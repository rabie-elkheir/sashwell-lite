<?php
/**
 * Nothing found.
 *
 * @package Sashwell_Lite
 */

?>
<div class="bempty">
	<?php if ( is_search() ) : ?>
		<p><b><?php esc_html_e( 'Nothing matches that.', 'sashwell-lite' ); ?></b> <?php esc_html_e( 'Try a shorter word or another topic.', 'sashwell-lite' ); ?></p>
	<?php else : ?>
		<p><b><?php esc_html_e( 'Nothing here yet.', 'sashwell-lite' ); ?></b> <?php esc_html_e( 'New articles appear here as soon as they are published.', 'sashwell-lite' ); ?></p>
	<?php endif; ?>
	<?php get_search_form(); ?>
</div>
