<?php
/**
 * Comment walker: the comment layout.
 *
 * @package Sashwell_Lite
 */

defined( 'ABSPATH' ) || exit;

/**
 * Comments as .cm blocks with initials, a writer tag for the post author and nested replies.
 */
class Sashwell_Lite_Walker_Comment extends Walker_Comment {

	/**
	 * Start a list of replies.
	 *
	 * @param string $output Output, passed by reference.
	 * @param int    $depth  Depth.
	 * @param array  $args   Arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '<ol class="cms cms--r">';
	}

	/**
	 * End a list of replies.
	 *
	 * @param string $output Output, passed by reference.
	 * @param int    $depth  Depth.
	 * @param array  $args   Arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= '</ol>';
	}

	/**
	 * Output one comment (the closing </li> comes from end_el()).
	 *
	 * @param WP_Comment $comment Comment.
	 * @param int        $depth   Depth.
	 * @param array      $args    Arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$name     = get_comment_author( $comment );
		$is_crew  = $comment->user_id && (int) get_post_field( 'post_author', $comment->comment_post_ID ) === (int) $comment->user_id;
		$initials = '';
		foreach ( array_slice( preg_split( '/\s+/', trim( $name ) ), 0, 2 ) as $word ) {
			$initials .= function_exists( 'mb_substr' ) ? mb_substr( $word, 0, 1 ) : substr( $word, 0, 1 );
		}
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
			<div class="cm">
				<span class="<?php echo esc_attr( $is_crew ? 'cm-av cm-av--crew' : 'cm-av' ); ?>" aria-hidden="true"><?php echo esc_html( strtoupper( $initials ) ); ?></span>
				<div class="cm-b">
					<p class="cm-h">
						<b><?php echo esc_html( $name ); ?></b>
						<?php if ( $is_crew ) : ?>
							<span class="cm-tag"><?php esc_html_e( 'Writer', 'sashwell-lite' ); ?></span>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_comment_date( 'c', $comment ) ); ?>"><?php echo esc_html( get_comment_date( '', $comment ) ); ?></time>
					</p>
					<?php if ( '0' === $comment->comment_approved ) : ?>
						<p class="cm-wait"><em><?php esc_html_e( 'Your comment is waiting for approval.', 'sashwell-lite' ); ?></em></p>
					<?php endif; ?>
					<?php comment_text( $comment ); ?>
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '',
								'after'     => '',
							)
						),
						$comment
					);
					?>
				</div>
			</div>
		<?php
	}
}
