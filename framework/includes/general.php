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
function anva_load_theme_texdomain() {
	load_theme_textdomain( anva_textdomain(), get_template_directory() . '/languages' );
}

/**
 * Add theme support features
 */
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
				'name' => __( 'Right', anva_textdomain() ),
				'description' => __( 'Sidebar right.', anva_textdomain() ),
			)
		),
		'sidebar_left' => array(
			'args' => array(
				'id' => 'sidebar_left',
				'name' => __( 'Left', anva_textdomain() ),
				'description' => __( 'Sidebar left.', anva_textdomain() ),
			)
		),
		'above_header' => array(
			'args' => array(
				'id' => 'above_header',
				'name' => __( 'Above Header', anva_textdomain() ),
				'description' => __( 'Sidebar above header.', anva_textdomain() ),
			)
		),
		'above_content' => array(
			'args' => array(
				'id' => 'above_content',
				'name' => __( 'Above Content', anva_textdomain() ),
				'description' => __( 'Sidebar above content.', anva_textdomain() ),
			)
		),
		'below_content' => array(
			'args' => array(
				'id' => 'below_content',
				'name' => __( 'Below Content', anva_textdomain() ),
				'description' => __( 'Sidebar below content.', anva_textdomain() ),
			)
		),
		'below_footer' => array(
			'args' => array(
				'id' => 'below_footer',
				'name' => __( 'Below Footer', anva_textdomain() ),
				'description' => __( 'Sidebar below footer.', anva_textdomain() ),
			)
		),
		'footer' => array(
			'args' => array(
				'id' => 'footer',
				'name' => __( 'Footer', anva_textdomain() ),
				'description' => __( 'Footer sidebar.', anva_textdomain() ),
				'class' => 'grid_' . $cols,
			)
		),
	);
	
	return apply_filters( 'anva_get_sidebar_locations', $locations );
}

/**
 * Register widgets areas.
 */
function anva_register_sidebar_locations() {

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

function anva_add_sidebar_location( $locations ) {
	return $locations;
}

function anva_filter_sidebar_locations( $locations ) {
	
}

/**
 * Remove sidebar locations from framework and wordpress
 */
function anva_remove_sidebar_location( $locations ) {
	// $locations = anva_get_sidebar_locations();
	// if ( isset( $locations[$id] ) ) {
	// 	unregister_sidebar( $id );
	// 	//unset( $locations[$id] );
	// 	//var_dump($locations);
	// }
	return $locations;
}

/*
 * Args in registers widget function
 */
function anva_get_sidebar_args( $id, $name, $description, $classes ) {	
	$args = array(
		'id'            => $id,
		'name'          => $name,
		'description'		=> $description,
		'before_widget' => '<aside id="%1$s" class="widget %2$s '. $classes .'"><div class="widget-inner clearfix">',
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
		'animate' => array(
			'handle' => 'animate',
			'src' => get_template_directory_uri() . '/assets/css/animate.min.css',
			'dep' => array(),
			'ver' => '',
			'media' => 'all',
			'type' => 'css',
			'cond' => true
		),
		'font-awesome' => array(
			'handle' => 'font-awesome',
			'src' => get_template_directory_uri() . '/assets/css/font-awesome.min.css',
			'dep' => array(),
			'ver' => '4.3.0',
			'media' => 'all',
			'type' => 'css',
			'cond' => true
		),
		'magnific-popup' => array(
			'handle' => 'magnific-popup',
			'src' => get_template_directory_uri() . '/assets/css/magnific-popup.min.css',
			'dep' => array(),
			'ver' => '',
			'media' => 'all',
			'type' => 'css',
			'cond' => true
		),
		'boostrap' => array(
			'handle' => 'boostrap',
			'src' => get_template_directory_uri() . '/assets/css/bootstrap.min.css',
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
			'src' => get_template_directory_uri() . '/assets/css/responsive.css',
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
			'src' => get_template_directory_uri() . '/assets/js/vendor/jquery.validate.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '1.12.0',
			'in_footer' => true,
			'type' => 'js',
			'cond' => ( is_page_template( 'template_contact-us.php' ) ? true : false )
		),
		'isotope' => array(
			'handle' => 'isotope',
			'src' => get_template_directory_uri() . '/assets/js/vendor/isotope.min.js',
			'dep' => array( 'jquery' ),
			'ver' => '2.2.0',
			'in_footer' => true,
			'type' => 'js',
			'cond' => true
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
 * Include post types in search page
 */
function anva_exclude_search_post_types( $query ) {

	$post_types = array();

	if ( ! $query->is_admin && $query->is_search ) {
		$query->set( 'post_type', apply_filters( 'anva_exclude_search_post_types', $post_types ) );
	}
	
	return $query;
}

function anva_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$html  = '';
	$html .= '<p class="lead">' . __( "To view this protected post, enter the password below:", 'anva' ) . '</p>';
	$html .= '<form class="form-inline" role="form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
	$html .= '<div class="form-group">';
	$html .= '<input class="form-control" name="post_password" id="' . $label . '" type="password" maxlength="20" />';
	$html .= '<input type="submit" class="btn btn-default" name="Submit" value="' . esc_attr__( "Submit" ) . '" />';
	$html .= '</div>';
	$html .= '</form>';
	return $html;
}