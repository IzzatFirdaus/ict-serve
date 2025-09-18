#!/usr/bin/env bash
# Create PRs for topic branches into feature/loan-module-refactor using GITHUB_TOKEN from environment.
# Usage: ensure $GITHUB_TOKEN is set in your environment, then run this script locally.

set -euo pipefail

if [ -z "${GITHUB_TOKEN:-}" ]; then
  echo "Please set GITHUB_TOKEN in your environment before running this script."
  exit 1
fi

REPO_OWNER="IzzatFirdaus"
REPO_NAME="ict-serve"
BASE_BRANCH="feature/loan-module-refactor"

create_pr() {
  local head="$1"
  local title="$2"
  local body="$3"

  echo "Creating PR: $title ($head -> $BASE_BRANCH)"

  curl -s -X POST \
    -H "Authorization: token ${GITHUB_TOKEN}" \
    -H "Accept: application/vnd.github+json" \
    https://api.github.com/repos/${REPO_OWNER}/${REPO_NAME}/pulls \
    -d "{\"title\":\"${title}\",\"head\":\"${head}\",\"base\":\"${BASE_BRANCH}\",\"body\":\"${body}\"}" \
    | jq -r '.html_url'
}

create_pr "chore/deps-livewire-migration" "Update dependencies and build configuration for Livewire migration" "Updates composer and frontend build dependencies to support migration to Livewire. Includes Vite config tweaks."
create_pr "feat/frontend-livewire" "Update frontend assets for Livewire migration and remove unused React file" "Replace React entry points with Livewire-compatible JS and CSS assets. Removes unused resources/js/app.jsx."
create_pr "feat/livewire-components" "Add new controllers, middleware, requests, resources, and Livewire components" "Adds API controllers, form requests, resources, models, and server-side Livewire components for the loan and helpdesk modules."
create_pr "chore/layout-ui" "Update main layout for Livewire and UI improvements" "Updates resources/views/layouts/app.blade.php for Livewire integration and improves accessibility and layout."
create_pr "chore/routing-bootstrap" "Update routing and bootstrap for new modules and Livewire integration" "Adds routes for new modules and updates bootstrap to register any required providers/middleware."
create_pr "refactor/notification-service" "Refactor NotificationService for new loan and helpdesk workflows" "Refactors notification delivery to support new workflows, channels, and Livewire notifications."
create_pr "docs/react-to-livewire" "Add migration documentation from React to Livewire" "Adds REACT_TO_LIVEWIRE_MIGRATION.md documenting the migration steps and rationale."
create_pr "chore/phpinsights" "Add PHP Insights configuration file" "Adds phpinsights.php to configure PHP Insights for the repository."

echo "Done."
