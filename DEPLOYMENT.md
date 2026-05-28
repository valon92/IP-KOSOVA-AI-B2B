# Deploy IPKO.ai — Vercel + ipko.ai (Namecheap)

Laravel 10 + Vue 3. **SQLite nuk funksionon** në Vercel — përdorni **PostgreSQL** (`DATABASE_URL`).

## Rekomandim i shpejtë

| Platformë | Për Laravel | ipko.ai |
|-----------|-------------|---------|
| **Render** (`render.yaml`) | ✅ PHP + Composer në build | Custom domain lehtë |
| **Vercel** | ⚠️ Via GitHub Actions (vendor i paracaktuar) | ✅ DNS Namecheap |

---

## A) Vercel + GitHub Actions (automatik)

Çdo `git push` në `main` → deploy (pas konfigurimit të secrets).

### 1. Secrets në GitHub

Repo → **Settings → Secrets → Actions**:

| Secret | Vlera |
|--------|--------|
| `VERCEL_TOKEN` | [vercel.com/account/tokens](https://vercel.com/account/tokens) |
| `VERCEL_ORG_ID` | `team_kwp91y9o8gmKeeZGGF9V2SMk` |
| `VERCEL_PROJECT_ID` | `prj_pYy4u0KYTpIfA2qh9aFRnAIGSvwS` |
| `APP_KEY` | `base64:f2mDqUcUp2yYAcMuQSR5JyD63odHKDZN3dmIX60pNSA=` *(ose gjeneroni të ri)* |

### 2. Variablat në Vercel (tashmë të vendosura për projektin `ipko-ai`)

Shtoni edhe **`DATABASE_URL`** nga [Neon](https://neon.tech) ose Vercel Postgres:

```
DB_CONNECTION=pgsql
DATABASE_URL=postgresql://...
```

Të tjerat: `APP_URL=https://ipko.ai`, `SESSION_DRIVER=database`, `SANCTUM_STATEFUL_DOMAINS=ipko.ai,www.ipko.ai`

### 3. Namecheap DNS → Vercel

**Advanced DNS** për `ipko.ai`:

| Type | Host | Value |
|------|------|--------|
| `A` | `@` | `76.76.21.21` |
| `CNAME` | `www` | `cname.vercel-dns.com` |

Pastaj në Vercel → **ipko-ai → Settings → Domains** → shtoni `ipko.ai` dhe `www.ipko.ai`.

### 4. Migrimet (një herë, pas DATABASE_URL)

```bash
# Lokalisht me DATABASE_URL në .env
php artisan migrate --force
php artisan db:seed --force
```

---

## B) Render (më e thjeshtë për Laravel)

1. [dashboard.render.com](https://dashboard.render.com) → **New → Blueprint** → lidhni repo GitHub
2. Zgjidhni `render.yaml` (krijon web + Postgres)
3. **Settings → Custom Domains** → `ipko.ai`
4. Namecheap: CNAME `@` ose `www` → adresa që jep Render *(ose përdorni nameservers Render)*

---

## C) Vercel CLI manual

```bash
npx vercel@latest login
npx vercel@latest link
# Vendosni DATABASE_URL në Vercel dashboard së pari
git push origin main   # trigger GitHub Action
```

---

## Pas deploy-it

- Login: `https://ipko.ai/login` (`demo@ipko.ai` / `ipko-demo-2026` pas seed)
- Status: `https://ipko.ai/status`
- Tracker: `data-endpoint="https://ipko.ai/api/v1/track"`

Projekti Vercel: [vercel.com/valon-sylejmanis-projects/ipko-ai](https://vercel.com/valon-sylejmanis-projects/ipko-ai)
