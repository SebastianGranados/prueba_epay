#!/usr/bin/env bash
set -e

echo "[start] Booting container..."

if [ ! -f "/var/www/html/vendor/autoload.php" ]; then
  if command -v composer >/dev/null 2>&1; then
    echo "[start] vendor/ missing. Running composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
  else
    echo "[start] WARNING: composer not found in runtime image. (Normal en prod)"
  fi
fi

if [ -n "${DB_HOST}" ] && [ -n "${DB_PORT}" ]; then
  echo "[start] Waiting for DB at ${DB_HOST}:${DB_PORT}..."
  for i in $(seq 1 30); do
    (echo > /dev/tcp/${DB_HOST}/${DB_PORT}) >/dev/null 2>&1 && break || sleep 1
    [ $i -eq 30 ] && echo "[start] DB wait timeout." || true
  done
fi

if [ -f "/var/www/html/artisan" ]; then
  echo "[start] Running migrations..."
  php artisan migrate --force || true
else
  echo "[start] No artisan found (ok si es Lumen sin artisan o micro imagen)."
fi

echo "[start] Starting services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf