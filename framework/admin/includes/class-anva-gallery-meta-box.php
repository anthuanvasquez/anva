<?php

/*
 * Anva Gallery Meta Box
 */
if ( ! class_exists( 'Anva_Gallery_Meta_Box' ) ) :

class Anva_Gallery_Meta_Box {

	/**
	 * ID for meta box and post field saved
	 *
	 * @since 2.2.0
	 * @var string
	 */
	public $id;

	/**
	 * Image admin thumbnail size
	 * 
	 * @since 1.0.0
	 */
	private $size = 150;

	/**
	 * Image thumbnail size width
	 * 
	 * @since 1.0.0
	 */
	private $width = 150;

	/**
	 * Image thumbnail size height
	 * 
	 * @since 1.0.0
	 */
	private $height = 150;

	/**
	 * Constructor
	 * Hook everything in.
	 * 
	 * @since 1.0.0
	 */
	public function __construct( $id, $args ) {
		
		$this->id = $id;
		$this->width  = 100;
		$this->height = 100;

		$defaults = array(
			'page'				=> array( 'post' ),		// Can contain post, page, link, or custom post type's slug
			'context'			=> 'normal',					// Normal, advanced, or side
			'priority'		=> 'high'							// Priority
		);

		$this->args = wp_parse_args( $args, $defaults );

		// Hooks
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			add_action( 'add_meta_boxes', array( $this, 'add' ) );
			add_action( 'save_post', array( $this, 'save' ), 9, 1 );
			add_action( 'wp_ajax_anva_gallery_get_thumbnail', array( $this, 'ajax_get_thumbnail' ) );
			add_action( 'wp_ajax_anva_gallery_get_all_thumbnail', array( $this, 'ajax_get_all_attachments' ) );
		}
	}

	/*
	 * Admin scripts
	 */
	public function scripts() {

		global $typenow;

		foreach ( $this->args['page'] as $page ) {
			
			// Add scripts only if page match with post type
			if ( $typenow != $page )
				return;

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'anva-metaboxes-js', anva_get_core_uri() . '/assets/js/admin/metaboxes.min.js' );
			wp_enqueue_style( 'anva-metaboxes', anva_get_core_uri() . '/assets/css/admin/metaboxes.min.css' );
		}
	}

	/*
	 * Adds the meta box container
	 */
	public function add() {
		
		// Filters
		$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );

		foreach ( $this->args['page'] as $page ) {
			add_meta_box(
				$this->id,
				$this->args['title'],
				array( $this, 'display' ),
				$page,
				$this->args['context'],
				$this->args['priority']
			);
		}
	}

	/*
	 * Metabox advanced
	 */
	public function display( $post ) {
		
		$gallery = get_post_meta( $post->ID, $this->id, true );

		wp_nonce_field( $this->id, $this->id . '_nonce' );

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
		
		<div class="anva-meta-box">
			<div class="anva-input-gallery">
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
				<div class="anva-gallery-actions">
					<input id="anva_gallery_delete_all_button" class="button secondary_button button-secondary" type="button" value="<?php echo __('Delete All Images', 'anva'); ?>" rel="" />
					<input id="anva_gallery_upload_button" data-uploader_title="<?php echo __( 'Upload Image', 'anva' ); ?>" data-uploader_button_text="Select" class="primary_button button button-primary" type="button" value="<?php echo __('Upload Image', 'anva'); ?>" rel="" />
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

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST[$this->id . '_nonce'] ) )
			return $post_id;

		$nonce = $_POST[$this->id . '_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, $this->id ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/*
		 * OK, its safe!
		 */
		$id = $this->id;
		$images = ( isset( $_POST['anva_gallery_thumb'] ) ) ? $_POST['anva_gallery_thumb'] : array();
		$images_ids = array();
		
		if ( count( $images ) > 0 ) {
			foreach ( $images as $key => $attachment_id ) {
				if ( is_numeric( $attachment_id ) ) {
					$images_ids[] = $attachment_id;
				}
			}
		}

		update_post_meta( $post_id, $id, $images_ids );

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

	/**
	 * Get admin thumbnail
	 * 
	 * @since 1.0.0
	 */
	private function admin_thumb( $attachment_id ) {
		$image = wp_get_attachment_image_src( $attachment_id, 'medium', true );
		?>
		<li>
			<div class="attachment-preview">
				<div class="thumbnail">
					<div class="centered">
							<img src="<?php echo esc_url( $image[0] ); ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
						
					</div>
				</div>
			</div>
			<a href="#" class="anva_gallery_remove">X</a>
			<input type="hidden" name="anva_gallery_thumb[]" value="<?php echo $attachment_id; ?>" />
		</li>
		<?php
	}
}
endif;