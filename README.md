# IP-KOSOVA-AI-B2B

**IPKO.ai** — B2B IP Reverse Lookup & Geolocation Analytics (MVP)

B2B visitor intelligence platform for the Kosovo/Balkan market. Identifies corporate visitors via IP range enrichment, scores leads with an AI-style scoring engine, and surfaces insights in a Vue 3 + Tailwind dashboard.

## Stack

- **Backend:** Laravel 10 (PHP 8.2+), REST API
- **Frontend:** Vue 3 (Composition API, `<script setup>`), Vite, Tailwind CSS
- **Database:** SQLite (default) or MySQL/PostgreSQL

## Quick Start

```bash
# Install PHP dependencies (already done if cloned)
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# SQLite (default) — create database file
touch database/database.sqlite

# Migrate & seed demo data
php artisan migrate --seed

# Frontend
npm install
npm run dev

# Backend (separate terminal)
php artisan serve
```

Open **http://127.0.0.1:8000/dashboard**

Demo API key: `ipko_demo_key_for_mvp_development` (set in `.env` as `IPKO_DEMO_API_KEY`)

## Tracking Snippet

Embed on any client website:

```html
<script
  src="https://your-domain.com/ipko-tracker.js"
  data-api-key="ipko_demo_key_for_mvp_development"
  data-endpoint="https://your-domain.com/api/v1/track"
  async
></script>
```

The script captures URL, referrer, device type, screen resolution, and sends async POSTs to `/api/v1/track`. The server resolves the visitor IP via `request()->ip()`.

## API Endpoints

| Method | Endpoint | Auth |
|--------|----------|------|
| POST | `/api/v1/track` | `X-Api-Key` header or `api_key` body |
| GET | `/api/v1/dashboard/metrics` | `X-Api-Key` |
| GET | `/api/v1/dashboard/live-feed` | `X-Api-Key` |
| GET | `/api/v1/dashboard/companies` | `X-Api-Key` |

### Track payload

```json
{
  "url": "https://example.com/pricing",
  "referrer": "https://google.com",
  "session_id": "ipko_...",
  "device_type": "desktop",
  "screen_resolution": "1920x1080",
  "duration": 0,
  "event": "pageview"
}
```

Ping/beacon events use `"event": "ping"` to accumulate time-on-page.

## Lead Scoring

Scores (0–100) combine:

- **Time on site:** up to 40 points (5 pts/minute)
- **High-value pages** (`/pricing`, `/checkout`, `/contact`, etc.): +30
- **Return visits** from same corporate IP within 7 days: +8 to +25

Status: **hot** (>75), **medium** (40–75), **cold** (<40)

## Kosovo Corporate IP Directory

Seeded companies include NLB Banka HQ, Albi Mall, Ministria e Financave, Balfin Group, IPKO Telecommunications, and more. Local development maps `127.0.0.x` to **IPKO Demo Corp**.

## Production Notes

- Switch `DB_CONNECTION` to `pgsql` or `mysql` in `.env`
- Run `php artisan config:cache` and `npm run build`
- Serve `public/ipko-tracker.js` via CDN for lowest latency
- Place app behind a reverse proxy and configure `TrustProxies` for accurate client IPs

## License

Proprietary — IPKO.ai MVP
