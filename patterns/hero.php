<?php
/**
 * Title: Hero with a job sheet
 * Slug: sashwell-lite/hero
 * Categories: sashwell-lite, featured, banner
 * Keywords: hero, header, intro, cleaning
 * Viewport Width: 1400
 * Description: Dark framed hero with the page heading, two buttons, a proof line and a ticked job sheet.
 *
 * @package Sashwell_Lite
 */

?>
<!-- wp:group {"tagName":"section","className":"swl-hero","layout":{"type":"default"}} -->
<section class="wp-block-group swl-hero"><!-- wp:group {"className":"swl-hero-panel","layout":{"type":"default"}} -->
<div class="wp-block-group swl-hero-panel"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%"><!-- wp:paragraph {"className":"swl-hero-kicker"} -->
<p class="swl-hero-kicker"><?php esc_html_e( 'Booking for next week in Didsbury and Chorlton', 'sashwell-lite' ); ?></p>
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

<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:group {"className":"swl-sheet","layout":{"type":"default"}} -->
<div class="wp-block-group swl-sheet"><!-- wp:paragraph {"className":"swl-sheet-top"} -->
<p class="swl-sheet-top"><strong><?php esc_html_e( 'Flat 4, Lapwing Lane', 'sashwell-lite' ); ?></strong> <span><?php esc_html_e( 'Tue 09:00, 2 cleaners', 'sashwell-lite' ); ?></span></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"swl-ticks"} -->
<ul class="wp-block-list swl-ticks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Kitchen: hob, oven door, sink and taps', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Bathroom: limescale off the screen', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Bedrooms: beds changed, floors vacuumed', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Living room: skirting boards and shelves', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"swl-sheet-foot"} -->
<p class="swl-sheet-foot"><span><?php esc_html_e( 'Done in 2 h 40 min', 'sashwell-lite' ); ?></span> <strong><?php esc_html_e( '£78', 'sashwell-lite' ); ?></strong></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
