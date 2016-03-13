<?php

/*
 * Don't load if optionsframework_init is already defined
 */
if ( ! function_exists( 'optionsframework_init' ) ) :

function optionsframework_init() {

	// Loads the required Options Framework classes.
	include_once( ANVA_FRAMEWORK_ADMIN . 'options/class-options-framework.php' );
	include_once( ANVA_FRAMEWORK_ADMIN . 'options/class-options-framework-admin.php' );
	include_once( ANVA_FRAMEWORK_ADMIN . 'options/class-options-interface.php' );
	include_once( ANVA_FRAMEWORK_ADMIN . 'options/class-options-media-uploader.php' );
	include_once( ANVA_FRAMEWORK_ADMIN . 'options/class-options-framework-backup.php' );
	include_once( ANVA_FRAMEWORK_ADMIN . 'options/sanitization.php' );

	// Instantiate the options page
	$options_framework_admin = new Options_Framework_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new Options_Framework_Media_Uploader;
	$options_framework_media_uploader->init();

	// Instantiate the options backup
	$options_framework_backup = new Options_Framework_Backup();
	$options_framework_backup->init();

}

add_action( 'init', 'optionsframework_init', 1 );

endif;