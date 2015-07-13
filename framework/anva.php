<?php

if ( ! class_exists( 'Anva' ) ) :

class Anva {
	
	/*
	 * A single instance of this class.
	 */
	private static $instance = null;

	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/*
	 * Constructor. Hook everything in.
	 */
	private function __construct() {
		add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'includes' ), 2 );
		add_action( 'after_setup_theme', array( $this, 'functions' ), 3 );
		add_action( 'after_setup_theme', array( $this, 'init' ), 4 );
	}

	/*
	 * Constants.
	 */
	public function constants() {

		// Define constants
		define( 'ANVA_PATH', get_template_directory() );
		define( 'ANVA_URL', get_template_directory_uri() );
		define( 'ANVA_FRAMEWORK', get_template_directory() . '/framework' );
		define( 'ANVA_FRAMEWORK_URL', get_template_directory_uri() . '/framework' );
		define( 'ANVA_FRAMEWORK_NAME', 'Anva Framework' );
		define( 'ANVA_FRAMEWORK_VERSION', '1.0.0' );
		define( 'ANVA_FRAMEWORK_DOMAIN', 'anva' );

	}

	/*
	 * Includes and Hooks
	 */
	public function includes() {

		// Vendor files
		include_once ( ANVA_FRAMEWORK . '/vendor/cssmin.php' );
		include_once ( ANVA_FRAMEWORK . '/vendor/jsmin.php' );

		// Include files
		include_once ( ANVA_FRAMEWORK . '/admin/options-framework.php' );
		include_once ( ANVA_FRAMEWORK . '/admin/includes/metaboxes.php' );
		include_once ( ANVA_FRAMEWORK . '/admin/includes/general.php' );
		include_once ( ANVA_FRAMEWORK . '/admin/includes/display.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/api/stylesheets.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/api/scripts.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/api/sidebars.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/api/widgets.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/api/api.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/actions.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/display.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/helpers.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/media.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/locals.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/parts.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/general.php' );
		include_once ( ANVA_FRAMEWORK . '/includes/shortcodes.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/email.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/login.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/slideshows.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/gallery.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/woocommerce.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/foodlist.php' );
		include_once ( ANVA_FRAMEWORK . '/plugins/megamenu.php' );

		/* ---------------------------------------------------------------- */
		/* Admin / Options
		/* ---------------------------------------------------------------- */

		add_action( 'optionsframework_custom_scripts', 'anva_admin_head_scripts' );
		add_action( 'optionsframework_after', 'anva_admin_footer_after' );
		add_action( 'optionsframework_after', 'anva_admin_header_before' );

		/* ---------------------------------------------------------------- */
		/* Init
		/* ---------------------------------------------------------------- */

		add_action( 'init', 'anva_register_menus' );
		add_action( 'wp', 'anva_setup_author' );
		add_action( 'wp_before_admin_bar_render', 'anva_admin_menu_bar', 100 );
		add_action( 'after_setup_theme', 'anva_add_image_sizes' );
		add_action( 'image_size_names_choose', 'anva_image_size_names_choose' );
		add_action( 'after_setup_theme', 'anva_add_theme_support' );
		add_action( 'add_meta_boxes', 'anva_add_page_options' );
		add_action( 'save_post', 'anva_page_options_save_meta', 1, 2 );
		add_action( 'wp_head', 'anva_head_apple_touch_icon' );
		add_action( 'wp_head', 'anva_head_viewport', 8 );
		add_action( 'after_setup_theme', 'anva_register_footer_sidebar_locations' );
		add_filter( 'wp_page_menu_args', 'anva_page_menu_args' );
		add_filter( 'body_class', 'anva_body_class' );
		add_filter( 'body_class', 'anva_browser_class' );
		add_filter( 'wp_title', 'anva_wp_title', 10, 2 );
		add_filter( 'comment_reply_link', 'anva_comment_reply_link_class' );
		add_filter( 'the_password_form', 'anva_the_password_form' );
		add_filter( 'anva_get_js_locals', 'anva_get_media_queries' );
		add_action( 'anva_init', 'anva_api_init' );
		add_action( 'anva_textdomain', 'anva_load_theme_texdomain' );

		/* ---------------------------------------------------------------- */
		/* Header
		/* ---------------------------------------------------------------- */

		add_action( 'anva_top_before', 'anva_side_menu' );
		add_action( 'anva_header_above', 'anva_top_bar_default' );
		add_action( 'anva_header_above', 'anva_sidebar_above_header' );
		add_action( 'anva_header_extras', 'anva_header_extras_default' );
		add_action( 'anva_header_logo', 'anva_header_logo_default' );
		add_action( 'anva_header_primary_menu', 'anva_header_primary_menu_default' );
		add_action( 'anva_header_primary_menu_addon', 'anva_header_primary_menu_addon_default' );

		/* ---------------------------------------------------------------- */
		/* Footer
		/* ---------------------------------------------------------------- */

		add_action( 'anva_footer_content', 'anva_footer_content_default' );
		add_action( 'anva_footer_copyrights', 'anva_footer_copyrights_default' );
		add_action( 'anva_footer_below', 'anva_sidebar_below_footer' );
		
		/* ---------------------------------------------------------------- */
		/* Featured
		/* ---------------------------------------------------------------- */

		add_action( 'anva_featured_before', 'anva_featured_before_default' );
		add_action( 'anva_featured_after', 'anva_featured_after_default' );
		add_action( 'anva_featured', 'anva_featured_default' );

		/* ---------------------------------------------------------------- */
		/* Content
		/* ---------------------------------------------------------------- */
		
		add_action( 'anva_breadcrumbs', 'anva_breadcrumbs_default' );
		add_action( 'anva_above_layout', 'anva_sidebar_above_content' );
		add_action( 'anva_above_layout', 'anva_above_layout_default' );
		add_action( 'anva_below_layout', 'anva_below_layout_default' );
		add_action( 'anva_below_layout', 'anva_sidebar_below_content' );
		add_action( 'anva_posts_meta', 'anva_posts_meta_default' );
		add_action( 'anva_posts_content', 'anva_posts_content_default' );
		add_action( 'anva_posts_comments', 'anva_posts_comments_default' );

		/* ---------------------------------------------------------------- */
		/* Sidebars
		/* ---------------------------------------------------------------- */

		add_action( 'anva_fixed_sidebar_before', 'anva_fixed_sidebar_before_default' );
		add_action( 'anva_fixed_sidebar_after', 'anva_fixed_sidebar_after_default' );
		add_action( 'anva_sidebars', 'anva_fixed_sidebars' );

		/* ---------------------------------------------------------------- */
		/* Layout
		/* ---------------------------------------------------------------- */

		add_action( 'anva_after', 'anva_debug_info' );
		
		/* ---------------------------------------------------------------- */
		/* Plugins
		/* ---------------------------------------------------------------- */

		add_filter( 'the_content', 'anva_fix_shortcodes' );
		add_filter( 'after_setup_theme', 'anva_shortcodes_init' );
		add_action( 'init', 'anva_contact_send_email' );
		add_action( 'after_setup_theme', 'anva_slideshows_setup' );

	}

	/*
	 * Theme Functions
	 */
	public function functions() {
		include_once( ANVA_PATH . '/functions/theme-functions.php' );
	}

	/*
	 * Textdomain
	 */
	public function init() {
		do_action( 'anva_textdomain' );
		do_action( 'anva_init' );
	}

}
endif;

/*
 * Init framework
 */
function Anva_Framework() {
	return Anva::instance();
}

// Here We Go!
Anva_Framework();