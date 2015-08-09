<?php

/*
 * Setup slideshows 
 */
function anva_slideshows_setup() {
	add_action( 'init', 'anva_slideshows_register' );
	add_action( 'admin_head', 'anva_slideshows_admin_icon' );	
	add_action( 'add_meta_boxes', 'anva_slideshows_add_meta' );
	add_action( 'save_post', 'anva_slideshows_save_meta', 1, 2 );
	add_action( 'manage_slideshows_posts_custom_column', 'anva_slideshows_add_columns' );
	add_filter( 'manage_edit-slideshows_columns', 'anva_slideshows_columns' );
}

/*
 * Register post type slideshows
 */
function anva_slideshows_register() {

	$labels = array(
		'name' 									=> __( 'Slideshows', anva_textdomain() ),
		'singular_name' 				=> __( 'Slide', anva_textdomain() ),
		'all_items' 						=> __( 'Todos los Slides', anva_textdomain() ),
		'add_new' 							=> __( 'A&ntilde;adir Nuevo Slide', anva_textdomain() ),
		'add_new_item' 					=> __( 'A&ntilde;adir Nuevo Slide', anva_textdomain() ),
		'edit_item' 						=> __( 'Editar Slide', anva_textdomain() ),
		'new_item' 							=> __( 'Nuevo Slide', anva_textdomain() ),
		'view_item' 						=> __( 'Ver Slide', anva_textdomain() ),
		'search_items' 					=> __( 'Buscar Slides', anva_textdomain() ),
		'not_found' 						=> __( 'Slide no Encontrado', anva_textdomain() ),
		'not_found_in_trash' 		=> __( 'No se Encontraron Slides en la Papelera', anva_textdomain() ),
		'parent_item_colon' 		=> '' );
	
	$args = array(
		'labels'               	=> $labels,
		'public'               	=> false,
		'publicly_queryable'   	=> false,
		'_builtin'             	=> false,
		'show_ui'              	=> true, 
		'query_var'            	=> false,
		'rewrite'              	=> false,
		'capability_type'      	=> 'post',
		'hierarchical'         	=> false,
		'menu_position'        	=> 26.6,
		'supports'             	=> array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies'           	=> array(),
		'has_archive'          	=> false,
		'show_in_nav_menus'    	=> false
	);

	register_post_type( 'slideshows', $args );
}

/*
 * Admin menu icon
 */
function anva_slideshows_admin_icon() {
	echo '<style>#adminmenu #menu-posts-slideshows div.wp-menu-image:before { content: "\f233"; }</style>';	
}

function anva_get_slideshows() {
	
	$args = array();

	// Main Slider
	$args['main'] = array(
		'name' 	=> 'Main Area',
		'size' 	=> 'slider_lg',
		'layout'=> 'boxed',
		'limit' => -1
	);

	$args['blog'] = array(
		'name' 	=> 'Blog Area',
		'size' 	=> 'slider_md',
		'limit' => -1
	);
	
	return apply_filters( 'anva_get_slideshows_args', $args );
}


/*
 * Output slides from slideshows array
 */
