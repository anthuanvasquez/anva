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

if ( ! class_exists( 'Anva_Meta_Box' ) ) :

class Anva_Meta_Box {

	/**
	 * Arguments to pass to add_meta_box()
	 *
	 * @since 1.0.0
	 */
	private $args;

	/**
	 * Options array for fields
	 *
	 * @since 1.0.0
	 * @var $options
	 */
	private $options;

	/**
	 * Constructor
	 * Hook in meta box to start the process.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $id, $args, $options ) {

		$this->id = $id;
		$this->options = $options;

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
			if ( $typenow != $page )
				return;

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'anva-metaboxes-js', anva_get_core_url() . '/assets/js/admin/metaboxes.min.js' );
			
			wp_enqueue_style( 'jquery-ui-custom', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css' );
			wp_enqueue_style( 'anva-metaboxes', anva_get_core_url() . '/assets/css/admin/metaboxes.min.css' );
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
		if ( ! function_exists( 'anva_meta_fields_interface' ) ) {
			echo __( 'Options framework not found.', anva_textdomain() );
			return;
		}

		$this->args = apply_filters( 'anva_meta_args_' . $this->id, $this->args );
		$this->options = apply_filters( 'anva_meta_options_' . $this->id, $this->options );

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->id, $this->id . '_nonce' );

		// Start content
		echo '<div class="anva-meta-box anva-meta-context-' . esc_attr( $this->args['context'] ) . '">';

		if ( ! empty( $this->args['desc'] ) ) {
			printf( '<p class="anva-meta-desc">%s</p><!-- .anva-meta-desc (end) -->', $this->args['desc'] );
		}

		// Use options framework to display form elements
		$form = anva_meta_fields_interface( $this->id, $this->options );
		echo $form;

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

	/**
	 * Validate meta data before saved
	 *
	 * @since  1.0.0
	 * @param  $_POST The form fields
	 * @return array Sanitize options
	 */
	private function validate( $input ) {

		$clean = array();
		$fields = $this->options;
		
		foreach ( $fields as $field ) {
			
			if ( ! isset( $field['id'] ) ) {
				continue;
			}

			if ( ! isset( $field['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $field['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $field['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $field['type'] && ! isset( $input[$id] ) ) {
				foreach ( $field['options'] as $key => $value ) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'anva_sanitize_' . $field['type'] ) ) {
				$clean[$id] = apply_filters( 'anva_sanitize_' . $field['type'], $input[$id], $field );
			}
		}

		// Hook to run after validation
		do_action( 'anva_meta_validate_options_after', $clean );

		return $clean;
	}

}
endif;

/* ---------------------------------------------------------------- */
/* Helpers
/* ---------------------------------------------------------------- */

/**
 * Helper to add new meta box
 *
 * @since 1.0.0
 * @param $id, $args, $options
 * @return class Anva_Meta_Box
 */
function anva_add_new_meta_box( $id, $args, $options ) {
	$meta_box = new Anva_Meta_Box( $id, $args, $options );
}
