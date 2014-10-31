<?php

function tm_get_featured_image( $post_id, $thumbnail ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $post_thumbnail_id ) {
		$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail );
		return $post_thumbnail_img[0];
	}
}