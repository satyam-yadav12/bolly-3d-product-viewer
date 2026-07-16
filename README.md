# Bolly Landing 3D Page

A lightweight WordPress plugin-style hero section that renders an Elementor-ready landing page block with a rotating 3D shampoo bottle.

## Overview

- Uses a shortcode to output hero markup from `template-parts/hero.php`.
- Loads `assets/css/style.css` for layout and responsive styling.
- Loads `assets/js/bottle-viewer.js` to render a touch-friendly Three.js bottle viewer.
- Supports a fallback placeholder bottle until a real `.glb` model is provided.

## Setup

1. Copy the plugin folder into your WordPress installation, typically under `wp-content/plugins/bolly-landing-3d-page`.
2. Add the contents of `functions-snippet.php` to your theme or child theme `functions.php` to register the shortcode and enqueue the CSS/JS assets.
3. Use Elementor to place the hero section:
   - Recommended: add an Elementor **Shortcode** widget and insert:
     ```
     [bolly_hero]
     ```
   - Optional: paste `section-hero.html` into an Elementor **HTML** widget.
4. Upload your 3D bottle `.glb` model and set `model_url` on the shortcode if needed:
   ```
   [bolly_hero model_url="https://example.com/wp-content/uploads/bolly-bottle.glb"]
   ```

## Files

- `functions-snippet.php` — shortcode registration and WP asset enqueue logic.
- `template-parts/hero.php` — hero section markup rendered by `[bolly_hero]`.
- `section-hero.html` — static HTML version for Elementor HTML widgets.
- `assets/css/style.css` — hero styling and responsive layout rules.
- `assets/js/bottle-viewer.js` — Three.js viewer with drag/swipe rotation.
- `assets/models/` — place a `bolly-bottle.glb` model here if using a local asset.

## Shortcode

- Basic usage:
  ```
  [bolly_hero]
  ```
- With a custom model URL:
  ```
  [bolly_hero model_url="https://example.com/wp-content/uploads/bolly-bottle.glb"]
  ```
- The shortcode renders the hero markup and enqueues the required styles and scripts.

## Responsiveness

- Designed for desktop, tablet, and mobile.
- Desktop uses a split layout with headline, 3D viewer, and tagline content.
- Tablet and mobile stack the content vertically while preserving spacing and readability.
- CSS uses fluid sizing and clamp-based type scaling to avoid hard jumps and horizontal overflow.

## Run steps

1. Install or move the folder into WordPress.
2. Register the shortcode via `functions-snippet.php`.
3. Add `[bolly_hero]` in Elementor or use the HTML file.
4. Upload the `.glb` model and optionally pass `model_url`.
5. Preview on desktop and mobile to confirm layout and interaction.
