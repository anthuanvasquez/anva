<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Anva' ) ) :

/**
 * Anva Initialize Framework
 * 
 * @since  1.0.0
 * @author Anthuan Vasquez <eigthy@gmail.com>
 */
class Anva {

	/**
	 * Framework name
	 *
	 * @since 1.0.0
	 */
	const NAME = 'Anva Framework';

	/**
	 * Framework version
	 *
	 * @since 1.0.0
	 */
	const VERSION = '1.0.0';
	
	/**
	 * A single instance of this class
	 * 
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 * Hook everything in.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		// Setup framework constants
		$this->set_constants();

		// Setup framework files
		$this->set_files();

		// Setup hooks and filters
		$this->set_hooks();

		// Setup api init
		$this->set_api();

		// Setup theme functions
		$this->set_theme_functions();

	}

	/**
	 * Define constants
	 *
	 * @since 1.0.0
	 */
	public function set_constants() {

		define( 'ANVA_FRAMEWORK_NAME', self::NAME );
		define( 'ANVA_FRAMEWORK_VERSION', self::VERSION );
		define( 'ANVA_FRAMEWORK_DIR', get_template_directory() . '/framework' );
		define( 'ANVA_FRAMEWORK_URI', get_template_directory_uri() . '/framework' );
		
	}

	public function set_files() {

		/* ---------------------------------------------------------------- */
		/* Vendor
		/* ---------------------------------------------------------------- */

		if ( ! is_admin() ) {
			include_once ( ANVA_FRAMEWORK_DIR . '/vendor/cssmin.php' );
			include_once ( ANVA_FRAMEWORK_DIR . '/vendor/jsmin.php' );
		}

		/* ---------------------------------------------------------------- */
		/* Admin
		/* ---------------------------------------------------------------- */

		// Options Framework
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/options/options-framework.php' );
		
		// General
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/class-anva-builder-meta-box.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/class-anva-gallery-meta-box.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/class-anva-meta-box.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/fields.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/general.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/display.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/admin/includes/locals.php' );

		/* ---------------------------------------------------------------- */
		/* API - Back End / Front End
		/* ---------------------------------------------------------------- */

		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/class-anva-options-api.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/class-anva-sidebars-api.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/class-anva-stylesheets-api.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/class-anva-scripts-api.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/class-anva-builder-elements-api.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/class-anva-sliders-api.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/api/helpers.php' );

		/* ---------------------------------------------------------------- */
		/* Front End
		/* ---------------------------------------------------------------- */

		// General
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/actions.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/display.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/helpers.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/media.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/locals.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/parts.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/general.php' );

		// Widgets
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/widgets/widgets.php' );

		// Shortcodes
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/shortcodes.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/includes/elements.php' );

		// Plugins
		include_once ( ANVA_FRAMEWORK_DIR . '/plugins/login.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/plugins/megamenu.php' );
		include_once ( ANVA_FRAMEWORK_DIR . '/plugins/woocommerce.php' );

	}

	/**
	 * Include files and initialize hooks
	 *
	 * @since 1.0.0
	 */
	public function set_hooks() {

		/* ---------------------------------------------------------------- */
		/* Admin / Options
		/* ---------------------------------------------------------------- */

		add_action( 'optionsframework_custom_scripts', 'anva_admin_head_scripts' );
		add_action( 'optionsframework_after', 'anva_admin_footer_credits' );
		add_action( 'optionsframework_after', 'anva_admin_footer_links' );
		add_action( 'optionsframework_importer_after', 'anva_admin_footer_credits' );
		add_action( 'optionsframework_importer_after', 'anva_admin_footer_links' );

		/* ---------------------------------------------------------------- */
		/* Init
		/* ---------------------------------------------------------------- */

		add_action( 'init', 'anva_register_menus' );
		add_action( 'init', 'anva_contact_send_email' );
		add_action( 'widgets_init','anva_register_widgets', 10, 2 );
		add_action( 'wp', 'anva_setup_author' );
		add_action( 'after_setup_theme', 'anva_add_image_sizes' );
		add_action( 'image_size_names_choose', 'anva_image_size_names_choose' );
		add_action( 'after_setup_theme', 'anva_add_theme_support' );
		add_action( 'wp_head', 'anva_head_apple_touch_icon' );
		add_action( 'wp_head', 'anva_head_viewport', 8 );
		add_filter( 'wp_title', 'anva_wp_title', 10, 2 );
		add_action( 'wp_footer', 'anva_footer_ghost', 1000 );
		add_action( 'after_setup_theme', 'anva_register_footer_sidebar_locations' );
		add_action( 'admin_init', 'anva_add_meta_boxes_default' );
		add_action( 'admin_init', 'anva_add_page_builder_meta_box' );
		add_filter( 'the_password_form', 'anva_password_form' );
		add_filter( 'wp_page_menu_args', 'anva_page_menu_args' );
		add_filter( 'body_class', 'anva_body_class' );
		add_filter( 'body_class', 'anva_browser_class' );
		add_filter( 'comment_reply_link', 'anva_comment_reply_link_class' );
		add_action( 'wp_before_admin_bar_render', 'anva_admin_menu_bar', 100 );
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
		add_action( 'anva_posts_footer', 'anva_post_tags' );
		add_action( 'anva_posts_footer', 'anva_post_share' );

		/* ---------------------------------------------------------------- */
		/* Sidebars
		/* ---------------------------------------------------------------- */

		add_action( 'anva_sidebar_before', 'anva_sidebar_before_default' );
		add_action( 'anva_sidebar_after', 'anva_sidebar_after_default' );
		add_action( 'anva_sidebars', 'anva_sidebars_default' );

		/* ---------------------------------------------------------------- */
		/* Layout
		/* ---------------------------------------------------------------- */

		add_action( 'anva_after', 'anva_debug' );
		
		/* ---------------------------------------------------------------- */
		/* Plugins
		/* ---------------------------------------------------------------- */

		add_filter( 'after_setup_theme', 'anva_shortcodes_init' );
		
		add_action( 'anva_slider_standard', 'anva_slider_standard_default', 9, 2 );
		add_action( 'anva_slider_owl', 'anva_slider_owl_default', 9, 2 );
		add_action( 'anva_slider_nivo', 'anva_slider_nivo_default', 9, 2 );
		add_action( 'anva_slider_bootstrap', 'anva_slider_bootstrap_default', 9, 2 );

		add_action( 'anva_slider_camera', 'anva_slider_camera_default', 9, 2 );

		// Textdomain
		do_action( 'anva_textdomain' );
	}

	/**
	 * Initialize Framework API
	 *
	 * @since 1.0.0
	 */
	public function set_api() {
		do_action( 'anva_before_init' );
		do_action( 'anva_init' );
		do_action( 'anva_after_init' );
	}

	/**
	 * Theme functions
	 *
	 * @since 1.0.0
	 */
	public function set_theme_functions() {
		include_once( get_template_directory() . '/includes/theme-functions.php' );
	}

}
endif; // End Class Anva

/**
 * Init Anva Framework
 *
 * @since 1.0.0
 */
function Anva_Framework() {
	return Anva::instance();
}


// Here We Go!
Anva_Framework();

Anva_Sliders_API::instance();
