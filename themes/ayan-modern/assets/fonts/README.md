# Self-hosted fonts (OFL)

This theme loads **Syne** (display) and **Source Sans 3** (body) via `theme.json` `fontFace`, not Google Fonts.

## Expected files

| Path | Role |
|------|------|
| `syne/Syne-Variable.woff2` | Syne variable (wght 400–800) |
| `source-sans-3/SourceSans3-Variable.woff2` | Source Sans 3 roman variable |
| `source-sans-3/SourceSans3-Italic-Variable.woff2` | Source Sans 3 italic variable |

These paths are referenced from [`theme.json`](../../theme.json).

## License

Both families are licensed under the [SIL Open Font License 1.1](https://scripts.sil.org/OFL).

- Syne — [github.com/BonneMaman/Syne](https://github.com/BonneMaman/Syne) / Google Fonts OFL
- Source Sans 3 — Adobe / [github.com/adobe-fonts/source-sans](https://github.com/adobe-fonts/source-sans)

## Re-download (if missing)

From this directory:

```bash
mkdir -p syne source-sans-3
curl -fsSL -o syne/Syne-Variable.woff2 \
  "https://unpkg.com/@fontsource-variable/syne@5.2.5/files/syne-latin-wght-normal.woff2"
curl -fsSL -o source-sans-3/SourceSans3-Variable.woff2 \
  "https://unpkg.com/@fontsource-variable/source-sans-3@5.2.8/files/source-sans-3-latin-wght-normal.woff2"
curl -fsSL -o source-sans-3/SourceSans3-Italic-Variable.woff2 \
  "https://unpkg.com/@fontsource-variable/source-sans-3@5.2.8/files/source-sans-3-latin-wght-italic.woff2"
```

Alternatively, download from [Fontsource](https://fontsource.org/) or [Google Fonts GitHub (OFL)](https://github.com/google/fonts) and place woff2 files at the paths above.
