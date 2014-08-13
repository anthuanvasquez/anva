<?php

/**
 * Make theme available for translations
 * @since 1.0.0
 */
function tm_theme_texdomain() {
	load_theme_textdomain( TM_THEME_DOMAIN, get_template_directory() . '/languages' );
}

/*
 * Register menus.
 */
function tm_register_menus() {
	/* Register Menus */
	register_nav_menus( array(
		'primary' 	=> __( 'Men&acute; Primario', TM_THEME_DOMAIN ),
		'secondary' => __( 'Men&acute; Secundario', TM_THEME_DOMAIN ),
	) );
}

/*
 * Register widgets areas.
 */
function tm_register_sidebars() {

	register_sidebar(
		tm_get_widget_args( 'main-sidebar', 'main_sidebar_title', 'main_sidebar_desc' )
	);

	register_sidebar(
		tm_get_widget_args( 'home-sidebar', 'home_sidebar_title', 'home_sidebar_desc' )
	);

	register_sidebar(
		tm_get_widget_args( 'footer-sidebar', 'footer_sidebar_title', 'footer_sidebar_desc' )
	);

}

/*
 * Enqueue custom Javascript & Stylesheets using wp_enqueue_script() and wp_enqueue_style().
 */
function tm_load_scripts() {
	
	// Load Stylesheets
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/assets/css/lightbox.css' );
	wp_enqueue_style( 'screen', get_template_directory_uri() . '/assets/css/screen.css' );
	wp_enqueue_style( 'spritesheets', get_template_directory_uri() . '/assets/css/spritesheets.css', array( 'screen' ), false, 'all' );
	
	if ( 1 == tm_get_option( 'responsive' ) ) {
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/responsive.css', array( 'screen' ), false, 'all' );
	}
	
	// Load Scripts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.6.2.min.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'main', 'TM', tm_get_js_locals() );	

}

/*
 * Hide wordpress version number.
 */
function tm_kill_version() {
	return '';
}

/*
 * Limit Excerpt Length to 50 words.
 */
function tm_excerpt_length( $length ) {
	return 50;
}

/*
 * Add class to posts_link_next() and previous.
 * @since 1.3.1
 */
function tm_posts_link_attr() {
	return 'class="button button-link"';
}

function tm_post_link_attr( $output ) {
	$class = 'class="button button-link"';
	return str_replace('<a href=', '<a '. $class .' href=', $output);
}

/**
 * Add customs image sizes.
 * @since 1.4.2
 */
function tm_add_image_size() {
	add_image_size( 'thumbnail_blog_large', 620, 300, true );
	add_image_size( 'thumbnail_blog_medium', 300, 300, true );
	add_image_size( 'thumbnail_blog_small', 150, 150, true );
	add_image_size( 'thumbnail_slideshow', 980, 350, true );
}

/**
 * Change the default mail from.
 * @since 1.5.0
 */
function tm_wp_mail_from( $original_email_address ) {
	$email = get_option( 'admin_email' );
	return $email;
}
add_filter( 'wp_mail_from', 'tm_wp_mail_from' );

/**
 * Change the default from name.
 * @since 1.5.0
 */
function tm_wp_mail_from_name( $original_email_from ) {
	$name = get_bloginfo( 'name' );
	return $name;
}
add_filter( 'wp_mail_from_name', 'tm_wp_mail_from_name' );

/**
 * Change the default from name.
 * @since 1.5.1
 */
function tm_search_filter( $query ) {

	$post_types = array(
		'post',
		'page'
	);

	if ( ! $query->is_admin && $query->is_search ) {
		$query->set( 'post_type', apply_filters( 'tm_search_filter_post_types', $post_types );
	}
	
	return $query;
}
add_filter( 'pre_get_posts', 'tm_search_filter' );