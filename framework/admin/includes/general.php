<?php

// Instantiate the import export options
Anva_Options_Import_Export::instance();

/**
 * Init admin modules.
 *
 * @since 1.0.0
 * @return void
 */
function anva_admin_init() {
	
	// Instantiate the options page
	Anva_Options_Page::instance();
	
	// Instantiate the media uploader class
	Anva_Options_Media_Uploader::instance();

}

/**
 * Gets option name.
 *
 * @since 1.0.0
 */
function anva_get_option_name() {

	$name = '';

	// Gets option name as defined in the theme
	if ( function_exists( 'anva_option_name' ) ) {
		$name = anva_option_name();
	}

	// Fallback
	if ( '' == $name ) {
		$name = get_option( 'stylesheet' );
		$name = preg_replace( "/\W/", "_", strtolower( $name ) );
	}

	return apply_filters( 'anva_option_name', $name );

}

/**
 * Allows for manipulating or setting options via 'anva_options' filter.
 *
 * @since  1.0.0
 * @return array $options
 */
function anva_get_options() {

	// Get options from api class Anva_Options_API
	$options = anva_get_formatted_options();

	// Allow setting/manipulating options via filters
	$options = apply_filters( 'anva_options', $options );

	return $options;
}

/**
 * Admin Assets.
 *
 * @global $pagenow
 *
 * @since  1.0.0
 */
