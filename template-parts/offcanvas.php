<?php
/**
 * Off-canvas panel: menu, contact lines, areas covered, call to action, social links.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_phone    = (string) sashwell_lite_option( 'phone' );
$sashwell_lite_email    = (string) sashwell_lite_option( 'email' );
$sashwell_lite_address  = (string) sashwell_lite_option( 'address' );
$sashwell_lite_wa       = sashwell_lite_whatsapp_url();
$sashwell_lite_areas    = sashwell_lite_option_lines( 'oc_areas' );
$sashwell_lite_cta_url  = (string) sashwell_lite_option( 'header_cta_url' );
$sashwell_lite_location = has_nav_menu( 'offcanvas' ) ? 'offcanvas' : ( has_nav_menu( 'primary' ) ? 'primary' : '' );
$sashwell_lite_social   = sashwell_lite_social_links();
$sashwell_lite_contact  = '' !== $sashwell_lite_phone || '' !== $sashwell_lite_email || '' !== $sashwell_lite_address || '' !== $sashwell_lite_wa;
// On wide screens the design shows only the contact details here (the menu is in the bar). With none set, the menu stays.
$sashwell_lite_bare = ! $sashwell_lite_contact && ! $sashwell_lite_areas && '' === $sashwell_lite_cta_url && ! sashwell_lite_option( 'proof' ) && ! $sashwell_lite_social;
?>
<div class="<?php echo esc_attr( $sashwell_lite_bare ? 'layer offcanvas oc-bare' : 'layer offcanvas' ); ?>" id="offcanvas" hidden>
	<div class="backdrop" data-close></div>
	<div class="panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menu and contact details', 'sashwell-lite' ); ?>">
		<div class="panel-head">
			<?php sashwell_lite_brand(); ?>
			<div class="tools">
				<button class="icon-btn sm-only" type="button" data-open="search" aria-label="<?php esc_attr_e( 'Search the site', 'sashwell-lite' ); ?>"><?php sashwell_lite_the_icon( 'search' ); ?></button>
				<?php if ( sashwell_lite_option( 'dark_toggle' ) ) : ?>
					<button class="icon-btn theme-toggle sm-only" type="button" aria-label="<?php esc_attr_e( 'Dark mode', 'sashwell-lite' ); ?>" aria-pressed="false"><?php sashwell_lite_the_icon( 'sun', 'sun' ); ?><?php sashwell_lite_the_icon( 'moon', 'moon' ); ?></button>
				<?php endif; ?>
				<button class="icon-btn" type="button" data-close aria-label="<?php esc_attr_e( 'Close menu', 'sashwell-lite' ); ?>"><?php sashwell_lite_the_icon( 'close' ); ?></button>
			</div>
		</div>
		<?php if ( $sashwell_lite_location ) : ?>
			<nav class="oc-nav" aria-label="<?php esc_attr_e( 'Mobile', 'sashwell-lite' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => $sashwell_lite_location,
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'depth'          => 3,
						'walker'         => new Sashwell_Lite_Walker_Offcanvas(),
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>
		<div class="oc-body">
			<?php if ( $sashwell_lite_contact ) : ?>
				<section class="oc-contact" aria-labelledby="oc-h">
					<?php if ( sashwell_lite_option( 'hours' ) ) : ?>
						<p class="oc-status"><i aria-hidden="true"></i><span><?php echo esc_html( sashwell_lite_option( 'hours' ) ); ?></span></p>
					<?php endif; ?>
					<h2 class="oc-h" id="oc-h"><?php echo esc_html( sashwell_lite_option( 'oc_title' ) ); ?> <span><?php echo esc_html( sashwell_lite_option( 'oc_title_soft' ) ); ?></span></h2>
					<?php if ( '' !== $sashwell_lite_phone ) : ?>
						<a class="oc-phone" href="<?php echo esc_url( sashwell_lite_tel( $sashwell_lite_phone ) ); ?>"><?php echo esc_html( $sashwell_lite_phone ); ?></a>
					<?php endif; ?>
					<ul class="oc-lines">
						<?php if ( '' !== $sashwell_lite_wa ) : ?>
							<li><a href="<?php echo esc_url( $sashwell_lite_wa ); ?>" target="_blank" rel="noopener"><span class="oc-l-ic" aria-hidden="true"><?php sashwell_lite_the_icon( 'whatsapp' ); ?></span><span class="oc-l-k">WhatsApp</span><span class="oc-l-v"><?php echo esc_html( sashwell_lite_option( 'whatsapp_note' ) ); ?></span><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a></li>
						<?php endif; ?>
						<?php if ( '' !== $sashwell_lite_email ) : ?>
							<li><a href="<?php echo esc_url( 'mailto:' . $sashwell_lite_email ); ?>"><span class="oc-l-ic" aria-hidden="true"><?php sashwell_lite_the_icon( 'mail' ); ?></span><span class="oc-l-k"><?php esc_html_e( 'Email', 'sashwell-lite' ); ?></span><span class="oc-l-v"><?php echo esc_html( $sashwell_lite_email ); ?></span><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a></li>
						<?php endif; ?>
						<?php if ( '' !== $sashwell_lite_address ) : ?>
							<li><a href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $sashwell_lite_address ) ); ?>" target="_blank" rel="noopener"><span class="oc-l-ic" aria-hidden="true"><?php sashwell_lite_the_icon( 'building' ); ?></span><span class="oc-l-k"><?php esc_html_e( 'Visit', 'sashwell-lite' ); ?></span><span class="oc-l-v"><?php echo esc_html( $sashwell_lite_address ); ?></span><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a></li>
						<?php endif; ?>
					</ul>
				</section>
			<?php endif; ?>
			<?php if ( $sashwell_lite_areas ) : ?>
				<section class="oc-area" aria-labelledby="oc-area-h">
					<h2 class="oc-k" id="oc-area-h"><?php echo esc_html( sashwell_lite_option( 'oc_areas_title' ) ); ?></h2>
					<ul class="oc-route">
						<?php
						foreach ( $sashwell_lite_areas as $sashwell_lite_area ) {
							$sashwell_lite_parts = array_map( 'trim', explode( '|', $sashwell_lite_area, 2 ) );
							echo '<li>' . esc_html( $sashwell_lite_parts[0] ) . ( isset( $sashwell_lite_parts[1] ) && '' !== $sashwell_lite_parts[1] ? '<small>' . esc_html( $sashwell_lite_parts[1] ) . '</small>' : '' ) . '</li>';
						}
						?>
					</ul>
					<?php if ( sashwell_lite_option( 'oc_areas_link' ) ) : ?>
						<a class="oc-more" href="<?php echo esc_url( sashwell_lite_option( 'oc_areas_link' ) ); ?>"><?php esc_html_e( 'Check your ZIP code', 'sashwell-lite' ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a>
					<?php endif; ?>
				</section>
			<?php endif; ?>
			<?php if ( '' !== $sashwell_lite_cta_url || sashwell_lite_option( 'proof' ) || $sashwell_lite_social ) : ?>
				<div class="oc-end">
					<?php if ( '' !== $sashwell_lite_cta_url ) : ?>
						<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $sashwell_lite_cta_url ); ?>"><?php echo esc_html( sashwell_lite_option( 'header_cta_text' ) ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a>
					<?php endif; ?>
					<?php if ( sashwell_lite_option( 'proof' ) ) : ?>
						<p class="oc-proof"><?php echo wp_kses( sashwell_lite_option( 'proof' ), array( 'b' => array() ) ); ?></p>
					<?php endif; ?>
					<?php if ( $sashwell_lite_social ) : ?>
						<ul class="oc-social">
							<?php foreach ( $sashwell_lite_social as $sashwell_lite_link ) : ?>
								<li><a href="<?php echo esc_url( $sashwell_lite_link['url'] ); ?>" aria-label="<?php echo esc_attr( $sashwell_lite_link['label'] ); ?>"><?php sashwell_lite_the_icon( $sashwell_lite_link['icon'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
