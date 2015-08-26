<?php

class Anva_Slider {

	private static $instance = null;
	private $post_type = 'slideshows';
	private $taxonomy = 'slideshow_group';

	public static function instance() {
	
		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	function __construct() {
		
		$post_type = $this->post_type;

		add_action( 'init', array( $this, 'register' ) );
		add_action( 'manage_' . $post_type . '_posts_custom_column', array( $this, 'add_columns' ), 10, 2 );
		add_filter( 'manage_edit-' . $post_type . '_columns', array( $this, 'columns' ) );

	}

	public function slides() {
		
	}

	public function add_columns( $column, $post_id ) {

		global $post;
		
		switch ( $column ) {
			case 'image':
				$edit_link = get_edit_post_link( $post->ID );
				echo '<a href="' . esc_url( $edit_link ) . '" title="' . esc_attr( $post->post_title ) . '">' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'alt' => $post->post_title  )  ) . '</a>';
				break;

			case 'group':
				$terms = get_the_terms( $post->ID, $this->taxonomy );

				if ( ! empty( $terms ) ) {

					$output = array();

					foreach ( $terms as $term ) {
						$output[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, $this->taxonomy => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $this->taxonomy, 'display' ) )
						);
					}

					echo join( ', ', $output );
				} else {
					_e( 'No Slide Groups', 'anva' );
				}

				break;
		}
		
	}

	public function columns( $columns ) {

		$columns = array(
			'cb'    => '<input type="checkbox" />',
			'image' => __( 'Featured Image', 'anva' ),
			'title' => __( 'Slide Title', 'anva' ),
			'group' => __( 'Slide Group' ),
			'date'  => __( 'Date', 'anva' )
		);

		return $columns;
	}

	public function register() {

		$labels = array(
			'name' 									=> __( 'Slideshows', 'anva' ),
			'singular_name' 				=> __( 'Slide', 'anva' ),
			'all_items' 						=> __( 'All Slides', 'anva' ),
			'add_new' 							=> __( 'Add New Slide', 'anva' ),
			'add_new_item' 					=> __( 'Add New Slide', 'anva' ),
			'edit_item' 						=> __( 'Edit Slide', 'anva' ),
			'new_item' 							=> __( 'New Slide', 'anva' ),
			'view_item' 						=> __( 'View Slide', 'anva' ),
			'search_items' 					=> __( 'Search Slides', 'anva' ),
			'not_found' 						=> __( 'Slide not found', 'anva' ),
			'not_found_in_trash' 		=> __( 'No se Encontraron Slides en la Papelera', 'anva' ),
			'parent_item_colon' 		=> __( '', 'anva' )
		);
		
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
			'menu_icon'							=> 'dashicons-images-alt2',
			'supports'             	=> array( 'title', 'thumbnail' ),
			'taxonomies'           	=> array(),
			'has_archive'          	=> false,
			'show_in_nav_menus'    	=> false
		);

		register_post_type( $this->post_type, $args );

		$labels = array(			  
			'name' 									=> __( 'Slide Groups', 'anva' ),
			'singular_name' 				=> __( 'Slide Group', 'anva' ),
			'search_items' 					=> __( 'Search Slide Groups', 'anva' ),
			'all_items' 						=> __( 'All Slide Groups', 'anva' ),
			'parent_item' 					=> __( 'Parent Slide Group', 'anva' ),
			'parent_item_colon' 		=> __( 'Parent Slide Group:', 'anva' ),
			'edit_item' 						=> __( 'Edit Slide Group', 'anva' ), 
			'update_item' 					=> __( 'Update Slide Group', 'anva' ),
			'add_new_item' 					=> __( 'Add New Slide Group', 'anva' ),
			'new_item_name' 				=> __( 'New Slide Group Name', 'anva' ),
		); 							  
			
		register_taxonomy(
			$this->taxonomy,
			$this->post_type,
			array(
				'public'							=> true,
				'hierarchical' 				=> true,
				'labels'							=> $labels,
				'query_var' 					=> $this->taxonomy,
				'show_ui' 						=> true,
				'rewrite' 						=> array( 'slug' => $this->taxonomy, 'with_front' => false ),
			)
		);
	}

}

/*
 * Output slides from slideshows array
 */
