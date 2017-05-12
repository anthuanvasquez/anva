<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Anva is a WordPress Theme Framework.
 *
 * Anva class launches the framework. It's the organizational structure behind the
 * entire framework. This class should be loaded and initialized before anything else within
 * the theme is called to properly use the framework.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */
class Anva {
	/**
	 * Framework's Name.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public static $name = 'Anva Framework';

	/**
	 * Framework's Version.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public static $version = '1.0.0';

	/**
	 * The framework directory path.
	 *
	 * @since  1.0.0
	 * @var    string
	 */
	public static $framework_dir_path = '';

	/**
	 * The framework directory uri.
	 *
	 * @since  1.0.0
	 * @var    string
	 */
	public static $framework_dir_uri = '';

	/**
	 * Cloning is forbidden.
	 *
	 * @since  1.0.0
	 * @return void Throw error on object clone.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheating Huh?', 'anva' ), self::$version );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since  1.0.0
	 * @return error Throw error on object unserializing.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheating Huh?', 'anva' ), self::$version );
	}

	/**
	 * Constructor hook everything in.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Set up an empty object to work with.
		$GLOBALS['anva'] = new stdClass;

		// Set framework paths
		self::$framework_dir_path = trailingslashit( get_template_directory() . '/framework' );
		self::$framework_dir_uri  = trailingslashit( get_template_directory_uri() . '/framework' );

		// Setup framework constants
		$this->set_constants();

		// Setup framework files
		$this->set_core_files();

		// Setup hooks and filters
		$this->set_core_hooks();
	}

	/**
	 * Defines the constant paths for use within the
	 * core framework, parent theme, and child theme.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function set_constants() {
		define( 'ANVA_FRAMEWORK_NAME', self::$name );
		define( 'ANVA_FRAMEWORK_VERSION', self::get_theme_version() );
		define( 'ANVA_FRAMEWORK_DIR', self::$framework_dir_path );
		define( 'ANVA_FRAMEWORK_URI', self::$framework_dir_uri );
		define( 'ANVA_FRAMEWORK_INC', trailingslashit( self::$framework_dir_path . 'includes' ) );
		define( 'ANVA_FRAMEWORK_CSS', trailingslashit( self::$framework_dir_uri . 'assets/css' ) );
		define( 'ANVA_FRAMEWORK_JS', trailingslashit( self::$framework_dir_uri . 'assets/js' ) );
		define( 'ANVA_FRAMEWORK_IMG', trailingslashit( self::$framework_dir_uri . 'assets/images' ) );
		define( 'ANVA_FRAMEWORK_ADMIN', trailingslashit( self::$framework_dir_path . 'admin' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_URI', trailingslashit( self::$framework_dir_uri . 'admin' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_CSS', trailingslashit( self::$framework_dir_uri . 'admin/assets/css' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_JS', trailingslashit( self::$framework_dir_uri . 'admin/assets/js' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_IMG', trailingslashit( self::$framework_dir_uri . 'admin/assets/images' ) );
		define( 'ANVA_FRAMEWORK_ADMIN_PLUGINS', trailingslashit( self::$framework_dir_uri . 'admin/assets/plugins' ) );
	}

	/**
	 * Include core framerwork files.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function set_core_files() {

		// Admin
		if ( is_admin() ) {

			include_once( self::$framework_dir_path . 'admin/options/class-anva-options-page.php' );
			include_once( self::$framework_dir_path . 'admin/options/class-anva-options-import-export.php' );
			include_once( self::$framework_dir_path . 'admin/options/class-anva-options-media-uploader.php' );
			include_once( self::$framework_dir_path . 'admin/options/anva-options-type.php' );
			include_once( self::$framework_dir_path . 'admin/options/anva-options-fields.php' );
			include_once( self::$framework_dir_path . 'admin/options/anva-options-sanitization.php' );
			include_once( self::$framework_dir_path . 'admin/class-anva-page-builder.php' );
			include_once( self::$framework_dir_path . 'admin/class-anva-page-gallery.php' );
			include_once( self::$framework_dir_path . 'admin/class-anva-page-meta-box.php' );
			include_once( self::$framework_dir_path . 'admin/class-anva-welcome-screen.php' );
			include_once( self::$framework_dir_path . 'admin/includes/general.php' );
			include_once( self::$framework_dir_path . 'admin/includes/display.php' );
			include_once( self::$framework_dir_path . 'admin/includes/meta.php' );
			include_once( self::$framework_dir_path . 'admin/includes/locals.php' );
			include_once( self::$framework_dir_path . 'admin/plugins/anva-tgm.php' );
			include_once( self::$framework_dir_path . 'admin/updates/anva-updates.php' );

		} else {

			include_once( self::$framework_dir_path . 'admin/options/anva-options-sanitization.php' );
			include_once( self::$framework_dir_path . 'admin/includes/general.php' );

		}

		// API and Helpers
		include_once( self::$framework_dir_path . 'class-anva-options.php' );
		include_once( self::$framework_dir_path . 'class-anva-sidebars.php' );
		include_once( self::$framework_dir_path . 'class-anva-styles.php' );
		include_once( self::$framework_dir_path . 'class-anva-scripts.php' );
		include_once( self::$framework_dir_path . 'class-anva-sliders.php' );
		include_once( self::$framework_dir_path . 'class-anva-builder-options.php' );
		include_once( self::$framework_dir_path . 'anva-helpers.php' );

		// General
		include_once( self::$framework_dir_path . 'includes/general.php' );
		include_once( self::$framework_dir_path . 'includes/display.php' );
		include_once( self::$framework_dir_path . 'includes/post-formats.php' );
		include_once( self::$framework_dir_path . 'includes/media.php' );
		include_once( self::$framework_dir_path . 'includes/content.php' );
		include_once( self::$framework_dir_path . 'includes/parts.php' );
		include_once( self::$framework_dir_path . 'includes/elements.php' );
		include_once( self::$framework_dir_path . 'includes/helpers.php' );
		include_once( self::$framework_dir_path . 'includes/locals.php' );

		// Customizer
		include_once( self::$framework_dir_path . 'customizer/customizer.php' );
	}

	/**
	 * Initialize core framework hooks.
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function set_core_hooks() {

		// Admin Filters and Actions
		if ( is_admin() ) {
			add_action( 'after_setup_theme', 'anva_plugins' );
			add_action( 'after_setup_theme', 'anva_envato_updates' );
			add_action( 'init', 'anva_admin_init', 1 );
			add_action( 'admin_init', 'anva_add_meta_boxes_default' );
			add_action( 'admin_init', 'anva_add_sanitization' );
			add_action( 'admin_enqueue_scripts', 'anva_admin_assets', 20 );
			add_action( 'admin_notices', 'anva_admin_theme_activate' );
			add_action( 'anva_options_page_top', 'anva_admin_check_settings' );
			add_action( 'anva_options_page_after_fields', 'anva_admin_footer_credits' );
			add_action( 'anva_options_page_after_fields', 'anva_admin_footer_links' );
			add_action( 'anva_options_page_before', 'anva_add_settings_change', 10 );
		}

		if ( ! is_admin() ) {
			add_action( 'anva_post_meta', 'anva_post_meta_default' );
			add_action( 'anva_post_content', 'anva_post_content_default' );
			add_action( 'anva_post_comments', 'anva_post_comments_default' );
			add_action( 'anva_post_footer', 'anva_post_tags_default' );
			add_action( 'anva_post_footer', 'anva_post_share_default' );
			add_action( 'anva_post_single_below', 'anva_post_nav_default' );
			add_action( 'anva_post_single_below', 'anva_post_author_default' );
			add_action( 'anva_post_single_below', 'anva_post_related_default' );
		}

		// Init Filters
		add_filter( 'body_class', 'anva_body_class' );
		add_filter( 'body_class', 'anva_browser_class' );
		add_filter( 'oembed_result', 'anva_oembed', 10, 2 );
		add_filter( 'embed_oembed_html', 'anva_oembed', 10, 2 );
		add_filter( 'wp_audio_shortcode', 'anva_audio_shortcode' );
		add_filter( 'the_content', 'anva_content_format_gallery', 7 );
		add_filter( 'the_content', 'anva_content_format_audio', 7 );
		add_filter( 'the_content', 'anva_content_format_video', 7 );
		add_filter( 'the_content', 'anva_content_format_quote', 7 );
		add_filter( 'the_content', 'anva_content_format_link', 7 );
		add_filter( 'the_password_form', 'anva_password_form' );
		add_filter( 'image_size_names_choose', 'anva_image_size_names_choose' );
		add_filter( 'nav_menu_css_class', 'anva_nav_menu_css_class', 10, 4 );
		add_filter( 'wp_page_menu_args', 'anva_page_menu_args' );
		add_filter( 'wp_link_pages_args', 'anva_link_pages_args' );
		add_filter( 'wp_link_pages_link', 'anva_link_pages_link', 10, 2 );

		// Init Actions
		add_action( 'after_setup_theme', 'anva_content_width', 0 );
		add_action( 'after_setup_theme', 'anva_add_image_sizes' );
		add_action( 'after_setup_theme', 'anva_add_theme_support', 10 );
		add_action( 'after_setup_theme', 'anva_add_elements', 10 );
		add_action( 'after_setup_theme', 'anva_require_theme_supports', 12 );
		add_action( 'after_setup_theme', 'anva_register_footer_sidebar_locations' );
		add_action( 'after_setup_theme', 'anva_load_theme_texdomain' );
		add_action( 'init', 'anva_register_menus' );
		add_action( 'init', 'anva_contact_send_email' );
		add_action( 'wp_loaded', 'anva_customizer_preview' );
		add_action( 'wp', 'anva_setup_author' );
		add_filter( 'wp_head', 'anva_wp_title_compat', 5 );
		add_action( 'wp_head', 'anva_head_apple_touch_icon' );
		add_action( 'wp_head', 'anva_head_viewport', 1 );
		add_action( 'wp_before_admin_bar_render', 'anva_admin_menu_bar', 100 );
		add_action( 'customize_register', 'anva_customizer_init' );
		add_action( 'customize_register', 'anva_customizer_register_blog' );
		add_action( 'customize_controls_print_styles', 'anva_customizer_styles' );
		add_action( 'customize_controls_enqueue_scripts', 'anva_customizer_scripts' );
		add_action( 'customize_preview_init', 'anva_customize_preview_enqueue_scripts' );

		// Framework Filters and Actions
		add_filter( 'anva_get_js_locals', 'anva_get_media_queries' );
		add_action( 'anva_api', 'anva_api_init' );
		add_action( 'anva_header_above', 'anva_top_bar_default' );
		add_action( 'anva_header_above', 'anva_sidebar_above_header' );
		add_action( 'anva_header', 'anva_header_default' );
		add_action( 'anva_header_extras', 'anva_header_extras_default' );
		add_action( 'anva_header_logo', 'anva_header_logo_default' );
		add_action( 'anva_header_primary_menu', 'anva_header_primary_menu_default' );
		add_action( 'anva_header_primary_menu_addon', 'anva_header_primary_menu_addon_default' );
		add_action( 'anva_footer_content', 'anva_footer_content_default' );
		add_action( 'anva_footer_copyrights', 'anva_footer_copyrights_default' );
		add_action( 'anva_footer_below', 'anva_sidebar_below_footer' );
		add_action( 'anva_featured_before', 'anva_featured_before_default' );
		add_action( 'anva_featured_after', 'anva_featured_after_default' );
		add_action( 'anva_featured', 'anva_featured_default' );
		add_action( 'anva_content_before', 'anva_page_title_default' );
		add_action( 'anva_breadcrumbs', 'anva_breadcrumbs_default' );
		add_action( 'anva_content_after', 'anva_post_reading_bar', 20 );
		add_action( 'anva_above_layout', 'anva_sidebar_above_content' );
		add_action( 'anva_above_layout', 'anva_above_layout_default' );
		add_action( 'anva_below_layout', 'anva_below_layout_default' );
		add_action( 'anva_below_layout', 'anva_sidebar_below_content' );
		add_action( 'anva_sidebar_before', 'anva_sidebar_before_default' );
		add_action( 'anva_sidebar_after', 'anva_sidebar_after_default' );
		add_action( 'anva_sidebars', 'anva_sidebars_default' );
		add_action( 'anva_before', 'anva_side_panel_default' );
		add_action( 'anva_after', 'anva_debug' );
		add_action( 'anva_content_builder', 'anva_display_elements' );
		add_action( 'anva_contact_form', 'anva_contact_form_default' );
		add_action( 'anva_post_type_navigation', 'anva_post_type_navigation_default' );
		add_action( 'anva_slider_standard', 'anva_slider_standard_default', 9, 2 );
		add_action( 'anva_slider_owl', 'anva_slider_owl_default', 9, 2 );
		add_action( 'anva_slider_nivo', 'anva_slider_nivo_default', 9, 2 );
		add_action( 'anva_slider_bootstrap', 'anva_slider_bootstrap_default', 9, 2 );
		add_action( 'anva_slider_swiper', 'anva_slider_swiper_default', 9, 2 );
		add_action( 'anva_slider_camera', 'anva_slider_camera_default', 9, 2 );

		// Initialize API
		do_action( 'anva_api_before' );
		do_action( 'anva_api' );
	}

	/**
	 * Gets the theme version.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_theme_version() {
		return self::$version;
	}

	/**
	 * Gets the normalized theme version.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_normalized_theme_version() {
		$theme_version       = self::$version;
		$theme_version_array = explode( '.', $theme_version );

		if ( isset( $theme_version_array[2] ) && '0' === $theme_version_array[2] ) {
			$theme_version = $theme_version_array[0] . '.' . $theme_version_array[1];
		}

		return $theme_version;
	}
}
