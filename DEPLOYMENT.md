# Deploy IPKO.ai — Vercel + ipko.ai (Namecheap)

Laravel 10 + Vue 3 deploy në **Vercel** me domenin **ipko.ai**.  
SQLite **nuk** funksionon në Vercel (serverless) — përdorni **PostgreSQL** ose **MySQL** (Neon, PlanetScale, Vercel Postgres).

## 1. Database (obligative për prodhim)

Krijoni një databazë PostgreSQL (rekomandohet [Neon](https://neon.tech) ose Vercel Storage → Postgres).

Kopjoni `DATABASE_URL` (format: `postgresql://user:pass@host/db?sslmode=require`).

## 2. Vercel — projekt i ri

1. [vercel.com](https://vercel.com) → **Add New Project** → import `valon92/IP-KOSOVA-AI-B2B`
2. **Framework Preset:** Other
3. **Root Directory:** `.` (default)
4. Build/Install lexohen nga `vercel.json`

### Environment Variables (Vercel → Settings → Environment Variables)

| Key | Value |
|-----|--------|
| `APP_NAME` | `IPKO.ai` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Gjeneroni: `php artisan key:generate --show` |
| `APP_URL` | `https://ipko.ai` |
| `DB_CONNECTION` | `pgsql` |
| `DATABASE_URL` | *(connection string nga Neon/Vercel)* |
| `SESSION_DRIVER` | `database` |
| `SESSION_SECURE_COOKIE` | `true` |
| `CACHE_DRIVER` | `array` |
| `QUEUE_CONNECTION` | `sync` |
| `SANCTUM_STATEFUL_DOMAINS` | `ipko.ai,www.ipko.ai` |
| `IPKO_DEMO_API_KEY` | *(çelës i ri, i fortë)* |
| `IPKO_AUTO_VERIFY_BUSINESSES` | `true` |

Pas deploy-it të parë, ekzekutoni migrimet (nëse build script nuk i bën):

```bash
vercel env pull .env.vercel
php artisan migrate --force
php artisan db:seed --class=IndustrySeeder --force
php artisan db:seed --class=BusinessSeeder --force
php artisan db:seed --class=ClientSeeder --force
```

## 3. Namecheap — DNS për ipko.ai

Në **Namecheap → Domain List → ipko.ai → Advanced DNS**:

### Opsioni A — Rekordet Vercel (më i shpejti)

| Type | Host | Value |
|------|------|--------|
| `A` | `@` | `76.76.21.21` |
| `CNAME` | `www` | `cname.vercel-dns.com` |

### Opsioni B — Nameservers Vercel (rekomandohet)

Në Vercel: **Project → Settings → Domains** → shtoni `ipko.ai` dhe `www.ipko.ai`.  
Vercel jep nameservers — vendosini te Namecheap → **Custom DNS**.

## 4. Shtimi i domenit në Vercel

1. Project → **Settings** → **Domains**
2. Shtoni: `ipko.ai` dhe `www.ipko.ai`
3. Redirect `www` → apex (ose anasjelltas), sipas preferencës
4. Prisni SSL (Let's Encrypt) — zakonisht &lt; 5 min

## 5. CLI (opsionale)

```bash
npm i -g vercel
vercel login
vercel link
vercel --prod
```

## 6. Pas deploy-it

- **Login:** `https://ipko.ai/login`
- **Status:** `https://ipko.ai/status`
- **Tracker:** `https://ipko.ai/ipko-tracker.js` me `data-endpoint="https://ipko.ai/api/v1/track"`

## Kufizime Vercel + Laravel

- Pa databazë cloud, app **nuk** funksionon.
- `storage/` është `/tmp` — mos mbështetuni në file uploads lokale.
- Për workload të rëndë tracking, konsideroni më vonë Railway/Fly për API dhe Vercel vetëm frontend (opsionale).
