<?php

/* ---------------------------------------------------------------- */
/* (1) Helpers - Anva Core Options
/* ---------------------------------------------------------------- */

if ( ! function_exists( 'anva_get_core_options' ) ) :
/**
 * Get raw options. This helper function is more
 * for backwards compatibility. Realistically, it
 * doesn't have much use unless an old plugin is
 * still using it.
 *
 * @since 1.0.0
 */
function anva_get_core_options() {
	$api = Anva_Core_Options::instance();
	return $api->get_raw_options();
}
endif;

if ( ! function_exists( 'anva_get_formatted_options' ) ) :
/**
 * Get formatted options. Note that options will not be
 * formatted until after WP's after_setup_theme hook.
 *
 * @since 1.0.0
 */
function anva_get_formatted_options() {
	$api = Anva_Core_Options::instance();
	return $api->get_formatted_options();
}
endif;

if ( ! function_exists( 'anva_add_option_tab' ) ) :
/**
 * Add theme option tab
 *
 * @since 1.0.0
 */
function anva_add_option_tab( $tab_id, $tab_name, $top = false ) {
	$api = Anva_Core_Options::instance();
	$api->add_tab( $tab_id, $tab_name, $top );
}
endif;

if ( ! function_exists( 'anva_remove_option_tab' ) ) :
/**
 * Remove theme option tab
 *
 * @since 1.0.0
 */
function anva_remove_option_tab( $tab_id ) {
	$api = Anva_Core_Options::instance();
	$api->remove_tab( $tab_id );
}
endif;

if ( ! function_exists( 'anva_add_option_section' ) ) :
/**
 * Add theme option section
 *
 * @since 1.0.0
 */
function anva_add_option_section( $tab_id, $section_id, $section_name, $section_desc = null, $options = null, $top = false ) {
	$api = Anva_Core_Options::instance();
	$api->add_section( $tab_id, $section_id, $section_name, $section_desc, $options, $top );
}
endif;

if ( ! function_exists( 'anva_remove_option_section' ) ) :
/**
 * Remove theme option section
 *
 * @since 1.0.0
 */
function anva_remove_option_section( $tab_id, $section_id ) {
	$api = Anva_Core_Options::instance();
	$api->remove_section( $tab_id, $section_id );
}
endif;

if ( ! function_exists( 'anva_add_option' ) ) :
/**
 * Add theme option
 *
 * @since 1.0.0
 */
function anva_add_option( $tab_id, $section_id, $option_id, $option ) {
	$api = Anva_Core_Options::instance();
	$api->add_option( $tab_id, $section_id, $option_id, $option );
}
endif;

if ( ! function_exists( 'anva_remove_option' ) ) :
/**
 * Remove theme option
 *
 * @since 1.0.0
 */
function anva_remove_option( $tab_id, $section_id, $option_id ) {
	$api = Anva_Core_Options::instance();
	$api->remove_option( $tab_id, $section_id, $option_id );
}
endif;

if ( ! function_exists( 'anva_edit_option' ) ) :
/**
 * Edit theme option
 *
 * @since 1.0.0
 */
function anva_edit_option( $tab_id, $section_id, $option_id, $att, $value ) {
	$api = Anva_Core_Options::instance();
	$api->edit_option( $tab_id, $section_id, $option_id, $att, $value );
}
endif;


/* ---------------------------------------------------------------- */
/* (2) Helpers - Anva Core Scripts
/* ---------------------------------------------------------------- */

/**
 * Add custom script
 *
 * @since 1.0.0
 */
function anva_add_script( $handle, $src, $level = 4, $ver = null, $footer = true ) {
	$api = Anva_Scripts::instance();
	$api->add( $handle, $src, $level, $ver, $footer );
}

/**
 * Remove custom script
 *
 * @since 1.0.0
 */
function anva_remove_script( $handle ) {
	$api = Anva_Scripts::instance();
	$api->remove( $handle );
}

/**
 * Get scripts
 *
 * @since 1.0.0
 */
function anva_get_scripts() {
	$api = Anva_Scripts::instance();
	$core = $api->get_framework_scripts();
	$custom = $api->get_custom_scripts();
	return array_merge( $core, $custom );
}

/**
 * Print out scripts
 *
 * @since 1.0.0
 */
function anva_print_scripts( $level ) {
	$api = Anva_Scripts::instance();
	$api->print_scripts( $level );
}

/* ---------------------------------------------------------------- */
/* (3) Helpers - Anva Core Stylesheets
/* ---------------------------------------------------------------- */

