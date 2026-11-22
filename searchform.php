<?php
/**
 * Search form, loaded by get_search_form().
 *
 * Three looks, chosen with get_search_form( array( 'sashwell_lite_form' => … ) ):
 * 'overlay' (the header search panel), 'blog' (the blog sidebar, articles only) and the default
 * (404, empty results and the Search widget).
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

$sashwell_lite_form = isset( $args['sashwell_lite_form'] ) ? $args['sashwell_lite_form'] : '';

if ( 'overlay' === $sashwell_lite_form ) :
	?>
	<form class="row" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php sashwell_lite_the_icon( 'search' ); ?>
		<label class="sr-only" for="sashwell-lite-q"><?php esc_html_e( 'Search pages and articles', 'sashwell-lite' ); ?></label>
		<input id="sashwell-lite-q" name="s" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search services, prices, help…', 'sashwell-lite' ); ?>" autocomplete="off">
		<kbd>Esc</kbd>
		<button class="icon-btn" type="button" data-close aria-label="<?php esc_attr_e( 'Close search', 'sashwell-lite' ); ?>"><?php sashwell_lite_the_icon( 'close' ); ?></button>
	</form>
	<?php
elseif ( 'blog' === $sashwell_lite_form ) :
	?>
	<form class="bsearch" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="bk" for="bq"><?php esc_html_e( 'Search articles', 'sashwell-lite' ); ?></label>
		<div class="bsearch-f">
			<?php sashwell_lite_the_icon( 'search' ); ?>
			<input id="bq" name="s" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search the articles…', 'sashwell-lite' ); ?>">
			<input type="hidden" name="post_type" value="post">
		</div>
	</form>
	<?php
else :
	$sashwell_lite_id = wp_unique_id( 'search-' );
	?>
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="<?php echo esc_attr( $sashwell_lite_id ); ?>"><?php esc_html_e( 'Search', 'sashwell-lite' ); ?></label>
		<input type="search" id="<?php echo esc_attr( $sashwell_lite_id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
		<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Search', 'sashwell-lite' ); ?></button>
	</form>
	<?php
endif;
