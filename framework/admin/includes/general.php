<?php

/**
 * Init admin modules.
 *
 * @since 1.0.0
 * @return void
 */
function anva_admin_init() {

	// Instantiate the options page
	$options_page = new Anva_Options_Page;
	$options_page->init();
	
	// Instantiate the options backup
	$options_backup = new Anva_Options_Backup();
	$options_backup->init();

	// Instantiate the media uploader class
	$options_media_uploader = new Anva_Options_Media_Uploader;
	$options_media_uploader->init();

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
		$size = $option['size'];
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

	if ( isset( $option['style'] ) && ( $option['style'] == 'italic' || $option['style'] == 'bold-italic' ) ) {
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

	if ( isset( $option['style'] ) ) {
		
		if ( $option['style'] == 'bold' || $option['style'] == 'bold-italic' ) {
			$weight = 'bold';
		}

		if ( is_numeric( $option['style'] ) ) {
			$weight = intval( $option['style'] );
		}

	}

	return apply_filters( 'anva_get_font_weight', $weight, $option );
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