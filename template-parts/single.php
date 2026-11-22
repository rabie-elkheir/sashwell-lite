<?php
/**
 * Single entry for content types without their own template (posts use single-post.php).
 *
 * @package Sashwell_Lite
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sec' ); ?>>
	<div class="wrap entry-content">
		<?php
		sashwell_lite_the_content();
		wp_link_pages();
		?>
	</div>
</article>
