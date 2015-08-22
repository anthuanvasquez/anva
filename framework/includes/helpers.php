<?php
/*-----------------------------------------------------------------------------------*/
/* Helper Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Get page builder field meta
 *
 * @since  1.0.0
 * @return string The page builder field meta
 */
function anva_get_page_builder_field() {
	
	$field = false;
	$page_builder_meta = anva_setup_page_builder_meta();

	if ( isset( $page_builder_meta['args']['id'] ) ) {
		$field = anva_get_post_meta( $page_builder_meta['args']['id'] );
	}

	return $field;
}

/**
 * Generate page builder elements
 *
 * @since  1.0.0
 * @return shortcode The shortcode 
 */
function anva_page_builder_elements( $page_id, $post_type = 'page' ) {
	
	$settings = anva_get_page_builder_field();
	$items_order = $settings['order'];
	$counter = 0;
	$classes = '';
	
	$items = explode( ',', $items_order );
	$shortcodes = anva_get_elements();
	
	if ( is_array( $items ) && count( $items ) > 0 ) {
			
		$html = '';
	
		foreach ( $items as $key => $item ) {

			$counter++;

			$item_data 				= $settings[$item]['data'];
			$item_size 				= $settings[$item]['size'];
			$item_obj 				= json_decode( $item_data );
			$item_content 		= $item_obj->shortcode . '_content';
			$shortcode 				= $item_obj->shortcode;

			// Validate if shortcode exist in elements array
			if ( isset( $shortcodes[$shortcode] ) ) {

				$html .= '[anva_' . $shortcode . ' size="' . esc_attr( $item_size ) . '" ';

				$title = $item_obj->shortcode . '_title';
				
				if ( isset( $item_obj->$title ) ) {
					$html .= 'title="' . esc_attr( urldecode( $item_obj->$title ), ENT_QUOTES, "UTF-8" ) . '" ';
				}
				
				// Get shortcode attributes
				$attributes = $shortcodes[$shortcode];
				
				foreach ( $attributes['attr'] as $attr => $value ) {
					$shortcode_attr = $item_obj->shortcode . '_' . $attr;
					
					if ( isset( $item_obj->$shortcode_attr ) ) {
						$html .= $attr . '="' . esc_attr( $item_obj->$shortcode_attr ) . '" ';
					}
				}

				// Shortcode has content
				if ( isset( $item_obj->$item_content ) ) {
					$classes = 'element-has-content';
					$html .= ']' . wp_kses_post( urldecode( $item_obj->$item_content ) ) . '[/anva_' . $shortcode . ']';

				} else {
					$html .= ']';
				}

			}
			
			echo '<section id="section-' . $counter . '" class="section-element section-' . $item .' section-' . $shortcode . ' ' . $classes . '">';
			echo '<div id="element-' . $item . '" class="element element-columns-' . $item_size . '">';
			echo anva_apply_content( $html );
			echo '</div><!-- #element-' . $item . ' (end) -->';
			echo '</section><!-- .section-' . $item . ' (end) -->';
		}
	}
		
	return false;
}

function anva_apply_content( $content ) {
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]>', $content );
	return $content;
}

function pp_get_image_id( $url ) {
	
	global $wpdb;
	
	$prefix = $wpdb->prefix;
	$attachment_id = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $url ) );
	
	if ( isset( $attachment_id[0] ) ) {
		return $attachment_id[0];
	}
	
	return '';
}

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
	$files  = array();
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

	if ( defined( 'ANVA_FRAMEWORK_DOMAIN' ) ) {
		$domain = ANVA_FRAMEWORK_DOMAIN;
	}

	return $domain;

}

function anva_insert_array_key( $array, $search_key, $insert_key, $insert_value, $insert_after_founded_key = true, $append_if_not_found = false ) {

	$new_array = array();

	foreach ( $array as $key => $value ) {

		// INSERT BEFORE THE CURRENT KEY? 
		// ONLY IF CURRENT KEY IS THE KEY WE ARE SEARCHING FOR, AND WE WANT TO INSERT BEFORE THAT FOUNDED KEY
		if ( $key === $search_key && ! $insert_after_founded_key )
			$new_array[ $insert_key ] = $insert_value;

		// COPY THE CURRENT KEY/VALUE FROM OLD ARRAY TO A NEW ARRAY
		$new_array[ $key ] = $value;

		// INSERT AFTER THE CURRENT KEY? 
		// ONLY IF CURRENT KEY IS THE KEY WE ARE SEARCHING FOR, AND WE WANT TO INSERT AFTER THAT FOUNDED KEY
		if ( $key === $search_key && $insert_after_founded_key )
			$new_array[ $insert_key ] = $insert_value;

	}

	// APPEND IF KEY ISNT FOUNDED
	if ( $append_if_not_found && count( $array ) == count( $new_array ) )
		$new_array[ $insert_key ] = $insert_value;

	return $new_array;

}