<?php


/**
 * Init admin modules.
 *
 * @since 1.0.0
 * @return void
 */
function anva_admin_init() {

	// Instantiate the options page.
	Anva_Options_Page::instance();

	// Instantiate the media uploader class.
	Anva_Options_Media_Uploader::instance();

	// Instantiate the import export options.
	Anva_Options_Import_Export::instance();

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
	if ( 'post-new.php' == $pagenow ||  'post.php' == $pagenow ) {
		wp_enqueue_style( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_CSS . 'page-meta.css', array(), ANVA_FRAMEWORK_VERSION );
		wp_enqueue_script( 'anva_meta_box', ANVA_FRAMEWORK_ADMIN_JS . 'page-meta.js', array( 'jquery' ), ANVA_FRAMEWORK_VERSION, false );
	}

	// Sweet Alert.
	wp_enqueue_script( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.js', array( 'jquery' ), '1.1.3', false );
	wp_enqueue_style( 'sweetalert', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'sweetalert.min.css', array(), '1.1.3' );

	// Admin Global.
	wp_enqueue_script( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_JS . 'admin.js', array( 'jquery', 'wp-color-picker' ), ANVA_FRAMEWORK_VERSION, false );
	wp_enqueue_style( 'anva_admin_global', ANVA_FRAMEWORK_ADMIN_CSS . 'admin.css', array(), ANVA_FRAMEWORK_VERSION );

}

/**
 * Get options page menu settings.
 *
 * @since  1.0.0
 * @return array $options_page
 */
function anva_get_options_page_menu() {
	$options_page = new Anva_Options_Page;
	return $options_page->menu_settings();
}

/**
 * Get default options.
 *
 * @since  1.0.0
 * @return array Default Options
 */
function anva_get_option_defaults() {
	$options_page = new Anva_Options_Page;
	return $options_page->get_default_values();
}

/**
 * Register a new meta box.
 *
 * @since  1.0.0
 */
function anva_add_meta_box( $id, $args, $options ) {
	new Anva_Page_Meta_Box( $id, $args, $options );
}
