<?php
/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

// Define theme constants
define( 'THEME_ID', 'theme' );
define( 'THEME_NAME', 'Theme' );
define( 'THEME_VERSION', '1.0.0');

// Modify framework's theme options
require_once( get_template_directory() . '/functions/options.php' );

/* 
 * Change the options.php directory.
 */
function theme_options_location() {
	return  '/functions/options.php';
}

/*
 * This is an example of filtering menu parameters
 */
function theme_options_menu( $menu ) {
	$options_framework  = new Options_Framework;
	$option_name 				= $options_framework->get_option_name();
	$menu['mode'] 			= 'menu';
	$menu['page_title'] = __( 'Theme Options', 'anva' );
	$menu['menu_title'] = __( 'Theme Options', 'anva' );
	$menu['menu_slug']  = $option_name;
	return $menu;
}

/**
 * Change the slider args
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
 * Change the start year in footer.
 */
// function anva_theme_start_year() {
// 	return 2015;
// }
// add_filter( 'anva_footer_year', 'anva_theme_start_year' );

/**
 * Body Classes
 */
function theme_body_classes( $classes ) {
	$classes[] = anva_get_option( 'layout_style' );
	$classes[] = 'skin-'. anva_get_option( 'skin' );
	return $classes;
}

/**
 * Google fonts using by the theme
 */
function theme_google_fonts() {
	anva_enqueue_google_fonts(
		anva_get_option('body_font'),
		anva_get_option('heading_font')
	);
}

function theme_add_stylesheets() {
	// anva_add_stylesheet( 'test', get_template_directory_uri() . '/assets/css/test.css', 3 );
}

function theme_add_scripts() {
	// anva_add_script( 'test', get_template_directory_uri() . '/assets/js/test.js', 4 );
}

/**
 * Custom Stylesheets
 */
function theme_stylesheets() {

	// Get stylesheet API
	$api = Anva_Stylesheets::instance();

	// Register stylesheets
	$stylesheets = array();

	$stylesheets['theme_screen'] = array(
		'handle' => 'theme_screen',
		'src' => get_template_directory_uri() . '/assets/css/screen.css',
		'deps' => $api->get_framework_deps(),
		'ver' => THEME_VERSION,
		'media' => 'all'
	);

	$stylesheets['theme_colors'] = array(
		'handle' => 'theme_colors',
		'src' => get_template_directory_uri() . '/assets/css/colors.css',
		'deps' => array( 'theme_screen' ),
		'ver' => THEME_VERSION,
		'media' => 'all'
	);

	$stylesheets['theme_responsive'] = array(
		'handle' => 'theme_responsive',
		'src' => get_template_directory_uri() . '/assets/css/responsive.css',
		'deps' => array( 'theme_screen' ),
		'ver' => THEME_VERSION,
		'media' => 'all'
	);

	$stylesheets['theme_ie'] = array(
		'handle' => 'theme_ie',
		'src' => get_template_directory_uri() . '/assets/css/ie.css',
		'deps' => array( 'theme_screen' ),
		'ver' => THEME_VERSION,
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

function theme_scripts() {

	// Get stylesheet API
	$api = Anva_Scripts::instance();

	wp_register_script( 'html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js', array(), '3.6.2' );
	wp_register_script( 'css3mediaqueriesjs', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js', array(), '3.6.2' );

	$GLOBALS['wp_scripts']->add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	$GLOBALS['wp_scripts']->add_data( 'css3mediaqueriesjs', 'conditional', 'lt IE 9' );

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
 */
function theme_styles() {
	$styles = '';
	$custom_css = anva_get_option( 'custom_css' );
	$body_font = anva_get_option( 'body_font' );
	$heading_font = anva_get_option( 'heading_font' );
	$heading_h1 = anva_get_option( 'heading_h1', '27' );
	$heading_h2 = anva_get_option( 'heading_h2', '24' );
	$heading_h3 = anva_get_option( 'heading_h3', '18' );
	$heading_h4 = anva_get_option( 'heading_h4', '14' );
	$heading_h5 = anva_get_option( 'heading_h5', '13' );
	$heading_h6 = anva_get_option( 'heading_h6', '11' );
	$background_color = anva_get_option( 'background_color' );
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

	// Compress output
	return anva_compress( $styles );
}

/*-----------------------------------------------------------------------------------*/
/* Hooks
/*-----------------------------------------------------------------------------------*/

add_filter( 'options_framework_location', 'theme_options_location' );
add_filter( 'optionsframework_menu', 'theme_options_menu' );
add_filter( 'body_class', 'theme_body_classes' );
add_action( 'wp_enqueue_scripts', 'theme_google_fonts' );
add_action( 'after_setup_theme', 'theme_add_stylesheets' );
add_action( 'after_setup_theme', 'theme_add_scripts' );
add_action( 'wp_enqueue_scripts', 'theme_stylesheets' );
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
add_action( 'wp_enqueue_scripts', 'theme_styles', 20 );