function anva_put_slideshows( $slug ) {
	
	$slug = strtolower( $slug );
	$slideshows = anva_get_slideshows();
	$slider_speed = anva_get_option( 'slider_speed' );
	$slider_control = anva_get_option( 'slider_control' );
	$slider_arrows = anva_get_option( 'slider_direction' );
	$slider_play = anva_get_option( 'slider_play' );
	$slider_animation = 'slide';
	$slider_animation_speed = '1000';
	
	// Set args
	$size 		= isset( $slideshows[$slug]['size'] ) ? $slideshows[$slug]['size'] : 'large';
	$orderby 	= isset( $slideshows[$slug]['orderby'] ) ? $slideshows[$slug]['orderby'] : "menu_order";
	$order 	 	= isset( $slideshows[$slug]['order'] ) ? $slideshows[$slug]['order'] : "ASC";
	$limit 	 	= isset( $slideshows[$slug]['limit'] ) ? $slideshows[$slug]['limit'] : "-1";

	// Default
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> $order,
		'orderby' 				=> $orderby,
		'meta_key' 				=> '_slider_id',
		'meta_value' 			=> $slug,
		'posts_per_page' 	=> $limit
	);
	
	// Output
	$html = "";
	
	$the_query = anva_get_query_posts( apply_filters( 'anva_put_slideshows_query_args', $query_args ) );

	if ( $the_query->have_posts() ) {
		$html .= '<div id="slider" class="fslider slider-boxed" data-animation="fade" data-thumbs="true" data-arrows="'. $slider_arrows .'" data-speed="'. $slider_animation_speed .'" data-pause="'. $slider_speed .'">';
		$html .= '<div id="slider-' . esc_attr( $slug ) . '" class="flexslider">';
		$html .= '<ul class="slides">';
		
		while ( $the_query->have_posts() ) {

			$the_query->the_post();
			
			$id 		= get_the_ID();
			$title 	= get_the_title();
			$desc 	= get_the_excerpt();
			$meta 	= anva_get_post_custom();
			$url 		= ( isset( $meta['_slider_link_url'][0] ) ? $meta['_slider_link_url'][0] : '' );
			$data 	= ( isset( $meta['_slider_data'][0] ) ? $meta['_slider_data'][0] : '' );
			$image  = anva_get_attachment_image( $id, 'blog_md' );
			$a_tag  = '<a href="' . esc_url( $url ) . '">';
			
			$html .= '<li data-thumb="'. esc_attr( $image ) .'">';
			$html .= '<div id="slide-' . esc_attr( $id ) . '" class="slide slide-'. esc_attr( $id ) .' slide-type-image">';
			
			if ( $slug == "attachments" ) {
				$html .= anva_get_attachment_image( $id, $size );
			
			} elseif ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $size , array( 'class' => 'slide-image' ) );

				// Close anchor
				if ( $url ) {
					$html .= '</a>';
				}
			}
			
			switch ( $data ) {
				case 'title':
					$html .= '<div class="slide-content no-desc">';
					$html .= '<h2 class="slide-title">'. esc_html( $title ) .'</h2>';
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="slide-content no-title">';
					$html .= '<div class="slide-desc">'. esc_html( $desc ) .'</div>';
					$html .= '</div>';
					break;

				case 'both':
					$html .= '<div class="slide-content">';
					$html .= '<h2 class="slide-title">'. esc_html( $title ) .'</h2>';
					$html .= '<div class="slide-desc">'. esc_html( $desc ) .'</div>';
					$html .= '</div>';
					break;
			}
	
			$html .= '</div><!-- #slide-' . $id . ' (end) -->';
			$html .= '</li>';
		}

		$html .= '</ul><!-- .slides (end) -->';
		$html .= '</div><!-- .flexslider (end) -->';
		$html .= '</div><!-- .fslider (end) -->';	
	}
	
	// Reset wp query
	wp_reset_query();

	return $html;
}

/*
 * Admin metabox
 */
function anva_slideshows_add_meta() {
	add_meta_box(
		'anva_slideshows_metabox',
		anva_get_local( 'slide_meta' ),
		'anva_slideshows_metabox',
		'slideshows',
		'normal',
		'default'
	);
}

/*
 * Metabox form
 */
