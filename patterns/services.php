<?php
/**
 * Title: Services with prices
 * Slug: sashwell-lite/services
 * Categories: sashwell-lite, text
 * Keywords: services, list, prices
 * Viewport Width: 1400
 * Description: Numbered service rows on hairlines, each with a short line and a starting price.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_services = array(
	array( __( 'Regular cleaning', 'sashwell-lite' ), __( 'Weekly or fortnightly, the same crew each time, with your own checklist.', 'sashwell-lite' ), __( 'from £26/h', 'sashwell-lite' ) ),
	array( __( 'Deep cleaning', 'sashwell-lite' ), __( 'Inside the oven and cupboards, behind the sofa, every skirting board.', 'sashwell-lite' ), __( 'from £180', 'sashwell-lite' ) ),
	array( __( 'End of tenancy', 'sashwell-lite' ), __( 'Done to the inventory, with a free re-clean if the agent asks within 72 hours.', 'sashwell-lite' ), __( 'from £220', 'sashwell-lite' ) ),
	array( __( 'Office cleaning', 'sashwell-lite' ), __( 'Before 08:00 or after 18:00, with a key-holding log your manager can read.', 'sashwell-lite' ), __( 'from £24/h', 'sashwell-lite' ) ),
	array( __( 'Carpets and upholstery', 'sashwell-lite' ), __( 'Hot-water extraction, dry to walk on in about four hours.', 'sashwell-lite' ), __( 'from £45', 'sashwell-lite' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:group {"className":"swl-head","layout":{"type":"default"}} -->
<div class="wp-block-group swl-head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'What we clean', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Five services,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'one standard.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Prices include products and equipment. No call-out fee, no minimum contract.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"swl-rows","layout":{"type":"default"}} -->
<div class="wp-block-group swl-rows">
<?php
foreach ( $sashwell_lite_services as $sashwell_lite_service ) :
	?>
	<!-- wp:group {"className":"swl-row","layout":{"type":"default"}} -->
<div class="wp-block-group swl-row"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $sashwell_lite_service[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $sashwell_lite_service[1] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"swl-price"} -->
<p class="swl-price"><?php echo esc_html( $sashwell_lite_service[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
