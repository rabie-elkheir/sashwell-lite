<?php
/**
 * Blog index, archives and search results.
 *
 * Blog home, page 1: the newest post as a featured article, then the archive.
 * Layout from Customize > Theme options > Blog: list (rows with a sidebar of search and topics)
 * or grid (topic chips and cards).
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_layout   = sashwell_lite_blog_layout();
$sashwell_lite_is_home  = is_home();
$sashwell_lite_featured = $sashwell_lite_is_home && ! is_paged() && sashwell_lite_option( 'blog_featured' ) && have_posts();
$sashwell_lite_num      = 0;

if ( $sashwell_lite_featured ) :
	the_post();
	++$sashwell_lite_num;
	?>
	<section class="sec" aria-labelledby="bl-latest-h">
		<div class="wrap">
			<div class="sec-head">
				<div>
					<p class="eyebrow"><span><?php echo esc_html( sprintf( '%02d', $sashwell_lite_num ) ); ?></span><?php esc_html_e( 'Latest', 'sashwell-lite' ); ?></p>
					<h2 class="h2x reveal" id="bl-latest-h"><?php echo esc_html( sashwell_lite_option( 'blog_latest_title' ) ); ?> <span class="soft"><?php echo esc_html( sashwell_lite_option( 'blog_latest_soft' ) ); ?></span></h2>
				</div>
				<?php if ( sashwell_lite_option( 'blog_latest_text' ) ) : ?>
					<p><?php echo esc_html( sashwell_lite_option( 'blog_latest_text' ) ); ?></p>
				<?php endif; ?>
			</div>
			<?php get_template_part( 'template-parts/post-feature' ); ?>
		</div>
	</section>
	<?php
endif;

++$sashwell_lite_num;
$sashwell_lite_sec_class = $sashwell_lite_featured ? 'sec sec--mist' : 'sec';
?>
<section class="<?php echo esc_attr( $sashwell_lite_sec_class ); ?>" aria-labelledby="bl-all-h">
	<div class="wrap">
		<?php if ( $sashwell_lite_is_home ) : ?>
			<div class="sec-head">
				<div>
					<p class="eyebrow"><span><?php echo esc_html( sprintf( '%02d', $sashwell_lite_num ) ); ?></span><?php esc_html_e( 'All articles', 'sashwell-lite' ); ?></p>
					<h2 class="h2x reveal" id="bl-all-h"><?php echo esc_html( sashwell_lite_option( 'blog_archive_title' ) ); ?> <span class="soft"><?php echo esc_html( sashwell_lite_option( 'blog_archive_soft' ) ); ?></span></h2>
				</div>
				<?php if ( sashwell_lite_option( 'blog_archive_text' ) ) : ?>
					<p><?php echo esc_html( sashwell_lite_option( 'blog_archive_text' ) ); ?></p>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<h2 class="sr-only" id="bl-all-h"><?php is_search() ? esc_html_e( 'Results', 'sashwell-lite' ) : esc_html_e( 'Articles', 'sashwell-lite' ); ?></h2>
		<?php endif; ?>

		<?php if ( 'grid' === $sashwell_lite_layout ) : ?>
			<?php if ( ! is_search() ) : ?>
				<div class="bbar">
					<ul class="bchips" aria-label="<?php esc_attr_e( 'Topics', 'sashwell-lite' ); ?>"><?php sashwell_lite_blog_topics( 'chips' ); ?></ul>
				</div>
			<?php endif; ?>
			<?php if ( have_posts() ) : ?>
				<ol class="bgrid" data-stagger>
					<?php
					$sashwell_lite_i = 0;
					while ( have_posts() ) :
						the_post();
						get_template_part(
							'template-parts/post-card',
							null,
							array(
								'n'    => $sashwell_lite_i,
								'wide' => 0 === $sashwell_lite_i && ! $sashwell_lite_featured,
							)
						);
						++$sashwell_lite_i;
					endwhile;
					?>
				</ol>
				<?php sashwell_lite_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content-none' ); ?>
			<?php endif; ?>
		<?php else : ?>
			<div class="bidx-g">
				<aside class="bidx" aria-label="<?php esc_attr_e( 'Search and topics', 'sashwell-lite' ); ?>">
					<?php get_search_form( array( 'sashwell_lite_form' => 'blog' ) ); ?>
					<div>
						<p class="bk" id="bl-topics"><?php esc_html_e( 'Topics', 'sashwell-lite' ); ?></p>
						<ul class="btopics" aria-labelledby="bl-topics"><?php sashwell_lite_blog_topics( 'list' ); ?></ul>
					</div>
				</aside>
				<div class="blist-w">
					<?php if ( have_posts() ) : ?>
						<ol class="blist" data-stagger>
							<?php
							$sashwell_lite_i = 0;
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/post-row', null, array( 'n' => $sashwell_lite_i ) );
								++$sashwell_lite_i;
							endwhile;
							?>
						</ol>
						<?php sashwell_lite_pagination(); ?>
					<?php else : ?>
						<?php get_template_part( 'template-parts/content-none' ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
