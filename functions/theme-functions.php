<?php

/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Add theme support features
 */
function anva_theme_setup() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'anva_theme_setup' );

/*
 * Add additional sidebar locations
 */
// function anva_theme_sidebar_locations( $locations ) {
// 	$cols = anva_get_option( 'footer_cols', '4' );
// 	$sidebars = array(
// 		'sidebar_front' => array(
// 			'args' => array(
// 				'id' => 'sidebar_front',
// 				'name' => __( 'Sidebar Front', ANVA_DOMAIN ),
// 				'description' => __( 'Sidebar front.', ANVA_DOMAIN ),
// 			)
// 		),
// 	);
// 	return array_merge( $locations, $sidebars );
// }
// add_filter( 'anva_get_sidebar_locations', 'anva_theme_sidebar_locations' );

/**
 * Change the slider args
 */
// function anva_theme_featured_size( $args ) {
// 	if ( isset( $args['homepage'] ) ) {
// 		$args['homepage']['size'] = 'slider_big';
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
function anva_theme_start_year() {
	return 2015;
}
add_filter( 'anva_footer_year', 'anva_theme_start_year' );

/**
 * Change footer credits.
 */
function anva_theme_footer_credits() {
	return __( 'Development by', 'anva' );
}
add_filter( 'anva_footer_credits', 'anva_theme_footer_credits' );

/**
 * Change footer author.
 */
function anva_theme_footer_author() {
	return  '<a href="'. esc_url( 'http://anthuanvasquez.het/') .'">'. __( 'Anthuan Vasquez' ) .'</a>.';
}
add_filter( 'anva_footer_author', 'anva_theme_footer_author' );
add_filter( 'anva_login_author', 'anva_theme_footer_author' );