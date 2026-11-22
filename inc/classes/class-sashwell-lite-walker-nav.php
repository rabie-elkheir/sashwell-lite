<?php
/**
 * Main menu walker: dropdowns and the mega menu from the approved header.
 *
 * Options come from the menu items' CSS classes (inc/menus.php): `mega` or `cols-2` on a
 * top-level item, `icon-<name>` and `sub-all` on dropdown links. The Description field is
 * the small line under a dropdown link.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Desktop navigation walker. Each top-level item renders its whole subtree.
 */
class Sashwell_Lite_Walker_Nav extends Walker_Nav_Menu {

	/**
	 * Render one top-level item and its children.
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

		$id       = (int) $element->ID;
		$children = isset( $children_elements[ $id ] ) ? $children_elements[ $id ] : array();
		$classes  = empty( $element->classes ) ? array() : (array) $element->classes;
		$opts     = sashwell_lite_menu_item( $element );
		$title    = $this->title( $element );
		$current  = (bool) array_intersect( array( 'current-menu-item', 'current-menu-ancestor', 'current-menu-parent', 'current_page_parent' ), $classes );

		if ( ! $children ) {
			$output .= sprintf(
				'<li><a class="nav-link" href="%1$s"%2$s%3$s>%4$s</a></li>',
				esc_url( $element->url ),
				in_array( 'current-menu-item', $classes, true ) ? ' aria-current="page"' : '',
				'_blank' === $element->target ? ' target="_blank" rel="noopener"' : '',
				esc_html( $title )
			);
			return;
		}

		$mega    = 'mega' === $opts['type'];
		$sub_id  = 'sub-' . $id;
		$sub_cls = 'sub' . ( $mega ? ' sub--mega' : ( '2col' === $opts['type'] ? ' sub--2col' : '' ) );
		$card    = '';
		if ( $mega ) {
			$card     = 'off' === $opts['card'] ? '' : sashwell_lite_menu_card( $opts['card_title'], $opts['card_text'] );
			$cols     = count( $children );
			$sub_cls .= ( '' === $card ? ' sub--nocard' : '' ) . ( 2 !== $cols ? ' sub--c' . min( 4, max( 1, $cols ) ) : '' );
		}

		$output .= '<li class="has-sub' . ( $mega ? ' mega' : '' ) . '">';
		$output .= sprintf(
			'<button class="sub-toggle%1$s" type="button" aria-expanded="false" aria-controls="%2$s">%3$s%4$s</button>',
			$current ? ' is-current' : '',
			esc_attr( $sub_id ),
			esc_html( $title ),
			sashwell_lite_icon( 'chev', 'chev' )
		);
		$output .= '<div class="' . esc_attr( $sub_cls ) . '" id="' . esc_attr( $sub_id ) . '">';

		if ( $mega ) {
			foreach ( $children as $column ) {
				$items   = isset( $children_elements[ $column->ID ] ) ? $children_elements[ $column->ID ] : array();
				$all     = '';
				$output .= '<div><p class="sub-h">' . esc_html( $this->title( $column ) ) . '</p><ul>';
				foreach ( $this->flatten( $items, $children_elements ) as $row ) {
					$item_opts = sashwell_lite_menu_item( $row[0] );
					if ( '1' === $item_opts['all'] ) {
						$all = $this->see_all( $row[0]->url, $this->title( $row[0] ) );
						continue;
					}
					$output .= $this->row( $row, $item_opts );
				}
				$output .= '</ul>' . $all . '</div>';
				unset( $children_elements[ $column->ID ] );
			}
			$output .= $card;
		} else {
			$output .= '<ul>';
			foreach ( $this->flatten( $children, $children_elements ) as $row ) {
				$output .= $this->row( $row, sashwell_lite_menu_item( $row[0] ) );
			}
			$output .= '</ul>';
		}

		$output .= '</div></li>';
		unset( $children_elements[ $id ] );
	}

	/**
	 * Items and all their sub-items, in menu order, with their level (1 = direct item).
	 * The design has no fly-out menus, so deeper levels are listed under their parent, stepped in.
	 *
	 * @param WP_Post[] $items             Items.
	 * @param array     $children_elements Children keyed by parent ID, passed by reference.
	 * @param int       $level             Level of $items.
	 * @return array[] Rows: array( WP_Post, level ).
	 */
	protected function flatten( $items, &$children_elements, $level = 1 ) {
		$rows = array();
		foreach ( $items as $item ) {
			$rows[] = array( $item, $level );
			if ( ! empty( $children_elements[ $item->ID ] ) ) {
				$kids = $children_elements[ $item->ID ];
				unset( $children_elements[ $item->ID ] );
				$rows = array_merge( $rows, $this->flatten( $kids, $children_elements, $level + 1 ) );
			}
		}
		return $rows;
	}