function anva_standard_slider( $args = array() ) {

	$defaults = array(
		'id' => 'standard',
		'order' => 'ASC',
		'number' => -1,
		'term' => '',
		'size' => 'slide_full',
	);

	$args = wp_parse_args( $args, $defaults );

	$size = $args['size'];
	$pause = anva_get_option( 'slider_speed' );
	$arrows = anva_get_option( 'slider_direction' );
	$animation = 'slide';
	$speed = '1000';
	$thumbs = true;

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> $args['order'],
		'posts_per_page' 	=> $args['number'],
	);

	if ( isset( $args['term'] ) &&  ! empty( $args['term'] ) ) {
		$query_args['tax_query'] = array( array(
			'taxonomy' 	=> 'slideshow_group',
			'field'    	=> 'slug',
			'terms'    	=> $args['term'],
		));
	}

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	// Output
	$html = '';
	
	$query = anva_get_query_posts( $query_args );

	if ( $query->have_posts() ) {
		
		$html .= '<div class="fslider flex-thumb-grid grid-10" data-animation="' . esc_attr( $animation ) . '" data-thumbs="' . esc_attr( $thumbs ) . '" data-arrows="' . esc_attr( $arrows ) . '" data-speed="' . esc_attr( $speed ) . '" data-pause="'. esc_attr( $pause ) . '">';
		$html .= '<div class="flexslider">';
		$html .= '<ul class="slider-wrap slides">';
		
		while ( $query->have_posts() ) {

			$query->the_post();
			
			$id 		 = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_field( 'description' );
			$url 		 = anva_get_field( 'url' );
			$content = anva_get_field( 'content' );
			$image   = anva_get_featured_image( $id, 'blog_md' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';
			
			$html .= '<div class="slide slide-'. esc_attr( $id ) . '" data-thumb="'. esc_attr( $image ) .'">';
			
			if ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $size , array( 'class' => 'slide-image' ) );

				// Close anchor
				if ( $url ) {
					$html .= '</a>';
				}
			}
			
			switch ( $content ) {
				case 'title':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $title );
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $desc );
					$html .= '</div>';
					break;

				case 'both':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $title );
					$html .= '<span>' . esc_html( $desc ) . '</span>';
					$html .= '</div>';
					break;
			}
			
			$html .= '</div>';
		}

		// Reset wp query
		wp_reset_postdata();

		$html .= '</ul><!-- .slider-wrap (end) -->';
		$html .= '</div><!-- .flexslider (end) -->';
		$html .= '</div><!-- .fslider (end) -->';
	}

	echo $html;
}

function anva_owl_slider() {

	$html .= '<div id="slider" class="boxed-slider">';
	$html .= '<div id="oc-slider" class="owl-carousel">';
	$html .= '<a href="#"><img src="http://www.best-of-magazin.com/wp-content/uploads/2014/03/Aachen11-1140x500.jpg" alt="Slider"></a>';
	$html .= '<a href="#"><img src="http://www.best-of-magazin.com/wp-content/uploads/2014/03/Aachen11-1140x500.jpg" alt="Slider"></a>';
	$html .= '<a href="#"><img src="http://www.best-of-magazin.com/wp-content/uploads/2014/03/Aachen11-1140x500.jpg" alt="Slider"></a>';
	$html .= '<a href="#"><img src="http://www.best-of-magazin.com/wp-content/uploads/2014/03/Aachen11-1140x500.jpg" alt="Slider"></a>';
	$html .= '</div>';
	$html .= '</div>';

}

/**
 * Display slider
 *
 * @since 1.0.0
 */
function anva_sliders( $slider ) {

	// Kill it if there's no slider
	// if ( ! $slider ) {
	// 	printf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'No slider selected.', 'anva' ) );
	// 	return;
	// }

	$sliders = anva_get_sliders();

	var_dump($sliders);

	if ( ! isset( $sliders[$slider] ) ) {
		printf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'No slider found.', 'anva' ) );
		return;
	}

	// Get Slider ID
	$slider_id = $sliders[$slider];
	if ( ! $slider_id ) {
		printf( '<div class="alert warning"><p>%s</p></div>', __( 'No slider.', 'anva' ) );
		return;
	}

	// Gather info
	$type = get_post_meta( $slider_id, 'type', true );
	$settings = get_post_meta( $slider_id, 'settings', true );
	$slides = get_post_meta( $slider_id, 'slides', true );

	// Display slider based on its slider type
	do_action( 'anva_' . $type . '_slider', $slider, $settings, $slides );
}

/*
 * The main function to return Anva_Gallery instance
 */
function Anva_Slider() {
	return Anva_Slider::instance();
}

// Here We Go!
Anva_Slider();
