<?php
/**
 * Title: Call to action
 * Slug: sashwell-lite/cta
 * Categories: sashwell-lite, call-to-action
 * Keywords: call to action, book, contact, banner
 * Viewport Width: 1400
 * Description: A blue rounded band with a two-part heading, a line of text and two buttons.
 *
 * @package Sashwell_Lite
 */

?>
<!-- wp:group {"tagName":"section","className":"swl-cta","layout":{"type":"default"}} -->
<section class="wp-block-group swl-cta"><!-- wp:group {"className":"swl-cta-panel","layout":{"type":"default"}} -->
<div class="wp-block-group swl-cta-panel"><!-- wp:columns {"verticalAlignment":"bottom"} -->
<div class="wp-block-columns are-vertically-aligned-bottom"><!-- wp:column {"verticalAlignment":"bottom","width":"60%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:60%"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Your first clean,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'this week.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Send the rooms and a day. A person replies with a fixed price, usually within the hour.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:40%"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get a quote', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:+441614960732"><?php esc_html_e( 'Call 0161 496 0732', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
