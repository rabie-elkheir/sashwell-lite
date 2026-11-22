<?php
/**
 * Blog helpers: reading time, meta lines, topics, pagination, contents list.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Blog layout: Customize > Theme options > Blog, or `?layout=list|grid` in the URL (demo links, previews).
 *
 * @return string 'list' or 'grid'.
 */
function sashwell_lite_blog_layout() {
	$layout = (string) get_query_var( 'layout' );
	if ( 'grid' !== $layout && 'list' !== $layout ) {
		$layout = 'grid' === sashwell_lite_option( 'blog_layout' ) ? 'grid' : 'list';
	}
	return (string) apply_filters( 'sashwell_lite_blog_layout', $layout );
}

/**
 * Public query var for the blog layout switch.
 *
 * @param string[] $vars Query vars.
 * @return string[]
 */
function sashwell_lite_blog_query_vars( $vars ) {
	$vars[] = 'layout';
	return $vars;
}
add_filter( 'query_vars', 'sashwell_lite_blog_query_vars' );

/**
 * Reading time in minutes, at 200 words a minute.
 *
 * @param int|WP_Post|null $post Post.
 * @return int
 */
function sashwell_lite_reading_time( $post = null ) {
	$post  = get_post( $post );
	$words = $post ? str_word_count( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) ) : 0;
	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * "6 min read".
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function sashwell_lite_reading_label( $post = null ) {
	$minutes = sashwell_lite_reading_time( $post );
	/* translators: %d: minutes. */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'sashwell-lite' ), $minutes );
}

/**
 * The first category of a post, or null.
 *
 * @param int|WP_Post|null $post Post.
 * @return WP_Term|null
 */
function sashwell_lite_primary_category( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || 'post' !== $post->post_type ) {
		return null;
	}
	$cats = get_the_category( $post->ID );
	return $cats ? $cats[0] : null;
}

/**
 * Meta line: category, date, reading time, and optionally the author.
 *
 * @param array $parts Which parts to show: cat, date, read, author.
 */
function sashwell_lite_post_meta( $parts = array( 'cat', 'date', 'read' ) ) {
	$out = array();
	foreach ( $parts as $part ) {
		if ( 'cat' === $part ) {
			$cat = sashwell_lite_primary_category();
			if ( $cat ) {
				$out[] = '<span class="bcat">' . esc_html( $cat->name ) . '</span>';
			}
		} elseif ( 'date' === $part ) {
			$out[] = '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
		} elseif ( 'read' === $part && 'post' === get_post_type() ) {
			$out[] = '<span>' . esc_html( sashwell_lite_reading_label() ) . '</span>';
		} elseif ( 'author' === $part && 'post' === get_post_type() ) {
			/* translators: %s: author name. */
			$out[] = '<span>' . esc_html( sprintf( __( 'By %s', 'sashwell-lite' ), get_the_author() ) ) . '</span>';
		} elseif ( 'type' === $part && 'post' !== get_post_type() ) {
			$type  = get_post_type_object( get_post_type() );
			$out[] = '<span class="bcat">' . esc_html( $type ? $type->labels->singular_name : '' ) . '</span>';
		}
	}
	if ( $out ) {
		echo '<p class="bmeta">' . wp_kses_post( implode( '', $out ) ) . '</p>';
	}
}

/**
 * Author line with avatar: name and number of articles.
 *
 * @param string $avatar_class Class of the avatar wrapper (bav, bav bav--s).
 * @param bool   $with_read    Add the reading time after the name (cards).
 */
function sashwell_lite_post_byline( $avatar_class = 'bav', $with_read = false ) {
	$author = (int) get_the_author_meta( 'ID' );
	$count  = (int) count_user_posts( $author, 'post', true );
	$avatar = get_avatar(
		$author,
		96,
		'',
		'',
		array(
			'loading' => 'lazy',
			'class'   => 'bav-img',
		)
	);
	$name   = '<b>' . esc_html( get_the_author() ) . '</b>';
	if ( $with_read ) {
		$tail = ' · ' . esc_html( sashwell_lite_reading_label() );
	} else {
		/* translators: %d: number of articles by the author. */
		$tail = esc_html( sprintf( _n( '%d article', '%d articles', $count, 'sashwell-lite' ), $count ) );
	}
	printf(
		'<span class="%1$s">%2$s</span><span>%3$s%4$s</span>',
		esc_attr( $avatar_class ),
		wp_kses_post( (string) $avatar ),
		wp_kses_post( $name ),
		wp_kses_post( $tail )
	);
}