/**
 * Add custom stylesheet
 * 
 * @since 1.0.0
 */
function anva_add_stylesheet( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
	$api = Anva_Stylesheets::instance();
	$api->add( $handle, $src, $level, $ver, $media );
}

/**
 * Remove custom stylesheet
 * 
 * @since 1.0.0
 */
function anva_remove_stylesheet( $handle ) {
	$api = Anva_Stylesheets::instance();
	$api->remove( $handle );
}

/**
 * Get stylesheets
 * 
 * @since 1.0.0
 */
function anva_get_stylesheets() {
	$api = Anva_Stylesheets::instance();
	$core = $api->get_framework_stylesheets();
	$custom = $api->get_custom_stylesheets();
	return array_merge( $core, $custom );
}

/**
 * Print out styles
 * 
 * @since 1.0.0
 */
function anva_print_styles( $level ) {
	$api = Anva_Stylesheets::instance();
	$api->print_styles( $level );
}

/* ---------------------------------------------------------------- */
/* (4) Helpers - Anva Core Sidebars
/* ---------------------------------------------------------------- */

/**
 * Add sidebar location
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_location( $id, $name, $desc = '' ) {
	$api = Anva_Sidebars::instance();
	$api->add_location( $id, $name, $desc );
}

/**
 * Remove sidebar location
 * 
 * @since 1.0.0
 */
function anva_remove_sidebar_location( $id ) {
	$api = Anva_Sidebars::instance();
	$api->remove_location( $id );
}

/**
 * Get sidebar locations
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_locations() {
	$api = Anva_Sidebars::instance();
	return $api->get_locations();
}

/**
 * Get sidebar location name or slug name
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_location_name( $location, $slug = false ) {
	$api = Anva_Sidebars::instance();
	$sidebar = $api->get_locations( $location );

	if ( isset( $sidebar['args']['name'] ) ) {
		if ( $slug ) {
			return sanitize_title( $sidebar['args']['name'] );
		}
		return $sidebar['args']['name'];
	}

	return __( 'Widget Area', anva_textdomain() );
}

/**
 * Display sidebar location
 * 
 * @since 1.0.0
 */
function anva_display_sidebar( $location ) {
	$api = Anva_Sidebars::instance();
	$api->display( $location );
}

/**
 * Add sidebar args when register locations
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_args( $id, $name, $desc = '', $classes = '' ) {	
	$args = array(
		'id'            => $id,
		'name'          => $name,
		'description'		=> $desc,
		'before_widget' => '<aside id="%1$s" class="widget %2$s '. esc_attr( $classes ) .'"><div class="widget-inner clearfix">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);
	return apply_filters( 'anva_add_sidebar_args', $args );
}

/* ---------------------------------------------------------------- */
/* (5) Helpers - Anva Core Widgets
/* ---------------------------------------------------------------- */

/**
 * Add widget
 *
 * @since 1.0.0
 */
function anva_add_widget( $class ) {
	$api = Anva_Widgets::instance();
	$api->add_widget( $class );
}

/**
 * Remove widget
 *
 * @since 1.0.0
 */
function anva_remove_widget( $class ) {
	$api = Anva_Widgets::instance();
	$api->remove_widget( $class ); 
}

/**
 * Get widgets
 *
 * @since 1.0.0
 */
function anva_get_widgets() {
	$api = Anva_Widgets::instance();
	return $api->get_widgets();
}


/* ---------------------------------------------------------------- */
/* (6) Helpers - Anva Meta Box
/* ---------------------------------------------------------------- */

/**
 * Helper to add new meta box
 *
 * @since  1.0.0
 * @return Instance of class
 */
function anva_add_new_meta_box( $id, $args, $options ) {
	$meta_box = new Anva_Meta_Box( $id, $args, $options );
}

/**
 * Get field
 *
 * @since 1.0.0
 */
function anva_get_field( $field, $default = false ) {

	$id = null;
	
	if ( is_page() ) {
		$page = anva_setup_page_meta();
	}

	if ( is_singular( 'post' ) ) {
		$page = anva_setup_post_meta();
	}

	if ( is_singular( 'galleries' ) ) {
		$page = anva_setup_gallery_meta();
	}

	if ( isset( $page['args']['id'] ) ) {
		$id = $page['args']['id'];
	}

	$fields = anva_get_post_meta( $id );

	if ( isset( $fields[$field] ) ) {
		return $fields[$field];
	}

	return $default;
}

/**
 * Show field
 *
 * @since 1.0.0
 */
