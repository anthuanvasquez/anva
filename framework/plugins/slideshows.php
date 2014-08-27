<?php


add_action( 'after_setup_theme', 'flexslider_setup' );

function flexslider_rotators() {
	
	$args = array();

	$args['homepage'] = array(
		'size' => 'thumbnail_slideshow',
		'options' => "
			animation: Modernizr.touch ? 'slide' : 'fade',
			animationSpeed: Modernizr.touch ? 400 : 1000,
			controlNav: true,
			directionNav: true,
			prevText: '',
			nextText: '',
			start: function(slider) {
				slider.removeClass('loading');
			}
	");
	
	$args['gallery'] = array(
		'size' => 'thumbnail_blog_large',
		'hide_slide_data' => true
	);
	
	$args['attachments'] = array(
		'size' => 'thumbnail_blog_large',
		'hide_slide_data' => true
	);
	
	return apply_filters( 'flexslider_rotators', $args );
}

// SETUP ACTIONS
function flexslider_setup() {
	add_action( 'init', 'flexslider_setup_init' );
	add_action( 'admin_head', 'flexslider_admin_icon' );	
	add_action( 'add_meta_boxes', 'flexslider_create_slide_metaboxes' );
	add_action( 'save_post', 'flexslider_save_meta', 1, 2 );
	add_filter( 'manage_edit-slideshows_columns', 'flexslider_columns' );
	add_action( 'manage_slideshows_posts_custom_column', 'flexslider_add_columns' );
	add_shortcode( 'flexslider', 'flexslider_shortcode' );
}

// INIT
function flexslider_setup_init() {
	// 'SLIDES' POST TYPE
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
		'rewrite'              	=> apply_filters( 'flexslider_post_type_rewite', array( "slug" => "slideshows" )),
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


// ADMIN: WIDGET ICONS
function flexslider_admin_icon() {
	echo '<style>#adminmenu #menu-posts-slideshows div.wp-menu-image:before { content: "\f233"; }</style>';	
}

// SHOW ROTATOR
function flexslider_rotator( $slug ) {
	
	// GET ALL ROTATORS
	$rotators = flexslider_rotators();
	
	// SET IMAGE SIZE: size
	$image_size = isset($rotators[ $slug ]['size']) ? $rotators[ $slug ]['size'] : 'large';

	// HIDE SLIDE TEXT: hide_slide_data
	$hide_slide_data = isset($rotators[ $slug ]['hide_slide_data']) ? true : false;
	
	// HEADING HTML ELEMENT: heading_tag
	$header_type = isset($rotators[ $slug ]['heading_tag']) ? $rotators[ $slug ]['heading_tag'] : "h2";
	
	// CAPTION HTML ELEMENT: hide_caption
	$hide_slide_caption = isset($rotators[ $slug ]['hide_slide_caption']) ? true : false;

	// ORDER BY PARAMS: orderby, order, limit
	$orderby = isset($rotators[ $slug ]['orderby']) ? $rotators[ $slug ]['orderby'] : "menu_order";
	$order = isset($rotators[ $slug ]['order']) ? $rotators[ $slug ]['order'] : "ASC";
	$limit = isset($rotators[ $slug ]['limit']) ? $rotators[ $slug ]['limit'] : "-1";

	// DEFAULT QUERY PARAMS
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> $order,
		'orderby' 				=> $orderby,
		'meta_key' 				=> '_slider_id',
		'meta_value' 			=> $slug,
		'posts_per_page' 	=> $limit
	);
	
	// IF ATTACHMENTS WE NEED THE POST PARENT
	if ( $slug == "attachments" ) {
		$query_args['post_type'] = 'attachment';
		$query_args['post_parent'] = get_the_ID();
		$query_args['post_status'] = 'inherit';
		$query_args['post_mime_type'] = 'image';
		unset( $query_args['meta_value'] );
		unset( $query_args['meta_key'] );
	}
	
	$html = "";
	
	query_posts( apply_filters( 'flexslider_query_post_args', $query_args) );

	if ( have_posts() ) {
		$html .= '<div id="flexslider_' . $slug . '_wrapper" class="flexslider-wrapper">';
		$html .= '<div id="flexslider_' . $slug . '" class="flexslider_' . $slug . ' flexslider">';
		$html .= '<ul class="slides">';
		
		while ( have_posts() ) { the_post();
		
			$url 		= get_post_meta( get_the_ID(), "_slider_link_url", true );
			$title 		= get_post_meta( get_the_ID(), "_slider_title", true );
			$excerpt 	= get_post_meta( get_the_ID(), "_slider_excerpt", true );
			$data 		= get_post_meta( get_the_ID(), "_slider_data", true );

			$a_tag_opening = '<a href="' . $url . '" title="' . the_title_attribute( array('echo' => false) ) . '" >';
			
			
			$html .= '<li>';
			$html .= '<div id="slide-' . get_the_ID() . '" class="slide">';
			
			if ( $slug == "attachments" ) {
				$html .= wp_get_attachment_image( get_the_ID(), $image_size );
			}
			else if ( has_post_thumbnail() ) {
				if ( $url ) { $html .= $a_tag_opening; }
				$html .= get_the_post_thumbnail( get_the_ID(), $image_size , array( 'class' => 'slide-thumbnail' ) );
				if ( $url ) { $html .= '</a>'; }
			}
			

			if ( '1' == $data ) {

				$html .= '<div class="slide-data">';				
				
				// Mostrar titulo para el slide
				if ( '1' == $title ) {

					$html .= '<' . $header_type . ' class="slide-title">';
				
					if ( $url ) { $html .= $a_tag_opening; }				
					$html .= get_the_title();
					if ( $url ) { $html .= '</a>'; }
				
					$html .= '</' . $header_type . '>';

				}
				
				// Mostrar descripcion para el slide
				if ( '1' == $excerpt ) {
					if ( ! $hide_slide_caption) {
						$html .= '<div class="slide-caption">';
						$html .= get_the_excerpt();
						$html .= '</div>';
					}
				}
				
				$html .= '</div>';
				
			}
	
			$html .= '</div><!-- #slide-' . get_the_ID() . ' -->';
			$html .= '</li>';
		}

		$html .= '</ul>';
		$html .= '</div><!-- #flexslider_' . $slug . ' -->';
		$html .= '</div><!-- #flexslider_' . $slug . '_wrapper -->';
		
		// INIT THE ROTATOR
		$html .= '<script>';
		$html .= 'jQuery(document).ready(function() {';
		$html .= "jQuery('#flexslider_{$slug}').addClass('loading');";
		$html .= "jQuery('#flexslider_{$slug}').flexslider({";
			
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

// ADMIN META BOX
function flexslider_create_slide_metaboxes() {
    add_meta_box(
		'flexslider_metabox_1',
		__( 'Slide Settings', 'flexslider-hg' ),
		'flexslider_metabox_1',
		'slideshows',
		'normal', 'default'
	);
}

function flexslider_metabox_1() {
	global $post;	
    
	$rotators 				= flexslider_rotators();
	$slider_id		 		= get_post_meta( $post->ID, '_slider_id', true );
	$slider_link_url 	= get_post_meta( $post->ID, '_slider_link_url', true );
	$slider_title			= get_post_meta( $post->ID, '_slider_title', true ); 
	$slider_excerpt		= get_post_meta( $post->ID, '_slider_excerpt', true );
	$slider_data			=	get_post_meta( $post->ID, '_slider_data', true );
	?>
	
	<p><strong>URL:</strong></p>
	<p>
		<input type="text" style="width:100%;" name="slider_link_url" value="<?php echo esc_attr( $slider_link_url ); ?>" />
	</p>
	
	<p><strong>Adjuntar A:</strong></p>
	<p>
		<?php if ( $rotators ) : ?>
			
		<select name="slider_id" style="width:100%">
			<?php foreach ( $rotators as $rotator => $size ) : ?>
				<option value="<?php echo $rotator; ?>" <?php selected( $slider_id, $rotator, true ); ?>><?php echo $rotator ?></option>
			<?php endforeach; ?>
		</select>

		<?php else : ?>
			<div style="color:red;">
				<?php _e( 'No se han configurado rotadores para los slideshows. Contacta con tu Desarrollador.', TM_THEME_DOMAIN ); ?>
			</div>
		<?php endif; ?>
	</p>

	<p><strong>Mostrar Titulo:</strong></p>
	<p>
		<input type="hidden" name="slider_title" value="0">
		<input type="checkbox" name="slider_title" value="1" <?php checked( $slider_title, 1, true ); ?>>
	</p>

	<p><strong>Mostrar Descripcion:</strong></p>
	<p>		
		<input type="hidden" name="slider_excerpt" value="0">
		<input type="checkbox" name="slider_excerpt" value="1" <?php checked( $slider_excerpt, 1, true ); ?>>
	</p>

	<p><strong>Mostrar Contenido:</strong></p>
	<p>		
		<input type="hidden" name="slider_data" value="0">
		<input type="checkbox" name="slider_data" value="1" <?php checked( $slider_data, 1, true ); ?>>
	</p>

	
	<?php 
}

// SAVE THE EXTRA GOODS FROM THE SLIDE
function flexslider_save_meta( $post_id, $post ) {
	
	if ( isset( $_POST['slider_link_url'] ) ) {
		update_post_meta( $post_id, '_slider_link_url', strip_tags( $_POST['slider_link_url'] ) );
	}
	
	if ( isset( $_POST['slider_id'] ) ) {
		update_post_meta( $post_id, '_slider_id', strip_tags( $_POST['slider_id'] ) );
	}

	if ( isset( $_POST['slider_title'] ) ) {
		update_post_meta( $post_id, '_slider_title', strip_tags( $_POST['slider_title'] ) );
	}

	if ( isset( $_POST['slider_excerpt'] ) ) {
		update_post_meta( $post_id, '_slider_excerpt', strip_tags( $_POST['slider_excerpt'] ) );
	}

	if ( isset( $_POST['slider_data'] ) ) {
		update_post_meta( $post_id, '_slider_data', strip_tags( $_POST['slider_data'] ) );
	}

}

// ADMIN COLUMNS
function flexslider_columns( $columns ) {
	$columns = array(
		'cb'       => '<input type="checkbox" />',
		'image'    => __( 'Image', TM_THEME_DOMAIN ),
		'title'    => __( 'Title', TM_THEME_DOMAIN ),
		'ID'       => __( 'Slide ID', TM_THEME_DOMAIN ),
		'order'    => __( 'Order', TM_THEME_DOMAIN ),
		'link'     => __( 'Link', TM_THEME_DOMAIN ),
		'date'     => __( 'Date', TM_THEME_DOMAIN )
	);
	return $columns;
}

function flexslider_add_columns( $column ) {
	global $post;
	
	$edit_link = get_edit_post_link( $post->ID );

	if ( $column == 'image' ) echo '<a href="' . $edit_link . '" title="' . $post->post_title . '">' . get_the_post_thumbnail( $post->ID, array( 60, 60 ), array( 'title' => trim( strip_tags(  $post->post_title ) ) ) ) . '</a>';
	if ( $column == 'order' ) echo '<a href="' . $edit_link . '">' . $post->menu_order . '</a>';
	if ( $column == 'ID' ) 		echo get_post_meta( $post->ID, "_slider_id", true );
	if ( $column == 'link' ) 	echo '<a href="' . get_post_meta( $post->ID, "_slider_link_url", true ) . '" target="_blank" >' . get_post_meta( $post->ID, "_slider_link_url", true ) . '</a>';		
}

// SHORTCODE
function flexslider_shortcode($atts, $content = null) {
	$slug = isset($atts['slug']) ? $atts['slug'] : "attachments";
	if( ! $slug ) {
		return apply_filters( 'flexslider_empty_shortcode', "Slide: Por favor incluye un 'slug' como parámetro e.j. [flexslider slug=homepage]" );
	}
	return flexslider_rotator( $slug );
}