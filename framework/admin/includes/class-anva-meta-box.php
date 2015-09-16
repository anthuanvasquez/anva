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
	 * Options array for fields
	 *
	 * @since 1.0.0
	 * @var array
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
			if ( $typenow == $page ) {
				
				wp_enqueue_script( 'jquery-ui-spinner' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'anva-metaboxes-js', anva_get_core_uri() . '/assets/js/admin/metaboxes.min.js', array(), ANVA_FRAMEWORK_VERSION, false );
				
				wp_enqueue_style( 'jquery-ui-custom', anva_get_core_uri() . '/assets/css/admin/jquery-ui-custom.min.css', array(), '1.11.4', 'all' );
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
		if ( ! method_exists( $this, 'fields' ) ) {
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

		// Display tabs
		echo '<h2 class="nav-tab-wrapper">' . $this->tabs() . '</h2>';

		// Use options framework to display form elements
		echo $this->fields();

		// Outputs closing div if there tabs
		if ( $this->tabs() != '' ) {
			echo '</div><!-- .meta-group (end) -->';
		}

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

	/**
	 * Tabs
	 *
	 * @since 1.0.0
	 */
	public function tabs() {
		$fields = $this->options;
		$counter = 0;
		$tabs = '';

		foreach ( $fields as $field ) {
			// Heading for Navigation
			if ( $field['type'] == "heading" ) {
				
				$icon = '';
				if ( isset( $field['icon'] ) && ! empty( $field['icon'] ) ) {
					$icon = '<span class="dashicons dashicons-'. esc_attr( $field['icon'] ) .'"></span> ';
				}

				$counter++;
				$class = '';
				$class = ! empty( $field['id'] ) ? $field['id'] : $field['name'];
				$class = 'tab-' . preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) );
				$tabs .= '<a id="meta-group-'.  esc_attr( $counter ) . '-tab" class="nav-tab ' . $class .'" title="' . esc_attr( $field['name'] ) . '" href="' . esc_attr( '#meta-group-' .  $counter ) . '">' . $icon . esc_html( $field['name'] ) . '</a>';
			}
		}

		return $tabs;
	}

	/**
	 * Interface
	 *
	 * @since 1.0.0
	 */
	public function fields() {

		$option_name = $this->id;
		$fields = $this->options;

		global $post, $allowedtags;

		// get value of this field if it exists for this post
		$meta = get_post_meta( $post->ID, $option_name, true );
		$output = '';
		$counter = 0;

		// Begin the field table and loop
		foreach ( $fields as $field ) {

			$val = '';
			$select_value = '';

			// Wrap all options
			if ( ( $field['type'] != "heading" ) && ( $field['type'] != "info" ) ) {
				
				// Keep all ids lowercase with no spaces
				$field['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower( $field['id'] ) );
				$id = 'meta-' . $field['id'];

				$class = 'meta';

				if ( isset( $field['type'] ) ) {
					$class .= ' field-' . $field['type'];
				}

				if ( isset( $field['class'] ) ) {
					$class .= ' ' . $field['class'];
				}

				$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";

				if ( isset( $field['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $field['name'] ) . '</h4>' . "\n";
				}
				
				if ( $field['type'] != 'editor' ) {
					$output .= '<div class="meta-option">' . "\n" . '<div class="meta-controls"><!-- .meta-controls (end) -->' . "\n";
				}
				else {
					$output .= '<div class="meta-option">' . "\n" . '<div><!-- .meta-option (end) -->' . "\n";
				}
			}

			// Set default value to $val
			if ( isset( $field['std'] ) ) {
				$val = $field['std'];
			}

			if ( ( $field['type'] != 'heading' ) && ( $field['type'] != 'info') ) {
				if ( isset( $meta[($field['id'])]) ) {
					$val = $meta[($field['id'])];
					// Striping slashes of non-array options
					if ( ! is_array( $val ) ) {
						$val = stripslashes( $val );
					}
				}
			}
			
			// If there is a description save it for labels
			$explain_value = '';
			if ( isset( $field['desc'] ) ) {
				$explain_value = $field['desc'];
			}

			// Set the placeholder if one exists
			$placeholder = '';
			if ( isset( $field['placeholder'] ) ) {
				$placeholder = ' placeholder="' . esc_attr( $field['placeholder'] ) . '"';
			}
		
			switch ( $field['type'] ) {

				// Text
				case 'text':
					$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="anva-input anva-text" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '"' . $placeholder . ' />';
					break;

				// Number
				case 'number':
					$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="anva-input anva-number anva-spinner" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="number" value="' . esc_attr( $val ) . '"' . $placeholder . ' />';
					break;

				// Textarea
				case 'textarea':
					$rows = '8';
					if ( isset( $field['settings']['rows'] ) ) {
						$custom_rows = $field['settings']['rows'];
						if ( is_numeric( $custom_rows ) ) {
							$rows = $custom_rows;
						}
					}
					$val = stripslashes( $val );
					$output .= '<textarea id="' . esc_attr( $field['id'] ) . '" class="anva-input anva-textarea" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" rows="' . $rows . '"' . $placeholder . '>' . esc_textarea( $val ) . '</textarea>';
					break;

				// Checkbox
				case 'checkbox':
					$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="anva-input anva-checkbox" type="checkbox" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
					$output .= '<label class="explain" for="' . esc_attr( $field['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
					break;

				// Select Box
				case 'select':
					$output .= '<select class="anva-input anva-select" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" id="' . esc_attr( $field['id'] ) . '">';
					foreach ( $field['options'] as $key => $option ) {
						$output .= '<option'. selected( $val, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
					}
					$output .= '</select>';
					break;

				// Radio
				case 'radio':
					$name = $option_name .'['. $field['id'] .']';
					foreach ( $field['options'] as $key => $option ) {
						$id = $option_name . '-' . $field['id'] .'-'. $key;
						$output .= '<input class="anva-input anva-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
					}
					break;

				// Multicheck
				case 'multicheck':
					foreach ( $field['options'] as $key => $option ) {
						$checked = '';
						$label = $option;
						$option = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $key ) );
						$id = $option_name . '-' . $field['id'] . '-'. $option;
						$name = $option_name . '[' . $field['id'] . '][' . $option .']';

						if ( isset( $val[$option] ) ) {
							$checked = checked( $val[$option], 1, false );
						}
						$output .= '<input id="' . esc_attr( $id ) . '" class="anva-input anva-multicheck" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
					}
					break;

				// Date
				case 'date':
					$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="anva-input anva-date anva-datepicker" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
					break;

				// Slider
				case 'slider':
					$output .= '<div id="' . esc_attr( $field['id'] ) . '-slider"></div>';
					$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="anva-input anva-slider" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
					break;

				// Tab
				case "heading":
					$counter++;
					if ( $counter >= 2 ) {
						$output .= '</div><!-- .meta-group (end) -->'."\n";
					}
					$class = '';
					$class = ! empty( $field['id'] ) ? $field['id'] : $field['name'];
					$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $class ) );
					$output .= '<div id="meta-group-' . esc_attr( $counter ) . '" class="meta-group ' . esc_attr( $class ) . '">';
					break;

			} // End Switch

			if ( ( $field['type'] != "heading" ) && ( $field['type'] != "info" ) ) {
				$output .= '</div><!-- .meta-controls (end) -->';
				if ( ( $field['type'] != "checkbox" ) && ( $field['type'] != "editor" ) ) {
					$output .= '<div class="meta-explain description">' . wp_kses( $explain_value, $allowedtags ) . '</div><!-- .meta-explain (end) -->'."\n";
				}
				$output .= '</div><!-- .meta-option (end) --></div><!-- .meta (end) -->'."\n";
			}

		} // End Foreach
		
		return $output;

	}

} // End Class
endif;
