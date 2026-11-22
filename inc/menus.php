<?php
/**
 * Menu item options, set with CSS classes on a menu item (Appearance > Menus > Screen Options >
 * CSS Classes):
 *
 * - `mega` on a top item: its dropdown becomes a big menu; each second-level item is a column
 *   and the price card (Customize > Theme options > Header) closes the row.
 * - `cols-2` on a top item: a dropdown list in two columns.
 * - `icon-<name>` on a dropdown link: the icon in front of it (picked from the title otherwise).
 * - `sub-all` on a link inside a big menu column: shown as the underlined "see all" link.
 *
 * The Description field of a menu item is the small line under it.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Icons offered in the menu picker: the theme's line icons (not the UI and social ones).
 *
 * @return array Name => label.
 */
function sashwell_lite_menu_icons() {
	$labels = array(
		'home'     => __( 'Home', 'sashwell-lite' ),
		'building' => __( 'Building', 'sashwell-lite' ),
		'key'      => __( 'Key', 'sashwell-lite' ),
		'sheet'    => __( 'Job sheet', 'sashwell-lite' ),
		'drop'     => __( 'Drop', 'sashwell-lite' ),
		'spray'    => __( 'Spray', 'sashwell-lite' ),
		'vacuum'   => __( 'Vacuum', 'sashwell-lite' ),
		'sofa'     => __( 'Sofa', 'sashwell-lite' ),
		'window'   => __( 'Window', 'sashwell-lite' ),
		'squeegee' => __( 'Squeegee', 'sashwell-lite' ),
		'hammer'   => __( 'Hammer', 'sashwell-lite' ),
		'box'      => __( 'Box', 'sashwell-lite' ),
		'shield'   => __( 'Shield', 'sashwell-lite' ),
		'id-check' => __( 'Checked ID', 'sashwell-lite' ),
		'umbrella' => __( 'Umbrella', 'sashwell-lite' ),
		'star'     => __( 'Star', 'sashwell-lite' ),
		'clock'    => __( 'Clock', 'sashwell-lite' ),
		'chat'     => __( 'Chat', 'sashwell-lite' ),
		'mail'     => __( 'Mail', 'sashwell-lite' ),
		'phone'    => __( 'Phone', 'sashwell-lite' ),
		'print'    => __( 'Print', 'sashwell-lite' ),
		'download' => __( 'Download', 'sashwell-lite' ),
		'link'     => __( 'Link', 'sashwell-lite' ),
	);
	$icons  = sashwell_lite_icons();
	return (array) apply_filters( 'sashwell_lite_menu_icons', array_intersect_key( $labels, $icons ) );
}

/**
 * Words that pick an icon when none is chosen ("Auto"). First match wins; checked against the
 * title, then the last part of the link (not the parent pages in it). English words; translations and other words can be added with the filter.
 *
 * @return array Icon => words.
 */
function sashwell_lite_menu_icon_words() {
	return (array) apply_filters(
		'sashwell_lite_menu_icon_words',
		array(
			'building' => array( 'office', 'commercial', 'business', 'studio', 'workplace' ),
			'sofa'     => array( 'carpet', 'sofa', 'upholster', 'rug' ),
			'window'   => array( 'window', 'facade', 'glass', 'project', 'gallery', 'grid', 'portfolio' ),
			'hammer'   => array( 'builder', 'renovat', 'construction' ),
			'box'      => array( 'moving', 'move-', 'move ', 'removal', 'career', 'job', 'single', 'article' ),
			'key'      => array( 'crew', 'team', 'member', 'staff', 'people', 'key' ),
			'drop'     => array( 'faq', 'question', 'help', 'support' ),
			'sheet'    => array( 'price', 'pricing', 'blog', 'news', 'list', 'plan', 'quote', 'booking', 'terms', 'one-page' ),
			'clock'    => array( 'soon', 'hours', 'schedule', 'time' ),
			'mail'     => array( 'contact', 'email', 'mail' ),
			'phone'    => array( 'call', 'phone' ),
			'shield'   => array( 'privacy', 'legal', 'insur', 'safety', 'policy' ),
			'star'     => array( 'review', 'testimonial', 'rating' ),
			'chat'     => array( 'chat', 'whatsapp', 'message' ),
			'download' => array( 'download' ),
			'spray'    => array( 'deep', 'spray', '404', 'error', 'disinfect' ),
			'home'     => array( 'home', 'house', 'flat', 'regular', 'residential', 'domestic', 'about', 'story' ),
			'vacuum'   => array( 'clean', 'vacuum' ),
		)
	);
}

/**
 * Icon for a title and link when none is chosen.
 *
 * @param string $title Item title.
 * @param string $url   Item link.
 * @return string Icon name.
 */
function sashwell_lite_menu_auto_icon( $title, $url = '' ) {
	$icons = sashwell_lite_icons();
	$path  = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
	$slug  = '' === $path ? '' : basename( $path );
	foreach ( array( $title, $slug ) as $text ) {
		$text = strtolower( (string) $text );
		if ( '' === $text || '/' === $text ) {
			continue;
		}
		foreach ( sashwell_lite_menu_icon_words() as $icon => $words ) {
			foreach ( (array) $words as $word ) {
				if ( isset( $icons[ $icon ] ) && false !== strpos( $text, strtolower( $word ) ) ) {
					return $icon;
				}
			}
		}
	}
	return 'link';
}

/**
 * Options of one menu item, read from its CSS classes.
 *
 * @param WP_Post $item Menu item.
 * @return array
 */
function sashwell_lite_menu_item( $item ) {
	$classes = empty( $item->classes ) ? array() : (array) $item->classes;
	$opts    = array(
		'icon'       => '',
		'badge'      => '',
		'state'      => '',
		'type'       => '',
		'source'     => '',
		'card'       => '',
		'card_title' => '',
		'card_text'  => '',
		'all'        => '',
	);

	if ( '' === $opts['type'] ) {
		if ( in_array( 'mega', $classes, true ) ) {
			$opts['type'] = 'mega';
		} elseif ( in_array( 'cols-2', $classes, true ) ) {
			$opts['type'] = '2col';
		}
	}
	if ( '' === $opts['icon'] ) {
		foreach ( $classes as $class ) {
			if ( 0 === strpos( $class, 'icon-' ) && '' !== sashwell_lite_icon( substr( $class, 5 ) ) ) {
				$opts['icon'] = substr( $class, 5 );
			}
		}
	}
	if ( '' === $opts['all'] && in_array( 'sub-all', $classes, true ) ) {
		$opts['all'] = '1';
	}
	return $opts;
}
