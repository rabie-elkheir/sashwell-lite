<?php
/**
 * Search overlay. Submits to the WordPress search.
 *
 * The input id is not "q" on purpose: main.js binds a static page index to #q.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_phone = (string) sashwell_lite_option( 'phone' );
?>
<div class="layer search" id="search" hidden>
	<div class="backdrop" data-close></div>
	<div class="panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'sashwell-lite' ); ?>">
		<div class="wrap">
			<?php get_search_form( array( 'sashwell_lite_form' => 'overlay' ) ); ?>
			<?php if ( '' !== $sashwell_lite_phone ) : ?>
				<p class="s-foot">
					<?php
					printf(
						/* translators: %s: phone number link. */
						esc_html__( 'Can\'t find it? Call %s.', 'sashwell-lite' ),
						'<a href="' . esc_url( sashwell_lite_tel( $sashwell_lite_phone ) ) . '">' . esc_html( $sashwell_lite_phone ) . '</a>'
					);
					?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
