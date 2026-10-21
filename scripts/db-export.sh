#!/usr/bin/env bash
# =============================================================================
# db-export.sh — Export the WordPress database to backups/
# Usage: ./scripts/db-export.sh
#
# Run this before pushing if you made any Elementor / WordPress admin changes.
# Commit the resulting file so your collaborator can import it.
# =============================================================================
set -euo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && cd .. && pwd)"
cd "$PROJECT_ROOT"

FILE="backups/airmech-current.sql"

echo "Exporting database to $FILE ..."

docker compose exec -T db mysqldump \
  -u wp_user -pwp_password \
  --single-transaction \
  --routines \
  --triggers \
  wellknown_db > "$FILE"

echo "Done. $(du -sh "$FILE" | cut -f1) written to $FILE"
echo ""
echo "Next steps:"
echo "  git add $FILE"
echo "  git commit -m 'chore: update database export'"
echo "  git push"
