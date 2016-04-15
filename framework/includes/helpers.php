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
	$settings = anva_get_post_meta( '_anva_builder_options' );

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
		$data 		= $settings[ $item ]['data'];
		$obj 		= json_decode( $data );
		$content 	= $obj->shortcode . '_content';
		$shortcode 	= $obj->shortcode;

		$counter++;

		// Check if the element exists.
		if ( anva_element_exists( $shortcode ) ) {

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
			} else {
				$content = NULL;
			}

			$classes = implode( ' ', $classes );

			echo '<section id="section-' . esc_attr( $counter ) . '" class="section section-element section-' .  esc_attr( $item ) .' section-' .  esc_attr( $shortcode ) . ' ' .  esc_attr( $classes ) . '">';
			echo '<div id="element-' .  esc_attr( $item ) . '" class="element element-' . esc_attr( $item ) . ' element-' .  esc_attr( $shortcode ) . '">';

			do_action( 'anva_element_' . $shortcode, $atts, $content );

			echo '</div><!-- #element-' . esc_attr( $item ) . ' (end) -->';
			echo '</section><!-- .section-' . esc_attr( $item ) . ' (end) -->';
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
	$attachment_id = $wpdb->get_col( $wpdb->prepare( 'SELECT ID FROM ' . $prefix . 'posts' . " WHERE guid='%s';", $url ) );

	if ( isset( $attachment_id[0] ) ) {
		return $attachment_id[0];
	}

	return '';
}

/**
 * Home page args
 *
 * @since  1.0.0
 * @param  array $args
 * @return array $args
 */
function anva_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

/**
 * Get args for wp_nav_menu().
 *
 * @since 1.0.0
 * @param string $location
 * @param array  $args
 */
function anva_get_wp_nav_menu_args( $location = 'primary' ) {

	$args = array();

	switch ( $location ) {
		case 'primary' :
			$args = array(
				'theme_location'  => apply_filters( 'anva_primary_menu_location', 'primary' ),
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'menu_class'      => '',
				'menu_id'         => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'     => 'anva_primary_menu_fallback'
			);

			// Add walker to primary menu if mega menu support.
			if ( class_exists( 'Anva_Main_Menu_Walker' ) ) {
				$args['walker']   = new Anva_Main_Menu_Walker();
			}

			break;

		case 'top_bar' :
			$args = array(
				'menu_class'		=> '',
				'container' 		=> '',
				'fallback_cb' 		=> false,
				'theme_location'	=> apply_filters( 'anva_top_bar_menu_location', 'top_bar' ),
				'depth' 			=> 1
			);
			break;

		case 'footer' :
			$args = array(
				'menu_class'		=> '',
				'container' 		=> '',
				'fallback_cb' 		=> false,
				'theme_location'	=> apply_filters( 'anva_footer_menu_location', 'footer' ),
				'depth' 			=> 1
			);

	}

	return apply_filters( "anva_{$location}_menu_args", $args );
}

/**
 * List pages as a main navigation menu when user
 * has not set one under Apperance > Menus in the
 * WordPress admin panel.
 *
 * @since  1.0.0
 * @param  array       $args
 * @return string|html $output
 */
