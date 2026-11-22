<?php
/**
 * Title: Services with photos
 * Slug: sashwell-lite/services-photos
 * Categories: sashwell-lite, text
 * Keywords: services, cards, photos, prices
 * Viewport Width: 1400
 * Description: Three service cards, each with a photo, a starting price, a short line and a link.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_cards = array(
	array( 'bedroom.webp', __( 'A freshly made bed in a bright bedroom', 'sashwell-lite' ), __( 'from £26/h', 'sashwell-lite' ), __( 'Homes', 'sashwell-lite' ), __( 'Weekly or fortnightly, the same crew each visit, with your own room checklist.', 'sashwell-lite' ) ),
	array( 'kitchen.webp', __( 'Clean pans and cutlery drying in a kitchen rack', 'sashwell-lite' ), __( 'from £180', 'sashwell-lite' ), __( 'Deep cleans', 'sashwell-lite' ), __( 'Inside the oven and cupboards, limescale and grout, every skirting board.', 'sashwell-lite' ) ),
	array( 'office.webp', __( 'An open-plan office with tidy desks and chairs', 'sashwell-lite' ), __( 'from £24/h', 'sashwell-lite' ), __( 'Offices', 'sashwell-lite' ), __( 'Before 08:00 or after 18:00, with a key-holding log your manager can read.', 'sashwell-lite' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:group {"className":"swl-head","layout":{"type":"default"}} -->
<div class="wp-block-group swl-head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'Services', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Homes, deep cleans and offices,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'one crew.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Products and equipment included. No call-out fee, no minimum contract.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"swl-cards"} -->
<div class="wp-block-columns swl-cards">
<?php
foreach ( $sashwell_lite_cards as $sashwell_lite_card ) :
	?>
	<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"swl-card","layout":{"type":"default"}} -->
<div class="wp-block-group swl-card"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"swl-photo"} -->
<figure class="wp-block-image size-full swl-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $sashwell_lite_card[0] ) ); ?>" alt="<?php echo esc_attr( $sashwell_lite_card[1] ); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"swl-price"} -->
<p class="swl-price"><?php echo esc_html( $sashwell_lite_card[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $sashwell_lite_card[3] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $sashwell_lite_card[4] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"swl-link"} -->
<div class="wp-block-buttons swl-link"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get a price', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --><?php endforeach; ?></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
