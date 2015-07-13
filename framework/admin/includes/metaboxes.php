<?php

add_action( 'admin_print_scripts-post.php', 'anva_page_admin_print_scripts' );
add_action( 'admin_print_scripts-post-new.php', 'anva_page_admin_print_scripts' );

function anva_page_admin_print_scripts() {
	wp_enqueue_script( 'metaboxes-admin-scripts', anva_get_core_url() . '/assets/js/admin/admin.min.js' );
}

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
	// add_meta_box(
	// 	'anva_post_options_metaboxes',
	// 	__( 'Post Options', anva_textdomain() ),
	// 	'anva_post_options_metaboxes',
	// 	'post',
	// 	'side',
	// 	'default'
	// );
}

/**
 * Add the page meta boxes options
 */
function anva_page_options_metaboxes() {
	
	echo '<input type="hidden" name="anva_page_options_nonce" id="anva_page_options_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
	
	$output 				= '';
	$hide_titlte		= anva_get_post_meta( '_hide_title' );
	$grid_column 		= anva_get_post_meta( '_grid_column' );
	$sidebar_layout = anva_get_post_meta( '_sidebar_layout' );
	?>

	<div class="meta-wrapper">
		<div class="meta-input-wrapper meta-input-page-title">
			<label class="meta-label" for="hide_title"><?php echo __( 'Page Title:', anva_textdomain() ); ?></label>
			<p class="meta-description"><?php echo __( 'Select option to show or hide page title.', anva_textdomain() ); ?></p>
			<p class="meta-input">
				<select name="hide_title" class="widefat">
					<?php
						$titles = array(
							anva_get_local( 'page_title_show' ) => 'show',
							anva_get_local( 'page_title_hide' ) => 'hide'
						);
						foreach ( $titles as $key => $value ) {
							echo '<option '. selected( $hide_titlte, $value, false ).' value="'.$value.'">'.$key.'</option>';
						}
					?>
				</select>
			</p>
		</div>

		<div class="meta-input-wrapper meta-input-sidebar-layout">
			<label class="meta-label" for="sidebar_layout"><?php echo __( 'Sidebar Layouts:', anva_textdomain() ); ?></label>
			<p class="meta-description"><?php echo __( 'Select a sidebar layout.', anva_textdomain() ); ?></p>
			<p class="meta-input">
				<select name="sidebar_layout" class="widefat">
					<option value=""><?php esc_html_e( 'Default Sidebar Layout' ); ?></option>
					<?php
						$layouts = anva_sidebar_layouts();
						foreach ( $layouts as $key => $value ) {
							echo '<option '. selected( $sidebar_layout, $key, false ).' value="'. esc_attr( $key ) .'">'. esc_html( $value['name'] ) .'</option>';
						}
					?>
				</select>
			</p>
		</div>

		<div class="meta-input-wrapper meta-input-post-grid">
			<label class="meta-label" for="grid_column"><?php echo anva_get_local( 'post_grid' ); ?></label>
			<p class="meta-description"><?php echo __( 'Select a grid column for posts list.', anva_textdomain() ); ?></p>
			<p class="meta-input">
				<select name="grid_column" class="widefat">
					<option value=""><?php esc_html_e( 'Default Grid Columns' ); ?></option>
					<?php
						$columns = anva_grid_columns();
						foreach ( $columns as $key => $value ) {
							echo '<option '. selected( $grid_column, $key, false ).' value="'. esc_attr( $key ) .'">'. esc_html( $value['name'] ) .'</option>';
						}
					?>
				</select>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Save the Metabox Data
 */
function anva_page_options_save_meta( $post_id, $post ) {
	
	if ( isset( $_POST['anva_page_options_nonce'] ) && ! wp_verify_nonce( $_POST['anva_page_options_nonce'], plugin_basename(__FILE__) ) ) {
		return $post->ID;
	}
	
	if ( ! current_user_can( 'edit_post', $post->ID ) )
		return $post->ID;
	
	// Validate inputs
	if ( isset( $_POST['grid_column'] ) )
		$meta['_grid_column'] = $_POST['grid_column'];

	if ( isset( $_POST['hide_title'] ) )
		$meta['_hide_title'] = $_POST['hide_title'];

	if ( isset( $_POST['sidebar_layout'] ) )
		$meta['_sidebar_layout'] = $_POST['sidebar_layout'];

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