/**
 * Categories that have posts, as links with counts. The current one is marked.
 *
 * @param string $style 'list' (sidebar buttons) or 'chips' (grid bar).
 */
function sashwell_lite_blog_topics( $style = 'list' ) {
	$cats  = get_categories(
		array(
			'hide_empty' => true,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => 12,
		)
	);
	$blog  = (int) get_option( 'page_for_posts' );
	$all   = $blog ? get_permalink( $blog ) : home_url( '/' );
	$total = (int) wp_count_posts( 'post' )->publish;
	$class = 'chips' === $style ? 'bchip' : 'btopic';

	$items   = array();
	$items[] = array( __( 'All articles', 'sashwell-lite' ), $all, $total, is_home() );
	foreach ( $cats as $cat ) {
		$items[] = array( $cat->name, get_category_link( $cat ), (int) $cat->count, is_category( $cat->term_id ) );
	}

	foreach ( $items as $item ) {
		if ( 'chips' === $style ) {
			$inner = esc_html( $item[0] ) . '<b>' . esc_html( number_format_i18n( $item[2] ) ) . '</b>';
		} else {
			$inner = '<span>' . esc_html( $item[0] ) . '</span><b>' . esc_html( number_format_i18n( $item[2] ) ) . '</b>';
		}
		printf(
			'<li><a class="%1$s" href="%2$s"%3$s>%4$s</a></li>',
			esc_attr( $class ),
			esc_url( $item[1] ),
			$item[3] ? ' aria-current="page"' : '',
			wp_kses_post( $inner )
		);
	}
}

/**
 * Pagination: "Showing 1–10 of 27", page numbers, link to older posts.
 */
function sashwell_lite_pagination() {
	global $wp_query;
	$total = (int) $wp_query->max_num_pages;
	if ( $total < 2 ) {
		return;
	}
	$paged = max( 1, (int) get_query_var( 'paged' ) );
	$per   = (int) get_query_var( 'posts_per_page' );
	$found = (int) $wp_query->found_posts;
	$first = ( $paged - 1 ) * $per + 1;
	$last  = min( $found, $paged * $per );

	$links = paginate_links(
		array(
			'type'               => 'array',
			'mid_size'           => 1,
			'prev_next'          => false,
			'before_page_number' => '<span class="sr-only">' . esc_html__( 'Page', 'sashwell-lite' ) . ' </span>',
		)
	);

	echo '<nav class="bpag" aria-label="' . esc_attr__( 'Pagination', 'sashwell-lite' ) . '">';
	printf(
		'<p class="bpag-n">%s</p>',
		/* translators: 1: first item, 2: last item, 3: total items. */
		wp_kses_post( sprintf( __( 'Showing <b>%1$s–%2$s</b> of %3$s', 'sashwell-lite' ), number_format_i18n( $first ), number_format_i18n( $last ), number_format_i18n( $found ) ) )
	);
	echo '<ul>';
	foreach ( (array) $links as $link ) {
		$link = str_replace( array( 'page-numbers current', 'page-numbers dots', 'page-numbers' ), array( 'bpag-i', 'bpag-i bpag-gap', 'bpag-i' ), $link );
		echo '<li>' . wp_kses_post( $link ) . '</li>';
	}
	echo '</ul>';
	if ( $paged < $total ) {
		echo '<a class="link-arrow" href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '">' . esc_html__( 'Older articles', 'sashwell-lite' );
		sashwell_lite_the_icon( 'arrow', 'flip' );
		echo '</a>';
	}
	echo '</nav>';
}

/**
 * Figures for the blog header: number of articles, topics and the average reading time.
 *
 * @return array[] Each: array( label, value, unit ).
 */
