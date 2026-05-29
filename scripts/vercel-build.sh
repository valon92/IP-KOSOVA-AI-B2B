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

# Artisan cache requires PHP (not on Vercel Node build image); vercel-php runs composer at deploy time.

echo "✓ Build complete"
