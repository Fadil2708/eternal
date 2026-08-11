#!/usr/bin/env bash
#
# backup.sh — Backup database MySQL sebelum deploy.
#
# Cara pakai:
#   ./deploy/backup.sh                # backup lengkap semua database
#   ./deploy/backup.sh --keep 14      # simpan 14 backup terakhir (default: 7)
#
# Backup disimpan di: backup/eternal_YYYYMMDD_HHMMSS.sql.gz
# Rotasi otomatis: hanya N backup terakhir yang dipertahankan.
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(dirname "$SCRIPT_DIR")"
BACKUP_DIR="${PROJECT_DIR}/backup"
KEEP="${1:-7}"

if [[ "${KEEP}" =~ ^--keep ]]; then
    KEEP="${2:-7}"
fi

MYSQL_CONTAINER="eternal-mysql"
MYSQL_USER="root"
MYSQL_PASSWORD="rootpassword2026"

# Cek container MySQL berjalan
if ! docker ps --format '{{.Names}}' | grep -qx "${MYSQL_CONTAINER}"; then
    echo "[ERROR] Container '${MYSQL_CONTAINER}' tidak berjalan. Pastikan aplikasi sudah up terlebih dahulu." >&2
    exit 1
fi

mkdir -p "${BACKUP_DIR}"
STAMP="$(date +%Y%m%d_%H%M%S)"
FILENAME="eternal_${STAMP}.sql.gz"
TARGET="${BACKUP_DIR}/${FILENAME}"

echo "[1/2] Membuat backup database → ${TARGET}"
docker exec "${MYSQL_CONTAINER}" sh -c \
    "mysqldump -u${MYSQL_USER} -p\"${MYSQL_PASSWORD}\" --all-databases --single-transaction --routines --triggers | gzip" \
    > "${TARGET}"

BACKUP_SIZE="$(du -h "${TARGET}" | cut -f1)"

# Verifikasi hasil: file gzip harus valid
if ! gzip -t "${TARGET}" 2>/dev/null; then
    echo "[ERROR] Backup gagal: file tidak valid." >&2
    rm -f "${TARGET}"
    exit 1
fi

if [[ "${BACKUP_SIZE}" == "0" || "${BACKUP_SIZE}" == "0K" || "${BACKUP_SIZE}" == "0B" ]]; then
    echo "[ERROR] Backup berukuran 0 — dibatalkan." >&2
    rm -f "${TARGET}"
    exit 1
fi

echo "       ✓ ${BACKUP_SIZE}"
echo "[2/2] Rotasi: simpan ${KEEP} backup terakhir"
ls -1t "${BACKUP_DIR}"/eternal_*.sql.gz 2>/dev/null | tail -n +$((KEEP + 1)) | while read -r old; do
    echo "       hapus ${old}"
    rm -f "${old}"
done

echo ""
echo "✓ Backup selesai: ${TARGET} (${BACKUP_SIZE})"