<?php
/**
 * Single post and other single content.
 *
 * @package Sashwell_Lite
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/single', get_post_type() );
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;

get_footer();
