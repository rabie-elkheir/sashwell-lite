<?php
/**
 * Template helpers: header, footer, logo, title bar.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site header.
 */
function sashwell_lite_header() {
	get_template_part( 'template-parts/header' );
}

/**
 * Site footer.
 */
function sashwell_lite_footer() {
	get_template_part( 'template-parts/footer' );
}

/**
 * Site logo, or the site name when no logo is set.
 */
function sashwell_lite_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	printf(
		'<a class="logo" href="%1$s" rel="home">%2$s</a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}

/**
 * Heading text for the title bar on the current view.
 *
 * @return string Plain text, not escaped.
 */
function sashwell_lite_page_title() {
	if ( is_home() ) {
		$blog_page = (int) get_option( 'page_for_posts' );
		$title     = $blog_page ? get_the_title( $blog_page ) : __( 'Blog', 'sashwell-lite' );
	} elseif ( is_search() ) {
		/* translators: %s: search terms. */
		$title = sprintf( __( 'Search results for &ldquo;%s&rdquo;', 'sashwell-lite' ), get_search_query( false ) );
	} elseif ( is_archive() ) {
		$title = get_the_archive_title();
	} else {
		$title = single_post_title( '', false );
	}

	return (string) apply_filters( 'sashwell_lite_page_title', wp_strip_all_tags( html_entity_decode( $title, ENT_QUOTES, get_bloginfo( 'charset' ) ) ) );
}

/**
 * Archive headings without the "Category:" / "Month:" prefix; the breadcrumb gives the context.
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Whether the current view is part of the blog (posts index, post archives, search, single post).
 *
 * @return bool
 */
function sashwell_lite_is_blog_view() {
	return is_home() || is_search() || is_singular( 'post' ) || is_category() || is_tag() || is_date() || is_author();
}

/**
 * Intro line for the title bar: the archive description, the page excerpt, or nothing.
 *
 * @return string Plain text.
 */
function sashwell_lite_page_lead() {
	if ( is_home() && (int) get_option( 'page_for_posts' ) ) {
		$lead = get_the_excerpt( (int) get_option( 'page_for_posts' ) );
	} elseif ( is_archive() ) {
		$lead = get_the_archive_description();
	} elseif ( is_singular() && has_excerpt() ) {
		$lead = get_the_excerpt();
	} else {
		$lead = '';
	}
	return trim( wp_strip_all_tags( (string) $lead ) );
}

/**
 * Inner-page title bar. Not shown on a static front page, 404 pages and single posts,
 * which have their own heading (one h1 per page). A front page that lists the latest
 * posts keeps it, so the posts index still has its h1. Pages on the Landing page template start
 * with their own hero.
 */
function sashwell_lite_title_bar() {
	if ( ! sashwell_lite_option( 'title_bar' ) || ( is_front_page() && ! is_home() ) || is_404() || is_singular( 'post' ) || sashwell_lite_is_landing() ) {
		return;
	}
	get_template_part( 'template-parts/title-bar' );
}

/**
 * The design's wordmark , drawn in currentColor so it
 * follows the header, the footer and dark mode. Only used when Customize > Theme options >
 * Header > "Logo without an uploaded image" is set to the wordmark.
 *
 * @return string Fixed SVG markup from this file, no user input.
 */
function sashwell_lite_wordmark() {
	return '<svg class="logo" viewBox="-20 -790 4196 990" aria-hidden="true" focusable="false"><g><path fill="currentColor" d="M276 14Q223 14 180.0 4.0Q137 -6 106.0 -25.0Q75 -44 56.0 -70.5Q37 -97 31 -130L141 -175Q145 -153 163.0 -134.0Q181 -115 211.5 -103.5Q242 -92 285 -92Q331 -92 356.0 -105.5Q381 -119 381 -144Q381 -163 367.0 -174.0Q353 -185 326.0 -193.0Q299 -201 261 -208Q224 -217 185.5 -227.0Q147 -237 114.5 -255.0Q82 -273 61.5 -302.5Q41 -332 41 -378Q41 -426 67.0 -462.0Q93 -498 143.0 -518.5Q193 -539 265 -539Q330 -539 379.0 -521.5Q428 -504 459.5 -471.5Q491 -439 502 -394L385 -355Q381 -379 365.5 -397.0Q350 -415 324.5 -424.0Q299 -433 265 -433Q222 -433 198.5 -419.0Q175 -405 175 -382Q175 -363 190.5 -351.0Q206 -339 234.0 -331.5Q262 -324 300 -316Q340 -308 378.0 -297.5Q416 -287 446.5 -270.0Q477 -253 495.0 -225.0Q513 -197 513 -153Q513 -101 485.0 -63.5Q457 -26 404.0 -6.0Q351 14 276 14Z M713 14Q669 14 635.0 -3.5Q601 -21 582.0 -54.0Q563 -87 563 -136Q563 -179 579.5 -208.0Q596 -237 628.0 -255.0Q660 -273 707.0 -285.0Q754 -297 814 -306Q846 -311 866.5 -315.5Q887 -320 897.0 -330.5Q907 -341 907 -361Q907 -389 887.0 -409.0Q867 -429 824 -429Q795 -429 770.5 -419.0Q746 -409 728.5 -389.0Q711 -369 703 -338L576 -377Q588 -418 610.5 -448.0Q633 -478 665.0 -498.5Q697 -519 738.0 -529.0Q779 -539 827 -539Q904 -539 952.5 -514.5Q1001 -490 1025.0 -438.5Q1049 -387 1049 -306V-216Q1049 -181 1050.5 -145.0Q1052 -109 1054.5 -72.5Q1057 -36 1060 0H933Q929 -25 925.5 -57.5Q922 -90 920 -123H902Q888 -85 862.0 -54.0Q836 -23 798.5 -4.5Q761 14 713 14ZM774 -90Q793 -90 812.5 -97.0Q832 -104 850.5 -116.5Q869 -129 884.5 -148.0Q900 -167 910 -191L908 -275L931 -270Q913 -257 889.0 -249.5Q865 -242 839.5 -238.0Q814 -234 789.0 -229.0Q764 -224 744.5 -216.0Q725 -208 713.5 -194.5Q702 -181 702 -157Q702 -126 722.0 -108.0Q742 -90 774 -90Z M1365 14Q1312 14 1269.0 4.0Q1226 -6 1195.0 -25.0Q1164 -44 1145.0 -70.5Q1126 -97 1120 -130L1230 -175Q1234 -153 1252.0 -134.0Q1270 -115 1300.5 -103.5Q1331 -92 1374 -92Q1420 -92 1445.0 -105.5Q1470 -119 1470 -144Q1470 -163 1456.0 -174.0Q1442 -185 1415.0 -193.0Q1388 -201 1350 -208Q1313 -217 1274.5 -227.0Q1236 -237 1203.5 -255.0Q1171 -273 1150.5 -302.5Q1130 -332 1130 -378Q1130 -426 1156.0 -462.0Q1182 -498 1232.0 -518.5Q1282 -539 1354 -539Q1419 -539 1468.0 -521.5Q1517 -504 1548.5 -471.5Q1580 -439 1591 -394L1474 -355Q1470 -379 1454.5 -397.0Q1439 -415 1413.5 -424.0Q1388 -433 1354 -433Q1311 -433 1287.5 -419.0Q1264 -405 1264 -382Q1264 -363 1279.5 -351.0Q1295 -339 1323.0 -331.5Q1351 -324 1389 -316Q1429 -308 1467.0 -297.5Q1505 -287 1535.5 -270.0Q1566 -253 1584.0 -225.0Q1602 -197 1602 -153Q1602 -101 1574.0 -63.5Q1546 -26 1493.0 -6.0Q1440 14 1365 14Z M1679 0V-330V-715H1824V-551Q1824 -531 1822.5 -509.0Q1821 -487 1817.5 -464.5Q1814 -442 1810.5 -419.0Q1807 -396 1803 -373H1825Q1839 -424 1860.5 -461.0Q1882 -498 1916.0 -518.5Q1950 -539 2002 -539Q2094 -539 2140.0 -474.5Q2186 -410 2186 -277V0H2041V-255Q2041 -339 2016.5 -379.5Q1992 -420 1943 -420Q1903 -420 1877.0 -396.0Q1851 -372 1838.0 -331.5Q1825 -291 1823 -241V0Z M2369 0 2239 -525H2389L2463 -114H2482L2570 -525H2743L2834 -114H2853L2925 -525H3072L2941 0H2743L2661 -408H2644L2566 0Z M3377 14Q3312 14 3261.5 -4.0Q3211 -22 3176.0 -56.0Q3141 -90 3122.5 -140.0Q3104 -190 3104 -253Q3104 -315 3121.5 -367.5Q3139 -420 3173.0 -458.5Q3207 -497 3256.0 -518.0Q3305 -539 3367 -539Q3427 -539 3474.0 -519.5Q3521 -500 3552.5 -461.0Q3584 -422 3598.5 -365.5Q3613 -309 3609 -236L3197 -232V-311L3526 -314L3475 -274Q3482 -327 3468.0 -361.0Q3454 -395 3427.5 -411.0Q3401 -427 3369 -427Q3331 -427 3302.0 -407.0Q3273 -387 3257.0 -348.5Q3241 -310 3241 -256Q3241 -171 3278.5 -131.0Q3316 -91 3377 -91Q3405 -91 3424.5 -98.5Q3444 -106 3456.5 -118.0Q3469 -130 3476.5 -145.0Q3484 -160 3489 -175L3614 -148Q3605 -111 3587.5 -81.5Q3570 -52 3541.0 -30.5Q3512 -9 3471.5 2.5Q3431 14 3377 14Z M3694 0V-715H3836V0Z M3948 0V-715H4090V0Z"/><path class="logo-wipe" style="fill:var(--lw)" d="M2190 163 C2590 115 3856 95 4116 95 A40 40 0 0 1 4116 175 L2250 175 Q2190 175 2190 163 Z"/></g></svg>';
}

/**
 * Logo link: the uploaded logo (Appearance > Customize > Site Identity), or, without one, the
 * Sashwell wordmark or the site name (Customize > Theme options > Header).
 *
 * @param string $css_class Extra class on the link.
 */
function sashwell_lite_brand( $css_class = '' ) {
	$logo_id = (int) get_theme_mod( 'custom_logo' );
	$name    = get_bloginfo( 'name' );

	if ( $logo_id ) {
		$inner = wp_kses_post(
			wp_get_attachment_image(
				$logo_id,
				'full',
				false,
				array(
					'class'   => 'logo logo-img',
					'alt'     => '',
					'loading' => false,
				)
			)
		);
	} elseif ( 'wordmark' === sashwell_lite_option( 'logo_fallback' ) ) {
		$inner = sashwell_lite_wordmark(); // A constant of this theme; its inline style would not pass wp_kses.
	} else {
		$inner = '<span class="brand-name">' . esc_html( $name ) . '</span>';
	}

	printf(
		'<a class="%1$s" href="%2$s" rel="home" aria-label="%3$s">%4$s</a>',
		esc_attr( trim( 'brand ' . $css_class ) ),
		esc_url( home_url( '/' ) ),
		/* translators: %s: site name. */
		esc_attr( sprintf( __( '%s, home', 'sashwell-lite' ), $name ) ),
		$inner // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above: wp_kses_post() for the image, esc_html() for the name, a fixed constant for the wordmark.
	);
}

/**
 * The tel: link for a phone number.
 *
 * The site's own number (empty, or equal to the "Phone number" option) uses the "Phone number for call
 * links" option (international form, e.g. +13035550132) when it is set; any other number, or an empty
 * option, uses the digits (and a leading +) of the number as shown.
 *
 * @param string $phone Phone number as shown. Empty = the site's phone number.
 * @return string The tel: URL, or an empty string when there is no number.
 */
function sashwell_lite_tel( $phone = '' ) {
	$phone = trim( (string) $phone );
	$site  = trim( (string) sashwell_lite_option( 'phone' ) );
	if ( '' === $phone || $phone === $site ) {
		$tel = sashwell_lite_tel_digits( (string) sashwell_lite_option( 'tel' ) );
		if ( '' !== $tel ) {
			return 'tel:' . $tel;
		}
		$phone = '' === $phone ? $site : $phone;
	}
	$tel = sashwell_lite_tel_digits( $phone );
	return '' === $tel ? '' : 'tel:' . $tel;
}

/**
 * Digits of a phone number, keeping one leading +.
 *
 * @param string $phone Phone number in any format.
 * @return string
 */
function sashwell_lite_tel_digits( $phone ) {
	$phone  = trim( (string) $phone );
	$plus   = 0 === strpos( $phone, '+' ) ? '+' : '';
	$digits = preg_replace( '/[^0-9]/', '', $phone );
	return '' === $digits ? '' : $plus . $digits;
}

/**
 * The WhatsApp chat link, or an empty string when no number is set.
 *
 * @return string
 */
function sashwell_lite_whatsapp_url() {
	$number = preg_replace( '/[^0-9]/', '', (string) sashwell_lite_option( 'whatsapp' ) );
	if ( '' === $number ) {
		return '';
	}
	$text = (string) sashwell_lite_option( 'whatsapp_text' );
	return 'https://wa.me/' . $number . ( '' !== $text ? '?text=' . rawurlencode( $text ) : '' );
}

/**
 * Social profiles that have an address, in display order.
 *
 * @param bool $with_whatsapp Add the WhatsApp chat link at the end.
 * @return array[] Each: array( 'icon', 'label', 'url' ).
 */
function sashwell_lite_social_links( $with_whatsapp = false ) {
	$networks = array(
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'linkedin'  => 'LinkedIn',
		'x'         => 'X',
		'youtube'   => 'YouTube',
		'tiktok'    => 'TikTok',
	);
	$links    = array();
	foreach ( $networks as $key => $label ) {
		$url = (string) sashwell_lite_option( 'social_' . $key );
		if ( '' !== $url ) {
			$links[] = array(
				'icon'  => $key,
				'label' => $label,
				'url'   => $url,
			);
		}
	}
	if ( $with_whatsapp && sashwell_lite_whatsapp_url() ) {
		$links[] = array(
			'icon'  => 'whatsapp',
			'label' => 'WhatsApp',
			'url'   => sashwell_lite_whatsapp_url(),
		);
	}
	return $links;
}

/**
 * Lines of a multi-line option, trimmed, empty lines removed.
 *
 * @param string $key Option key.
 * @return string[]
 */
function sashwell_lite_option_lines( $key ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\R/', (string) sashwell_lite_option( $key ) ) ) ) );
}

/**
 * The "get a price" card at the end of the mega menu.
 *
 * @param string $title Label; empty = Customize > Theme options > Header.
 * @param string $text  Text; empty = Customize > Theme options > Header.
 * @return string Escaped markup, or an empty string.
 */
function sashwell_lite_menu_card( $title = '', $text = '' ) {
	$phone = (string) sashwell_lite_option( 'phone' );
	$cta   = (string) sashwell_lite_option( 'header_cta_url' );
	if ( ! sashwell_lite_option( 'menu_card' ) || ( '' === $phone && '' === $cta ) ) {
		return '';
	}

	$title = '' !== $title ? $title : (string) sashwell_lite_option( 'menu_card_title' );
	$text  = '' !== $text ? $text : (string) sashwell_lite_option( 'menu_card_text' );
	$html  = '<div class="sub-card"><p class="sub-h">' . esc_html( $title ) . '</p>';
	if ( '' !== $text ) {
		$html .= '<p class="sub-card-t">' . esc_html( $text ) . '</p>';
	}
	if ( '' !== $phone ) {
		$html .= '<a class="sub-phone" href="' . esc_url( sashwell_lite_tel( $phone ) ) . '">' . esc_html( $phone ) . '</a>';
	}
	if ( sashwell_lite_option( 'hours' ) ) {
		$html .= '<p class="sub-card-s">' . esc_html( sashwell_lite_option( 'hours' ) ) . '</p>';
	}
	if ( '' !== $cta ) {
		$html .= '<a class="btn btn--white" href="' . esc_url( $cta ) . '">' . esc_html( sashwell_lite_option( 'header_cta_text' ) ) . sashwell_lite_icon( 'arrow', 'flip' ) . '</a>';
	}
	return $html . '</div>';
}

/**
 * Breadcrumb trail: Home, then archive or parent pages, then the current view.
 *
 * @param string $css_class Class on the <nav>.
 */
function sashwell_lite_breadcrumbs( $css_class = 'crumbs' ) {
	if ( ! sashwell_lite_option( 'breadcrumb' ) || is_front_page() ) {
		return;
	}

	$trail = array( array( __( 'Home', 'sashwell-lite' ), home_url( '/' ) ) );

	if ( is_singular( 'post' ) || is_category() || is_tag() || is_date() || is_author() ) {
		$blog = (int) get_option( 'page_for_posts' );
		if ( $blog ) {
			$trail[] = array( get_the_title( $blog ), get_permalink( $blog ) );
		}
	} elseif ( is_singular() && ! is_page() ) {
		$type = get_post_type_object( get_post_type() );
		if ( $type && $type->has_archive ) {
			$trail[] = array( $type->labels->name, get_post_type_archive_link( $type->name ) );
		}
	} elseif ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_queried_object_id() ) ) as $ancestor ) {
			$trail[] = array( get_the_title( $ancestor ), get_permalink( $ancestor ) );
		}
	}

	$cat = is_singular( 'post' ) ? sashwell_lite_primary_category() : null;
	if ( $cat ) {
		// Articles end with their topic, as in the design; the title is the h1 right below.
		$trail[] = array( $cat->name, get_category_link( $cat ) );
	} else {
		$trail[] = array( sashwell_lite_page_title(), '' );
	}

	echo '<nav class="' . esc_attr( $css_class ) . '" aria-label="' . esc_attr__( 'Breadcrumb', 'sashwell-lite' ) . '"><ol>';
	foreach ( $trail as $crumb ) {
		if ( '' === $crumb[1] ) {
			echo '<li><span aria-current="page">' . esc_html( wp_strip_all_tags( $crumb[0] ) ) . '</span></li>';
		} else {
			echo '<li><a href="' . esc_url( $crumb[1] ) . '">' . esc_html( wp_strip_all_tags( $crumb[0] ) ) . '</a></li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * Links listed on the 404 page (`ul.nf-links`): the "404 page links" menu, or the top items of the
 * main menu when that location is empty. Each item's Description (Appearance > Menus > Screen
 * Options > Description) is the small line under the title.
 *
 * @param int $max Most links to return.
 * @return array List of array( title, url, description ).
 */
function sashwell_lite_404_links( $max = 6 ) {
	$locations = get_nav_menu_locations();
	$links     = array();

	foreach ( array( 'not_found', 'primary' ) as $location ) {
		if ( empty( $locations[ $location ] ) ) {
			continue;
		}
		$items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( ! $items ) {
			continue;
		}
		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent || '' === (string) $item->url ) {
				continue;
			}
			$links[] = array( $item->title, $item->url, isset( $item->description ) ? (string) $item->description : '' );
			if ( count( $links ) >= $max ) {
				break;
			}
		}
		if ( $links ) {
			break;
		}
	}

	return apply_filters( 'sashwell_lite_404_links', $links );
}

/**
 * The entry content. A password-protected entry prints the core password form as it is, without
 * the content filters: wpautop would wrap the form's hidden field and leave a stray </p>.
 */
function sashwell_lite_the_content() {
	if ( post_password_required() ) {
		echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core form markup, built and escaped by WordPress.
		return;
	}
	the_content();
}
