<?php
/**
 * Page template: the title bar, then the page content in the text column.
 *
 * @package Sashwell_Lite
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="sec">
		<div class="wrap entry-content">
			<?php
			sashwell_lite_the_content();
			wp_link_pages();
			?>
		</div>
	</section>
	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;

get_footer();
