<?php
/**
 * Admin general functions.
 *
 * @package AnvaFramework
 */

/**
 * Init admin modules.
 *
 * @since 1.0.0
 * @return void
 */
function anva_admin_init() {

	// Welcome screen.
	Anva_Page_Welcome::instance();

	// Instantiate the options page.
	Anva_Page_Options::instance();

	// Instantiate the media uploader class.
	Anva_Options_Media_Uploader::instance();

	// Instantiate shortcode generator.
	Anva_Shortcodes_Generator::instance();

}

/**
 * Initialize the Anva_Menu_Options instance.
 *
 * @since 1.0.0
 */
function anva_admin_menu_init() {
	Anva_Nav_Menu_Options::get_instance();
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

	// Assets for meta boxes.
	if ( 'post-new.php' === $pagenow ||  'post.php' === $pagenow ) {
		wp_enqueue_style( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_CSS . 'page-meta.css', array(), Anva::get_version() );
		wp_enqueue_script( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_JS . 'page-meta.js', array( 'jquery' ), Anva::get_version(), false );
	}

	// Sweet Alert.
	wp_enqueue_script( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.js', array( 'jquery' ), '1.1.3', false );
	wp_enqueue_style( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.css', array(), '1.1.3' );

	// Admin Global.
	wp_enqueue_script( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_JS . 'admin.js', array( 'jquery', 'wp-color-picker' ), Anva::get_version(), false );
	wp_enqueue_style( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_CSS . 'admin.css', array(), Anva::get_version() );

}
