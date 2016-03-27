<?php

/*-----------------------------------------------------------------------------------*/
/* Helper Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Generate page builder elements
 *
 * @since  1.0.0
 * @return shortcode The shortcode
 */
function anva_elements() {

	// Get settings
	$settings = anva_get_page_builder_field();

	// Kill it if there's no order
	if ( isset( $settings['order'] ) && empty( $settings['order'] ) ) {
		return;
	}

	// Set items order
	$items 	 = explode( ',', $settings['order'] );
	$counter = 0;

	foreach ( $items as $key => $item ) {

		$atts 		= array();
		$classes 	= array();
		$data 		= $settings[$item]['data'];
		$obj 		= json_decode( $data );
		$content 	= $obj->shortcode . '_content';
		$shortcode 	= $obj->shortcode;

		$counter++;

		// Validate if elements exist
		if ( anva_is_element( $shortcode ) ) {

			$shortcodes = anva_get_elements();

			// Shortcode has attributes
			if ( isset( $shortcodes[$shortcode]['attr'] ) && ! empty( $shortcodes[$shortcode]['attr'] ) ) {

				$classes[] = 'element-has-attributes';

				// Get shortcode attributes
				$attributes = $shortcodes[$shortcode]['attr'];

				foreach ( $attributes as $attribute_id => $attribute ) {
					$obj_attribute = $obj->shortcode . '_' . $attribute_id;
					$atts[$attribute_id] = esc_attr( urldecode( $obj->$obj_attribute ) );
				}
			}

			// Shortcode has content
			if ( isset( $obj->$content ) ) {
				$classes[] = 'element-has-content';
				$content   = urldecode( $obj->$content );
			}
		}

		$classes = implode( ' ', $classes );

		echo '<section id="section-' . esc_attr( $counter ) . '" class="section section-element section-' .  esc_attr( $item ) .' section-' .  esc_attr( $shortcode ) . ' ' .  esc_attr( $classes ) . '">';
		echo '<div id="element-' .  esc_attr( $item ) . '" class="element element-' . esc_attr( $item ) . ' element-' .  esc_attr( $shortcode ) . '">';

		do_action( 'anva_element_' . $shortcode, $atts, $content );

		echo '</div><!-- #element-' . esc_attr( $item ) . ' (end) -->';
		echo '</section><!-- .section-' . esc_attr( $item ) . ' (end) -->';
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
	$attachment_id = $wpdb->get_col( $wpdb->prepare( 'SELECT ID FROM ' . $prefix . 'posts' . " WHERE guid='%s';", $url ) );

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
	if ( $is_lynx ) {
		$classes[] = 'lynx'; }
	elseif ( $is_gecko ) {
		$classes[] = 'gecko'; }
	elseif ( $is_opera ) {
		$classes[] = 'opera'; }
	elseif ( $is_NS4 ) {
		$classes[] = 'ns4'; }
	elseif ( $is_safari ) {
		$classes[] = 'safari'; }
	elseif ( $is_chrome ) {
		$classes[] = 'chrome'; }
	elseif ( $is_IE ) {
		$classes[] = 'ie';
		if ( preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) ) {
			$classes[] = 'ie'.$browser_version[1]; }
	} else {
		$classes[] = 'unknown';
	}

	// iPhone
	if ( $is_iphone ) {
		$classes[] = 'iphone'; }

	// OS
	if ( stristr( $_SERVER['HTTP_USER_AGENT'], 'mac' ) ) {
		$classes[] = 'osx';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'], 'linux' ) ) {
		$classes[] = 'linux';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'], 'windows' ) ) {
		$classes[] = 'windows';
	}

	return $classes;
}

