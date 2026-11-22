<?php
/**
 * Call / WhatsApp dock fixed to the bottom of the screen on phones.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_phone = (string) sashwell_lite_option( 'phone' );
$sashwell_lite_wa    = sashwell_lite_whatsapp_url();

if ( ! sashwell_lite_option( 'dock' ) || ( '' === $sashwell_lite_phone && '' === $sashwell_lite_wa ) ) {
	return;
}
?>
<nav class="dock" aria-label="<?php esc_attr_e( 'Quick contact', 'sashwell-lite' ); ?>">
	<div class="dock-list" id="dock-list">
		<?php if ( '' !== $sashwell_lite_phone ) : ?>
			<a class="dock-b dock-call" href="<?php echo esc_url( sashwell_lite_tel( $sashwell_lite_phone ) ); ?>"><?php sashwell_lite_the_icon( 'call' ); ?><span class="dock-t"><b><?php esc_html_e( 'Call', 'sashwell-lite' ); ?></b><small><?php echo esc_html( $sashwell_lite_phone ); ?></small></span></a>
		<?php endif; ?>
		<?php if ( '' !== $sashwell_lite_wa ) : ?>
			<a class="dock-b dock-wa" href="<?php echo esc_url( $sashwell_lite_wa ); ?>" target="_blank" rel="noopener"><?php sashwell_lite_the_icon( 'whatsapp' ); ?><span class="dock-t"><b>WhatsApp</b><small><?php echo esc_html( sashwell_lite_option( 'whatsapp_note' ) ); ?></small></span></a>
		<?php endif; ?>
	</div>
</nav>
