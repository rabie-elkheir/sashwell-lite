<?php
/**
 * One post in the grid layout.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_n    = isset( $args['n'] ) ? (int) $args['n'] : 0;
$sashwell_lite_wide = ! empty( $args['wide'] );
?>
<li <?php post_class( $sashwell_lite_wide ? 'bcard bcard--wide' : 'bcard' ); ?> style="<?php echo esc_attr( '--n:' . $sashwell_lite_n ); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="bcard-ph"><?php the_post_thumbnail( 'large', array( 'sizes' => $sashwell_lite_wide ? '(min-width: 64em) 52vw, (min-width: 40em) 50vw, 100vw' : '(min-width: 64em) 26vw, (min-width: 40em) 45vw, 100vw' ) ); ?></div>
	<?php endif; ?>
	<div class="bcard-b">
		<?php sashwell_lite_post_meta( array( 'cat', 'type', 'date' ) ); ?>
		<h3 class="bcard-t"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="bcard-ex"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<?php if ( 'post' === get_post_type() ) : ?>
			<p class="bby"><?php sashwell_lite_post_byline( 'bav bav--s', true ); ?></p>
		<?php endif; ?>
	</div>
</li>
