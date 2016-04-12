<?php

/**
 * Add metaboxes fields.
 *
 * @since  1.0.0
 * @return void
 */
function anva_add_meta_boxes_default() {

	// Builder Meta Box
	$content_builder_meta = anva_setup_content_builder_meta();
	new Anva_Content_Builder( $content_builder_meta['args']['id'], $content_builder_meta['args'], $content_builder_meta['options'] );
	
	// Page Meta Box
	$page_meta = anva_setup_page_meta();
	anva_add_meta_box( $page_meta['args']['id'], $page_meta['args'], $page_meta['options'] );

	// Post Meta Box
	$post_meta = anva_setup_post_meta();
	anva_add_meta_box( $post_meta['args']['id'], $post_meta['args'], $post_meta['options'] );

	// Gallery Meta Box
	if ( post_type_exists( 'galleries' ) ) {
		$gallery_meta = anva_setup_gallery_meta();
		anva_add_meta_box( $gallery_meta['args']['id'], $gallery_meta['args'], $gallery_meta['options'] );
		
		$gallery_attachments_meta = anva_setup_gallery_attachments_meta();
		$gallery_attachments_meta_box = new Anva_Gallery( $gallery_attachments_meta['args']['id'], $gallery_attachments_meta['args'] );
	}

	// Portfolio Meta Box
	if ( post_type_exists( 'portfolio' ) ) {
		$portfolio_meta = anva_setup_portfolio_meta();
		$portfolio_media_meta = anva_setup_portfolio_media_meta();
		anva_add_meta_box( $portfolio_meta['args']['id'], $portfolio_meta['args'], $portfolio_meta['options'] );
		anva_add_meta_box( $portfolio_media_meta['args']['id'], $portfolio_media_meta['args'], $portfolio_media_meta['options'] );
	}

	// Slider Meta Box
	if ( post_type_exists( 'slideshows' ) ) {
		$slider_meta = anva_setup_slider_meta();
		anva_add_meta_box( $slider_meta['args']['id'], $slider_meta['args'], $slider_meta['options'] );
	}
	

}

