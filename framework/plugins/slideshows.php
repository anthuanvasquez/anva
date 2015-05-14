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
	add_shortcode( 'slideshows', 'anva_slideshows_shortcode' );
}

function anva_get_slideshows() {
	
	$args = array();
	$slider_speed = anva_get_option( 'slider_speed' );
	$slider_control = anva_get_option( 'slider_control' );
	$slider_direction = anva_get_option( 'slider_direction' );
	$slider_play = anva_get_option( 'slider_play' );
	$slide_animation = 'slide';
	$slide_animation_speed = '1000';

	// Main Slider
	$args['homepage'] = array(
		'name' => 'Homepage',
		'size' => 'slider_large',
		'type' => 'flexslider',
		'options' => "
			animation: '$slide_animation',
			animationSpeed: '$slide_animation_speed',
			slideshowSpeed: '$slider_speed',
			controlNav: ( $slider_control == 1 ? true : false ),
			directionNav: ( $slider_direction == 1 ? true : false ) ,
			pausePlay: ( $slider_play == 1 ? true : false ),
			pauseText: '',
			playText: '',
			prevText: '',
			nextText: '',
			useCSS: true,
			touch: true,
			video: true,
			start: function(slider) {
				slider.removeClass('loading');
			}
		"
	);

	// Attachments Slider	
	$args['attachments'] = array(
		'name' => 'Attachments',
		'size' => 'blog_large',
		'type' => 'flexslider',
		'options' => "
			controlNav: false,
			directionNav: true,
			pausePlay: false,
			smoothHeight: true,
			start: function(slider) {
				slider.removeClass('loading');
			}
		"
	);
	
	return apply_filters( 'anva_slideshows', $args );
}

/*
 * Register post type slideshows
 */
