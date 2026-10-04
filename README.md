# WordPress Development Environment

A Docker-based WordPress development environment with the **Ayan Modern** full-site editing block theme. The theme requires WordPress 6.6 or newer and PHP 8.2 or newer.

## Quick Start

1. **Start the environment:**
   ```bash
   make start
   ```

2. **Build theme assets:**
   ```bash
   cd themes/ayan-modern
   npm ci
   npm run build
   ```

3. **Access WordPress:**
   - Site: http://localhost:8000
   - phpMyAdmin: http://localhost:8081

4. **Activate the theme** under Appearance → Themes, then customize header/footer in **Appearance → Editor**.

## Ayan Modern (v2.0.5)

Ink & Signal is a block theme using:

- `theme.json` design tokens (Syne + Source Sans 3, self-hosted)
- HTML templates in `templates/` and `parts/`
- File-based patterns in `patterns/`
- Built assets: `assets/css/theme.css`, `assets/js/theme.js`, `assets/js/editor.js`

### Build commands

From `themes/ayan-modern/`:

```bash
npm ci           # clean install from package-lock.json
npm run build    # production build
npm start        # watch mode during development
```

Run `npm run build` before packaging or deploying — the zip must include compiled CSS/JS.

### Site Editor workflow

- **Header / footer:** Appearance → Editor → Template Parts
- **Navigation:** the starter header lists published pages automatically; customize it under Appearance → Editor → Navigation
- **Home layout:** edit `Home` template or swap patterns (`Featured Query`, `Hero Home`, `Post Row`)
- **Featured posts:** open a post → Document sidebar → Post Options → “Mark as featured post”
- **Reading time:** set manually or leave empty for auto word-count calculation

On first activation, legacy Customizer welcome text and social URLs are imported once into template content when possible.

## Directory Structure

```
ayan-wp-theme/
├── docker-compose.yml
├── Makefile
├── themes/
│   └── ayan-modern/     # Block theme (FSE)
├── plugins/
└── uploads/
```

## Makefile Helpers

From the repository root:

```bash
make show-version   # Print theme version from style.css
make package        # npm build + zip current version
make bump-patch     # Patch bump, commit, build, zip
make bump-minor     # Minor bump, commit, build, zip
make bump-major     # Major bump, commit, build, zip
```

Packages are written to `themes/ayan-modern-<version>.zip`.

## Troubleshooting

- **Styles missing:** run `npm run build` inside `themes/ayan-modern/`
- **Port conflicts:** edit ports in `docker-compose.yml`
- **Reset environment:** `make reset` then `make start`

## Resources

- [Block theme handbook](https://developer.wordpress.org/themes/block-themes/)
- [theme.json reference](https://developer.wordpress.org/block-editor/reference-guides/theme-json-reference/)
