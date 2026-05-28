#!/usr/bin/env bash
set -euo pipefail

echo "→ Building frontend assets…"
npm run build

if [ -z "${APP_KEY:-}" ]; then
    echo "⚠ APP_KEY not set during build — skipping artisan cache (set in Vercel env)"
    exit 0
fi

echo "→ Caching Laravel config/routes/views…"
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ -n "${DATABASE_URL:-}" ]; then
    echo "→ Running migrations…"
    php artisan migrate --force --no-interaction
fi

echo "✓ Vercel build complete"
