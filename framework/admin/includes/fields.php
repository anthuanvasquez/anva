<?php

/*-----------------------------------------------------------------------------------*/
/* Meta Fields Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Add page and post meta boxes
 *
 * @since  1.0.0
 */
function anva_add_meta_boxes_default() {

	// Page Meta Box
	$page_meta = anva_setup_page_meta();
	$page_meta_box = new Anva_Meta_Box( $page_meta['args']['id'], $page_meta['args'], $page_meta['options'] );

	// Post Meta Box
	$post_meta = anva_setup_post_meta();
	$post_meta_box = new Anva_Meta_Box( $post_meta['args']['id'], $post_meta['args'], $post_meta['options'] );

	// Page Builder Meta Box
	$page_builder_meta = anva_setup_page_builder_meta();
	$page_builder_meta_box = new Anva_Builder_Meta_Box( $page_builder_meta['args']['id'], $page_builder_meta['args'], $page_builder_meta['options'] );

	// Gallery Meta Box
	if ( post_type_exists( 'galleries' ) ) {
		$gallery_meta = anva_setup_gallery_meta();
		$gallery_meta_box = new Anva_Meta_Box( $gallery_meta['args']['id'], $gallery_meta['args'], $gallery_meta['options'] );
	
		$gallery_attachments_meta = anva_setup_gallery_attachments_meta();
		$gallery_attachments_meta_box = new Anva_Gallery_Meta_Box( $gallery_attachments_meta['args']['id'], $gallery_attachments_meta['args'] );
	}

	// Portfolio Meta Box
	if ( post_type_exists( 'portfolio' ) ) {
		$portfolio_meta = anva_setup_portfolio_meta();
		$portfolio_meta_box = new Anva_Meta_Box( $portfolio_meta['args']['id'], $portfolio_meta['args'], $portfolio_meta['options'] );
	
		$portfolio_media_meta = anva_setup_portfolio_media_meta();
		$portfolio_media_meta_box = new Anva_Media_Meta_Box( $portfolio_media_meta['args']['id'], $portfolio_media_meta['args'] );
	}

	// Slider Meta Box
	if ( post_type_exists( 'slideshows' ) ) {
		$slider_meta = anva_setup_slider_meta();
		$slider_meta_box = new Anva_Meta_Box( $slider_meta['args']['id'], $slider_meta['args'], $slider_meta['options'] );
	}
}

