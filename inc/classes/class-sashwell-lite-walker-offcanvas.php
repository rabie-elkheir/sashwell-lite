<?php
/**
 * Off-canvas menu walker: top-level items with children become <details> groups.
 * Items deeper than the second level (mega menu columns) are listed flat.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Off-canvas navigation walker.
 */
class Sashwell_Lite_Walker_Offcanvas extends Walker_Nav_Menu {

	/**
	 * Render one top-level item and its subtree.
	 *
	 * @param WP_Post $element           Menu item.
	 * @param array   $children_elements Children keyed by parent ID.
	 * @param int     $max_depth         Max depth.
	 * @param int     $depth             Depth.
	 * @param array   $args              wp_nav_menu() arguments.
	 * @param string  $output            Output, passed by reference.
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element || 0 !== $depth ) {
			return;
		}

		$id    = (int) $element->ID;
		$links = $this->descendants( $id, $children_elements );
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core filter, applied as WordPress does for menu titles.
		$title = wp_strip_all_tags( apply_filters( 'the_title', $element->title, $element->ID ) );

		if ( ! $links ) {
			$output .= '<li>' . $this->link( $element ) . '</li>';
			return;
		}

		$output .= '<li><details><summary>' . esc_html( $title ) . sashwell_lite_icon( 'chev', 'chev' ) . '</summary><ul>';
		foreach ( $links as $item ) {
			$output .= '<li>' . $this->link( $item ) . '</li>';
		}
		$output .= '</ul></details></li>';
	}

	/**
	 * Linkable descendants of an item, in menu order. Column headings without a real link are skipped.
	 *
	 * @param int   $id                Parent ID.
	 * @param array $children_elements Children keyed by parent ID, passed by reference.
	 * @return WP_Post[]
	 */
	protected function descendants( $id, &$children_elements ) {
		$found = array();
		if ( empty( $children_elements[ $id ] ) ) {
			return $found;
		}
		foreach ( $children_elements[ $id ] as $child ) {
			$grand = $this->descendants( (int) $child->ID, $children_elements );
			if ( '1' === sashwell_lite_menu_item( $child )['hide_phone'] ) {
				continue;
			}
			if ( ! $grand || ( $child->url && '#' !== $child->url ) ) {
				$found[] = $child;
			}
			$found = array_merge( $found, $grand );
		}
		unset( $children_elements[ $id ] );
		return $found;
	}

	/**
	 * One plain link.
	 *
	 * @param WP_Post $item Menu item.
	 * @return string
	 */
	protected function link( $item ) {
		$opts = sashwell_lite_menu_item( $item );
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core filter, applied as WordPress does for menu titles.
		$title = esc_html( wp_strip_all_tags( apply_filters( 'the_title', $item->title, $item->ID ) ) );

		if ( 'soon' === $opts['state'] ) {
			$label = '' !== $opts['badge'] ? $opts['badge'] : __( 'Soon', 'sashwell-lite' );
			return '<span class="soon">' . $title . '<em>' . esc_html( $label ) . '</em></span>';
		}

		return sprintf(
			'<a href="%1$s"%2$s%3$s>%4$s%5$s</a>',
			esc_url( $item->url ),
			in_array( 'current-menu-item', (array) $item->classes, true ) ? ' aria-current="page"' : '',
			'_blank' === $item->target ? ' target="_blank" rel="noopener"' : '',
			$title,
			'' !== $opts['badge'] ? '<em class="oc-badge">' . esc_html( $opts['badge'] ) . '</em>' : ''
		);
	}
}
