<?php
/*-----------------------------------------------------------------------------------*/
/* General Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Make theme available for translations
 *
 * @since 1.0.0
 */
function anva_load_theme_texdomain() {
	load_theme_textdomain( 'anva', get_template_directory() . '/languages' );
}

/**
 * Add default theme support features
 *
 * @since 1.0.0
 */
function anva_add_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-header' );
}

/**
 * Add custom theme support features
 *
 * @since 1.0.0
 */
function anva_require_theme_supports() {
	require_if_theme_supports( 'anva-login-styles', ANVA_FRAMEWORK_EXT . 'class-login.php' );
	require_if_theme_supports( 'anva-megamenu', ANVA_FRAMEWORK_EXT . 'class-megamenu.php' );
	require_if_theme_supports( 'anva-woocommerce', ANVA_FRAMEWORK_EXT . 'woocommerce-config.php' );
}

/**
 * Enable support in existing themes without breaking backwards compatibility.
 *
 * @since  1.0.0.
 * @return string The site title.
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function anva_render_title() {
		echo "<title><?php wp_title( '|', true, 'right' ); ?></title>";
	}
	add_action( 'wp_head', 'anva_render_title' );
endif;

/**
 * Register menus
 *
 * @since 1.0.0
 */
function anva_register_menus() {
	register_nav_menus( array(
		'primary' 	=> anva_get_local( 'menu_primary' ),
		'secondary' => anva_get_local( 'menu_secondary' ),
		'tertiary'  => anva_get_local( 'menu_tertiary' ),
	) );
}

function anva_current_nav_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'current';
	}
	return $classes;
}

/**
 * Get theme data.
 *
 * @since  1.0.0
 * @param  string  $id
 * @return string  $text
 */
function anva_get_theme( $id ) {
	
	$text = null;
	$theme = wp_get_theme();

	$data = apply_filters( 'anva_theme_data', array(
		'name'       => $theme->get( 'Name' ),
		'uri'        => $theme->get( 'ThemeURI' ),
		'desc'       => $theme->get( 'Description' ),
		'version'    => $theme->get( 'Version' ),
		'domain'     => $theme->get( 'TextDomain' ),
		'author'     => $theme->get( 'Author' ),
		'author_uri' => $theme->get( 'AuthorURI' ),
	) );

	if ( isset( $data[ $id ] ) ) {
		$text = $data[ $id ];
	}

	return $text;
}

/**
 * Grid columns
 *
 * @since  1.0.0
 * @return array  $columns
 */
function anva_get_grid_columns() {
	$columns = array(
		'1' => array(
			'name'   => '1 Column',
			'class'  => 'col-md-12',
			'column' => 1,
		),
		'2' => array(
			'name'   => '2 Columns',
			'class'  => 'col-md-6',
			'column' => 2,
		),
		'3' => array(
			'name'   => '3 Columns',
			'class'  => 'col-md-4',
			'column' => 3
		),
		'4' => array(
			'name'   => '4 Columns',
			'class'  => 'col-md-3',
			'column' => 4
		),
		'5' => array(
			'name'   => '5 Columns',
			'class'  => 'col-5', // Extend Boostrap Columns
			'column' => 5
		),
		'6' => array(
			'name'   => '6 Columns',
			'class'  => 'col-md-2', // Extend Boostrap Columns
			'column' => 5
		),
	);
	return apply_filters( 'anva_grid_columns', $columns );
}

/**
 * Sidebar layouts.
 *
 * @since  1.0.0
 * @return array $layouts
 */
