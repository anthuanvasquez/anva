<?php

// SHOW THE FEATURED IMAGE
function tm_posts_columns_content($column_name, $post_ID) {
	if ( $column_name == 'featured_image' ) {
		$post_featured_image = tm_get_featured_image( $post_ID, array(90, 90) );
		if ( $post_featured_image ) {
			echo '<img src="' . $post_featured_image . '" />';
		}
	}
}