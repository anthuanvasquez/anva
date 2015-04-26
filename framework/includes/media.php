<?php

/**
 * Get Image Sizes
 *
 * By having this in a separate function, hopefully
 * it can be extended upon better. If any plugin or
 * other feature of the framework requires these
 * image sizes, they can grab 'em.
 */
function anva_get_image_sizes() {

	global $content_width;

	// Content Width
	// Default width of primary content area
	$content_width = apply_filters( 'anva_content_width', 940 );

	// Crop sizes
	$sizes = array(
		'blog_large' => array(
			'name' 		=> __( 'Blog Large', ANVA_DOMAIN ),
			'width' 	=> $content_width,
			'height' 	=> 9999,
			'crop' 		=> false
		),
		'blog_medium' => array(
			'name' 		=> __( 'Blog Medium', ANVA_DOMAIN ),
			'width' 	=> 320,
			'height'	=> 320,
			'crop' 		=> false
		),
		'blog_small' => array(
			'name' 		=> __( 'Blog Small', ANVA_DOMAIN ),
			'width' 	=> 195,
			'height' 	=> 195,
			'crop' 		=> false
		),
		'slider_big' => array(
			'name' 		=> __( 'Slider Big', ANVA_DOMAIN ),
			'width' 	=> 1600,
			'height' 	=> 500,
			'crop' 		=> true
		),
		'slider_large' => array(
			'name' 		=> __( 'Slider Large', ANVA_DOMAIN ),
			'width' 	=> $content_width,
			'height' 	=> 400,
			'crop' 		=> true
		),
		'slider_medium' => array(
			'name' 		=> __( 'Slider Medium', ANVA_DOMAIN ),
			'width' 	=> 564,
			'height' 	=> 400,
			'crop' 		=> true
		),
		'grid_2' => array(
			'name' 		=> __( '2 Column of Grid', ANVA_DOMAIN ),
			'width' 	=> 472,
			'height' 	=> 295,
			'crop' 		=> true
		),
		'grid_3' => array(
			'name' 		=> __( '3 Column of Grid', ANVA_DOMAIN ),
			'width' 	=> 320,
			'height' 	=> 200,
			'crop' 		=> true
		),
		'grid_4' => array(
			'name' 		=> __( '4 Column of Grid', ANVA_DOMAIN ),
			'width' 	=> 240,
			'height' 	=> 150,
			'crop' 		=> true
		),
	);

	return apply_filters( 'anva_image_sizes', $sizes );
}

/**
 * Register Image Sizes
 */
function anva_add_image_sizes() {

	// Get image sizes
	$sizes = anva_get_image_sizes();

	// Add image sizes
	foreach ( $sizes as $size => $atts ) {
		add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'] );
	}

}

/**
 * Show theme's image thumb sizes when inserting
 * an image in a post or page.
 *
 * This function gets added as a filter to WP's
 * image_size_names_choose
 *
 * @return array Framework's image sizes
 */
function anva_image_size_names_choose( $sizes ) {

	// Get image sizes for framework that were registered.
	$raw_sizes = anva_get_image_sizes();

	// Format sizes
	$image_sizes = array();
	
	foreach ( $raw_sizes as $id => $atts ) {
		$image_sizes[$id] = $atts['name'];
	}

	// Apply filter - Filter in filter... I know, I know.
	$image_sizes = apply_filters( 'anva_image_choose_sizes', $image_sizes );

	// Return merged with original WP sizes
	return array_merge( $sizes, $image_sizes );
}

/**
 * Get featured image url
 */
function anva_get_featured_image( $post_id, $thumbnail ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $post_thumbnail_id ) {
		$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail );
		return $post_thumbnail_img[0];
	}
}

/**
 * Get featured image in posts
 */
function anva_post_thumbnails( $thumb ) {
	
	global $post;

	$output = '';

	// Default
	$size = 'blog_large';
	$classes = 'large-thumbnail';

	if ( 0 == $thumb ) {
		$classes = 'medium-thumbnail';
		$size = 'blog_medium';

	} elseif ( 1 == $thumb ) {
		$classes = 'large-thumbnail';
		$size = 'blog_large';
	}

	if ( $thumb != 2 && has_post_thumbnail() ) {
		$output .= '<div class="entry-thumbnail ' . $classes . ' thumbnail">';
		if ( is_single() ) {
			$output .= '<a href="' . anva_get_featured_image( $post->ID, 'large' ) . '" title="' . get_the_title() . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';
		} else {
			$output .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';
		}
		$output .= '</div>';
	}

	return $output;

}

/**
 * Get featured image in post grid
 */
function anva_post_grid_thumbnails( $size ) {
	global $post;
	
	$output  = '';

	if ( has_post_thumbnail() ) {
		$output .= '<div class="entry-thumbnail large-thumbnail thumbnail">';
		$output .= '<a href="' . get_permalink( $post->ID ) . '" title="' . get_the_title( $post->ID ) . '">' .get_the_post_thumbnail( $post->ID, $size ) . '</a>';
		$output .= '</div>';
	}
	
	return $output;
}