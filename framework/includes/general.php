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

/*
 * Get theme info
 */
function anva_get_theme( $id ) {
	
	$text = null;
	$theme = wp_get_theme();

	$data = array(
		'name' => $theme->get( 'Name' ),
		'uri' => $theme->get( 'ThemeURI' ),
		'desc' => $theme->get( 'Description' ),
		'version' => $theme->get( 'Version' ),
		'domain' => $theme->get( 'TextDomain' ),
		'author' => $theme->get( 'Author' ),
		'author_uri' => $theme->get( 'AuthorURI' ),
		
	);

	if ( isset( $data[$id]) ) {
		$text = $data[$id];
	}

	return $text;
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

/*
 * Define theme scripts
 */
function anva_get_theme_scripts() {
	$scripts = array(
		'font-awesome' => array(
			'handle' => 'font-awesome',
			'src' => get_template_directory_uri() . '/assets/css/font-awesome.css',
			'dep' => array(),
			'ver' => '4.3.0',
			'media' => 'all',
			'type' => 'css',
			'cond' => true
		),
		'boostrap' => array(
			'handle' => 'boostrap',
			'src' => get_template_directory_uri() . '/assets/css/bootstrap.css',
			'dep' => array(),
			'ver' => '3.3.4',
			'media' => 'all',
			'type' => 'css',
			'cond' => true
		),
		'screen' => array(
			'handle' => 'screen',
			'src' => get_template_directory_uri() . '/assets/css/screen.css',
			'dep' => array(),
			'ver' => false,
			'media' => 'all',
			'type' => 'css',
			'cond' => true
		),
		'responsive' => array(
			'handle' => 'responsive',
			'src' => get_template_directory_uri() . '/assets/css/screen-responsive.css',
			'dep' => array( 'screen' ),
			'ver' => false,
			'media' => 'all',
			'type' => 'css',
			'cond' => ( 1 == anva_get_option( 'responsive' ) ? true : false ),
		),
		'bootstrap-js' => array(
			'handle' => 'boostrap-js',
			'src' => get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '3.3.4',
			'in_footer' => true,
			'type' => 'js',
			'cond' => true
		),
		'validate' => array(
			'handle' => 'jquery-validate',
			'src' => get_template_directory_uri() . '/assets/js/jquery.validate.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '1.12.0',
			'in_footer' => true,
			'type' => 'js',
			'cond' => ( is_page_template( 'template_contact-us.php' ) ? true : false )
		),
		'flexslider' => array(
			'handle' => 'jquery-flexslider',
			'src' => get_template_directory_uri() . '/assets/js/vendor/jquery.flexslider.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '2.2.2',
			'in_footer' => true,
			'type' => 'js',
			'cond' => true
		),
		'slick' => array(
			'handle' => 'slick-js',
			'src' => get_template_directory_uri() . '/assets/js/vendor/slick.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '1.5.0',
			'in_footer' => true,
			'type' => 'js',
			'cond' => true
		),
		'isotope' => array(
			'handle' => 'isotope',
			'src' => get_template_directory_uri() . '/assets/js/vendor/isotope.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '2.2.0',
			'in_footer' => true,
			'type' => 'js',
			'cond' => ( is_singular( 'galleries' ) ? true : false )
		),
		'masonry' => array(
			'handle' => 'masonry',
			'src' => get_template_directory_uri() . '/assets/js/vendor/masonry.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '3.3.0',
			'in_footer' => true,
			'type' => 'js',
			'cond' => false
		),
		'plugins' => array(
			'handle' => 'theme-plugins',
			'src' => get_template_directory_uri() . '/assets/js/plugins.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '',
			'in_footer' => true,
			'type' => 'js',
			'cond' => true
		),
		'main' => array(
			'handle' => 'theme-main',
			'src' => get_template_directory_uri() . '/assets/js/main.min.js',
			'dep' => array( 'jquery', 'theme-plugins' ),
			'ver' => '',
			'in_footer' => true,
			'type' => 'js',
			'cond' => true
		),
	);
	return apply_filters( 'anva_get_theme_scripts', $scripts );
}

/*
 * Register theme scripts
 */
function anva_register_scripts() {
	
	$scripts = anva_get_theme_scripts();
	
	foreach ( $scripts as $key => $value) {
		if ( 'js' == $value['type'] ) {
			wp_register_script( $value['handle'], $value['src'], $value['dep'], $value['ver'], $value['in_footer'] );
		} elseif ( 'css' == $value['type'] ) {
			wp_register_style( $value['handle'], $value['src'], $value['dep'], $value['ver'], $value['media'] );
		}
	}
}

/**
 * Load theme scripts.
 */
function anva_load_scripts() {
	
	$scripts = anva_get_theme_scripts();

	foreach ( $scripts as $key => $value) {
		if ( true == $value['cond'] ) {
			if ( 'js' == $value['type'] ) {
				wp_enqueue_script( $value['handle'] );
			} elseif ( 'css' == $value['type']  ) {
				wp_enqueue_style( $value['handle'] );
			}
		}
	}

	wp_localize_script( 'theme-main', 'ANVAJS', anva_get_js_locals() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

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