function anva_slideshows_register() {

	$labels = array(
		'name' 									=> __( 'Slideshows', ANVA_DOMAIN ),
		'singular_name' 				=> __( 'Slide', ANVA_DOMAIN ),
		'all_items' 						=> __( 'Todos los Slides', ANVA_DOMAIN ),
		'add_new' 							=> __( 'A&ntilde;adir Nuevo Slide', ANVA_DOMAIN ),
		'add_new_item' 					=> __( 'A&ntilde;adir Nuevo Slide', ANVA_DOMAIN ),
		'edit_item' 						=> __( 'Editar Slide', ANVA_DOMAIN ),
		'new_item' 							=> __( 'Nuevo Slide', ANVA_DOMAIN ),
		'view_item' 						=> __( 'Ver Slide', ANVA_DOMAIN ),
		'search_items' 					=> __( 'Buscar Slides', ANVA_DOMAIN ),
		'not_found' 						=> __( 'Slide no Encontrado', ANVA_DOMAIN ),
		'not_found_in_trash' 		=> __( 'No se Encontraron Slides en la Papelera', ANVA_DOMAIN ),
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

/*
 * Output slides from slideshows array
 */
function anva_slideshows_featured( $slug ) {
	
	// Get slides area
	$slideshows = anva_get_slideshows();
	
	// Set args
	$image_size = isset( $slideshows[$slug]['size'] ) ? $slideshows[$slug]['size'] : 'large';
	$orderby = isset( $slideshows[$slug]['orderby'] ) ? $slideshows[$slug]['orderby'] : "menu_order";
	$order 	 = isset( $slideshows[$slug]['order'] ) ? $slideshows[$slug]['order'] : "ASC";
	$limit 	 = isset( $slideshows[$slug]['limit'] ) ? $slideshows[$slug]['limit'] : "-1";

	// Default Query Args
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> $order,
		'orderby' 				=> $orderby,
		'meta_key' 				=> '_slider_id',
		'meta_value' 			=> $slug,
		'posts_per_page' 	=> $limit
	);
	
	// Attachments Query Args
	if ( $slug == "attachments" ) {
		$query_args['post_type'] = 'attachment';
		$query_args['post_parent'] = get_the_ID();
		$query_args['post_status'] = 'inherit';
		$query_args['post_mime_type'] = 'image';
		unset( $query_args['meta_value'] );
		unset( $query_args['meta_key'] );
	}
	
	// Output
	$html = "";
	
	$the_query = anva_get_post_query( apply_filters( 'anva_slideshows_query_args', $query_args ) );

	if ( $the_query->have_posts() ) {
		$html .= '<div id="slider">';
		$html .= '<div id="slider_wrapper_' . $slug . '" class="slider-wrapper slider-wrapper-' . $slug . '">';
		$html .= '<div id="slider_inner_' . $slug . '" class="slider-inner slider-inner-' . $slug . '">';
		$html .= '<ul class="slides">';
		
		while ( $the_query->have_posts() ) {

			$the_query->the_post();
			
			$meta = anva_get_post_custom();

			$url 	= ( isset( $meta['_slider_link_url'][0] ) ? $meta['_slider_link_url'][0] : '' );
			$data = ( isset( $meta['_slider_data'][0] ) ? $meta['_slider_data'][0] : '' );

			$a_tag_opening = '<a href="' . $url . '">';
						
			$html .= '<li>';
			$html .= '<div id="slide-' . get_the_ID() . '" class="slide slide-'. get_the_ID() .' slide-type-image">';
			
			if ( $slug == "attachments" ) {
				$html .= wp_get_attachment_image( get_the_ID(), $image_size );
			
			} elseif ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag_opening;
				}

				$html .= get_the_post_thumbnail( get_the_ID(), $image_size , array( 'class' => 'slide-thumbnail' ) );

				if ( $url ) {
					$html .= '</a>';
				}
			}
			
			switch ( $data ) {

				case 'title':
					$html .= '<div class="slide-caption no-description">';
					$html .= '<h2 class="slide-title">';
					$html .= get_the_title();
					$html .= '</h2>';
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="slide-caption no-title">';
					$html .= '<div class="slide-description">';
					$html .= get_the_excerpt();
					$html .= '</div>';
					$html .= '</div>';
					break;

				case 'show':
					$html .= '<div class="slide-caption">';
					$html .= '<h2 class="slide-title">';
					$html .= get_the_title();
					$html .= '</h2>';
					$html .= '<div class="slide-description">';
					$html .= get_the_excerpt();
					$html .= '</div>';
					$html .= '</div>';
					break;

			}
	
			$html .= '</div><!-- #slide-' . get_the_ID() . ' (end) -->';
			$html .= '</li>';
		}

		$html .= '</ul><!-- .slides (end) -->';
		$html .= '</div><!-- #slider_inner_' . $slug . ' (end) -->';
		$html .= '</div><!-- #slider_wrapper_' . $slug . ' (end) -->';
		$html .= '</div><!-- #slider (end) -->';	
	}
	
	// Reset wp query
	wp_reset_query();

	// Init Flexslider
	if ( 'flexslider' == $slideshows[$slug]['type'] ) {

		wp_enqueue_script( 'flexslider-js', get_template_directory_uri() . '/assets/js/vendor/jquery.flexslider.min.js', array( 'jquery' ), '', true );

		$html .= '<script>';
		$html .= 'jQuery(document).ready(function() {';
		$html .= "jQuery('#slider_inner_{$slug}').addClass('loading');";
		$html .= "jQuery('#slider_inner_{$slug}').flexslider({";
			
		if ( isset( $slideshows[$slug]['options'] ) && $slideshows[$slug]['options'] != "" ) { 
			$html .= $slideshows[$slug]['options'];
		} else {
			$html .="prevText: '', nextText: '',";
			$html .="start: function(slider){ slider.removeClass('loading'); }";
		}
		
		$html .= "});";
		$html .= "});";
		$html .= '</script>';

	// Init Slick JS
	} elseif( 'slick' == $slideshows[$slug]['type'] ) {

		wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/assets/js/vendor/slick.min.js', array( 'jquery' ), '', true );

		$html .= '<script>';
		$html .= 'jQuery(document).ready(function() {';
		$html .= "jQuery('#slider_inner_{$slug} .slides').slick({";
		$html .= "autoplay: true, autoplaySpeed: 7000, dots: true";
		$html .= "});";
		$html .= "});";
		$html .= '</script>';

	}

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
							'show' 	=> anva_get_local('slide_show'),
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

/*
 * Create slideshows shortcode
 */
function anva_slideshows_shortcode( $atts, $content = null ) {

	extract(shortcode_atts( array(
		'slug' => 'attachments',
	), $atts ));
	
	$string = anva_get_local( 'slide_shortcode' );
	
	if ( empty( $slug ) ) {
		return apply_filters( 'anva_slideshows_empty_shortcode', $string );
	}

	return anva_slideshows_featured( $slug );
}