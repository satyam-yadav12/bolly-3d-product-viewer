<?php
/**
 * Hero section markup, included (via output buffering) by the
 * [bolly_hero] shortcode in functions-snippet.php. $atts is in scope
 * from the calling function — do not access this file directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="bolly-hero">
	<div class="bolly-hero__card">

		<header class="bolly-header">
			<a class="bolly-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">bolly</a>

			<nav class="bolly-nav">
				<a href="/shop" class="bolly-nav__pill">Shop <span class="plus">+</span></a>
				<a href="/about">About</a>
				<a href="/blog">Blog</a>
				<a href="/contact">Contact</a>
			</nav>

			<a href="/cart" class="bolly-cart">
				<span class="bolly-cart__label">Cart</span>
				<span class="bolly-cart__icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M6 7h12l-1 13H7L6 7Z" />
						<path d="M9 7a3 3 0 0 1 6 0" />
					</svg>
				</span>
			</a>
		</header>

		<div class="bolly-hero__body">

			<div class="bolly-hero__left">
				<p class="bolly-badge"><span>FROM ROOT</span><em>TO SHINE</em></p>
				<h1 class="bolly-headline">KNOCK<br />OUT<br />FLAKES</h1>
			</div>

			<div class="bolly-hero__center">
				<div class="bolly-viewer-glow" aria-hidden="true"></div>
				<div
					class="bolly-viewer is-loading"
					data-bolly-viewer
					data-model-url="<?php echo esc_url( $atts['model_url'] ); ?>"
					role="img"
					aria-label="Rotatable 3D preview of the Bolly Clarify Shampoo bottle. Drag or swipe to rotate."
				></div>
			</div>

			<div class="bolly-hero__right">
				<p class="bolly-tagline">Journey in to the <em>wonderful</em> world of shampoo</p>
				<a href="/shop" class="bolly-cta">
					<span>EXPLORE MORE</span>
					<span class="bolly-cta__arrow" aria-hidden="true">
						<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5">
							<path d="M7 17 17 7M9 7h8v8" />
						</svg>
					</span>
				</a>
			</div>

		</div>
	</div>
</section>
