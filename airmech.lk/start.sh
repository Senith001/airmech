#!/usr/bin/env bash
#
# Start a local web server for the Air Mech website.
# Usage:  ./start.sh            (serves on http://localhost:4873)
#         ./start.sh 8080       (serves on a custom port)
#
set -euo pipefail

PORT="${1:-4873}"

# Serve from the folder this script lives in, regardless of where it is run from.
cd "$(dirname "$0")"

echo "Air Mech website running at:  http://localhost:${PORT}"
echo "Press Ctrl+C to stop."
echo

python3 -m http.server "${PORT}" --bind 127.0.0.1
