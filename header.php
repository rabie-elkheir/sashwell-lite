<?php
/**
 * Document head, site header, off-canvas panel and search overlay.
 *
 * @package Sashwell_Lite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'sashwell-lite' ); ?></a>
<?php
sashwell_lite_header();
get_template_part( 'template-parts/offcanvas' );
get_template_part( 'template-parts/search' );
?>
<main id="main">
<?php sashwell_lite_title_bar(); ?>
