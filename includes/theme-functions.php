<?php

// Define theme constants
define( 'ANVA_THEME_ID', 'anva' );
define( 'ANVA_THEME_NAME', 'Anva' );
define( 'ANVA_THEME_VERSION', '1.0.0');

// Modify customizer options
require_once( get_template_directory() . '/includes/customizer.php' );

// Modify framework's core options
require_once( get_template_directory() . '/includes/options.php' );

// Add theme updates
require_once( get_template_directory() . '/includes/updates.php' );

// Add recommended plugins
require_once( get_template_directory() . '/includes/install.php' );

/**
 * Filtering theme options menu.
 * 
 * @since  1.0.0
 * @param  array $menu
 * @return array $menu
 */
function theme_options_menu( $menu ) {
	$menu['page_title'] = sprintf( '%1$s %2$s', ANVA_THEME_NAME, __( 'Options', 'anva' ) );
	$menu['menu_title'] = sprintf( '%1$s %2$s', ANVA_THEME_NAME, __( 'Options', 'anva' ) );
	return $menu;
}

/**
 * Filtering theme backup menu.
 * 
 * @since  1.0.0
 * @param  array $menu
 * @return array $menu
 */
function theme_backup_menu( $menu ) {
	$menu['page_title'] = sprintf( '%1$s %2$s', ANVA_THEME_NAME, __( 'Backup', 'anva' ) );
	$menu['menu_title'] = sprintf( '%1$s %2$s', ANVA_THEME_NAME, __( 'Backup', 'anva' ) );
	return $menu;
}

/**
 * Add theme body classes.
 * 
 * @since  1.0.0
 * @param  array $classes
 * @return array $classes
 */
function theme_body_classes( $classes ) {
	$classes[] = anva_get_option( 'layout_style' );
	$classes[] = 'base-color-' . anva_get_option( 'base_color' );
	return $classes;
}

/**
 * Google fonts using by the theme
 * 
 * @since  1.0.0
 * @return void
 */
function theme_google_fonts() {
	anva_enqueue_google_fonts(
		anva_get_option( 'body_font' ),
		anva_get_option( 'heading_font' )
	);
}

/**
 * Add custom editor styles.
 *
 * @since  1.0.0
 * @return void
 */
function theme_add_theme_support() {
	add_editor_style( 'assets/css/editor-style.css' );
	add_theme_support( 'anva-login-styles' );
	add_theme_support( 'anva-megamenu' );
	add_theme_support( 'anva-woocommerce' );
}

/**
 * Include the themes stylesheets.
 * 
 * @since  1.0.0
 * @return void
 */
function theme_stylesheets() {

	// Get stylesheet API
	$api = Anva_Stylesheets_API::instance();

	// Register theme stylesheets
	wp_register_style( 'theme_colors', get_template_directory_uri() . '/assets/css/colors.css', array(), ANVA_THEME_VERSION, 'all' );
	wp_register_style( 'theme_ie', get_template_directory_uri() . '/assets/css/ie.css', array(), ANVA_THEME_VERSION, 'all' );

	// Compress CSS
	if ( '1' != anva_get_option( 'compress_css' ) ) {
		
		// Enqueue theme stylesheets
		wp_enqueue_style( 'theme_colors' );
		
		// IE
		$GLOBALS['wp_styles']->add_data( 'theme_ie', 'conditional', 'lt IE 9' );
		wp_enqueue_style( 'theme_ie' );

		// Inline theme styles
		wp_add_inline_style( 'theme_colors', theme_styles() );

	} else {

		// Include CSS Min
		if ( ! class_exists( 'CSS_Minify' ) ) {
			include_once( anva_get_core_directory() . '/vendor/class-css-min.php' );
		}
		
		// Ignore stylesheets in compressed file
		$ignore = array( 'theme_ie' => '' );

		// Compress CSS files
		anva_minify_stylesheets( $stylesheets, $ignore );
		
		// Add IE conditional
		$GLOBALS['wp_styles']->add_data( 'theme_ie', 'conditional', 'lt IE 9' );
		wp_enqueue_style( 'theme_ie' );
		
		// Inline theme styles
		wp_add_inline_style( 'all-in-one', theme_styles() );

	}
	
	// Level 3 
	$api->print_styles(3);

}

/**
 * Include the theme scripts.
 * 
 * @since  1.0.0
 * @return void
 */
