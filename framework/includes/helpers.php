<?php

function tm_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

function tm_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	$classes[] = tm_get_option( 'navigation' );

	return $classes;
}

function tm_browser_class( $classes ) {
	
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
	if ( $is_lynx ) 		$classes[] = 'lynx';
	elseif ( $is_gecko ) 	$classes[] = 'gecko';
	elseif ( $is_opera ) 	$classes[] = 'opera';
	elseif ( $is_NS4 ) 		$classes[] = 'ns4';
	elseif ( $is_safari ) 	$classes[] = 'safari';
	elseif ( $is_chrome ) 	$classes[] = 'chrome';
	elseif ( $is_IE ) {
		$classes[] = 'ie';
		if ( preg_match( '/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) )
			$classes[] = 'ie'.$browser_version[1];
	} else {
		$classes[] = 'unknown';
	}
	
	if ( $is_iphone) $classes[] = 'iphone';
	
	if ( stristr( $_SERVER['HTTP_USER_AGENT'], "mac" ) ) {
		$classes[] = 'osx';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'], "linux" ) ) {
		$classes[] = 'linux';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'], "windows" ) ) {
		$classes[] = 'windows';
	}
	return $classes;
}

function tm_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( tm_get_local( 'page' ) .' %s', '_s' ), max( $paged, $page ) );
	}

	return $title;
}

function tm_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

// Get the current offset
function tm_get_offset() {

	$number = 10;
	$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	return 1 == $page ? ( $page - 1 ) : ( ( $page - 1 ) * $number );

}

/*
 * Add theme options menu to admin bar.
 */
function tm_settings_menu_link() {
	global $wp_admin_bar, $wpdb;
	
	if( ! is_super_admin() || ! is_admin_bar_showing() )
		return;
	
	$wp_admin_bar->add_menu( array(
		'id' 		=> 'theme_settings_link',
		'parent' 	=> 'appearance',
		'title' 	=> esc_html__( 'Opciones', TM_THEME_DOMAIN ),
		'href' 		=> home_url() . '/wp-admin/themes.php?page=theme-settings'
	));

}

/*
 * Get theme single option or all options.
 */
function tm_get_option( $id ) {

	$settings = unserialize( TM_THEME_SETTINGS );

	$option = '';

	if( ! empty( $id ) )
		if ( isset( $settings[$id] ) )
			$option = $settings[$id];
	else
		$option = $settings;

	return $option; 
}

function tm_get_widget_args( $id, $name, $description ) {
	
	$columns = '';

	if( 'home-sidebar' == $id || 'footer-sidebar' == $id ) {
		$columns = 'column-4';
	}

	$args = array(
		'id'            => $id,
		'name'          => tm_get_local( $name ),
		'description'		=> tm_get_local( $description ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$columns.'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	return apply_filters( 'tm_widget_args', $args );
}

/*
 * Limit chars in string
 * @since 1.5.0
 * @return $string
 */
function tm_truncate( $string, $length = 100 ) {

	$string = trim( $string );

	if ( strlen( $string ) <= $length) {
		return $string;
	}
	else {
		$string = substr( $string, 0, $length ) . '...';
		return $string;
	}

}

function tm_get_widget_posts( $number = 3, $orderby = 'date', $order = 'date', $thumbnail = true ) {
	global $post;

	$output = '';

	$args = array(
		'posts_per_page' => $number,
		'post_type' => array( 'post' ),
		'orderby'	=> $orderby,
		'order'	=> $order
	);

	$the_query = new WP_Query( $args );
	
	echo '<ul class="posts">';

	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		if ( $thumbnail ) {
			$output .= '<li class="group"><a href="'. get_permalink() .'">' . get_the_post_thumbnail( $post->ID, 'thumbnail', $attr = '' ) . '</a>';
		} else {
			$output .= '<li class="group">';
		}

		$output .= '<h4><a href="'. get_permalink() .'">' . get_the_title() . '</a></h4>';
		$output .= '<span class="post-date">' . get_the_time( 'F j, Y' ) . '</span>';
		$output .= '</li>';
	}

	echo $output;

	echo '</ul>';
}