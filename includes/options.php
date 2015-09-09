<?php
/**
 * Use Anva_Options_API to add options onto options already
 * present in framework
 *
 * @since 1.0.0
 */
function eren_options() {

	/* ---------------------------------------------------------------- */
	/* Styles
	/* ---------------------------------------------------------------- */

	// Add skin colors to Styles -> Layout
	$base_colors = array(
		'name' => __( 'Base Colors Scheme', 'anva' ),
		'desc' => __( 'Choose skin color for the theme.', 'anva' ),
		'id' => 'base_colors',
		'std' => 'blue',
		'type' => 'select',
		'options' => array(
			'blue' 		=> 'Blue',
			'green' 	=> 'Green',
			'orange' 	=> 'Orange',
			'red' 		=> 'Red',
			'teal' 		=> 'Teal',
		)
	);
	anva_add_option( 'styles', 'layout', 'base_colors', $base_colors );

	/* ---------------------------------------------------------------- */
	/* Galleries
	/* ---------------------------------------------------------------- */

	if ( is_admin() ) {

		// Pull all gallery templates
		$galleries = array();
		foreach ( anva_gallery_templates() as $key => $gallery ) {
			$galleries[$key] = $gallery['name'];
		}

		$animations = array();
		foreach ( anva_get_animations() as $key => $value ) {
			$animations[$value] = $value; 
		}

		$gallery_options = array(
			'gallery_sort' => array(
				'name' => __('Images Sorting', 'anva'),
				'desc' => __('Select how you want to sort gallery images.', 'anva'),
				'id' => 'gallery_sort',
				'std' => 'drag',
				'type' => 'select',
				'options' => array(
					'drag' => __('Drag & Drop', 'anva'),
					'desc' => __('Newest', 'anva'),
					'asc' => __('Oldest', 'anva'),
					'rand' => __('Random', 'anva'),
					'title' => __('Title', 'anva')
				)
			),
			'gallery_template' => array(
				'name' => __('Default Template', 'anva'),
				'desc' => __('Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', 'anva'),
				'id' => 'gallery_template',
				'std' => '3-col',
				'type' => 'select',
				'options' => $galleries
			),
			'gallery_animate' => array(
				'name' => __( 'Animate', 'anva' ),
				'desc' => __( 'Choose the default animation for gallery images.', 'anva' ),
				'id' => 'gallery_animate',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $animations
			),
			'gallery_delay' => array(
				'name' => __( 'Delay', 'anva' ),
				'desc' => __( 'Choose the default delay for animation.', 'anva' ),
				'id' => 'gallery_delay',
				'std' => 400,
				'type' => 'number'
			),
		);
		anva_add_option_section( 'layout', 'gallery', __( 'Galleries', 'anva' ), null, $gallery_options, false );
	}

	/* ---------------------------------------------------------------- */
	/* Sliders
	/* ---------------------------------------------------------------- */

	if ( is_admin() ) {

		// Get all sliders
		$sliders = anva_get_sliders();

		// Pull all sliders
		$slider_select = array();
		foreach ( $sliders as $slider_id => $slider ) {
			$slider_select[$slider_id] = $slider['name'];
		}

		// Revolution Slider
		if ( class_exists( 'RevSliderAdmin' ) ) {
			$slider_select['revslider'] = 'Revolution Slider';
		}

		$slider_options = array(
			'slider_id' => array(
				'name' => __( 'Slider', 'anva'),
				'desc' => __( 'Select the main slider. Based on the slider you select, the options below may change.', 'anva'),
				'id' => 'slider_id',
				'std' => 'standard',
				'type' => 'select',
				'options' => $slider_select
			),
			'slider_style' => array(
				'name' => __( 'Style', 'anva'),
				'desc' => __( 'Select the slider style.', 'anva'),
				'id' => 'slider_style',
				'std' => 'boxed',
				'type' => 'select',
				'options' => array(
					'slider-boxed' => __( 'Boxed', 'anva' ),
					'full-screen'  => __( 'Full Screen', 'anva' ),
				)
			),
			'slider_parallax' => array(
				'name' => __( 'Parallax', 'anva'),
				'desc' => __( 'If you use the parallax effect for sliders enable this option.', 'anva'),
				'id' => 'slider_parallax',
				'std' => 'true',
				'type' => 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable parallax.',
					'false'	=> 'No, disable parallax.'
				),
			),
		);
		
		// Get dynamic slider options
		foreach ( $sliders as $slider_id => $slider ) {
			foreach ( $slider['options'] as $option_id => $option ) {
				$slider_options[$option_id] = $option;
			}
		}

		$slider_options['revslider_id'] = array(
			'name' => __( 'Revolution Slider ID', 'anva' ),
			'desc' => __( 'Show or hide the slider direction navigation.', 'anva' ),
			'id' => 'revslider_id',
			'std' => '',
			'type' => 'text',
			'class' => 'revslider hide'
		);
		anva_add_option_section( 'layout', 'slider', __( 'Sliders', 'anva' ), null, $slider_options, false );
	}

	/* ---------------------------------------------------------------- */
	/* Minify
	/* ---------------------------------------------------------------- */

	$minify_options = array(
		'minify_warning' => array(
			'name' => __( 'Warning', 'anva' ),
			'desc' => __( 'If you have a cache plugin installed in your site desactive this options.', 'anva' ),
			'id' 	 => 'minify_warning',
			'type' => 'info'
		),

		'compress_css' => array(
			'name' => __( 'Combine and Compress CSS files', 'anva'),
			'desc' => __( 'Combine and compress all CSS files to one. Help reduce page load time and increase server resources.', 'anva'),
			'id' => "compress_css",
			'std' => '0',
			'type' => 'checkbox'
		),

		'compress_js' => array(
			'name' => __( 'Combine and Compress Javascript files', 'anva' ),
			'desc' => __( 'Combine and compress all Javascript files to one. Help reduce page load time and increase server resource.', 'anva'),
			'id' => "compress_js",
			'std' => '0',
			'type' => 'checkbox'
		)
	);
	anva_add_option_section( 'advanced', 'minify', __( 'Minify', 'anva' ), null, $minify_options, false );

}
add_action( 'after_setup_theme', 'eren_options' );

/**
 * Use Anva Builder Elements API to add elements onto elements already
 * present in framework
 *
 * @since 1.0.0
 */
function eren_elements() {
	
	$image_path = anva_get_core_uri() . '/assets/images/builder/';
	
	$elements['box'] = array(
		'id' => 'box',
		'name' => 'This Box',
		'icon' => $image_path . 'header.png',
		'attr' => array(
			'subtitle' => array(
				'title' => 'Sub Title (Optional)',
				'type' => 'text',
				'desc' => 'Enter short description for this header',
			)
		),
		'desc' => 'This is a Box'
	);
	anva_add_builder_element( $elements['box']['id'], $elements['box']['name'], $elements['box']['icon'], $elements['box']['attr'], $elements['box']['desc'], true );
	
}
add_action( 'after_setup_theme', 'eren_elements' );