/**
 * Get post list classes.
 *
 * @since  1.0.0
 * @param  string  $class
 * @param  boolean $paged
 * @return string  $classes
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
			'default' => 'template-post-grid post-grid grid-container',
			'paged' => 'post-grid-paginated',
		),
		'list' => array(
			'default' => 'template-post-list post-list post-list container',
			'paged' => 'post-list-paginated',
		),
		'search' => array(
			'default' => 'search-post-list post-list',
			'paged' => 'post-list-paginated',
		),
	);

	if ( isset( $default_classes[ $class ]['default'] ) ) {
		$classes[] = $default_classes[ $class ]['default'];
		if ( $paged && isset( $default_classes[ $class ]['paged'] ) ) {
			$classes[] = $default_classes[ $class ]['paged'];
		}
	}

	$thumb = anva_get_option( 'primary_thumb' );

	// Ignore posts grid
	if ( ! is_page_template( 'template_grid.php' ) ) {
		if ( 'small' == $thumb ) {
			$classes[] = 'post-list-small';
		} elseif ( 'large' == $thumb ) {
			$classes[] = 'post-list-large';
		} elseif ( 'full' == $thumb ) {
			$classes[] = 'post-list-full-width';
		}
	}

	$classes = implode( ' ', $classes );

	return apply_filters( 'anva_post_classes', $classes );
}

/**
* Display the classes for the header element.
*
* @since 1.0.0
* @param string|array $class
*/
function anva_header_class( $class = '' ) {
	echo 'class="' . join( ' ', anva_get_header_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * @since  1.0.0
 * @param  string|array $class
 * @return array        $classes
 */
function anva_get_header_class( $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
			$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	// Filter the header class.
	$classes = apply_filters( 'anva_header_class', $classes, $class );

	return array_unique( $classes );
}

/**
 * Get header styles.
 *
 * @since  1.0.0
 * @return string|boolean
 */
function anva_get_header_style_type() {

	$header_style = anva_get_option( 'header_style', 'default' );
	$styles = anva_get_header_styles();

	if (isset( $styles[ $header_style ] ) ) {
		return $styles[ $header_style ]['type'];
	}

	return false;
}

/**
 * Display name and description in title.
 *
 * @since  1.0.0
 * @param  string $title
 * @param  string $sep
 * @return string $title
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
 */
function anva_setup_author() {
	global $wp_query;
	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

/**
 * Check if a feature is supported by the theme.
 *
 * @since  1.0.0
 * @param  string  $feature
 * @return boolean current theme supprot feature
 */
function anva_support( $feature ) {
	return current_theme_supports( $feature );
}

/**
 * Limit chars in string
 *
 * @since 1.0.0
 */
function anva_truncate_string( $string, $length = 100 ) {
	$string = trim( $string );
	if ( strlen( $string ) <= $length ) {
		return $string;
	} else {
		$string = substr( $string, 0, $length ) . '...';
		return $string;
	}
}

function anva_hex_to_rgb( $hex ) {

	$hex = str_replace( '#', '', $hex );
	$color = array();

	if ( strlen( $hex ) == 3 ) {
		$color['r'] = hexdec( substr( $hex, 0, 1 ) . $r );
		$color['g'] = hexdec( substr( $hex, 1, 1 ) . $g );
		$color['b'] = hexdec( substr( $hex, 2, 1 ) . $b );
	} else if ( strlen( $hex ) == 6 ) {
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
 * Filter applied on copyright text to allow dynamic variables.
 *
 * @since  1.0.0
 * @param  string $text
 * @return string $text
 */
function anva_footer_copyright_helpers( $text ) {
	$text = str_replace( '%year%', esc_attr( date( 'Y' ) ), $text );
	$text = str_replace( '%site_title%', esc_html( get_bloginfo( 'site_title' ) ), $text );
	return $text;
}


/**
 * Get current year in footer copyright.
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
	$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );

	return $buffer;
}

/**
 * Minify stylesheets output and combine into one
 *
 * @since  1.0.0
 * @param  array $merge_styles
 * @param  array $ignore
 * @return Enqueue stysheets
 */
function anva_minify_stylesheets( $merge_styles = array(), $ignore = array() ) {

	// Get framework stylesheets
	$stylesheets = anva_get_stylesheets();

	// Set filename
	$filename = apply_filters( 'anva_minify_stylesheets_filename', 'all.min.css' );

	// Set file path and URL
	$file_path = get_template_directory() . '/assets/css/min/' . $filename;
	$file_url = get_template_directory_uri() . '/assets/css/min/' . $filename;

	if ( ! file_exists( $file_path ) ) {

		$files = array();

		if ( is_array( $merge_styles ) && $merge_styles ) {
			$merged = array_merge( $stylesheets, $merge_styles );
		}

		// Set URL
		$url = 'http';

		if ( isset( $_SERVER['HTTPS'] ) && filter_var( $_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN ) ) {
			$url .= 'https';
		}

		$url .= '://';

		foreach ( $merged as $key => $value ) {
			if ( isset( $ignore[ $key ] ) ) {
				unset( $merged[ $key ] );
			} elseif ( isset( $value['src'] ) ) {
				$string = str_replace( $url . $_SERVER['SERVER_NAME'], $_SERVER['DOCUMENT_ROOT'], $value['src'] );
				if ( file_exists( $string ) ) {
					$files[] = $string;
				}
			}
		}

		// Create compressed file if don't exists
		$cssmin = new CSS_Minify();

		// Add files
		$cssmin->add_files( $files );

		// Set original CSS from all files
		$cssmin->set_original_css();

		// Compress CSS
		$cssmin->compress_css();

		// Get compressed and combined css
		$css = $cssmin->print_compressed_css();

		// Create compressed file
		file_put_contents( $file_path, $css );
	}

	// Dequeue framework stylesheets to clear the HEAD
	foreach ( $stylesheets as $key => $value ) {
		if ( isset( $value['handle'] ) ) {
			wp_dequeue_style( $value['handle'] );
			wp_deregister_style( $value['handle'] );
		}
	}

	$version = ANVA_FRAMEWORK_VERSION;
	if ( defined( 'ANVA_THEME_VERSION' ) ) {
		$version = ANVA_THEME_VERSION;
	}

	// Enqueue compressed files
	wp_enqueue_style( 'anva-all-in-one', $file_url, array(), $version, 'all' );

}

/**
 * Get template framework part.
 *
 * @since 1.0.0
 * @param string $name
 * @param string $slug
 */
function anva_get_template_part( $name, $slug = 'content' ) {
	$path = trailingslashit( 'framework/templates' );
	get_template_part( $path . $slug, $name );
}

/**
 * Get core framework url.
 *
 * @since  1.0.0
 * @return string $uri
 */
function anva_get_core_uri() {
	if ( defined( 'ANVA_FRAMEWORK_URI' ) ) {
		$uri = ANVA_FRAMEWORK_URI;
	} else {
		$uri = trailingslashit( get_template_directory_uri() . '/framework' );
	}
	return $uri;
}

/**
 * Get core framework admin url.
 *
 * @since  1.0.0
 * @return string $uri
 */
function anva_get_core_admin_uri() {
	if ( defined( 'ANVA_FRAMEWORK_ADMIN_URI' ) ) {
		$uri = ANVA_FRAMEWORK_ADMIN_URI;
	} else {
		$uri = trailingslashit( get_template_directory_uri() . '/framework/admin' );
	}
	return $uri;
}

/**
 * Get core framework directory.
 *
 * @since  1.0.0
 * @return string $path
 */
function anva_get_core_directory() {
	if ( defined( 'ANVA_FRAMEWORK_DIR' ) ) {
		$path = ANVA_FRAMEWORK_DIR;
	} else {
		$path = trailingslashit( get_template_directory() . '/framework' );
	}
	return $path;
}

/**
 * Get core framework admin directory.
 *
 * @since  1.0.0
 * @return string $path
 */
function anva_get_core_admin_directory() {
	if ( defined( 'ANVA_FRAMEWORK_ADMIN' ) ) {
		$path = ANVA_FRAMEWORK_ADMIN;
	} else {
		$path = trailingslashit( get_template_directory() . '/framework/admin' );
	}
	return $path;
}

/**
 * Insert a key in array.
 * 
 * @param  array   $array 
 * @param  string  $search_key
 * @param  string  $insert_key
 * @param  string  $insert_value
 * @param  boolean $insert_after
 * @param  boolean $append
 * @return array   $new_array
 */
function anva_insert_array_key( $array, $search_key, $insert_key, $insert_value, $insert_after = true, $append = false ) {

	if ( ! is_array( $array ) ) {
		return;
	}

	$new_array = array();

	foreach ( $array as $key => $value ) {

		// INSERT BEFORE THE CURRENT KEY?
		// ONLY IF CURRENT KEY IS THE KEY WE ARE SEARCHING FOR, AND WE WANT TO INSERT BEFORE THAT FOUNDED KEY
		if ( $key === $search_key && ! $insert_after ) {
			$new_array[ $insert_key ] = $insert_value; }

		// COPY THE CURRENT KEY/VALUE FROM OLD ARRAY TO A NEW ARRAY
		$new_array[ $key ] = $value;

		// INSERT AFTER THE CURRENT KEY?
		// ONLY IF CURRENT KEY IS THE KEY WE ARE SEARCHING FOR, AND WE WANT TO INSERT AFTER THAT FOUNDED KEY
		if ( $key === $search_key && $insert_after ) {
			$new_array[ $insert_key ] = $insert_value; }
	}

	// APPEND IF KEY ISNT FOUNDED
	if ( $append && count( $array ) == count( $new_array ) ) {
		$new_array[ $insert_key ] = $insert_value; }

	return $new_array;

}

/**
 * Convert memory use.
 * 
 * @param  int $size
 * @return int $size
 */
function anva_convert_memory_use( $size ) {
	$unit = array( 'b', 'kb', 'mb', 'gb', 'tb', 'pb' );
	return @round( $size / pow( 1024, ( $i = floor( log( $size, 1024 ) ) ) ), 2 ) . ' ' . $unit[ $i ];
}