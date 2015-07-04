<?php

define( 'THEME_ID', 'theme' );
define( 'THEME_NAME', 'Theme' );
define( 'THEME_VERSION', '1.0.0');

/*-----------------------------------------------------------------------------------*/
/* Theme Functions
/*-----------------------------------------------------------------------------------*/

/* 
 * Change the options.php directory.
 */
function theme_options_location() {
	return  '/framework/admin/options.php';
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

/**
 * Custom Stylesheets
 */
function theme_stylesheets() {
	
	wp_enqueue_style( 'theme-skin', get_template_directory_uri() . '/assets/css/colors.css' );
	wp_add_inline_style( 'theme-skin', theme_styles() );

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
add_action( 'wp_enqueue_scripts', 'theme_stylesheets' );
add_action( 'wp_enqueue_scripts', 'theme_styles', 20 );