<?php

/**
 * Add page and post meta boxes
 *
 * @since 1.0.0
 * @return class Anva_Meta_box
 */
function anva_add_meta_boxes() {

	// Page meta box
	$page_meta = anva_setup_page_meta();
	$page_meta_box = new Anva_Meta_Box( $page_meta['args']['id'], $page_meta['args'], $page_meta['options'] );

}

/**
 * Page meta setup array
 *
 * @since 1.0.0
 * @return array $setup
 */
function anva_setup_page_meta() {
	
	$domain = anva_textdomain();
	$columns = array();
	$layouts = array();

	// Fill columns array
	$columns[''] = esc_html__( 'Default Grid Columns', $domain );
	foreach ( anva_grid_columns() as $key => $value ) {
		$columns[$key] = esc_html( $value['name'] );
	}
	// Remove 1 Column Grid
	unset( $columns[1] );

	// Fill layouts array
	$layouts[''] = esc_html__( 'Default Sidebar Layout', $domain );
	foreach ( anva_sidebar_layouts() as $key => $value ) {
		$layouts[$key] = esc_html( $value['name'] );
	}

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_page_options',
			'title' 		=> __( 'Page Options', $domain ),
			'page'			=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'default',
			'desc'			=> __( 'Page Options Desc', $domain )
		),
		'options' => array(
			'hide_title' => array(
				'id'			=> 'hide_title',
				'name' 		=> __( 'Page Title', $domain ),
				'desc'		=> __( 'Show or hide page\'s titles.', $domain ),
				'type' 		=> 'select',
				'std'			=> 'show',
				'options'	=> array(
					'show' 	=> __( 'Show page\'s title', $domain ),
					'hide'	=> __( 'Hide page\'s title', $domain )
				)
			),
			'sidebar_layout' => array(
				'id'			=> 'sidebar_layout',
				'name' 		=> __( 'Sidebar Layout', $domain ),
				'desc'		=> __( 'Select a sidebar layout.', $domain ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> $layouts
			),
			'grid_column' => array(
				'id'			=> 'grid_column',
				'name' 		=> __( 'Post Grid', $domain ),
				'desc'		=> __( 'Select a grid column for posts list.', $domain ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> $columns
			),


			'textarea' => array(
				'name' => 'Textarea',
				'desc'  => 'A description for the field.',
				'id'    => 'textarea',
				'type'  => 'textarea',
				'std'			=> 'Hello'
			),
			'checkbox' => array(
				'name' => 'Checkbox Input',
				'desc'  => 'A description for the field.',
				'id'    => 'checkbox',
				'type'  => 'checkbox',
				'std'		=> '1',
			),
			'radio' => array(
				'name' => 'Radio Group',
				'desc'  => 'A description for the field.',
				'id'    => 'radio',
				'std'		=> 'value2',
				'type'  => 'radio',
				'options' => array(
					'value1' => 'One',
					'value2' => 'Two',
					'value3' => 'Three'
				)
			),
			'multicheck' => array(
				'name' => 'Checkbox Group',
				'desc'  => 'A description for the field.',
				'id'    => 'multicheck',
				'type'  => 'multicheck',
				'std'		=> array( 'one' => '1' ),
				'options' => array(
					'one' => __( 'French Toast', 'theme-textdomain' ),
					'two' => __( 'Pancake', 'theme-textdomain' ),
					'three' => __( 'Omelette', 'theme-textdomain' ),
					'four' => __( 'Crepe', 'theme-textdomain' ),
					'five' => __( 'Waffle', 'theme-textdomain' )
				)
			),
			'date' => array(
				'name' => 'Date',
				'desc'  => 'A description for the field.',
				'id'    => 'date',
				'type'  => 'date',
				'std'		=> '07/11/2018'
			),
			'repeatable' => array(
				'name' => 'Repeatable',
				'desc'  => 'A description for the field.',
				'id'    => 'repeatable',
				'type'  => 'repeatable'
			)
		)
	);

	return apply_filters( 'anva_page_meta', $setup );
}

/**
 * Meta Fields Interface
 *
 * @since 1.0.0
 */
function anva_meta_fields_interface( $option_name, $fields ) {

	global $post, $allowedtags;

	// get value of this field if it exists for this post
	$meta = get_post_meta( $post->ID, $option_name, true );
	$output = '';

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
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="meta-input" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '"' . $placeholder . ' />';
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
				$output .= '<textarea id="' . esc_attr( $field['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" rows="' . $rows . '"' . $placeholder . '>' . esc_textarea( $val ) . '</textarea>';
				break;

			// Checkbox
			case "checkbox":
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="checkbox meta-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
				$output .= '<label class="explain" for="' . esc_attr( $field['id'] ) . '">' . wp_kses( $explain_value, $allowedtags ) . '</label>';
				break;

			// Select Box
			case 'select':
				$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach ( $field['options'] as $key => $option ) {
					$output .= '<option'. selected( $val, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				break;

			// Radio
			case "radio":
				$name = $option_name .'['. $field['id'] .']';
				foreach ( $field['options'] as $key => $option ) {
					$id = $option_name . '-' . $field['id'] .'-'. $key;
					$output .= '<input class="meta-input meta-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
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
					$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox meta-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				}
				break;

			// Date
			case 'date':
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="meta-input meta-date meta-date-picker" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
				break;

			// Slider
			case 'slider':
				$output .= '<div id="' . esc_attr( $field['id'] ) . '-slider"></div>';
				$output .= '<input id="' . esc_attr( $field['id'] ) . '" class="meta-input meta-slider" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
				break;

			// Repeatable
			case 'repeatable':
				$output .= '<a class="repeatable-add button" href="#">+</a>';
				$output .= '<ul id="' . esc_attr( $field['id'] ) . '-repeatable" class="custom_repeatable">';
				
				$i = 0;
				if ( is_array( $val ) && $val ) {
					foreach ( $val as $row) {
						$output .= '<li><span class="sort hndle">##</span>';
						$output .= '<input type="text" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '['.$i.']" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $row ) . '" />';
						$output .= '<a class="repeatable-remove button" href="#">-</a></li>';
						$i++;
					}
				} else {
					$output .= '<li><span class="sort hndle">##</span>';
					$output .= '<input type="text" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '[' . $i . ']" id="' . esc_attr( $field['id'] ) . '" value="" />';
					$output .= '<a class="repeatable-remove button" href="#">-</a></li>';
				}
				
				$output .= '</ul>';
				break;

		} // End Switch

		if ( ( $field['type'] != "heading" ) && ( $field['type'] != "info" ) ) {
			$output .= '</div>';
			if ( ( $field['type'] != "checkbox" ) && ( $field['type'] != "editor" ) ) {
				$output .= '<div class="meta-explain description">' . wp_kses( $explain_value, $allowedtags ) . '</div><!-- .meta-explain (end) -->'."\n";
			}
			$output .= '</div></div>'."\n";
		}

	} // End Foreach
	
	return $output;

}

/* ---------------------------------------------------------------- */
/* Helpers
/* ---------------------------------------------------------------- */

/**
 * Get field
 *
 * @since 1.0.0
 */
function anva_get_field( $id, $field, $default = false ) {
	
	$fields = anva_get_post_meta( $id );

	if ( isset( $fields[$field] ) ) {
		return $fields[$field];
	}

	return $default;
}

/**
 * Show field
 *
 * @since 1.0.0
 */
function anva_the_field( $id, $field, $default = false ) {
	echo anva_get_field( $id, $field, $default );
}