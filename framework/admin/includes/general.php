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