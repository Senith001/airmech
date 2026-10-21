/*
 * ==========================================================================
 *  SITE SETTINGS
 * ==========================================================================
 *  Contact details used across every page (header, footer, contact page,
 *  WhatsApp buttons). Change a value here once and the whole site updates.
 *
 *  ⚠ The phone, WhatsApp number and address below are PLACEHOLDERS.
 *    Replace them with your real details before going live.
 * ==========================================================================
 */
window.SITE = {
  company: 'Air Mech Engineering Works',
  shortName: 'Air Mech',
  url: 'https://airmech.lk',

  // Shown as written. Links are generated automatically.
  phone: '+94 11 000 0000',

  // WhatsApp number in international format, digits only (no +, spaces or dashes).
  whatsapp: '94110000000',

  email: 'info@airmech.lk',

  // One line per entry.
  address: ['No. 00, Main Street', 'Colombo', 'Sri Lanka'],
  mapUrl: 'https://www.google.com/maps/search/?api=1&query=Colombo%2C+Sri+Lanka',

  hours: [
    { days: 'Monday – Friday', time: '8.30 am – 5.30 pm' },
    { days: 'Saturday', time: '8.30 am – 1.00 pm' }
  ],

  // Optional. Paste a form-service URL (e.g. Formspree, Getform, Basin) to receive
  // contact-form submissions by email. Leave empty to send enquiries via WhatsApp or email.
  formEndpoint: '',

  // Add full profile URLs to show icons in the footer. Empty values are hidden.
  social: {
    facebook: '',
    instagram: '',
    youtube: '',
    tiktok: '',
    linkedin: ''
  }
};
