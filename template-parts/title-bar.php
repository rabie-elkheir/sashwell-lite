<?php
/**
 * Title bar. Blog views use the blog header (.bhead); pages and other content use the inner-page hero (.phero).
 *
 * @package Sashwell_Lite
 */

$sashwell_lite_title = sashwell_lite_page_title();
$sashwell_lite_lead  = sashwell_lite_page_lead();

if ( sashwell_lite_is_blog_view() ) : ?>
	<div class="bhead">
		<div class="wrap">
			<?php sashwell_lite_breadcrumbs( 'crumbs' ); ?>
			<div class="bhead-g">
				<h1 class="h2x reveal"><?php echo esc_html( $sashwell_lite_title ); ?></h1>
				<?php if ( '' !== $sashwell_lite_lead ) : ?>
					<div class="bhead-side">
						<p class="lead"><?php echo esc_html( $sashwell_lite_lead ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php else : ?>
	<section class="phero" aria-labelledby="ph-h">
		<div class="ph-panel">
			<div class="wrap ph-grid">
				<div class="ph-copy">
					<?php sashwell_lite_breadcrumbs( 'ph-crumbs' ); ?>
					<h1 id="ph-h"><?php echo esc_html( $sashwell_lite_title ); ?></h1>
					<?php if ( '' !== $sashwell_lite_lead ) : ?>
						<p class="ph-lead"><?php echo esc_html( $sashwell_lite_lead ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
endif;
