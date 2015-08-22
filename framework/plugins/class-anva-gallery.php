<?php

/*
 * Anva Gallery Class
 */
if ( ! class_exists( 'Anva_Gallery' ) ) :

class Anva_Gallery {

	/*
	 * A single instance of this class
	 */
	private static $instance = null;

	/*
	 * Image admin thumbnail size
	 */
	private $size = 150;

	/*
	 * Image thumbnail size width
	 */
	private $width = 150;

	/*
	 * Image thumbnail size height
	 */
	private $height = 150;

	/*
	 * Creates or returns an instance of this class
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/*
	 * Constructor
	 * Hook everything in.
	 */
	private function __construct() {
		
		$this->width  = 100;
		$this->height = 100;

		add_action( 'admin_print_scripts-post.php', array( $this, 'admin_print_scripts' ) );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'admin_print_scripts' ) );
		add_action( 'admin_print_styles', array( $this, 'admin_print_styles' ) );
		add_action( 'admin_head', array( $this, 'admin_icon' ) );
		add_action( 'init', array( $this, 'post_type' ) );

		add_image_size( 'anva_gallery_admin_thumb', $this->size, $this->size, true );
		add_image_size( 'anva_gallery_thumb', $this->width, $this->height, true );

		if ( is_admin() ) {
			add_action( 'add_meta_boxes', array( $this, 'add' ) );
			add_action( 'save_post', array( $this, 'save' ), 9, 1 );
			add_action( 'wp_ajax_anva_gallery_get_thumbnail', array( $this, 'ajax_get_thumbnail' ) );
			add_action( 'wp_ajax_anva_gallery_get_all_thumbnail', array( $this, 'ajax_get_all_attachments' ) );
		}
	}

	/*
	 * Admin scripts
	 */
	public function admin_print_scripts() {
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'anva-metaboxes-js', anva_get_core_url() . '/assets/js/admin/metaboxes.min.js' );
	}

	/*
	 * Amin stylesheets
	 */
	public function admin_print_styles() {
		wp_enqueue_style( 'anva-metaboxes', anva_get_core_url() . '/assets/css/admin/metaboxes.min.css' );
	}

	/*
	 * Adds the meta box container
	 */
	public function add() {
		
		$post_types = array( 'galleries' => 1 );
		$post_types = ( $post_types !== false ) ? $post_types : array( 'page' => '1', 'post' => '1' );

		foreach ( $post_types as $type => $value ) {
			if ($value == '1') {
				add_meta_box(
					'anva_gallery',
					__( 'Gallery Images', 'anva' ),
					array( $this, 'display' ),
					$type,
					'advanced',
					'default'
				);
			}
		}
	}

	/*
	 * Metabox advanced
	 */
	public function display( $post ) {
		
		$gallery = get_post_meta( $post->ID, '_anva_gallery_images', true );

		wp_nonce_field( 'anva_galleries_advanced_box', 'anva_galleries_advanced_box_nonce' );

		$upload_size_unit = $max_upload_size = wp_max_upload_size();
		$sizes = array( 'KB', 'MB', 'GB' );

		for ( $u = -1; $upload_size_unit > 1024 && $u < count( $sizes ) - 1; $u++ ) {
			$upload_size_unit /= 1024;
		}

		if ( $u < 0 ) {
			$upload_size_unit = 0;
			$u = 0;
		} else {
			$upload_size_unit = (int) $upload_size_unit;
		}

		$upload_action_url = admin_url( 'async-upload.php' );
		
		$post_params 	= array(
			'post_id' 	=> $post->ID,
			'_wpnonce' 	=> wp_create_nonce( 'media-form' ),
			'short' 		=> '1',
		);

		$post_params 	= apply_filters( 'upload_post_params', $post_params );

		$plupload_init = array(
			'runtimes' 						=> 'html5, silverlight, flash, html4',
			'browse_button' 			=> 'anva-plupload-browse-button',
			'file_data_name' 			=> 'async-upload',
			'multiple_queues' 		=> true,
			'max_file_size' 			=> $max_upload_size . 'b',
			'url' 								=> $upload_action_url,
			'flash_swf_url' 			=> includes_url( 'js/plupload/plupload.flash.swf'),
			'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
			'filters' 						=> array( array( 'title' => __( 'Allowed Files', 'anva' ), 'extensions' => '*' ) ),
			'multipart' 					=> true,
			'urlstream_upload' 		=> true,
			'multipart_params' 		=> $post_params
		);
		?>
		
		<div class="meta-wrapper">
			<div class="meta-input-wrapper meta-input-gallery">
				<span id="anva_gallery_spinner" class="spinner"></span>
				<div id="anva_gallery_container">
					<ul id="anva_gallery_thumbs">
						<?php
							$gallery = ( is_string( $gallery ) ) ? @unserialize( $gallery ) : $gallery;
							if ( is_array( $gallery ) && count( $gallery ) > 0 ) {
								foreach ( $gallery as $id ) {
									echo $this->admin_thumb( $id );
								}
							}
						?>
					</ul>
				</div>
				<div class="meta-input-actions">
					<input id="anva_gallery_upload_button" data-uploader_title="<?php echo __( 'Upload Image' ); ?>" data-uploader_button_text="Select" class="primary_button button button-primary" type="button" value="<?php echo __('Upload Image', 'anva'); ?>" rel="" />
					<input id="anva_gallery_delete_all_button" class="button secondary_button button-secondary" type="button" value="<?php echo __('Delete All Images', 'anva'); ?>" rel="" />
				</div>
				<script type="text/javascript">
					/* <![CDATA[ */
					var POST_ID = <?php echo $post->ID; ?>;
					var ANVAUploaderInit = <?php echo json_encode( $plupload_init ); ?>;
					/* ]]> */
				</script>
			</div>
		</div>

		<?php
	}

	/*
	 * Save the meta when the post is saved
	 */
	public function save( $post_id ) {

		// Check nonce fo advanced box
		if ( isset( $_POST['anva_galleries_advanced_box_nonce'] ) && wp_verify_nonce( $_POST['anva_galleries_advanced_box_nonce'], 'anva_galleries_advanced_box' ) ) {

			$images = ( isset( $_POST['anva_gallery_thumb'] ) ) ? $_POST['anva_gallery_thumb'] : array();
			$images_ids = array();
			
			if ( count( $images ) > 0 ) {
				foreach ( $images as $key => $attachment_id ) {
					if ( is_numeric( $attachment_id ) ) {
						$images_ids[] = $attachment_id;
					}
				}
			}

			update_post_meta( $post_id, '_anva_gallery_images', $images_ids );
		}

		return $post_id;
	}

	/*
	 * Get admin thumb
	 */
	private function admin_thumb( $id ) {
		$image = wp_get_attachment_image_src( $id, 'thumbnail', true );
		?>
		<li>
			<a class="anva_gallery_image" href="<?php echo esc_url( admin_url( '/post.php?post=' ) . $id . '&action=edit' ); ?>" target="_blank">
				<img src="<?php echo esc_url( $image[0] ); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
			</a>
			<a href="#" class="anva_gallery_remove">X</a>
			<input type="hidden" name="anva_gallery_thumb[]" value="<?php echo $id; ?>" />
		</li>
		<?php
	}

	/*
	 * Ajax get thumbnail
	 */
	public function ajax_get_thumbnail() {
		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		echo $this->admin_thumb( $_POST['imageid'] );
		die;
	}

	/*
	 * Ajax get attachments
	 */
	public function ajax_get_all_attachments() {
		
		$post_id = $_POST['post_id'];
		$included = ( isset( $_POST['included'] ) ) ? $_POST['included'] : array();

		// Do only if there are attachments of these qualifications
		$attachments = get_children( array(
			'post_parent' 		=> $post_id,
			'post_type' 			=> 'attachment',
			'numberposts' 		=> -1,
			'order' 					=> 'ASC',
			'post_mime_type' 	=> 'image', // MIME Type condition
		) );

		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		
		if ( count( $attachments ) > 0 ) {
			foreach ( $attachments as $a ) {
				if ( !in_array( $a->ID, $included ) ) {
					echo $this->admin_thumb( $a->ID );
				}
			}
		}

		die;
	}

	/*
	 * Get thumb data
	 */
	private function thumb( $id, $post_id ) {
		
		$info = get_posts( array(
			'p' 					=> $id,
			'post_type' 	=> 'attachment'
		));

		$url 						= wp_get_attachment_url( $id );
		$image 					= wp_get_attachment_image_src( $id );
		$string 				= '%title%';
		$alt 						= get_post_meta( $id, '_wp_attachment_image_alt', true );
		$data 					= array(
			'%title%' 		=> $info[0]->post_title,
			'%alt%' 			=> $alt,
			'%filename%' 	=> basename( $url ),
			'%caption%' 	=> $info[0]->post_excerpt,
			"\n" 					=> ' - '
		);

		$title = str_replace( array_keys( $data ), $data, $string );

		$html = sprintf(
			'<li><a href="%1$s" title="%2$s" data-gallery="gallery-group-%3$s"><img src="%4$s" width="%5$s" height="%6$s" alt="%7$s" /></a></li>',
			$url,
			$title,
			$post_id,
			$image[0],
			$image[1],
			$image[2],
			$info[0]->post_title
		);

		return $html;
	}

	/*
	 * Admin menu icon
	 */
	public function admin_icon() {
		echo '<style>#adminmenu #menu-posts-galleries div.wp-menu-image:before { content: "\f161"; }</style>';	
	}

	/*
	 * Register galleries post type
	 */
	public function post_type() {
		
		$labels = array(
			'name' 								=> __( 'Galleries', 'anva' ),
			'singular_name' 			=> __( 'Gallery', 'anva' ),
			'add_new' 						=> __( 'Add New Gallery', 'anva' ),
			'add_new_item' 				=> __( 'Add New Gallery', 'anva' ),
			'edit_item' 					=> __( 'Edit Gallery', 'anva' ),
			'new_item' 						=> __( 'New Gallery', 'anva' ),
			'view_item' 					=> __( 'View Gallery', 'anva' ),
			'search_items' 				=> __( 'Search Gallery', 'anva' ),
			'not_found' 					=> __( 'No Gallery found', 'anva' ),
			'not_found_in_trash' 	=> __( 'No Gallery found in Trash', 'anva' ), 
			'parent_item_colon' 	=> ''
		);

		$args = array(
			'labels' 							=> $labels,
			'public' 							=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 						=> true, 
			'query_var' 					=> true,
			'rewrite' 						=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 				=> false,
			'menu_position' 			=> 26.6,
			'supports' 						=> array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'taxonomies'          => array( 'gallery_cat' ),
			'has_archive'         => true
		); 		

		register_post_type( 'galleries', $args );
		
		$labels = array(			  
			'name' 								=> __( 'Gallery Categories', 'anva' ),
			'singular_name' 			=> __( 'Gallery Category', 'anva' ),
			'search_items' 				=> __( 'Search Gallery Categories', 'anva' ),
			'all_items' 					=> __( 'All Gallery Categories', 'anva' ),
			'parent_item' 				=> __( 'Parent Gallery Category', 'anva' ),
			'parent_item_colon' 	=> __( 'Parent Gallery Category:', 'anva' ),
			'edit_item' 					=> __( 'Edit Gallery Category', 'anva' ), 
			'update_item' 				=> __( 'Update Gallery Category', 'anva' ),
			'add_new_item' 				=> __( 'Add New Gallery Category', 'anva' ),
			'new_item_name' 			=> __( 'New Gallery Category Name', 'anva' ),
		); 							  
			
		register_taxonomy(
			'gallery_cat',
			'galleries',
			array(
				'public'						=> true,
				'hierarchical' 			=> true,
				'labels'						=> $labels,
				'query_var' 				=> 'gallery_cat',
				'show_ui' 					=> true,
				'rewrite' 					=> array( 'slug' => 'gallery_cat', 'with_front' => false ),
			)
		);		  
	}

}
endif; // If class_exists check

