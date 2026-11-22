<?php
/**
 * Footer style 1, ported from the approved pages: call to action, brand column,
 * three widget columns, legal links, motion switch and social links.
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_phone   = (string) sashwell_lite_option( 'phone' );
$sashwell_lite_email   = (string) sashwell_lite_option( 'email' );
$sashwell_lite_address = (string) sashwell_lite_option( 'address' );
$sashwell_lite_cta_t   = (string) sashwell_lite_option( 'ft_cta_title' );
$sashwell_lite_cta_url = (string) sashwell_lite_option( 'ft_cta_url' );
$sashwell_lite_badges  = sashwell_lite_option_lines( 'footer_badges' );
$sashwell_lite_social  = sashwell_lite_social_links( true );
$sashwell_lite_text    = (string) sashwell_lite_option( 'footer_text' );

// With nothing to show above the bottom bar (a fresh install), the footer is only the bottom bar.
$sashwell_lite_full = '' !== $sashwell_lite_cta_t || '' !== $sashwell_lite_address || '' !== $sashwell_lite_email || $sashwell_lite_badges
	|| sashwell_lite_option( 'footer_about' ) || sashwell_lite_option( 'office_hours' )
	|| is_active_sidebar( 'sashwell-lite-footer-1' ) || is_active_sidebar( 'sashwell-lite-footer-2' ) || is_active_sidebar( 'sashwell-lite-footer-3' );
?>
<footer class="<?php echo esc_attr( $sashwell_lite_full ? 'footer' : 'footer footer--simple' ); ?>">
	<div class="wrap">
		<?php if ( $sashwell_lite_full ) : ?>
			<?php if ( '' !== $sashwell_lite_cta_t ) : ?>
				<div class="ft-cta">
					<h2 class="ft-h"><?php echo esc_html( $sashwell_lite_cta_t ); ?> <span><?php echo esc_html( sashwell_lite_option( 'ft_cta_soft' ) ); ?></span></h2>
					<div class="ft-act">
						<?php if ( '' !== $sashwell_lite_cta_url ) : ?>
							<a class="btn btn--lemon btn--lg magnetic" href="<?php echo esc_url( $sashwell_lite_cta_url ); ?>"><?php echo esc_html( sashwell_lite_option( 'ft_cta_text' ) ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a>
						<?php endif; ?>
						<?php if ( '' !== $sashwell_lite_phone ) : ?>
							<a class="ft-phone" href="<?php echo esc_url( sashwell_lite_tel( $sashwell_lite_phone ) ); ?>"><span><?php echo esc_html( sashwell_lite_option( 'ft_phone_label' ) ); ?></span><?php echo esc_html( $sashwell_lite_phone ); ?></a>
						<?php endif; ?>
					</div>
				</div>
		<?php endif; ?>
		<div class="footer-grid">
			<div class="ft-brand">
				<?php sashwell_lite_brand(); ?>
				<?php if ( sashwell_lite_option( 'footer_about' ) ) : ?>
					<p><?php echo esc_html( sashwell_lite_option( 'footer_about' ) ); ?></p>
				<?php endif; ?>
				<?php if ( sashwell_lite_option( 'office_hours' ) ) : ?>
					<p class="ft-open"><i aria-hidden="true"></i><span><?php echo esc_html( sashwell_lite_option( 'office_hours' ) ); ?></span></p>
				<?php endif; ?>
				<?php if ( '' !== $sashwell_lite_address || '' !== $sashwell_lite_email ) : ?>
					<address>
						<?php echo esc_html( $sashwell_lite_address ); ?>
						<?php if ( '' !== $sashwell_lite_address && '' !== $sashwell_lite_email ) : ?>
							<br>
						<?php endif; ?>
						<?php if ( '' !== $sashwell_lite_email ) : ?>
							<a href="<?php echo esc_url( 'mailto:' . $sashwell_lite_email ); ?>"><?php echo esc_html( $sashwell_lite_email ); ?></a>
						<?php endif; ?>
					</address>
				<?php endif; ?>
			</div>
			<?php for ( $sashwell_lite_i = 1; $sashwell_lite_i <= 3; $sashwell_lite_i++ ) : ?>
				<div class="<?php echo esc_attr( 3 === $sashwell_lite_i ? 'ft-col ft-news' : 'ft-col' ); ?>">
					<?php
					if ( is_active_sidebar( 'sashwell-lite-footer-' . $sashwell_lite_i ) ) {
						dynamic_sidebar( 'sashwell-lite-footer-' . $sashwell_lite_i );
					}
					if ( 3 === $sashwell_lite_i && $sashwell_lite_badges ) {
						echo '<ul class="ft-badges">';
						foreach ( $sashwell_lite_badges as $sashwell_lite_badge ) {
							echo '<li>' . esc_html( $sashwell_lite_badge ) . '</li>';
						}
						echo '</ul>';
					}
					?>
				</div>
			<?php endfor; ?>
		</div>
		<?php endif; ?>
		<div class="footer-bottom">
			<?php
			if ( ! $sashwell_lite_full ) {
				sashwell_lite_brand();
			}
			?>
			<p>
				<?php
				if ( '' !== $sashwell_lite_text ) {
					echo esc_html( $sashwell_lite_text );
				} else {
					echo '&copy; ' . esc_html( gmdate( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) );
				}
				?>
			</p>
			<ul class="ft-legal">
				<?php
				if ( has_nav_menu( 'legal' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'legal',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				}
				?>
				<?php if ( sashwell_lite_option( 'motion' ) ) : ?>
					<li><button class="motion-toggle" type="button" aria-pressed="false"><?php esc_html_e( 'Reduce motion', 'sashwell-lite' ); ?></button></li>
				<?php endif; ?>
			</ul>
			<div class="ft-end">
				<?php if ( $sashwell_lite_social ) : ?>
					<p class="ft-follow"><?php esc_html_e( 'Follow us', 'sashwell-lite' ); ?></p>
					<ul class="ft-social">
						<?php foreach ( $sashwell_lite_social as $sashwell_lite_link ) : ?>
							<li><a href="<?php echo esc_url( $sashwell_lite_link['url'] ); ?>" aria-label="<?php echo esc_attr( $sashwell_lite_link['label'] ); ?>"><?php sashwell_lite_the_icon( $sashwell_lite_link['icon'] ); ?><span><?php echo esc_html( $sashwell_lite_link['label'] ); ?></span></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<a class="to-top" href="#main" aria-label="<?php esc_attr_e( 'Back to top', 'sashwell-lite' ); ?>"><?php sashwell_lite_the_icon( 'top' ); ?></a>
			</div>
		</div>
	</div>
	<?php if ( $sashwell_lite_full ) : ?>
		<p class="foot-mark" aria-hidden="true"><?php echo esc_html( strtolower( get_bloginfo( 'name' ) ) ); ?></p>
	<?php endif; ?>
</footer>
<?php
get_template_part( 'template-parts/dock' );
