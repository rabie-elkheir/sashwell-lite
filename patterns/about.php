<?php
/**
 * Title: About with photos
 * Slug: sashwell-lite/about
 * Categories: sashwell-lite, about
 * Keywords: about, story, team, photos
 * Viewport Width: 1400
 * Description: Two overlapping photos next to the company story, three ticked promises and a signature line.
 *
 * @package Sashwell_Lite
 */

?>
<!-- wp:group {"tagName":"section","className":"swl-sec swl-sec--mist","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec swl-sec--mist"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:columns {"verticalAlignment":"center","className":"swl-split swl-about"} -->
<div class="wp-block-columns are-vertically-aligned-center swl-split swl-about"><!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%"><!-- wp:group {"className":"swl-about-media","layout":{"type":"default"}} -->
<div class="wp-block-group swl-about-media"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"swl-photo"} -->
<figure class="wp-block-image size-full swl-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/mops.webp' ) ); ?>" alt="<?php esc_attr_e( 'Four washed mops drying against a wall', 'sashwell-lite' ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"swl-photo swl-photo--inset"} -->
<figure class="wp-block-image size-full swl-photo swl-photo--inset"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/window-cleaning.webp' ) ); ?>" alt="<?php esc_attr_e( 'Two window cleaners on ropes outside an office block', 'sashwell-lite' ); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"54%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'About us', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Two people and a van,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'thirty-four today.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'We started in 2014 with one rule: the person who cleans your home is someone we employ, train and insure ourselves. No agencies, no subcontractors, and the same crew every visit.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"swl-ticks"} -->
<ul class="wp-block-list swl-ticks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Every cleaner employed, DBS-checked and insured', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'A written job sheet after every clean', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Anything missed is redone free within 24 hours', 'sashwell-lite' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph {"className":"swl-sign"} -->
<p class="swl-sign"><strong><?php esc_html_e( 'Maria Okoye', 'sashwell-lite' ); ?></strong> <?php esc_html_e( 'Founder, still on the Tuesday rota', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
