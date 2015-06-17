<?php

/**
 * Add the page meta boxes
 */
function anva_add_page_options() {
	add_meta_box(
		'anva_page_options_metaboxes',
		anva_get_local( 'page_options' ),
		'anva_page_options_metaboxes',
		'page',
		'side',
		'default'
	);
}

/**
 * Add the page meta boxes options
 */
function anva_page_options_metaboxes() {

	global $post;
	
	echo '<input type="hidden" name="anva_page_options_nonce" id="anva_page_options_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	
	$output = '';
	$grid_columns = get_post_meta( $post->ID, '_grid_columns', true );
	$hide_titlte = get_post_meta( $post->ID, '_hide_title', true );
	$sidebar_column = get_post_meta( $post->ID, '_sidebar_column', true );	

	// Page title
	$output .= '<div id="page_title">';
	$output .= '<p>'.anva_get_local( 'page_title' ).'</p>';
	$output .= '<select name="_hide_title" class="widefat" />';
	
	$titles = array(
		anva_get_local( 'page_title_show' ) => 'show',
		anva_get_local( 'page_title_hide' ) => 'hide'
	);
	
	foreach ( $titles as $key => $value ) {
		$output .= '<option '. selected( $hide_titlte, $value, false ).' value="'.$value.'">'.$key.'</option>';
	}

	$output .= '</select>';
	$output .= '</div>';

	// Sidebar
	$output .= '<div id="sidebar_column">';
	$output .= '<p>'.anva_get_local( 'sidebar_title' ).'</p>';
	$output .= '<select name="_sidebar_column" class="widefat" />';
	
	$asides = array(
		anva_get_local( 'sidebar_right' ) 				=> 'right',
		anva_get_local( 'sidebar_left' ) 					=> 'left',
		anva_get_local( 'sidebar_fullwidth' ) 		=> 'fullwidth',
		anva_get_local( 'sidebar_double' ) 				=> 'double',
		anva_get_local( 'sidebar_double_left' ) 	=> 'double_left',
		anva_get_local( 'sidebar_double_right' ) 	=> 'double_right'
	);
	
	foreach ( $asides as $key => $value ) {
		$output .= '<option '. selected( $sidebar_column, $value, false ).' value="'.$value.'">'.$key.'</option>';
	}

	$output .= '</select>';
	$output .= '</div>';

	// Post Grid
	$output .= '<div id="post_grid" style="display:none">';
	$output .= '<p>'.anva_get_local( 'post_grid' ).'</p>';
	$output .= '<select name="_grid_columns" class="widefat" />';
	
	$columns = array(
		anva_get_local( 'grid_2_columns' ) => 2,
		anva_get_local( 'grid_3_columns' ) => 3,
		anva_get_local( 'grid_4_columns' ) => 4
	);

	foreach ( $columns as $key => $value ) {
		$output .= '<option '. selected( $grid_columns, $value, false ).' value="'.$value.'">'.$key.'</option>';
	}

	$output .= '</select>';
	$output .= '</div>';

	echo $output;

}

/**
 * Save the Metabox Data
 */
function anva_page_options_save_meta( $post_id, $post ) {
	
	if ( isset( $_POST['anva_page_options_nonce'] ) && ! wp_verify_nonce( $_POST['anva_page_options_nonce'], plugin_basename(__FILE__) ) ) {
		return $post->ID;
	}
	
	if ( !current_user_can( 'edit_post', $post->ID ) )
		return $post->ID;
	
	// Validate inputs
	if ( isset( $_POST['_grid_columns'] ) )
		$meta['_grid_columns'] = $_POST['_grid_columns'];

	if ( isset( $_POST['_hide_title'] ) )
		$meta['_hide_title'] = $_POST['_hide_title'];

	if ( isset( $_POST['_sidebar_column'] ) )
		$meta['_sidebar_column'] = $_POST['_sidebar_column'];

	// Validate all meta info
	if ( isset( $meta ) ) {
		foreach( $meta as $key => $value ) { 
			
			if ( $post->post_type == 'revision' )
				return;

			$value = implode( ',', (array)$value );
			
			if ( get_post_meta( $post->ID, $key, false ) ) {
				update_post_meta( $post->ID, $key, $value );
			} else {
				add_post_meta( $post->ID, $key, $value );
			}
			
			if ( ! $value )
				delete_post_meta( $post->ID, $key );
		}
	}
}