/*
 * The main function to return Anva_Gallery instance
 */
function Anva_Gallery() {
	return Anva_Gallery::instance();
}

Anva_Gallery();

/*
 * Get gallery templates
 */
function anva_gallery_templates() {
	$templates = array(
		'grid_1'  => array(
			'name' => __( 'Gallery 1 Column', 'anva' ),
			'id'	 => 'grid_1',
			'layout' => array(
				'size' => 'blog_full',
				'col'	 => 'col-1',
				'type' => 'grid'
			)
		),
		'grid_2'  => array(
			'name' => __( 'Gallery 2 Columns', 'anva' ),
			'id'	 => 'grid_2',
			'layout' => array(
				'size' => 'gallery_2',
				'col'	 => 'col-2',
				'type' => 'grid'
			)
		),
		'grid_3'  => array(
			'name' => __( 'Gallery 3 Columns', 'anva' ),
			'id'	 => 'grid_3',
			'layout' => array(
				'size' => 'gallery_2',
				'col'	 => 'col-3',
				'type' => 'grid'
			)
		),
		'grid_4'  => array(
			'name' => __( 'Gallery 4 Columns', 'anva' ),
			'id'	 => 'grid_4',
			'layout' => array(
				'size' => 'gallery_2',
				'col'	 => 'col-4',
				'type' => 'grid'
			)
		),
		'grid_5'  => array(
			'name' => __( 'Gallery 5 Columns', 'anva' ),
			'id'	 => 'grid_5',
			'layout' => array(
				'size' => 'gallery_3',
				'col'	 => 'col-5',
				'type' => 'grid'
			)
		),
		'masonry_2' => array(
			'name' => __( 'Masonry 2 Columns', 'anva' ),
			'id'	 => 'masonry_2',
			'layout' => array(
				'size' => 'gallery_masonry',
				'col'	 => 'col-2',
				'type' => 'masonry'
			)
		),
		'masonry_3' => array(
			'name' => __( 'Masonry 3 Columns', 'anva' ),
			'id'	 => 'masonry_3',
			'layout' => array(
				'size' => 'gallery_masonry',
				'col'	 => 'col-3',
				'type' => 'masonry'
			)
		),
		'masonry_4' => array(
			'name' => __( 'Masonry 4 Columns', 'anva' ),
			'id'	 => 'masonry_4',
			'layout' => array(
				'size' => 'gallery_masonry',
				'col'	 => 'col-4',
				'type' => 'masonry'
			)
		),
		'masonry_5' => array(
			'name' => __( 'Masonry 5 Columns', 'anva' ),
			'id'	 => 'masonry_5',
			'layout' => array(
				'size' => 'gallery_masonry',
				'col'	 => 'col-5',
				'type' => 'masonry'
			)
		)
	);
	return apply_filters( 'anva_gallery_templates', $templates );
}
