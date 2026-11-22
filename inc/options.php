<?php
/**
 * Theme options: read from theme mods (Appearance > Customize), with safe defaults.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default value of every option the theme reads. Contact details default to empty, so nothing
 * appears until the site owner fills them in.
 *
 * @return array
 */
function sashwell_lite_option_defaults() {
	return apply_filters(
		'sashwell_lite_option_defaults',
		array(
			'logo_fallback'      => 'name',
			'title_bar'          => true,
			'breadcrumb'         => true,
			'phone'              => '',
			'tel'                => '',
			'whatsapp'           => '',
			'whatsapp_text'      => '',
			'whatsapp_note'      => __( 'Replies within the hour', 'sashwell-lite' ),
			'email'              => '',
			'address'            => '',
			'hours'              => '',
			'dock'               => true,
			'dark_toggle'        => true,
			'motion'             => true,
			'utility_bar'        => true,
			'utility_note'       => '',
			'header_cta_text'    => __( 'Get a quote', 'sashwell-lite' ),
			'header_cta_url'     => '',
			'menu_card'          => true,
			'menu_card_title'    => __( 'Get a price', 'sashwell-lite' ),
			'menu_card_text'     => '',
			'oc_title'           => __( 'Talk to a person,', 'sashwell-lite' ),
			'oc_title_soft'      => __( 'not a form.', 'sashwell-lite' ),
			'oc_areas_title'     => __( 'Areas we cover', 'sashwell-lite' ),
			'oc_areas'           => '',
			'oc_areas_link'      => '',
			'proof'              => '',
			'blog_layout'        => 'list',
			'blog_featured'      => true,
			'blog_latest_title'  => __( 'The latest article,', 'sashwell-lite' ),
			'blog_latest_soft'   => __( 'from the people who do the work.', 'sashwell-lite' ),
			'blog_latest_text'   => '',
			'blog_archive_title' => __( 'Every article so far,', 'sashwell-lite' ),
			'blog_archive_soft'  => __( 'newest first.', 'sashwell-lite' ),
			'blog_archive_text'  => '',
			'error_kicker'       => '',
			'error_title'        => __( 'This page has been tidied away.', 'sashwell-lite' ),
			'error_mark'         => '',
			'error_text'         => __( 'The address may have changed. Search the site or go back to the home page.', 'sashwell-lite' ),
			'error_word'         => '404',
			'ft_cta_title'       => '',
			'ft_cta_soft'        => '',
			'ft_cta_text'        => __( 'Get a quote', 'sashwell-lite' ),
			'ft_cta_url'         => '',
			'ft_phone_label'     => __( 'Or call the office', 'sashwell-lite' ),
			'footer_about'       => '',
			'office_hours'       => '',
			'footer_badges'      => '',
			'footer_text'        => '',
			'social_facebook'    => '',
			'social_instagram'   => '',
			'social_x'           => '',
			'social_linkedin'    => '',
			'social_youtube'     => '',
			'social_tiktok'      => '',
		)
	);
}

/**
 * Get one option from the theme mods.
 *
 * @param string $key      Option key.
 * @param mixed  $fallback Value when the key has no default.
 * @return mixed
 */
function sashwell_lite_option( $key, $fallback = null ) {
	$defaults = sashwell_lite_option_defaults();
	$value    = get_theme_mod( 'sashwell_lite_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : $fallback );
	return apply_filters( 'sashwell_lite_option_' . $key, $value );
}