function anva_get_sidebar_layouts() {
	$layouts = array(
		'fullwidth' 		=> array(
			'name' 			=> 'Full Width',
			'id'			=> 'fullwidth',
			'columns'		=> array(
				'content' 	=> 'col_full nobottommargin clearfix',
				'left' 		=> '',
				'right' 	=> ''
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/fullwidth.png'
		),
		'right' 			=> array(
			'name' 			=> 'Sidebar Right',
			'id'			=> 'sidebar_right',
			'columns'		=> array(
				'content' 	=> 'postcontent nobottommargin clearfix',
				'left' 		=> '',
				'right' 	=> 'sidebar nobottommargin col_last clearfix'
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/right.png'
		),
		'left' 				=> array(
			'name' 			=> 'Sidebar Left',
			'id'			=> 'sidebar_left',
			'columns'		=> array(
				'content' 	=> 'postcontent nobottommargin col_last clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> ''
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/left.png'
		),
		'double' 			=> array(
			'name' 			=> 'Double Sidebars',
			'id'			=> 'double',
			'columns'		=> array(
				'content' 	=> 'postcontent bothsidebar nobottommargin clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> 'sidebar nobottommargin col_last clearfix'
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/double.png'
		),
		'double_right'		=> array(
			'name' 			=> 'Double Right Sidebars',
			'id'			=> 'double_right',
			'columns'		=> array(
				'content' 	=> 'postcontent bothsidebar nobottommargin clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> 'sidebar nobottommargin col_last clearfix'
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/double_right.png'
		),
		'double_left' 		=> array(
			'name' 			=> 'Double Left Sidebars',
			'id'			=> 'double_left',
			'columns'		=> array(
				'content' 	=> 'postcontent bothsidebar nobottommargin col_last clearfix',
				'left' 		=> 'sidebar nobottommargin clearfix',
				'right' 	=> 'sidebar nobottommargin clearfix'
			),
			'icon'			=> ANVA_FRAMEWORK_ADMIN_IMG . 'sidebar/double_left.png'
		)
	);
	return apply_filters( 'anva_sidebar_layouts', $layouts );
}

/**
 * Get layout column classes
 *
 * @since  1.0.0
 * @param  string  $column
 * @return string  $column_class
*/
function anva_get_column_class( $column ) {
	
	$layout = '';
	$column_class = '';
	$sidebar_layout = anva_get_sidebar_layouts();
	$current_layout = anva_get_post_meta( '_anva_sidebar_layout' );
	
	// Get sidebar location
	if ( isset( $current_layout['layout'] ) ) {
		$layout = $current_layout['layout'];
	}
	
	// Set default sidebar layout
	if ( empty( $layout ) ) {
		$layout = anva_get_option( 'sidebar_layout', 'right' );
	}

	// Validate if field exists
	if ( isset( $sidebar_layout[$layout]['columns'][$column] ) ) {
		$column_class = $sidebar_layout[$layout]['columns'][$column];
	}

	return apply_filters( 'anva_column_class', $column_class );
}

function anva_get_header_styles() {
	$header_styles = array(
		'default' 			=> array(
			'name' 			=> __( 'Default', 'anva' ),
			'id' 			=> 'default',
			'classes' 		=> array(
				'header'	=> 'full-header',
				'body'		=> ''
			),
			'type' 			=> 'sticky'
		),
		'transparent' 		=> array(
			'name'  		=> __( 'Transparent', 'anva' ),
			'id' 			=> 'transparent',
			'classes' 		=> array(
				'header'	=> 'transparent-header',
				'body'		=> ''
			),
			'type' 			=> 'sticky'
		),
		'semi_transparent' 	=> array(
			'name' 			=> __( 'Semi Transparent', 'anva' ),
			'id' 			=> 'semi_transparent',
			'classes' 		=> array(
				'header'	=> 'transparent-header semi-transparent full-header',
				'body'		=> ''
			),
			'type' 			=> 'sticky'
		),
		'floating' 			=> array(
			'name' 			=> __( 'Floating', 'anva' ),
			'id' 			=> 'floating',
			'classes' 		=> array(
				'header'	=> 'floating-header transparent-header',
				'body'		=> ''
			),
			'type' 			=> 'sticky'
		),
		'static_sticky' 	=> array(
			'name' 			=> __( 'Static Sticky', 'anva' ),
			'id' 			=> 'static_sticky',
			'classes' 		=> array(
				'header'	=> 'full-header static-sticky',
				'body'		=> ''
			),
			'type' 			=> 'sticky'
		),
		'responsive_sticky' => array(
			'name' 			=> __( 'Responsive Sticky', 'anva' ),
			'id' 			=> 'responsive_sticky',
			'classes' 		=> array(
				'header'	=> '',
				'body'		=> 'responsive-sticky-menu'
			),
			'type' 			=> 'sticky'
		),
		'left_side_fixed' 	=> array(
			'name' 			=> __( 'Left Side Fixed', 'anva' ),
			'id' 			=> 'left_side_fixed',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header'
			),
			'type' 			=> 'side'
		),
		'left_side_open' 	=> array(
			'name' 			=> __( 'Left Side Open', 'anva' ),
			'id' 			=> 'left_side_open',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header open-header close-header-on-scroll'
			),
			'type' 			=> 'side'
		),
		'left_side_push' 	=> array(
			'name' 			=> __( 'Left Side Push Content', 'anva' ),
			'id' 			=> 'left_side_push',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header open-header push-wrapper close-header-on-scroll'
			),
			'type' 			=> 'side'
		),
		'right_side_fixed' 	=> array(
			'name' 			=> __( 'Right Side Fixed', 'anva' ),
			'id' 			=> 'right_side_fixed',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header side-header-right'
			),
			'type' 			=> 'side'
		),
		'right_side_open' 	=> array(
			'name' 			=> __( 'Right Side Open', 'anva' ),
			'id' 			=> 'right_side_open',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header side-header-right open-header close-header-on-scroll'
			),
			'type' 			=> 'side'
		),
		'right_side_push' 	=> array(
			'name' 			=> __( 'Right Side Push Content', 'anva' ),
			'id' 			=> 'right_side_push',
			'classes' 		=> array(
				'header'	=> 'no-sticky',
				'body'		=> 'side-header side-header-right open-header push-wrapper close-header-on-scroll'
			),
			'type' 			=> 'side'
		),
	);

	return apply_filters( 'anva_header_styles', $header_styles );
}

