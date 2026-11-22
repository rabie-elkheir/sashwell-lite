<?php
/**
 * Customizer: every theme option, grouped in one panel.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function sashwell_lite_sanitize_checkbox( $value ) {
	return ( isset( $value ) && true === (bool) $value );
}

/**
 * Sanitize a select or radio value against the control's choices.
 *
 * @param string               $value   Raw value.
 * @param WP_Customize_Setting $setting Setting.
 * @return string
 */
function sashwell_lite_sanitize_choice( $value, $setting ) {
	$value   = sanitize_key( $value );
	$control = $setting->manager->get_control( $setting->id );
	$choices = $control ? $control->choices : array();
	return array_key_exists( $value, $choices ) ? $value : $setting->default;
}

/**
 * Sanitize a phone number: digits, spaces, brackets, dots, dashes and one leading plus.
 *
 * @param string $value Raw value.
 * @return string
 */
function sashwell_lite_sanitize_phone( $value ) {
	return trim( preg_replace( '/[^0-9+().\-\s]/', '', sanitize_text_field( $value ) ) );
}

/**
 * Sanitize text that may hold <b> only.
 *
 * @param string $value Raw value.
 * @return string
 */
function sashwell_lite_sanitize_bold( $value ) {
	return wp_kses( $value, array( 'b' => array() ) );
}

/**
 * The fields: section => list of array( key, type, label, description ).
 *
 * Types: text, textarea, url, email, phone, checkbox, select:<a|b>.
 *
 * @return array
 */
