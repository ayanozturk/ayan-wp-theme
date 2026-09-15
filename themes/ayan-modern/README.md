# Ayan Modern

Ink & Signal — a full-site editing block theme for personal-brand editorial sites.

## Build

```bash
npm install
npm run build
```

## Key paths

| Path | Purpose |
|------|---------|
| `theme.json` | Design tokens and block styles |
| `templates/` | Block templates |
| `parts/` | Header and footer template parts |
| `patterns/` | Reusable block patterns |
| `assets/scss/` | Source styles → `assets/css/theme.css` |
| `assets/js/src/main.js` | Front-end interactions |
| `assets/js/src/editor.js` | Post Options document panel |
| `inc/` | Meta, bindings, query filters, schema |

## Patterns

- `ayan-modern/featured-query` — featured post full-bleed cover
- `ayan-modern/hero-home` — welcome line + CTA
- `ayan-modern/post-row` — image-led archive rows
- `ayan-modern/related-posts` — same-category related items
- `ayan-modern/share-row` — X / LinkedIn / copy link
- `ayan-modern/callout` — signal-border callout

## Post meta

| Meta key | Purpose |
|----------|---------|
| `_featured_post` | `"1"` when post is featured on home |
| `_reading_time` | Manual minutes override (0 = auto) |

Registered for REST and edited via the block editor **Post Options** panel.

## Packaging

From repo root: `make package` (runs build, then zips).
