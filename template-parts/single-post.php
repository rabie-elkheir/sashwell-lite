<?php
/**
 * Single article.
 *
 * Contents list: built from the article's h2 headings, which are numbered and anchored
 * by sashwell_lite_number_headings(). Booking card: Customize > Theme options > Header (price card title and text, button).
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_toc     = sashwell_lite_toc_items();
$sashwell_lite_cta_url = (string) sashwell_lite_option( 'header_cta_url' );
$sashwell_lite_author  = (int) get_the_author_meta( 'ID' );
$sashwell_lite_prev    = get_previous_post();
$sashwell_lite_next    = get_next_post();
?>
<div class="aprog" aria-hidden="true"><i data-progress></i></div>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'art' ); ?> aria-labelledby="art-h">
	<header class="ahead">
		<div class="wrap">
			<?php sashwell_lite_breadcrumbs( 'crumbs' ); ?>
			<?php sashwell_lite_post_meta( array( 'cat', 'date', 'read' ) ); ?>
			<h1 class="ahead-h reveal" id="art-h"><?php the_title(); ?></h1>
			<div class="ahead-f">
				<?php if ( has_excerpt() ) : ?>
					<p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<div class="ahead-by">
					<p class="bwho"><?php sashwell_lite_post_byline(); ?></p>
				</div>
			</div>
		</div>
	</header>
	<div class="wrap">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="ahero">
				<?php
				the_post_thumbnail(
					'full',
					array(
						'sizes'         => '(min-width: 80em) 1240px, 100vw',
						'fetchpriority' => 'high',
						'loading'       => false,
					)
				);
				?>
				<?php if ( get_the_post_thumbnail_caption() ) : ?>
					<figcaption><?php the_post_thumbnail_caption(); ?></figcaption>
				<?php endif; ?>
			</figure>
		<?php endif; ?>
		<div class="abody">
			<?php if ( count( $sashwell_lite_toc ) > 1 || '' !== $sashwell_lite_cta_url ) : ?>
				<aside class="aside" aria-label="<?php esc_attr_e( 'Contents and booking', 'sashwell-lite' ); ?>">
					<?php if ( count( $sashwell_lite_toc ) > 1 ) : ?>
						<nav class="atoc" aria-labelledby="toc-h">
							<p class="bk" id="toc-h"><?php esc_html_e( 'In this article', 'sashwell-lite' ); ?></p>
							<ol>
								<?php foreach ( $sashwell_lite_toc as $sashwell_lite_k => $sashwell_lite_item ) : ?>
									<li><a href="<?php echo esc_url( '#' . $sashwell_lite_item[0] ); ?>"><span><?php echo esc_html( sprintf( '%02d', $sashwell_lite_k + 1 ) ); ?></span><?php echo esc_html( $sashwell_lite_item[1] ); ?></a></li>
								<?php endforeach; ?>
							</ol>
						</nav>
					<?php endif; ?>
					<?php if ( '' !== $sashwell_lite_cta_url ) : ?>
						<div class="aoffer">
							<p class="bk"><?php echo esc_html( sashwell_lite_option( 'menu_card_title' ) ); ?></p>
							<?php if ( sashwell_lite_option( 'menu_card_text' ) ) : ?>
								<p class="aoffer-t"><?php echo esc_html( sashwell_lite_option( 'menu_card_text' ) ); ?></p>
							<?php endif; ?>
							<?php if ( sashwell_lite_option( 'hours' ) ) : ?>
								<p class="aoffer-s"><?php echo esc_html( sashwell_lite_option( 'hours' ) ); ?></p>
							<?php endif; ?>
							<a class="btn btn--white" href="<?php echo esc_url( $sashwell_lite_cta_url ); ?>"><?php echo esc_html( sashwell_lite_option( 'header_cta_text' ) ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a>
						</div>
					<?php endif; ?>
				</aside>
			<?php endif; ?>
			<div class="aprose">
				<?php
				sashwell_lite_the_content();
				wp_link_pages(
					array(
						'before' => '<nav class="apages" aria-label="' . esc_attr__( 'Article pages', 'sashwell-lite' ) . '"><span>' . esc_html__( 'Pages:', 'sashwell-lite' ) . '</span>',
						'after'  => '</nav>',
					)
				);
				?>
				<div class="atags">
					<?php if ( has_tag() ) : ?>
						<p class="bk"><?php esc_html_e( 'Filed under', 'sashwell-lite' ); ?></p>
						<?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?>
					<?php endif; ?>
				</div>
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
					<section class="abio" aria-labelledby="bio-h">
						<span class="abio-ph"><?php echo wp_kses_post( (string) get_avatar( $sashwell_lite_author, 192, '', '', array( 'loading' => 'lazy' ) ) ); ?></span>
						<div>
							<p class="bk"><?php esc_html_e( 'Written by', 'sashwell-lite' ); ?></p>
							<h2 id="bio-h"><?php the_author(); ?></h2>
							<p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
							<a class="link-arrow" href="<?php echo esc_url( get_author_posts_url( $sashwell_lite_author ) ); ?>">
								<?php
								/* translators: %s: author name. */
								echo esc_html( sprintf( __( 'All articles by %s', 'sashwell-lite' ), get_the_author() ) );
								?>
								<?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?>
							</a>
						</div>
					</section>
				<?php endif; ?>
				<?php if ( $sashwell_lite_prev || $sashwell_lite_next ) : ?>
					<nav class="anav" aria-label="<?php esc_attr_e( 'More articles', 'sashwell-lite' ); ?>">
						<?php if ( $sashwell_lite_prev ) : ?>
							<a href="<?php echo esc_url( get_permalink( $sashwell_lite_prev ) ); ?>" rel="prev"><span><?php esc_html_e( 'Previous article', 'sashwell-lite' ); ?></span><?php echo esc_html( get_the_title( $sashwell_lite_prev ) ); ?></a>
						<?php endif; ?>
						<?php if ( $sashwell_lite_next ) : ?>
							<a href="<?php echo esc_url( get_permalink( $sashwell_lite_next ) ); ?>" rel="next"><span><?php esc_html_e( 'Next article', 'sashwell-lite' ); ?></span><?php echo esc_html( get_the_title( $sashwell_lite_next ) ); ?></a>
						<?php endif; ?>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>
