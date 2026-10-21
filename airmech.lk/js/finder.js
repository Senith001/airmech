/*
 * Capacity finder: estimates the A/C size for a room and links to matching Macma models.
 * Mount it with <div data-finder></div>.
 *
 * Sizing tiers match the "Recommended room size" figures in js/products.js.
 * The room area is adjusted for sun exposure, a roof directly above, and occupancy.
 */
(() => {
  const { CATALOG, UI, Icons } = window;
  const { esc } = UI;

  const TIERS = [
    { maxSqFt: 150, btu: 9000 },
    { maxSqFt: 250, btu: 12000 },
    { maxSqFt: 350, btu: 18000 },
    { maxSqFt: 450, btu: 24000 },
    { maxSqFt: 700, btu: 36000 },
    { maxSqFt: 900, btu: 48000 }
  ];
  const SUN_FACTOR = { shaded: 0.9, some: 1, strong: 1.15 };
  const ROOF_FACTOR = 1.1;
  const SQFT_PER_EXTRA_PERSON = 25;
  const BASE_PEOPLE = 2;

  function estimate({ length, width, sun, roof, people }) {
    const area = length * width;
    if (!(area > 0)) return null;
    let effective = area * (SUN_FACTOR[sun] || 1);
    if (roof) effective *= ROOF_FACTOR;
    effective += Math.max(0, people - BASE_PEOPLE) * SQFT_PER_EXTRA_PERSON;
    const tier = TIERS.find((t) => effective <= t.maxSqFt);
    return { area: Math.round(area), effective: Math.round(effective), btu: tier ? tier.btu : null };
  }

  const matchingModels = (btu) => CATALOG.products.flatMap((p) =>
    p.variants.filter((v) => v.btu === btu).map((v) => ({ product: p, variant: v })));

  let count = 0;

  function mount(root) {
    const id = `finder-${++count}`;
    root.classList.add('finder');
    root.innerHTML = `
      <form class="finder-form" novalidate aria-label="Room details">
        <div class="field-row">
          <div class="field">
            <label for="${id}-length">Room length <span class="field-hint">(feet)</span></label>
            <input class="input" id="${id}-length" name="length" type="number" inputmode="decimal" min="1" max="200" step="0.5" value="12">
          </div>
          <div class="field">
            <label for="${id}-width">Room width <span class="field-hint">(feet)</span></label>
            <input class="input" id="${id}-width" name="width" type="number" inputmode="decimal" min="1" max="200" step="0.5" value="10">
          </div>
        </div>
        <div class="field">
          <label for="${id}-sun">How much sun does the room get?</label>
          <select class="input" id="${id}-sun" name="sun">
            <option value="shaded">Mostly shaded</option>
            <option value="some" selected>Some direct sun</option>
            <option value="strong">Strong afternoon sun</option>
          </select>
        </div>
        <div class="field">
          <label for="${id}-people">People usually in the room</label>
          <input class="input" id="${id}-people" name="people" type="number" inputmode="numeric" min="1" max="40" step="1" value="2">
        </div>
        <label class="check">
          <input type="checkbox" name="roof">
          <span>Roof or top floor directly above</span>
        </label>
      </form>
      <div class="finder-result" aria-live="polite"></div>`;

    const form = root.querySelector('form');
    const out = root.querySelector('.finder-result');

    // form.elements avoids clashes with built-in form properties such as `length`.
    const field = (name) => form.elements.namedItem(name);
    const read = () => ({
      length: parseFloat(field('length').value),
      width: parseFloat(field('width').value),
      sun: field('sun').value,
      roof: field('roof').checked,
      people: Math.max(1, parseInt(field('people').value, 10) || BASE_PEOPLE)
    });

    function render() {
      const result = estimate(read());

      if (!result) {
        out.innerHTML = `
          <p class="finder-label">Recommended capacity</p>
          <p class="finder-empty">Enter the room’s length and width to see a recommendation.</p>`;
        return;
      }

      if (!result.btu) {
        out.innerHTML = `
          <p class="finder-label">Recommended capacity</p>
          <p class="finder-value">48,000+ <span>BTU</span></p>
          <p class="finder-meta">About ${result.area.toLocaleString('en-US')} sq ft is more than one unit should cool. Larger spaces usually need several units working together.</p>
          <a class="btn btn-light" href="contact.html?topic=commercial">Talk to our engineers ${Icons.svg('arrowRight')}</a>`;
        return;
      }

      const models = matchingModels(result.btu);
      const adjusted = result.effective !== result.area
        ? ` We sized it as about ${result.effective.toLocaleString('en-US')} sq ft to allow for sun, roof and occupancy.`
        : '';

      out.innerHTML = `
        <p class="finder-label">Recommended capacity</p>
        <p class="finder-value">${result.btu.toLocaleString('en-US')} <span>BTU</span></p>
        <p class="finder-meta">For a room of about ${result.area.toLocaleString('en-US')} sq ft.${adjusted}</p>
        ${models.length ? `
          <p class="finder-sub">Matching Macma models</p>
          <ul class="finder-matches">
            ${models.map(({ product, variant }) => `
              <li>
                <a href="${UI.productUrl(product, variant.model)}">
                  <span><strong>${esc(product.name)}</strong> <small>${esc(UI.typeLabel(product))}</small></span>
                  <span class="finder-model">${esc(variant.model)} ${Icons.svg('arrowRight')}</span>
                </a>
              </li>`).join('')}
          </ul>` : ''}
        <p class="finder-note">${Icons.svg('info')} This is a guide only. We confirm the right size on site before you buy.</p>`;
    }

    form.addEventListener('input', render);
    form.addEventListener('change', render);
    form.addEventListener('submit', (e) => e.preventDefault());
    render();
  }

  document.querySelectorAll('[data-finder]').forEach(mount);
  window.Finder = { mount, estimate };
})();
