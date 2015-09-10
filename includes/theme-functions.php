<?php

/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

// Define theme constants
define( 'ANVA_THEME_ID', 'eren' );
define( 'ANVA_THEME_NAME', 'Eren' );
define( 'ANVA_THEME_VERSION', '1.0.0');

// Recommend plugins
require_once( get_template_directory() . '/includes/install.php' );

// Modify framework's core options
require_once( get_template_directory() . '/includes/options.php' );

/**
 * Filtering theme options menu
 * 
 * @since 1.0.0
 */
function theme_options_menu( $menu ) {
	$option_name 				= anva_get_option_name();
	$menu['mode'] 			= 'menu';
	$menu['page_title'] = sprintf( '%1$s %2$s', ANVA_THEME_NAME, __( 'Options', 'anva' ) );
	$menu['menu_title'] = sprintf( '%1$s %2$s', ANVA_THEME_NAME, __( 'Options', 'anva' ) );
	$menu['menu_slug']  = $option_name;
	return $menu;
}

/**
 * Filtering theme backup menu
 * 
 * @since 1.0.0
 */
function theme_backup_menu( $menu ) {
	$menu['page_title'] = ANVA_THEME_NAME . ' ' . __( 'Backup', 'anva' );
	$menu['menu_title'] = ANVA_THEME_NAME . ' ' . __( 'Backup', 'anva' );
	return $menu;
}

/**
 * Change the slider args
 *
 * @since 1.0.0
 */
// function anva_theme_featured_size( $args ) {
// 	if ( isset( $args['main'] ) ) {
// 		$args['main']['size'] = 'slider_fullwidth';
// 	}
//  if ( ! isset( $args['main'] ) ) {
// 		$args['main']['orderby'] = 'date';
//  }
// 	return $args;
// }
// add_filter( 'anva_slideshows', 'anva_theme_featured_size' );

/**
 * Body Classes
 * 
 * @since 1.0.0
 */
function theme_body_classes( $classes ) {
	$classes[] = anva_get_option( 'layout_style' );
	$classes[] = 'base-color-'. anva_get_option( 'base_colors' );
	return $classes;
}

/**
 * Google fonts using by the theme
 * 
 * @since 1.0.0
 */
function theme_google_fonts() {
	anva_enqueue_google_fonts(
		anva_get_option( 'body_font' ),
		anva_get_option( 'heading_font' )
	);
}

/**
 * Custom Stylesheets
 * 
 * @since 1.0.0
 */
function theme_stylesheets() {

	// Get stylesheet API
	$api = Anva_Stylesheets_API::instance();

	// Register stylesheets
	$stylesheets = array();

	$stylesheets['theme_screen'] = array(
		'handle' => 'theme_screen',
		'src' => get_template_directory_uri() . '/assets/css/styles.css',
		'deps' => $api->get_framework_deps(),
		'ver' => ANVA_THEME_VERSION,
		'media' => 'all'
	);

	$stylesheets['theme_colors'] = array(
		'handle' => 'theme_colors',
		'src' => get_template_directory_uri() . '/assets/css/colors.css',
		'deps' => array( 'theme_screen' ),
		'ver' => ANVA_THEME_VERSION,
		'media' => 'all'
	);

	$stylesheets['theme_responsive'] = array(
		'handle' => 'theme_responsive',
		'src' => get_template_directory_uri() . '/assets/css/responsive.css',
		'deps' => array( 'theme_screen' ),
		'ver' => ANVA_THEME_VERSION,
		'media' => 'all'
	);

	$stylesheets['theme_ie'] = array(
		'handle' => 'theme_ie',
		'src' => get_template_directory_uri() . '/assets/css/ie.css',
		'deps' => array( 'theme_screen' ),
		'ver' => ANVA_THEME_VERSION,
		'media' => 'all'
	);

	// Register stylesheets for later use
	foreach ( $stylesheets as $key => $value ) {
		wp_register_style( $value['handle'], $value['src'], $value['deps'], $value['ver'], $value['media'] );
	}

	// Compress CSS
	if ( '1' != anva_get_option( 'compress_css' ) ) {
		
		// Enqueue theme stylesheets
		wp_enqueue_style( 'theme_screen' );
		wp_enqueue_style( 'theme_responsive' );
		wp_enqueue_style( 'theme_colors' );
		
		// IE
		$GLOBALS['wp_styles']->add_data( 'theme_ie', 'conditional', 'lt IE 9' );
		wp_enqueue_style( 'theme_ie' );

		// Inline theme styles
		wp_add_inline_style( 'theme_colors', theme_styles() );

	} else {
		
		// Ignore stylesheets in compressed file
		$ignore = array( 'theme_ie' => '' );

		// Compress CSS files
		anva_minify_stylesheets( $stylesheets, $ignore );
		
		// Add IE conditional
		wp_register_style( 'theme_xie', get_template_directory_uri() . '/assets/css/ie.css', array( 'all-in-one' ), THEME_VERSION, 'all' );
		$GLOBALS['wp_styles']->add_data( 'theme_xie', 'conditional', 'lt IE 9' );
		wp_enqueue_style( 'theme_xie' );
		
		// Inline theme styles
		wp_add_inline_style( 'all-in-one', theme_styles() );

	}
	
	// Level 3 
	$api->print_styles(3);

}

