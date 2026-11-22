<?php
/**
 * Template Name: Landing page
 * Template Post Type: page
 *
 * Full-width page without the title bar: the page content is a stack of sections. Insert the
 * "Home page" pattern, or single Sashwell patterns, from the block inserter.
 *
 * @package Sashwell_Lite
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="swl-landing-content">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();
