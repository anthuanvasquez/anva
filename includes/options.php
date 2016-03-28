<?php
/**
 * Use Anva_Options_API to add options onto options already
 * present in framework.
 *
 * @since  1.0.0
 * @return void
 */
function anva_options() {

	// Assets
	$skin_path = get_template_directory_uri() . '/assets/images/skins/';

	// Skin Colors
	$schemes = array();
	foreach ( anva_get_colors_scheme( $skin_path, 'jpg' ) as $color_id => $color ) {
		$schemes[ $color_id ] = $color['image'];
	}

	// Transitions
	$transitions = array();
	foreach ( range( 0, 14 ) as $key ) {
		$transitions[ $key ] = __( 'Loader Style', 'anva' ) . ' ' . $key;
	}
	$transitions[0] = __( 'Disable Transition', 'anva' );
	$transitions[1] = __( 'Default Loader Style', 'anva' );

	// Animations
	$animations = array();
	foreach ( anva_get_animations() as $animation_id => $animation ) {
		$animations[ $animation ] = $animation;
	}

	/* ---------------------------------------------------------------- */
	/* Styles
	/* ---------------------------------------------------------------- */

	$base_color = array(
		'name' => __( 'Base Color Scheme', 'anva' ),
		'desc' => sprintf(
			__( 'Choose skin color for the theme. Check live preview in the %s.', 'anva' ),
			sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=base_color' ) . '">%s</a>', __( 'Customizer', 'anva' ) )
		),
		'id' => 'base_color',
		'std' => 'blue',
		'type' => 'images',
		'options' => $schemes
	);
	anva_add_option( 'styles', 'main', 'base_color', $base_color );

	$base_color_style = array(
		'name' => __( 'Base Color Style', 'anva' ),
		'desc' => sprintf(
			__( 'Choose skin style for the theme. Check live preview in the %s.', 'anva' ),
			sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=base_color_style' ) . '">%s</a>', __( 'Customizer', 'anva' ) )
		),
		'id' => 'base_color_style',
		'std' => 'light',
		'type' => 'select',
		'options' => array(
			'light' => __( 'Light', 'anva' ),
			'dark' => __( 'Dark', 'anva' ),
		)
	);
	anva_add_option( 'styles', 'main', 'base_color_style', $base_color_style );

	$footer_color = array(
		'name' => __( 'Footer Color', 'anva' ),
		'desc' => __( 'Choose the color style for the footer.', 'anva' ),
		'id' => 'footer_color',
		'std' => 'dark',
		'type' => 'select',
		'options' => array(
			'light' => __( 'Light', 'anva' ),
			'dark' 	=> __( 'Dark', 'anva' )
		)
	);
	anva_add_option( 'styles', 'main', 'footer_color', $footer_color );

	/* ---------------------------------------------------------------- */
	/* Links
	/* ---------------------------------------------------------------- */

	$links_options = array(
		'link_color' => array(
			'name' => __( 'Link Color', 'anva' ),
			'desc' => __( 'Set the link color.', 'anva' ),
			'id' => 'link_color',
			'std' => '#3498db',
			'type' => 'color'
		),
		'link_color_hover' => array(
			'name' => __( 'Link Color (:Hover)', 'anva' ),
			'desc' => __( 'Set the link color.', 'anva' ),
			'id' => 'link_color_hover',
			'std' => '#222222',
			'type' => 'color'
		)
	);
	anva_add_option_section( 'styles', 'links', __( 'Links', 'anva' ), null, $links_options, false );

	// Header
	// 
	$header_styles = array();
	foreach ( anva_get_header_styles() as $style_id => $style ) {
		$header_styles[ $style_id ] = $style['name'];
	}

	$header_options = array(
		'header_style' => array(
			'name' => __( 'Header Style', 'anva' ),
			'desc' => __( 'Choose the style for the header.', 'anva' ),
			'id' => 'header_style',
			'std' => 'normal',
			'type' => 'select',
			'options' => $header_styles,
		),
		'header_color' => array(
			'name' => __( 'Header Color', 'anva' ),
			'desc' => __( 'Choose the color for the header.', 'anva' ),
			'id' => 'header_color',
			'std' => 'light',
			'type' => 'select',
			'options' => array(
				'light' => __( 'Light', 'anva' ),
				'dark' => __( 'Dark', 'anva' ),
			),
		),
		'primary_menu_style' => array(
			'name' => __( 'Primary Menu Style', 'anva' ),
			'desc' => __( 'Choose the style for the primary menu navigation.', 'anva' ),
			'id' => 'primary_menu_style',
			'std' => 'light',
			'type' => 'select',
			'options' => array(
				'default' => __( 'Default Style', 'anva' ),
				'style-2' => __( 'Style 2', 'anva' ),
				'style-3' => __( 'Style 3', 'anva' ),
				'style-4' => __( 'Style 4', 'anva' ),
				'style-5' => __( 'Style 5', 'anva' ),
				'style-6' => __( 'Style 6', 'anva' ),
				'style-7' => __( 'Style 7', 'anva' ),
				'style-8' => __( 'Style 8', 'anva' ),
				'style-9' => __( 'Style 9', 'anva' ),
			),
		),
		'primary_menu_color' => array(
			'name' => __( 'Primary Menu Color', 'anva' ),
			'desc' => __( 'Choose the color for the primary menu navigation.', 'anva' ),
			'id' => 'primary_menu_color',
			'std' => 'light',
			'type' => 'select',
			'options' => array(
				'light' => __( 'Light', 'anva' ),
				'dark' => __( 'Dark', 'anva' ),
			),
		),
	);
	anva_add_option_section( 'styles', 'header', __( 'Header', 'anva' ), null, $header_options, false  );

	$social_icons_options = array(
		'social_icons_style' => array(
			'name' => __('Social Icons Style', 'anva'),
			'desc' => __('choose the style for your social icons.', 'anva'),
			'id' => 'social_icons_style',
			'std' => 'default',
			'type' => 'select',
			'options' => array(
				'default' 	=> __('Default Style', 'anva'),
				'light' 	=> __('Light', 'anva'),
				'dark' 		=> __('Dark', 'anva'),
				'text-color' => __('Text Colored', 'anva'),
				'colored' => __('Colored', 'anva'),
			)
		),
		'social_icons_shape' => array(
			'name' => __('Social Icons Shape', 'anva'),
			'desc' => __('choose the shape for your social icons.', 'anva'),
			'id' => 'social_icons_shape',
			'std' => 'default',
			'type' => 'select',
			'options' => array(
				'default' 	=> __('Default Shape', 'anva'),
				'rounded' 	=> __('Rounded', 'anva'),
			)
		),
		'social_icons_border' => array(
			'name' => __('Social Icons Border', 'anva'),
			'desc' => __('Choose the shape for your social icons.', 'anva'),
			'id' => 'social_icons_border',
			'std' => 'default',
			'type' => 'select',
			'options' => array(
				'default' 	=> __('Default Border', 'anva'),
				'borderless' 	=> __('Without Border', 'anva'),
			)
		),
		'social_icons_size' => array(
			'name' => __('Social Icons Size', 'anva'),
			'desc' => __('Choose the size for your social icons.', 'anva'),
			'id' => 'social_icons_size',
			'std' => 'default',
			'type' => 'select',
			'options' => array(
				'default' 	=> __('Default Size', 'anva'),
				'small' 	=> __('Small', 'anva'),
				'large' 	=> __('Large', 'anva'),
			)
		),
	);
	anva_add_option_section( 'styles', 'social_icons', __( 'Social Icons', 'anva' ), null, $social_icons_options, false );

	$page_loading_options = array(
		'page_loader' => array(
			'name' => __( 'Loader', 'anva' ),
			'desc' => __( 'Choose the loading styles of the Animation you want to show to your visitors while the pages of you Website loads in the background.', 'anva' ),
			'id' => 'page_loader',
			'std' => '1',
			'type' => 'select',
			'options' => $transitions
		),
		'page_loader_color' => array(
			'name' => __( 'Color', 'anva' ),
			'desc' => __( 'Choose the loader color.', 'anva' ),
			'id' => 'page_loader_color',
			'std' => '#dddddd',
			'type' => 'color',
		),
		'page_loader_timeout' => array(
			'name' => __( 'Timeout', 'anva' ),
			'desc' => __( 'Enter the timeOut in milliseconds to end the page preloader immaturely. Default is 1000.', 'anva' ),
			'id' => 'page_loader_timeout',
			'std' => 1000,
			'type' => 'number',
		),
		'page_loader_speed_in' => array(
			'name' => __( 'Speed In', 'anva' ),
			'desc' => __( 'Enter the speed of the animation in milliseconds on page load. Default is 800.', 'anva' ),
			'id' => 'page_loader_speed_in',
			'std' => 800,
			'type' => 'number',
		),
		'page_loader_speed_out' => array(
			'name' => __( 'Speed Out', 'anva' ),
			'desc' => __( 'Enter the speed of the animation in milliseconds on page load. Default is 800.', 'anva' ),
			'id' => 'page_loader_speed_out',
			'std' => 800,
			'type' => 'number',
		),
		'page_loader_animation_in' => array(
			'name' => __( 'Animation In', 'anva' ),
			'desc' => __( 'Choose the animation style on page load.', 'anva' ),
			'id' => 'page_loader_animation_in',
			'std' => 'fadeIn',
			'type' => 'select',
			'options' => $animations,
		),
		'page_loader_animation_out' => array(
			'name' => __( 'Animation Out', 'anva' ),
			'desc' => __( 'Choose the animation style on page out.', 'anva' ),
			'id' => 'page_loader_animation_out',
			'std' => 'fadeOut',
			'type' => 'select',
			'options' => $animations
		),
	);
	anva_add_option_section( 'styles', 'page_loader_transition', __( 'Page Loading Transition', 'anva' ), null, $page_loading_options, false );


	/* ---------------------------------------------------------------- */
	/* Background
	/* ---------------------------------------------------------------- */

	// Background defaults
	$background_defaults = array(
		'image' 		=> '',
		'repeat' 		=> 'repeat',
		'position' 		=> 'top center',
		'attachment' 	=> 'scroll'
	);

	$background_options = array(
		'bg_color' => array(
			'name' => __('Background Color', 'anva'),
			'desc' => __('Choose the background color.', 'anva'),
			'id' => 'bg_color',
			'std' => '#dddddd',
			'type' => 'color'
		),
		'background_image' => array(
			'name' => __('Background Image', 'anva'),
			'desc' => __('Choose the background image. Note: this option only take effect if layout style is boxed.', 'anva'),
			'id' => 'background_image',
			'std' => $background_defaults,
			'type' => 'background'
		),
		'background_cover' => array(
			'name' => __( 'Background Cover', 'anva' ),
			'desc' => __( 'Use background size cover.', 'anva' ),
			'id' => 'background_cover',
			'std' => '0',
			'type' => 'switch'
		),
		'background_pattern' => array(
			'name' => __( 'Background Pattern', 'anva' ),
			'desc' => sprintf( __( 'Choose the background pattern. Note: this option is only applied if the braclground image option is empty. Check live preview in the %s.', 'anva' ), sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=background_pattern' ) . '">%s</a>', __( 'Customizer', 'anva' ) ) ),
			'id' => 'background_pattern',
			'std' => '',
			'type' => 'select',
			'options' => array(
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
			)
		)
	);
	anva_add_option_section( 'styles', 'background', __( 'Background', 'anva' ), null, $background_options, false );

	/* ---------------------------------------------------------------- */
	/* Typography
	/* ---------------------------------------------------------------- */

	$typography_options = array(
		'body_font' => array(
			'name' => __( 'Body Font', 'anva' ),
			'desc' => __( 'This applies to most of the text on your site.', 'anva' ),
			'id' => 'body_font',
			'std' => array(
				'size' => '14px',
				'face' => 'google',
				'google' => 'Lato:300,400,400italic,600,700',
				'style' => 'normal',
				'color' => '#555555'
			),
			'type' => 'typography',
			'options' => array( 'size', 'style', 'face', 'color' )
		),
		'heading_font' => array(
			'name' => __( 'Headings Font', 'anva' ),
			'desc' => __( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', 'anva' ),
			'id' => 'heading_font',
			'std' => array(
				'face' => 'google',
				'google' => 'Raleway:300,400,500,600,700',
				'style' => 'normal',
				'color' => '#444444'
			),
			'type' => 'typography',
			'options' => array( 'style', 'face', 'color' )
		),
		'heading_h1' => array(
			'name' => __( 'H1', 'anva' ),
			'desc' => __( 'Select the size for H1 tag in px.', 'anva' ),
			'id' => 'heading_h1',
			'std' => '27',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
			)
		),
		'heading_h2' => array(
			'name' => __( 'H2', 'anva' ),
			'desc' => __( 'Select the size for H2 tag in px.', 'anva' ),
			'id' => 'heading_h2',
			'std' => '24',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
			)
		),
		'heading_h3' => array(
			'name' => __('H3', 'anva'),
			'desc' => __('Select the size for H3 tag in px.', 'anva'),
			'id' => 'heading_h3',
			'std' => '18',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
			)
		),
		'heading_h4' => array(
			'name' => __('H4', 'anva'),
			'desc' => __('Select the size for H4 tag in px.', 'anva'),
			'id' => 'heading_h4',
			'std' => '14',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
			)
		),
		'heading_h5' => array(
			'name' => __('H5', 'anva'),
			'desc' => __('Select the size for H5 tag in px.', 'anva'),
			'id' => 'heading_h5',
			'std' => '13',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
			)
		),
		'heading_h6' => array(
			'name' => __('H6', 'anva'),
			'desc' => __('Select the size for H6 tag in px.', 'anva'),
			'id' => 'heading_h6',
			'std' => '11',
			'type' => 'range',
			'options' => array(
				'min' => 9,
				'max' => 72,
				'step' => 1,
			)
		),
	);
	anva_add_option_section( 'styles', 'typography', __( 'Typography', 'anva' ), null, $typography_options, false );

	/* ---------------------------------------------------------------- */
	/* Custom
	/* ---------------------------------------------------------------- */

	$custom_options = array(
		'css_warning' => array(
			'name' => __( 'Info', 'anva'),
			'desc' => __( 'If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva'),
			'id' => 'css_warning',
			'type' => 'info',
		),
		'custom_css' => array(
			'name' => __( 'Custom CSS', 'anva'),
			'desc' => __( 'Use custom CSS to override the theme styles.', 'anva'),
			'id' => 'custom_css',
			'std' => '',
			'type' => 'textarea'
		),
		'custom_css_stylesheet' => array(
			'name' => __( 'Custom CSS Stylesheet', 'anva'),
			'desc' => __( 'Add a custom stylesheet with all your custom styled CSS for new styles or overwriting default theme styles for better hanlding updates.', 'anva' ),
			'id' => 'custom_css_stylesheet',
			'std' => 'no',
			'type' => 'select',
			'options' => array(
				'yes' => __( 'Yes, add custom stylesheet in the head', 'anva' ),
				'no' => __( 'No, I don\'t add custom stylesheet in the head', 'anva' ),		
			)
		)
	);
	anva_add_option_section( 'styles', 'custom', __( 'Custom', 'anva' ), null, $custom_options, false );

	/* ---------------------------------------------------------------- */
	/* Header
	/* ---------------------------------------------------------------- */
	
	$side_header_icons = array(
		'name' => __( 'Side Header Social Icons', 'anva' ),
		'desc' => __( 'Show social media icons below primary menu in side header.', 'anva' ),
		'id' => 'side_header_icons',
		'std' => '1',
		'type' => 'switch',
	);
	anva_add_option( 'layout', 'header', 'side_header_icons', $side_header_icons );

	$top_bar_icons = array(
		'name' => __( 'Top Bar Social Icons', 'anva' ),
		'desc' => __( 'Show social media icons in the top bar.', 'anva' ),
		'id' => 'top_bar_icons',
		'std' => '1',
		'type' => 'switch',
	);
	anva_add_option( 'layout', 'header', 'top_bar_icons', $top_bar_icons );

	$footer_icons = array(
		'name' => __( 'Footer Social Icons', 'anva' ),
		'desc' => __( 'Show social media icons to the right of footer.', 'anva' ),
		'id' => 'footer_icons',
		'std' => '1',
		'type' => 'switch',
	);
	anva_add_option( 'layout', 'footer', 'footer_icons', $footer_icons );

	/* ---------------------------------------------------------------- */
	/* Galleries
	/* ---------------------------------------------------------------- */

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
			'desc' => sprintf(
				__( 'Choose the default animation for gallery images. Get a %s of the animations.', 'anva' ),
				sprintf( '<a href="' . esc_url( 'https://daneden.github.io/animate.css/' ) . '" target="_blank">%s</a>', __( 'preview', 'anva' ) )
			),
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

	/* ---------------------------------------------------------------- */
	/* Sliders
	/* ---------------------------------------------------------------- */

	// Get all sliders
	$sliders = anva_get_sliders();

	// Pull all sliders
	$slider_select = array();
	foreach ( $sliders as $slider_id => $slider ) {
		$slider_select[ $slider_id ] = $slider['name'];
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
			'std' => 'full-screen',
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
			'std' => 'false',
			'type' => 'select',
			'options'	=> array(
				'true' 	=> 'Yes, enable parallax',
				'false'	=> 'No, disable parallax'
			),
		),
	);
	
	// Get dynamic slider options
	foreach ( $sliders as $slider_id => $slider ) {
		foreach ( $slider['options'] as $option_id => $option ) {
			$slider_options[ $option_id ] = $option;
		}
	}

	$slider_options['revslider_id'] = array(
		'name' => __( 'Revolution Slider ID', 'anva' ),
		'desc' => __( 'Show or hide the slider direction navigation.', 'anva' ),
		'id' => 'revslider_id',
		'std' => '',
		'type' => 'text',
		'class' => 'slider-item revslider hide'
	);
	anva_add_option_section( 'layout', 'slider', __( 'Sliders', 'anva' ), null, $slider_options, false );

	/* ---------------------------------------------------------------- */
	/* Login
	/* ---------------------------------------------------------------- */

	if ( anva_support( 'anva-login-styles' ) ) {
	
		// Author default credtis
		$author = '<a href="' . esc_url( 'http://anthuanvasquez.net' ) . '" target="_blank">Anthuan Vasquez</a>';

		$login_options = array(
			'login_style' => array(
				'name' => __( 'Style', 'anva'),
				'desc' => __( 'Select the login style.', 'anva'),
				'id' => 'login_style',
				'std' => '',
				'type' => 'select',
				'options' => array(
					'' 			 => __( 'None', 'anva' ),
					'style1' => __( 'Style 1', 'anva' ),
					'style2' => __( 'Style 2', 'anva' ),
					'style3' => __( 'Style 3', 'anva' )
				)
			),
			'login_copyright' => array(
				'name' => __( 'Copyright Text', 'anva'),
				'desc' => __( 'Enter the copyright text you\'d like to show in the footer of your login page.', 'anva'),
				'id' => 'login_copyright',
				'std' => sprintf( __( 'Copyright %s %s. Designed by %s.', 'anva' ), date( 'Y' ), anva_get_theme( 'name' ), $author ),
				'type' => 'textarea',
			),
		);

		anva_add_option_section( 'layout', 'login', __( 'Login', 'anva' ), null, $login_options, false );

		$single_post_reading_bar = array(
			'name' => __( 'Show Post Reading Bar', 'anva'),
			'desc' => __( 'Select to display the post reading bar indicator in single posts.', 'anva'),
			'id' => 'single_post_reading_bar',
			'std' => '',
			'type' => 'select',
			'options' => array(
				'show' => __( 'Show the post reading bar', 'anva' ),
				'hide' => __( 'Hide the post reading bar', 'anva' ),
			)
		);
		anva_add_option( 'content', 'single', 'single_post_reading_bar', $single_post_reading_bar );

		$debug_options = array(
			'debug' => array(
				'name' => __( 'Show Debug Info?', 'anva'),
				'desc' => sprintf( __( 'Enable this option to show debug information in the footer, as database queries, memory usage and others. Note: the debug information will only be visible to administrators and the wordpress constant %s be set to TRUE.', 'anva' ), '<a href="' . esc_url( 'http://codex.wordpress.org/Debugging_in_WordPress' ) . '" target="_blank">WP_DEBUG</a>' ),
				'id' => 'debug',
				'std' => '0',
				'type' => 'switch',
			)
		);
		anva_add_option_section( 'advanced', 'debug', __( 'Debug', 'anva' ), null, $debug_options, false );


	}


}
add_action( 'after_setup_theme', 'anva_options', 11 );

