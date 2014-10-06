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

	// Global content width
	if ( ! isset( $content_width ) )
		$content_width = 980;

	// Add theme-supported features
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'tm_setup' );