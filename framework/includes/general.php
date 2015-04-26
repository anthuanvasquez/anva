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

function anva_add_theme_support() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
}

/**
 * Register menus.
 */
function anva_register_menus() {
	register_nav_menus( array(
		'primary' 	=> anva_get_local( 'menu_primary' ),
		'secondary' => anva_get_local( 'menu_secondary' )
	));
}

/**
 * Sidebar locations
 */
function anva_get_sidebar_locations() {
	$cols = anva_get_option( 'footer_cols', '4' );
	$locations = array(
		'sidebar_right' => array(
			'args' => array(
				'id' => 'sidebar_right',
				'name' => __( 'Sidebar Right', ANVA_DOMAIN ),
				'description' => __( 'Sidebar right.', ANVA_DOMAIN ),
			)
		),
		'sidebar_left' => array(
			'args' => array(
				'id' => 'sidebar_left',
				'name' => __( 'Sidebar Left', ANVA_DOMAIN ),
				'description' => __( 'Sidebar left.', ANVA_DOMAIN ),
			)
		),
		'homepage' => array(
			'args' => array(
				'id' => 'homepage',
				'name' => __( 'Homepage', ANVA_DOMAIN ),
				'description' => __( 'Homepage sidebar below content.', ANVA_DOMAIN ),
				'class' => 'grid_4',
			)
		),
		'footer' => array(
			'args' => array(
				'id' => 'footer',
				'name' => __( 'Footer', ANVA_DOMAIN ),
				'description' => __( 'Footer sidebar.', ANVA_DOMAIN ),
				'class' => 'grid_' . $cols,
			)
		),
	);

	return apply_filters( 'anva_get_sidebar_locations', $locations );
}

/**
 * Register widgets areas.
 */
function anva_register_sidebars() {

	$locations = anva_get_sidebar_locations();

	foreach ( $locations as $sidebar ) {
		if ( is_array( $sidebar ) && isset( $sidebar['args'] ) ) {
			register_sidebar(
				anva_get_sidebar_args(
					$sidebar['args']['id'],
					$sidebar['args']['name'],
					$sidebar['args']['description'],
					( isset( $sidebar['args']['class'] ) ? $sidebar['args']['class'] : '' )
				)
			);
		}
	}
}

/*
 * Args in registers widget function
 */
function anva_get_sidebar_args( $id, $name, $description, $classes ) {	
	$args = array(
		'id'            => $id,
		'name'          => $name,
		'description'		=> $description,
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$classes.'"><div class="widget-inner">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	return apply_filters( 'anva_get_sidebar_args', $args );
}

/**
 * Enqueue custom Javascript & Stylesheets using wp_enqueue_script() and wp_enqueue_style().
 */
function anva_load_scripts() {
	
	// Stylesheets
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'boostrap', get_template_directory_uri() . '/assets/css/bootstrap.css' );
	wp_enqueue_style( 'screen', get_template_directory_uri() . '/assets/css/screen.css' );
	
	if ( 1 == anva_get_option( 'responsive' ) ) {
		wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/css/screen-responsive.css', array( 'screen' ), false, 'all' );
	}
	
	// Scripts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_page_template( 'template_contact-us.php' ) ) {
		wp_enqueue_script( 'validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array( 'jquery' ), '', true );
	}

	wp_enqueue_script( 'boostrap-js', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery', 'plugins' ), '', true );
	wp_localize_script( 'main', 'ANVAJS', anva_get_js_locals() );

}

/**
 * Hide wordpress version number.
 */
function anva_kill_version() {
	return '';
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