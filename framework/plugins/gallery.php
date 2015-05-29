<?php

/*
 * Anva Gallery Class
 */
class Anva_Gallery {

	/*
	 * Class properties
	 */
	private static $instance;
	private $admin_thumbnail_size = 110;
	private $thumbnail_size_w = 150;
	private $thumbnail_size_h = 150;

	/*
	 * Instance class
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}

	/*
	 * Construct
	 */
	private function __construct() {
		
		$this->thumbnail_size_w = 100;
		$this->thumbnail_size_h = 100;

		add_action( 'admin_print_scripts-post.php', array( &$this, 'admin_print_scripts' ) );
		add_action( 'admin_print_scripts-post-new.php', array( &$this, 'admin_print_scripts' ) );
		add_action( 'admin_print_styles', array( &$this, 'admin_print_styles' ) );
		
		// add_filter( 'the_content', array( &$this, 'gallery_output' ), 10 );
		
		add_image_size( 'anva_gallery_admin_thumb', $this->admin_thumbnail_size, $this->admin_thumbnail_size, true );
		add_image_size( 'anva_gallery_thumb', $this->thumbnail_size_w, $this->thumbnail_size_h, true );
		
		add_shortcode( 'anva_gallery', array(&$this, 'shortcode' ) );

		if ( is_admin() ) {
			add_action( 'add_meta_boxes', array( &$this, 'gallery_add_meta' ) );
			add_action( 'admin_init', array( &$this, 'gallery_add_meta' ), 1 );
			add_action( 'save_post', array( &$this, 'gallery_save_meta' ), 9, 1 );
			add_action( 'wp_ajax_anva_gallery_get_thumbnail', array( &$this, 'ajax_get_thumbnail' ) );
			add_action( 'wp_ajax_anva_gallery_get_all_thumbnail', array( &$this, 'ajax_get_all_attachments' ) );
		}
	}

