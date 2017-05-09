<div class="author-wrap">
	<?php
	$post_id = get_the_ID();
	$id      = get_post_field( 'post_author', $post_id );
	$avatar  = get_avatar( $id, '96' );
	$url     = get_author_posts_url( $id );
	$name    = get_the_author_meta( 'display_name', $id );
	$desc    = get_the_author_meta( 'description', $id );
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php printf( '%1$s <span><a href="%2$s">%3$s</a></span>', __( 'Posted by', 'anva' ), esc_url( $url ), esc_html( $name ) ); ?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="author-image">
				<?php echo $avatar ; ?>
			</div>
			<div class="author-description">
				<?php echo wpautop( esc_html( $desc ) ); ?>
			</div>
		</div>
	</div><!-- .panel (end) -->
</div><!-- .author-wrap (end) -->

<div class="line"></div>
