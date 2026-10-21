/*
 * Product detail page: product.html?id=<product-id>[&model=<variant-model>]
 * Everything on the page comes from the matching entry in js/products.js.
 */
(() => {
  const { SITE, CATALOG, UI, Icons } = window;
  const { esc } = UI;

  const root = document.getElementById('product-root');
  if (!root) return;

  const params = new URLSearchParams(window.location.search);
  const product = UI.getProduct(params.get('id'));

  if (!product) {
    document.title = `Product not found | ${SITE.company}`;
    root.removeAttribute('aria-busy');
    root.innerHTML = `
      <div class="container">
        <div class="empty-state empty-state-page">
          <span class="empty-icon">${Icons.svg('search')}</span>
          <h1>We couldn’t find that product</h1>
          <p>The link may be out of date, or the product may have been renamed. Browse the current Macma range instead.</p>
          <a class="btn btn-primary" href="products.html">View all products ${Icons.svg('arrowRight')}</a>
        </div>
      </div>`;
    return;
  }

  let variant = product.variants.find((v) => v.model === params.get('model')) || product.variants[0];
  const rows = UI.specRows(product);
  const keySpecs = (product.keySpecs || rows).slice(0, 3);
  const gallery = product.gallery && product.gallery.length ? product.gallery : [product.image];
  const features = product.features || [];
  const highlights = product.highlights || [];

  // ---- Page metadata ---------------------------------------------------
  document.title = `${product.fullName} | Macma by ${SITE.shortName}`;
  UI.setMeta('description', `${product.fullName}: ${product.tagline} Specifications, features and enquiries from ${SITE.company}, Sri Lanka.`);

  const ld = document.createElement('script');
  ld.type = 'application/ld+json';
  ld.textContent = JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'ProductGroup',
    name: product.fullName,
    description: product.description,
    brand: { '@type': 'Brand', name: CATALOG.brand },
    image: new URL(product.image.src, `${SITE.url}/`).href,
    productGroupID: product.id,
    hasVariant: product.variants.map((v) => ({
      '@type': 'Product',
      name: `${product.fullName} ${UI.variantLabel(v)}`,
      sku: v.model,
      brand: { '@type': 'Brand', name: CATALOG.brand }
    }))
  });
  document.head.appendChild(ld);

  // ---- Markup -----------------------------------------------------------
  const thumbs = gallery.length > 1 ? `
    <div class="gallery-thumbs" role="group" aria-label="Product images">
      ${gallery.map((img, i) => `
        <button type="button" class="gallery-thumb" data-index="${i}" aria-label="Show ${esc(img.label || img.alt)}"${i === 0 ? ' aria-current="true"' : ''}>
          <img src="${esc(img.src)}" alt="" loading="lazy">
        </button>`).join('')}
    </div>` : '';

  const variantOptions = product.variants.map((v) => `
    <label class="variant-option">
      <input type="radio" name="variant" value="${esc(v.model)}"${v === variant ? ' checked' : ''}>
      <span class="variant-box">
        <strong>${esc(UI.variantLabel(v))}</strong>
        ${v.specs && v.specs['Recommended room size'] ? `<small>${esc(v.specs['Recommended room size'])}</small>` : ''}
      </span>
    </label>`).join('');

  const specTable = `
    <table class="spec-table">
      <caption class="visually-hidden">${esc(product.fullName)} specifications by model</caption>
      <thead>
        <tr>
          <th scope="col">Model</th>
          ${product.variants.map((v, i) => `<th scope="col" data-col="${i}">${esc(v.model)}<span>${esc(UI.variantLabel(v))}</span></th>`).join('')}
        </tr>
      </thead>
      <tbody>
        ${rows.map((label) => `
          <tr>
            <th scope="row">${esc(label)}</th>
            ${product.variants.map((v, i) => `<td data-col="${i}">${esc(UI.specValue(product, v, label))}</td>`).join('')}
          </tr>`).join('')}
      </tbody>
    </table>`;

  const related = CATALOG.products.filter((p) => p.id !== product.id && p.category === product.category);

  root.innerHTML = `
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li><a href="products.html">Products</a></li>
          <li><span aria-current="page">${esc(product.name)}</span></li>
        </ol>
      </nav>

      <div class="pd">
        <div class="pd-gallery">
          <div class="gallery-main">
            ${UI.badgeList(product.badges)}
            <img id="pd-image" src="${esc(gallery[0].src)}" alt="${esc(gallery[0].alt)}">
          </div>
          ${thumbs}
        </div>

        <div class="pd-info">
          <p class="eyebrow">${esc(UI.typeLabel(product))}${features.includes('inverter') ? ' · Inverter' : ''}</p>
          <h1 class="pd-title">${esc(product.fullName)}</h1>
          <p class="pd-tagline">${esc(product.tagline)}</p>
          <p class="pd-desc">${esc(product.description)}</p>

          ${product.variants.length > 1 ? `
            <fieldset class="variant-group">
              <legend>Choose a capacity</legend>
              <div class="variant-options">${variantOptions}</div>
            </fieldset>` : ''}

          <dl class="key-stats" id="pd-stats"></dl>

          <div class="pd-actions">
            <a class="btn btn-whatsapp btn-lg" id="pd-whatsapp" target="_blank" rel="noopener">${Icons.svg('whatsapp')} Enquire on WhatsApp</a>
            <a class="btn btn-secondary btn-lg" id="pd-quote">Request a quote</a>
          </div>
          <p class="pd-call">Prefer to talk? Call <a href="${UI.telHref()}">${esc(SITE.phone)}</a></p>

          <ul class="check-list pd-highlights">
            ${highlights.map((h) => `<li>${Icons.svg('check')}<span>${esc(h)}</span></li>`).join('')}
          </ul>
        </div>
      </div>
    </div>

    ${features.length ? `
    <section class="section section-alt" aria-labelledby="pd-features-title">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Features</p>
          <h2 id="pd-features-title">What’s inside the ${esc(product.name)}</h2>
        </div>
        <ul class="feature-grid">${features.map((k) => UI.featureItem(k, 3)).join('')}</ul>
      </div>
    </section>` : ''}

    <section class="section" aria-labelledby="pd-specs-title">
      <div class="container">
        <div class="section-head section-head-row">
          <div>
            <p class="eyebrow">Specifications</p>
            <h2 id="pd-specs-title">Technical specifications</h2>
          </div>
          <p class="section-note">The selected model is highlighted. Specifications are indicative and may change without notice.</p>
        </div>
        ${product.variants.length > 2 ? `<p class="table-hint" aria-hidden="true">${Icons.svg('arrowRight')} Scroll sideways to compare all models</p>` : ''}
        <div class="table-wrap" tabindex="0" role="region" aria-labelledby="pd-specs-title">${specTable}</div>

        <div class="pd-extras">
          ${product.inTheBox && product.inTheBox.length ? `
            <div class="info-card">
              <h3>In the box</h3>
              <ul class="check-list check-list-sm">${product.inTheBox.map((i) => `<li>${Icons.svg('check')}<span>${esc(i)}</span></li>`).join('')}</ul>
            </div>` : ''}
          ${product.warranty && product.warranty.length ? `
            <div class="info-card">
              <h3>Warranty</h3>
              <dl class="warranty-list">${product.warranty.map((w) => `<div><dt>${esc(w.label)}</dt><dd>${esc(w.value)}</dd></div>`).join('')}</dl>
              <p class="info-card-note">Warranty support is handled directly by ${esc(SITE.company)}.</p>
            </div>` : ''}
          <div class="info-card info-card-accent">
            <h3>Installation and aftercare</h3>
            <p>Our technicians survey the room, install the unit and commission it. Afterwards we keep it serviced.</p>
            <a class="link-arrow" href="services.html">Our services ${Icons.svg('arrowRight')}</a>
          </div>
          ${product.downloads && product.downloads.length ? `
            <div class="info-card">
              <h3>Downloads</h3>
              <ul class="download-list">${product.downloads.map((d) => `<li><a href="${esc(d.href)}" download>${Icons.svg('download')}${esc(d.label)}</a></li>`).join('')}</ul>
            </div>` : ''}
        </div>
      </div>
    </section>

    ${related.length ? `
      <section class="section section-alt" aria-labelledby="pd-related-title">
        <div class="container">
          <div class="section-head section-head-row">
            <div>
              <p class="eyebrow">Macma range</p>
              <h2 id="pd-related-title">You might also consider</h2>
            </div>
            <a class="link-arrow" href="products.html">All products ${Icons.svg('arrowRight')}</a>
          </div>
          <div class="product-grid">${related.map((p) => UI.productCard(p, 3)).join('')}</div>
        </div>
      </section>` : ''}`;

  root.removeAttribute('aria-busy');

  // ---- Behaviour --------------------------------------------------------
  const stats = root.querySelector('#pd-stats');
  const whatsapp = root.querySelector('#pd-whatsapp');
  const quote = root.querySelector('#pd-quote');
  const table = root.querySelector('.spec-table');

  function applyVariant() {
    const index = product.variants.indexOf(variant);
    const label = `${product.fullName} ${UI.variantLabel(variant)} (${variant.model})`;

    stats.innerHTML = `
      <div class="key-stat"><dt>Model</dt><dd>${esc(variant.model)}</dd></div>
      ${keySpecs.map((k) => `<div class="key-stat"><dt>${esc(k)}</dt><dd>${esc(UI.specValue(product, variant, k))}</dd></div>`).join('')}`;

    whatsapp.href = UI.whatsappUrl(`Hi ${SITE.shortName}, I’d like to know more about the ${label}.`);
    quote.href = `contact.html?product=${encodeURIComponent(variant.model)}`;

    table.querySelectorAll('[data-col]').forEach((cell) => {
      cell.classList.toggle('is-selected', Number(cell.dataset.col) === index);
    });
  }

  root.querySelectorAll('input[name="variant"]').forEach((input) => {
    input.addEventListener('change', () => {
      variant = product.variants.find((v) => v.model === input.value) || variant;
      applyVariant();
      try {
        window.history.replaceState(null, '', UI.productUrl(product, variant.model));
      } catch {
        // History updates can be blocked on file:// pages.
      }
    });
  });

  const mainImage = root.querySelector('#pd-image');
  root.querySelectorAll('.gallery-thumb').forEach((btn) => {
    btn.addEventListener('click', () => {
      const img = gallery[Number(btn.dataset.index)];
      mainImage.src = img.src;
      mainImage.alt = img.alt;
      root.querySelectorAll('.gallery-thumb').forEach((b) => b.removeAttribute('aria-current'));
      btn.setAttribute('aria-current', 'true');
    });
  });

  applyVariant();
})();
