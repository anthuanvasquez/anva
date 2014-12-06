<?php

/*
 * Get theme single option or all options.
 */
function anva_get_option( $id, $default = false ) {
	$settings = unserialize( ANVA_SETTINGS );
	$option = '';
	if ( ! empty( $id ) ) {
		if ( isset( $settings[$id] ) )
			$option = $settings[$id];
	} else {
		$option = $default;
	}
	return $option; 
}

/**
 * Make theme available for translations
 */
function anva_theme_texdomain() {
	load_theme_textdomain( ANVA_DOMAIN, get_template_directory() . '/languages' );
}

/**
 * Register menus.
 */
function anva_register_menus() {
	/* Register Menus */
	register_nav_menus( array(
		'primary' 	=> anva_get_local( 'menu_primary' ),
		'secondary' => anva_get_local( 'menu_secondary' )
	) );
}

/**
 * Register widgets areas.
 */
function anva_register_sidebars() {

	register_sidebar(
		anva_get_widget_args( 'sidebar-right', 'sidebar_right_title', 'sidebar_right_desc' )
	);

	register_sidebar(
		anva_get_widget_args( 'sidebar-left', 'sidebar_left_title', 'sidebar_left_desc' )
	);

	register_sidebar(
		anva_get_widget_args( 'home-sidebar', 'home_sidebar_title', 'home_sidebar_desc' )
	);

	register_sidebar(
		anva_get_widget_args( 'footer-sidebar', 'footer_sidebar_title', 'footer_sidebar_desc' )
	);

}

/**
 * Enqueue custom Javascript & Stylesheets using wp_enqueue_script() and wp_enqueue_style().
 */
function anva_load_scripts() {
	
	// Load Stylesheets
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'boostrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'screen', get_template_directory_uri() . '/assets/css/screen.css' );
	
	if ( 1 == anva_get_option( 'responsive' ) ) {
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array( 'screen' ), false, 'all' );
	}
	
	// Load Scripts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'boostrap-js', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'main', 'anva_FRAMEWORK', anva_get_js_locals() );

}

/**
 * Hide wordpress version number.
 */
function anva_kill_version() {
	return '';
}

/**
 * Add class to posts_link_next() and previous.
 */
function anva_posts_link_attr() {
	return 'class="button button-link"';
}

function anva_post_link_attr( $output ) {
	$class = 'class="button button-link"';
	return str_replace('<a href=', '<a '. $class .' href=', $output);
}

/**
 * Change the default mail from.
 */
function anva_wp_mail_from( $original_email_address ) {
	$email = get_option( 'admin_email' );
	return $email;
}

/**
 * Change the default from name.
 */
function anva_wp_mail_from_name( $original_email_from ) {
	$name = get_bloginfo( 'name' );
	return $name;
}

/**
 * Include post types in search page
 */
function anva_search_filter( $query ) {

	$post_types = array(
		'post',
		'page'
	);

	if ( ! class_exists( 'Woocommerce' ) ) {
		if ( ! $query->is_admin && $query->is_search ) {
			$query->set( 'post_type', apply_filters( 'anva_search_filter_post_types', $post_types ) );
		}
	}
	
	return $query;
}

/**
 * Compress a chunk of code to output.
 *
 * @param string $buffer Text to compress
 * @return array $buffer Compressed text
 */
function anva_compress( $buffer ) {

	// Remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

	return $buffer;
}