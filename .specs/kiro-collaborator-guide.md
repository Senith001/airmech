# Kiro AI Collaborator Guide
# Air Mech Engineering Works — WordPress Site

This document is written for Kiro AI assistants working on this project alongside
a human developer. Read it fully before taking any action on the codebase.

---

## Project Overview

This is a **Dockerised WordPress site** for Air Mech Engineering Works, a Sri
Lanka-based HVAC business. The site sells and promotes the **Macma** brand of
inverter air conditioners.

| Detail | Value |
|--------|-------|
| WordPress URL | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| MySQL port | localhost:3307 |
| PHP version | 8.3 (Apache) |
| MySQL version | 8.0 |
| WordPress | 6.7 |
| Theme | `coolair` parent + `coolair-child` (active) |
| Page builder | Elementor Free v4.3.5 (Atomic editor) |
| E-commerce | WooCommerce 11.x |
| Header/footer builder | RT Elements (bundled HFE fork) |

---

## First-Time Setup for the AI Session

Before starting any task, verify the environment is running:

```bash
# 1. Start containers (if not already running)
docker compose up -d

# 2. Wait for MySQL to be healthy (~30 seconds)
docker compose ps

# 3. Verify WordPress is responding
curl -s -o /dev/null -w '%{http_code}' http://localhost:8080
# Expected: 200

# 4. Import the database if working fresh
./scripts/db-import.sh
```

If containers are already running and the site returns 200, skip to your task.

---

## Repository Structure

```
well-known/                        ← project root (also WordPress webroot)
├── airmech.lk/                   ← ORIGINAL HTML design — source of truth
│   ├── index.html                 ← Homepage reference
│   ├── css/styles.css             ← Reference CSS (design tokens, layouts)
│   ├── js/layout.js               ← Header/footer structure
│   ├── js/products.js             ← Product catalogue data
│   └── assets/img/                ← Reference SVG assets
├── backups/
│   ├── airmech-current.sql        ← Full DB export (import on setup)
│   └── *.json                     ← Elementor page data snapshots
├── scripts/
│   ├── db-export.sh               ← Export DB before pushing
│   └── db-import.sh               ← Import DB after pulling
├── wp-content/
│   ├── themes/
│   │   ├── coolair/               ← Parent theme — DO NOT EDIT
│   │   └── coolair-child/         ← ⭐ ALL custom CSS goes here
│   │       └── style.css          ← Primary custom stylesheet
│   ├── plugins/                   ← All installed plugins
│   └── uploads/                   ← Media: SVGs, product images
├── docker-compose.yml
├── Dockerfile
├── .env.example                   ← Copy to .env — never commit .env
└── uploads.ini
```

---

## Design Source of Truth

The `airmech.lk/` folder contains the **original static HTML design**. Always
consult it before making any visual decision:

- **Layout, spacing, colours, typography** → `airmech.lk/css/styles.css`
- **Homepage structure** → `airmech.lk/index.html`
- **Header and footer content** → `airmech.lk/js/layout.js`
- **Product data** → `airmech.lk/js/products.js`
- **SVG assets** → `airmech.lk/assets/img/products/`

**Design tokens** (from `styles.css`):

| Token | Value | Use |
|-------|-------|-----|
| Navy | `#0C2340` | Hero, dark sections, footer |
| Blue | `#0A6CD6` | Primary CTA, links |
| Blue hover | `#0858B0` | Button hover |
| Cyan | `#46CBF2` | Accent, eyebrow in dark sections |
| Ink | `#0F1B2A` | Body text |
| Muted | `#546577` | Secondary text |
| Surface | `#F4F7FA` | Light grey section background |
| On-dark | `#F2F6FA` | Text on navy background |
| On-dark muted | `#B3C3D5` | Secondary text on navy |
| Line | `#DFE5EC` | Borders, dividers |
| Radius | `10px` | Card border radius |
| Radius small | `6px` | Button border radius |

**Fonts**: `Manrope` (headings, weight 600/700/800) + `Inter` (body, weight 400/500/600)

---

## WordPress Architecture

### Page builder: Elementor v4 Atomic

This site uses **Elementor v4 Atomic widgets**, NOT the legacy section/column system.