function anva_slideshows_metabox() {
	
	global $post;

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'anva_slideshows_custom_box', 'anva_slideshows_custom_box_nonce' );
		
	$slideshows 			= anva_get_slideshows();
	$meta 						= anva_get_post_custom();
	$slider_id		 		= ( isset( $meta['_slider_id'][0] ) ? $meta['_slider_id'][0] : '' );
	$slider_link_url 	= ( isset( $meta['_slider_link_url'][0] ) ? $meta['_slider_link_url'][0] : '' );
	$slider_data			=	( isset( $meta['_slider_data'][0] ) ? $meta['_slider_data'][0] : '' );
	?>

	<table class="form-table">
		<tr>
			<th>
				<label for="slider_link_url">URL:</label>
			</th>
			<td>
				<input type="text" style="width:99%;" name="slider_link_url" value="<?php echo esc_attr( $slider_link_url ); ?>" />
			</td>
		</tr>
		<tr>
			<th>
				<label for="slider_id"><?php echo anva_get_local( 'slide_area' ); ?>:</label>
			</th>
			<td>
				<?php if ( $slideshows ) : ?>
					<select name="slider_id" style="width:99%;text-transform:capitalize;">
						<?php foreach ( $slideshows as $slide => $item ) : ?>
							<option value="<?php echo esc_attr( $slide ); ?>" <?php selected( $slider_id, $slide, true ); ?>><?php echo $item['name']; ?></option>
						<?php endforeach; ?>
					</select>
				<?php else : ?>
					<div style="color:red;">
						<?php anva_get_local( 'slide_message' ); ?>
					</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="slider_data"><?php echo anva_get_local( 'slide_content' ); ?>:</label>
			</th>
			<td>
				<select name="slider_data" style="width:99%;">
					<?php
						$select = array(
							'title' => anva_get_local('slide_title'),
							'desc' 	=> anva_get_local('slide_desc'),
							'both' 	=> anva_get_local('slide_show'),
							'hide' 	=> anva_get_local('slide_hide'),
						);
						foreach ( $select as $key => $value ) {
							echo '<option value="'.esc_attr( $key ).'" '. selected( $slider_data, $key, true ) .'>'. $value .'</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<?php
}

/*
 * Save metabox
 */
function anva_slideshows_save_meta( $post_id, $post ) {

	// Check if our nonce is set
	if ( ! isset( $_POST['anva_slideshows_custom_box_nonce'] ) )
		return $post_id;

	// Verify that the nonce is valid
	if ( ! wp_verify_nonce( $_POST['anva_slideshows_custom_box_nonce'], 'anva_slideshows_custom_box' ) )
		return $post_id;

	// If this is an autosave, our form has not been submitted
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;

	// Check the user's permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}
	
	if ( isset( $_POST['slider_link_url'] ) ) {
		update_post_meta( $post_id, '_slider_link_url', strip_tags( $_POST['slider_link_url'] ) );
	}
	
	if ( isset( $_POST['slider_id'] ) ) {
		update_post_meta( $post_id, '_slider_id', strip_tags( $_POST['slider_id'] ) );
	}

	if ( isset( $_POST['slider_data'] ) ) {
		update_post_meta( $post_id, '_slider_data', strip_tags( $_POST['slider_data'] ) );
	}

}

/*
 * Admin columns
 */
function anva_slideshows_columns( $columns ) {
	$columns = array(
		'cb'       => '<input type="checkbox" />',
		'image'    => anva_get_local( 'image' ),
		'title'    => anva_get_local( 'title' ),
		'ID'       => anva_get_local( 'slide_id' ),
		'order'    => anva_get_local( 'order' ),
		'link'     => anva_get_local( 'link' ),
		'date'     => anva_get_local( 'date' )
	);
	return $columns;
}

/*
 * Add admin coumns
 */
function anva_slideshows_add_columns( $column ) {
	
	global $post;
	
	$edit_link 		= get_edit_post_link( $post->ID );
	$meta 				= anva_get_post_custom();
	$slider_link 	= $meta['_slider_link_url'][0];
	$slider_id 		= $meta['_slider_id'][0];

	if ( $column == 'image' )
		echo '<a href="' . $edit_link . '" title="' . $post->post_title . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'alt' => $post->post_title  )  ) . '</a>';
	
	if ( $column == 'order' )
		echo '<a href="' . $edit_link . '">' . $post->menu_order . '</a>';
	
	if ( $column == 'ID' )
		echo $slider_id;
	
	if ( $column == 'link' )
		echo '<a href="' . $slider_link . '" target="_blank" >' . $slider_link . '</a>';		
}
