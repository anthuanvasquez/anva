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
function anva_body_classes( $classes ) {
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
function anva_get_widget_posts( $number = 3, $orderby = 'date', $order = 'date', $thumbnail = true ) {
	global $post;

	$output = '';

	$args = array(
		'posts_per_page' => $number,
		'post_type' => array( 'post' ),
		'orderby'	=> $orderby,
		'order'	=> $order
	);

	$the_query = new WP_Query( $args );
	
	echo '<ul class="widget-posts">';

	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		if ( $thumbnail ) {
			$output .= '<li class="post-widget clearfix">';
			$output .= '<a href="'. get_permalink() .'"><div class="thumbnail">' . get_the_post_thumbnail( $post->ID, 'thumbnail', $attr = '' ) . '</div></a>';
		} else {
			$output .= '<li class="post-widget clearfix">';
		}

		$output .= '<h4 class="post-title"><a href="'. get_permalink() .'">' . get_the_title() . '</a></h4>';
		$output .= '<span class="post-date">' . get_the_time( 'F j, Y' ) . '</span>';
		$output .= '</li>';
	}

	echo $output;
	echo '</ul>';
}

/*
 * Get current year in footer copyright
 */
function anva_get_current_year( $year ) {
	$current_year = date( 'Y' );
	return $year . ( ( $year != $current_year ) ? ' - ' . $current_year : '' );
}