/**
 * Post meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_post_meta() {

	$options = array(
		'hide_title' => array(
			'name' 		=> __( 'Post Title', 'anva' ),
			'desc'		=> __( 'Show or hide post\'s titles.', 'anva' ),
			'id'		=> 'hide_title',
			'type' 		=> 'select',
			'std'		=> 'show',
			'options'	=> array(
				'show' 	=> __( 'Show post\'s title', 'anva' ),
				'hide'	=> __( 'Hide post\'s title', 'anva' )
			)
		),
		'sidebar_layout' => array(
			'name' => __( 'Sidebar Layout', 'anva' ),
			'desc' => __( 'Select a sidebar layout.', 'anva' ),
			'id'   => 'sidebar_layout',
			'type' => 'layout',
			'std'  => array(
				'layout' => '',
				'right'  => '',
				'left'   => ''
			),
		),
	);

	$setup = array(
		'args' => array(
			'id'       => 'anva_post_options',
			'title'    => __( 'Post Options', 'anva' ),
			'page'     => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => __( 'This is the default placeholder for post options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => $options
	);

	return apply_filters( 'anva_post_meta', $setup );
}

/**
 * Page meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_page_meta() {
	
	$columns = array();
	
	// Fill columns array
	$columns[''] = esc_html__( 'Default Grid Columns', 'anva' );
	foreach ( anva_get_grid_columns() as $key => $value ) {
		$columns[$key] = esc_html( $value['name'] );
	}

	$options = array(
		'hide_title' 	=> array(
			'name' 		=> __( 'Page Title', 'anva' ),
			'desc'		=> __( 'Show or hide page\'s titles.', 'anva' ),
			'id'		=> 'hide_title',
			'type' 		=> 'select',
			'std'		=> 'show',
			'options'	=> array(
				'show' 	=> __( 'Show page\'s title', 'anva' ),
				'hide'	=> __( 'Hide page\'s title', 'anva' )
			)
		),
		'page_desc' 	=> array(
			'name' 		=> __( 'Page Description', 'anva' ),
			'desc'		=> __( 'Enter the description for the page.', 'anva' ),
			'id'		=> 'page_desc',
			'type' 		=> 'textarea',
			'std'		=> '',
		),
		'sidebar_layout'=> array(
			'name' 		=> __( 'Sidebar Layout', 'anva' ),
			'desc'		=> __( 'Select a sidebar layout.', 'anva' ),
			'id'		=> 'sidebar_layout',
			'type' 		=> 'layout',
			'std'		=> array(
				'layout'=> '',
				'right' => '',
				'left' 	=> ''
			),
		),
		'grid_column' 	=> array(
			'name' 		=> __( 'Post Grid', 'anva' ),
			'desc'		=> __( 'Select a grid column for posts list.', 'anva' ),
			'id'		=> 'grid_column',
			'type' 		=> 'select',
			'std'		=> '',
			'options'	=> $columns
		),
	);

	$setup = array(
		'args' => array(
			'id' 			=> 'anva_page_options',
			'title' 		=> __( 'Page Options', 'anva' ),
			'page'			=> array( 'page' ),
			'context' 		=> 'normal',
			'priority'		=> 'high',
			'desc'			=> __( 'This is the default placeholder for page options.', 'anva' ),
			'prefix'		=> '_anva_',
		),
		'options' => $options
	);

	return apply_filters( 'anva_page_meta', $setup );
}

/**
 * Slider meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_slider_meta() {

	$slider = anva_get_option( 'slider_id' );
	$sliders = anva_get_sliders( $slider );
	$slider_fields = array();

	if ( isset( $sliders['fields'] ) ) {
		$slider_fields = $sliders['fields'];
	}
	
	$setup = array(
		'args' => array(
			'id' 			=> 'anva_slider_options',
			'title' 		=> __( 'Slider Options', 'anva' ),
			'page'			=> array( 'slideshows' ),
			'context' 		=> 'normal',
			'priority'		=> 'high',
		),
		'options' => $slider_fields
	);
	
	return apply_filters( 'anva_slider_meta', $setup );
}

/**
 * Gallery meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_gallery_meta() {
	
	$galleries = array();
	$galleries[''] = esc_html__( 'Default Gallery Columns', 'anva' );
	
	foreach ( anva_gallery_templates() as $key => $value ) {
		$galleries[ $key ] = esc_html( $value['name'] );
	}

	$options = array(
		'hide_title' 		=> array(
			'name'    		=> __( 'Gallery Title', 'anva' ),
			'desc'    		=> __( 'Show or hide gallery\'s titles.', 'anva' ),
			'id'      		=> 'hide_title',
			'type'    		=> 'select',
			'std'     		=> 'show',
			'options' 		=> array(
				'show' 		=> __( 'Show gallery\'s title', 'anva' ),
				'hide'		=> __( 'Hide gallery\'s title', 'anva' )
			)
		),
		'gallery_highlight' => array(
			'id'   			=> 'gallery_highlight',
			'name' 			=> __( 'Highlight Image', 'anva' ),
			'desc' 			=> __( 'Enter the number of image than want to highlight.', 'anva' ),
			'type' 			=> 'number',
			'std'  			=> ''
		),
		'gallery_template' 	=> array(
			'id'      		=> 'gallery_template',
			'name'    		=> __( 'Gallery Template', 'anva' ),
			'desc'    		=> __( 'Select gallery template for this gallery.', 'anva' ),
			'type'    		=> 'select',
			'std'     		=> '',
			'options' 		=> $galleries
		),
	);

	$setup = array(
		'args' => array(
			'id' 		=> 'anva_gallery_options',
			'title' 	=> __( 'Gallery Options', 'anva' ),
			'page'		=> array( 'galleries' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
			'desc'		=> __( 'This is the default placeholder for gallery options.', 'anva' ),
			'prefix'	=> '_anva_',
		),
		'options' => $options
	);

	return apply_filters( 'anva_gallery_meta', $setup );
}

/**
 * Portfolio meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_portfolio_meta() {

	$options = array(
		'hide_title' => array(
			'id'		=> 'hide_title',
			'name' 		=> __( 'Portfolio Title', 'anva' ),
			'desc'		=> __( 'Show or hide portfolio\'s item titles.', 'anva' ),
			'type' 		=> 'select',
			'std'		=> 'show',
			'options'	=> array(
				'show' 	=> __( 'Show portfolio\'s item title', 'anva' ),
				'hide'	=> __( 'Hide portfolio\'s item title', 'anva' )
			),
		),
		'author' => array(
			'id'		=> 'author',
			'name' 		=> __( 'Author', 'anva' ),
			'desc'		=> __( 'Enter the porfolio item author.', 'anva' ),
			'type' 		=> 'text',
			'std'		=> ''
		),
		'client' => array(
			'id'		=> 'client',
			'name' 		=> __( 'Client', 'anva' ),
			'desc'		=> __( 'Enter the porfolio client.', 'anva' ),
			'type' 		=> 'text',
			'std'		=> ''
		),
		'client_url' => array(
			'id'		=> 'client_url',
			'name' 		=> __( 'Client URL', 'anva' ),
			'desc'		=> __( 'Enter the client URL.', 'anva' ),
			'type' 		=> 'text',
			'std'		=> 'http://'
		),
		'date' => array(
			'id'		=> 'date',
			'name' 		=> __( 'Date', 'anva' ),
			'desc'		=> __( 'Select the date on which the project was completed.', 'anva' ),
			'type' 		=> 'date',
			'std'		=> ''
		),
	);

	$setup = array(
		'args' => array(
			'id'       => 'anva_portfolio_options',
			'title'    => __( 'Portfolio Options', 'anva' ),
			'page'     => array( 'portfolio' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => __( 'This is the default placeholder for portfolio options.', 'anva' ),
			'prefix'   => '_anva_',
		),
		'options' => $options
	);

	return apply_filters( 'anva_portfolio_meta', $setup );
}

/**
 * Portfolio media meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_portfolio_media_meta() {

	$options = array(
		'audio_image' 		=> array(
			'id'   			=> 'audio_image',
			'name' 			=> __( 'Audio Featured Image', 'anva' ),
			'desc' 			=> __( 'Add a poster image to your audio player (optional).', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'audio_mp3' 		=> array(
			'id'   			=> 'audio_mp3',
			'name' 			=> __( 'Audio MP3', 'anva' ),
			'desc' 			=> __( 'Insert an .mp3 file, if desired.', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'audio_ogg' 		=> array(
			'id'   			=> 'audio_ogg',
			'name' 			=> __( 'Audio OGG', 'anva' ),
			'desc' 			=> __( 'Insert an .ogg file, if desired.', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'video_image' 		=> array(
			'id'   			=> 'video_image',
			'name' 			=> __( 'Video Featured Image', 'anva' ),
			'desc' 			=> __( 'Add a poster image for your video player (optional).', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'video_m4v' 		=> array(
			'id'   			=> 'video_m4v',
			'name' 			=> __( 'Video M4V', 'anva' ),
			'desc' 			=> __( 'Insert an .m4v file, if desired..', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'video_ogv' 		=> array(
			'id'   			=> 'video_ogv',
			'name' 			=> __( 'Video OGV', 'anva' ),
			'desc' 			=> __( 'Insert an .ogv file, if desired.', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'video_mp4' 		=> array(
			'id'   			=> 'video_mp4',
			'name' 			=> __( 'Video MP4', 'anva' ),
			'desc' 			=> __( 'Insert an .mp4 file, if desired.', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
		'video_embed' 		=> array(
			'id'   			=> 'video_embed',
			'name' 			=> __( 'Video Embed', 'anva' ),
			'desc' 			=> __( 'Embed iframe code from YouTube, Vimeo or other trusted source. HTML tags are limited to iframe, div, img, a, em, strong and br. Note: This field overrides the previous fields.', 'anva' ),
			'type' 			=> 'upload',
			'std'  			=> ''
		),
	);

	$setup = array(
		'args' => array(
			'id'       => 'anva_portfolio_media',
			'title'    => __( 'Portfolio Media', 'anva' ),
			'page'     => array( 'portfolio' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => 'Portfolio Media',
			'prefix'   => '_anva_',
		),
		'options' => $options
	);

	return apply_filters( 'anva_portfolio_media_meta', $setup );
}

/**
 * Gallery attachements meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_gallery_attachments_meta() {

	$setup = array(
		'args' => array(
			'id' 		=> '_anva_gallery_attachments',
			'title' 	=> __( 'Gallery', 'anva' ),
			'page'		=> array( 'galleries', 'portfolio' ), // Use gallery in portfolio?
			'context' 	=> 'normal',
			'priority'	=> 'default'
		)
	);

	return apply_filters( 'anva_gallery_attachments_meta', $setup );
}

/**
 * Page builder meta setup.
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_content_builder_meta() {
	
	$setup = array(
		'args' => array(
			'id' 		=> '_anva_builder_options',
			'title' 	=> __( 'Content Builder', 'anva' ),
			'page'		=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
		),
		'options'		=> anva_get_elements() // Get content builder elements
	);
	
	return apply_filters( 'anva_page_buider_meta', $setup );
}