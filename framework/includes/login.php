<?php

// Add print styles in login head
if ( ! has_action( 'login_enqueue_scripts', 'wp_print_styles' ) )
	add_action( 'login_enqueue_scripts', 'wp_print_styles', 11 );

// Hooks
add_action( 'login_footer', 'anva_login_footer' );
add_action( 'login_enqueue_scripts', 'anva_login_stylesheet' );
add_filter( 'login_headerurl', 'anva_login_logo_url' );

/**
 * Custom login stylesheet.
 */
function anva_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/login.css', array(), '', 'all' );
}

/**
 * Change the logo url.
 */
function anva_login_logo_url() {
	return home_url( '/' );
}

/**
 * Change the logo url title.
 */
function anva_login_logo_url_title() {
	return get_bloginfo( 'name' );
}

/**
 * Add custom text in login footer page.
 */
function anva_login_footer() {
	$url = 'http://anthuanvasquez.net/';
	$author = 'Anthuan Vasquez';	
	printf(
		'<div id="login-footer"><p id="login-credits">&copy %s <a href="%s">%s</a> %s.</p></div>',
		date('Y'),
		esc_url( $url ),
		esc_html( $author ),
		anva_get_local( 'footer_copyright' )
	);
}