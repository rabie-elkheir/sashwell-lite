<?php
/**
 * Styles and scripts.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * The page sheet a request needs: "blog" for the blog views, "inner" for everything else
 * (page title bar, 404 page).
 *
 * @return string Sheet name without extension.
 */
function sashwell_lite_page_sheet() {
	$sheet = sashwell_lite_is_blog_view() ? 'blog' : 'inner';
	$sheet = (string) apply_filters( 'sashwell_lite_page_sheet', $sheet );
	return in_array( $sheet, array( 'blog', 'inner' ), true ) ? $sheet : 'inner';
}

/**
 * Body classes the stylesheets scope their tokens to: "inner" on pages and the 404 page,
 * "swl-landing" on pages using the Landing page template.
 *
 * @param array $classes Body classes.
 * @return array
 */
function sashwell_lite_body_class( $classes ) {
	if ( is_404() || ( 'inner' === sashwell_lite_page_sheet() && ! sashwell_lite_is_landing() ) ) {
		$classes[] = 'inner';
	}
	if ( sashwell_lite_is_landing() ) {
		$classes[] = 'swl-landing';
	}
	return $classes;
}
add_filter( 'body_class', 'sashwell_lite_body_class' );

/**
 * Whether the current view is a page on the Landing page template.
 *
 * @return bool
 */
function sashwell_lite_is_landing() {
	return is_page() && 'page-templates/landing.php' === get_page_template_slug( get_queried_object_id() );
}

/**
 * Enqueue front-end assets.
 */
function sashwell_lite_enqueue_assets() {
	$uri = SASHWELL_LITE_URI . '/assets';
	$ver = SASHWELL_LITE_VERSION;

	wp_enqueue_style( 'sashwell-lite-style', $uri . '/css/style.css', array(), $ver );
	wp_enqueue_style( 'sashwell-lite-page', $uri . '/css/' . sashwell_lite_page_sheet() . '.css', array( 'sashwell-lite-style' ), $ver );
	wp_enqueue_style( 'sashwell-lite-wordpress', $uri . '/css/wordpress.css', array( 'sashwell-lite-page' ), $ver );
	wp_enqueue_style( 'sashwell-lite-blocks', $uri . '/css/blocks.css', array( 'sashwell-lite-wordpress' ), $ver );
	wp_enqueue_style( 'sashwell-lite-patterns', $uri . '/css/patterns.css', array( 'sashwell-lite-blocks' ), $ver );

	// Theme and motion classes must be set before the first paint, so this runs in the head.
	wp_register_script( 'sashwell-lite-init', false, array(), $ver, false );
	wp_enqueue_script( 'sashwell-lite-init' );
	wp_add_inline_script( 'sashwell-lite-init', sashwell_lite_init_script() );

	wp_enqueue_script(
		'sashwell-lite-main',
		$uri . '/js/main.js',
		array(),
		$ver,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
	// Screen-reader texts of main.js, extras.js and motion.js (they read window.sashwellI18n).
	wp_add_inline_script(
		'sashwell-lite-main',
		'window.sashwellI18n=' . wp_json_encode(
			array(
				/* translators: %s: the heading of a card list that scrolls sideways on phones. */
				'rail'  => __( '%s, swipe for more', 'sashwell-lite' ),
				'cards' => __( 'Cards', 'sashwell-lite' ),
				'done'  => __( 'Done:', 'sashwell-lite' ) . ' ',
				'todo'  => __( 'To do:', 'sashwell-lite' ) . ' ',
				/* translators: 1: tasks done, 2: all tasks on the job sheet. */
				'count' => __( '%1$s of %2$s done', 'sashwell-lite' ),
			)
		) . ';',
		'before'
	);
	if ( sashwell_lite_option( 'motion' ) ) {
		wp_enqueue_script(
			'sashwell-lite-motion',
			$uri . '/js/motion.js',
			array(),
			$ver,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sashwell_lite_enqueue_assets' );

/**
 * The head script: light theme unless dark was chosen in this visit, motion on unless reduced.
 * The storage keys are the ones main.js reads.
 *
 * @return string JavaScript.
 */
function sashwell_lite_init_script() {
	$motion = sashwell_lite_option( 'motion' )
		? 'var m;try{m=localStorage.getItem("sashwell-motion")}catch(e){}if(m!=="off"&&!matchMedia("(prefers-reduced-motion: reduce)").matches)d.classList.add("motion");'
		: '';
	return '(function(){var d=document.documentElement,t;try{t=sessionStorage.getItem("sashwell-theme")}catch(e){}d.dataset.theme=t==="dark"?"dark":"light";' . $motion . '})();';
}

/**
 * Side panel styles are not needed for the first paint, so they are printed in the footer.
 */
function sashwell_lite_enqueue_late_styles() {
	wp_enqueue_style( 'sashwell-lite-offcanvas', SASHWELL_LITE_URI . '/assets/css/offcanvas.css', array( 'sashwell-lite-style' ), SASHWELL_LITE_VERSION );
}
add_action( 'wp_footer', 'sashwell_lite_enqueue_late_styles', 1 );

/**
 * Preload the two fonts used above the fold, and set the browser theme colour.
 */
function sashwell_lite_head_hints() {
	foreach ( array( 'bricolage-grotesque-latin-700-normal', 'figtree-latin-400-normal' ) as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( SASHWELL_LITE_URI . '/assets/fonts/' . $font . '.woff2' )
		);
	}
	echo '<meta name="theme-color" content="#0e2a47">' . "\n";
}
add_action( 'wp_head', 'sashwell_lite_head_hints', 2 );