function sashwell_lite_customizer_fields() {
	return array(
		'sashwell_lite_contact' => array(
			'title'  => __( 'Contact details', 'sashwell-lite' ),
			'fields' => array(
				array( 'phone', 'phone', __( 'Phone number', 'sashwell-lite' ), __( 'As shown on the site, e.g. 0161 496 0732.', 'sashwell-lite' ) ),
				array( 'tel', 'phone', __( 'Phone number for call links', 'sashwell-lite' ), __( 'Optional. International form, e.g. +441614960732.', 'sashwell-lite' ) ),
				array( 'email', 'email', __( 'Email address', 'sashwell-lite' ), '' ),
				array( 'address', 'text', __( 'Address', 'sashwell-lite' ), __( 'Links to a map search.', 'sashwell-lite' ) ),
				array( 'hours', 'text', __( 'Opening hours', 'sashwell-lite' ), __( 'One line, e.g. Mon–Sat, 7:30–19:00.', 'sashwell-lite' ) ),
				array( 'whatsapp', 'phone', __( 'WhatsApp number', 'sashwell-lite' ), __( 'International form without spaces, e.g. 447700900123.', 'sashwell-lite' ) ),
				array( 'whatsapp_text', 'text', __( 'WhatsApp first message', 'sashwell-lite' ), '' ),
				array( 'whatsapp_note', 'text', __( 'WhatsApp note', 'sashwell-lite' ), '' ),
				array( 'dock', 'checkbox', __( 'Show the call and WhatsApp bar on phones', 'sashwell-lite' ), '' ),
			),
		),
		'sashwell_lite_header'  => array(
			'title'  => __( 'Header', 'sashwell-lite' ),
			'fields' => array(
				array( 'logo_fallback', 'select:name|wordmark', __( 'Logo without an uploaded image', 'sashwell-lite' ), __( 'Upload a logo under Site Identity. Without one, show the site name or the Sashwell wordmark.', 'sashwell-lite' ) ),
				array( 'utility_bar', 'checkbox', __( 'Show the top bar (phone, email, note)', 'sashwell-lite' ), '' ),
				array( 'utility_note', 'text', __( 'Top bar note', 'sashwell-lite' ), '' ),
				array( 'header_cta_text', 'text', __( 'Button text', 'sashwell-lite' ), '' ),
				array( 'header_cta_url', 'url', __( 'Button link', 'sashwell-lite' ), __( 'The button shows when a link is set.', 'sashwell-lite' ) ),
				array( 'dark_toggle', 'checkbox', __( 'Show the dark mode button', 'sashwell-lite' ), '' ),
				array( 'menu_card', 'checkbox', __( 'Show the price card in big menus', 'sashwell-lite' ), __( 'Add the class "mega" to a top menu item to turn its dropdown into a big menu.', 'sashwell-lite' ) ),
				array( 'menu_card_title', 'text', __( 'Price card title', 'sashwell-lite' ), '' ),
				array( 'menu_card_text', 'text', __( 'Price card text', 'sashwell-lite' ), '' ),
			),
		),
		'sashwell_lite_panel'   => array(
			'title'  => __( 'Side panel', 'sashwell-lite' ),
			'fields' => array(
				array( 'oc_title', 'text', __( 'Heading', 'sashwell-lite' ), '' ),
				array( 'oc_title_soft', 'text', __( 'Heading, second part', 'sashwell-lite' ), '' ),
				array( 'oc_areas_title', 'text', __( 'Areas title', 'sashwell-lite' ), '' ),
				array( 'oc_areas', 'textarea', __( 'Areas', 'sashwell-lite' ), __( 'One per line: name | postcode, e.g. Didsbury | M20.', 'sashwell-lite' ) ),
				array( 'oc_areas_link', 'url', __( 'Areas link', 'sashwell-lite' ), '' ),
				array( 'proof', 'text', __( 'Proof line', 'sashwell-lite' ), __( 'Short line under the button. <b>bold</b> is allowed.', 'sashwell-lite' ) ),
			),
		),
		'sashwell_lite_footer'  => array(
			'title'  => __( 'Footer', 'sashwell-lite' ),
			'fields' => array(
				array( 'ft_cta_title', 'text', __( 'Call to action heading', 'sashwell-lite' ), __( 'The dark band above the footer shows when this is set.', 'sashwell-lite' ) ),
				array( 'ft_cta_soft', 'text', __( 'Heading, second part', 'sashwell-lite' ), '' ),
				array( 'ft_cta_text', 'text', __( 'Button text', 'sashwell-lite' ), '' ),
				array( 'ft_cta_url', 'url', __( 'Button link', 'sashwell-lite' ), '' ),
				array( 'ft_phone_label', 'text', __( 'Phone label', 'sashwell-lite' ), '' ),
				array( 'footer_about', 'textarea', __( 'About text', 'sashwell-lite' ), '' ),
				array( 'office_hours', 'text', __( 'Office hours line', 'sashwell-lite' ), '' ),
				array( 'footer_badges', 'textarea', __( 'Badges', 'sashwell-lite' ), __( 'One per line, e.g. Fully insured.', 'sashwell-lite' ) ),
				array( 'footer_text', 'text', __( 'Copyright line', 'sashwell-lite' ), __( 'Empty: © year and site name.', 'sashwell-lite' ) ),
				array( 'motion', 'checkbox', __( 'Animations, with a "Reduce motion" switch in the footer', 'sashwell-lite' ), '' ),
			),
		),
		'sashwell_lite_social'  => array(
			'title'  => __( 'Social profiles', 'sashwell-lite' ),
			'fields' => array(
				array( 'social_instagram', 'url', 'Instagram', '' ),
				array( 'social_facebook', 'url', 'Facebook', '' ),
				array( 'social_linkedin', 'url', 'LinkedIn', '' ),
				array( 'social_x', 'url', 'X', '' ),
				array( 'social_youtube', 'url', 'YouTube', '' ),
				array( 'social_tiktok', 'url', 'TikTok', '' ),
			),
		),
		'sashwell_lite_blog'    => array(
			'title'  => __( 'Blog', 'sashwell-lite' ),
			'fields' => array(
				array( 'blog_layout', 'select:list|grid', __( 'Layout', 'sashwell-lite' ), '' ),
				array( 'blog_featured', 'checkbox', __( 'Show the newest article as a featured article', 'sashwell-lite' ), '' ),
				array( 'blog_latest_title', 'text', __( 'Featured heading', 'sashwell-lite' ), '' ),
				array( 'blog_latest_soft', 'text', __( 'Featured heading, second part', 'sashwell-lite' ), '' ),
				array( 'blog_latest_text', 'text', __( 'Featured text', 'sashwell-lite' ), '' ),
				array( 'blog_archive_title', 'text', __( 'Archive heading', 'sashwell-lite' ), '' ),
				array( 'blog_archive_soft', 'text', __( 'Archive heading, second part', 'sashwell-lite' ), '' ),
				array( 'blog_archive_text', 'text', __( 'Archive text', 'sashwell-lite' ), '' ),
				array( 'title_bar', 'checkbox', __( 'Show the title bar on pages and archives', 'sashwell-lite' ), '' ),
				array( 'breadcrumb', 'checkbox', __( 'Show breadcrumbs', 'sashwell-lite' ), '' ),
			),
		),
		'sashwell_lite_404'     => array(
			'title'  => __( '404 page', 'sashwell-lite' ),
			'fields' => array(
				array( 'error_kicker', 'text', __( 'Small line above the heading', 'sashwell-lite' ), '' ),
				array( 'error_title', 'text', __( 'Heading', 'sashwell-lite' ), '' ),
				array( 'error_mark', 'text', __( 'Highlighted end of the heading', 'sashwell-lite' ), '' ),
				array( 'error_text', 'textarea', __( 'Text', 'sashwell-lite' ), '' ),
				array( 'error_word', 'text', __( 'Large background word', 'sashwell-lite' ), '' ),
			),
		),
	);
}