function anva_primary_menu_fallback( $args ) {

	$output = '';

	if ( $args['theme_location'] = apply_filters( 'anva_primary_menu_location', 'primary' ) && current_user_can( 'edit_theme_options' ) ) {
		$output .= sprintf( '<div class="menu-message"><strong>%s</strong>: %s</div>', esc_html__( 'No Custom Menu', 'anva' ), anva_get_local( 'menu_message' ) );
	}

	/**
	 * If the user doesn't set a nav menu, and you want to make
	 * sure nothing gets outputted, simply filter this to false.
	 * Note that by default, we only see a message if the admin
	 * is logged in.
	 *
	 * add_filter('anva_menu_fallback', '__return_false');
	 */
	if ( $output = apply_filters( 'anva_menu_fallback', $output, $args ) ) {
		echo $output;
	}
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

	$classes[] = 'has-lang-' . strtolower( get_bloginfo( 'language' ) );
	
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$single_post_reading_bar = anva_get_option( 'single_post_reading_bar' );
	if ( is_singular( 'post' ) && 'show' == $single_post_reading_bar ) {
		$classes[] = 'has-reading-bar';
	}


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
function anva_post_class( $class, $paged = true ) {

	$classes = array();

	// Set default post classes
	$default_classes = array(
		'index' => array(
			'default' => 'primary-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'archive' => array(
			'default' => 'archive-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'search' => array(
			'default' => 'search-post-list post-list',
			'paged' => 'post-list-paginated',
		),
		'grid' => array(
			'default' => 'template-post-grid post-grid grid-container',
			'paged' => 'post-grid-paginated',
		),
		'list' => array(
			'default' => 'template-post-list post-list post-list-container',
			'paged' => 'post-list-paginated',
		),
		'small' => array(
			'default' => 'template-post-small post-small post-small-container small-thumbs',
			'paged' => 'post-small-paginated',
		),
		'mansory' => array(
			'default' => 'template-post-mansory post-mansory post-mansory-container',
			'paged' => 'post-mansory-paginated',
		),
		// @TODO timeline classes
	);

	// Add default
	if ( isset( $default_classes[ $class ]['default'] ) ) {
		$classes[] = $default_classes[ $class ]['default'];
		
	}
	
	// Posts using pagination.
	if ( isset( $default_classes[ $class ]['paged'] ) && $paged ) {
		$classes[] = $default_classes[ $class ]['paged'];
	}

	$classes = implode( ' ', $classes );

	return apply_filters( 'anva_post_class', $classes );
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
* Display the classes for the header element.
*
* @since 1.0.0
* @param string|array $class
*/
function anva_primary_menu_class( $class = '' ) {
	echo 'class="' . join( ' ', anva_get_primary_menu_class( $class ) ) . '"';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * @since  1.0.0
 * @param  string|array $class
 * @return array        $classes
 */
function anva_get_primary_menu_class( $class = '' ) {

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
	$classes = apply_filters( 'anva_primary_menu_class', $classes, $class );

	return array_unique( $classes );
}

/**
 * Get header styles.
 *
 * @since  1.0.0
 * @return string|boolean
 */
function anva_get_header_type() {

	$types = anva_get_header_types();
	$header_type = anva_get_option( 'header_type', 'default' );

	if ( isset( $types[ $header_type ] ) ) {
		 return $types[ $header_type ]['type'];
	}

	return false;
}

/**
 * Print title in WP 4.0-.
 * Enable support in existing themes without breaking backwards compatibility.
 *
 * @since  1.0.0
 * @return string The site title.
 */
function anva_wp_title_compat() {
	// If WP 4.1+
	if ( function_exists( '_wp_render_title_tag' ) ) {
		return;
	}
	
	add_filter( 'wp_head', 'anva_wp_title' );
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
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

	return apply_filters( 'anva_wp_title', $title );
}

/**
 * Print page transition data.
 * 
 * @return string $data
 */
function anva_page_transition_data() {

	// Get loader data
	$loader        = anva_get_option( 'page_loader', 1 );
	$color         = anva_get_option( 'page_loader_color', 1 );
	$timeout       = anva_get_option( 'page_loader_timeout', 1000 );
	$speed_in      = anva_get_option( 'page_loader_speed_in', 800 );
	$speed_out     = anva_get_option( 'page_loader_speed_out', 800 );
	$animation_in  = anva_get_option( 'page_loader_animation_in', 'fadeIn' );
	$animation_out = anva_get_option( 'page_loader_animation_out', 'fadeOut' );
	$html          = anva_get_option( 'page_loader_html' );
	$data          = '';

	if ( $loader ) {
		$data .= 'data-loader="' . esc_attr( $loader ) . '"';
		$data .= 'data-loader-color="' . esc_attr( $color ) . '"';
		$data .= 'data-loader-timeout="' . esc_attr( $timeout ) . '"';
		$data .= 'data-speed-in="' . esc_attr( $speed_in ) . '"';
		$data .= 'data-speed-out="' . esc_attr( $speed_out ) . '"';
		$data .= 'data-animation-in="' . esc_attr( $animation_in ) . '"';
		$data .= 'data-animation-out="' . esc_attr( $animation_out ) . '"';
		
		if ( $html ) {
			$data .= 'data-loader-html="' . $html . '"';
		}
	}

	echo $data;
}

/**
 * Setup author page.
 *
 * @global $wp_query
 *
 * @since  1.0.0
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
 * Limit chars in string.
 *
 * @since  1.0.0
 * @param  $string
 * @param  $length
 * @return $string
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

/**
 * Convert HEX to RGB.
 * 
 * @param  string $hex
 * @return array  $color
 */
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
 * Get the excerpt and limit chars.
 *
 * @since 1.0.0
 */
function anva_get_excerpt( $length = '' ) {
	if ( ! empty( $length ) ) {
		$content = get_the_excerpt();
		$content = anva_truncate_string( $content, $length );
		return $content;
	}
	$content = get_the_excerpt();
	$content = wpautop( $content );
	return $content;
}

/**
 * Output excerpt.
 *
 * @since 1.0.0
 */
function anva_the_excerpt( $length = '' ) {
	echo anva_get_excerpt( $length );
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
 * Process any icons passed in as %icon%.
 *
 * @since  1.0.0
 * @param  string $string
 * @return string $string
 */
function anva_extract_icon( $string ) {

	preg_match_all( '/\%(.*?)\%/', $string, $icons );

	if ( ! empty( $icons[0] ) ) {

		$list = true;

		if ( substr_count( trim( $string ), "\n" ) ) {
			// If text has more than one line, we won't make into an inline list
			$list = false;
		}

		$total = count( $icons[0] );

		if ( $list ) {
			$string = sprintf( "<ul class=\"list-inline nobottommargin\">\n<li>%s</li>\n</ul>", $string );
		}

		foreach ( $icons[0] as $key => $val ) {

			$html = apply_filters( 'anva_extract_icon_html', '<i class="icon-%s"></i>', $string );

			if ( $list && $key > 0 ) {
				$html = "<li>\n" . $html;
			}

			$string = str_replace( $val, sprintf( $html, $icons[1][ $key ] ), $string );
		}
	}

	return $string;
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
	$path = trailingslashit( 'templates' );
	if ( empty( $slug ) ) {
		get_template_part( $path . $name );
		return;
	}
	get_template_part( $path . $slug, $name );
}

/**
 * Get core framework url.
 *
 * @since  1.0.0
 * @return string $uri
 */
function anva_get_core_uri() {
	$uri = trailingslashit( get_template_directory_uri() . '/framework' );
	if ( defined( 'ANVA_FRAMEWORK_URI' ) ) {
		$uri = ANVA_FRAMEWORK_URI;
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
	$uri = trailingslashit( get_template_directory_uri() . '/framework/admin' );
	if ( defined( 'ANVA_FRAMEWORK_ADMIN_URI' ) ) {
		$uri = ANVA_FRAMEWORK_ADMIN_URI;
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
	$path = trailingslashit( get_template_directory() . '/framework' );
	if ( defined( 'ANVA_FRAMEWORK_DIR' ) ) {
		$path = ANVA_FRAMEWORK_DIR;
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
	$path = trailingslashit( get_template_directory() . '/framework/admin' );
	if ( defined( 'ANVA_FRAMEWORK_ADMIN' ) ) {
		$path = ANVA_FRAMEWORK_ADMIN;
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