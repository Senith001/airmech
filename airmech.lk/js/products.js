/*
 * ==========================================================================
 *  MACMA PRODUCT CATALOGUE
 * ==========================================================================
 *  Every product card, product page, filter, footer link and the capacity
 *  finder is built from this file — there is no separate page to create.
 *
 *  To add a product: copy one of the objects in `products`, give it a new
 *  unique `id` (lowercase, no spaces) and update the details. It will appear
 *  at  product.html?id=<your-id>  and in the product listings automatically.
 *
 *  To add a new product line (e.g. a future Macma appliance), add it to
 *  `categories`, add any new `types`, then add products with that category.
 *
 *  ⚠ PLACEHOLDER DATA: model numbers, specifications, features and warranty
 *    terms below are realistic examples only. Replace them with the official
 *    Macma figures before the site goes live.
 * ==========================================================================
 */
window.CATALOG = {
  brand: 'Macma',

  categories: [
    { id: 'air-conditioners', name: 'Air conditioners' }
  ],

  types: {
    'wall-split': 'Wall-mounted split',
    'cassette': 'Ceiling cassette'
  },

  // Shared feature descriptions. Each product lists the keys it supports.
  // `icon` refers to a name in js/icons.js.
  features: {
    inverter: {
      icon: 'wave',
      title: 'Full DC inverter',
      text: 'The compressor speeds up and slows down to hold your set temperature, using far less power than a fixed-speed unit.'
    },
    tropical: {
      icon: 'thermometer',
      title: 'Tropical-rated compressor',
      text: 'Keeps cooling at outdoor temperatures up to 52 °C, so it copes with the hottest Sri Lankan afternoons.'
    },
    goldfin: {
      icon: 'shield',
      title: 'Gold Fin anti-corrosion',
      text: 'A protective coating on the condenser fins resists salt air and humidity, which makes it a good fit for coastal homes.'
    },
    voltage: {
      icon: 'bolt',
      title: 'Wide-voltage operation',
      text: 'Runs steadily anywhere from 150 V to 260 V and protects itself from supply fluctuations.'
    },
    autorestart: {
      icon: 'power',
      title: 'Auto restart',
      text: 'After a power cut it switches itself back on with your last settings.'
    },
    quiet: {
      icon: 'volume',
      title: 'Quiet indoor unit',
      text: 'Low fan speeds and a balanced fan keep the indoor unit barely audible at night.'
    },
    sleep: {
      icon: 'moon',
      title: 'Sleep mode',
      text: 'Eases the temperature up gradually overnight for comfortable, uninterrupted sleep.'
    },
    turbo: {
      icon: 'gauge',
      title: 'Turbo cooling',
      text: 'Runs at full output for a short burst to bring a hot room down to temperature quickly.'
    },
    selfclean: {
      icon: 'sparkle',
      title: 'Self-clean',
      text: 'Dries the indoor coil after use to help keep mould and odours away.'
    },
    filter: {
      icon: 'layers',
      title: 'Multi-layer filtration',
      text: 'A washable dust filter plus a fine filter that traps smaller airborne particles.'
    },
    dehumidify: {
      icon: 'droplet',
      title: 'Dry mode',
      text: 'Pulls excess moisture from the air on humid, rainy days without over-cooling the room.'
    },
    r32: {
      icon: 'leaf',
      title: 'R32 refrigerant',
      text: 'Roughly one-third the global-warming potential of the older R410A refrigerant.'
    },
    wifi: {
      icon: 'wifi',
      title: 'Wi-Fi control',
      text: 'Switch on, change modes and set schedules from your phone, at home or on the way back.'
    },
    airflow360: {
      icon: 'wind',
      title: '360° airflow',
      text: 'Four-way louvres spread air evenly across large rooms, without a cold spot under the unit.'
    },
    pump: {
      icon: 'droplet',
      title: 'Built-in drain pump',
      text: 'Lifts condensate up to 750 mm, giving more freedom on ceiling layouts.'
    },
    wired: {
      icon: 'remote',
      title: 'Wired and wireless control',
      text: 'Works with a wall-mounted wired controller as well as the handheld remote.'
    }
  },

  products: [
    /* ------------------------------------------------------------------ */
    {
      id: 'aero',
      category: 'air-conditioners',
      type: 'wall-split',
      name: 'Macma Aero',
      fullName: 'Macma Aero Inverter',
      tagline: 'Everyday inverter cooling for bedrooms and living rooms.',
      description: 'Aero is the core of the Macma range: a full DC inverter split that cools quickly, runs quietly and keeps electricity bills in check. Its tropical-rated compressor and Gold Fin condenser are built for Sri Lanka’s heat, humidity and salt air.',
      badges: ['New'],
      image: { src: 'assets/img/products/aero-indoor.svg', alt: 'Macma Aero wall-mounted indoor unit in white' },
      gallery: [
        { src: 'assets/img/products/aero-indoor.svg', alt: 'Macma Aero indoor unit', label: 'Indoor unit' },
        { src: 'assets/img/products/outdoor-unit.svg', alt: 'Macma Aero outdoor unit', label: 'Outdoor unit' },
        { src: 'assets/img/products/remote.svg', alt: 'Macma wireless remote control', label: 'Remote' }
      ],
      highlights: [
        'Full DC inverter compressor',
        'Cools at outdoor temperatures up to 52 °C',
        'Gold Fin anti-corrosion condenser',
        'Sleep-mode noise from 22 dB(A)'
      ],
      features: ['inverter', 'tropical', 'goldfin', 'voltage', 'autorestart', 'quiet', 'turbo', 'selfclean', 'dehumidify', 'r32'],
      inTheBox: ['Indoor unit', 'Outdoor unit', 'Wireless remote and batteries', 'Wall-mounting plate', 'User manual'],
      warranty: [
        { label: 'Compressor', value: '10 years' },
        { label: 'Parts', value: '3 years' },
        { label: 'Service', value: '1 year' }
      ],
      downloads: [],
      // Spec rows shown next to the model number at the top of the product page.
      keySpecs: ['Cooling capacity', 'Recommended room size', 'Energy efficiency (EER)'],
      common: {
        'Power supply': '220–240 V, 50 Hz, single-phase',
        'Operating voltage range': '150 – 260 V',
        'Refrigerant': 'R32',
        'Outdoor operating range': '16 – 52 °C'
      },
      variants: [
        {
          model: 'MAC-AE09',
          btu: 9000,
          specs: {
            'Cooling capacity': '9,000 BTU/h (2.64 kW)',
            'Recommended room size': 'Up to 150 sq ft',
            'Rated power input': '780 W',
            'Energy efficiency (EER)': '3.38 W/W',
            'Indoor noise (H / M / L / Sleep)': '38 / 34 / 28 / 22 dB(A)',
            'Indoor airflow (max)': '520 m³/h',
            'Indoor unit (W × H × D)': '715 × 285 × 194 mm',
            'Indoor unit weight': '7.5 kg',
            'Outdoor unit (W × H × D)': '660 × 482 × 240 mm',
            'Outdoor unit weight': '21 kg',
            'Pipe size (liquid / gas)': '1/4" / 3/8"'
          }
        },
        {
          model: 'MAC-AE12',
          btu: 12000,
          specs: {
            'Cooling capacity': '12,000 BTU/h (3.52 kW)',
            'Recommended room size': '150 – 250 sq ft',
            'Rated power input': '1,050 W',
            'Energy efficiency (EER)': '3.35 W/W',
            'Indoor noise (H / M / L / Sleep)': '40 / 35 / 29 / 23 dB(A)',
            'Indoor airflow (max)': '600 m³/h',
            'Indoor unit (W × H × D)': '805 × 285 × 194 mm',
            'Indoor unit weight': '8.6 kg',
            'Outdoor unit (W × H × D)': '720 × 495 × 270 mm',
            'Outdoor unit weight': '24.5 kg',
            'Pipe size (liquid / gas)': '1/4" / 3/8"'
          }
        },
        {
          model: 'MAC-AE18',
          btu: 18000,
          specs: {
            'Cooling capacity': '18,000 BTU/h (5.28 kW)',
            'Recommended room size': '250 – 350 sq ft',
            'Rated power input': '1,600 W',
            'Energy efficiency (EER)': '3.30 W/W',
            'Indoor noise (H / M / L / Sleep)': '43 / 38 / 32 / 26 dB(A)',
            'Indoor airflow (max)': '850 m³/h',
            'Indoor unit (W × H × D)': '957 × 302 × 213 mm',
            'Indoor unit weight': '11.2 kg',
            'Outdoor unit (W × H × D)': '805 × 554 × 330 mm',
            'Outdoor unit weight': '33 kg',
            'Pipe size (liquid / gas)': '1/4" / 1/2"'
          }
        },
        {
          model: 'MAC-AE24',
          btu: 24000,
          specs: {
            'Cooling capacity': '24,000 BTU/h (7.03 kW)',
            'Recommended room size': '350 – 450 sq ft',
            'Rated power input': '2,150 W',
            'Energy efficiency (EER)': '3.27 W/W',
            'Indoor noise (H / M / L / Sleep)': '45 / 40 / 34 / 28 dB(A)',
            'Indoor airflow (max)': '1,100 m³/h',
            'Indoor unit (W × H × D)': '1,040 × 327 × 220 mm',
            'Indoor unit weight': '13.5 kg',
            'Outdoor unit (W × H × D)': '890 × 673 × 342 mm',
            'Outdoor unit weight': '45 kg',
            'Pipe size (liquid / gas)': '3/8" / 5/8"'
          }
        }
      ]
    },

    /* ------------------------------------------------------------------ */
    {
      id: 'prime',
      category: 'air-conditioners',
      type: 'wall-split',
      name: 'Macma Prime',
      fullName: 'Macma Prime Wi-Fi Inverter',
      tagline: 'Our quietest, most efficient split, with Wi-Fi built in.',
      description: 'Prime builds on everything in Aero: a higher-efficiency inverter, a near-silent 20 dB(A) sleep mode, a graphite front panel and built-in Wi-Fi, so the room can be cool before you get home.',
      badges: ['New', 'Wi-Fi'],
      image: { src: 'assets/img/products/prime-indoor.svg', alt: 'Macma Prime wall-mounted indoor unit with graphite front panel' },
      gallery: [
        { src: 'assets/img/products/prime-indoor.svg', alt: 'Macma Prime indoor unit', label: 'Indoor unit' },
        { src: 'assets/img/products/outdoor-unit.svg', alt: 'Macma Prime outdoor unit', label: 'Outdoor unit' },
        { src: 'assets/img/products/remote.svg', alt: 'Macma wireless remote control', label: 'Remote' }
      ],
      highlights: [
        'High-efficiency inverter, EER up to 3.67',
        'Built-in Wi-Fi with phone control',
        'Sleep-mode noise from 20 dB(A)',
        'Gold Fin condenser for coastal areas'
      ],
      features: ['inverter', 'wifi', 'quiet', 'sleep', 'tropical', 'goldfin', 'voltage', 'autorestart', 'selfclean', 'filter', 'r32'],
      inTheBox: ['Indoor unit', 'Outdoor unit', 'Wireless remote and batteries', 'Wall-mounting plate', 'Wi-Fi setup guide', 'User manual'],
      warranty: [
        { label: 'Compressor', value: '10 years' },
        { label: 'Parts', value: '3 years' },
        { label: 'Service', value: '1 year' }
      ],
      downloads: [],
      // Spec rows shown next to the model number at the top of the product page.
      keySpecs: ['Cooling capacity', 'Recommended room size', 'Energy efficiency (EER)'],
      common: {
        'Power supply': '220–240 V, 50 Hz, single-phase',
        'Operating voltage range': '150 – 260 V',
        'Refrigerant': 'R32',
        'Outdoor operating range': '16 – 52 °C',
        'Wi-Fi': 'Built in (2.4 GHz)'
      },
      variants: [
        {
          model: 'MAC-PR12',
          btu: 12000,
          specs: {
            'Cooling capacity': '12,000 BTU/h (3.52 kW)',
            'Recommended room size': '150 – 250 sq ft',
            'Rated power input': '960 W',
            'Energy efficiency (EER)': '3.67 W/W',
            'Indoor noise (H / M / L / Sleep)': '38 / 33 / 26 / 20 dB(A)',
            'Indoor airflow (max)': '650 m³/h',
            'Indoor unit (W × H × D)': '835 × 295 × 208 mm',
            'Indoor unit weight': '9.4 kg',
            'Outdoor unit (W × H × D)': '765 × 555 × 303 mm',
            'Outdoor unit weight': '27 kg',
            'Pipe size (liquid / gas)': '1/4" / 3/8"'
          }
        },
        {
          model: 'MAC-PR18',
          btu: 18000,
          specs: {
            'Cooling capacity': '18,000 BTU/h (5.28 kW)',
            'Recommended room size': '250 – 350 sq ft',
            'Rated power input': '1,450 W',
            'Energy efficiency (EER)': '3.64 W/W',
            'Indoor noise (H / M / L / Sleep)': '41 / 36 / 30 / 24 dB(A)',
            'Indoor airflow (max)': '900 m³/h',
            'Indoor unit (W × H × D)': '968 × 315 × 230 mm',
            'Indoor unit weight': '12.3 kg',
            'Outdoor unit (W × H × D)': '820 × 614 × 330 mm',
            'Outdoor unit weight': '36.5 kg',
            'Pipe size (liquid / gas)': '1/4" / 1/2"'
          }
        },
        {
          model: 'MAC-PR24',
          btu: 24000,
          specs: {
            'Cooling capacity': '24,000 BTU/h (7.03 kW)',
            'Recommended room size': '350 – 450 sq ft',
            'Rated power input': '1,950 W',
            'Energy efficiency (EER)': '3.61 W/W',
            'Indoor noise (H / M / L / Sleep)': '44 / 39 / 33 / 26 dB(A)',
            'Indoor airflow (max)': '1,150 m³/h',
            'Indoor unit (W × H × D)': '1,082 × 330 × 233 mm',
            'Indoor unit weight': '14.8 kg',
            'Outdoor unit (W × H × D)': '890 × 673 × 342 mm',
            'Outdoor unit weight': '46 kg',
            'Pipe size (liquid / gas)': '3/8" / 5/8"'
          }
        }
      ]
    },

    /* ------------------------------------------------------------------ */
    {
      id: 'cassette',
      category: 'air-conditioners',
      type: 'cassette',
      name: 'Macma Cassette',
      fullName: 'Macma 4-Way Cassette Inverter',
      tagline: 'Even, out-of-sight cooling for shops, offices and open-plan spaces.',
      description: 'The Macma 4-way cassette sits flush in the ceiling and sends air out in every direction, keeping larger rooms evenly cool without a unit on the wall. A built-in drain pump and wired-controller support make it easy to design into commercial fit-outs.',
      badges: ['Commercial'],
      image: { src: 'assets/img/products/cassette.svg', alt: 'Macma four-way ceiling cassette panel' },
      gallery: [
        { src: 'assets/img/products/cassette.svg', alt: 'Macma cassette ceiling panel', label: 'Ceiling panel' },
        { src: 'assets/img/products/outdoor-unit.svg', alt: 'Macma cassette outdoor unit', label: 'Outdoor unit' },
        { src: 'assets/img/products/remote.svg', alt: 'Macma wireless remote control', label: 'Remote' }
      ],
      highlights: [
        '360° four-way airflow',
        'Slim 950 × 950 mm ceiling panel',
        'Built-in condensate drain pump',
        'Wired and wireless control'
      ],
      features: ['airflow360', 'inverter', 'pump', 'wired', 'tropical', 'goldfin', 'autorestart', 'r32'],
      inTheBox: ['Indoor cassette body', 'Ceiling panel', 'Outdoor unit', 'Wireless remote and batteries', 'Installation template', 'User manual'],
      warranty: [
        { label: 'Compressor', value: '5 years' },
        { label: 'Parts', value: '2 years' },
        { label: 'Service', value: '1 year' }
      ],
      downloads: [],
      // Spec rows shown next to the model number at the top of the product page.
      keySpecs: ['Cooling capacity', 'Recommended room size', 'Energy efficiency (EER)'],
      common: {
        'Ceiling panel (W × H × D)': '950 × 55 × 950 mm',
        'Refrigerant': 'R32',
        'Outdoor operating range': '16 – 52 °C'
      },
      variants: [
        {
          model: 'MAC-CS24',
          btu: 24000,
          specs: {
            'Cooling capacity': '24,000 BTU/h (7.03 kW)',
            'Recommended room size': '350 – 450 sq ft',
            'Rated power input': '2,200 W',
            'Energy efficiency (EER)': '3.20 W/W',
            'Indoor noise (H / M / L)': '42 / 38 / 35 dB(A)',
            'Indoor airflow (max)': '1,200 m³/h',
            'Indoor body (W × H × D)': '840 × 240 × 840 mm',
            'Indoor unit weight': '24 kg',
            'Outdoor unit (W × H × D)': '890 × 673 × 342 mm',
            'Outdoor unit weight': '46 kg',
            'Power supply': '220–240 V, 50 Hz, single-phase',
            'Pipe size (liquid / gas)': '3/8" / 5/8"'
          }
        },
        {
          model: 'MAC-CS36',
          btu: 36000,
          specs: {
            'Cooling capacity': '36,000 BTU/h (10.55 kW)',
            'Recommended room size': '450 – 700 sq ft',
            'Rated power input': '3,400 W',
            'Energy efficiency (EER)': '3.10 W/W',
            'Indoor noise (H / M / L)': '46 / 42 / 38 dB(A)',
            'Indoor airflow (max)': '1,700 m³/h',
            'Indoor body (W × H × D)': '840 × 290 × 840 mm',
            'Indoor unit weight': '28 kg',
            'Outdoor unit (W × H × D)': '946 × 810 × 410 mm',
            'Outdoor unit weight': '68 kg',
            'Power supply': '220–240 V, 50 Hz, single-phase',
            'Pipe size (liquid / gas)': '3/8" / 3/4"'
          }
        },
        {
          model: 'MAC-CS48',
          btu: 48000,
          specs: {
            'Cooling capacity': '48,000 BTU/h (14.07 kW)',
            'Recommended room size': '700 – 900 sq ft',
            'Rated power input': '4,600 W',
            'Energy efficiency (EER)': '3.06 W/W',
            'Indoor noise (H / M / L)': '48 / 44 / 40 dB(A)',
            'Indoor airflow (max)': '2,000 m³/h',
            'Indoor body (W × H × D)': '840 × 290 × 840 mm',
            'Indoor unit weight': '30 kg',
            'Outdoor unit (W × H × D)': '952 × 1,333 × 415 mm',
            'Outdoor unit weight': '98 kg',
            'Power supply': '380–415 V, 50 Hz, three-phase',
            'Pipe size (liquid / gas)': '3/8" / 3/4"'
          }
        }
      ]
    }
  ]
};
