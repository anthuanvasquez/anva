<?php

/**
 * Make theme available for translations
 */
function anva_load_theme_texdomain() {
	load_theme_textdomain( anva_textdomain(), get_template_directory() . '/languages' );
}

/**
 * Add theme support features
 */
function anva_add_theme_support() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
}

/**
 * Register menus.
 */
function anva_register_menus() {
	register_nav_menus( array(
		'primary' 	=> anva_get_local( 'menu_primary' ),
		'secondary' => anva_get_local( 'menu_secondary' )
	));
}

/*
 * Get theme info
 */
function anva_get_theme( $id ) {
	
	$text = null;
	$theme = wp_get_theme();

	$data = array(
		'name' => $theme->get( 'Name' ),
		'uri' => $theme->get( 'ThemeURI' ),
		'desc' => $theme->get( 'Description' ),
		'version' => $theme->get( 'Version' ),
		'domain' => $theme->get( 'TextDomain' ),
		'author' => $theme->get( 'Author' ),
		'author_uri' => $theme->get( 'AuthorURI' ),
	);

	if ( isset( $data[$id]) ) {
		$text = $data[$id];
	}

	return $text;
}

/*
 * Grid columns
 */
function anva_grid_columns() {
	$columns = array(
		'1' => array(
			'name' => '1 Column',
			'class' => 'col-sm-12',
			'column'	=> 1,
		),
		'2' => array(
			'name' => '2 Columns',
			'class' => 'col-sm-6',
			'column'	=> 2,
		),
		'3' => array(
			'name' => '3 Columns',
			'class' => 'col-sm-4',
			'column' => 3
		),
		'4' => array(
			'name' => '4 Columns',
			'class' => 'col-sm-3',
			'column' => 4
		),
		'5' => array(
			'name' => '5 Columns',
			'class' => 'col-sm-5th', // Extend Boostrap Columns
			'column' => 5
		),
		'6' => array(
			'name' => '6 Columns',
			'class' => 'col-sm-6',
			'column' => 6
		),
	);
	return apply_filters( 'anva_grid_columns', $columns );
}

/*
 * Sidebar layouts
 */
function anva_sidebar_layouts() {
	$layouts = array(
		'fullwidth' 	=> array(
			'name' 			=> 'Full Width',
			'id'				=> 'fullwidth',
			'columns'		=> array(
				'content' => 'col-sm-12',
				'left' 		=> '',
				'right' 	=> ''
			)
		),
		'right' 			=> array(
			'name' 			=> 'Sidebar Right',
			'id'				=> 'sidebar_right',
			'columns'		=> array(
				'content' => 'col-sm-9',
				'left' 		=> '',
				'right' 	=> 'col-sm-3'
			)
		),
		'left' 				=> array(
			'name' 			=> 'Sidebar Left',
			'id'				=> 'sidebar_left',
			'columns'		=> array(
				'content' => 'col-sm-9',
				'left' 		=> 'col-sm-3',
				'right' 	=> ''
			)
		),
		'double' 			=> array(
			'name' 			=> 'Double Sidebars',
			'id'				=> 'double',
			'columns'		=> array(
				'content' => 'col-sm-6',
				'left' 		=> 'col-sm-3',
				'right' 	=> 'col-sm-3'
			)
		),
		'double_right'=> array(
			'name' 			=> 'Double Right Sidebars',
			'id'				=> 'double_right',
			'columns'		=> array(
				'content' => 'col-sm-6',
				'left' 		=> 'col-sm-3',
				'right' 	=> 'col-sm-3'
			)
		),
		'double_left' => array(
			'name' 			=> 'Double Left Sidebars',
			'id'				=> 'double_left',
			'columns'		=> array(
				'content' => 'col-sm-6',
				'left' 		=> 'col-sm-3',
				'right' 	=> 'col-sm-3'
			)
		)
	);
	return apply_filters( 'anva_sidebar_layouts', $layouts );
}

