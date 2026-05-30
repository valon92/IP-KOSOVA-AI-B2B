#!/usr/bin/env bash
# Vendos GitHub Actions secrets (Vercel token lexohet automatikisht nga Mac).
# Përdorimi:
#   1. gh auth login   (një herë)
#   2. bash scripts/setup-github-secrets.sh

set -euo pipefail

REPO="valon92/IP-KOSOVA-AI-B2B"
VERCEL_AUTH="${HOME}/Library/Application Support/com.vercel.cli/auth.json"

if ! gh auth status &>/dev/null; then
  echo "❌ Së pari përfundo: gh auth login"
  echo "   (GitHub.com → HTTPS → Yes → Login with web browser)"
  exit 1
fi

if [ -z "${VERCEL_TOKEN:-}" ] && [ -f "$VERCEL_AUTH" ]; then
  VERCEL_TOKEN=$(python3 -c "import json; print(json.load(open('$VERCEL_AUTH'))['token'])")
  echo "→ Përdor Vercel token nga CLI (auth.json)"
fi

if [ -z "${VERCEL_TOKEN:-}" ]; then
  echo "❌ Nuk u gjet VERCEL_TOKEN. Bëj: export VERCEL_TOKEN='...' ose vercel login"
  exit 1
fi

code=$(curl -s -o /dev/null -w "%{http_code}" -H "Authorization: Bearer $VERCEL_TOKEN" \
  "https://api.vercel.com/v2/teams/team_kwp91y9o8gmKeeZGGF9V2SMk")
if [ "$code" != "200" ]; then
  echo "❌ Tokeni nuk ka akses te team (HTTP $code). Krijo token të ri: vercel.com/account/tokens"
  exit 1
fi
echo "✓ Vercel token valid për team"

echo "→ Duke vendosur secrets në $REPO …"
gh secret set VERCEL_TOKEN --repo "$REPO" --body "$VERCEL_TOKEN"
gh secret set VERCEL_ORG_ID --repo "$REPO" --body "team_kwp91y9o8gmKeeZGGF9V2SMk"
gh secret set VERCEL_PROJECT_ID --repo "$REPO" --body "prj_pYy4u0KYTpIfA2qh9aFRnAIGSvwS"
gh secret set APP_KEY --repo "$REPO" --body "base64:f2mDqUcUp2yYAcMuQSR5JyD63odHKDZN3dmIX60pNSA="

echo "✓ Secrets u vendosën."
echo "→ https://github.com/$REPO/actions/workflows/vercel-deploy.yml → Run workflow"
