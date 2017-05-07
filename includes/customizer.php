<?php

/**
 * Setup theme options for customizer.
 *
 * @since  1.0.0.
 * @return void
 */
function theme_customizer_options() {

	// Setup background options
	$background_options = array(
		'background_color' 				=> array(
			'label' 					=> __( 'Background Color', 'anva' ),
			'id' 						=> 'background_color',
			'type' 						=> 'color',
			'transport'					=> 'postMessage',
			'priority'					=> 1
		),
		'background_image' 				=> array(
			'label' 					=> __( 'Background Image', 'anva' ),
			'id' 						=> 'background_image',
			'type' 						=> 'image',
			'transport'					=> 'postMessage',
			'priority'					=> 2
		),
		'background_pattern' 			=> array(
			'label' 					=> __( 'Background Patterns', 'anva' ),
			'description' 				=> __( 'Select the background patterns.', 'anva' ),
			'id' 						=> 'background_pattern',
			'type' 						=> 'select',
			'choices' 					=> array(
				'' 						=> __( 'None', 'anva' ),
				'binding_light' 		=> 'Binding Light',
				'dimension_@2X' 		=> 'Dimension',
				'hoffman_@2X' 			=> 'Hoffman',
				'knitting250px' 		=> 'Knitting',
				'noisy_grid' 			=> 'Noisy Grid',
				'pixel_weave_@2X' 		=> 'Pixel Weave',
				'struckaxiom' 			=> 'Struckaxiom',
				'subtle_stripes' 		=> 'Subtle Stripes',
				'white_brick_wall_@2X' 	=> 'White Brick Wall',
				'gplaypattern'			=> 'G Play Pattern',
				'blackmamba'			=> 'Black Mamba',
				'carbon_fibre' 			=> 'Carbon Fibre',
				'congruent_outline' 	=> 'Congruent Outline',
				'moulin' 				=> 'Moulin',
				'wild_oliva' 			=> 'Wild Oliva',
			),
			'transport'				    => 'postMessage',
			'priority'				    => 3
		),
	);
	anva_add_customizer_section( 'background', __( 'Background', 'anva' ), $background_options, 1 );

	// Setup logo options
	$header_options = array(
		'custom_logo' => array(
			'label' 					=> __( 'Logo', 'anva' ),
			'id' 						=> 'custom_logo',
			'type' 						=> 'logo',
			'transport'					=> 'postMessage',
			'priority'					=> 1
		),
		'social_media_style' 			=> array(
			'label' 					=> __( 'Socia Media Buttons Style', 'anva' ),
			'id'						=> 'social_media_style',
			'type' 						=> 'select',
			'choices'					=> array(
				'light' 				=> __( 'Light', 'anva' ),
				'colored' 				=> __( 'Colored', 'anva' ),
				'dark' 					=> __( 'Dark', 'anva' )
			),
			'transport'					=> 'postMessage',
			'priority'					=> 21
		)
	);
	anva_add_customizer_section( 'header', __( 'Header', 'anva' ), $header_options, 2 );

	$main_styles_options = array(
		'layout_style' 						 => array(
			'label' 						 => __( 'Layout Style', 'anva' ),
			'id'							 => 'layout_style',
			'type' 							 => 'select',
			'choices'						 => array(
				'boxed' 					 => __( 'Boxed', 'anva' ),
				'stretched' 				 => __( 'Stretched', 'anva' )
			),
			'transport'						 => 'postMessage',
			'priority'						 => 1
		),
		'base_color' 						 => array(
			'label' 						 => __( 'Base Color Scheme', 'anva' ),
			'id'							 => 'base_color',
			'type' 							 => 'select',
			'choices'						 => array(
				'black' 					 => __( 'Black', 'anva' ),
				'blue' 						 => __( 'Blue', 'anva' ),
				'brown' 					 => __( 'Brown', 'anva' ),
				'green' 					 => __( 'Green', 'anva' ),
				'navy' 						 => __( 'Navy', 'anva' ),
				'orange' 					 => __( 'Orange', 'anva' ),
				'pink' 						 => __( 'Pink', 'anva' ),
				'purple' 					 => __( 'Purple', 'anva' ),
				'red' 						 => __( 'Red', 'anva' ),
				'slate' 					 => __( 'Slate Grey', 'anva' ),
				'teal' 						 => __( 'Teal', 'anva' )
			),
			'transport'						 => 'postMessage',
			'priority'						 => 2
		),
		'footer_color' 						 => array(
			'label' 						 => __( 'Footer Color Scheme', 'anva' ),
			'id'							 => 'footer_color',
			'type' 							 => 'select',
			'choices'						 => array(
				'light' 					 => __( 'Light', 'anva' ),
				'dark' 						 => __( 'Dark', 'anva' )
			),
			'transport'						 => 'postMessage',
			'priority'						 => 3
		),
	);
	anva_add_customizer_section( 'main_styles', __( 'Main Styles', 'anva' ), $main_styles_options, 101 );

	//  Font options
	$font_options = array(
		'body_font' 						 => array(
			'label' 						 => __( 'Body Font', 'anva' ),
			'id' 							 => 'body_font',
			'atts'							 => array( 'size', 'weight', 'style', 'face' ),
			'type' 							 => 'typography',
			'transport'						 => 'postMessage'
		),
		'heading_font' 						 => array(
			'label' 						 => __( 'Headings Font', 'anva' ),
			'id' 							 => 'heading_font',
			'atts'							 => array('style', 'weight', 'face'),
			'type' 							 => 'typography',
			'transport'						 => 'postMessage'
		),
		'meta_font' 						 => array(
			'label' 						 => __( 'Meta Font', 'anva' ),
			'id' 							 => 'meta_font',
			'atts'							 => array( 'style', 'weight', 'face' ),
			'type' 							 => 'typography',
			'transport'						 => 'postMessage'
		),
		'heading_h1' 						 => array(
			'label' 					     => __( 'H1', 'anva' ),
			'id' 							 => 'heading_h1',
			'type'							 => 'typography',
			'atts'							 => array( 'select' ),
			'transport'						 => 'postMessage'
		),
		'heading_h2' 						 => array(
			'label' 						 => __( 'H2', 'anva' ),
			'id' 							 => 'heading_h2',
			'type'							 => 'typography',
			'atts'							 => array( 'select' ),
			'transport'						 => 'postMessage'
		),
		'heading_h3' 						 => array(
			'label' 						 => __( 'H3', 'anva' ),
			'id' 							 => 'heading_h3',
			'type'							 => 'typography',
			'atts'							 => array( 'select' ),
			'transport'						 => 'postMessage'
		),
		'heading_h4' 						 => array(
			'label' 						 => __( 'H4', 'anva' ),
			'id' 							 => 'heading_h4',
			'type'							 => 'typography',
			'atts'							 => array( 'select' ),
			'transport'						 => 'postMessage'
		),
		'heading_h5' 						 => array(
			'label' 						 => __( 'H5', 'anva' ),
			'id' 							 => 'heading_h5',
			'transport'						 => 'postMessage'
		),
		'heading_h6' 						 => array(
			'label' 						 => __( 'H6', 'anva' ),
			'id' 							 => 'heading_h6',
			'type'							 => 'typography',
			'atts'							 => array( 'select' ),
			'transport'						 => 'postMessage'
		),
	);
	anva_add_customizer_section( 'typography', __( 'Typography', 'anva' ), $font_options, 102 );

	// Link options
	$link_options = array(
		'link_color' 						 => array(
			'label' 						 => __( 'Link Color', 'anva' ),
			'id' 							 => 'link_color',
			'type' 							 => 'color',
			'priority'						 => 1
		),
		'link_hover_color' 				     => array(
			'label' 					     => __( 'Link Hover Color', 'anva' ),
			'id' 							 => 'link_hover_color',
			'type' 							 => 'color',
			'priority'						 => 2
		),
		'footer_link_color' 			     => array(
			'label' 						 => __( 'Footer Link Color', 'anva' ),
			'id' 							 => 'footer_link_color',
			'type' 							 => 'color',
			'priority'						 => 3
		),
		'footer_link_hover_color'            => array(
			'label' 						 => __( 'Footer Link Hover Color', 'anva' ),
			'id' 							 => 'footer_link_hover_color',
			'type' 							 => 'color',
			'priority'						 => 4
		)
	);
	anva_add_customizer_section( 'links', __( 'Links', 'anva' ), $link_options, 103 );

	// Setup custom styles option
	$custom_css_options = array(
		'custom_css' 					     => array(
			'label' 						 => __( 'Enter styles to preview their results.', 'anva' ),
			'id' 							 => 'custom_css',
			'type' 							 => 'textarea',
			'transport'						 => 'postMessage'
		)
	);
	anva_add_customizer_section( 'custom_css', __( 'Custom CSS', 'anva' ), $custom_css_options, 121 );

}
add_action( 'after_setup_theme', 'theme_customizer_options' );

/**
 * Add specific theme elements to customizer.
 *
 * @since  1.0.0.
 * @param  object  $wp_customize
 * @return void
 */
function theme_customizer_init( $wp_customize ) {

	// Remove custom background options
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'header_image' );

}
add_action( 'customize_register', 'theme_customizer_init' );
