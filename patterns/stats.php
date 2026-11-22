<?php
/**
 * Title: Figures
 * Slug: sashwell-lite/stats
 * Categories: sashwell-lite, about
 * Keywords: numbers, figures, stats, proof
 * Viewport Width: 1400
 * Description: Four large figures with a one-line label each, on a light grey band.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_stats = array(
	array( '18,400', '', __( 'cleans written up since 2014', 'sashwell-lite' ) ),
	array( '47', __( 'min', 'sashwell-lite' ), __( 'average reply time to a quote request', 'sashwell-lite' ) ),
	array( '4.9', __( '/5', 'sashwell-lite' ), __( 'from 1,280 reviews on two sites', 'sashwell-lite' ) ),
	array( '92', __( '%', 'sashwell-lite' ), __( 'of customers keep the same crew for a year', 'sashwell-lite' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec swl-sec--mist","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec swl-sec--mist"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:group {"className":"swl-head","layout":{"type":"default"}} -->
<div class="wp-block-group swl-head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'On the record', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Twelve years of job sheets,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'counted.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Figures from our own booking records, updated every quarter.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"swl-stats","layout":{"type":"default"}} -->
<div class="wp-block-group swl-stats">
<?php
foreach ( $sashwell_lite_stats as $sashwell_lite_stat ) :
	?>
	<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"swl-n"} -->
<p class="swl-n"><?php echo esc_html( $sashwell_lite_stat[0] ); ?><?php echo '' !== $sashwell_lite_stat[1] ? '<small>' . esc_html( $sashwell_lite_stat[1] ) . '</small>' : ''; ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"swl-l"} -->
<p class="swl-l"><?php echo esc_html( $sashwell_lite_stat[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
