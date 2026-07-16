# Bolly hero section — WordPress + Elementor

Recreates the "Knock Out Flakes" hero (header, headline, tagline, CTA) with
an interactive 3D shampoo bottle in place of the static product photo.

## Files

| File | Purpose |
|---|---|
| `functions-snippet.php` | Registers the `[bolly_hero]` **shortcode** and enqueues the CSS/JS correctly as WP assets |
| `template-parts/hero.php` | The actual markup, rendered by the shortcode (edit here, not in the HTML widget copy) |
| `section-hero.html` | Same markup as a static file, for pasting straight into an Elementor **HTML** widget if you'd rather not use the shortcode |
| `assets/css/style.css` | All layout/visual styling, responsive down to 320px |
| `assets/js/bottle-viewer.js` | Three.js viewer — drag/swipe to rotate the bottle |
| `assets/models/` | Drop your `bolly-bottle.glb` here once you have one |

## Setup on your WordPress machine

1. **Copy the folder.** Put `bolly-landing-page/` inside your active theme
   (e.g. `wp-content/themes/your-theme/bolly-landing-page/`). If your theme
   is a child theme, `get_stylesheet_directory_uri()` in the snippet already
   points at the child theme, so this just works.

2. **Wire up the shortcode + assets.** Open your theme's `functions.php` and
   paste in the contents of `functions-snippet.php`. This registers a
   `[bolly_hero]` shortcode and enqueues `style.css` and `bottle-viewer.js`
   (as an ES module, required for the `import` statements) as real WP
   assets rather than inlining them in a widget.

3. **Build the section in Elementor** — two ways to do this, pick one:

   **Option A — Shortcode widget (recommended).** Add a full-width
   **Section**, remove default padding (the CSS already handles spacing via
   `.bolly-hero`), drop in Elementor's **Shortcode** widget, and enter:
   ```
   [bolly_hero]
   ```
   This is the cleaner integration — the markup lives in one place
   (`template-parts/hero.php`), so editing it updates every page that uses
   the shortcode. To point at a specific model without editing PHP:
   ```
   [bolly_hero model_url="https://yoursite.com/wp-content/uploads/bolly-bottle.glb"]
   ```

   **Option B — raw HTML widget.** Add the same full-width Section, drop in
   an **HTML** widget instead, and paste the full contents of
   `section-hero.html`. Simpler to reason about since it's just markup on
   the page, but you're maintaining two copies of the HTML if you also use
   the shortcode elsewhere.

   Either way: save and preview — the layout, colors, and type should match
   the reference design immediately; the bottle viewer will show a spinner
   briefly, then fall back to a placeholder bottle (see below) since no
   `.glb` is wired up yet.

4. **Add your 3D model when it's ready.**
   - Export/convert your bottle to `.glb` (glTF binary — Blender's built-in
     glTF exporter or an online converter both work).
   - Upload it to the Media Library, or drop it straight into
     `assets/models/bolly-bottle.glb`.
   - Point the viewer at it: if you're using the shortcode, add
     `model_url="..."` to `[bolly_hero]` (Media Library gives you a direct
     URL — use that); if you're using the HTML widget, update
     `data-model-url` on the `.bolly-viewer` element in `section-hero.html`
     instead.
   - Reload the page. `bottle-viewer.js` auto-centers and auto-scales
     whatever model it finds, so no code changes should be needed for a
     reasonably-sized single-mesh export.
   - If the model looks too dark/bright or oddly colored, that's almost
     always a materials/export issue from the 3D tool, not the viewer —
     check the glTF export settings (metallic/roughness workflow, baked
     textures) before touching the lighting in `bottle-viewer.js`.

## How the 3D interaction works

- `bottle-viewer.js` uses `OrbitControls` from Three.js, which natively
  supports **mouse-drag rotation on desktop** and **one-finger touch-drag
  rotation on mobile** — no custom gesture code needed.
- Zoom and pan are disabled (`enableZoom`/`enablePan = false`) so the
  interaction stays a pure "spin the product" gesture and doesn't fight
  page scroll on mobile. `touch-action: none` on the container (in
  `style.css`) is what stops the browser from intercepting the swipe as a
  page scroll instead of a rotate.
- The bottle auto-rotates slowly until the visitor touches/drags it, then
  stops, matching the "hero product shot" feel from the reference design.
- Until a real `.glb` is present, `createPlaceholder()` in
  `bottle-viewer.js` builds a simple procedural bottle (cylinder body +
  cap + pump) in the right purple tone, so the section is never blank —
  delete that fallback once a real model is confirmed working if you'd
  rather fail loudly on a broken path.

## Responsiveness

Breakpoints in `style.css`: desktop (3-column grid: headline / bottle /
tagline), tablet at `1024px` (stacks to a single centered column, bottle
first), mobile at `640px`, and a final tightening pass at `360px` so
320px-wide devices don't clip or scroll horizontally. All type sizes use
`clamp()` instead of fixed breakpoint jumps.

Test in Elementor's built-in responsive preview (desktop/tablet/mobile
icons in the bottom toolbar) plus your browser's device toolbar at exactly
320px width to confirm no horizontal scrollbar appears.

## Customizing to match your brand assets exactly

Colors, spacing units, and font stacks are all CSS custom properties /
`clamp()` values at the top of `.bolly-hero` in `style.css` — adjust
`--bolly-purple`, `--bolly-lime`, `--bolly-ink`, etc. there rather than
hunting through individual rules.