function anva_the_field( $id, $field, $default = false ) {
	echo anva_get_field( $id, $field, $default );
}

/* ---------------------------------------------------------------- */
/* Common Helpers
/* ---------------------------------------------------------------- */

/**
 * Home page args
 *
 * @since 1.0.0
 */
function anva_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

/**
 * Body classes
 * Adds a class of group-blog to blogs with more than 1 published author.
 *
 * @since   1.0.0
 * @package Anva
 * @return  array Body classes.
 */
function anva_body_class( $classes ) {
	
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$classes[] = anva_get_option( 'navigation' );
	$classes[] = 'lang-' . strtolower( get_bloginfo( 'language' ) );
	
	$footer = anva_get_option( 'footer_setup' );
	if (  isset( $footer['num'] ) && $footer['num'] > 0  ) {
		$classes[] = 'has-footer-content';
	}
	
	return $classes;
}

/**
 * Return browser classes
 *
 * @since   1.0.0
 * @package Anva
 * @return  array Body classes.
 */
function anva_browser_class( $classes ) {
	
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
	// Browsers
	if ( $is_lynx )
		$classes[] = 'lynx';
	elseif ( $is_gecko )
		$classes[] = 'gecko';
	elseif ( $is_opera )
		$classes[] = 'opera';
	elseif ( $is_NS4 )
		$classes[] = 'ns4';
	elseif ( $is_safari )
		$classes[] = 'safari';
	elseif ( $is_chrome )
		$classes[] = 'chrome';
	elseif ( $is_IE ) {
		$classes[] = 'ie';
		if ( preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) )
			$classes[] = 'ie'.$browser_version[1];
	} else {
		$classes[] = 'unknown';
	}
	
	// iPhone
	if ( $is_iphone )
		$classes[] = 'iphone';

	// OS
	if ( stristr( $_SERVER['HTTP_USER_AGENT'], "mac" ) ) {
		$classes[] = 'osx';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'], "linux" ) ) {
		$classes[] = 'linux';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'], "windows" ) ) {
		$classes[] = 'windows';
	}
	
	return $classes;
}

/**
 * Get primary post classes
 *
 * @since   1.0.0
 * @package Anva
 * @return  string Body classes.
 */
function anva_post_classes( $class, $paged = true ) {

	$classes = array();

	$default_classes = array(
		'index' => array(
			'default' => 'primary-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'archive' => array(
			'default' => 'archive-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'grid' => array(
			'default' => 'primary-post-grid post-grid',
			'paged' => 'post-grid-paginated',
		),
		'list' => array(
			'default' => 'template-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'search' => array(
			'default' => 'search-post-list post-list',
			'paged' => 'post-list-paginated',
		),
	);

	if ( isset( $default_classes[$class]['default'] ) ) {
		$classes[] = $default_classes[$class]['default'];
		if ( $paged && isset( $default_classes[$class]['paged'] ) ) {
			$classes[] = $default_classes[$class]['paged'];
		}
	}
	
	$thumb = anva_get_option( 'primary_thumb' );

	// Ignore posts grid
	if ( ! is_page_template( 'template_grid.php' ) ) {
		if ( 'small' == $thumb ) {
			$classes[] = 'post-list-small';
		} elseif ( 'large' == $thumb ) {
			$classes[] = 'post-list-large';
		}
	}

	$classes = implode( ' ', $classes );
	
	return apply_filters( 'anva_post_classes', $classes );
}

/**
 * Display name and description in title
 *
 * @since   1.0.0
 * @package Anva
 * @param   string The title of the site, string Separator.
 * @return  string The title content.
 */
function anva_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( anva_get_local( 'page' ) .' %s', max( $paged, $page ) );
	}

	return $title;
}

/**
 * Setup author page
 *
 * @since   1.0.0
 * @package Anva
 */