/**
 * Use Anva_Builder_Elements_API to add elements onto elements already
 * present in framework.
 *
 * @since  1.0.0
 * @return void
 */
function anva_theme_elements() {
	
	// Get framework assets path
	$image_path = trailingslashit( anva_get_core_admin_uri() . 'assets/images/builder' );

	// Get sidebar locations
	$sidebars = array();
	foreach ( anva_get_sidebar_layouts() as $sidebar_id => $sidebar ) {
		$sidebars[$sidebar_id] = $sidebar['name'];
	}
	
	/*--------------------------------------------*/
	/* Text Sidebar
	/*--------------------------------------------*/

	$text_sidebar_icon = $image_path . '/contact_sidebar.png';
	$text_sidebar_desc = __( 'Create a text block with sidebar.', 'anva' );
	$text_sidebar_atts = array(
		'slug' => array(
			'title' => 'Slug (Optional)',
			'type' => 'text',
			'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
		),
		'sidebar' => array(
			'Title' => 'Content Sidebar',
			'type' => 'select',
			'options' => $sidebars,
			'desc' => 'You can select sidebar to display next to classic blog content',
		),
		'padding' => array(
			'title' => 'Content Padding',
			'type' => 'slider',
			"std" => "30",
			"min" => 0,
			"max" => 200,
			"step" => 5,
			'desc' => 'Select padding top and bottom value for this header block',
		),
		'custom_css' => array(
			'title' => 'Custom CSS',
			'type' => 'text',
			'desc' => 'You can add custom CSS style for this block (advanced user only)',
		)
	);
	anva_add_builder_element( 'text_sidebar', __( 'Text With Sidebar', 'anva' ), $text_sidebar_icon, $text_sidebar_atts, $text_sidebar_desc, true );

	/*--------------------------------------------*/
	/* Contact Sidebar
	/*--------------------------------------------*/

	$contact_sidebar_icon = $image_path . '/contact_sidebar.png';
	$contact_sidebar_desc = __( 'Create a contact form with sidebar.', 'anva' );
	$contact_sidebar_atts = array(
		'slug' => array(
			'title' => 'Slug (Optional)',
			'type' => 'text',
			'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers and hyphens.',
		),
		'subtitle' => array(
			'title' => 'Sub Title (Optional)',
			'type' => 'text',
			'desc' => 'Enter short description for this header.',
		),
		'sidebar' => array(
			'Title' => 'Content Sidebar',
			'type' => 'select',
			'options' => $sidebars,
			'desc' => 'You can select sidebar to display next to classic blog content.',
		),
		'padding' => array(
			'title' => 'Content Padding',
			'type' => 'slider',
			"std" => "30",
			"min" => 0,
			"max" => 200,
			"step" => 5,
			'desc' => 'Select padding top and bottom value for this header block',
		),
		'custom_css' => array(
			'title' => 'Custom CSS',
			'type' => 'text',
			'desc' => 'You can add custom CSS style for this block (advanced user only)',
		),
	);
	anva_add_builder_element( 'contact_sidebar', __( 'Contact Form With Sidebar', 'anva' ), $contact_sidebar_icon, $contact_sidebar_atts, $contact_sidebar_desc, true );

}
add_action( 'after_setup_theme', 'anva_theme_elements' );