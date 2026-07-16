<?php

define( 'BOLLY_ASSET_VERSION', '1.0.0' );

add_shortcode( 'bolly_hero', 'bolly_hero_shortcode' );

function bolly_hero_shortcode( $raw_atts = array() ) {
	$atts = shortcode_atts(
		array(
			'model_url' => plugin_dir_url( __FILE__ ).'assets/models/shampoo_bottle.glb',
		),
		$raw_atts,
		'bolly_hero'
	);

	ob_start();
	include __DIR__ . '/template-parts/hero.php';
	return ob_get_clean();
}


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
		true
	);
} );

add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if ( 'bolly-bottle-viewer' === $handle ) {
		$tag = str_replace( ' src=', ' type="module" src=', $tag );
	}
	return $tag;
}, 10, 2 );
