<?php
/**
 * Not found: crumbs, kicker, heading, lead, the home button and search link, the most visited
 * pages (`ul.nf-links`) and the large background word. Texts come from Customize > Theme options >
 * 404 page; the links from the "404 page links" menu.
 *
 * @package Sashwell_Lite
 */

get_header();

$sashwell_lite_kicker = (string) sashwell_lite_option( 'error_kicker' );
$sashwell_lite_title  = (string) sashwell_lite_option( 'error_title' );
$sashwell_lite_mark   = (string) sashwell_lite_option( 'error_mark' );
$sashwell_lite_lead   = (string) sashwell_lite_option( 'error_text' );
$sashwell_lite_word   = (string) sashwell_lite_option( 'error_word' );
$sashwell_lite_links  = sashwell_lite_404_links();
?>
<section class="phero phero--404" aria-labelledby="ph-h">
	<div class="ph-panel">
		<div class="wrap ph-grid">
			<div class="ph-copy">
				<?php if ( sashwell_lite_option( 'breadcrumb' ) ) : ?>
					<nav class="ph-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'sashwell-lite' ); ?>">
						<ol>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'sashwell-lite' ); ?></a></li>
							<li><span aria-current="page"><?php esc_html_e( 'Page not found', 'sashwell-lite' ); ?></span></li>
						</ol>
					</nav>
				<?php endif; ?>
				<?php if ( '' !== $sashwell_lite_kicker ) : ?>
					<p class="ph-kicker"><span class="dot" aria-hidden="true"></span><?php echo esc_html( $sashwell_lite_kicker ); ?></p>
				<?php endif; ?>
				<h1 id="ph-h">
					<?php
					echo esc_html( $sashwell_lite_title );
					if ( '' !== $sashwell_lite_mark ) {
						echo ' <span class="ph-mark">' . esc_html( $sashwell_lite_mark ) . '</span>';
					}
					?>
				</h1>
				<?php if ( '' !== $sashwell_lite_lead ) : ?>
					<p class="ph-lead"><?php echo esc_html( $sashwell_lite_lead ); ?></p>
				<?php endif; ?>
				<div class="ph-cta"><a class="btn btn--primary btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the home page', 'sashwell-lite' ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a><button class="ph-link" type="button" data-open="search" aria-haspopup="dialog"><?php esc_html_e( 'Search the site', 'sashwell-lite' ); ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></button></div>
				<?php if ( $sashwell_lite_links ) : ?>
					<ul class="nf-links">
						<?php foreach ( $sashwell_lite_links as $sashwell_lite_link ) : ?>
							<li><a href="<?php echo esc_url( $sashwell_lite_link[1] ); ?>"><b><?php echo esc_html( wp_strip_all_tags( $sashwell_lite_link[0] ) ); ?></b><?php echo '' !== $sashwell_lite_link[2] ? '<span>' . esc_html( $sashwell_lite_link[2] ) . '</span>' : ''; ?><?php sashwell_lite_the_icon( 'arrow', 'flip' ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( '' !== $sashwell_lite_word ) : ?>
			<p class="ph-word" aria-hidden="true"><?php echo esc_html( $sashwell_lite_word ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
