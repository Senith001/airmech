#!/usr/bin/env bash
# =============================================================================
# db-import.sh — Import the latest database export into the local MySQL
# Usage: ./scripts/db-import.sh
#
# Run this after pulling if your collaborator updated backups/airmech-current.sql
# WARNING: This replaces your local database entirely.
# =============================================================================
set -euo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && cd .. && pwd)"
cd "$PROJECT_ROOT"

FILE="backups/airmech-current.sql"

if [ ! -f "$FILE" ]; then
  echo "Error: $FILE not found. Pull the latest changes first."
  exit 1
fi

echo "Importing $FILE into local MySQL ..."
echo "WARNING: This will overwrite your local database. Press Ctrl+C to cancel."
sleep 3

docker compose exec -T db mysql \
  -u wp_user -pwp_password \
  wellknown_db < "$FILE"

echo "Done. Flushing WordPress object cache ..."
docker compose exec wordpress bash -c \
  'command -v wp || (curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x /usr/local/bin/wp)' 2>/dev/null
docker compose exec -T wordpress bash -c \
  'wp cache flush --allow-root 2>/dev/null && echo "Cache flushed." || echo "Cache flush skipped."'

echo ""
echo "Import complete. Open http://localhost:8080 to verify."
