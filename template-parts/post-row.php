<?php
/**
 * One post in the list layout.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_n = isset( $args['n'] ) ? (int) $args['n'] : 0;
?>
<li <?php post_class( 'brow' ); ?> style="<?php echo esc_attr( '--n:' . $sashwell_lite_n ); ?>">
	<time class="brow-d" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><b><?php echo esc_html( get_the_date( 'd' ) ); ?></b><?php echo esc_html( get_the_date( 'M Y' ) ); ?></time>
	<div class="brow-b">
		<?php sashwell_lite_post_meta( array( 'cat', 'type', 'read', 'author' ) ); ?>
		<h3 class="brow-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( has_excerpt() || get_the_content() ) : ?>
			<p class="brow-ex"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
		<?php endif; ?>
	</div>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="brow-ph">
		<?php
		the_post_thumbnail(
			'medium',
			array(
				'sizes' => '9rem',
				'alt'   => '',
			)
		);
		?>
								</div>
	<?php endif; ?>
</li>