/**
 * Post meta setup
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_post_meta() {

	$layouts_default = array(
		'layout' => '',
		'right' => '',
		'left' => ''
	);

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_post_options',
			'title' 		=> __( 'Post Options', 'anva' ),
			'page'			=> array( 'post' ),
			'context' 	=> 'side',
			'priority'	=> 'default',
			'desc'			=> __( 'This is the default placeholder for post options.', 'anva' )
		),
		'options' => array(
			'layout' => array(
				'id' 			=> 'layout',
				'name'		=> __( 'Layout', 'anva' ),
				'type' 		=> 'heading'
			),
			'hide_title' => array(
				'id'			=> 'hide_title',
				'name' 		=> __( 'Page Title', 'anva' ),
				'desc'		=> __( 'Show or hide page\'s titles.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> 'show',
				'options'	=> array(
					'show' 	=> __( 'Show page\'s title', 'anva' ),
					'hide'	=> __( 'Hide page\'s title', 'anva' )
				)
			),
			'sidebar_layout' => array(
				'id'			=> 'sidebar_layout',
				'name' 		=> __( 'Sidebar Layout', 'anva' ),
				'desc'		=> __( 'Select a sidebar layout.', 'anva' ),
				'type' 		=> 'layout',
				'std'			=> $layouts_default,
			),
		)
	);

	return apply_filters( 'anva_post_meta', $setup );
}

/**
 * Page meta setup
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_page_meta() {
	
	$columns = array();
	$layouts_default = array(
		'layout' => '',
		'right' => '',
		'left' => ''
	);

	// Fill columns array
	$columns[''] = esc_html__( 'Default Grid Columns', 'anva' );
	foreach ( anva_get_grid_columns() as $key => $value ) {
		$columns[$key] = esc_html( $value['name'] );
	}

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_page_options',
			'title' 		=> __( 'Page Options', 'anva' ),
			'page'			=> array( 'page' ),
			'context' 	=> 'side',
			'priority'	=> 'default',
			'desc'			=> __( 'This is the default placeholder for post options.', 'anva' )
		),
		'options' => array(
			'layout' => array(
				'id' 			=> 'layout',
				'name'		=> __( 'Layout', 'anva' ),
				'type' 		=> 'heading'
			),
			'hide_title' => array(
				'id'			=> 'hide_title',
				'name' 		=> __( 'Page Title', 'anva' ),
				'desc'		=> __( 'Show or hide page\'s titles.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> 'show',
				'options'	=> array(
					'show' 	=> __( 'Show page\'s title', 'anva' ),
					'hide'	=> __( 'Hide page\'s title', 'anva' )
				)
			),
			'sidebar_layout' => array(
				'id'			=> 'sidebar_layout',
				'name' 		=> __( 'Sidebar Layout', 'anva' ),
				'desc'		=> __( 'Select a sidebar layout.', 'anva' ),
				'type' 		=> 'layout',
				'std'			=> $layouts_default,
			),
			'grid_column' => array(
				'id'			=> 'grid_column',
				'name' 		=> __( 'Post Grid', 'anva' ),
				'desc'		=> __( 'Select a grid column for posts list.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> $columns
			),
		)
	);

	return apply_filters( 'anva_page_meta', $setup );
}

/**
 * Portfolio meta setup
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_portfolio_meta() {

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_portfolio_options',
			'title' 		=> __( 'Portfolio Options', 'anva' ),
			'page'			=> array( 'portfolio' ),
			'context' 	=> 'side',
			'priority'	=> 'default',
			'desc'			=> __( 'This is the default placeholder for portfolio options.', 'anva' )
		),
		'options' => array(
			'layout' => array(
				'id' 			=> 'layout',
				'name'		=> __( 'Layout', 'anva' ),
				'type' 		=> 'heading'
			),
			'hide_title' => array(
				'id'			=> 'hide_title',
				'name' 		=> __( 'Page Title', 'anva' ),
				'desc'		=> __( 'Show or hide page\'s titles.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> 'show',
				'options'	=> array(
					'show' 	=> __( 'Show page\'s title', 'anva' ),
					'hide'	=> __( 'Hide page\'s title', 'anva' )
				),
			),
			'author' => array(
				'id'			=> 'author',
				'name' 		=> __( 'Author', 'anva' ),
				'desc'		=> __( 'Enter the porfolio author.', 'anva' ),
				'type' 		=> 'text',
				'std'			=> ''
			),
			'client' => array(
				'id'			=> 'client',
				'name' 		=> __( 'Client', 'anva' ),
				'desc'		=> __( 'Select the date on which the project was completed.', 'anva' ),
				'type' 		=> 'text',
				'std'			=> ''
			),
			'client_url' => array(
				'id'			=> 'client_url',
				'name' 		=> __( 'Client URL', 'anva' ),
				'desc'		=> __( 'Select the date on which the project was completed.', 'anva' ),
				'type' 		=> 'text',
				'std'			=> 'http://'
			),
			'date' => array(
				'id'			=> 'date',
				'name' 		=> __( 'Date', 'anva' ),
				'desc'		=> __( 'Select the date Enter the porfolio client.', 'anva' ),
				'type' 		=> 'date',
				'std'			=> ''
			),
		)
	);

	return apply_filters( 'anva_portfolio_meta', $setup );
}

function anva_setup_portfolio_media_meta() {

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_portfolio_media_options',
			'title' 		=> __( 'Portfolio Media Options', 'anva' ),
			'page'			=> array( 'portfolio' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
			'desc'			=> ''
		),
	);

	return apply_filters( 'anva_portfolio_media_meta', $setup );
}

/**
 * Gallery meta setup
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_gallery_meta() {
	
	$galleries = array();

	$galleries[''] = esc_html__( 'Default Gallery Columns', 'anva' );
	foreach ( anva_gallery_templates() as $key => $value ) {
		$galleries[$key] = esc_html( $value['name'] );
	}

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_gallery_options',
			'title' 		=> __( 'Gallery Options', 'anva' ),
			'page'			=> array( 'galleries' ),
			'context' 	=> 'side',
			'priority'	=> 'default',
			'desc'			=> __( 'This is the default placeholder for gallery options.', 'anva' )
		),
		'options' => array(
			'layout' => array(
				'id' 			=> 'layout',
				'name'		=> __( 'Layout', 'anva' ),
				'type' 		=> 'heading'
			),
			'gallery_highlight' => array(
				'id'			=> 'gallery_highlight',
				'name' 		=> __( 'Highlight Image', 'anva' ),
				'desc'		=> __( 'Enter the number of image than want to highlight.', 'anva' ),
				'type' 		=> 'number',
				'std'			=> ''
			),
			'gallery_template' => array(
				'id'			=> 'gallery_template',
				'name' 		=> __( 'Gallery Template', 'anva' ),
				'desc'		=> __( 'Select gallery template for this gallery.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> $galleries
			),
		)
	);

	return apply_filters( 'anva_gallery_meta', $setup );
}

/**
 * Gallery attachements meta setup
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_gallery_attachments_meta() {

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_gallery_attachments',
			'title' 		=> __( 'Gallery Attachments', 'anva' ),
			'page'			=> array( 'galleries', 'portfolio' ), // Use gallery in portfolio?
			'context' 	=> 'normal',
			'priority'	=> 'high'
		)
	);

	return apply_filters( 'anva_gallery_attachments_meta', $setup );
}

/**
 * Slider meta setup
 *
 * @since  1.0.0
 * @return array $setup
 */
