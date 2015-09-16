<?php

/**
 * Adds meta boxes
 * 
 * WP's built-in add_meta_box() functionality.
 *
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/admin
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */

if ( ! class_exists( 'Anva_Media_Meta_Box' ) ) :

class Anva_Media_Meta_Box {

	/**
	 * ID for meta box and post field saved
	 *
	 * @since 2.2.0
	 * @var string
	 */
	public $id;

	/**
	 * Arguments to pass to add_meta_box()
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $args;

	/**
	 * Constructor
	 * Hook in meta box to start the process.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $id, $args ) {

		$this->id = $id;

		$defaults = array(
			'page'				=> array( 'post' ),		// Can contain post, page, link, or custom post type's slug
			'context'			=> 'normal',					// Normal, advanced, or side
			'priority'		=> 'high'							// Priority
		);

		$this->args = wp_parse_args( $args, $defaults );

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 */
	public function scripts( $hook ) {
		
		global $typenow;

		foreach ( $this->args['page'] as $page ) {
			
			// Add scripts only if page match with post type
			if ( $typenow == $page ) {
				
				wp_enqueue_script( 'anva-media', anva_get_core_uri() . '/assets/js/admin/media.js', array(), ANVA_FRAMEWORK_VERSION, false );
				wp_enqueue_script( 'anva-metaboxes-js', anva_get_core_uri() . '/assets/js/admin/metaboxes.min.js', array(), ANVA_FRAMEWORK_VERSION, false );
				wp_enqueue_style( 'anva-metaboxes', anva_get_core_uri() . '/assets/css/admin/metaboxes.min.css', array(), ANVA_FRAMEWORK_VERSION, 'all' );

			}
		}
	}

	/**
	 * Call WP's add_meta_box() for each post type
	 */
	public function add() {

		// Filters
		$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );
		$this->options = apply_filters( 'anva_meta_options_' . $this->id, $this->options );

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

	/**
	 * Renders the content of the meta box
	 *
	 * @since 1.0.0
	 */
	public function display() {

		// Make sure options framework exists so we can show
		// the options form.
		if ( ! method_exists( $this, 'media' ) ) {
			echo __( 'Options not found.', 'anva' );
			return;
		}

		$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );
		$this->options = apply_filters( 'anva_meta_options_' . $this->id, $this->options );

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->id, $this->id . '_nonce' );

		// Start content
		echo '<div class="anva-meta-box">';

		if ( ! empty( $this->args['desc'] ) ) {
			printf( '<p class="anva-meta-desc">%s</p><!-- .anva-meta-desc (end) -->', $this->args['desc'] );
		}

		// Use options framework to display form elements
		echo $this->media();

		//  Finish content
		echo '</div><!-- .anva-meta-box (end) -->';
	}

	/**
	 * Save meta data sent from meta box
	 * 
	 * @since 1.0.0
	 * @param integer The post ID
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
		$id  = $this->id;
		$old = get_post_meta( $post_id, $this->id, true );

		if ( isset( $_POST[$id] ) && ! empty( $_POST[$id] ) ) {

			$new = $_POST[$id];

			if ( $new && $new != $old ) {

				// Clean inputs
				$clean = $this->validate( $new );

				update_post_meta( $post_id, $id, $clean );

			} elseif ( '' == $new && $old ) {

				delete_post_meta( $post_id, $id, $old );

			}

		}

	}

	public function media() {
		global $post;

		echo '<div class="tzp-metabox">';
		printf( '<p class="tzp-intro">%1$s</p>', __('Set up your audio media for display in your portfolio. Only 1 file type is required for audio to work in all browsers, but the providing additional file types will ensure that users view an HTML5 audio element if available.', 'zilla') );

		do_action( 'tzp_portfolio_audio_meta_box_fields', $post->ID );
		echo '</div>';

		echo '<div class="tzp-metabox">';
		printf( '<p class="tzp-intro">%1$s</p>', __('Set up your video media for display in your portfolio. Adding to the video embed field will override the self hosted options. For self hosted video, the more file types you provide the more likely a user will view an HTML5 video element. However, only one file type is required.', 'zilla-portfolio') );

		do_action( 'tzp_portfolio_video_meta_box_fields', $post->ID );
		echo '</div>';

	}

}
endif;

add_action( 'tzp_portfolio_audio_meta_box_fields', 'tzp_render_portfolio_audio_fields', 10 );
add_action( 'tzp_portfolio_video_meta_box_fields', 'tzp_render_portfolio_video_fields', 10 );

/**
 * Portfolio Audio Fields
 *
 * Used to output the portfolio audio fields
 *
 * @since 0.1.0
 * @param int $post_id The ID of the portfolio post
 */
