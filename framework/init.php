<?php

/**
 * Get any current theme settings
 * @since 1.3.1
 */
$theme_settings = get_option( 'tm_theme_settings' );

define( 'TM_THEME_PATH', get_template_directory() );
define( 'TM_THEME_FRAMEWORK', get_template_directory() . '/framework' );
define( 'TM_THEME_URL', get_template_directory_uri() );
define( 'TM_THEME_LOGO', get_template_directory_uri() . '/assets/images/logo.png' );
define( 'TM_THEME_DOMAIN', 'tm' );
define( 'TM_THEME_SETTINGS', serialize( $theme_settings ) );

// Inlclude files
include_once( TM_THEME_FRAMEWORK . '/includes/actions.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/display.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/meta.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/helpers.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/media.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/locals.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/parts.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/general.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/widgets.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/shortcodes.php' );
include_once( TM_THEME_FRAMEWORK . '/includes/login.php' );
include_once( TM_THEME_FRAMEWORK . '/plugins/contact-email.php' );
include_once( TM_THEME_FRAMEWORK . '/plugins/slideshows.php' );

// Validate if Woocommerce plugin is activated
if ( class_exists( 'Woocommerce' ) ) :
	include_once( TM_THEME_FRAMEWORK . '/plugins/woocommerce-config.php' );
endif;

// Validate if Foodlist plugin is activated
if ( defined( 'FOODLIST_VERSION' )) {
	include_once( TM_THEME_FRAMEWORK . '/plugins/foodlist.php' );
}

/**
 * Theme Settings Admin
 * @since 1.3.1
 */
if ( is_admin() ) {
	include_once( get_template_directory() . '/framework/admin/settings.php' );
}

// Initial actions
add_action( 'init', 'tm_register_menus' );
add_action( 'tm_texdomain', 'tm_theme_texdomain' );
add_action( 'wp', 'tm_setup_author' );
add_action( 'wp_enqueue_scripts', 'tm_load_scripts' );
add_action( 'widgets_init', 'tm_register_sidebars' );
add_action( 'widgets_init', 'tm_register_widgets' );	
add_action( 'admin_bar_menu', 'tm_settings_menu_link', 1000 );
add_action( 'init', 'tm_add_image_size' );
add_filter( 'next_posts_link_attributes', 'tm_posts_link_attr' );
add_filter( 'previous_posts_link_attributes', 'tm_posts_link_attr' );
add_filter( 'next_post_link', 'tm_post_link_attr' );
add_filter( 'previous_post_link', 'tm_post_link_attr' );
add_filter( 'the_generator', 'tm_kill_version' );
add_filter( 'wp_page_menu_args', 'tm_page_menu_args' );
add_filter( 'body_class', 'tm_body_classes' );
add_filter( 'body_class', 'tm_browser_class' );
add_filter( 'wp_title', 'tm_wp_title', 10, 2 );
add_filter( 'wp_mail_from', 'tm_wp_mail_from' );
add_filter( 'wp_mail_from_name', 'tm_wp_mail_from_name' );
add_filter( 'pre_get_posts', 'tm_search_filter' );

// Hook hooks
add_action( 'add_meta_boxes', 'tm_add_page_options' );
add_action( 'save_post', 'tm_page_options_save_meta', 1, 2 );
add_action( 'wp_head', 'tm_apple_touch_icon' );
add_action( 'wp_head', 'tm_custom_css' );
add_action( 'wp_head', 'tm_navigation' );
add_action( 'tm_header_addon', 'tm_social_icons' );
add_action( 'tm_header_addon', 'tm_site_search' );
add_action( 'tm_header_logo', 'tm_header_logo_default' );
add_action( 'tm_footer_text', 'tm_footer_text_default' );
add_action( 'tm_layout_before', 'tm_layout_before_default' );
add_action( 'tm_layout_after', 'tm_layout_after_default' );
add_action( 'tm_layout_before', 'tm_ie_browser_message' );
add_action( 'tm_layout_after', 'tm_debug_queries' );
add_action( 'tm_content_before', 'tm_breadcrumbs' );
add_action( 'tm_content_before', 'tm_content_before_default' );
add_action( 'tm_content_after', 'tm_content_after_default' );
add_action( 'tm_sidebar_layout_before', 'tm_sidebar_layout_before_default' );
add_action( 'tm_sidebar_layout_after', 'tm_sidebar_layout_after_default' );

// Plugin Hooks
add_action( 'init', 'tm_contact_send_email' );
add_action( 'after_setup_theme', 'tm_slideshows_setup' );

/**
 * Hook textdomain
 * @since 1.4.0
 */
do_action( 'tm_texdomain' );