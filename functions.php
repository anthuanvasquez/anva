<?php
/*-----------------------------------------------------------------------------------*/
/* Run Framework
/*
/* Below is the file needed to load the parent theme and theme framework.
/* It's included with require_once().
/*-----------------------------------------------------------------------------------*/

require_once( get_template_directory() . '/framework/init.php' );

/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Add theme support features
 */
function tm_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'tm_setup' );

/*
 * Change slider featured image size
 */
// function tm_featured_size( $args ) {
// 	if ( isset( $args['homepage'] ) ) {
// 		$args['homepage']['size'] = 'slider_big';
// 	}
// 	return $args;
// }
// add_filter( 'tm_slideshows', 'tm_featured_size' );

/*
 * Change the start year in footer.
 */
// function tm_start_year() {
// 	return 2008;
// }
// add_filter( 'tm_footer_year', 'start_year' );