function anva_setup_author() {
	global $wp_query;
	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

/**
 * Limit chars in string
 *
 * @since 1.0.0
 */
function anva_truncate_string( $string, $length = 100 ) {
	$string = trim( $string );
	if ( strlen( $string ) <= $length) {
		return $string;
	} else {
		$string = substr( $string, 0, $length ) . '...';
		return $string;
	}
}

function HexToRGB( $hex ) {
	$hex = str_replace( '#', '', $hex );
	$color = array();
	
	if ( strlen( $hex ) == 3 ) {
		$color['r'] = hexdec( substr( $hex, 0, 1 ) . $r );
		$color['g'] = hexdec( substr( $hex, 1, 1 ) . $g );
		$color['b'] = hexdec( substr( $hex, 2, 1 ) . $b );
	} else if( strlen( $hex ) == 6 ) {
		$color['r'] = hexdec( substr( $hex, 0, 2 ) );
		$color['g'] = hexdec( substr( $hex, 2, 2 ) );
		$color['b'] = hexdec( substr( $hex, 4, 2 ) );
	}
	
	return $color;
}

/**
 * Limit chars in excerpt
 *
 * @since 1.0.0
 */
function anva_excerpt( $length = '' ) {
	if ( empty( $length ) ) {
		$length = apply_filters( 'anva_excerpt_length', 256 );
	}
	$string = get_the_excerpt();
	$p = anva_truncate_string( $string, $length );
	echo wpautop( $p );
}

/**
 * Get current year in footer copyright
 *
 *
 * @since 1.0.0
 */
function anva_get_current_year( $year ) {
	$current_year = date( 'Y' );
	return $year . ( ( $year != $current_year ) ? ' - ' . $current_year : '' );
}

/**
 * Compress a chunk of code to output
 *
 * @since 1.0.0
 */
function anva_compress( $buffer ) {

	// Remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

	return $buffer;
}

/**
 * Minify stylesheets output and combine into one
 *
 * @since   1.0.0
 * @package Anva
 * @return  Enqueue stysheets
 */
function anva_minify_stylesheets( $merge_styles = array(), $ignore = array() ) {

	$filename = apply_filters( 'anva_minify_stylesheets_filename', 'all.min.css' );
	$files 	= array();
	$stylesheets = anva_get_stylesheets();

	if ( is_array( $merge_styles ) && ! empty( $merge_styles ) ) {
		$merged = array_merge( $stylesheets, $merge_styles );
	}

	// Set URL
	$url = '';

	if ( isset( $_SERVER['HTTPS'] ) && filter_var( $_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN ) ) {
		$url .= 'https';
	} else {
		$url .= 'http';
	}

	$url .= '://';

	foreach ( $merged as $key => $value ) {
		if ( isset( $ignore[$key] ) ) {
			unset( $merged[$key] );
		} elseif ( isset( $value['src'] ) ) {
			$string = str_replace( $url . $_SERVER['SERVER_NAME'], $_SERVER['DOCUMENT_ROOT'], $value['src']);
			if ( file_exists( $string ) ) {
				$files[] = $string;
			}
		}
	}

	// Get file path
	$path = get_template_directory() .'/assets/css/'. $filename;
		
	// Create compressed file if don't exists
	if ( ! file_exists( $path ) ) {
		$cssmin = new CSSMin();

		// Add files
		$cssmin->addFiles( $files );

		// Set original CSS from all files
		$cssmin->setOriginalCSS();

		// Compress CSS
		$cssmin->compressCSS();

		// Get compressed and combined css
		$css = $cssmin->printCompressedCSS();

		// Create compressed file
		file_put_contents( $path, $css );
	}

	// Dequeue framework stylesheets to clear the HEAD
	foreach ( $stylesheets as $key => $value ) {
		if ( isset( $value['handle'] ) ) {
			wp_dequeue_style( $value['handle'] );
			wp_deregister_style( $value['handle'] );
		}
	}

	// Enqueue compressed file
	wp_enqueue_style( 'anva-all-in-one', get_template_directory_uri() .'/assets/css/'. $filename, array(), THEME_VERSION, 'all' );
	
}

/**
 * Get templates part
 *
 * @since 1.0.0
 */
function anva_get_template_part( $name ) {
	$path = 'templates/';
	$part = 'template_';
	get_template_part( $path . $part . $name );
}

/**
 * Get framework url
 *
 * @since 1.0.0
 */
function anva_get_core_url() {
	if ( defined( 'ANVA_FRAMEWORK_URL' ) ) {
		$url = ANVA_FRAMEWORK_URL;
	} else {
		$url = get_template_directory_uri() . '/framework';
	}
	return $url;
}

/**
 * Get templates part
 *
 * @since 1.0.0
 */
function anva_get_core_directory() {
	if ( defined( 'ANVA_FRAMEWORK' ) ) {
		$path = ANVA_FRAMEWORK;
	} else {
		$path = get_template_directory() . '/framework';
	}
	return $path;
}

/**
 * Textdomain
 *
 * @since 1.0.0
 */
function anva_textdomain() {
	$domain = 'anva';
	if ( defined( 'ANVA_DOMAIN' ) ) {
		$domain = ANVA_DOMAIN;
	}
	return $domain;
}