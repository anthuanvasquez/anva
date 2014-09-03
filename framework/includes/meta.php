<?php

// Add the Events Meta Boxes
function tm_add_page_options() {
	add_meta_box(
		'tm_page_options_metaboxes',
		__('Opciones de Pagina', TM_THEME_DOMAIN),
		'tm_page_options_metaboxes',
		'page',
		'side',
		'default'
	);
}

function tm_page_options_metaboxes() {

	global $post;
	
	echo '<input type="hidden" name="tm_page_options_nonce" id="tm_page_options_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	
	$grid_columns = get_post_meta( $post->ID, '_grid_columns', true );
	
	echo '<p>Post Grid:</p>';
	echo '<select name="_grid_columns" class="widefat" />';
	
	$columns = array(
		'2 Columns' => 2,
		'3 Columns' => 3,
		'4 Columns' => 4
	);

	foreach ( $columns as $key => $value ) {
		echo '<option '. selected( $grid_columns, $value, false ).' value="'.$value.'">'.$key.'</option>';
	}

	echo '</select>';

}

// Save the Metabox Data
function tm_page_options_save_meta( $post_id, $post ) {
	
	if ( isset( $_POST['tm_page_options_nonce'] ) && ! wp_verify_nonce( $_POST['tm_page_options_nonce'], plugin_basename(__FILE__) ) ) {
		return $post->ID;
	}
	
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	
	if ( isset( $_POST['_grid_columns'] ) )
		$meta['_grid_columns'] = $_POST['_grid_columns'];

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