function theme_scripts() {

	// Get scripts API
	$api = Anva_Scripts_API::instance();

	wp_register_script( 'html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js', array(), '3.7.2' );
	wp_register_script( 'css3mediaqueriesjs', 'http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js', array(), '1.0.0' );

	$GLOBALS['wp_scripts']->add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	$GLOBALS['wp_scripts']->add_data( 'css3mediaqueriesjs', 'conditional', 'lt IE 9' );

	// Enqueue Scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'html5shiv' );
	wp_enqueue_script( 'google-map-api', '//maps.google.com/maps/api/js', array(), '3.0.0' );
	wp_localize_script( 'anva', 'ANVAJS', anva_get_js_locals() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Level 3
	$api->print_scripts(3);
	
}

/**
 * Theme custom styles options.
 * 
 * @since  1.0.0
 * @return string $styles
 */
function theme_styles() {
	
	$styles 			= '';

	// Get styles options
	$custom_css 		= anva_get_option( 'custom_css' );
	$body_font 			= anva_get_option( 'body_font' );
	$heading_font 		= anva_get_option( 'heading_font' );
	$heading_h1 		= anva_get_option( 'heading_h1', '27' );
	$heading_h2 		= anva_get_option( 'heading_h2', '24' );
	$heading_h3 		= anva_get_option( 'heading_h3', '18' );
	$heading_h4 		= anva_get_option( 'heading_h4', '14' );
	$heading_h5 		= anva_get_option( 'heading_h5', '13' );
	$heading_h6 		= anva_get_option( 'heading_h6', '11' );
	$background_color 	= anva_get_option( 'bg_color' );
	$background_image 	= anva_get_option( 'background_image', array( 'image' => '' ) );
	$background_cover 	= anva_get_option( 'background_cover' );
	$background_pattern = anva_get_option( 'background_pattern' );
	$link_color			= anva_get_option( 'link_color' );
	$link_color_hover	= anva_get_option( 'link_color_hover' );
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
	.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6, .entry-title h1, .entry-title h2, .page-title h1 {
		font-family: <?php echo anva_get_font_face( $heading_font ); ?>;
		font-style: <?php echo anva_get_font_style( $heading_font ); ?>;
		font-weight: <?php echo anva_get_font_weight( $heading_font ); ?>;
	}
	h1 {
		font-size: <?php echo anva_get_font_size( $heading_h1 ); ?>;
	}
	h2 {
		font-size: <?php echo anva_get_font_size( $heading_h2 ); ?>;
	}
	h3 {
		font-size: <?php echo anva_get_font_size( $heading_h3 ); ?>;
	}
	h4 {
		font-size: <?php echo anva_get_font_size( $heading_h4 ); ?>;
	}
	h5 {
		font-size: <?php echo anva_get_font_size( $heading_h5 ); ?>;
	}
	h6 {
		font-size: <?php echo anva_get_font_size( $heading_h6 ); ?>;
	}
	/* Background */
	body {
		background-color: <?php echo esc_html( $background_color ); ?>;
		<?php if ( ! empty( $background_image['image'] ) ) : ?>
		background-image: url('<?php echo esc_url( $background_image['image'] );?>');
		background-repeat: <?php echo esc_html( $background_image['repeat'] );?>;
		background-position: <?php echo esc_html( $background_image['position'] );?>;
		background-attachment: <?php echo esc_html( $background_image['attachment'] );?>;
		<?php endif; ?>
	}
	<?php if ( $background_cover && ! empty( $background_image['image'] ) ) : ?>
	body {
		background: url('<?php echo esc_url( $background_image['image'] );?>') no-repeat center center fixed; 
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	<?php endif; ?>
	<?php if ( empty( $background_image['image'] ) && ! empty( $background_pattern ) ) : ?>
	body {
		background-image: url('<?php echo anva_get_background_pattern( $background_pattern ); ?>');
		background-repeat: repeat;
	}
	<?php endif; ?>
	<?php if ( $link_color ) : ?>
	/* Links */
	a {
		color: <?php echo $link_color; ?>
	}
	a:hover {
		color: <?php echo $link_color_hover; ?>
	}
	<?php endif; ?>
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

add_action('anva_options_page_custom_scripts', 'theme_base_colors');
function theme_base_colors() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Color Scheme Options - These array names should match
			// the values in base_color_scheme of options.php
			
			// Dark Color Options
			var dark = new Array();
			dark['bg_color']='#e4ff31';
			
			// Light Color Options
			var light = new Array();
			light['bg_color']='#6cff00';
			
			// Vibrant Color Options
			var vibrant = new Array();
			vibrant['bg_color']='#065667';
			
			// When the select box #base_color_scheme changes
			// it checks which value was selected and calls of_update_color
			$('#section-base_color .anva-radio-img-radio').click(function() {
			    colorscheme = $(this).val();
			    if (colorscheme == 'blue') { colorscheme = dark; }
			    if (colorscheme == 'red') { colorscheme = light; }
			    if (colorscheme == 'green') { colorscheme = vibrant; }
			    for (id in colorscheme) {
			        of_update_color(id,colorscheme[id]);
			    }
			});

			// This does the heavy lifting of updating all the colorpickers and text
	        function of_update_color(id,hex) {
	            $('#' + id).wpColorPicker('color',hex);
	        }
		});
	</script>
	<?php
}


/**
 * Remove camera and swiper scripts if their not uses.
 * 
 * @since  1.0.0
 * @return void
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
 * Remove grid columns that are not needed.
 * 
 * @since  1.0.0
 * @param  array $columns
 * @return array $columns
 */
function theme_remove_grid_columns( $columns ) {
	
	if ( is_admin() ) {
		global $pagenow;
	
		// Admin Pages
		if ( ( $pagenow == 'post.php' ) && ( isset( $_GET['post_type'] ) ) && ( $_GET['post_type'] == 'page' ) ) {
			unset( $columns[1] );
			unset( $columns[5] );
			unset( $columns[6] );
		}
		
		// Admin Nav Menu
		if ( ( $pagenow == 'nav-menus.php' ) ) {
			unset( $columns[1] );
			unset( $columns[6] );
		}
	}
	
	return $columns;
}

/*-----------------------------------------------------------------------------------*/
/* Hooks
/*-----------------------------------------------------------------------------------*/

add_filter( 'anva_options_page_menu', 'theme_options_menu' );
add_filter( 'anva_options_backup_menu', 'theme_backup_menu' );
add_filter( 'anva_grid_columns', 'theme_remove_grid_columns' );
add_filter( 'body_class', 'theme_body_classes' );
add_action( 'wp_enqueue_scripts', 'theme_google_fonts' );
add_action( 'wp_enqueue_scripts', 'theme_stylesheets' );
add_action( 'wp_enqueue_scripts', 'theme_scripts' );
add_action( 'wp_enqueue_scripts', 'theme_styles', 20 );
add_action( 'after_setup_theme', 'theme_remove_scripts', 11 );
add_action( 'after_setup_theme', 'theme_add_theme_support', 10 );