function tzp_render_portfolio_audio_fields( $post_id ) {
?>
	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_audio_poster_url'><?php _e('Poster Image:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_audio_poster_url" id="_tzp_audio_poster_url" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_audio_poster_url', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_audio_poster_url_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_audio_poster_url_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Add a poster image to your audio player (optional).', 'zilla-portfolio'); ?></p>
		</div>
	</div>

	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_audio_file_mp3'><?php _e('.mp3 File:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_audio_file_mp3" id="_tzp_audio_file_mp3" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_audio_file_mp3', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_audio_file_mp3_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_audio_file_mp3_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Insert an .mp3 file, if desired.', 'zilla-portfolio'); ?></p>
		</div>
	</div>

	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_audio_file_ogg'><?php _e('.ogg File:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_audio_file_ogg" id="_tzp_audio_file_ogg" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_audio_file_ogg', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_audio_file_ogg_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_audio_file_ogg_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Insert an .ogg file, if desired.', 'zilla-portfolio'); ?></p>
		</div>
	</div>
<?php
}

/**
 * Portfolio Video Fields
 *
 * Used to output the portfolio video fields
 *
 * @since 0.1.0
 * @param int $post_id The ID of the portfolio post
 */
function tzp_render_portfolio_video_fields( $post_id ) {
?>
	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_video_poster_url'><?php _e('Poster Image:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_video_poster_url" id="_tzp_video_poster_url" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_video_poster_url', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_video_poster_url_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_video_poster_url_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Add a poster image for your video player (optional).', 'zilla-portfolio'); ?></p>
		</div>
	</div>

	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_video_file_m4v'><?php _e('.m4v File:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_video_file_m4v" id="_tzp_video_file_m4v" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_video_file_m4v', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_video_file_m4v_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_video_file_m4v_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Insert an .m4v file, if desired.', 'zilla-portfolio'); ?></p>
		</div>
	</div>

	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_video_file_ogv'><?php _e('.ogv File:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_video_file_ogv" id="_tzp_video_file_ogv" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_video_file_ogv', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_video_file_ogv_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_video_file_ogv_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Insert an .ogv file, if desired.', 'zilla-portfolio'); ?></p>
		</div>
	</div>

	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_video_file_mp4'><?php _e('.mp4 File:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<input type="text" name="_tzp_video_file_mp4" id="_tzp_video_file_mp4" value="<?php echo esc_attr( get_post_meta( $post_id, '_tzp_video_file_mp4', true ) ); ?>" class="file" />
			<input type="button" class="tzp-upload-file-button button" name="_tzp_video_file_mp4_button" data-post-id="<?php echo $post_id; ?>" id="_tzp_video_file_mp4_button" value="<?php esc_attr_e( 'Browse', 'zilla-portfolio' ); ?>" />
			<p class='tzp-desc howto'><?php _e('Insert an .mp4 file, if desired.', 'zilla-portfolio'); ?></p>
		</div>
	</div>

	<div class="tzp-field">
		<div class="tzp-left">
			<label for='_tzp_video_embed'><?php _e('Video Embed:', 'zilla-portfolio'); ?></label>
		</div>
		<div class="tzp-right">
			<textarea name="_tzp_video_embed" id="_tzp_video_embed" rows="8" cols="5"><?php echo esc_textarea( get_post_meta( $post_id , '_tzp_video_embed', true ) ); ?></textarea>
			<p class='tzp-desc howto'><?php printf( '%1$s <br /><strong>%2$s</strong>.', __('Embed iframe code from YouTube, Vimeo or other trusted source. HTML tags are limited to iframe, div, img, a, em, strong and br.', 'zilla-portfolio'), __('This field overrides the previous fields.', 'zilla-portfolio') ); ?></p>
		</div>
	</div>
<?php
}
