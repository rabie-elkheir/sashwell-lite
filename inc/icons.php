<?php
/**
 * Inline SVG icons. Data in icons-data.php.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * All icons: name => array( viewBox, inner markup ).
 *
 * @return array
 */
function sashwell_lite_icons() {
	static $icons = null;
	if ( null === $icons ) {
		$icons = (array) apply_filters( 'sashwell_lite_icons', require SASHWELL_LITE_INC . '/icons-data.php' );
	}
	return $icons;
}

/**
 * SVG markup for one icon, or an empty string when the name is unknown.
 *
 * @param string $name      Icon name.
 * @param string $css_class Optional class attribute.
 * @return string Unescaped markup; print it with sashwell_lite_the_icon() or wp_kses( $svg, sashwell_lite_svg_kses() ).
 */
function sashwell_lite_icon( $name, $css_class = '' ) {
	$icons = sashwell_lite_icons();
	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}
	return sprintf(
		'<svg%1$s viewBox="%2$s" aria-hidden="true" focusable="false">%3$s</svg>',
		$css_class ? ' class="' . esc_attr( $css_class ) . '"' : '',
		esc_attr( $icons[ $name ][0] ),
		$icons[ $name ][1]
	);
}

/**
 * Print an icon through the SVG allow-list.
 *
 * @param string $name      Icon name.
 * @param string $css_class Optional class attribute.
 */
function sashwell_lite_the_icon( $name, $css_class = '' ) {
	echo wp_kses( sashwell_lite_icon( $name, $css_class ), sashwell_lite_svg_kses() );
}

/**
 * Tags and attributes allowed in icon markup.
 *
 * @return array
 */
function sashwell_lite_svg_kses() {
	$shape = array(
		'd'                => true,
		'fill'             => true,
		'fill-opacity'     => true,
		'stroke'           => true,
		'stroke-width'     => true,
		'stroke-linecap'   => true,
		'stroke-linejoin'  => true,
		'stroke-dasharray' => true,
		'cx'               => true,
		'cy'               => true,
		'r'                => true,
		'x'                => true,
		'y'                => true,
		'width'            => true,
		'height'           => true,
		'rx'               => true,
		'class'            => true,
	);
	return array(
		'svg'    => array(
			'class'       => true,
			'viewbox'     => true,
			'aria-hidden' => true,
			'focusable'   => true,
			'role'        => true,
		),
		'path'   => $shape,
		'circle' => $shape,
		'rect'   => $shape,
		'g'      => array( 'id' => true ),
	);
}
