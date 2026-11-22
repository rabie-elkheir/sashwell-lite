<?php
/**
 * Theme setup: supports, menus, sidebars.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports and menus.
 */
function sashwell_lite_setup() {
	load_theme_textdomain( 'sashwell-lite', SASHWELL_LITE_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Block editor: the site's fonts, tokens and block styles in the editor, and the design colours and sizes.
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/editor-style.css', 'assets/css/blocks.css', 'assets/css/patterns.css' ) );
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html__( 'Ink', 'sashwell-lite' ),
				'slug'  => 'swl-ink',
				'color' => '#0e2a47',
			),
			array(
				'name'  => esc_html__( 'Blue', 'sashwell-lite' ),
				'slug'  => 'swl-blue',
				'color' => '#1f6feb',
			),
			array(
				'name'  => esc_html__( 'Lemon', 'sashwell-lite' ),
				'slug'  => 'swl-lemon',
				'color' => '#e3f05a',
			),
			array(
				'name'  => esc_html__( 'Stone', 'sashwell-lite' ),
				'slug'  => 'swl-stone',
				'color' => '#56606b',
			),
			array(
				'name'  => esc_html__( 'Mist', 'sashwell-lite' ),
				'slug'  => 'swl-mist',
				'color' => '#eef3f7',
			),
			array(
				'name'  => esc_html__( 'Paper', 'sashwell-lite' ),
				'slug'  => 'swl-paper',
				'color' => '#f4f6f8',
			),
			array(
				'name'  => esc_html__( 'White', 'sashwell-lite' ),
				'slug'  => 'swl-white',
				'color' => '#ffffff',
			),
		)
	);
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => esc_html__( 'Small', 'sashwell-lite' ),
				'slug' => 'small',
				'size' => 15,
			),
			array(
				'name' => esc_html__( 'Normal', 'sashwell-lite' ),
				'slug' => 'normal',
				'size' => 17,
			),
			array(
				'name' => esc_html__( 'Lead', 'sashwell-lite' ),
				'slug' => 'lead',
				'size' => 21,
			),
			array(
				'name' => esc_html__( 'Large', 'sashwell-lite' ),
				'slug' => 'large',
				'size' => 28,
			),
			array(
				'name' => esc_html__( 'Huge', 'sashwell-lite' ),
				'slug' => 'huge',
				'size' => 44,
			),
		)
	);

	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Main menu', 'sashwell-lite' ),
			'offcanvas' => esc_html__( 'Side panel menu (uses the main menu when empty)', 'sashwell-lite' ),
			'legal'     => esc_html__( 'Footer legal links', 'sashwell-lite' ),
			'not_found' => esc_html__( '404 page links (uses the main menu\'s top items when empty)', 'sashwell-lite' ),
		)
	);
}
add_action( 'after_setup_theme', 'sashwell_lite_setup' );

/**
 * Content width for embeds.
 */
function sashwell_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sashwell_lite_content_width', 736 );
}
add_action( 'after_setup_theme', 'sashwell_lite_content_width', 0 );

/**
 * Sidebars: blog sidebar and three footer columns (the brand column comes from Customize > Theme options > Footer).
 */
function sashwell_lite_widgets_init() {
	$common = array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array_merge(
			$common,
			array(
				'name' => esc_html__( 'Blog sidebar', 'sashwell-lite' ),
				'id'   => 'sashwell-lite-blog',
			)
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array_merge(
				$common,
				array(
					/* translators: %d: footer column number. */
					'name' => sprintf( esc_html__( 'Footer column %d', 'sashwell-lite' ), $i ),
					'id'   => 'sashwell-lite-footer-' . $i,
				)
			)
		);
	}
}
add_action( 'widgets_init', 'sashwell_lite_widgets_init' );
