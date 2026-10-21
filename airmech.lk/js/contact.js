/*
 * Contact / enquiry form.
 *
 * With SITE.formEndpoint set (js/config.js), the form posts JSON to that URL.
 * Without it, visitors choose to send the enquiry through WhatsApp or their email app.
 * Pre-select a topic with contact.html?product=<model> or contact.html?topic=<value>.
 */
(() => {
  const { SITE, CATALOG, UI, Icons } = window;
  const { esc } = UI;

  const form = document.getElementById('enquiry-form');
  if (!form) return;

  const field = (name) => form.elements.namedItem(name);
  const interest = field('interest');
  const status = document.getElementById('form-status');
  const actions = document.getElementById('form-actions');

  // ---- Interest options -------------------------------------------------
  const productGroups = CATALOG.products.map((p) => `
    <optgroup label="${esc(p.fullName)}">
      ${p.variants.map((v) => `<option value="${esc(v.model)}">${esc(`${p.name} ${UI.variantLabel(v)} (${v.model})`)}</option>`).join('')}
    </optgroup>`).join('');

  interest.innerHTML = `
    <option value="general">General enquiry</option>
    ${productGroups}
    <optgroup label="Services">
      <option value="site-visit">Site visit and sizing</option>
      <option value="installation">Installation</option>
      <option value="service">Servicing or maintenance contract</option>
      <option value="repair">Repair</option>
      <option value="commercial">Commercial project</option>
    </optgroup>
    <option value="updates">Updates on new Macma products</option>`;

  const params = new URLSearchParams(window.location.search);
  const preset = params.get('product') || params.get('topic');
  if (preset && [...interest.options].some((o) => o.value === preset)) interest.value = preset;

  // ---- Send buttons -------------------------------------------------------
  const hasEndpoint = Boolean(SITE.formEndpoint);
  actions.innerHTML = hasEndpoint
    ? `<button type="submit" class="btn btn-primary btn-lg" value="post">Send enquiry ${Icons.svg('arrowRight')}</button>`
    : `<button type="submit" class="btn btn-whatsapp btn-lg" value="whatsapp">${Icons.svg('whatsapp')} Send via WhatsApp</button>
       <button type="submit" class="btn btn-secondary btn-lg" value="email">${Icons.svg('mail')} Send via email</button>`;

  // ---- Validation ---------------------------------------------------------
  const rules = {
    name: (v) => (v.trim().length >= 2 ? '' : 'Please enter your name.'),
    phone: (v) => (v.replace(/\D/g, '').length >= 9 ? '' : 'Please enter a phone number we can reach you on.'),
    email: (v) => (!v.trim() || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) ? '' : 'Please check the email address.')
  };

  function validateField(name) {
    const input = field(name);
    const message = rules[name](input.value);
    const error = document.getElementById(`${name}-error`);
    input.setAttribute('aria-invalid', String(Boolean(message)));
    error.textContent = message;
    error.hidden = !message;
    return !message;
  }

  Object.keys(rules).forEach((name) => {
    field(name).addEventListener('blur', () => {
      if (field(name).value) validateField(name);
    });
    field(name).addEventListener('input', () => {
      if (field(name).getAttribute('aria-invalid') === 'true') validateField(name);
    });
  });

  function setStatus(type, html) {
    status.className = `form-status form-status-${type}`;
    status.innerHTML = html;
    status.hidden = false;
  }

  function collect() {
    const option = interest.options[interest.selectedIndex];
    return {
      name: field('name').value.trim(),
      phone: field('phone').value.trim(),
      email: field('email').value.trim(),
      location: field('location').value.trim(),
      interest: option ? option.textContent.trim() : '',
      message: field('message').value.trim()
    };
  }

  function composeText(data) {
    const lines = [
      `New enquiry from ${SITE.url.replace(/^https?:\/\//, '')}`,
      '',
      `Name: ${data.name}`,
      `Phone: ${data.phone}`
    ];
    if (data.email) lines.push(`Email: ${data.email}`);
    if (data.location) lines.push(`Location: ${data.location}`);
    lines.push(`Interested in: ${data.interest}`);
    if (data.message) lines.push('', `Message: ${data.message}`);
    return lines.join('\n');
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    status.hidden = true;

    const results = Object.keys(rules).map(validateField);
    if (results.includes(false)) {
      const firstInvalid = form.querySelector('[aria-invalid="true"]');
      if (firstInvalid) firstInvalid.focus();
      return;
    }

    const method = (e.submitter && e.submitter.value) || (hasEndpoint ? 'post' : 'whatsapp');
    const data = collect();
    const text = composeText(data);

    if (method === 'whatsapp') {
      window.open(UI.whatsappUrl(text), '_blank', 'noopener');
      setStatus('success', `${Icons.svg('check')}<span>WhatsApp has opened with your message. Press <strong>send</strong> there and we’ll reply as soon as we can.</span>`);
      return;
    }

    if (method === 'email') {
      const subject = `Website enquiry: ${data.interest}`;
      window.location.href = `mailto:${SITE.email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(text)}`;
      setStatus('success', `${Icons.svg('check')}<span>Your email app should open with the message ready. If nothing happens, write to <a href="mailto:${esc(SITE.email)}">${esc(SITE.email)}</a>.</span>`);
      return;
    }

    const submit = form.querySelector('button[type="submit"]');
    submit.disabled = true;
    submit.setAttribute('aria-busy', 'true');
    try {
      const response = await fetch(SITE.formEndpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
        body: JSON.stringify({ ...data, _subject: `Website enquiry: ${data.interest}` })
      });
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      form.reset();
      setStatus('success', `${Icons.svg('check')}<span>Thank you. Your enquiry has been sent and we’ll be in touch shortly.</span>`);
    } catch {
      setStatus('error', `${Icons.svg('info')}<span>Sorry, we couldn’t send your enquiry just now. Please call <a href="${UI.telHref()}">${esc(SITE.phone)}</a> or <a href="${UI.whatsappUrl(text)}" target="_blank" rel="noopener">message us on WhatsApp</a>.</span>`);
    } finally {
      submit.disabled = false;
      submit.removeAttribute('aria-busy');
    }
  });
})();
