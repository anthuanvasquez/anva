<?php

/**
 * Add customs image sizes.
 * @since 1.4.2
 */
function tm_add_image_size() {
	add_image_size( 'blog_large', 620, 300, true );
	add_image_size( 'blog_medium', 300, 300, true );
	add_image_size( 'blog_small', 150, 150, true );
	add_image_size( 'grid_2', 472, 295, true );
	add_image_size( 'grid_3', 320, 200, true);
	add_image_size( 'grid_4', 240, 150, true );
	add_image_size( 'slideshow', 980, 450, true );
}

function tm_get_featured_image( $post_id, $thumbnail ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $post_thumbnail_id ) {
		$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail );
		return $post_thumbnail_img[0];
	}
}