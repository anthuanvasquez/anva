<?php
/**
 * The template for displaying Comments
 */

if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'Una respuesta en &ldquo;%2$s&rdquo;', '%1$s respuestas en &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', ANVA_DOMAIN ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<?php anva_comment_pagination(); ?>

		<ol class="comment-list">
			<?php
		wp_list_comments( 'type=comment&callback=anva_comment_list' );
			?>
		</ol><!-- .comment-list (end) -->

		<?php anva_comment_pagination(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php anva_get_local( 'no_comment' ); ?></p>
	<?php endif; ?>

	<?php
		$required_text = __( 'Los campos marcados con <span class="required">*</span> son requeridos.', ANVA_DOMAIN );
		$aria_req = 'required';
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'class_submit'      => 'btn btn-default',
			'title_reply'       => __( 'Leave a Reply' ),
			'title_reply_to'    => __( 'Leave a Reply to %s' ),
			'cancel_reply_link' => __( 'Cancel Reply' ),
			'label_submit'      => __( 'Post Comment' ),

			'comment_field' =>  '
				<p class="comment-form-comment form-group">
				<label for="comment" class="hidden">' . _x( 'Comment', 'noun' ) . '</label>
				<textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true">' . '</textarea>
				</p>',

			'must_log_in' => '<p class="must-log-in">' .
				sprintf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
					wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
				sprintf(
				__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				) . '</p>',

			'comment_notes_before' => '<p class="comment-notes">' .
				__( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
				'</p>',

			'comment_notes_after' => '<p class="form-allowed-tags">' .
				sprintf(
					__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
					' <code>' . allowed_tags() . '</code>'
				) . '</p>',

			'fields' => apply_filters( 'comment_form_default_fields', array(

				'author' =>
					'<p class="comment-form-author form-group">' .
					'<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30"' . $aria_req . ' />' .
					'<label for="author">' . __( 'Name', 'domainreference' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'</p>',

				'email' =>
					'<p class="comment-form-email form-group">
					<input id="email" name="email" type="text" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
					<label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
					'</p>',

				'url' =>
					'<p class="comment-form-url form-group">
					<input id="url" name="url" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" size="30" />
					<label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
					'</p>'
				)
			),
		);

		comment_form($args);
	?>

</div><!-- #comments (end) -->