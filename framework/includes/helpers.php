<?php

/*
 * Home page args
 */
function anva_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

/*
 * Body classes
 * Adds a class of group-blog to blogs with more than 1 published author.
 */
function anva_body_class( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	$classes[] = anva_get_option( 'navigation' );
	$classes[] = 'lang-' . get_bloginfo( 'language' );
	return $classes;
}

/*
 * Return browser classes
 */
function anva_browser_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
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

/*
 * Return post classes
 */
function anva_post_classes() {
	
	$classes = array();
	$thumb 	 = anva_get_option( 'posts_thumb' );

	if ( is_home() ) {
		$classes[] = 'primary-post-list';
	}

	if ( is_archive() ) {
		$classes[] = 'archive-post-list';
	}

	$classes[] = 'post-list post-list-paginated';

	if ( 0 == $thumb ) {
		$classes[] = 'post-list-small';
	} elseif ( 1 == $thumb ) {
		$classes[] = 'post-list-large';
	}

	$classes = implode( ' ', $classes );
	
	echo apply_filters( 'anva_posts_classes', $classes );
}

/*
 * Display name and description in title
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

/*
 * Setup author page
 */
function anva_setup_author() {
	global $wp_query;
	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

/*
 * WP Query args
 */
function anva_get_post_query( $query_args = '' ) {
	$number = get_option( 'posts_per_page' );
	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$offset = ( $page - 1 ) * $number;
	if ( empty( $query_args ) ) {
		$query_args = array(
			'post_type'  			=>  array( 'post' ),
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> $number,
			'orderby'    			=> 'date',
			'order'      			=> 'desc',
			'number'     			=> $number,
			'page'       			=> $page,
			'offset'     			=> $offset
		);
	}
	$the_query = new WP_Query( $query_args );
	return $the_query;
}

/*
 * Add theme options menu to admin bar.
 */
function anva_settings_menu_link() {
	global $wp_admin_bar, $wpdb;
	
	if ( ! is_super_admin() || ! is_admin_bar_showing() )
		return;
	
	$wp_admin_bar->add_menu( array(
		'id' 			=> 'theme_settings_link',
		'parent' 	=> 'appearance',
		'title' 	=> anva_get_local( 'options' ),
		'href' 		=> home_url() . '/wp-admin/themes.php?page=theme-settings'
	));

}

/*
 * Return the post meta field 
 */
function anva_get_post_meta( $field ) {
	global $post;
	$meta = get_post_meta( $post->ID, $field, true );
	return $meta;
}

/*
 * Get custom meta fields
 */
function anva_get_post_custom() {
	global $post;
	$meta = get_post_custom( $post->ID );
	return $meta;
}

/*
 * Limit chars in string
 */
function anva_truncate_string( $string, $length = 100 ) {
	$string = trim( $string );
	if ( strlen( $string ) <= $length) {
		return $string;
	}
	else {
		$string = substr( $string, 0, $length ) . '...';
		return $string;
	}
}

/*
 * Limit chars in excerpt
 */
function anva_excerpt( $length = '' ) {
	if ( empty( $length ) ) {
		$length = 256;
	}
	$string = get_the_excerpt();
	$p = anva_truncate_string( $string, $length );
	echo wpautop( $p );
}

/*
 * Get posts in custom posts widget
 */
function anva_widget_posts_list( $number = 3, $orderby = 'date', $order = 'date', $thumbnail = true ) {
	global $post;

	$output = '';

	$args = array(
		'posts_per_page' 	=> $number,
		'post_type' 			=> array( 'post' ),
		'orderby'					=> $orderby,
		'order'						=> $order
	);

	$the_query = new WP_Query( $args );
	
	$output .= '<ul class="widget-posts-list">';

	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		if ( $thumbnail ) {
			$output .= '<li class="post-widget clearfix">';
			$output .= '<div class="post-image">';
			$output .= '<a href="'. get_permalink() .'">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a>';
			$output .= '</div>';
		} else {
			$output .= '<li class="post-widget clearfix">';
		}

		$output .= '<div class="post-content">';
		$output .= '<div class="post-title">';
		$output .= '<h4><a href="'. get_permalink() .'">' . get_the_title() . '</a></h4>';
		$output .= '</div>';
		$output .= '<div class="post-meta">';
		$output .= '<span class="post-date">' . get_the_time( 'F j, Y' ) . '</span>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</li>';
	}

	$output .= '</ul>';
	echo $output;
}

/*
 * Get current year in footer copyright
 */
function anva_get_current_year( $year ) {
	$current_year = date( 'Y' );
	return $year . ( ( $year != $current_year ) ? ' - ' . $current_year : '' );
}

/**
 * Compress a chunk of code to output.
 *
 * @param string $buffer Text to compress
 * @return array $buffer Compressed text
 */
function anva_compress( $buffer ) {

	// Remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

	// Remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

	return $buffer;
}

function anva_sort_gallery( $gallery_arr ) {
	
	$gallery_arr_sorted = array();
	$order = anva_get_option( 'gallery_order' );
	
	if ( ! empty( $order ) && ! empty ( $gallery_arr ) ) {
		
		switch ( $order ) {
			
			case 'drag':
				foreach( $gallery_arr as $key => $image ) {
					$gallery_arr_sorted[$key] = $image;
				}
				break;

			case 'desc':
				foreach( $gallery_arr as $key => $image ) {
					$image_meta = get_post( $image );
					$image_date = strtotime( $image_meta->post_date );	
					$gallery_arr_sorted[$image_date] = $image;
					krsort( $gallery_arr_sorted );
				}
				break;
			
			case 'asc':
				foreach( $gallery_arr as $key => $image) {
					$image_meta = get_post( $image );
					$image_date = strtotime( $image_meta->post_date );
					$gallery_arr_sorted[$image_date] = $image;
					ksort( $gallery_arr_sorted );
				}
				break;
			
			case 'rand':
				shuffle( $gallery_arr );
				$gallery_arr_sorted = $gallery_arr;
				break;
			
			case 'title':
				foreach( $gallery_arr as $key => $image ) {
					$image_meta = get_post( $image );
					$image_title = $image_meta->post_title;
					$gallery_arr_sorted[$image_title] = $image;
					ksort( $gallery_arr_sorted );
				}
				break;
		}
		
		return $gallery_arr_sorted;

	} else {
		return $gallery_arr;
	}
}

/*
 * Get templates part
 */
function anva_get_template_part( $name ) {
	$path = 'templates/';
	$part = 'template_';
	get_template_part( $path . $part . $name );
}

/*
 * Get framework url
 */
function anva_get_framework_url() {
	if ( defined( 'ANVA_FRAMEWORK_URL' ) ) {
		$url = ANVA_FRAMEWORK_URL;
	} else {
		$url = get_template_directory_uri() . '/framework';
	}
	return $url;
}

/*
 * Get templates part
 */
function anva_get_framework_directory() {
	if ( defined( 'ANVA_FRAMEWORK' ) ) {
		$path = ANVA_FRAMEWORK;
	} else {
		$path = get_template_directory_uri() . '/framework';
	}
	return $path;
}

function anva_textdomain() {
	$domain = 'anva';
	if ( defined( 'ANVA_DOMAIN' ) ) {
		$domain = ANVA_DOMAIN;
	}
	return $domain;
}

/*
 * Get media queries
 */
function anva_get_media_queries( $localize ) {
	$media_queries = array(
		'small' 		=> 320,
		'handheld' 	=> 480,
		'tablet' 		=> 768,
		'laptop' 		=> 992,
		'desktop' 	=> 1200
	);
	return array_merge( $localize, $media_queries );
}