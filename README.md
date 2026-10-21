# Air Mech Engineering Works — WordPress Site

Dockerised WordPress site for Air Mech Engineering Works, built with WooCommerce,
Elementor, and a custom `coolair-child` theme matching the `airmech.lk` design.

## Stack

| Service | Port | URL |
|---------|------|-----|
| WordPress | 8080 | http://localhost:8080 |
| phpMyAdmin | 8081 | http://localhost:8081 |
| MySQL 8 | 3307 | localhost:3307 |

## Prerequisites

- Docker Desktop (running)
- Git
- macOS / Linux / WSL2

---

## First-time setup

### 1. Clone the repo

```bash
git clone <REPO_URL>
cd well-known
```

### 2. Create your local `.env`

```bash
cp .env.example .env
```

The default credentials in `.env.example` work as-is for local Docker development.
Do **not** commit `.env` — it is gitignored.

### 3. Start the containers

```bash
docker compose up -d --build
```

First build takes 2–3 minutes. MySQL needs ~30 seconds to initialise.

### 4. Import the database

```bash
./scripts/db-import.sh
```

This loads `backups/airmech-current.sql` into the local MySQL container.

### 5. Open the site

```bash
open http://localhost:8080        # WordPress front end
open http://localhost:8080/wp-admin  # Admin — credentials from team lead
open http://localhost:8081        # phpMyAdmin
```

---

## Daily collaboration workflow

### Before you start working

```bash
git pull
# If backups/airmech-current.sql changed:
./scripts/db-import.sh
```

### After making Elementor or WordPress admin changes

```bash
./scripts/db-export.sh
git add backups/airmech-current.sql
git commit -m "chore: update db export after [what you changed]"
git push
```

### After code-only changes (CSS, PHP, plugins)

```bash
git add -p   # stage specific changes
git commit -m "your message"
git push
```

### Conflict rule

> **One developer edits Elementor / WordPress admin at a time.**
> Code changes (CSS, PHP) can happen in parallel.
> Always export the DB before pushing if you touched the WordPress admin.

---

## Project structure

```
well-known/
├── airmech.lk/              Original HTML reference design
├── backups/
│   ├── airmech-current.sql  Latest full database export (import this on setup)
│   └── *.json               Elementor page backups
├── scripts/
│   ├── db-export.sh         Export DB → run before pushing Elementor changes
│   └── db-import.sh         Import DB → run after pulling someone else's changes
├── wp-content/
│   ├── themes/
│   │   ├── coolair/           Parent theme (do not edit)
│   │   └── coolair-child/     ⭐ All custom CSS and overrides go here
│   ├── plugins/             All installed plugins
│   └── uploads/             Media files (SVGs, product images)
├── docker-compose.yml
├── Dockerfile
├── .env.example           Copy to .env and fill in — never commit .env
└── uploads.ini
```

---

## Editing the header and footer

The header and footer are **not** part of the main pages. They are separate
Elementor templates:

| Template | Edit URL |
|----------|----------|
| Header | http://localhost:8080/wp-admin/post.php?post=3788&action=elementor |
| Footer | http://localhost:8080/wp-admin/post.php?post=923&action=elementor |

---

## Common commands

```bash
# Start
docker compose up -d

# Stop
docker compose down

# Rebuild after Dockerfile changes
docker compose up -d --build

# View logs
docker compose logs -f wordpress

# WP-CLI
docker compose exec wordpress bash -c 'wp <command> --allow-root'

# Full reset (destroys all data)
docker compose down -v
docker compose up -d --build
./scripts/db-import.sh
```

---

## Plugins installed

- **WooCommerce** — e-commerce
- **Elementor** — page builder (Free v4.x, Atomic editor)
- **RT Elements** — header/footer builder (bundled HFE fork)
- **All in One SEO** — SEO
- **WPForms Lite** — contact forms
- Do **not** activate `litespeed-cache` or `imunify-security` locally

---

## Notes

- WordPress admin credentials: ask the team lead (not stored in this repo)
- The `airmech.lk/` folder is the original static HTML design — treat it as the source of truth for design decisions
- All custom styling lives in `wp-content/themes/coolair-child/style.css`
- Elementor content is stored in the database — always export after editing