function anva_admin_assets() {

	global $pagenow;

	// Assets for meta boxes
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
		wp_enqueue_style( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_CSS . 'meta-boxes.min.css', array(), ANVA_FRAMEWORK_VERSION );
		wp_enqueue_script( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_JS . 'meta-boxes.min.js', array( 'jquery' ), ANVA_FRAMEWORK_VERSION, false );
	}

	// Sweet Alert
	wp_enqueue_script( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.js', array( 'jquery' ), '1.1.3', false );
	wp_enqueue_style( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.css', array(), '1.1.3' );
	
	// Admin Global
	wp_enqueue_script( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_JS . 'admin-global.min.js', array( 'jquery', 'wp-color-picker' ), ANVA_FRAMEWORK_VERSION, false );
	wp_enqueue_style( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-global.min.css', array(), ANVA_FRAMEWORK_VERSION );
	wp_enqueue_style( 'anva_admin_responive', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-responsive.min.css', array(), ANVA_FRAMEWORK_VERSION );

}

/**
 * Remove trailing char.
 *
 * @since  1.0.0
 * @param  string $string
 * @param  string $char
 * @return string $string
 */
function anva_remove_trailing_char( $string, $char = ' ' ) {

	if ( ! $string ) {
		return NULL;
	}

	$offset = strlen( $string ) - 1;

	$trailing_char = strpos( $string, $char, $offset );
	if ( $trailing_char ) {
		$string = substr( $string, 0, -1 );
	}

	return $string;
}

/**
 * Get font stacks
 * 
 * @since  1.0.0
 * @return array $stacks
 */
function anva_get_font_stacks() {
	$stacks = array(
		'default'     => 'Arial, sans-serif', // Used to chain onto end of google font
		'arial'       => 'Arial, "Helvetica Neue", Helvetica, sans-serif',
		'baskerville' => 'Baskerville, "Baskerville Old Face", "Hoefler Text", Garamond, "Times New Roman", serif',
		'georgia'     => 'Georgia, Times, "Times New Roman", serif',
		'helvetica'   => '"Helvetica Neue", Helvetica, Arial, sans-serif',
		'lucida'      => '"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif',
		'palatino'    => 'Palatino, "Palatino Linotype", "Palatino LT STD", "Book Antiqua", Georgia, serif',
		'tahoma'      => 'Tahoma, Verdana, Segoe, sans-serif',
		'times'       => 'TimesNewRoman, "Times New Roman", Times, Baskerville, Georgia, serif',
		'trebuchet'   => '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif',
		'verdana'     => 'Verdana, Geneva, sans-serif',
		'google'      => 'Google Font'
	);
	return apply_filters( 'anva_font_stacks', $stacks );
}

/**
 * Get font face
 *
 * @since  1.0.0
 * @param  array $option
 * @return font face name
 */
function anva_get_font_face( $option ) {

	$stack = '';
	$stacks = anva_get_font_stacks();
	$face = 'helvetica'; // Default font face

	if ( isset( $option['face'] ) && $option['face'] == 'google'  ) {

		// Grab font face, making sure they didn't do the
		// super, sneaky trick of including font weight or type.
		$name = explode( ':', $option['google'] );

		// Check for accidental space at end
		$name = anva_remove_trailing_char( $name[0] );

		// Add the deafult font stack to the end of the google font.
		$stack = $name . ', ' . $stacks['default'];

	} elseif ( isset( $option['face'] ) && isset( $stacks[ $option['face'] ] ) ) {
		$stack = $stacks[ $option['face'] ];

 	} else {
		$stack = $stacks[ $face ];
 	}


	return apply_filters( 'anva_get_font_face', $stack, $option, $stacks );
}

/**
 * Get font size and set the default value.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $size
 */
function anva_get_font_size( $option ) {

	$size = '14px'; // Default font size

	if ( isset( $option['size'] ) ) {
		$size = $option['size'] . 'px';
	}

	return apply_filters( 'anva_get_font_size', $size, $option );
}

/**
 * Get font style and set the default value.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $style
 */
function anva_get_font_style( $option ) {

	$style = 'normal'; // Default font style

	if ( isset( $option['style'] ) && ( $option['style'] == 'italic' || $option['style'] == 'uppercase-italic' ) ) {
		$style = 'italic';
	}

	return apply_filters( 'anva_get_font_style', $style, $option );
}

/**
 * Get font weight and set the default value.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $weight
 */
function anva_get_font_weight( $option ) {

	$weight = 'normal';

	if ( ! empty( $option['weight'] ) ){
		$weight = $option['weight'];
	}

	if ( ! $weight ) {
		$weight = '400';
	}

	return apply_filters( 'anva_get_font_weight', $weight, $option );
}

/**
 * Get font text-transform.
 *
 * @since  1.0.0
 * @param  array  $option
 * @return string $transform
 */
function anva_get_text_transform( $option ) {

	$tranform = 'none';

	if ( ! empty( $option['style'] ) && in_array( $option['style'], array('uppercase', 'uppercase-italic') ) ) {
		$tranform = 'uppercase';
	}

	return apply_filters( 'anva_text_transform', $tranform, $option );
}

/**
 * Get background patterns url fron option value.
 *
 * @since  1.0.0
 * @param  string $option
 * @return string $output
 */
function anva_get_background_pattern( $option ) {
	$image = esc_url( get_template_directory_uri() . '/assets/images/patterns/' . $option . '.png' );
	return apply_filters( 'anva_background_pattern', $url );
}

/**
 * Include font from google. Accepts unlimited amount of font arguments.
 *
 * @since  1.0.0
 * @return void
 */
function anva_enqueue_google_fonts() {

	$input = func_get_args();
	$used = array();

	if ( ! empty( $input ) ) {

		// Before including files, determine if SSL is being
		// used because if we include an external file without https
		// on a secure server, they'll get an error.
		$protocol = is_ssl() ? 'https://' : 'http://';

		// Build fonts to include
		$fonts = array();

		foreach ( $input as $font ) {

			if ( $font['face'] == 'google' && ! empty( $font['google'] ) ) {

				$font = explode( ':', $font['google'] );
				$name = trim ( str_replace( ' ', '+', $font[0] ) );

				if ( ! isset( $fonts[ $name ] ) ) {
					$fonts[ $name ] = array(
						'style'		=> array(),
						'subset'	=> array()
					);
				}

				if ( isset( $font[1] ) ) {

					$parts = explode( '&', $font[1] );

					foreach ( $parts as $part ) {
						if ( strpos( $part, 'subset' ) === 0 ) {
							$part = str_replace( 'subset=', '', $part );
							$part = explode( ',', $part );
							$part = array_merge( $fonts[ $name ]['subset'], $part );
							$fonts[ $name ]['subset'] = array_unique( $part );
						} else {
							$part = explode( ',', $part );
							$part = array_merge( $fonts[ $name ]['style'], $part );
							$fonts[ $name ]['style'] = array_unique( $part );
						}
					}

				}

			}
		}

		// Include each font file from google
		foreach ( $fonts as $font => $atts ) {

			// Create handle
			$handle = strtolower( $font );
			$handle = str_replace( ' ', '-', $handle );

			if ( ! empty( $atts['style'] ) ) {
				$font .= sprintf( ':%s', implode( ',', $atts['style'] ) );
			}

			if ( ! empty( $atts['subset'] ) ) {
				$font .= sprintf( '&subset=%s', implode( ',', $atts['subset'] ) );
			}

			wp_enqueue_style( $handle, $protocol . 'fonts.googleapis.com/css?family=' . $font, array(), ANVA_FRAMEWORK_VERSION, 'all' );

		}

	}
}

/**
 * Get social media sources and their respective names.
 *
 * @since  1.0.0
 * @return array $profiles
 */
function anva_get_social_icons_profiles() {
	$profiles = array(
		'bitbucket'		=> 'Bitbucket',
		'codepen'		=> 'Codepen',
		'delicious' 	=> 'Delicious',
		'deviantart' 	=> 'DeviantArt',
		'digg' 			=> 'Digg',
		'dribbble' 		=> 'Dribbble',
		'email3' 		=> 'Email',
		'facebook' 		=> 'Facebook',
		'flickr' 		=> 'Flickr',
		'foursquare' 	=> 'Foursquare',
		'github' 		=> 'Github',
		'gplus' 		=> 'Google+',
		'instagram' 	=> 'Instagram',
		'linkedin' 		=> 'Linkedin',
		'paypal' 		=> 'Paypal',
		'pinterest' 	=> 'Pinterest',
		'reddit' 		=> 'Reddit',
		'skype'			=> 'Skype',
		'soundcloud' 	=> 'Soundcloud',
		'tumblr' 		=> 'Tumblr',
		'twitter' 		=> 'Twitter',
		'vimeo-square'	=> 'Vimeo',
		'yahoo' 		=> 'Yahoo',
		'youtube' 		=> 'YouTube',
		'call'			=> 'Call',
		'rss' 			=> 'RSS',
	);

	// Backwards compat filter
	return apply_filters( 'anva_social_icons_profiles', $profiles );
}

/**
 * Get capability for admin module.
 *
 * @since  1.0.0
 * @param  string $module
 * @return string $cap
 */
function anva_admin_module_cap( $module ) {

	// Setup default capabilities
	$module_caps = array(
		'builder' 	=> 'edit_theme_options', // Role: Administrator
		'options' 	=> 'edit_theme_options', // Role: Administrator
		'backup' 	=> 'manage_options', 	 // Role: Administrator
		'updates' 	=> 'manage_options', 	 // Role: Administrator
	);
	
	$module_caps = apply_filters( 'anva_admin_module_caps', $module_caps );

	// Setup capability
	$cap = '';
	if ( isset( $module_caps[ $module ] ) ) {
		$cap = $module_caps[ $module ];
	}

	return $cap;
}