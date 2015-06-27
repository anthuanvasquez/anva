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
	$content_width = apply_filters( 'anva_content_width', 1110 );

	// Crop sizes
	$sizes = array(
		'blog_full' => array(
			'name' 		=> __( 'Blog Full Width', ANVA_DOMAIN ),
			'width' 	=> 2000,
			'height' 	=> 1333,
			'crop' 		=> true,
			'position'=> array( 'center', 'top' )
		),
		'blog_lg' => array(
			'name' 		=> __( 'Blog Large', ANVA_DOMAIN ),
			'width' 	=> 860,
			'height' 	=> 400,
			'crop' 		=> true,
			'position'=> array( 'center', 'top' )
		),
		'blog_md' => array(
			'name' 		=> __( 'Blog Medium', ANVA_DOMAIN ),
			'width' 	=> 400,
			'height'	=> 300,
			'crop' 		=> true,
			'position'=> array( 'center', 'top' )
		),
		'blog_sm' => array(
			'name' 		=> __( 'Blog Small', ANVA_DOMAIN ),
			'width' 	=> 195,
			'height' 	=> 195,
			'crop' 		=> false
		),
		'slider_full' => array(
			'name' 		=> __( 'Slider Full Width', ANVA_DOMAIN ),
			'width' 	=> 1600,
			'height' 	=> 500,
			'crop' 		=> true,
			'position'=> array( 'center', 'top' )
		),
		'slider_lg' => array(
			'name' 		=> __( 'Slider Large', ANVA_DOMAIN ),
			'width' 	=> 1140,
			'height' 	=> 500,
			'crop' 		=> true,
			'position'=> array( 'center', 'top' )
		),
		'slider_md' => array(
			'name' 		=> __( 'Slider Medium', ANVA_DOMAIN ),
			'width' 	=> 564,
			'height' 	=> 400,
			'crop' 		=> true,
			'position'=> array( 'center', 'top' )
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
			'crop' 		=> true,

		),
		'gallery_2' => array(
			'name' 		=> __( 'Gallery Grid 2 Columns', ANVA_DOMAIN ),
			'width' 	=> 480,
			'height' 	=> 480,
			'crop' 		=> true
		),
		'gallery_3' => array(
			'name' 		=> __( 'Gallery Grid 3 Columns', ANVA_DOMAIN ),
			'width' 	=> 440,
			'height' 	=> 440,
			'crop' 		=> true
		),
		'gallery_masonry' => array(
			'name' 		=> __( 'Gallery Masonry', ANVA_DOMAIN ),
			'width' 	=> 480,
			'height' 	=> 9999,
			'crop' 		=> false
		),
	);

	return apply_filters( 'anva_image_sizes', $sizes );
}

/**
 * Register Image Sizes
 */
function anva_add_image_sizes() {
	
	// Compared wp version
	global $wp_version;

	// Get image sizes
	$sizes = anva_get_image_sizes();

	// Add image sizes
	foreach ( $sizes as $size => $atts ) {
		if ( version_compare( $wp_version, '3.9', '>=' ) && isset( $atts['position'] ) ) {
			add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'], $atts['position'] );
		} else {
			add_image_size( $size, $atts['width'], $atts['height'], $atts['crop'] );
		}
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
function anva_get_post_thumbnail( $thumb ) {
	global $post;

	// Default
	$html = '';
	$size = 'blog_lg';

	if ( 0 == $thumb ) {
		$size = 'blog_md';
	} elseif ( 1 == $thumb ) {
		$size = 'blog_lg';
	}

	if ( $thumb != 2 && has_post_thumbnail() ) {
		$html .= '<div class="entry-image">';
		if ( is_single() ) {
			$html .= '<a data-lightbox="image" href="' . anva_get_featured_image( $post->ID, 'large' ) . '" title="' . get_the_title() . '">' . get_the_post_thumbnail( $post->ID, $size, array( 'title' => get_the_title() ) ) . '</a>';
		} else {
			$html .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail( $post->ID, $size, array( 'title' => get_the_title() ) ) . '</a>';
		}
		$html .= '</div>';
	}

	echo $html;

}

/**
 * Get featured image in post grid
 */
function anva_get_post_grid_thumbnails( $size ) {
	global $post;
	
	$output  = '';

	if ( has_post_thumbnail() ) {
		$output .= '<div class="entry-image">';
		$output .= '<a href="'. get_permalink( $post->ID ) .'" title="'. get_the_title( $post->ID ) .'">'. get_the_post_thumbnail( $post->ID, $size ) .'</a>';
		$output .= '</div>';
	}
	
	return $output;
}