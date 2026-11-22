<?php
/**
 * Block patterns and block styles.
 *
 * WordPress registers every file in /patterns on its own; this file adds their category and
 * two block styles.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the "Sashwell" pattern category.
 */
function sashwell_lite_pattern_categories() {
	register_block_pattern_category(
		'sashwell-lite',
		array(
			'label'       => __( 'Sashwell', 'sashwell-lite' ),
			'description' => __( 'Sections for a service business home page: hero, services, steps, prices, figures, reviews, questions and a call to action.', 'sashwell-lite' ),
		)
	);
}
add_action( 'init', 'sashwell_lite_pattern_categories', 9 );

/**
 * Block styles: the ticked list and the text-link button of the patterns, for any List or Button block.
 */
function sashwell_lite_block_styles() {
	register_block_style(
		'core/list',
		array(
			'name'  => 'swl-ticks',
			'label' => __( 'Ticked', 'sashwell-lite' ),
		)
	);
	register_block_style(
		'core/button',
		array(
			'name'  => 'swl-link',
			'label' => __( 'Text link', 'sashwell-lite' ),
		)
	);
}
add_action( 'init', 'sashwell_lite_block_styles' );