	/**
	 * One dropdown row; sub-items carry a level class.
	 *
	 * @param array $row  Row from flatten(): item and level.
	 * @param array $opts Item options.
	 * @return string
	 */
	protected function row( $row, $opts ) {
		$level = min( 4, (int) $row[1] );
		return '<li' . ( $level > 1 ? ' class="mi-lv' . $level . '"' : '' ) . '>' . $this->link( $this->item_link( $row[0] ), $opts ) . '</li>';
	}

	/**
	 * Item title after core filters.
	 *
	 * @param WP_Post $item Menu item.
	 * @return string
	 */
	protected function title( $item ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core filter, applied as WordPress does for menu titles.
		return wp_strip_all_tags( apply_filters( 'the_title', $item->title, $item->ID ) );
	}

	/**
	 * Link data of a menu item, as used by link().
	 *
	 * @param WP_Post $item Menu item.
	 * @return array
	 */
	protected function item_link( $item ) {
		$opts  = sashwell_lite_menu_item( $item );
		$title = $this->title( $item );
		return array(
			'url'     => $item->url,
			'title'   => $title,
			'desc'    => trim( (string) $item->description ),
			'icon'    => '' !== $opts['icon'] ? $opts['icon'] : sashwell_lite_menu_auto_icon( $title, $item->url ),
			'current' => in_array( 'current-menu-item', (array) $item->classes, true ),
			'blank'   => '_blank' === $item->target,
		);
	}

	/**
	 * The underlined "see all" link under a mega menu column.
	 *
	 * @param string $url  Link.
	 * @param string $text Text.
	 * @return string
	 */
	protected function see_all( $url, $text ) {
		return sprintf( '<a class="sub-all" href="%1$s">%2$s%3$s</a>', esc_url( $url ), esc_html( $text ), sashwell_lite_icon( 'go', 'mi-go flip' ) );
	}

	/**
	 * A dropdown link: icon, title, small line, arrow or badge. "Coming soon" items are not links.
	 *
	 * @param array $link Link data: url, title, desc, icon, current, blank.
	 * @param array $opts Item options (badge, state); .
	 * @return string
	 */
	protected function link( $link, $opts = array() ) {
		$badge = isset( $opts['badge'] ) ? $opts['badge'] : '';
		$inner = '<span class="mi-ic" aria-hidden="true">' . sashwell_lite_icon( $link['icon'] ) . '</span>'
			. '<span class="mi-t">' . esc_html( $link['title'] ) . ( '' !== $link['desc'] ? '<small>' . esc_html( $link['desc'] ) . '</small>' : '' ) . '</span>';

		if ( isset( $opts['state'] ) && 'soon' === $opts['state'] ) {
			$label = '' !== $badge ? $badge : __( 'Soon', 'sashwell-lite' );
			return '<span class="mi mi--soon">' . $inner . '<em>' . esc_html( $label ) . '</em></span>';
		}

		return sprintf(
			'<a class="mi" href="%1$s"%2$s%3$s>%4$s%5$s</a>',
			esc_url( $link['url'] ),
			$link['current'] ? ' aria-current="page"' : '',
			! empty( $link['blank'] ) ? ' target="_blank" rel="noopener"' : '',
			$inner,
			'' !== $badge ? '<em class="mi-badge">' . esc_html( $badge ) . '</em>' : sashwell_lite_icon( 'go', 'mi-go flip' )
		);
	}
}
