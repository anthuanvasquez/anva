<?php

// Add print styles in login head
if ( ! has_action( 'login_enqueue_scripts', 'wp_print_styles' ) )
	add_action( 'login_enqueue_scripts', 'wp_print_styles', 11 );

// Hooks
add_action( 'login_footer', 'tm_login_footer' );
add_action( 'login_enqueue_scripts', 'tm_login_stylesheet' );
add_filter( 'login_headerurl', 'tm_login_logo_url' );

/**
 * Custom login stylesheet.
 *
 * @since 1.4.2
 */
function tm_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/login.css', array(), '', 'all' );
}

/**
 * Change the logo url.
 *
 * @since 1.4.2
 */
function tm_login_logo_url() {
	return get_bloginfo( 'url' );
}

/**
 * Change the logo url title.
 *
 * @since 1.4.2
 */
function tm_login_logo_url_title() {
	return get_bloginfo( 'name' );
}

/**
 * Add custom text in login footer page.
 *
 * @since 1.4.2
 */
function tm_login_footer() {
	$html ='';
	$link = 'http://3mentes.com/';
	$author = '3mentes';

	$html .= '<div id="login" style="padding:10px 0 0;">';
	$html .= '<p id="credit">Copyright &copy; '. date('Y') .' <a href="'. esc_url( $link ).'">'. $author .'</a>. '. esc_html__( 'Todos los Derechos Reservados.', 'tm' );
	$html .= '</p></div>';

	echo $html;
}