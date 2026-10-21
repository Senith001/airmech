/*
 * Inline SVG icon set (24 × 24, stroke-based).
 * In HTML:  <span data-icon="check"></span>   → replaced with the SVG on load.
 * In JS:    Icons.svg('check')                → returns the SVG markup.
 */
(() => {
  const paths = {
    arrowRight: '<path d="M5 12h14M13 6l6 6-6 6"/>',
    arrowLeft: '<path d="M19 12H5M11 6l-6 6 6 6"/>',
    check: '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
    chevronDown: '<path d="M6 9l6 6 6-6"/>',
    menu: '<path d="M4 7h16M4 12h16M4 17h16"/>',
    close: '<path d="M6 6l12 12M18 6L6 18"/>',
    info: '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>',
    phone: '<path d="M5 4h3.2l1.8 4.6-2.3 1.4a11 11 0 0 0 6.3 6.3l1.4-2.3 4.6 1.8V19a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
    mail: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 7l8.5 6 8.5-6"/>',
    mapPin: '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
    clock: '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
    whatsapp: '<path d="M3.5 20.5l1.2-4.1A8.5 8.5 0 1 1 8 19.6l-4.5.9z"/><path d="M9.2 8.4c.2-.4.6-.5.9-.4l.8.2.8 1.9-.8.9c.5 1.1 1.4 2 2.5 2.5l.9-.8 1.9.8.2.8c.1.3 0 .7-.4.9-1.1.7-2.5.6-3.7-.1a8.1 8.1 0 0 1-3-3c-.7-1.2-.8-2.6-.1-3.7z"/>',
    snowflake: '<path d="M12 3v18M4.2 7.5l15.6 9M19.8 7.5l-15.6 9"/><path d="M9.5 4.5L12 7l2.5-2.5M9.5 19.5L12 17l2.5 2.5"/>',
    wave: '<path d="M2.5 12c1.6-4.5 3.6-4.5 5.2 0s3.6 4.5 5.2 0 3.6-4.5 5.2 0 2.2 3.2 3.4 2.6"/>',
    thermometer: '<path d="M14 14.5V5a2 2 0 1 0-4 0v9.5a4 4 0 1 0 4 0z"/><path d="M12 10v6"/>',
    shield: '<path d="M12 3l7 3v5.2c0 4.4-3 8.2-7 9.8-4-1.6-7-5.4-7-9.8V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
    bolt: '<path d="M13 2.5L4.5 14h7l-1 7.5L19 10h-7l1-7.5z"/>',
    power: '<path d="M12 3v8"/><path d="M6.4 6.6a8 8 0 1 0 11.2 0"/>',
    volume: '<path d="M4 9.5v5h3.5L12 18.5v-13L7.5 9.5H4z"/><path d="M15.5 9.5a3.5 3.5 0 0 1 0 5"/>',
    moon: '<path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5z"/>',
    gauge: '<path d="M4 17a8 8 0 1 1 16 0"/><path d="M12 17l4-5"/><path d="M4 17h2M18 17h2"/>',
    sparkle: '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/><path d="M19 16l.7 1.8 1.8.7-1.8.7L19 21l-.7-1.8-1.8-.7 1.8-.7L19 16z"/>',
    layers: '<path d="M12 3l9 5-9 5-9-5 9-5z"/><path d="M3 12.5l9 5 9-5"/><path d="M3 16.5l9 5 9-5"/>',
    droplet: '<path d="M12 3s6 6.4 6 11a6 6 0 0 1-12 0c0-4.6 6-11 6-11z"/>',
    leaf: '<path d="M5 19.5C4 10 9.5 4.5 20 4c.5 10.5-5 16-14.5 15.5z"/><path d="M5 19.5l7.5-7.5"/>',
    wifi: '<path d="M2.5 8.8a14 14 0 0 1 19 0"/><path d="M5.5 12.2a9.5 9.5 0 0 1 13 0"/><path d="M8.7 15.5a5 5 0 0 1 6.6 0"/><path d="M12 19h.01"/>',
    wind: '<path d="M3 8.5h10.5a3 3 0 1 0-3-3"/><path d="M3 12.5h15a3 3 0 1 1-3 3"/><path d="M3 16.5h7"/>',
    remote: '<rect x="7" y="2.5" width="10" height="19" rx="3"/><path d="M10 6.5h4M12 10.5h.01M10 14h.01M14 14h.01M10 17h.01M14 17h.01"/>',
    home: '<path d="M3.5 11L12 4l8.5 7"/><path d="M5.5 9.5V20h13V9.5"/><path d="M10 20v-5h4v5"/>',
    wrench: '<path d="M14.7 6.3a4 4 0 0 0-5.3 5.2L3.5 17.4V20.5h3.1l5.9-5.9a4 4 0 0 0 5.2-5.3l-2.6 2.6-2.4-.4-.4-2.4 2.4-2.8z"/>',
    calendar: '<rect x="3.5" y="5" width="17" height="15.5" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/>',
    clipboard: '<rect x="5" y="4.5" width="14" height="16.5" rx="2"/><path d="M9 3h6v3H9zM9 11h6M9 15h4"/>',
    building: '<path d="M4 21V5.5L12 3v18M12 21V9l8 2.5V21M2.5 21h19"/><path d="M7 8h2M7 12h2M7 16h2M15 14h2M15 17.5h2"/>',
    users: '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.6a3.5 3.5 0 0 1 0 6.8M18 14.3a6.5 6.5 0 0 1 3.5 5.7"/>',
    ruler: '<path d="M3 16.5L16.5 3l4.5 4.5L7.5 21 3 16.5z"/><path d="M7.5 12l2 2M10.5 9l2 2M13.5 6l2 2"/>',
    download: '<path d="M12 4v11M7 10l5 5 5-5M5 20h14"/>',
    search: '<circle cx="11" cy="11" r="6.5"/><path d="M20 20l-4.2-4.2"/>',
    facebook: '<path d="M14 8.5h3v-4h-3a4 4 0 0 0-4 4v2.5H7.5v4H10V21h4v-6h2.8l.7-4H14V8.5z"/>',
    instagram: '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.2 6.8h.01"/>',
    youtube: '<rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="M10 9.3v5.4l4.6-2.7L10 9.3z"/>',
    linkedin: '<rect x="3.5" y="3.5" width="17" height="17" rx="3"/><path d="M8 10.5V16.5M8 7.5v.01M12 16.5v-3.5a2 2 0 0 1 4 0v3.5M12 10.5v6"/>',
    tiktok: '<path d="M14 3.5v11a3.5 3.5 0 1 1-3.5-3.5"/><path d="M14 3.5c.5 2.6 2.4 4.4 5 4.6"/>'
  };

  function svg(name, className) {
    const body = paths[name];
    if (!body) return '';
    return `<svg class="icon${className ? ` ${className}` : ''}" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">${body}</svg>`;
  }

  function hydrate(root = document) {
    root.querySelectorAll('[data-icon]').forEach((el) => {
      el.innerHTML = svg(el.getAttribute('data-icon'), el.getAttribute('data-icon-class'));
      el.removeAttribute('data-icon');
    });
  }

  window.Icons = { svg, hydrate };
})();
