<?php
/**
 * Sashwell Lite functions and definitions.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

define( 'SASHWELL_LITE_VERSION', '1.0.1' );
define( 'SASHWELL_LITE_DIR', get_template_directory() );
define( 'SASHWELL_LITE_URI', get_template_directory_uri() );
define( 'SASHWELL_LITE_INC', SASHWELL_LITE_DIR . '/inc' );

require_once SASHWELL_LITE_INC . '/options.php';
require_once SASHWELL_LITE_INC . '/customizer.php';
require_once SASHWELL_LITE_INC . '/icons.php';
require_once SASHWELL_LITE_INC . '/menus.php';
require_once SASHWELL_LITE_INC . '/classes/class-sashwell-lite-walker-nav.php';
require_once SASHWELL_LITE_INC . '/classes/class-sashwell-lite-walker-offcanvas.php';
require_once SASHWELL_LITE_INC . '/classes/class-sashwell-lite-walker-comment.php';
require_once SASHWELL_LITE_INC . '/blog.php';
require_once SASHWELL_LITE_INC . '/setup.php';
require_once SASHWELL_LITE_INC . '/patterns.php';
require_once SASHWELL_LITE_INC . '/enqueue.php';
require_once SASHWELL_LITE_INC . '/template-functions.php';
