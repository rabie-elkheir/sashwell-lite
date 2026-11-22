<?php
/**
 * Title: How it works
 * Slug: sashwell-lite/steps
 * Categories: sashwell-lite, text
 * Keywords: steps, process, how it works
 * Viewport Width: 1400
 * Description: Four numbered steps on a dark band, each with a time line.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_steps = array(
	array( __( 'Tell us about the place', 'sashwell-lite' ), __( 'Rooms, pets, the bits that bother you. Two minutes online or on the phone.', 'sashwell-lite' ), __( 'Today', 'sashwell-lite' ) ),
	array( __( 'Get a fixed price', 'sashwell-lite' ), __( 'A written quote with the hours and the crew, before anything is booked.', 'sashwell-lite' ), __( 'Within the hour', 'sashwell-lite' ) ),
	array( __( 'Meet your crew', 'sashwell-lite' ), __( 'The same two people each visit, with photo ID and a key log.', 'sashwell-lite' ), __( 'First visit', 'sashwell-lite' ) ),
	array( __( 'Read the job sheet', 'sashwell-lite' ), __( 'Every room ticked off, with notes. Anything missed is redone free.', 'sashwell-lite' ), __( 'After each clean', 'sashwell-lite' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec swl-sec--ink","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec swl-sec--ink"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:group {"className":"swl-head","layout":{"type":"default"}} -->
<div class="wp-block-group swl-head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'How it works', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Four steps,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'no surprises.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'From the first message to the first clean usually takes three days.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"swl-steps","layout":{"type":"default"}} -->
<div class="wp-block-group swl-steps">
<?php
foreach ( $sashwell_lite_steps as $sashwell_lite_step ) :
	?>
	<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html( $sashwell_lite_step[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $sashwell_lite_step[1] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"swl-when"} -->
<p class="swl-when"><?php echo esc_html( $sashwell_lite_step[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
