#!/usr/bin/env bash
#
# deploy.sh — Deploy aman aplikasi eternal (TANPA kehilangan data).
#
# Alur:
#   1. Backup database otomatis (wajib, gagal → deploy dibatalkan)
#   2. Catat jumlah data sebelum deploy
#   3. docker compose up -d --build
#   4. Jalankan migrasi (migrate --force)
#   5. Verifikasi: jika jumlah data drop drastis dari sebelum deploy → ALARM & rollback saran
#
# Cara pakai:
#   ./deploy/deploy.sh
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(dirname "$SCRIPT_DIR")"
BACKUP_DIR="${PROJECT_DIR}/backup"
MYSQL_CONTAINER="eternal-mysql"
APP_CONTAINER="eternal-app"
MYSQL_USER="root"
MYSQL_PASSWORD="rootpassword2026"
DB_NAME="eternal_db"

cd "${PROJECT_DIR}"

# ─── 1. Backup ───────────────────────────────────────────
echo "════════════════════════════════════════════════════"
echo " 1/5 Backup database sebelum deploy…"
echo "════════════════════════════════════════════════════"
"${SCRIPT_DIR}/backup.sh" || { echo "[ERROR] Backup gagal — deploy DIBATALKAN. Data aman." >&2; exit 1; }

# ─── 2. Catat jumlah data sebelum deploy ─────────────────
count_before() {
    docker exec "${MYSQL_CONTAINER}" mysql -u"${MYSQL_USER}" -p"${MYSQL_PASSWORD}" \
        "${DB_NAME}" -N -e "SELECT COUNT(*) FROM users" 2>/dev/null | grep -Eo '[0-9]+' | head -1 || echo "0"
}
USERS_BEFORE="$(count_before)"
echo "     Data sebelum deploy: ${USERS_BEFORE} user"

# ─── 3. Build & up ───────────────────────────────────────
echo ""
echo "════════════════════════════════════════════════════"
echo " 2/5 Build image & up container…"
echo "════════════════════════════════════════════════════"
docker compose up -d --build

# ─── 4. Migrasi ──────────────────────────────────────────
echo ""
echo "════════════════════════════════════════════════════"
echo " 3/5 Menjalankan migrasi (migrate --force)…"
echo "════════════════════════════════════════════════════"
docker exec "${APP_CONTAINER}" php artisan migrate --force

# ─── 5. Verifikasi ───────────────────────────────────────
echo ""
echo "════════════════════════════════════════════════════"
echo " 4/5 Verifikasi data…"
echo "════════════════════════════════════════════════════"
USERS_AFTER="$(count_before)"
echo "     Data sesudah deploy: ${USERS_AFTER} user"

if [[ "${USERS_BEFORE}" =~ ^[0-9]+$ && "${USERS_BEFORE}" -gt 0 && "${USERS_AFTER}" -eq 0 ]]; then
    echo ""
    echo "⚠️  ALARM: Database menjadi KOSONG setelah deploy (sebelumnya ${USERS_BEFORE} user)!"
    echo "    Ada kemungkinan volume DB baru dibuat (proyek/volume salah)."
    echo "    → Pemulihan: gunakan backup terakhir di ${BACKUP_DIR}"
    echo "      zcat backup/eternal_TERBARU.sql.gz | docker exec -i ${MYSQL_CONTAINER} mysql -u${MYSQL_USER} -p\"${MYSQL_PASSWORD}\""
    echo "    JANGAN jalankan: docker compose down -v, migrate:fresh, db:wipe"
    exit 1
fi

# ─── 5. Status container ─────────────────────────────────
echo ""
echo "════════════════════════════════════════════════════"
echo " 5/5 Status container…"
echo "════════════════════════════════════════════════════"
docker compose ps

echo ""
echo "✓ Deploy selesai. Data aman (${USERS_AFTER} user)."
echo "  Backup terbaru: $(ls -1t ${BACKUP_DIR}/eternal_*.sql.gz 2>/dev/null | head -1 || echo '(belum ada)')"