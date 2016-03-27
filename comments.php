<?php
/**
 * The template for displaying Comments.
 * 
 * @version 1.0.0
 */

if ( post_password_required() ) {
	return;
}

?>

<?php do_action( 'anva_comments_before' ); ?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf(
					_nx(
						'A response &ldquo;%2$s&rdquo;',
						'%1$s responses &ldquo;%2$s&rdquo;',
						get_comments_number(), 
						'comments title', 'anva'
					),
					number_format_i18n(
						get_comments_number() ),
						'<span>' . get_the_title() . '</span>'
					);
			?>
		</h2>

		<?php do_action( 'anva_comment_pagination' ); ?>

		<ol class="comment-list">
			<?php wp_list_comments( 'type=comment&callback=anva_comment_list' ); ?>
		</ol><!-- .comment-list (end) -->

		<?php do_action( 'anva_comment_pagination' ); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php anva_get_local( 'no_comment' ); ?></p>
	<?php endif; ?>

	<?php
		$required_text = sprintf( __( 'Fields marked with %s are required.', 'anva' ), '<span class="required">*</span>' );
		$aria_req = 'required';
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'button butotn-3d no-margin',
			'title_reply'       => __( 'Leave a Reply', 'anva' ),
			'title_reply_to'    => __( 'Leave a Reply to %s', 'anva' ),
			'cancel_reply_link' => __( 'Cancel Reply', 'anva' ),
			'label_submit'      => __( 'Post Comment', 'anva' ),

			'comment_field' =>  '
				<p class="comment-form-comment form-group">
				<label for="comment" class="hidden">' . _x( 'Comment', 'noun', 'anva' ) . '</label>
				<textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true">' . '</textarea>
				</p>',

			'must_log_in' => '<p class="must-log-in">' .
				sprintf(
					__( 'You must be %s to post a comment.', 'anva' ),
					sprintf(
						'<a href="%s">%s</a>',
						wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ),
						__( 'logged in', 'anva' )
					)
				) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
				sprintf(
					'%1$s <a href="%2$s">%3$s</a>. <a href="%4$s" title="%5$s">%6$s</a>',
					__( 'Logged in as', 'anva' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ),
					__( 'Log out of this account', 'anva' ),
					__( 'Log out?', 'anva' )
				) . '</p>',

			'comment_notes_before' => '<p class="comment-notes">' .
				__( 'Your email address will not be published.', 'anva' ) . ' ' . ( $req ? $required_text : '' ) .
				'</p>',

			'comment_notes_after' => '<p class="form-allowed-tags">' .
				sprintf(
					__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'anva' ),
					' <code>' . allowed_tags() . '</code>'
				) . '</p>',

			'fields' => apply_filters( 'comment_form_default_fields', array(

				'author' =>
					'<p class="comment-form-author form-group">' .
					'<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' />' .
					'<label for="author">' . __( 'Name', 'anva' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'</p>',

				'email' =>
					'<p class="comment-form-email form-group">
					<input id="email" name="email" type="text" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
					<label for="email">' . __( 'Email', 'anva' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'</p>',

				'url' =>
					'<p class="comment-form-url form-group">
					<input id="url" name="url" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" />
					<label for="url">' . __( 'Website', 'anva' ) . '</label>' .
					'</p>'
				)
			),
		);

		comment_form( $args );
	?>

</div><!-- #comments (end) -->

<?php do_action( 'anva_comments_after' ); ?>
