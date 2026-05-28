#!/usr/bin/env bash
# Vercel build step — Composer runs in GitHub Actions before deploy.
# Local / preview without vendor: only frontend build.
set -euo pipefail

if [ -f vendor/autoload.php ]; then
    echo "→ Vendor present (CI prebuilt)"
else
    echo "⚠ vendor/ missing — run composer install locally or use GitHub Actions deploy"
fi

echo "→ Building frontend assets…"
npm run build

if [ -z "${APP_KEY:-}" ]; then
    echo "⚠ APP_KEY not set — skipping artisan cache"
    exit 0
fi

if [ -f vendor/autoload.php ]; then
    echo "→ Caching Laravel…"
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "✓ Build complete"
