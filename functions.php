<?php

/**
 * Load framework
 * @since 1.5.0
 */
include_once( get_template_directory() . '/framework/init.php' );

/**
 * Hook textdomain
 * @since 1.4.0
 */
do_action( 'tm_texdomain' );

/**
 * Setup theme functions. After theme setup hooks and filters.
 * @since 1.3.1
 */
function tm_setup() {

	global $content_width;

	if ( !isset( $content_width ) )
		$content_width = 620;

	// Add theme-supported features
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
	add_theme_support( 'woocommerce' ); // include Woocommerce Support

	// Hook actions
	add_action( 'init', 'tm_register_menus' );
	add_action( 'tm_texdomain', 'tm_theme_texdomain' );
	add_action( 'wp', 'tm_setup_author' );
	add_action( 'wp_enqueue_scripts', 'tm_load_scripts' );
	add_action( 'widgets_init', 'tm_register_sidebars' );
	add_action( 'widgets_init', 'tm_register_widgets' );	
	add_action( 'admin_bar_menu', 'tm_settings_menu_link', 1000 );
	add_action( 'init', 'tm_add_image_size' );
	
	// Hooks filters
	add_filter( 'next_posts_link_attributes', 'tm_posts_link_attr' );
	add_filter( 'previous_posts_link_attributes', 'tm_posts_link_attr' );
	add_filter( 'next_post_link', 'tm_post_link_attr' );
	add_filter( 'previous_post_link', 'tm_post_link_attr' );
	add_filter( 'the_generator', 'tm_kill_version' );
	add_filter( 'excerpt_length', 'tm_excerpt_length', 999 );
	add_filter( 'wp_page_menu_args', 'tm_page_menu_args' );
	add_filter( 'body_class', 'tm_body_classes' );
	add_filter( 'body_class', 'tm_browser_class' );
	add_filter( 'wp_title', 'tm_wp_title', 10, 2 );
	add_filter( 'wp_mail_from', 'tm_wp_mail_from' );
	add_filter( 'wp_mail_from_name', 'tm_wp_mail_from_name' );
	add_filter( 'pre_get_posts', 'tm_search_filter' )

}
add_action( 'after_setup_theme', 'tm_setup' );