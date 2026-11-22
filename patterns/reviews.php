<?php
/**
 * Title: Reviews
 * Slug: sashwell-lite/reviews
 * Categories: sashwell-lite, testimonials
 * Keywords: reviews, quotes, testimonials
 * Viewport Width: 1400
 * Description: Three short reviews with the name, the place and what was cleaned.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_reviews = array(
	array( __( 'They found the limescale I had stopped seeing. The job sheet said where, and it has stayed gone.', 'sashwell-lite' ), 'Hannah Okafor', __( 'Didsbury, fortnightly clean', 'sashwell-lite' ) ),
	array( __( 'The agent returned the full deposit. The checklist matched the inventory line for line.', 'sashwell-lite' ), 'Tom Reilly', __( 'Chorlton, end of tenancy', 'sashwell-lite' ) ),
	array( __( 'Same two people every Tuesday for three years. They know which plants not to move.', 'sashwell-lite' ), 'Priya Shah', __( 'Sale, weekly clean', 'sashwell-lite' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:group {"className":"swl-head","layout":{"type":"default"}} -->
<div class="wp-block-group swl-head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'Reviews', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'What neighbours say,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'in their words.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Rated 4.9 out of 5 from 1,280 reviews. We reply to every one.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"swl-quotes"} -->
<div class="wp-block-columns swl-quotes">
<?php
foreach ( $sashwell_lite_reviews as $sashwell_lite_review ) :
	?>
	<!-- wp:column -->
<div class="wp-block-column"><!-- wp:quote -->
<blockquote class="wp-block-quote"><!-- wp:paragraph -->
<p><?php echo esc_html( $sashwell_lite_review[0] ); ?></p>
<!-- /wp:paragraph --><cite><strong><?php echo esc_html( $sashwell_lite_review[1] ); ?></strong><?php echo esc_html( $sashwell_lite_review[2] ); ?></cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
