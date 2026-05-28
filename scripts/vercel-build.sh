#!/usr/bin/env bash
set -euo pipefail

echo "→ Installing PHP dependencies…"
if command -v composer >/dev/null 2>&1; then
    composer install --no-dev --optimize-autoloader --no-interaction
else
    curl -sS https://getcomposer.org/installer | php -- --quiet
    php composer.phar install --no-dev --optimize-autoloader --no-interaction
    rm -f composer.phar
fi

echo "→ Building frontend assets…"
npm run build

if [ -z "${APP_KEY:-}" ]; then
    echo "⚠ APP_KEY not set — skipping artisan cache"
    exit 0
fi

echo "→ Caching Laravel…"
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ -n "${DATABASE_URL:-}" ]; then
    echo "→ Running migrations…"
    php artisan migrate --force --no-interaction
fi

echo "✓ Vercel build complete"
