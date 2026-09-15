# Ayan Modern Theme — Installation Guide

## Package Contents

Ayan Modern **2.0.0** is a full-site editing block theme:

- Ink & Signal editorial design (image-led post rows, full-bleed covers)
- Self-hosted Syne + Source Sans 3 typography
- Block templates, template parts, and patterns
- Featured post + reading time meta (block editor panel)
- Reading progress, sticky header, share/copy link (front-end JS)

## Requirements

- WordPress **6.4+** (6.6 recommended)
- PHP **7.4+**
- Node.js **18+** only if building from source

## Installation

### WordPress admin upload

1. Build assets locally (see below) or use a pre-built release zip.
2. Appearance → Themes → Add New → Upload Theme
3. Choose `ayan-modern-2.0.0.zip`
4. Activate **Ayan Modern**

### Docker dev stack

```bash
make start
cd themes/ayan-modern && npm install && npm run build
```

Visit http://localhost:8000 and activate the theme.

## Build from source

```bash
cd themes/ayan-modern
npm install
npm run build
```

Outputs:

- `assets/css/theme.css`
- `assets/js/theme.js`
- `assets/js/editor.js`

Re-run after editing `assets/scss/` or `assets/js/src/`.

## Initial setup

### 1. Site identity

Appearance → Editor → Template Parts → **Header**

- Set site title / tagline / logo
- Assign **Primary Menu** to the Navigation block

### 2. Footer

Appearance → Editor → Template Parts → **Footer**

- Assign **Footer Menu**
- Update Social Links URLs (X, GitHub, LinkedIn)

### 3. Home page

- Settings → Reading → “Your homepage displays” → **Your latest posts** (or assign the Home template to a static front page)
- Edit the **Home** template to adjust hero copy and query sections

### 4. Featured posts

Edit any post → Document sidebar → **Post Options**:

- **Mark as featured post** — surfaces in the home featured cover query
- **Reading time** — optional override (auto-calculated when empty)

### 5. Legacy Customizer import

If upgrading from Ayan Modern 1.x, welcome text and social URLs from the old Customizer are imported **once** on theme activation. Confirm values in the Site Editor afterward.

## File structure

```
ayan-modern/
├── theme.json
├── style.css              # Theme header only
├── functions.php
├── index.php              # Required stub
├── templates/             # Block templates (.html)
├── parts/                 # Header + footer
├── patterns/              # File-based block patterns
├── assets/
│   ├── css/theme.css      # Built styles
│   ├── js/theme.js        # Front-end JS
│   ├── js/editor.js       # Editor panel
│   ├── scss/              # Source styles
│   └── fonts/             # Self-hosted woff2
└── inc/                   # PHP bridges (meta, query, schema)
```

## Translations

See `languages/README.md` for POT generation with WP-CLI.

## Manual QA checklist (Docker)

- [ ] Home: featured cover, welcome, post rows
- [ ] Single: full-bleed image, reading time, share, related, comments
- [ ] Archive, search, 404
- [ ] Mobile navigation overlay
- [ ] Skip link targets `#wp--skip-link--target`
- [ ] Featured post meta in editor
- [ ] Site Editor edits persist for header/footer
- [ ] Reduced motion: no scale/scroll animations
- [ ] Dark mode (OS preference)

## License

MIT — see `LICENSE`.

**Version:** 2.0.0  
**Author:** Ayan Ozturk
