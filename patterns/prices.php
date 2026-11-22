<?php
/**
 * Title: Price plans
 * Slug: sashwell-lite/prices
 * Categories: sashwell-lite, call-to-action
 * Keywords: prices, plans, pricing
 * Viewport Width: 1400
 * Description: Three price cards, the middle one marked as the most booked.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_plans = array(
	array(
		'name'  => __( 'One-off', 'sashwell-lite' ),
		'for'   => __( 'Before guests, after a party', 'sashwell-lite' ),
		'price' => __( '£29', 'sashwell-lite' ),
		'unit'  => __( 'per hour', 'sashwell-lite' ),
		'lines' => array( __( 'Minimum three hours', 'sashwell-lite' ), __( 'Products and equipment included', 'sashwell-lite' ), __( 'Job sheet after the clean', 'sashwell-lite' ) ),
		'pick'  => false,
	),
	array(
		'name'  => __( 'Fortnightly', 'sashwell-lite' ),
		'for'   => __( 'Most homes with two to three bedrooms', 'sashwell-lite' ),
		'price' => __( '£26', 'sashwell-lite' ),
		'unit'  => __( 'per hour', 'sashwell-lite' ),
		'lines' => array( __( 'The same crew every visit', 'sashwell-lite' ), __( 'Your own room checklist', 'sashwell-lite' ), __( 'Skip a visit with 48 hours notice', 'sashwell-lite' ), __( 'Free re-clean within 24 hours', 'sashwell-lite' ) ),
		'pick'  => true,
	),
	array(
		'name'  => __( 'Deep clean', 'sashwell-lite' ),
		'for'   => __( 'Spring cleans and moving out', 'sashwell-lite' ),
		'price' => __( '£180', 'sashwell-lite' ),
		'unit'  => __( 'starting price', 'sashwell-lite' ),
		'lines' => array( __( 'Oven, fridge and cupboards inside', 'sashwell-lite' ), __( 'Limescale and grout', 'sashwell-lite' ), __( 'Fixed price before we start', 'sashwell-lite' ) ),
		'pick'  => false,
	),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec swl-sec--mist","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec swl-sec--mist" id="prices"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:group {"className":"swl-head","layout":{"type":"default"}} -->
<div class="wp-block-group swl-head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'Prices', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Clear prices.', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'No call-out fee.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'You pay for the hours on the job sheet, never more than the quote.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"swl-prices"} -->
<div class="wp-block-columns swl-prices">
<?php
foreach ( $sashwell_lite_plans as $sashwell_lite_plan ) :
	?>
	<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"swl-plan<?php echo $sashwell_lite_plan['pick'] ? ' swl-plan--pick' : ''; ?>","layout":{"type":"default"}} -->
<div class="wp-block-group swl-plan<?php echo $sashwell_lite_plan['pick'] ? ' swl-plan--pick' : ''; ?>">
	<?php
	if ( $sashwell_lite_plan['pick'] ) :
		?>
	<!-- wp:paragraph {"className":"swl-flag"} -->
<p class="swl-flag"><?php esc_html_e( 'Most booked', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

	<?php endif; ?><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $sashwell_lite_plan['name'] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"swl-plan-for"} -->
<p class="swl-plan-for"><?php echo esc_html( $sashwell_lite_plan['for'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"swl-plan-price"} -->
<p class="swl-plan-price"><?php echo esc_html( $sashwell_lite_plan['price'] ); ?><small><?php echo esc_html( $sashwell_lite_plan['unit'] ); ?></small></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"swl-ticks"} -->
<ul class="wp-block-list swl-ticks">
	<?php
	foreach ( $sashwell_lite_plan['lines'] as $sashwell_lite_line ) :
		?>
	<!-- wp:list-item -->
<li><?php echo esc_html( $sashwell_lite_line ); ?></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button<?php echo $sashwell_lite_plan['pick'] ? '' : ' {"className":"is-style-outline"}'; ?> -->
<div class="wp-block-button<?php echo $sashwell_lite_plan['pick'] ? '' : ' is-style-outline'; ?>"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Book this', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"swl-note"} -->
<p class="swl-note"><?php esc_html_e( 'Prices for Greater Manchester. Weekends add £4 an hour.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
