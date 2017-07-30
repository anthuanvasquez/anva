<?php
/**
 * Feature options.
 *
 * @package AnvaFramework
 */

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feature options tab.
 *
 * @since  1.0.0
 * @return array $feature Options array,
 */
function anva_theme_options_feature() {

	// Animations.
	$animations = array();
	foreach ( anva_get_animations() as $animation_id => $animation ) {
		$animations[ $animation_id ] = $animation;
	}

	// Pull all gallery templates
	$galleries = array();
	foreach ( anva_gallery_templates() as $key => $gallery ) {
		$galleries[ $key ] = $gallery['name'];
	}

	// Get all sliders.
	$sliders = anva_get_sliders();

	// Add slider options.
	$slider_select  = array();
	$slider_options = array();
	foreach ( $sliders as $slider_id => $slider ) {
		$slider_select[ $slider_id ] = $slider['name'];
		foreach ( $slider['options'] as $option_id => $option ) {
			$slider_options[ $option_id ] = $option;
		}
	}

	// Revolution Slider.
	if ( class_exists( 'RevSliderAdmin' ) ) {
		$slider_select['revslider'] = 'Revolution Slider';
	}

	// Slideshows options.
	$slideshows = array(
		'slider_id' => array(
			'name' => esc_html__( 'Slider', 'anva' ),
			'desc' => esc_html__( 'Select the main slider. Based on the slider you select, the options below may change.', 'anva' ),
			'id' => 'slider_id',
			'std' => 'standard',
			'type' => 'select',
			'options' => $slider_select,
		),
		'slider_style' => array(
			'name' => esc_html__( 'Style', 'anva' ),
			'desc' => esc_html__( 'Select the slider style.', 'anva' ),
			'id' => 'slider_style',
			'std' => 'full-screen',
			'type' => 'select',
			'options' => array(
				'slider-boxed' => esc_attr__( 'Boxed', 'anva' ),
				'full-screen'  => esc_attr__( 'Full Screen', 'anva' ),
			),
		),
		'slider_parallax' => array(
			'name' => esc_html__( 'Parallax', 'anva' ),
			'desc' => esc_html__( 'If you use the parallax effect for sliders enable this option.', 'anva' ),
			'id' => 'slider_parallax',
			'std' => 'false',
			'type' => 'select',
			'options'   => array(
				'true'  => esc_attr__( 'Yes, enable parallax', 'anva' ),
				'false' => esc_attr__( 'No, disable parallax', 'anva' ),
			),
		),
		'slider_thumbnails' => array(
			'name' => esc_html__( 'Thumbnails Size', 'anva' ),
			'desc' => esc_html__( 'Select the image size you want to show in featured content.', 'anva' ),
			'id' => 'slider_thumbnails',
			'std' => 'anva_xl',
			'type' => 'select',
			'options' => anva_get_image_sizes_thumbnail(),
		),
		'revslider_id' => array(
			'name' => esc_html__( 'Revolution Slider ID', 'anva' ),
			'desc' => esc_html__( 'Show or hide the slider direction navigation.', 'anva' ),
			'id' => 'revslider_id',
			'std' => '',
			'type' => 'text',
			'class' => 'slider-item revslider hide',
		),
		'slider_area' => array(
			'name' => esc_html__( 'Slider Area', 'anva' ),
			'desc' => esc_html__( 'Select the slider area.', 'anva' ),
			'id' => 'slider_area',
			'std' => array(
				'front' => '1',
			),
			'type' => 'multicheck',
			'options' => anva_get_default_slider_areas(),
		),
		'slider_group_area' => array(
			'name' => esc_html__( 'Slider Group and Areas', 'anva' ),
			'desc' => esc_html__( 'Select the slider area and groups slides.', 'anva' ),
			'id'   => 'slider_group_area',
			'type' => 'slider_group_area',
		),
	);

	$slideshows = array_merge( $slideshows, $slider_options );

	$feature = array(
		'gallery' => array(
			'gallery_sort' => array(
				'name' => esc_html__( 'Images Sorting', 'anva' ),
				'desc' => esc_html__( 'Select how you want to sort gallery images.', 'anva' ),
				'id' => 'gallery_sort',
				'std' => 'drag',
				'type' => 'select',
				'options' => array(
					'drag'  => esc_attr__( 'Drag & Drop', 'anva' ),
					'desc'  => esc_attr__( 'Newest', 'anva' ),
					'asc'   => esc_attr__( 'Oldest', 'anva' ),
					'rand'  => esc_attr__( 'Random', 'anva' ),
					'title' => esc_attr__( 'Title', 'anva' ),
				),
			),
			'gallery_template' => array(
				'name' => esc_html__( 'Default Template', 'anva' ),
				'desc' => esc_html__( 'Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', 'anva' ),
				'id' => 'gallery_template',
				'std' => '3-col',
				'type' => 'select',
				'options' => $galleries,
			),
			'gallery_animate' => array(
				'name' => esc_html__( 'Animate', 'anva' ),
				'desc' => sprintf(
					esc_html__( 'Choose the default animation for gallery images. Get a %s of the animations.', 'anva' ),
					sprintf( '<a href="' . esc_url( 'https://daneden.github.io/animate.css/' ) . '" target="_blank">%s</a>', esc_html__( 'preview', 'anva' ) )
				),
				'id' => 'gallery_animate',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $animations,
			),
			'gallery_delay' => array(
				'name' => esc_html__( 'Delay', 'anva' ),
				'desc' => esc_html__( 'Choose the default delay for animation.', 'anva' ),
				'id' => 'gallery_delay',
				'std' => 400,
				'type' => 'number',
			),
		),
		'slideshows' => $slideshows,
	);

	return $feature;
}