/**
 * Setup the config array for which
 * features the framework supports
 * 
 * @since 1.0.0
 */
function anva_setup() {
	$setup = array(
		'featured' => array(
			'archive' => false,
			'front'   => false,
			'blog'    => false,
			'grid'    => false,
			'page'    => false,
			'single'  => false
		),
	);

	if ( is_front_page() ) {
		$setup['featured']['front'] = true;
	}

	if ( is_home() ) {
		$setup['featured']['blog'] = true;
	}

	if ( is_page() ) {
		$setup['featured']['page'] = true;
	}

	if ( is_single() ) {
		$setup['featured']['single'] = true;
	}

	return apply_filters( 'anva_setup', $setup );
}

/**
 * Test whether an feature is currently supported
 *
 * @since 1.0.0
 */
function anva_supports( $group, $feature ) {

	$setup = anva_setup();
	$supports = false;

	if ( ! empty( $setup ) && ! empty( $setup[$group][$feature] ) ) {
		$supports = true;
	}

	return $supports;
}

/**
 * Run warning if function is deprecated and WP_DEBUG is on.
 *
 * @since  1.0.0
 * @param  string $function
 * @param  string $version
 * @param  string $replacement
 * @param  string $message
 * @return string trigger_error()
 */
function anva_deprecated_function( $function, $version, $replacement = null, $message = null ) {
	if ( WP_DEBUG && apply_filters( 'deprecated_function_trigger_error', true ) ) {
		if ( ! is_null( $message ) ) {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework! %3$s', 'anva' ), $function, $version, $message ) );
		} elseif ( ! is_null( $replacement ) ) {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework! Use %3$s instead.', 'anva' ), $function, $version, $replacement ) );
		} else {
			trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s of the Anva Framework with no alternative available.', 'anva' ), $function, $version ) );
		}
	}
}

/**
 * Generates default column widths for column element.
 * 
 * @since  1.0.0
 * @return array $widths
 */
