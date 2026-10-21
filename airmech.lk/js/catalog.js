/*
 * Products page: filterable grid built from js/products.js.
 * Filters are kept in the URL (?category=…&type=…&capacity=…) so filtered views can be shared.
 */
(() => {
  const { CATALOG, UI, Icons } = window;
  const { esc } = UI;

  const root = document.getElementById('catalog');
  if (!root) return;

  const products = CATALOG.products;
  const params = new URLSearchParams(window.location.search);
  const state = {
    category: params.get('category') || 'all',
    type: params.get('type') || 'all',
    capacity: params.get('capacity') || 'all'
  };

  const usedCategories = CATALOG.categories.filter((c) => products.some((p) => p.category === c.id));
  const usedTypes = [...new Set(products.map((p) => p.type))];
  const capacities = [...new Set(products.flatMap((p) => p.variants.map((v) => v.btu).filter(Boolean)))]
    .sort((a, b) => a - b);

  const chipGroup = (key, label, options) => `
    <div class="filter-group" role="group" aria-labelledby="filter-${key}-label">
      <span class="filter-label" id="filter-${key}-label">${label}</span>
      <div class="chip-row">
        <button type="button" class="chip-btn" data-filter="${key}" data-value="all">All</button>
        ${options.map((o) => `<button type="button" class="chip-btn" data-filter="${key}" data-value="${esc(o.value)}">${esc(o.label)}</button>`).join('')}
      </div>
    </div>`;

  root.innerHTML = `
    <div class="filters">
      ${usedCategories.length > 1 ? chipGroup('category', 'Category', usedCategories.map((c) => ({ value: c.id, label: c.name }))) : ''}
      ${usedTypes.length > 1 ? chipGroup('type', 'Type', usedTypes.map((t) => ({ value: t, label: CATALOG.types[t] || t }))) : ''}
      ${capacities.length ? `
        <div class="filter-group">
          <label class="filter-label" for="filter-capacity">Capacity</label>
          <select class="input input-sm" id="filter-capacity" data-filter="capacity">
            <option value="all">Any capacity</option>
            ${capacities.map((btu) => `<option value="${btu}">${UI.formatBtu(btu)}</option>`).join('')}
          </select>
        </div>` : ''}
      <p class="filter-count" id="filter-count" aria-live="polite"></p>
    </div>
    <div class="product-grid" id="catalog-grid"></div>
    <div class="empty-state" id="catalog-empty" hidden>
      <span class="empty-icon">${Icons.svg('search')}</span>
      <h2>No products match those filters</h2>
      <p>Try a different capacity or type, or ask us. We can tell you what will suit your space.</p>
      <button type="button" class="btn btn-secondary" id="catalog-reset">Clear filters</button>
    </div>`;

  const grid = root.querySelector('#catalog-grid');
  const empty = root.querySelector('#catalog-empty');
  const countEl = root.querySelector('#filter-count');
  const capSelect = root.querySelector('#filter-capacity');

  // Ignore stale or hand-edited URL values that no longer match any option.
  if (!usedCategories.some((c) => c.id === state.category)) state.category = 'all';
  if (!usedTypes.includes(state.type)) state.type = 'all';
  if (!capacities.includes(Number(state.capacity))) state.capacity = 'all';

  const matches = (p) =>
    (state.category === 'all' || p.category === state.category) &&
    (state.type === 'all' || p.type === state.type) &&
    (state.capacity === 'all' || p.variants.some((v) => v.btu === Number(state.capacity)));

  function syncUrl() {
    const next = new URLSearchParams();
    Object.entries(state).forEach(([k, v]) => { if (v !== 'all') next.set(k, v); });
    const query = next.toString();
    try {
      window.history.replaceState(null, '', query ? `?${query}` : window.location.pathname);
    } catch {
      // Some browsers block history updates on file:// pages; filtering still works.
    }
  }

  function render() {
    const list = products.filter(matches);
    grid.innerHTML = list.map((p) => UI.productCard(p, 2)).join('');
    grid.hidden = list.length === 0;
    empty.hidden = list.length !== 0;
    countEl.textContent = `${list.length} ${list.length === 1 ? 'product' : 'products'}`;

    root.querySelectorAll('.chip-btn').forEach((btn) => {
      btn.setAttribute('aria-pressed', String(state[btn.dataset.filter] === btn.dataset.value));
    });
    if (capSelect) capSelect.value = state.capacity;
  }

  root.addEventListener('click', (e) => {
    const chip = e.target.closest('.chip-btn');
    if (!chip) return;
    state[chip.dataset.filter] = chip.dataset.value;
    syncUrl();
    render();
  });

  if (capSelect) {
    capSelect.addEventListener('change', () => {
      state.capacity = capSelect.value;
      syncUrl();
      render();
    });
  }

  root.querySelector('#catalog-reset').addEventListener('click', () => {
    state.category = 'all';
    state.type = 'all';
    state.capacity = 'all';
    syncUrl();
    render();
  });

  render();
})();