/*
 * Get layout column classes
*/
function anva_get_column_class( $column ) {
	
	$column_class 	 = '';
	$sidebar_layouts = anva_sidebar_layouts();
	$current_layout  = anva_get_field( 'anva_page_options', 'sidebar_layout' );
	
	// Set default sidebar layout
	if ( ! is_page() && ! is_single() || empty( $current_layout ) ) {
		$current_layout = anva_get_option( 'sidebar_layout', 'right' );
	}

	// Validate if field exists
	if ( isset( $sidebar_layouts[$current_layout]['columns'][$column] ) ) {
		$column_class = $sidebar_layouts[$current_layout]['columns'][$column];
	}

	return apply_filters( 'anva_column_class', $column_class );
}

/**
 * Setup the config array for which features the framework supports
 */
function anva_setup() {
	$setup = array(
		'featured' 			=> array(
			'archive'			=> false,
			'front'				=> false,
			'blog'				=> false,
			'grid'				=> false,
			'page'				=> false,
			'single'			=> false
		),
		'comments' 			=> array(
			'posts'				=> true,
			'pages'				=> false,
			'attachments'	=> false
		),
		'display' 			=> array(
			'responsive' 	=> true
		)
	);

	if ( is_front_page() ) {
		$setup['featured']['front'] = true;
	}

	if ( is_page() ) {
		$setup['featured']['front'] = false;
		$setup['comments']['posts'] = true;
	}

	return apply_filters( 'anva_setup', $setup );
}

/**
 * Test whether an feature is currently supported
 */
function anva_supports( $group, $feature ) {

	$setup = anva_setup();
	$supports = false;

	if ( ! empty( $setup ) && ! empty( $setup[$group][$feature] ) ) {
		$supports = true;
	}

	return $supports;
}

/*
 * Return meta field outside loop
 */
// function anva_get_field( $field ) {

// 	// Get post ID
// 	global $wp_query;

// 	$id 		 = $wp_query->post->ID;
// 	$prefix  = '_';
// 	$field   = get_post_meta( $id, $prefix . $field, true );

// 	if ( empty( $field ) ) {
// 		$field = '';
// 	}
	
// 	return $field;
// }

/**
 * Generates default column widths for column element
 */
