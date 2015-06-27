<?php

/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

// anva_add_sidebar_location( 'test', 'Testing' );
// anva_remove_sidebar_location( 'below_content' );

// anva_add_widget( 'Anva_Contact_AS' );;
// anva_remove_widget( 'Anva_Social_Icons' );

/**
 * Add theme support features
 */
// function anva_theme_setup() {
// 	add_theme_support( 'woocommerce' );
// }
// add_action( 'after_setup_theme', 'anva_theme_setup' );

/**
 * Change the slider args
 */
// function anva_theme_featured_size( $args ) {
// 	if ( isset( $args['homepage'] ) ) {
// 		$args['homepage']['size'] = 'slider_fullwidth';
// 	}
//  if ( ! isset( $args['homepage'] ) ) {
// 		$args['homepage']['orderby'] = 'date';
//  }
// 	return $args;
// }
// add_filter( 'anva_slideshows', 'anva_theme_featured_size' );

/**
 * Change the start year in footer.
 */
// function anva_theme_start_year() {
// 	return 2015;
// }
// add_filter( 'anva_footer_year', 'anva_theme_start_year' );

/**
 * Change footer credits.
 */
// function anva_theme_footer_credits() {
// 	return __( 'Development by', 'anva' );
// }
// add_filter( 'anva_footer_credits', 'anva_theme_footer_credits' );

/**
 * Change footer author.
 */
// function anva_theme_footer_author() {
// 	return  '<a href="'. esc_url( anva_get_theme( 'author_uri' ) ) .'">'. anva_get_theme( 'author' ) .'</a>.';
// }
// add_filter( 'anva_footer_author', 'anva_theme_footer_author' );