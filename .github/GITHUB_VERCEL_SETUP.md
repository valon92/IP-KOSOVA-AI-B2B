# GitHub + Vercel — IPKO.ai (akses global)

Faqja publike: **https://ipko.ai/login** — funksionon nga çdo Wi‑Fi / mobile data kur shkruhet **`https://`** (jo `htpps`).

## 1. Lidh GitHub me Vercel (një herë)

1. Hap [Vercel → ipko-ai → Settings → Git](https://vercel.com/valon-sylejmanis-projects/ipko-ai/settings/git)
2. **Connect Git Repository** → GitHub → `valon92/IP-KOSOVA-AI-B2B`
3. Branch production: **`main`**
4. Nëse CLI thotë "Failed to connect" → autorizo **Vercel GitHub App** për org/user `valon92` në GitHub → Settings → Applications

> Deploy nga Vercel Git vetëm bën `npm` — **Laravel kërkon `vendor/`**. Përdor **GitHub Actions** (seksioni 2) si deploy kryesor.

## 2. Secrets në GitHub (obligative për auto-deploy)

Repo: [github.com/valon92/IP-KOSOVA-AI-B2B/settings/secrets/actions](https://github.com/valon92/IP-KOSOVA-AI-B2B/settings/secrets/actions)

| Secret | Vlera |
|--------|--------|
| `VERCEL_TOKEN` | [vercel.com/account/tokens](https://vercel.com/account/tokens) → Create |
| `VERCEL_ORG_ID` | `team_kwp91y9o8gmKeeZGGF9V2SMk` |
| `VERCEL_PROJECT_ID` | `prj_pYy4u0KYTpIfA2qh9aFRnAIGSvwS` |
| `APP_KEY` | `base64:f2mDqUcUp2yYAcMuQSR5JyD63odHKDZN3dmIX60pNSA=` |

Pas ruajtjes: **Actions → Deploy to Vercel → Run workflow** ose `git push` në `main`.

**Nëse workflow dështon në ~30s:** shiko hapin *Validate GitHub secrets* — zakonisht mungon `VERCEL_TOKEN`.

## 3. Vercel — variabla (tashmë të vendosura)

- `DATABASE_URL` (Neon)
- `SESSION_DOMAIN=.ipko.ai`
- `APP_URL=https://ipko.ai`
- `SANCTUM_STATEFUL_DOMAINS=ipko.ai,www.ipko.ai`

Kontrollo: [Vercel → ipko-ai → Settings → Environment Variables](https://vercel.com/valon-sylejmanis-projects/ipko-ai/settings/environment-variables)

## 4. Namecheap DNS

| Type | Host | Value |
|------|------|--------|
| A | `@` | `76.76.21.21` |
| CNAME | `www` | `cname.vercel-dns.com` |

Gmail (MX) **nuk pengon** faqen.

## 5. Test global

- [https://ipko.ai/login](https://ipko.ai/login)
- [dnschecker.org/#A/ipko.ai](https://dnschecker.org/#A/ipko.ai) → `76.76.21.21`

Login demo: `demo@ipko.ai` / `ipko-demo-2026`