Key differences from legacy Elementor:
- Containers are `e-div-block` and `e-flexbox` (not `section`/`column`)
- Widget types: `e-heading`, `e-paragraph`, `e-button`, `e-image`
- CSS classes stored in `settings.classes.value` as a plain string array
- Global class IDs follow the pattern `g-XXXXXXX`
- Per-page CSS is generated at `wp-content/uploads/elementor/css/global-{POST_ID}-frontend-desktop.css`

### Elementor data format

All page content is stored in `wp_postmeta` under the key `_elementor_data` as JSON.
Reading and writing it:

```bash
# Read
docker compose exec -T wordpress bash -c \
  'wp post meta get {POST_ID} _elementor_data --allow-root'

# Write (use a file to avoid shell escaping issues)
docker cp /path/to/data.json well-known-wordpress-1:/tmp/data.json
docker compose exec -T wordpress bash -c \
  'wp post meta update {POST_ID} _elementor_data "$(cat /tmp/data.json)" --format=json --allow-root'
```

After any DB write, always flush the Elementor CSS cache:

```bash
docker compose exec -T wordpress bash -c \
  'wp eval "\\Elementor\\Plugin::$instance->files_manager->clear_cache();" --allow-root'
docker compose exec -T wordpress bash -c 'wp cache flush --allow-root'
```

### Key post IDs

| Post | ID | Edit URL |
|------|----|----------|
| Homepage One | 3954 | /wp-admin/post.php?post=3954&action=elementor |
| Header template | 3788 | /wp-admin/post.php?post=3788&action=elementor |
| Footer template | 923 | /wp-admin/post.php?post=923&action=elementor |
| WooCommerce Shop | 9 | /shop/ |

### Header and footer

Header (3788) and footer (923) are **`elementor-hf` post type** templates rendered
by the RT Elements plugin (HFE fork). They are NOT part of any page — editing a
page in Elementor does NOT edit the header or footer. Edit them directly at their
own post edit URLs above.

Critical meta keys that must be preserved on these posts:
- Header: `ehf_template_type = type_header`, `header-position = on`
- Footer: `ehf_template_type = type_footer`
- Both: `ehf_target_include_locations = basic-global` (entire site)

### Child theme CSS

All custom CSS lives in `wp-content/themes/coolair-child/style.css`. It is ~2,400
lines. Key selectors use `am-*` class names applied via Elementor's CSS Classes
field:

| Class | Purpose |
|-------|---------|
| `am-hero` | Hero section root |
| `am-section` | Standard white section |
| `am-section-alt` | Light grey section (`#F4F7FA`) |
| `am-section-dark` | Dark navy section (`#0C2340`) |
| `am-container` | Max-width 1264px centred container |
| `am-why-macma` | Why Macma section |
| `am-team` | One Team section |
| `am-steps` | Step cards grid |
| `am-step` | Individual step card |
| `am-product-grid-native` | 3-col product card grid |
| `am-product-card` | Individual product card |
| `am-cta-band` | Rounded CTA box |
| `am-site-header` | Sticky header bar |
| `am-site-footer` | Footer root |

### WooCommerce

WooCommerce is installed and has real products. **Never modify, delete, or reset
WooCommerce products, orders, or settings** unless explicitly asked.

The WooCommerce shop is at `/shop/` (page ID 9). Cart, checkout, and my-account
pages exist and work. Product images live in `wp-content/uploads/`.

---

## WP-CLI Reference

WP-CLI is not pre-installed. Install it on first use per session:

```bash
docker compose exec -T wordpress bash -c \
  'command -v wp || (curl -fsSL -o /usr/local/bin/wp \
  https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
  && chmod +x /usr/local/bin/wp)'
```

Common commands:

```bash
# Get post meta
wp post meta get {POST_ID} {META_KEY} --allow-root

# Update post meta (from file)
wp post meta update {POST_ID} {META_KEY} "$(cat /tmp/file.json)" --format=json --allow-root

# Flush Elementor CSS cache
wp eval "\\Elementor\\Plugin::$instance->files_manager->clear_cache();" --allow-root

# Flush object cache
wp cache flush --allow-root

# List pages
wp post list --post_type=page --fields=ID,post_title,post_name --allow-root

# Get option
wp option get {OPTION_NAME} --allow-root

# Run PHP
wp eval '{PHP CODE}' --allow-root
```

