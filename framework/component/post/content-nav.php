<div class="post-navigation-wrapp">
	<?php
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );


	if ( ! $next && ! $previous ) {
		return;
	}

	$class = '';

	// Align to right
	if ( ! $previous ) {
		$class = ' fright';
	}

	?>
	<div class="post-navigation clearfix">
		<?php
			if ( $previous ) {
				$previous_title = $previous->post_title;
				previous_post_link( '<div class="post-previous col_half nobottommargin">%link</div>', '&lArr; ' . $previous_title );
			}

			if ( $next ) {
				$next_title = $next->post_title;
				next_post_link( '<div class="post-next col_half col_last nobottommargin tright' . esc_attr( $class ) . '">%link</div>', $next_title . ' &rArr;' );
			}
		?>
	</div><!-- .post-navigation (end) -->
	<div class="line"></div>

</div><!-- .post-navigation-wrap -->
