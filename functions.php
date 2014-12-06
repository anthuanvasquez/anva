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
function anva_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'anva_setup' );

/**
 * Change slider featured image size
 * @see anva_get_image_sizes()
 */
// function anva_featured_size( $args ) {
// 	if ( isset( $args['homepage'] ) ) {
// 		$args['homepage']['size'] = 'slider_big';
// 	}
// 	return $args;
// }
// add_filter( 'anva_slideshows', 'anva_featured_size' );

/**
 * Change the start year in footer.
 */
// function anva_start_year() {
// 	return 2014;
// }
// add_filter( 'anva_footer_year', 'start_year' );

/**
 * Change footer credits.
 */
// function anva_theme_footer_credits() {
// 	return __( 'Diseno por', 'anva' );
// }
// add_filter( 'anva_footer_credits', 'anva_theme_footer_credits' );

/**
 * Change footer author.
 */
// function anva_theme_footer_author() {
// 	return  '<a href="'. esc_url( 'http://your-url.com/') .'">Your name</a>.';
// }
// add_filter( 'anva_footer_author', 'anva_theme_footer_author' );