function anva_setup_slider_meta() {
	
	$setup = array(
		'args' => array(
			'id' 				=> 'anva_slider_options',
			'title' 		=> __( 'Anva Slider Options', 'anva' ),
			'page'			=> array( 'slideshows' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
		),
		'options'			=> array(
			'main' => array(
				'id' 			=> 'main',
				'name'		=> __( 'Main', 'anva' ),
				'type' 		=> 'heading'
			),
			'type' => array(
				'id'			=> 'type',
				'name' 		=> __( 'Slide Type', 'anva' ),
				'desc'		=> __( 'Select content type.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> array(
					'image' => __( 'Image Slide', 'anva' ),
					'video' => __( 'Video Slide', 'anva' )
				)
			),
			'link' => array(
				'id'			=> 'link',
				'name' 		=> __( 'Image Link', 'anva' ),
				'desc'		=> __( 'Where should the link open?.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> 'same',
				'options'	=> array(
					'same' 	=> __( 'Same Windows', 'anva' ),
					'new' 	=> __( 'New Windows', 'anva' ),
					'image' => __( 'Lightbox Image', 'anva' ),
					'video' => __( 'Lightbox Video', 'anva' )
				)
			),
			'url' => array(
				'id'			=> 'url',
				'name' 		=> __( 'URL', 'anva' ),
				'desc'		=> __( 'Where should the link go?.', 'anva' ),
				'type' 		=> 'text',
				'std'			=> ''
			),
			'description' => array(
				'id'			=> 'description',
				'name' 		=> __( 'Description', 'anva' ),
				'desc'		=> __( 'What should the description say?.', 'anva' ),
				'type' 		=> 'textarea',
				'std'			=> ''
			),
			'content' => array(
				'id'			=> 'content',
				'name' 		=> __( 'Content', 'anva' ),
				'desc'		=> __( 'Select a option to show the content.', 'anva' ),
				'type' 		=> 'select',
				'std'			=> 'hide',
				'options'	=> array(
					'title' => anva_get_local( 'slide_title'),
					'desc' 	=> anva_get_local( 'slide_desc' ),
					'both' 	=> anva_get_local( 'slide_show' ),
					'hide' 	=> anva_get_local( 'slide_hide' )
				)
			),
		)
	);
	
	return apply_filters( 'anva_slider_meta', $setup );
}

/**
 * Page Builder meta setup
 *
 * @since 1.0.0
 * @return array $setup
 */
function anva_setup_page_builder_meta() {
	
	$setup = array(
		'args' => array(
			'id' 				=> 'anva_builder_options',
			'title' 		=> __( 'Anva Page Builder', 'anva' ),
			'page'			=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'high',
		),
		'options'			=> anva_get_elements()
	);
	
	return apply_filters( 'anva_page_buider_meta', $setup );
}