<?php

/**
 * Get any current theme settings
 * @since 1.3.1
 */
$theme_settings = get_option( 'tm_theme_settings' );

define( 'TM_THEME_PATH', get_template_directory() );
define( 'TM_THEME_URL', get_template_directory_uri() );
define( 'TM_THEME_LOGO', get_template_directory_uri() . '/assets/images/logo.png' );
define( 'TM_THEME_DOMAIN', 'tm' );
define( 'TM_THEME_SETTINGS', serialize( $theme_settings ) );

// Inlclude files
include_once( get_template_directory() . '/framework/includes/actions.php' );
include_once( get_template_directory() . '/framework/includes/display.php' );
include_once( get_template_directory() . '/framework/includes/helpers.php' );
include_once( get_template_directory() . '/framework/includes/locals.php' );
include_once( get_template_directory() . '/framework/includes/parts.php' );
include_once( get_template_directory() . '/framework/includes/general.php' );
include_once( get_template_directory() . '/framework/includes/widgets.php' );
include_once( get_template_directory() . '/framework/includes/shortcodes.php' );
include_once( get_template_directory() . '/framework/includes/login.php' );
include_once( get_template_directory() . '/framework/plugins/flexslider.php' );
include_once( get_template_directory() . '/framework/plugins/woocommerce-config.php' );

/**
 * Theme Settings Admin
 * @since 1.3.1
 */
if ( is_admin() ) {
	include_once( get_template_directory() . '/framework/admin/settings.php' );
}

// Initial hooks
add_action( 'wp_head', 'tm_apple_touch_icon' );
add_action( 'wp_head', 'tm_custom_css' );
add_action( 'wp_head', 'tm_navigation' );
add_action( 'tm_layout_before', 'tm_ie_browser_message' );
add_action( 'tm_header_addon', 'tm_site_search' );
add_action( 'tm_header_addon', 'tm_social_icons' );
add_action( 'tm_header_logo', 'tm_header_logo_default' );