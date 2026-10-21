/*
 * Shared helpers and reusable blocks rendered from the catalogue.
 *
 * Declarative blocks (add the attribute to any element in the HTML):
 *   data-products="all" | "<category-id>"   → product cards
 *   data-features="inverter,tropical,…"      → feature list (optional data-heading="4")
 */
(() => {
  const { SITE, CATALOG, Icons } = window;

  const esc = (value) => String(value ?? '').replace(/[&<>"']/g, (ch) => (
    { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]
  ));

  const formatBtu = (btu) => `${Number(btu).toLocaleString('en-US')} BTU`;
  const shortBtu = (btu) => `${Math.round(btu / 100) / 10}k`;

  const variantLabel = (variant) => variant.label || (variant.btu ? formatBtu(variant.btu) : variant.model);

  const getProduct = (id) => CATALOG.products.find((p) => p.id === id);

  const productUrl = (product, model) =>
    `product.html?id=${encodeURIComponent(product.id)}${model ? `&model=${encodeURIComponent(model)}` : ''}`;

  const typeLabel = (product) => CATALOG.types[product.type] || product.type;

  const telHref = () => `tel:${SITE.phone.replace(/[^\d+]/g, '')}`;

  const whatsappUrl = (text) =>
    `https://wa.me/${SITE.whatsapp}${text ? `?text=${encodeURIComponent(text)}` : ''}`;

  // Ordered union of spec labels across all variants, followed by the product-wide specs.
  const specRows = (product) => {
    const rows = [];
    product.variants.forEach((v) => Object.keys(v.specs || {}).forEach((k) => {
      if (!rows.includes(k)) rows.push(k);
    }));
    Object.keys(product.common || {}).forEach((k) => {
      if (!rows.includes(k)) rows.push(k);
    });
    return rows;
  };

  const specValue = (product, variant, label) =>
    (variant.specs && variant.specs[label]) ?? (product.common && product.common[label]) ?? '—';

  const badgeList = (badges = []) => badges.length
    ? `<ul class="badges">${badges.map((b) => `<li class="badge">${esc(b)}</li>`).join('')}</ul>`
    : '';

  function productCard(product, headingLevel = 3) {
    const h = `h${headingLevel}`;
    const caps = product.variants.filter((v) => v.btu);
    const capList = caps.length
      ? `<div class="card-caps">
           <span class="card-caps-label">BTU</span>
           <ul class="cap-list" aria-label="Available capacities in BTU">
             ${caps.map((v) => `<li>${shortBtu(v.btu)}</li>`).join('')}
           </ul>
         </div>`
      : '';

    return `
      <article class="product-card">
        <div class="product-card-media">
          ${badgeList(product.badges)}
          <img src="${esc(product.image.src)}" alt="${esc(product.image.alt)}" loading="lazy" decoding="async">
        </div>
        <div class="product-card-body">
          <p class="product-card-type">${esc(typeLabel(product))}</p>
          <${h} class="product-card-title"><a href="${productUrl(product)}">${esc(product.name)}</a></${h}>
          <p class="product-card-text">${esc(product.tagline)}</p>
          ${capList}
          <span class="link-arrow" aria-hidden="true">View details ${Icons.svg('arrowRight')}</span>
        </div>
      </article>`;
  }

  function featureItem(key, headingLevel = 3) {
    const f = CATALOG.features[key];
    if (!f) return '';
    const h = `h${headingLevel}`;
    return `
      <li class="feature">
        <span class="feature-icon">${Icons.svg(f.icon)}</span>
        <div>
          <${h} class="feature-title">${esc(f.title)}</${h}>
          <p class="feature-text">${esc(f.text)}</p>
        </div>
      </li>`;
  }

  function mountBlocks(root = document) {
    root.querySelectorAll('[data-products]').forEach((el) => {
      const category = el.getAttribute('data-products');
      const level = Number(el.getAttribute('data-heading')) || 3;
      const list = CATALOG.products.filter((p) => category === 'all' || p.category === category);
      el.innerHTML = list.map((p) => productCard(p, level)).join('');
    });

    root.querySelectorAll('[data-features]').forEach((el) => {
      const keys = el.getAttribute('data-features').split(',').map((k) => k.trim()).filter(Boolean);
      const level = Number(el.getAttribute('data-heading')) || 3;
      el.innerHTML = keys.map((k) => featureItem(k, level)).join('');
    });
  }

  function setMeta(name, content) {
    let tag = document.querySelector(`meta[name="${name}"]`);
    if (!tag) {
      tag = document.createElement('meta');
      tag.setAttribute('name', name);
      document.head.appendChild(tag);
    }
    tag.setAttribute('content', content);
  }

  window.UI = {
    esc,
    formatBtu,
    shortBtu,
    variantLabel,
    getProduct,
    productUrl,
    typeLabel,
    telHref,
    whatsappUrl,
    specRows,
    specValue,
    badgeList,
    productCard,
    featureItem,
    mountBlocks,
    setMeta
  };

  mountBlocks();
})();