---

## Playwright (Visual Verification)

Playwright is available at `/tmp/node_modules/playwright` if previously installed.
Install if needed:

```bash
cd /tmp && npm install playwright@latest 2>/dev/null | tail -3
```

Standard screenshot pattern:

```javascript
const { chromium } = require('/tmp/node_modules/playwright');
(async () => {
  const browser = await chromium.launch();
  for (const [name, w, h] of [['desktop',1280,900],['mobile',390,844]]) {
    const ctx = await browser.newContext({ viewport: { width: w, height: h } });
    const page = await ctx.newPage();
    await page.goto('http://localhost:8080', { waitUntil: 'networkidle', timeout: 30000 });
    await page.waitForTimeout(2000);
    await page.screenshot({ path: `/tmp/${name}.png`, fullPage: true });
    await ctx.close();
  }
  await browser.close();
})();
```

Always take screenshots at both `1280x900` (desktop) and `390x844` (mobile) to
verify responsive layouts.

---

## Collaboration Rules

### The golden rule

> **One developer (or AI session) edits Elementor / WordPress admin at a time.**
> Code changes (CSS, PHP) can happen in parallel on separate branches.

### Before starting any Elementor or DB work

```bash
git pull
git log --oneline -3   # check what the other dev last pushed
# If backups/airmech-current.sql was updated:
./scripts/db-import.sh
```

### After any Elementor or WordPress admin change

```bash
./scripts/db-export.sh
git add backups/airmech-current.sql
git commit -m "chore: update db after [description]"
git push
```

### For CSS / PHP / code-only changes

```bash
git add -p
git commit -m "feat/fix/chore: [description]"
git push
```

### Never do these

- Do NOT commit `.env` or `wp-config.php`
- Do NOT edit the `coolair` parent theme (only `coolair-child`)
- Do NOT run `docker compose down -v` (destroys the database volume)
- Do NOT activate `litespeed-cache` or `imunify-security` locally
- Do NOT delete WooCommerce products, orders, or customers
- Do NOT change the WordPress Application Password
- Do NOT `git push --force` to main

---

## Elementor MCP (if configured)

The Elementor MCP server may be configured in `~/.kiro/settings/mcp.json`.
Before using MCP tools, verify the connection:

```json
{
  "mcpServers": {
    "air-mech-engineering-works-elementor": {
      "type": "http",
      "url": "http://localhost:8080/wp-json/elementor/mcp/",
      "headers": { "Authorization": "Basic <base64 user:app-password>" }
    }
  }
}
```

The Application Password is stored in `~/.kiro/settings/mcp.json` — do not print
or log it. The MCP server requires Elementor Atomic Editor to be activated
(Elementor → Settings → Experiments → Atomic CSS).

---

## Troubleshooting

| Symptom | Cause | Fix |
|---------|-------|-----|
| Site shows old content | Browser cache | Hard reload Ctrl+Shift+R |
| Elementor edits not visible | Elementor CSS cache stale | `wp eval '\Elementor\Plugin::$instance->files_manager->clear_cache();'` |
| 500 error | PHP error | `docker compose logs wordpress \| tail -50` |
| DB connection error | MySQL not ready | `docker compose restart db && sleep 30` |
| `wp` not found | WP-CLI not installed | Run the WP-CLI install one-liner above |
| SVG not displaying | WordPress 0x0 dims bug | Ensure child theme CSS has `width:100%!important` on the img |
| Header/footer not updating | Wrong template edited | Edit post 3788 (header) or 923 (footer) directly |
| `docker compose up` fails | Port conflict | Check 8080, 8081, 3307 are free: `lsof -i :8080` |

---

## Task Handoff Protocol

When finishing a work session, always:

1. Run `./scripts/db-export.sh` if you touched the WordPress admin or Elementor
2. Run `git add -A && git status` to review everything staged
3. Commit with a clear message describing what changed
4. Push to `origin main`
5. Leave a note in the commit body if there are known issues or next steps

Example commit message:
```
feat: add Why Macma feature icons to homepage

- Added 6 feature items with icon + title + description to am-why-right
- Updated am-feature-* CSS classes in coolair-child/style.css
- DB exported: includes updated _elementor_data for post 3954

Next: style the icon boxes to match reference (blue square background)
```
