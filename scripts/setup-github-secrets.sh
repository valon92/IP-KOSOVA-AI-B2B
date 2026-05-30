#!/usr/bin/env bash
# Vendos GitHub Actions secrets me Vercel token të vlefshëm.
# Përdorimi: gh auth login  →  bash scripts/setup-github-secrets.sh

set -euo pipefail

REPO="valon92/IP-KOSOVA-AI-B2B"
VERCEL_AUTH="${HOME}/Library/Application Support/com.vercel.cli/auth.json"

if ! gh auth status &>/dev/null; then
  echo "❌ Së pari: gh auth login  (përfundo autorizimin në browser)"
  exit 1
fi

if [ ! -f "$VERCEL_AUTH" ]; then
  echo "❌ Nuk u gjet Vercel CLI. Ekzekuto: npx vercel login"
  exit 1
fi

echo "→ Krijon token të ri për GitHub Actions (Full Account)…"
EXISTING=$(python3 -c "import json; print(json.load(open('$VERCEL_AUTH'))['token'])")
RESP=$(curl -s -X POST "https://api.vercel.com/v3/user/tokens" \
  -H "Authorization: Bearer $EXISTING" \
  -H "Content-Type: application/json" \
  -d "{\"name\":\"github-actions-$(date +%Y%m%d)\"}")

VERCEL_TOKEN=$(echo "$RESP" | python3 -c "import json,sys; d=json.load(sys.stdin); print(d.get('bearerToken') or d.get('token') or '')")

if [ -z "$VERCEL_TOKEN" ]; then
  echo "❌ Nuk u krijua token. Përgjigja Vercel:"
  echo "$RESP"
  exit 1
fi

code=$(curl -s -o /dev/null -w "%{http_code}" -H "Authorization: Bearer $VERCEL_TOKEN" \
  "https://api.vercel.com/v2/teams/team_kwp91y9o8gmKeeZGGF9V2SMk")
if [ "$code" != "200" ]; then
  echo "❌ Token i ri nuk ka akses te team (HTTP $code)"
  exit 1
fi
echo "✓ Token i ri valid (team API 200)"

echo "→ Duke vendosur secrets në GitHub…"
gh secret set VERCEL_TOKEN --repo "$REPO" --body "$VERCEL_TOKEN"
gh secret set VERCEL_ORG_ID --repo "$REPO" --body "team_kwp91y9o8gmKeeZGGF9V2SMk"
gh secret set VERCEL_PROJECT_ID --repo "$REPO" --body "prj_pYy4u0KYTpIfA2qh9aFRnAIGSvwS"
gh secret set APP_KEY --repo "$REPO" --body "base64:f2mDqUcUp2yYAcMuQSR5JyD63odHKDZN3dmIX60pNSA="

echo ""
echo "✓ U vendosën të gjitha secrets."
echo "→ https://github.com/$REPO/actions/workflows/vercel-deploy.yml"
echo "  Kliko: Run workflow"
