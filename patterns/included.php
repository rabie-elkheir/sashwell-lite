<?php
/**
 * Title: What is included, and where
 * Slug: sashwell-lite/included
 * Categories: sashwell-lite, text
 * Keywords: checklist, included, areas, postcodes
 * Viewport Width: 1400
 * Description: A ticked list of what every clean covers, next to the areas served as postcode chips.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_items = array(
	__( 'Kitchen worktops, hob and splashback', 'sashwell-lite' ),
	__( 'Outside of cupboards and appliances', 'sashwell-lite' ),
	__( 'Sinks, taps and plugholes', 'sashwell-lite' ),
	__( 'Bath, shower and limescale on glass', 'sashwell-lite' ),
	__( 'Toilets, inside and out', 'sashwell-lite' ),
	__( 'Mirrors and glass surfaces', 'sashwell-lite' ),
	__( 'Dusting to door-frame height', 'sashwell-lite' ),
	__( 'Skirting boards and light switches', 'sashwell-lite' ),
	__( 'Vacuuming and mopping every floor', 'sashwell-lite' ),
	__( 'Bins emptied and relined', 'sashwell-lite' ),
);
$sashwell_lite_areas = array(
	array( 'Didsbury', 'M20' ),
	array( 'Chorlton', 'M21' ),
	array( 'Withington', 'M20' ),
	array( 'Fallowfield', 'M14' ),
	array( 'Levenshulme', 'M19' ),
	array( 'Sale', 'M33' ),
	array( 'Stretford', 'M32' ),
	array( 'Heaton Moor', 'SK4' ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:columns {"className":"swl-split"} -->
<div class="wp-block-columns swl-split"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'Every regular clean', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Ten lines,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'ticked every visit.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"swl-ticks swl-ticks--2"} -->
<ul class="wp-block-list swl-ticks swl-ticks--2">
<?php
foreach ( $sashwell_lite_items as $sashwell_lite_item ) :
	?>
	<!-- wp:list-item -->
<li><?php echo esc_html( $sashwell_lite_item ); ?></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'Where we work', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php esc_html_e( 'South Manchester and Trafford, within 25 minutes of the office.', 'sashwell-lite' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:list {"className":"swl-areas"} -->
<ul class="wp-block-list swl-areas">
<?php
foreach ( $sashwell_lite_areas as $sashwell_lite_area ) :
	?>
	<!-- wp:list-item -->
<li><?php echo esc_html( $sashwell_lite_area[0] ); ?> <em><?php echo esc_html( $sashwell_lite_area[1] ); ?></em></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list -->

<!-- wp:buttons {"className":"swl-link"} -->
<div class="wp-block-buttons swl-link"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Ask about your street', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
