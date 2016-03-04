<?php

// Add print styles in login head
if ( ! has_action( 'login_enqueue_scripts', 'wp_print_styles' ) )
	add_action( 'login_enqueue_scripts', 'wp_print_styles', 11 );

// Hooks
add_action( 'login_enqueue_scripts', 'anva_login_stylesheet' );
add_filter( 'login_headerurl', 'anva_login_logo_url' );
add_action( 'login_footer', 'anva_login_footer' );

/**
 * Custom login stylesheet.
 */
function anva_login_stylesheet() {
	wp_enqueue_style( 'anva-login', get_template_directory_uri() . '/assets/css/login.css', array(), '', 'all' );
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
	$login_copyright = anva_get_option( 'login_copyright' );
	printf( '<div class="login-footer">%s</div>', $login_copyright );
}