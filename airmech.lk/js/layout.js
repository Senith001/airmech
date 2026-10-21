/*
 * Site header, footer and floating WhatsApp button, shared by every page.
 * Each page marks its section with <body data-page="…"> to highlight the nav link.
 */
(() => {
  const { SITE, CATALOG, Icons, UI } = window;
  const { esc } = UI;

  const NAV = [
    { id: 'home', href: 'index.html', label: 'Home' },
    { id: 'macma', href: 'macma.html', label: 'Macma' },
    { id: 'products', href: 'products.html', label: 'Products' },
    { id: 'services', href: 'services.html', label: 'Services' },
    { id: 'about', href: 'about.html', label: 'About' },
    { id: 'contact', href: 'contact.html', label: 'Contact' }
  ];

  const current = document.body.getAttribute('data-page');

  const navLinks = NAV.map((item) => `
    <li><a href="${item.href}"${item.id === current ? ' aria-current="page"' : ''}>${item.label}</a></li>`).join('');

  const headerHtml = `
    <div class="announce">
      <div class="container announce-inner">
        <span class="announce-tag">New</span>
        <p><span class="announce-long">Macma inverter air conditioners are now available in Sri Lanka.</span><span class="announce-short">Macma air conditioners are here.</span></p>
        <a href="macma.html">Meet Macma ${Icons.svg('arrowRight')}</a>
      </div>
    </div>
    <header class="site-header" id="site-header">
      <div class="container header-inner">
        <a class="brand" href="index.html" aria-label="${esc(SITE.company)}, home">
          <img src="assets/img/logo-mark.svg" width="36" height="36" alt="">
          <span class="brand-text">
            <span class="brand-name">AIR MECH</span>
            <span class="brand-sub">Engineering Works</span>
          </span>
        </a>
        <nav class="site-nav" id="site-nav" aria-label="Main">
          <ul class="nav-list">${navLinks}</ul>
          <div class="nav-extra">
            <a class="nav-phone" href="${UI.telHref()}">${Icons.svg('phone')}<span>${esc(SITE.phone)}</span></a>
            <a class="btn btn-primary" href="contact.html">Get a quote</a>
          </div>
        </nav>
        <a class="icon-btn header-call" href="${UI.telHref()}" aria-label="Call ${esc(SITE.phone)}">${Icons.svg('phone')}</a>
        <button class="icon-btn nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Open menu">
          ${Icons.svg('menu', 'icon-open')}${Icons.svg('close', 'icon-close')}
        </button>
      </div>
    </header>`;

  const productLinks = CATALOG.products.map((p) =>
    `<li><a href="${UI.productUrl(p)}">${esc(p.name)}</a></li>`).join('');

  const socialLinks = Object.entries(SITE.social || {})
    .filter(([, url]) => url)
    .map(([network, url]) => `
      <li><a class="icon-btn icon-btn-dark" href="${esc(url)}" target="_blank" rel="noopener" aria-label="${esc(SITE.shortName)} on ${network.charAt(0).toUpperCase() + network.slice(1)}">${Icons.svg(network)}</a></li>`)
    .join('');

  const hours = (SITE.hours || []).map((h) => `<li><span>${esc(h.days)}</span><span>${esc(h.time)}</span></li>`).join('');

  const footerHtml = `
    <footer class="site-footer">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-brand">
            <a class="brand brand-light" href="index.html" aria-label="${esc(SITE.company)}, home">
              <img src="assets/img/logo-mark.svg" width="36" height="36" alt="">
              <span class="brand-text">
                <span class="brand-name">AIR MECH</span>
                <span class="brand-sub">Engineering Works</span>
              </span>
            </a>
            <p>Air-conditioning engineers supplying, installing and servicing Macma air conditioners in Sri Lanka.</p>
            ${socialLinks ? `<ul class="social-list">${socialLinks}</ul>` : ''}
          </div>
          <div>
            <h2 class="footer-title">Macma range</h2>
            <ul class="footer-links">
              ${productLinks}
              <li><a href="products.html">All products</a></li>
            </ul>
          </div>
          <div>
            <h2 class="footer-title">Company</h2>
            <ul class="footer-links">
              <li><a href="macma.html">About Macma</a></li>
              <li><a href="services.html">Services</a></li>
              <li><a href="about.html">About Air Mech</a></li>
              <li><a href="contact.html">Contact</a></li>
            </ul>
          </div>
          <div>
            <h2 class="footer-title">Get in touch</h2>
            <ul class="footer-contact">
              <li>${Icons.svg('phone')}<a href="${UI.telHref()}">${esc(SITE.phone)}</a></li>
              <li>${Icons.svg('whatsapp')}<a href="${UI.whatsappUrl()}" target="_blank" rel="noopener">WhatsApp us</a></li>
              <li>${Icons.svg('mail')}<a href="mailto:${esc(SITE.email)}">${esc(SITE.email)}</a></li>
              <li>${Icons.svg('mapPin')}<span>${SITE.address.map(esc).join(', ')}</span></li>
            </ul>
            ${hours ? `<ul class="footer-hours">${hours}</ul>` : ''}
          </div>
        </div>
        <div class="footer-bottom">
          <p>© ${new Date().getFullYear()} ${esc(SITE.company)}. All rights reserved.</p>
          <p>Specifications are indicative and may change without notice.</p>
        </div>
      </div>
    </footer>`;

  const fabHtml = current === 'contact' ? '' : `
    <a class="wa-fab" href="${UI.whatsappUrl(`Hi ${SITE.shortName}, I have a question about Macma air conditioners.`)}" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
      ${Icons.svg('whatsapp')}
    </a>`;

  const headerSlot = document.getElementById('site-header-slot');
  const footerSlot = document.getElementById('site-footer-slot');
  if (headerSlot) headerSlot.outerHTML = headerHtml;
  if (footerSlot) footerSlot.outerHTML = footerHtml + fabHtml;

  // Mobile navigation
  const header = document.getElementById('site-header');
  const toggle = header && header.querySelector('.nav-toggle');
  const nav = document.getElementById('site-nav');

  const setOpen = (open) => {
    header.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    document.body.classList.toggle('nav-open', open);
  };

  if (toggle && nav) {
    toggle.addEventListener('click', () => setOpen(!header.classList.contains('is-open')));
    nav.addEventListener('click', (e) => { if (e.target.closest('a')) setOpen(false); });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && header.classList.contains('is-open')) {
        setOpen(false);
        toggle.focus();
      }
    });
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (mq) => { if (mq.matches) setOpen(false); });
  }

  // Icons placed in static HTML with data-icon="…"
  Icons.hydrate();

  // Contact details placed in static HTML: <a data-contact="phone|whatsapp|email"> / <span data-contact="address|hours">
  document.querySelectorAll('[data-contact]').forEach((el) => {
    const kind = el.getAttribute('data-contact');
    const message = el.getAttribute('data-message') || '';
    if (kind === 'phone') {
      el.setAttribute('href', UI.telHref());
      if (!el.children.length && !el.textContent.trim()) el.textContent = SITE.phone;
    } else if (kind === 'whatsapp') {
      el.setAttribute('href', UI.whatsappUrl(message));
      el.setAttribute('target', '_blank');
      el.setAttribute('rel', 'noopener');
    } else if (kind === 'email') {
      el.setAttribute('href', `mailto:${SITE.email}`);
      if (!el.children.length && !el.textContent.trim()) el.textContent = SITE.email;
    } else if (kind === 'address') {
      el.innerHTML = SITE.address.map(esc).join('<br>');
    } else if (kind === 'map') {
      el.setAttribute('href', SITE.mapUrl);
      el.setAttribute('target', '_blank');
      el.setAttribute('rel', 'noopener');
    } else if (kind === 'hours') {
      el.innerHTML = (SITE.hours || []).map((h) => `${esc(h.days)}: ${esc(h.time)}`).join('<br>');
    }
  });

  // Plain text from config: <span data-fill="phone|email|company"></span>
  document.querySelectorAll('[data-fill]').forEach((el) => {
    const value = SITE[el.getAttribute('data-fill')];
    if (typeof value === 'string') el.textContent = value;
  });
})();
