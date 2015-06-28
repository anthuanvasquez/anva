<?php

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
 * Load theme scripts
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

/*
 * Grid columns
 */
function anva_grid_columns() {
	$columns = array(
		'grid_1' => array(
			'name' => '1 Column',
			'class' => 'col-sm-12',
			'column'	=> 1,
		),
		'grid_2' => array(
			'name' => '2 Columns',
			'class' => 'col-sm-6',
			'column'	=> 2,
		),
		'grid_3' => array(
			'name' => '3 Columns',
			'class' => 'col-sm-4',
			'column' => 3
		),
		'grid_4' => array(
			'name' => '4 Columns',
			'class' => 'col-sm-3',
			'column' => 4
		),
		'grid_5' => array(
			'name' => '5 Columns',
			'class' => 'col-sm-5th', // Extend Boostrap Columns
			'column' => 5
		),
		'grid_6' => array(
			'name' => '6 Columns',
			'class' => 'col-sm-6', // Extend Boostrap Columns
			'column' => 6
		),
	);
	return apply_filters( 'anva_grid_columns', $columns );
}

/*
 * Sidebar layouts
 */
function anva_sidebar_layouts() {
	$layouts = array(
		'fullwidth' 	=> array(
			'name' 			=> 'Full Width',
			'id'				=> 'fullwidth',
			'columns'		=> array(
				'content' => 'col-sm-12',
				'left' 		=> '',
				'right' 	=> ''
			)
		),
		'right' 			=> array(
			'name' 			=> 'Sidebar Right',
			'id'				=> 'sidebar_right',
			'columns'		=> array(
				'content' => 'col-sm-9',
				'left' 		=> '',
				'right' 	=> 'col-sm-3'
			)
		),
		'left' 				=> array(
			'name' 			=> 'Sidebar Left',
			'id'				=> 'sidebar_left',
			'columns'		=> array(
				'content' => 'col-sm-9',
				'left' 		=> 'col-sm-3',
				'right' 	=> ''
			)
		),
		'double' 			=> array(
			'name' 			=> 'Double Sidebar',
			'id'				=> 'double',
			'columns'		=> array(
				'content' => 'col-sm-6',
				'left' 		=> 'col-sm-3',
				'right' 	=> 'col-sm-3'
			)
		),
		'double_left' => array(
			'name' 			=> 'Double Left Sidebars',
			'id'				=> 'double_left',
			'columns'		=> array(
				'content' => 'col-sm-6',
				'left' 		=> 'col-sm-3',
				'right' 	=> 'col-sm-3'
			)
		),
		'double_right'=> array(
			'name' 			=> 'Double Right Sidebars',
			'id'				=> 'double_right',
			'columns'		=> array(
				'content' => 'col-sm-6',
				'left' 		=> 'col-sm-3',
				'right' 	=> 'col-sm-3'
			)
		)
	);
	return apply_filters( 'anva_sidebar_layouts', $layouts );
}

/*
 * Get layout column classes
*/
function anva_get_column_class( $column ) {
	
	$column_class 	 = '';
	$sidebar_layouts = anva_sidebar_layouts();
	$current_layout  = anva_get_field( 'sidebar_layout' );

	// Set default sidebar layout
	if ( ! is_page() && ! is_single() || empty( $current_layout ) ) {
		$current_layout = 'right';
	}

	// Validate if field exists
	if ( isset( $sidebar_layouts[$current_layout]['columns'][$column] ) ) {
		$column_class = $sidebar_layouts[$current_layout]['columns'][$column];
	}

	return apply_filters( 'anva_column_class', $column_class );
}

/**
 * Setup the config array for which features the framework supports
 */
function anva_setup() {
	$setup = array(
		'featured' 			=> array(
			'archive'			=> false,
			'front'				=> true,
			'blog'				=> false,
			'grid'				=> false,
			'page'				=> false,
			'single'			=> false
		),
		'comments' 			=> array(
			'posts'				=> true,
			'pages'				=> false,
			'attachments'	=> false
		),
		'display' 			=> array(
			'responsive' 	=> true
		)
	);
	return apply_filters( 'anva_setup', $setup );
}

/**
 * Test whether an feature is currently supported
 */
function anva_supports( $group, $feature ) {

	$setup = anva_setup();
	$supports = false;

	if ( ! empty( $setup ) && ! empty( $setup[$group][$feature] ) ) {
		$supports = true;
	}

	return $supports;
}

/*
 * Return meta field outside loop
 */
function anva_get_field( $field ) {

	// Get post ID
	global $wp_query;

	$id 		 = $wp_query->post->ID;
	$prefix  = '_';
	$field   = get_post_meta( $id, $prefix . $field, true );

	if ( empty( $field )) {
		$field = '';
	}
	
	return $field;
}

/*
 * Return the post meta field 
 */
function anva_get_post_meta( $field ) {
	global $post;
	$field = get_post_meta( $post->ID, $field, true );
	return $field;
}

/*
 * Get custom meta fields
 */
function anva_get_post_custom() {
	global $post;
	$fields = get_post_custom( $post->ID );
	return $fields;
}

function anva_get_admin_modules() {

	// Options page
	//$options_admin = new Options_Framework_Admin;
	$//args = $options_admin->menu_settings();
	//$options_page = sprintf( 'themes.php?page=%s', $args['menu_slug'] );
	$options_page = 'themes.php?page=anva_theme';

	// Admin modules
	$modules = array(
		'options'	=> $options_page,
		'backup'	=> $options_page .'-backup'
	);

	var_dump($args);

	return apply_filters( 'anva_admin_modules', $modules );
}

/**
 * Add items to admin menu bar
 */
function anva_admin_menu_bar() {

	global $wp_admin_bar;

	if ( is_admin() || ! method_exists( $wp_admin_bar, 'add_node' ) ) {
		return;
	}

	// Get all admin modules
	$modules = anva_get_admin_modules();

	if ( ! $modules ) {
		return;
	}

	// Theme Options
	if ( isset( $modules['options'] ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'			=> 'anva_theme_options',
				'parent' 	=> 'site-name',
				'title'		=> __( 'Theme Options', 'anva' ),
				'href'		=> admin_url( $modules['options'] )
			)
		);
	}

	// // Theme Backup
	if ( isset( $modules['backup'] ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'		 => 'anva_theme_backup',
				'parent' 	=> 'site-name',
				'title'	 => __( 'Theme Backup', 'anva' ),
				'href'	 => admin_url( $modules['backup'] )
			)
		);
	}
}