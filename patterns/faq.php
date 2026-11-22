<?php
/**
 * Title: Questions
 * Slug: sashwell-lite/faq
 * Categories: sashwell-lite, text
 * Keywords: faq, questions, answers, accordion
 * Viewport Width: 1400
 * Description: Questions that open and close, next to a heading and a contact link.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_faq = array(
	array( __( 'Do I need to be at home?', 'sashwell-lite' ), __( 'No. Most customers leave a key or a code. Keys are logged out and back in, and never labelled with your address.', 'sashwell-lite' ) ),
	array( __( 'Do you bring your own products?', 'sashwell-lite' ), __( 'Yes, and a vacuum and mop. If you prefer your own products, leave them out and we will use those.', 'sashwell-lite' ) ),
	array( __( 'What if something is missed?', 'sashwell-lite' ), __( 'Tell us within 24 hours and the crew comes back to redo it, free. It happens on about one clean in sixty.', 'sashwell-lite' ) ),
	array( __( 'Can I change or skip a visit?', 'sashwell-lite' ), __( 'Yes, with 48 hours notice and no fee. Shorter notice is charged at half the visit.', 'sashwell-lite' ) ),
	array( __( 'Are you insured?', 'sashwell-lite' ), __( 'Public liability cover of £5 million, and every cleaner is DBS-checked and employed by us, not subcontracted.', 'sashwell-lite' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"swl-sec swl-sec--mist","layout":{"type":"default"}} -->
<section class="wp-block-group swl-sec swl-sec--mist"><!-- wp:group {"className":"wrap","layout":{"type":"default"}} -->
<div class="wp-block-group wrap"><!-- wp:columns {"className":"swl-faq"} -->
<div class="wp-block-columns swl-faq"><!-- wp:column {"width":"40%","className":"swl-faq-side"} -->
<div class="wp-block-column swl-faq-side" style="flex-basis:40%"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php esc_html_e( 'Questions', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2x"} -->
<h2 class="wp-block-heading h2x"><?php esc_html_e( 'Asked every week,', 'sashwell-lite' ); ?> <span class="soft"><?php esc_html_e( 'answered once.', 'sashwell-lite' ); ?></span></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Something else on your mind? The office answers the phone from 07:30.', 'sashwell-lite' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"swl-link"} -->
<div class="wp-block-buttons swl-link"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Ask a question', 'sashwell-lite' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%">
<?php
foreach ( $sashwell_lite_faq as $sashwell_lite_qa ) :
	?>
	<!-- wp:details -->
<details class="wp-block-details"><summary><?php echo esc_html( $sashwell_lite_qa[0] ); ?></summary><!-- wp:paragraph -->
<p><?php echo esc_html( $sashwell_lite_qa[1] ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<?php endforeach; ?></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