function sashwell_lite_blog_stats() {
	$cached = get_transient( 'sashwell_lite_blog_stats' );
	if ( is_array( $cached ) ) {
		return $cached;
	}
	$posts   = (int) wp_count_posts( 'post' )->publish;
	$topics  = count( get_categories( array( 'hide_empty' => true ) ) );
	$recent  = get_posts(
		array(
			'numberposts'      => 20,
			'post_status'      => 'publish',
			'suppress_filters' => false,
		)
	);
	$minutes = 0;
	foreach ( $recent as $post ) {
		$minutes += sashwell_lite_reading_time( $post );
	}
	$stats = array(
		array( __( 'Articles', 'sashwell-lite' ), number_format_i18n( $posts ), '' ),
		array( __( 'Topics', 'sashwell-lite' ), number_format_i18n( $topics ), '' ),
	);
	if ( $recent ) {
		$stats[] = array( __( 'Avg. read', 'sashwell-lite' ), number_format_i18n( (int) round( $minutes / count( $recent ) ) ), __( 'min', 'sashwell-lite' ) );
	}
	set_transient( 'sashwell_lite_blog_stats', $stats, DAY_IN_SECONDS );
	return $stats;
}

/**
 * Clear the cached blog figures when posts or categories change.
 */
function sashwell_lite_flush_blog_stats() {
	delete_transient( 'sashwell_lite_blog_stats' );
}
add_action( 'save_post_post', 'sashwell_lite_flush_blog_stats' );
add_action( 'deleted_post', 'sashwell_lite_flush_blog_stats' );
add_action( 'edited_category', 'sashwell_lite_flush_blog_stats' );

/**
 * A unique anchor for a heading.
 *
 * @param string $text Heading text.
 * @param array  $used Anchors already used, passed by reference.
 * @return string
 */
function sashwell_lite_heading_anchor( $text, &$used ) {
	$base = sanitize_title( wp_strip_all_tags( $text ) );
	$base = '' === $base ? 'section' : $base;
	$id   = $base;
	$n    = 2;
	while ( isset( $used[ $id ] ) ) {
		$id = $base . '-' . $n;
		++$n;
	}
	$used[ $id ] = true;
	return $id;
}

/**
 * The h2 headings of a post, for the contents list.
 *
 * @param int|WP_Post|null $post Post.
 * @return array[] Each: array( anchor, text ).
 */
function sashwell_lite_toc_items( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array();
	}
	$html = do_blocks( $post->post_content );
	preg_match_all( '#<h2\b([^>]*)>(.*?)</h2>#is', $html, $matches, PREG_SET_ORDER );
	$used  = array();
	$items = array();
	foreach ( $matches as $m ) {
		$text = trim( wp_strip_all_tags( $m[2] ) );
		if ( '' === $text ) {
			continue;
		}
		$items[] = array( preg_match( '#\bid=["\']([^"\']+)#', $m[1], $id ) ? $id[1] : sashwell_lite_heading_anchor( $text, $used ), $text );
	}
	return $items;
}

/**
 * Number the h2 headings of a single post and give them anchors, matching the contents list.
 *
 * @param string $content Post content.
 * @return string
 */
function sashwell_lite_number_headings( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$used = array();
	$n    = 0;
	return preg_replace_callback(
		'#<h2\b([^>]*)>(.*?)</h2>#is',
		function ( $m ) use ( &$used, &$n ) {
			$text = trim( wp_strip_all_tags( $m[2] ) );
			if ( '' === $text ) {
				return $m[0];
			}
			++$n;
			$attrs = $m[1];
			if ( ! preg_match( '#\bid=["\']#', $attrs ) ) {
				$attrs .= ' id="' . esc_attr( sashwell_lite_heading_anchor( $text, $used ) ) . '"';
			}
			return '<h2' . $attrs . '><span class="an">' . esc_html( sprintf( '%02d', $n ) ) . '</span>' . $m[2] . '</h2>';
		},
		$content
	);
}
add_filter( 'the_content', 'sashwell_lite_number_headings', 20 );

/**
 * Reply links get the design's reply-button style.
 *
 * @param string $link Reply link markup.
 * @return string
 */
function sashwell_lite_reply_link_class( $link ) {
	return str_replace( "class='comment-reply-link'", "class='comment-reply-link cm-rp'", str_replace( 'class="comment-reply-link"', 'class="comment-reply-link cm-rp"', $link ) );
}
add_filter( 'comment_reply_link', 'sashwell_lite_reply_link_class' );