	/*
	 * Admin scripts
	 */
	public function admin_print_scripts() {
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'gallery-admin-scripts', ANVA_URL . '/assets/js/admin.gallery.js' );
	}

	/*
	 * Amin stylesheets
	 */
	public function admin_print_styles() {
		wp_enqueue_style( 'gallery-admin-style', ANVA_URL . '/assets/css/gallery.css' );
	}

	/*
	 * Adds the meta box container
	 */
	public function gallery_add_meta( $post_type ) {
		
		$post_types = array( 'galleries' );

		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'anva_gallery',
				__('Gallery Images', 'anva' ),
				array( &$this, 'gallery_metabox_advanced'),
				$post_type,
				'advanced',
				'default'
			);
		}
	}

	/*
	 * Custom meta box
	 */
	public function gallery_metabox_advanced( $post ) {
		
		$gallery = get_post_meta( $post->ID, 'anva_gallery_gallery', true );
		wp_nonce_field( basename( __FILE__ ), 'anva_gallery_nonce' );

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
			'browse_button' 			=> 'wpsg-plupload-browse-button',
			'file_data_name' 			=> 'async-upload',
			'multiple_queues' 		=> true,
			'max_file_size' 			=> $max_upload_size . 'b',
			'url' 								=> $upload_action_url,
			'flash_swf_url' 			=> includes_url( 'js/plupload/plupload.flash.swf'),
			'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
			'filters' 						=> array( array( 'title' => __( 'Allowed Files', ANVA_DOMAIN ), 'extensions' => '*' ) ),
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
					<input id="anva_gallery_upload_button" data-uploader_title="<?php echo __( 'Upload Image' ); ?>" data-uploader_button_text="Select" class="primary_button button" type="button" value="<?php echo __('Upload Image', 'anva'); ?>" rel="" />
					<input id="anva_gallery_delete_all_button" class="button secondary_button" type="button" value="<?php echo __('Delete All Images', 'anva'); ?>" rel="" />
				</div>
				<script type="text/javascript">
					/* <![CDATA[ */
					var POST_ID = <?php echo $post->ID; ?>;
					var WPSGwpUploaderInit = <?php echo json_encode( $plupload_init ); ?>;
					/* ]]> */
				</script>
			</div>
		</div>

		<?php
	}

	/*
	 * Save the meta when the post is saved
	 */
	public function gallery_save_meta( $post_id ) {
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return '';
		}

		if ( ! isset( $_POST['anva_gallery_nonce'] ) || ! wp_verify_nonce( $_POST['anva_gallery_nonce'], basename( __FILE__ ) ) )
			return ( isset( $post_id) ) ? $post_id : 0;

		$images = ( isset( $_POST['anva_gallery_thumb'] ) ) ? $_POST['anva_gallery_thumb'] : array();
		$gallery = array();
		
		if ( count( $images ) > 0 ) {
			foreach ( $images as $i => $img ) {
				if ( is_numeric( $img ) ) {
					$gallery[] = $img;
				}
			}
		}

		update_post_meta( $post_id, 'anva_gallery_gallery', $gallery );
		
		return $post_id;
	}

	/*
	 * Get admin thumb
	 */
	private function admin_thumb( $id ) {
		$image = wp_get_attachment_image_src( $id, 'thumbnail', true );
		?>
		<li>
			<a class="anva_gallery_image" href="<?php echo admin_url( '/post.php?post=' ) . $id . '&action=edit'; ?>" target="_blank">
				<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
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
			'post_mime_type' 	=> 'image', //MIME Type condition
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
			'<li><a href="%1$s" title="%2$s" data-gallery="gallery-group-%3$s"><img src="%4$s" width="%5$s" height="%6$s" alt="%7$s" /></a>',
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
	 * Gallery
	 */
	private function gallery( $post_id = false ) {
		
		global $post;
		
		$post_id = ( ! $post_id ) ? $post->ID : $post_id;
		$gallery = get_post_meta( $post_id, 'anva_gallery_gallery', true );
		$gallery = ( is_string( $gallery ) ) ? @unserialize( $gallery ) : $gallery;
		$html = '';

		if ( is_array( $gallery ) && count( $gallery ) > 0) {
			$html .= '<div id="anva_gallery_container">';
			$html .= '<ul id="anva_gallery" class="clearfix">';
			
			foreach ( $gallery as $thumbid ) {
				$html .= $this->thumb( $thumbid, $post_id );
			}
			
			$html .= '</ul>';
			$html .= '</div>';
		}

		return $html;
	}

	/*
	 * Output gallery
	 */
	public function gallery_output( $content ) {
		
		if ( post_password_required() ) {
			return $content;
		}

		$append_gallery = 1;
		
		if ( ! post_password_required() && $append_gallery == '1' && is_singular() ) {
			$content .= $this->gallery();
		}
		return $content;
	}

	/*
	 * Shortcode
	 */
	public function shortcode($atts) {
		extract( shortcode_atts( array(
			'id' => false,
		), $atts ) );
		return $this->gallery( $id );
	}

}

// Run gallery class instance
Anva_Gallery::instance();

/*
 * Setup galleries
 */
function anva_galleries_setup() {
	add_action( 'init', 'anva_galleries_register' );
	add_action( 'add_meta_boxes', 'anva_galleries_add_meta' );
	add_action( 'save_post', 'anva_galleries_save_meta', 1, 2 );
	add_action( 'admin_head', 'anva_galleries_admin_icon' );
}

/*
 * Register galleries post type
 */
