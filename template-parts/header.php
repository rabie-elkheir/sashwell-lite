<?php
/**
 * Header style 1, ported from the approved pages (utility bar, mega menu, actions).
 *
 * @package Sashwell_Lite
 */

get_template_part( 'template-parts/utility' );

$sashwell_lite_cta_url = (string) sashwell_lite_option( 'header_cta_url' );
?>
<header class="header">
	<div class="wrap">
		<?php sashwell_lite_brand(); ?>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="nav" aria-label="<?php esc_attr_e( 'Main', 'sashwell-lite' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'depth'          => 3,
						'walker'         => new Sashwell_Lite_Walker_Nav(),
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>
		<div class="header-actions">
			<button class="icon-btn" type="button" data-open="search" aria-label="<?php esc_attr_e( 'Search the site', 'sashwell-lite' ); ?>" aria-haspopup="dialog"><?php sashwell_lite_the_icon( 'search' ); ?></button>
			<?php if ( sashwell_lite_option( 'dark_toggle' ) ) : ?>
				<button class="icon-btn theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Dark mode', 'sashwell-lite' ); ?>" aria-pressed="false"><?php sashwell_lite_the_icon( 'sun', 'sun' ); ?><?php sashwell_lite_the_icon( 'moon', 'moon' ); ?></button>
			<?php endif; ?>
			<?php if ( '' !== $sashwell_lite_cta_url ) : ?>
				<span class="hdr-sep" aria-hidden="true"></span>
				<a class="btn btn--primary header-cta magnetic" href="<?php echo esc_url( $sashwell_lite_cta_url ); ?>"><?php echo esc_html( sashwell_lite_option( 'header_cta_text' ) ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a>
			<?php endif; ?>
			<button class="icon-btn" type="button" data-open="offcanvas" aria-label="<?php esc_attr_e( 'Menu and contact details', 'sashwell-lite' ); ?>" aria-haspopup="dialog"><?php sashwell_lite_the_icon( 'menu' ); ?></button>
		</div>
	</div>
</header>