/**
 * Theme scripts
 * 
 * @since 1.0.0
 */
function theme_scripts() {

	// Get scripts API
	$api = Anva_Scripts_API::instance();

	wp_register_script( 'html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js', array(), '3.6.2' );
	wp_register_script( 'css3mediaqueriesjs', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js', array(), '3.6.2' );

	$GLOBALS['wp_scripts']->add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	$GLOBALS['wp_scripts']->add_data( 'css3mediaqueriesjs', 'conditional', 'lt IE 9' );

	// Enque Scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'html5shiv' );
	wp_enqueue_script( 'css3mediaqueriesjs' );
	wp_localize_script( 'anva', 'ANVAJS', anva_get_js_locals() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Level 3
	$api->print_scripts(3);
}

/**
 * Custom Styles
 * 
 * @since 1.0.0
 */
function theme_styles() {
	$styles 						= '';
	$custom_css 				= anva_get_option( 'custom_css' );
	$body_font 					= anva_get_option( 'body_font' );
	$heading_font 			= anva_get_option( 'heading_font' );
	$heading_h1 				= anva_get_option( 'heading_h1', '27' );
	$heading_h2 				= anva_get_option( 'heading_h2', '24' );
	$heading_h3 				= anva_get_option( 'heading_h3', '18' );
	$heading_h4 				= anva_get_option( 'heading_h4', '14' );
	$heading_h5 				= anva_get_option( 'heading_h5', '13' );
	$heading_h6 				= anva_get_option( 'heading_h6', '11' );
	$background_color 	= anva_get_option( 'background_color' );
	$background_pattern = anva_get_option( 'background_pattern' );
	ob_start();
	?>
	/* Typography */
	html,
	body {
		font-family: <?php echo anva_get_font_face( $body_font ); ?>;
		font-size: <?php echo anva_get_font_size( $body_font ); ?>;
		font-style: <?php echo anva_get_font_style( $body_font ); ?>;
		font-weight: <?php echo anva_get_font_weight( $body_font ); ?>;
	}
	h1, h2, h3, h4, h5, h6, .slide-title, .entry-title h1, .entry-title h2 {
		font-family: <?php echo anva_get_font_face( $heading_font ); ?>;
		font-style: <?php echo anva_get_font_style( $heading_font ); ?>;
		font-weight: <?php echo anva_get_font_weight( $heading_font ); ?>;
	}
	h1 {
		font-size: <?php echo $heading_h1; ?>;
	}
	h2 {
		font-size: <?php echo $heading_h2; ?>;
	}
	h3 {
		font-size: <?php echo $heading_h3; ?>;
	}
	h4 {
		font-size: <?php echo $heading_h4; ?>;
	}
	h5 {
		font-size: <?php echo $heading_h5; ?>;
	}
	h6 {
		font-size: <?php echo $heading_h6; ?>;
	}
	/* Background */
	body {
		background: <?php echo esc_html( $background_color ); ?>;
		<?php if ( '' == $background_pattern ) : ?>
		background-image: none;
		<?php else : ?>
		background-image: url(<?php echo anva_get_background_pattern( $background_pattern ); ?>);
		background-repeat: repeat;
		<?php endif; ?>
	}
	<?php
	$styles = ob_get_clean();

	// Add custom CSS
	if ( $custom_css ) {
		$styles .= "\n/* Custom CSS */\n";
		$styles .= $custom_css;
	}

	// Compress Output
	return anva_compress( $styles );
}

/**
 * Remove Scripts
 * 
 * @since 1.0.0
 */
function theme_remove_scripts() {
	$slider = anva_get_option( 'slider_id' );
	// Camera
	if ( 'camera' != $slider ) {
	 	anva_remove_stylesheet( 'camera' );
		anva_remove_script( 'camera' );
	}
	// Swiper
	if ( 'swiper' != $slider ) {
	 	anva_remove_stylesheet( 'swiper' );
		anva_remove_script( 'swiper' );
	}
}

/**
 * Remove grid columns that are not needed
 * 
 * @since 1.0.0
 */
function theme_remove_grid_columns( $columns ) {
	global $pagenow;
	// Admin Pages
	if ( ( $pagenow == 'post.php' ) && ( isset( $_GET['post_type'] ) ) && ( $_GET['post_type'] == 'page' ) ) {
		unset( $columns[1] );
		unset( $columns[5] );
		unset( $columns[6] );
	}
	// Admin Nav Menu
	if ( ( $pagenow == 'nav-menus.php' ) ) {
		unset( $columns[6] );
	}
	return $columns;
}

/*-----------------------------------------------------------------------------------*/
/* Hooks
/*-----------------------------------------------------------------------------------*/

add_filter( 'optionsframework_menu', 'theme_options_menu' );
add_filter( 'optionsframework_backup_menu', 'theme_backup_menu' );
add_filter( 'anva_grid_columns', 'theme_remove_grid_columns' );
add_filter( 'body_class', 'theme_body_classes' );
add_action( 'wp_enqueue_scripts', 'theme_google_fonts' );
add_action( 'wp_enqueue_scripts', 'theme_stylesheets' );
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
add_action( 'wp_enqueue_scripts', 'theme_styles', 20 );
add_action( 'after_setup_theme', 'theme_remove_scripts', 11 );

//$terms = get_terms( 'gallery_cat', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order' );
	function aregister() {

		$labels = array(
			'name' 								 => __( 'Galleries', 'anva' ),
			'singular_name' 			 => __( 'Gallery', 'anva' ),
			'all_items' 					 => __( 'All Galleries', 'anva' ),
			'add_new' 						 => __( 'Add New Gallery', 'anva' ),
			'add_new_item' 				 => __( 'Add New Gallery', 'anva' ),
			'edit_item' 					 => __( 'Edit Gallery', 'anva' ),
			'new_item' 						 => __( 'New Gallery', 'anva' ),
			'view_item' 					 => __( 'View Gallery', 'anva' ),
			'search_items' 				 => __( 'Search Galleries', 'anva' ),
			'not_found' 					 => __( 'No Gallery found', 'anva' ),
			'not_found_in_trash' 	 => __( 'No Gallery found in Trash', 'anva' )
		);
		
		$args = array(
			'labels'               => $labels,
			'public'               => true,
			'publicly_queryable'   => true,
			'_builtin'             => false,
			'show_ui'              => true, 
			'query_var'            => true,
			'rewrite'              => true,
			'capability_type'      => 'post',
			'hierarchical'         => false,
			'menu_position'        => 26.6,
			'menu_icon'						 => 'dashicons-format-gallery',
			'supports'             => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'           => array( 'gallery_cat' ),
			'has_archive'          => false,
			'show_in_nav_menus'    => true
		);

		register_post_type( 'galleries', $args );

		$labels = array(
			'name' 								=> __( 'Gallery Categories', 'anva' ),
			'singular_name' 			=> __( 'Gallery Category', 'anva' ),
			'search_items' 				=> __( 'Search Gallery Categories', 'anva' ),
			'all_items' 					=> __( 'All Gallery Categorys', 'anva' ),
			'parent_item' 				=> __( 'Parent Gallery Category', 'anva' ),
			'parent_item_colon' 	=> __( 'Parent Gallery Category:', 'anva' ),
			'edit_item' 					=> __( 'Edit Gallery Category', 'anva' ), 
			'update_item' 				=> __( 'Update Gallery Category', 'anva' ),
			'add_new_item' 				=> __( 'Add New Gallery Category', 'anva' ),
			'new_item_name' 			=> __( 'New Gallery Category Name', 'anva' ),
		); 							  
			
		register_taxonomy(
			'gallery_cat',
			'galleries',
			array(
				'public'						=> false,
				'hierarchical' 			=> true,
				'labels'						=> $labels,
				'show_ui' 					=> true,
				'rewrite' 					=> array( 'slug' => 'gallery_cat', 'with_front' => false ),
			)
		);
	}

	add_action( 'init', 'aregister' );

	add_action('init', 'wpse29164_registerTaxonomy');
function wpse29164_registerTaxonomy() {
    $args = array(
        'hierarchical' => true,
        'label' => 'Double IPAs',
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'double-ipa'
        ),
        'singular_label' => 'Double IPA'
    );

    register_taxonomy('double-ipa', array('post', 'page'), $args);
}

$terms = get_terms('double-ipa', array('hide_empty' => false));

//$terms = get_terms ('gallery_cat', 'hide_empty = 0');
var_dump($terms);