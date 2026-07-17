# bolly-3d-product-viewer

A WordPress hero section featuring an interactive 3D shampoo bottle, built to integrate easily with Elementor.

## Features

- Interactive 3D bottle viewer powered by Three.js
- Elementor-compatible via shortcode
- Responsive layout for desktop, tablet, and mobile
- Supports custom `.glb` 3D models

## Installation

1. Copy the plugin folder to:
   ```
   wp-content/plugins/bolly-3d-product-viewer
   ```
2. Add a page in wordpress dashboard
3. Insert the shortcode into an Elementor **Shortcode** widget:
   ```
   [bolly_hero]
   ```

## Project Structure

```
assets/
├── css/
│   └── style.css
├── js/
│   └── bottle-viewer.js
├── models/
│   └── bolly-bottle.glb
bolly landing page.php
template-parts/
└── hero.php
```

## Shortcode

Default:

```text
[bolly_hero]
```

Custom model:

```text
[bolly_hero model_url="https://example.com/uploads/bolly-bottle.glb"]
```

## Tech Stack

- WordPress
- Elementor
- Three.js
- HTML
- CSS
- JavaScript
