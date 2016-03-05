<?php
/**
 * Options Framework
 *
 * @package   Options Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

if ( ! function_exists( 'optionsframework_init' ) ) :
/*
 * Don't load if optionsframework_init is already defined
 */
function optionsframework_init() {

	//  If user can't edit theme options, exit
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Loads the required Options Framework classes.
	require anva_get_core_directory() . '/admin/options/class-options-framework.php';
	require anva_get_core_directory() . '/admin/options/class-options-framework-admin.php';
	require anva_get_core_directory() . '/admin/options/class-options-framework-importer.php';
	require anva_get_core_directory() . '/admin/options/class-options-interface.php';
	require anva_get_core_directory() . '/admin/options/class-options-media-uploader.php';
	require anva_get_core_directory() . '/admin/options/sanitization.php';

	// Instantiate the options page.
	$options_framework_admin = new Options_Framework_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new Options_Framework_Media_Uploader;
	$options_framework_media_uploader->init();

}

add_action( 'init', 'optionsframework_init', 1 );

endif;