function anva_column_widths() {
	$widths = array(
		'1-col' => array(
			array(
				'name' 	=> '100%',
				'value' => 'col_full',
			)
		),
		'2-col' => array(
			array(
				'name' 	=> '20% | 80%',
				'value' => 'col_fifth_one,col_fifth_4',
			),
			array(
				'name' 	=> '25% | 75%',
				'value' => 'grid_3,grid_9',
			),
			array(
				'name' 	=> '30% | 70%',
				'value' => 'grid_tenth_3,grid_tenth_7',
			),
			array(
				'name' 	=> '33% | 66%',
				'value' => 'grid_4,grid_8',
			),
			array(
				'name' 	=> '50% | 50%',
				'value' => 'grid_6,grid_6',
			),
			array(
				'name' 	=> '66% | 33%',
				'value' => 'grid_8,grid_4',
			),
			array(
				'name' 	=> '70% | 30%',
				'value' => 'grid_tenth_7,grid_tenth_3',
			),
			array(
				'name' 	=> '75% | 25%',
				'value' => 'grid_9,grid_3',
			),
			array(
				'name' 	=> '80% | 20%',
				'value' => 'grid_fifth_4,grid_fifth_1',
			)
		),
		'3-col' => array(
			array(
				'name' 	=> '33% | 33% | 33%',
				'value' => 'col_one_third,col_one_third,col_one_third',
			),
			array(
				'name' 	=> '25% | 25% | 50%',
				'value' => 'grid_3,grid_3,grid_6',
			),
			array(
				'name' 	=> '25% | 50% | 25%',
				'value' => 'grid_3,grid_6,grid_3',
			),
			array(
				'name' 	=> '50% | 25% | 25% ',
				'value' => 'grid_6,grid_3,grid_3',
			),
			array(
				'name' 	=> '20% | 20% | 60%',
				'value' => 'grid_fifth_1,grid_fifth_1,grid_fifth_3',
			),
			array(
				'name' 	=> '20% | 60% | 20%',
				'value' => 'grid_fifth_1,grid_fifth_3,grid_fifth_1',
			),
			array(
				'name' 	=> '60% | 20% | 20%',
				'value' => 'grid_fifth_3,grid_fifth_1,grid_fifth_1',
			),
			array(
				'name' 	=> '40% | 40% | 20%',
				'value' => 'grid_fifth_2,grid_fifth_2,grid_fifth_1',
			),
			array(
				'name' 	=> '40% | 20% | 40%',
				'value' => 'grid_fifth_2,grid_fifth_1,grid_fifth_2',
			),
			array(
				'name' 	=> '20% | 40% | 40%',
				'value' => 'grid_fifth_1,grid_fifth_2,grid_fifth_2',
			),
			array(
				'name' 	=> '30% | 30% | 40%',
				'value' => 'grid_tenth_3,grid_tenth_3,grid_fifth_2',
			),
			array(
				'name' 	=> '30% | 40% | 30%',
				'value' => 'grid_tenth_3,grid_fifth_2,grid_tenth_3',
			),
			array(
				'name' 	=> '40% | 30% | 30%',
				'value' => 'grid_fifth_2,grid_tenth_3,grid_tenth_3',
			)
		),
		'4-col' => array(
			array(
				'name' 	=> '25% | 25% | 25% | 25%',
				'value' => 'grid_3,grid_3,grid_3,grid_3',
			),
			array(
				'name' 	=> '20% | 20% | 20% | 40%',
				'value' => 'grid_fifth_1,grid_fifth_1,grid_fifth_1,grid_fifth_2',
			),
			array(
				'name' 	=> '20% | 20% | 40% | 20%',
				'value' => 'grid_fifth_1,grid_fifth_1,grid_fifth_2,grid_fifth_1',
			),
			array(
				'name' 	=> '20% | 40% | 20% | 20%',
				'value' => 'grid_fifth_1,grid_fifth_2,grid_fifth_1,grid_fifth_1',
			),
			array(
				'name' 	=> '40% | 20% | 20% | 20%',
				'value' => 'grid_fifth_2,grid_fifth_1,grid_fifth_1,grid_fifth_1',
			)
		),
		'5-col' => array(
			array(
				'name' 	=> '20% | 20% | 20% | 20% | 20%',
				'value' => 'grid_fifth_1,grid_fifth_1,grid_fifth_1,grid_fifth_1,grid_fifth_1',
			)
		)
	);
	return apply_filters( 'anva_column_widths', $widths );
}

