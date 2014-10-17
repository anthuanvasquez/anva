<?php

// Add the Events Meta Boxes
function tm_add_page_options() {
	add_meta_box(
		'tm_page_options_metaboxes',
		tm_get_local( 'page_options' ),
		'tm_page_options_metaboxes',
		'page',
		'side',
		'default'
	);
}

function tm_page_options_metaboxes() {

	global $post;
	
	echo '<input type="hidden" name="tm_page_options_nonce" id="tm_page_options_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	
	$output = '';
	$grid_columns = get_post_meta( $post->ID, '_grid_columns', true );
	$hide_titlte = get_post_meta( $post->ID, '_hide_title', true );	

	// Page title
	$output .= '<div id="page_title">';
	$output .= '<p>'.tm_get_local( 'page_title' ).'</p>';
	$output .= '<select name="_hide_title" class="widefat" />';
	
	$titles = array(
		tm_get_local( 'paget_title_hide' ) => 'show',
		tm_get_local( 'paget_title_show' ) => 'hide'
	);
	
	foreach ( $titles as $key => $value ) {
		$output .= '<option '. selected( $hide_titlte, $value, false ).' value="'.$value.'">'.$key.'</option>';
	}

	$output .= '</select>';
	$output .= '</div>';

	// Post Grid
	$output .= '<div id="post_grid" style="display:none">';
	$output .= '<p>'.tm_get_local( 'post_grid' ).'</p>';
	$output .= '<select name="_grid_columns" class="widefat" />';
	
	$columns = array(
		tm_get_local( 'grid_2_columns' ) => 2,
		tm_get_local( 'grid_3_columns' ) => 3,
		tm_get_local( 'grid_4_columns' ) => 4
	);

	foreach ( $columns as $key => $value ) {
		$output .= '<option '. selected( $grid_columns, $value, false ).' value="'.$value.'">'.$key.'</option>';
	}

	$output .= '</select>';
	$output .= '</div>';

	echo $output;

}

// Save the Metabox Data
function tm_page_options_save_meta( $post_id, $post ) {
	
	if ( isset( $_POST['tm_page_options_nonce'] ) && ! wp_verify_nonce( $_POST['tm_page_options_nonce'], plugin_basename(__FILE__) ) ) {
		return $post->ID;
	}
	
	if ( !current_user_can( 'edit_post', $post->ID ) )
		return $post->ID;
	
	// Validate inputs
	if ( isset( $_POST['_grid_columns'] ) )
		$meta['_grid_columns'] = $_POST['_grid_columns'];

	if ( isset( $_POST['_hide_title'] ) )
		$meta['_hide_title'] = $_POST['_hide_title'];

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