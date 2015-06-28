<?php

define( 'THEME_ID', 'theme' );
define( 'THEME_NAME', 'Theme' );
define( 'THEME_VERSION', '1.0.0');

/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

/* 
 * Change the options.php directory.
 */
function theme_options_location() {
	return  '/framework/admin/options.php';
}
add_filter( 'options_framework_location', 'theme_options_location' );

/*
 * This is an example of filtering menu parameters
 */
function theme_options_menu( $menu ) {
	$options_framework = new Options_Framework;
	$option_name = $options_framework->get_option_name();
	$menu['mode'] = 'menu';
	$menu['page_title'] = __( 'Theme Options', 'anva' );
	$menu['menu_title'] = __( 'Theme Options', 'anva' );
	$menu['menu_slug']  = $option_name;
	return $menu;
}
add_filter( 'optionsframework_menu', 'theme_options_menu' );

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

/**
 * Google fonts using by the theme
 */
function theme_google_fonts() {
	anva_enqueue_google_fonts(
		anva_get_option('body_font'),
		anva_get_option('heading_font')
	);
}

/*-----------------------------------------------------------------------------------*/
/* Hooks
/*-----------------------------------------------------------------------------------*/

add_action('wp_enqueue_scripts', 'theme_google_fonts');