function anva_galleries_register() {
	
	$labels = array(
		'name' 								=> __( 'Galleries', ANVA_DOMAIN ),
		'singular_name' 			=> __( 'Gallery', ANVA_DOMAIN ),
		'add_new' 						=> __( 'Add New Gallery', ANVA_DOMAIN ),
		'add_new_item' 				=> __( 'Add New Gallery', ANVA_DOMAIN ),
		'edit_item' 					=> __( 'Edit Gallery', ANVA_DOMAIN ),
		'new_item' 						=> __( 'New Gallery', ANVA_DOMAIN ),
		'view_item' 					=> __( 'View Gallery', ANVA_DOMAIN ),
		'search_items' 				=> __( 'Search Gallery', ANVA_DOMAIN ),
		'not_found' 					=> __( 'No Gallery found', ANVA_DOMAIN ),
		'not_found_in_trash' 	=> __( 'No Gallery found in Trash', ANVA_DOMAIN ), 
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
		'name' 								=> __( 'Gallery Categories', ANVA_DOMAIN ),
		'singular_name' 			=> __( 'Gallery Category', ANVA_DOMAIN ),
		'search_items' 				=> __( 'Search Gallery Categories', ANVA_DOMAIN ),
		'all_items' 					=> __( 'All Gallery Categories', ANVA_DOMAIN ),
		'parent_item' 				=> __( 'Parent Gallery Category', ANVA_DOMAIN ),
		'parent_item_colon' 	=> __( 'Parent Gallery Category:', ANVA_DOMAIN ),
		'edit_item' 					=> __( 'Edit Gallery Category', ANVA_DOMAIN ), 
		'update_item' 				=> __( 'Update Gallery Category', ANVA_DOMAIN ),
		'add_new_item' 				=> __( 'Add New Gallery Category', ANVA_DOMAIN ),
		'new_item_name' 			=> __( 'New Gallery Category Name', ANVA_DOMAIN ),
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

/*
 * Admin metabox
 */
function anva_galleries_add_meta() {
	add_meta_box(
		'anva_galleries_metabox',
		__( 'Gallery Options' ),
		'anva_galleries_metabox',
		'galleries',
		'side',
		'core'
	);
}

/*
 * Metabox form
 */
function anva_galleries_metabox() {
	
	global $post;

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'anva_galleries_custom_box', 'anva_galleries_custom_box_nonce' );
	
	$meta 						= anva_get_post_custom();
	$gallery_password = ( isset( $meta['_gallery_password'][0] ) ? $meta['_gallery_password'][0] : '' );
	$gallery_password = base64_decode( $gallery_password );
	$gallery_template = ( isset( $meta['_gallery_template'][0] ) ? $meta['_gallery_template'][0] : '' );

	?>
	
	<div class="meta-wrapper">
		<div class="meta-input-wrapper meta-input-text">
			<label class="meta-label" for="gallery_password">
				<strong>Gallery Password:</strong>
			</label>
			<p class="meta-description">Enter your password for this gallery.</p>
			<p class="meta-input"><input type="password" class="wide" name="gallery_password" value="<?php echo esc_attr( $gallery_password ); ?>" /></p>
		</div>

		<div class="meta-input-wrapper meta-input-select">
			<label class="meta-label" for="gallery_template">
				<strong>Gallery Template:</strong>
			</label>
			<p class="meta-description">Select gallery template for this gallery.</p>
			<p class="meta-input">
				<select class="wide" name="gallery_template">
					<?php
						$select = array(
							'Gallery 1 Column'  => 'Gallery 1 Column',
							'Gallery 2 Columns' => 'Gallery 2 Columns',
							'Gallery 3 Columns' => 'Gallery 3 Columns',
							'Gallery 4 Columns' => 'Gallery 4 Columns',
							'Gallery Masonry 2 Columns' => 'Gallery Masonry 2 Columns',
						);
						foreach ( $select as $key => $value ) {
							echo '<option value="' . esc_attr( $key ) . '" ' . selected( $gallery_template, $key, true ) . '>' . $value . '</option>';
						}
					?>
				</select>
			</p>
		</div>
	</div>
	<?php
}

/*
 * Save metabox
 */
function anva_galleries_save_meta( $post_id, $post ) {

	// Check if our nonce is set
	if ( ! isset( $_POST['anva_galleries_custom_box_nonce'] ) )
		return $post_id;

	// Verify that the nonce is valid
	if ( ! wp_verify_nonce( $_POST['anva_galleries_custom_box_nonce'], 'anva_galleries_custom_box' ) )
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

	// Is safe to save the data
	
	if ( isset( $_POST['gallery_password'] ) ) {
		$text = sanitize_text_field( $_POST['gallery_password'] );
		$text = base64_encode( $text );
		update_post_meta( $post_id, '_gallery_password', $text );
	}
	
	if ( isset( $_POST['gallery_template'] ) ) {
		$text = sanitize_text_field( $_POST['gallery_template'] );
		update_post_meta( $post_id, '_gallery_template', $text );
	}

}

/*
 * Admin menu icon
 */
function anva_galleries_admin_icon() {
	echo '<style>#adminmenu #menu-posts-galleries div.wp-menu-image:before { content: "\f161"; }</style>';	
}