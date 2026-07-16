<?php
/**
 * Bolly hero section — shortcode + asset enqueue.
 *
 * Paste this into your active theme's functions.php (or a small
 * site-specific plugin / mu-plugin, which survives theme switches).
 * Assumes bolly-landing-page/ was copied into the theme root — adjust
 * the paths below if you put it somewhere else.
 *
 * Usage: place [bolly_hero] in a page/post, or in an Elementor
 * "Shortcode" widget. Optional attribute:
 *   [bolly_hero model_url="https://yoursite.com/wp-content/uploads/bolly-bottle.glb"]
 */

define( 'BOLLY_ASSET_VERSION', '1.0.0' );

add_shortcode( 'bolly_hero', 'bolly_hero_shortcode' );

function bolly_hero_shortcode( $raw_atts = array() ) {
	$atts = shortcode_atts(
		array(
			'model_url' => plugin_dir_url( __FILE__ ) . 'models/shampoo_product_design.glb',
		),
		$raw_atts,
		'bolly_hero'
	);

	ob_start();
	include __DIR__ . '/template-parts/hero.php';
	return ob_get_clean();
}

/**
 * Enqueued unconditionally (on every page) so style.css is guaranteed
 * to land in <head> regardless of where [bolly_hero] ends up — a
 * shortcode's own callback runs too late in the request to safely
 * enqueue styles itself (wp_head has usually already printed by then).
 * It's one small stylesheet + one JS module, so this is cheap; narrow
 * it to specific pages with is_front_page() / is_page() if you'd
 * rather not load it sitewide.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'bolly-hero',
		plugin_dir_url( __FILE__ ) . 'assets/css/style.css',
		array(),
		BOLLY_ASSET_VERSION
	);

	wp_enqueue_script(
		'bolly-bottle-viewer',
		plugin_dir_url( __FILE__ ) . 'assets/js/bottle-viewer.js',
		array(),
		BOLLY_ASSET_VERSION,
		true // print in the footer
	);
} );

/**
 * bottle-viewer.js uses ES `import` statements, so the <script> tag
 * needs type="module" — wp_enqueue_script has no native option for
 * this pre-WP 6.5, so the tag is rewritten here.
 */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if ( 'bolly-bottle-viewer' === $handle ) {
		$tag = str_replace( ' src=', ' type="module" src=', $tag );
	}
	return $tag;
}, 10, 2 );
