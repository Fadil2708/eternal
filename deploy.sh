#!/bin/bash

set -e

PROJECT_DIR="/opt/docker/eternal"

echo "========================================"
echo "      ETERNAL PRODUCTION DEPLOY"
echo "========================================"

cd "$PROJECT_DIR"

echo "[1/6] Checking Git status..."

git status

echo "[2/6] Pulling latest code..."

git pull origin main

echo "[3/6] Rebuilding application..."

docker compose build app

echo "[4/6] Restarting application..."

docker compose up -d app

echo "[5/6] Waiting for application..."

sleep 10

echo "[6/6] Running Laravel commands..."

docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan optimize:clear
docker compose exec -T app php artisan optimize

echo "========================================"
echo "       DEPLOYMENT SUCCESSFUL"
echo "========================================"

docker compose ps