function anva_column_widths() {
	$widths = array(
		'1-col' => array(
			array(
				'name' 	=> '100%',
				'value' => 'grid_12',
			)
		),
		'2-col' => array(
			array(
				'name' 	=> '20% | 80%',
				'value' => 'grid_fifth_1,grid_fifth_4',
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
				'value' => 'grid_4,grid_4,grid_4',
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

function anva_get_footer_widget_columns() {
	$columns = array(
		'footer_1' => array(
			'id' => 'footer_1',
			'name' => __( 'Footer 1', 'anva' ),
			'desc' => __( 'This the default placeholder for footer widgets.' ),
			'col' => 1
		),
		'footer_2' => array(
			'id' => 'footer_2',
			'name' => __( 'Footer 2', 'anva' ),
			'desc' => __( 'This the default placeholder for footer widgets.' ),
			'col' => 2
		),
		'footer_3' => array(
			'id' => 'footer_3',
			'name' => __( 'Footer 3', 'anva' ),
			'desc' => __( 'This the default placeholder for footer widgets.' ),
			'col' => 3
		),
		'footer_4' => array(
			'id' => 'footer_4',
			'name' => __( 'Footer 4', 'anva' ),
			'desc' => __( 'This the default placeholder for footer widgets.' ),
			'col' => 4
		),
		'footer_5' => array(
			'id' => 'footer_5',
			'name' => __( 'Footer 5', 'anva' ),
			'desc' => __( 'This the default placeholder for footer widgets.' ),
			'col' => 5
		)
	);
	return apply_filters( 'anva_get_footer_widget_columns', $columns );
}

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
 */
function anva_columns( $num, $widths, $columns ) {

	// Kill it if number of columns doesn't match the
	// number of widths exploded from the string.
	$widths = explode( ',', $widths );
	if ( $num != count( $widths ) ) {
		return;
	}

	// Kill it if number of columns doesn't match the
	// number of columns feed into the function.
	if ( $num != count( $columns ) ) {
		return;
	}

	// Last column's key
	$last = $num - 1;

	foreach ( $columns as $key => $column ) {
		// Set CSS classes for column
		$classes = 'grid_column ' . $widths[$key];
		if ( $last == $key ) {
			$classes .= ' grid_last';
		}

		echo '<div class="' . esc_attr( $classes ) .'">';
		anva_display_sidebar( $column );
		echo '</div><!-- .grid_column (end) -->';
	}
}

/*
 * Return the post meta field 
 */
function anva_get_post_meta( $field ) {
	global $post;
	$field = get_post_meta( $post->ID, $field, true );
	return $field;
	var_dump($field);
}

/*
 * Get custom meta fields
 */
function anva_get_post_custom() {
	global $post;
	$fields = get_post_custom( $post->ID );
	return $fields;
}

/**
 * Get query posts args
 *
 * @since   1.0.0
 * @package Anva
 * @param   array The query arguments.
 * @return  array The post list.
 */
function anva_get_query_posts( $query_args = '' ) {
	
	$number = get_option( 'posts_per_page' );
	$page 	= get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$offset = ( $page - 1 ) * $number;
	
	if ( empty( $query_args ) ) {
		$query_args = array(
			'post_type'  			=> array( 'post' ),
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> $number,
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

function anva_get_admin_modules() {

	// Options page
	$args = anva_get_admin_menu_settings();
	$options_page = sprintf( 'themes.php?page=%s', $args['menu_slug'] );

	// Admin modules
	$modules = array(
		'options'	=> $options_page,
		'backup'	=> $options_page . '_backup'
	);

	return apply_filters( 'anva_admin_modules', $modules );
}

/**
 * Add items to admin menu bar
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

	// Theme Options
	if ( isset( $modules['options'] ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'			=> 'anva_theme_options',
				'parent' 	=> 'appearance',
				'title'		=> __( 'Theme Options', anva_textdomain() ),
				'href'		=> admin_url( $modules['options'] )
			)
		);
	}

	// Theme Backup
	if ( isset( $modules['backup'] ) ) {
		$wp_admin_bar->add_node(
			array(
				'id'		 => 'anva_theme_backup',
				'parent' => 'appearance',
				'title'	 => __( 'Backup Options', anva_textdomain() ),
				'href'	 => admin_url( $modules['backup'] )
			)
		);
	}
}

/**
 * Contact email
 */
function anva_contact_send_email() {
	
	global $email_sended_message;

	// Submit form
	if ( isset( $_POST['contact-submission'] ) && 1 == $_POST['contact-submission'] ) {

		// Fields
		$name 		= $_POST['cname'];
		$email 		= $_POST['cemail'];
		$subject 	= $_POST['csubject'];
		$message 	= $_POST['cmessage'];
		$captcha 	= $_POST['ccaptcha'];
		
		// Validate name
		if ( empty( $name ) || sanitize_text_field( $name ) == '' ) {
			$has_error = true;
		}

		// Validate email
		if ( empty( $email ) || sanitize_email( $email ) == '' || ! is_email( $email ) ) {
			$has_error = true;
		}

		// Validate subject
		if ( empty( $subject ) || sanitize_text_field( $subject ) == '' ) {
			$has_error = true;
		}

		// Validate message
		if ( empty( $message ) || sanitize_text_field( $message ) == '' ) {
			$has_error = true;
		}

		// Validate answer
		if ( empty( $captcha ) || sanitize_text_field( $captcha ) == '' ) {
			$has_error = true;
		}
		
		// Body Mail
		if ( ! isset( $has_error ) ) {

			// Change to dynamic
			$email_to = '';
			
			if ( ! isset( $email_to ) || ( $email_to == '' ) ) {
				$email_to = get_option( 'admin_email' );
			}
			
			$email_subject 	= '[Contacto - '. $subject . '] De ' . $name;
			$email_body 		= "Nombre: $name\n\nEmail: $email\n\nMensaje: \n\n$message";
			$headers 				= 'De: ' . $name . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email;
			
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