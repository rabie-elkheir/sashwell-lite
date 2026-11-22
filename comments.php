<?php
/**
 * Comments section. Posting and replies use WordPress's own comment system.
 *
 * @package Sashwell_Lite
 */

if ( post_password_required() ) {
	return;
}

$sashwell_lite_count = (int) get_comments_number();
?>
<section class="sec sec--mist" aria-labelledby="cm-h" id="comments">
	<div class="wrap">
		<div class="sec-head">
			<div>
				<p class="eyebrow"><span>01</span><?php esc_html_e( 'Comments', 'sashwell-lite' ); ?></p>
				<h2 class="h2x reveal" id="cm-h">
					<?php
					if ( $sashwell_lite_count ) {
						/* translators: %s: number of comments. */
						echo esc_html( sprintf( _n( '%s comment,', '%s comments,', $sashwell_lite_count, 'sashwell-lite' ), number_format_i18n( $sashwell_lite_count ) ) );
						echo ' <span class="soft">' . esc_html__( 'newest last.', 'sashwell-lite' ) . '</span>';
					} else {
						echo esc_html__( 'No comments yet,', 'sashwell-lite' ) . ' <span class="soft">' . esc_html__( 'ask the first question.', 'sashwell-lite' ) . '</span>';
					}
					?>
				</h2>
			</div>
			<?php if ( comments_open() ) : ?>
				<p><?php esc_html_e( 'Ask about your own home or job. Comments are read before they appear.', 'sashwell-lite' ); ?></p>
			<?php endif; ?>
		</div>
		<div class="cm-g">
			<?php if ( have_comments() ) : ?>
				<ol class="cms">
						<?php
						wp_list_comments(
							array(
								'style'       => 'ol',
								'short_ping'  => true,
								'avatar_size' => 0,
								'walker'      => new Sashwell_Lite_Walker_Comment(),
								'reply_text'  => __( 'Reply', 'sashwell-lite' ),
							)
						);
						?>
				</ol>
				<?php
				the_comments_pagination(
					array(
						'prev_text' => __( 'Older comments', 'sashwell-lite' ),
						'next_text' => __( 'Newer comments', 'sashwell-lite' ),
					)
				);
				?>
			<?php endif; ?>
			<?php if ( ! comments_open() && $sashwell_lite_count ) : ?>
				<p class="cm-closed"><?php esc_html_e( 'Comments are closed.', 'sashwell-lite' ); ?></p>
			<?php endif; ?>
			<?php
			$sashwell_lite_commenter = wp_get_current_commenter();
			$sashwell_lite_req       = get_option( 'require_name_email' ) ? ' required' : '';
			$sashwell_lite_grid      = '<div class="form-grid form-grid--2">';
			comment_form(
				array(
					'class_container'      => 'comment-respond cform',
					'class_form'           => 'comment-form',
					'title_reply'          => __( 'Leave a comment', 'sashwell-lite' ),
					/* translators: %s: name of the person being replied to. */
					'title_reply_to'       => __( 'Reply to %s', 'sashwell-lite' ),
					'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
					'title_reply_after'    => '</h3>',
					'comment_notes_before' => $sashwell_lite_grid . '<p class="span-2 muted">' . esc_html__( 'Your email is never shown.', 'sashwell-lite' ) . '</p>',
					'logged_in_as'         => $sashwell_lite_grid . '<p class="span-2 muted">' . sprintf(
						/* translators: %s: user display name. */
						esc_html__( 'Commenting as %s.', 'sashwell-lite' ),
						esc_html( wp_get_current_user()->display_name )
					) . '</p>',
					'comment_field'        => '<div class="field span-2"><label for="comment">' . esc_html__( 'Comment', 'sashwell-lite' ) . '</label><textarea class="input" id="comment" name="comment" required minlength="2" maxlength="65525"></textarea></div>',
					'fields'               => array(
						'author'  => '<div class="field"><label for="author">' . esc_html__( 'Name', 'sashwell-lite' ) . '</label><input class="input" id="author" name="author" type="text" autocomplete="name" value="' . esc_attr( $sashwell_lite_commenter['comment_author'] ) . '" maxlength="245"' . $sashwell_lite_req . '></div>',
						'email'   => '<div class="field"><label for="email">' . esc_html__( 'Email', 'sashwell-lite' ) . '</label><input class="input" id="email" name="email" type="email" inputmode="email" autocomplete="email" value="' . esc_attr( $sashwell_lite_commenter['comment_author_email'] ) . '" maxlength="100"' . $sashwell_lite_req . '></div>',
						'url'     => '<div class="field span-2"><label for="url">' . esc_html__( 'Website', 'sashwell-lite' ) . ' <span class="muted">' . esc_html__( '(optional)', 'sashwell-lite' ) . '</span></label><input class="input" id="url" name="url" type="url" autocomplete="url" value="' . esc_attr( $sashwell_lite_commenter['comment_author_url'] ) . '" maxlength="200"></div>',
						'cookies' => '<p class="field span-2 comment-form-cookies-consent"><label><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . ( empty( $sashwell_lite_commenter['comment_author_email'] ) ? '' : ' checked' ) . '> ' . esc_html__( 'Save my name and email in this browser for the next time I comment.', 'sashwell-lite' ) . '</label></p>',
					),
					'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="btn btn--primary btn--lg">%4$s</button>',
					'submit_field'         => '<div class="span-2">%1$s %2$s</div></div>',
					'label_submit'         => __( 'Post comment', 'sashwell-lite' ),
				)
			);
			?>
		</div>
	</div>
</section>