/**
 * Get footer widget columns.
 * 
 * @since  1.0.0
 * @return array  $columns
 */
function anva_get_footer_widget_columns() {
	$columns = array(
		'footer_1' => array(
			'id'   => 'footer_1',
			'name' => __( 'Footer 1', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 1' ),
			'col'  => 1
		),
		'footer_2' => array(
			'id'   => 'footer_2',
			'name' => __( 'Footer 2', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 2' ),
			'col'  => 2
		),
		'footer_3' => array(
			'id'   => 'footer_3',
			'name' => __( 'Footer 3', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 3' ),
			'col'  => 3
		),
		'footer_4' => array(
			'id'   => 'footer_4',
			'name' => __( 'Footer 4', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 4' ),
			'col'  => 4
		),
		'footer_5' => array(
			'id'   => 'footer_5',
			'name' => __( 'Footer 5', 'anva' ),
			'desc' => sprintf( __( 'This is default placeholder for the "%s" location.', 'anva' ), 'Footer 5' ),
			'col'  => 5
		)
	);
	return apply_filters( 'anva_get_footer_widget_columns', $columns );
}

/**
 * Register footer sidebars based on number of columns.
 *
 * @since  1.0.0
 * @return void
 */
function anva_register_footer_sidebar_locations() {
	
	$footer = anva_get_option( 'footer_setup' );

	// Register footer locations
	if ( isset( $footer['num'] ) && $footer['num'] > 0 ) {
	
		$columns = anva_get_footer_widget_columns();
		
		foreach ( $columns as $key => $value ) {
			if ( isset( $value['col'] ) ) {
				anva_add_sidebar_location( $value['id'], $value['name'] );
				if ( $footer['num'] == $value['col'] ) {
					break;
				}
			}
		}
	}
}

/**
 * Display footer sidebat locations.
 *
 * @since  1.0.0
 * @return void
 */
function anva_display_footer_sidebar_locations() {

	$footer_setup = anva_get_option( 'footer_setup' );
	$widgets_columns = anva_get_footer_widget_columns();

	// Make sure there's actually a footer option in the theme setup
	if ( is_array( $footer_setup ) ) {

		// Only move forward if user has selected for columns to show
		if ( $footer_setup['num'] > 0 ) {

			// Build array of columns
			$i = 1;
			$columns = array();
			$num = $footer_setup['num'];
			while ( $i <= $num ) {
				if ( isset( $widgets_columns['footer_'. $i] ) ) {
					$columns[] = $widgets_columns['footer_'. $i]['id'];
				}
				$i++;
			}
			anva_columns( $num, $footer_setup['width'][$num], $columns );
		}
	}

}

/**
 * Display set of columns
 *
 * @since  1.0.0
 * @param  integer $num
 * @param  array   $widths
 * @param  array   $columns
 * @return void
 */
function anva_columns( $num, $widths, $columns ) {

	// Kill it if number of columns doesn't match the number of widths exploded from the string.
	$widths = explode( ',', $widths );
	if ( $num != count( $widths ) ) {
		return;
	}

	// Kill it if number of columns doesn't match the number of columns feed into the function.
	if ( $num != count( $columns ) ) {
		return;
	}

	// Last column's key
	$last = $num - 1;

	foreach ( $columns as $key => $column ) {
		// Set CSS classes for column
		$classes = 'grid_column ' . $widths[ $key ];
		if ( $last == $key ) {
			$classes .= ' col_last';
		}

		echo '<div class="' . esc_attr( $classes ) .'">';
		anva_display_sidebar( $column );
		echo '</div><!-- .grid_column (end) -->';
	}
}

/**
 * Get gallery templates.
 * 
 * @since  1.0.0
 * @return array  $templates
 */
function anva_gallery_templates() {
	$templates = array(
		'grid_2'  => array(
			'name'   => __( 'Gallery 2 Columns', 'anva' ),
			'id'     => 'grid_2',
			'layout' => array(
				'size' => 'anva_grid_2',
				'col'  => 'col-2'
			)
		),
		'grid_3'  => array(
			'name' => __( 'Gallery 3 Columns', 'anva' ),
			'id'	 => 'grid_3',
			'layout' => array(
				'size' => 'anva_grid_3',
				'col'	 => 'col-3'
			)
		),
		'grid_4'  => array(
			'name' => __( 'Gallery 4 Columns', 'anva' ),
			'id'	 => 'grid_4',
			'layout' => array(
				'size' => 'anva_sm',
				'col'	 => 'col-4'
			)
		),
		'grid_5'  => array(
			'name' => __( 'Gallery 5 Columns', 'anva' ),
			'id'	 => 'grid_5',
			'layout' => array(
				'size' => 'anva_sm',
				'col'	 => 'col-5'
			)
		),
		'grid_6'  => array(
			'name' => __( 'Gallery 6 Columns', 'anva' ),
			'id'	 => 'grid_6',
			'layout' => array(
				'size' => 'anva_sm',
				'col'	 => 'col-6'
			)
		)
	);
	return apply_filters( 'anva_gallery_templates', $templates );
}

/**
 * Return the post meta field
 * 
 * @since 1.0.0
 */
function anva_get_post_meta( $field ) {
	global $post;
	return get_post_meta( $post->ID, $field, true );
}

/**
 * Sort galleries
 *
 * @since  1.0.0
 * @param  array  $gallery
 * @return array  $gallery  The sorted galleries
 */
function anva_sort_gallery( $gallery ) {
	
	$sorted = array();
	$order = anva_get_option( 'gallery_sort' );
	
	if ( ! empty( $order ) && ! empty ( $gallery ) ) {
		
		switch ( $order ) {
			
			case 'drag':
				foreach( $gallery as $key => $attachment_id ) {
					$sorted[$key] = $attachment_id;
				}
				break;

			case 'desc':
				foreach( $gallery as $key => $attachment_id ) {
					$meta = get_post( $attachment_id );
					$date = strtotime( $meta->post_date );	
					$sorted[$date] = $attachment_id;
					krsort( $sorted );
				}
				break;
			
			case 'asc':
				foreach( $gallery as $key => $attachment_id ) {
					$meta = get_post( $attachment_id );
					$date = strtotime( $meta->post_date );	
					$sorted[$date] = $attachment_id;
					ksort( $sorted );
				}
				break;
			
			case 'rand':
				shuffle( $gallery );
				$sorted = $gallery;
				break;
			
			case 'title':
				foreach( $gallery as $key => $attachment_id ) {
					$meta = get_post( $attachment_id );
					$title = $meta->post_title;
					$sorted[$title] = $attachment_id;
					ksort( $sorted );
				}
				break;
		}
		
		return $sorted;

	}
	
	return $gallery;
}

/**
 * Get query posts args.
 *
 * @since  1.0.0
 * @return array The post list
 */
function anva_get_query_posts( $query_args = '' ) {
	
	$number = get_option( 'posts_per_page' );
	$page 	= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$offset = ( $page - 1 ) * $number;
	
	if ( empty( $query_args ) ) {
		$query_args = array(
			'post_type'  			=> array( 'post' ),
			'post_status' 			=> 'publish',
			'posts_per_page' 		=> $number,
			'orderby'    			=> 'date',
			'order'      			=> 'desc',
			'number'     			=> $number,
			'page'       			=> $page,
			'offset'     			=> $offset
		);
	}

	$query_args = apply_filters( 'anva_get_query_posts_args', $query_args );
	$query = new WP_Query( $query_args );
	
	return $query;
}

/**
 * Get admin modules.
 *
 * @since  1.0.0
 * @return array $modules
 */
function anva_get_admin_modules() {

	// Options page
	$args = anva_get_options_page_menu();
	$options_page = sprintf( 'themes.php?page=%s', $args['menu_slug'] );

	// Admin modules
	$modules = array(
		'options'	=> $options_page,
		'backup'	=> $options_page . '_backup'
	);

	return apply_filters( 'anva_admin_modules', $modules );
}

/**
 * Add items to admin menu bar.
 *
 * @global $awp_admin_bar
 *
 * @since  1.0.0
 * @return void
 */
function anva_admin_menu_bar() {

	global $wp_admin_bar;

	if ( is_admin() || ! method_exists( $wp_admin_bar, 'add_node' ) ) {
		return;
	}

	// Get all admin modules
	$modules = anva_get_admin_modules();

	if ( ! $modules ) {
		return;
	}

	$node = 'anva_node_optons';

	$default_node = array(
		'id'    => $node,
		'title' => __( 'Anva', 'anva' ),
		'meta'  => array( 'class' => 'anva-admin-bar-node' )
	);

	$wp_admin_bar->add_node( $default_node );

	// Theme Options
	if ( isset( $modules['options'] ) && current_user_can( anva_admin_module_cap( 'options' ) ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'		=> 'anva_theme_options',
				'title'		=> sprintf( '%1$s', __( 'Theme Options', 'anva' ) ),
				'href'		=> admin_url( $modules['options'] ),
				'parent' 	=> $node,
			)
		);
	}

	// Theme Backup
	if ( isset( $modules['backup'] ) && current_user_can( anva_admin_module_cap( 'backup' ) ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'	 	=> 'anva_theme_backup',
				'title'	 	=> sprintf( '%1$s', __( 'Theme Backup', 'anva' ) ),
				'href'	 	=> admin_url( $modules['backup'] ),
				'parent' 	=> $node,
			)
		);
	}

	if ( current_user_can( 'install_plugins' ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'		=> 'anva_theme_plugins',
				'title'		=> sprintf( '%1$s', __( 'Theme Plugins', 'anva' ) ),
				'href'		=> admin_url( 'themes.php?page=tgmpa-install-plugins' ),
				'parent' 	=> $node,
			)
		);
	}
}

/**
 * Contact email.
 * 
 * @todo Move to extensions
 *
 * @since  1.0.0
 * @return void
 */
function anva_contact_send_email() {

	global $email_sended_message;

	// Submit form
	if ( isset( $_POST['contact-submission'] ) && 1 == $_POST['contact-submission'] && wp_verify_nonce( 'contact_form_nonce', 'contact_form' ) ) {

		// Fields
		$name 		= $_POST['cname'];
		$email 		= $_POST['cemail'];
		$subject 	= $_POST['csubject'];
		$message 	= $_POST['cmessage'];
		$captcha 	= $_POST['ccaptcha'];
		
		// Validate name
		if ( sanitize_text_field( $name ) == '' ) {
			$has_error = true;
		}

		// Validate email
		if ( sanitize_email( $email ) == '' || ! is_email( $email ) ) {
			$has_error = true;
		}

		// Validate subject
		if ( sanitize_text_field( $subject ) == '' ) {
			$has_error = true;
		}

		// Validate message
		if ( sanitize_text_field( $message ) == '' ) {
			$has_error = true;
		}

		// Validate answer
		if ( sanitize_text_field( $captcha ) == '' ) {
			$has_error = true;
		}
		
		// Body Mail
		if ( ! isset( $has_error ) ) {

			// Change to dynamic
			$email_to = '';
			
			if ( ! isset( $email_to ) || ( $email_to == '' ) ) {
				$email_to = get_option( 'admin_email' );
			}
			
			$email_body		 = "";
			$email_body 	.= "Name: $name\n\n";
			$email_body 	.= "E-email: $email\n\n";
			$email_body 	.= "Message: \n\n$message";
			$email_subject 	 = '['. $subject . '] From ' . $name;
			$headers 		 = 'From: ' . $name . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email;
			
			wp_mail( $email_to, $email_subject, $email_body, $headers );

			$email_sent = true;
		}

	}

	if ( isset( $email_sent ) && $email_sent == true ) :

		$email_sended_message = anva_get_local( 'submit_message' );
		
		// Clear form after submit
		unset(
			$_POST['cname'],
			$_POST['cemail'],
			$_POST['csubject'],
			$_POST['cmessage'],
			$_POST['ccaptcha']
		);
		
	else :
		if ( isset( $has_error ) ) :
			$email_sended_message = anva_get_local( 'submit_error' );
		endif;
	endif;
}