/**
 * Register the panel, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function sashwell_lite_customize_register( $wp_customize ) {
	$defaults = sashwell_lite_option_defaults();
	$labels   = array(
		'name'     => __( 'Site name', 'sashwell-lite' ),
		'wordmark' => __( 'Sashwell wordmark', 'sashwell-lite' ),
		'list'     => __( 'List with a sidebar', 'sashwell-lite' ),
		'grid'     => __( 'Grid of cards', 'sashwell-lite' ),
	);

	$wp_customize->add_panel(
		'sashwell_lite',
		array(
			'title'    => __( 'Theme options', 'sashwell-lite' ),
			'priority' => 30,
		)
	);

	$priority = 10;
	foreach ( sashwell_lite_customizer_fields() as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title'    => $section['title'],
				'panel'    => 'sashwell_lite',
				'priority' => $priority,
			)
		);
		$priority += 10;

		foreach ( $section['fields'] as $field ) {
			list( $key, $type, $label, $description ) = $field;

			$setting_id = 'sashwell_lite_' . $key;
			$control    = array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section_id,
			);

			if ( 'checkbox' === $type ) {
				$sanitize        = 'sashwell_lite_sanitize_checkbox';
				$control['type'] = 'checkbox';
			} elseif ( 0 === strpos( $type, 'select:' ) ) {
				$sanitize           = 'sashwell_lite_sanitize_choice';
				$control['type']    = 'select';
				$control['choices'] = array();
				foreach ( explode( '|', substr( $type, 7 ) ) as $choice ) {
					$control['choices'][ $choice ] = $labels[ $choice ];
				}
			} elseif ( 'url' === $type ) {
				$sanitize        = 'esc_url_raw';
				$control['type'] = 'url';
			} elseif ( 'email' === $type ) {
				$sanitize        = 'sanitize_email';
				$control['type'] = 'email';
			} elseif ( 'phone' === $type ) {
				$sanitize        = 'sashwell_lite_sanitize_phone';
				$control['type'] = 'tel';
			} elseif ( 'textarea' === $type ) {
				$sanitize        = 'sanitize_textarea_field';
				$control['type'] = 'textarea';
			} elseif ( 'proof' === $key ) {
				$sanitize        = 'sashwell_lite_sanitize_bold';
				$control['type'] = 'text';
			} else {
				$sanitize        = 'sanitize_text_field';
				$control['type'] = 'text';
			}

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
					'sanitize_callback' => $sanitize,
					'transport'         => 'refresh',
				)
			);
			$wp_customize->add_control( $setting_id, $control );
		}
	}

	require_once SASHWELL_LITE_INC . '/classes/class-sashwell-lite-customize-link-section.php';
	$wp_customize->register_section_type( 'Sashwell_Lite_Customize_Link_Section' );
	$wp_customize->add_section(
		new Sashwell_Lite_Customize_Link_Section(
			$wp_customize,
			'sashwell_lite_pro',
			array(
				'title'     => __( 'Sashwell Pro', 'sashwell-lite' ),
				'link_text' => __( 'See the Pro version', 'sashwell-lite' ),
				'link_url'  => 'https://themeforest.net/user/nile-theme',
				'priority'  => 1,
			)
		)
	);
}
add_action( 'customize_register', 'sashwell_lite_customize_register' );

/**
 * Style of the Pro link section in the Customizer.
 */
function sashwell_lite_customize_controls_css() {
	wp_enqueue_style( 'sashwell-lite-customizer', SASHWELL_LITE_URI . '/assets/css/customizer.css', array(), SASHWELL_LITE_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'sashwell_lite_customize_controls_css' );
