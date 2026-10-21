# airmech.lk: Air Mech Engineering Works, featuring Macma

A static website (plain HTML, CSS and JavaScript, with no build step) showcasing Macma air conditioners, supplied, installed and serviced in Sri Lanka by Air Mech Engineering Works.

## Before going live

Everything below is **placeholder content** and must be replaced:

| What | Where |
|---|---|
| Phone, WhatsApp number, email, address, opening hours, social links | `js/config.js` |
| Model numbers, specifications, warranty terms, features | `js/products.js` |
| Product images (currently SVG illustrations) | `assets/img/products/`, then update paths in `js/products.js` |
| Company claims to confirm: servicing other brands, local warranty handling, Macma supply relationship | `services.html`, `macma.html`, `about.html` |
| Company history, team or installation photos (optional but recommended) | `about.html` (see the `TODO` comment) |

## Project structure

```
index.html        Home
macma.html        Macma brand and technology page
products.html     Product range with filters and sizing guide
product.html      Product detail page (product.html?id=aero)
services.html     Installation, servicing, repairs, commercial
about.html        About Air Mech
contact.html      Enquiry form and contact details
404.html          Not-found page

css/styles.css    All styles; colours and spacing are tokens at the top
js/config.js      ← Site-wide contact details
js/products.js    ← Product catalogue (drives every product listing and page)
js/icons.js       Inline SVG icon set
js/ui.js          Shared helpers: product cards, feature lists
js/layout.js      Header, footer, mobile menu, WhatsApp button
js/finder.js      "Which capacity do I need?" sizing tool
js/catalog.js     Products page filters
js/product.js     Product detail page
js/contact.js     Enquiry form

.htaccess         Apache/LiteSpeed config: HTTPS, redirects from old WordPress URLs, caching
sitemap.xml, robots.txt
```

## Common tasks

### Add a product

1. Add images to `assets/img/products/`. Transparent PNG or WebP works best. Wall units look best around 800 × 320 px, square units around 480 × 480 px.
2. In `js/products.js`, copy an existing object inside `products: [ … ]` and change:
   - `id`: unique, lowercase, no spaces (it becomes the URL: `product.html?id=your-id`)
   - `name`, `fullName`, `tagline`, `description`, `badges`
   - `image` and `gallery`
   - `highlights` (4 short bullet points)
   - `features`: keys from the `features` list at the top of the file (add new ones there if needed)
   - `variants`: one entry per capacity, each with `model`, `btu` and `specs`
   - `common`: specs that are the same for every variant
3. Add the new URL to `sitemap.xml`.

The product then appears automatically on the home page, the products page, the footer, the capacity finder and the contact form's "I'm interested in" list.

### Add a new product line (beyond air conditioners)

1. Add a category to `categories` in `js/products.js`, e.g. `{ id: 'water-heaters', name: 'Water heaters' }`.
2. Add any new product types to `types`.
3. Add products with `category: 'water-heaters'`. For non-A/C products, leave out `btu` and give each variant a `label` instead (e.g. `label: '30 litre'`).

Category filters on the products page appear automatically once more than one category exists. On the home page, the range section shows `data-products="air-conditioners"`. Add a second section with your new category id, or use `data-products="all"`.

### Change contact details

Edit `js/config.js`. The header, footer, contact page, WhatsApp buttons and phone links all update from there.

### Receive form submissions by email

By default the contact form sends enquiries through WhatsApp or the visitor's email app, with no server needed. To receive submissions directly instead, create a form endpoint with a service such as Formspree, Getform or Basin, and paste its URL into `formEndpoint` in `js/config.js`.

### Change the capacity finder

Sizing tiers are in `js/finder.js` (`TIERS`). Keep them in line with the "Recommended room size" values in `js/products.js`.

## Running locally

Open `index.html` directly in a browser, or serve the folder:

```bash
python3 -m http.server 4873
```

Then visit http://localhost:4873.

## Deploying (replacing the WordPress site)

1. **Back up the existing WordPress site** (files and database) from your hosting control panel.
2. In `public_html` (or your site's web root), move the WordPress files into a backup folder or delete them, including the old `.htaccess`.
3. Upload every file and folder from this project to the web root, including the hidden `.htaccess` file. You don't need to upload `.claude/` or `README.md`.
4. Visit https://airmech.lk and check the home, a product page and the contact form.
5. In Google Search Console, submit `https://airmech.lk/sitemap.xml`.

`.htaccess` redirects the old WordPress URLs (`/about-us/`, `/contact/`, `/products/`, and so on) to the new pages, so existing links keep working.
