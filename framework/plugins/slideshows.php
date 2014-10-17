<?php

// SETUP ACTIONS
function tm_slideshows_setup() {
	add_action( 'init', 'tm_slideshows_setup_init' );
	add_action( 'admin_head', 'tm_slideshows_admin_icon' );	
	add_action( 'add_meta_boxes', 'tm_slideshows_create_slide_metaboxes' );
	add_action( 'save_post', 'tm_slideshows_save_meta', 1, 2 );
	add_filter( 'manage_edit-slideshows_columns', 'tm_slideshows_columns' );
	add_action( 'manage_slideshows_posts_custom_column', 'tm_slideshows_add_columns' );
	add_shortcode( 'slideshows', 'tm_slideshows_shortcode' );
}

function tm_slideshows() {
	
	$args = array();
	$slider_speed = tm_get_option( 'slider_speed' );
	$slider_control = tm_get_option( 'slider_control' );
	$slider_direction = tm_get_option( 'slider_direction' );
	$slider_play = tm_get_option( 'slider_play' );

	$args['homepage'] = array(
		'size' 		=> 'thumbnail_slideshow',
		'options' => "
			animation: Modernizr.touch ? 'slide' : 'fade',
			animationSpeed: Modernizr.touch ? 400 : 1000,
			slideshowSpeed: '$slider_speed',
			controlNav: ($slider_control == 1 ? true : false),
			directionNav: ($slider_direction == 1 ? true : false),
			pausePlay: ($slider_play == 1 ? true : false),
			pauseText: '',
			playText: '',
			prevText: '',
			nextText: '',
			video: true,
			start: function(slider) {
				slider.removeClass('loading');
			}
	");
	
	$args['gallery'] = array(
		'size' => 'thumbnail_blog_large'
	);
	
	$args['attachments'] = array(
		'size' => 'thumbnail_blog_large'
	);
	
	return apply_filters( 'tm_slideshows', $args );
}

// Create Post Type
function tm_slideshows_setup_init() {

	$labels = array(
		'name' 									=> __( 'Slideshows', TM_THEME_DOMAIN ),
		'singular_name' 				=> __( 'Slide', TM_THEME_DOMAIN ),
		'all_items' 						=> __( 'Todos los Slides', TM_THEME_DOMAIN ),
		'add_new' 							=> __( 'A&ntilde;adir Nuevo Slide', TM_THEME_DOMAIN ),
		'add_new_item' 					=> __( 'A&ntilde;adir Nuevo Slide', TM_THEME_DOMAIN ),
		'edit_item' 						=> __( 'Editar Slide', TM_THEME_DOMAIN ),
		'new_item' 							=> __( 'Nuevo Slide', TM_THEME_DOMAIN ),
		'view_item' 						=> __( 'Ver Slide', TM_THEME_DOMAIN ),
		'search_items' 					=> __( 'Buscar Slides', TM_THEME_DOMAIN ),
		'not_found' 						=> __( 'Slide no Encontrado', TM_THEME_DOMAIN ),
		'not_found_in_trash' 		=> __( 'No se Encontraron Slides en la Papelera', TM_THEME_DOMAIN ),
		'parent_item_colon' 		=> '' );
	
	$args = array(
		'labels'               	=> $labels,
		'public'               	=> true,
		'publicly_queryable'   	=> true,
		'_builtin'             	=> false,
		'show_ui'              	=> true, 
		'query_var'            	=> true,
		'rewrite'              	=> apply_filters( 'tm_slideshows_post_type_rewite', array( "slug" => "slideshows" )),
		'capability_type'      	=> 'post',
		'hierarchical'         	=> false,
		'menu_position'        	=> 26.6,
		'supports'             	=> array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		'taxonomies'           	=> array(),
		'has_archive'          	=> true,
		'show_in_nav_menus'    	=> false
	);

	register_post_type( 'slideshows', $args );
}


// Admin Icon
function tm_slideshows_admin_icon() {
	echo '<style>#adminmenu #menu-posts-slideshows div.wp-menu-image:before { content: "\f233"; }</style>';	
}

// Show Slides
function tm_slideshows_slides( $slug ) {
	
	// Get slides area
	$rotators = tm_slideshows();
	
	// Set image size
	$image_size = isset( $rotators[ $slug ]['size']) ? $rotators[ $slug ]['size'] : 'large';

	// Order: orderby, order, limit
	$orderby = isset($rotators[ $slug ]['orderby']) ? $rotators[ $slug ]['orderby'] : "menu_order";
	$order = isset($rotators[ $slug ]['order']) ? $rotators[ $slug ]['order'] : "ASC";
	$limit = isset($rotators[ $slug ]['limit']) ? $rotators[ $slug ]['limit'] : "-1";

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
	
	query_posts( apply_filters( 'tm_slideshows_query_post_args', $query_args) );

	if ( have_posts() ) {
		$html .= '<div id="slider_wrapper_' . $slug . '" class="slider-wrapper slider-wrapper-' . $slug . '">';
		$html .= '<div id="slider_inner_' . $slug . '" class="slider-inner slider-inner-' . $slug . '">';
		$html .= '<ul class="slides">';
		
		while ( have_posts() ) {

			the_post();
		
			$url 	= get_post_meta( get_the_ID(), "_slider_link_url", true );
			$data = get_post_meta( get_the_ID(), "_slider_data", true );

			$a_tag_opening = '<a href="' . $url . '" title="' . the_title_attribute( array('echo' => false) ) . '" >';
						
			$html .= '<li>';
			$html .= '<div id="slide-' . get_the_ID() . '" class="slide slide-'. get_the_ID() .' slide-type-image">';
			
			if ( $slug == "attachments" ) {
				$html .= wp_get_attachment_image( get_the_ID(), $image_size );
			
			} else if ( has_post_thumbnail() ) {
				
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
					$html .= '<div class="slide-data">';
					$html .= '<h2 class="slide-title">';	

					if ( $url ) {
						$html .= $a_tag_opening;
					}

					$html .= get_the_title();

					if ( $url ) {
						$html .= '</a>';
					}

					$html .= '</h2>';
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="slide-data">';
					$html .= '<div class="slide-caption">';
					$html .= get_the_excerpt();
					$html .= '</div>';
					$html .= '</div>';
					break;

				case 'show':
					$html .= '<div class="slide-data">';
					$html .= '<h2 class="slide-title">';	

					if ( $url ) {
						$html .= $a_tag_opening;
					}

					$html .= get_the_title();

					if ( $url ) {
						$html .= '</a>';
					}

					$html .= '</h2>';
					$html .= '<div class="slide-caption">';
					$html .= get_the_excerpt();
					$html .= '</div>';
					$html .= '</div>';
					break;
			}
	
			$html .= '</div><!-- #slide-' . get_the_ID() . ' (end) -->';
			$html .= '</li>';
		}

		$html .= '</ul>';
		$html .= '</div><!-- #slider_inner_' . $slug . ' (end) -->';
		$html .= '</div><!-- #slider_wrapper_' . $slug . ' (end) -->';
		
		// Call Flexslider
		$html .= '<script>';
		$html .= 'jQuery(document).ready(function() {';
		$html .= "jQuery('#slider_inner_{$slug}').addClass('loading');";
		$html .= "jQuery('#slider_inner_{$slug}').flexslider({";
			
		if ( isset($rotators[ $slug ]['options']) && $rotators[ $slug ]['options'] != "" ) { 
			$html .= $rotators[ $slug ]['options'];
		} else {
			$html .="prevText: '', nextText: '',";
			$html .="start: function(slider){ slider.removeClass('loading'); }";
		}
		
		$html .= "});";
		$html .= "});";
		$html .= '</script>';		
	}
	
	wp_reset_query();
	
	return $html;
}

// Admin metabox
function tm_slideshows_create_slide_metaboxes() {
	add_meta_box(
		'tm_slideshows_metabox_1',
		tm_get_local( 'slide_meta' ),
		'tm_slideshows_metabox_1',
		'slideshows',
		'normal',
		'default'
	);
}

function tm_slideshows_metabox_1() {
	
	global $post;	
		
	$rotators 				= tm_slideshows();
	$slider_id		 		= get_post_meta( $post->ID, '_slider_id', true );
	$slider_link_url 	= get_post_meta( $post->ID, '_slider_link_url', true );
	$slider_data			=	get_post_meta( $post->ID, '_slider_data', true );
	?>
	
	<p><strong>URL:</strong></p>
	<p>
		<input type="text" style="width:99%;" name="slider_link_url" value="<?php echo esc_attr( $slider_link_url ); ?>" />
	</p>
	
	<p><strong><?php echo tm_get_local( 'slide_area' ); ?>:</strong></p>
	<p>

		<?php var_dump( $rotators ); ?>

		<?php if ( $rotators ) : ?>
			
		<select name="slider_id" style="width:99%;">
			<?php foreach ( $rotators as $rotator => $size ) : ?>
				<option value="<?php echo $rotator; ?>" <?php selected( $slider_id, $rotator, true ); ?>><?php echo $rotator ?></option>
			<?php endforeach; ?>
		</select>

		<?php else : ?>
			<div style="color:red;">
				<?php tm_get_local( 'slide_message' ); ?>
			</div>
		<?php endif; ?>
	</p>

	<?php
		$select = array(
			'title' => tm_get_local('slide_title'),
			'desc' 	=> tm_get_local('slide_desc'),
			'show' 	=> tm_get_local('slide_show'),
			'hide' 	=> tm_get_local('slide_hide')
		);
	?>
	
	<p><strong><?php echo tm_get_local( 'slide_content' ); ?>:</strong></p>
	<p><select name="slider_data" style="width:99%;">
		<?php
			foreach ( $select as $key => $value ) {
				echo '<option value="'.$key.'" '. selected( $slider_data, $key, true ) .'>'. $value .'</option>';
			}
		?>
	</select></p>
	
	<?php 
}

// SAVE THE EXTRA GOODS FROM THE SLIDE
function tm_slideshows_save_meta( $post_id, $post ) {
	
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

// ADMIN COLUMNS
function tm_slideshows_columns( $columns ) {
	$columns = array(
		'cb'       => '<input type="checkbox" />',
		'image'    => tm_get_local( 'image' ),
		'title'    => tm_get_local( 'title' ),
		'ID'       => tm_get_local( 'slide_id' ),
		'order'    => tm_get_local( 'order' ),
		'link'     => tm_get_local( 'link' ),
		'date'     => tm_get_local( 'date' )
	);
	return $columns;
}

function tm_slideshows_add_columns( $column ) {
	
	global $post;
	
	$edit_link = get_edit_post_link( $post->ID );
	$slider_link = get_post_meta( $post->ID, "_slider_link_url", true );
	$slider_id = get_post_meta( $post->ID, "_slider_id", true );

	if ( $column == 'image' )
		echo '<a href="' . $edit_link . '" title="' . $post->post_title . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'alt' => $post->post_title  )  ) . '</a>';
	
	if ( $column == 'order' )
		echo '<a href="' . $edit_link . '">' . $post->menu_order . '</a>';
	
	if ( $column == 'ID' )
		echo $slider_id;
	
	if ( $column == 'link' )

		echo '<a href="' . $slider_link . '" target="_blank" >' . $slider_link . '</a>';		
}

// SHORTCODE
function tm_slideshows_shortcode($atts, $content = null) {
	
	$slug = isset( $atts['slug'] ) ? $atts['slug'] : "attachments";
	
	$string = tm_get_local( 'slide_shortcode' );
	
	if ( ! $slug ) {
		return apply_filters( 'tm_slideshows_empty_shortcode', $string );
	}
	return tm_slideshows( $slug );
}