<?php
/**
 * Archives. Post archives use the blog layout; other content types use a plain list
 * until their own templates are built.
 *
 * @package Sashwell_Lite
 */

get_header();

if ( sashwell_lite_is_blog_view() ) :
	get_template_part( 'template-parts/blog-index' );
else :
	?>
	<section class="sec">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				the_posts_pagination();
				?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content-none' ); ?>
			<?php endif; ?>
		</div>
	</section>
	<?php
endif;

get_footer();
