<?php
/**
 * Title: Hero with a photo
 * Slug: sashwell-lite/hero-photo
 * Categories: sashwell-lite, featured, banner
 * Keywords: hero, header, intro, photo, cleaning
 * Viewport Width: 1400
 * Description: Dark framed hero with the page heading, two buttons, a proof line and a photo with a small job note.
 *
 * @package Sashwell_Lite
 */

?>
<!-- wp:group {"tagName":"section","className":"swl-hero swl-hero--photo","layout":{"type":"default"}} -->
<section class="wp-block-group swl-hero swl-hero--photo"><!-- wp:group {"className":"swl-hero-panel","layout":{"type":"default"}} -->
<div class="wp-block-group swl-hero-panel"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%"><!-- wp:paragraph {"className":"swl-hero-kicker"} -->
<p class="swl-hero-kicker"><?php esc_html_e( 'House and office cleaning since 2014', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e( 'A clean home, written up', 'sashwell-lite' ); ?> <em><?php esc_html_e( 'line by line.', 'sashwell-lite' ); ?></em></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"swl-hero-lead"} -->
<p class="swl-hero-lead"><?php esc_html_e( 'Regular and deep cleans by the same vetted crew each visit. You get a job sheet with every room ticked off, and a clear price before we start.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Book a clean', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#prices"><?php esc_html_e( 'See prices', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"swl-hero-proof"} -->
<p class="swl-hero-proof"><strong><?php esc_html_e( '4.9 out of 5', 'sashwell-lite' ); ?></strong> <?php esc_html_e( 'from 1,280 reviews. Insured, DBS-checked crews.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%"><!-- wp:group {"className":"swl-hero-media","layout":{"type":"default"}} -->
<div class="wp-block-group swl-hero-media"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"swl-photo swl-photo--tall"} -->
<figure class="wp-block-image size-full swl-photo swl-photo--tall"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-mopping.webp' ) ); ?>" alt="<?php esc_attr_e( 'A cleaner mopping a long, bright stone corridor', 'sashwell-lite' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"swl-hero-note"} -->
<p class="swl-hero-note"><strong><?php esc_html_e( 'Corridor and lobby', 'sashwell-lite' ); ?></strong> <span><?php esc_html_e( 'Done 06:40, before the first tenant', 'sashwell-lite' ); ?></span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
