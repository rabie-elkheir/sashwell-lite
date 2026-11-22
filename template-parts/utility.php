<?php
/**
 * Utility bar above the header: phone, email and a short note. Hidden when all are empty.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_phone = (string) sashwell_lite_option( 'phone' );
$sashwell_lite_email = (string) sashwell_lite_option( 'email' );
$sashwell_lite_note  = (string) sashwell_lite_option( 'utility_note' );

if ( ! sashwell_lite_option( 'utility_bar' ) || ( '' === $sashwell_lite_phone && '' === $sashwell_lite_email && '' === $sashwell_lite_note ) ) {
	return;
}
?>
<aside class="utility" aria-label="<?php esc_attr_e( 'Contact details', 'sashwell-lite' ); ?>">
	<div class="wrap">
		<ul>
			<?php if ( '' !== $sashwell_lite_phone ) : ?>
				<li><a href="<?php echo esc_url( sashwell_lite_tel( $sashwell_lite_phone ) ); ?>"><?php echo esc_html( $sashwell_lite_phone ); ?></a></li>
			<?php endif; ?>
			<?php if ( '' !== $sashwell_lite_email ) : ?>
				<li class="u-hide"><a href="<?php echo esc_url( 'mailto:' . $sashwell_lite_email ); ?>"><?php echo esc_html( $sashwell_lite_email ); ?></a></li>
			<?php endif; ?>
		</ul>
		<?php if ( '' !== $sashwell_lite_note ) : ?>
			<p class="u-hide"><?php echo esc_html( $sashwell_lite_note ); ?></p>
		<?php endif; ?>
	</div>
</aside>
