<?php
/**
 * The featured (newest) post at the top of the blog.
 *
 * @package Sashwell_Lite
 */

?>
<article <?php post_class( 'bfeat' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="bfeat-ph" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php
			the_post_thumbnail(
				'large',
				array(
					'sizes' => '(min-width: 60em) 54vw, 100vw',
					'alt'   => '',
				)
			);
			?>
			<?php if ( is_sticky() ) : ?>
				<span class="bflag"><?php esc_html_e( 'Featured', 'sashwell-lite' ); ?></span>
			<?php endif; ?>
		</a>
	<?php endif; ?>
	<div class="bfeat-b">
		<?php sashwell_lite_post_meta( array( 'cat', 'date', 'read' ) ); ?>
		<h3 class="bfeat-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="bfeat-ex"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40 ) ); ?></p>
		<?php $sashwell_lite_toc = sashwell_lite_toc_items(); ?>
		<?php if ( count( $sashwell_lite_toc ) > 1 ) : ?>
			<div class="bfeat-in">
				<p class="bk"><?php esc_html_e( 'In this piece', 'sashwell-lite' ); ?></p>
				<ol>
					<?php foreach ( array_slice( $sashwell_lite_toc, 0, 5 ) as $sashwell_lite_k => $sashwell_lite_item ) : ?>
						<li><span><?php echo esc_html( sprintf( '%02d', $sashwell_lite_k + 1 ) ); ?></span><?php echo esc_html( $sashwell_lite_item[1] ); ?></li>
					<?php endforeach; ?>
				</ol>
			</div>
		<?php endif; ?>
		<div class="bfeat-f">
			<p class="bwho"><?php sashwell_lite_post_byline(); ?></p>
			<a class="btn btn--primary" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read the article', 'sashwell-lite' ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a>
		</div>
	</div>
</article>
