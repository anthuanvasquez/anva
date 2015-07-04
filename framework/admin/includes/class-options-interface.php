<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

class Options_Framework_Interface {

	/**
	 * Generates the tabs that are used in the options menu
	 */
	static function optionsframework_tabs() {
		$counter = 0;
		$options = & Options_Framework::_optionsframework_options();
		$menu = '';

		foreach ( $options as $value ) {
			// Heading for Navigation
			if ( $value['type'] == "heading" ) {
				$counter++;
				$class = '';
				$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
				$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower($class) ) . '-tab';
				$menu .= '<a id="options-group-'.  $counter . '-tab" class="nav-tab ' . $class .'" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#options-group-'.  $counter ) . '">' . esc_html( $value['name'] ) . '</a>';
			}
		}

		return $menu;
	}

	/**
	 * Generates the options fields that are used in the form.
	 */
	static function optionsframework_fields() {

		global $allowedtags;

		$options_framework = new Options_Framework;
		$option_name = $options_framework->get_option_name();
		$settings = get_option( $option_name );
		$options = & Options_Framework::_optionsframework_options();

		$counter = 0;
		$menu = '';

		// Read options array
		foreach ( $options as $value ) :

			$val = '';
			$select_value = '';
			$output = '';

			if ( $value['type'] == 'group_start' ) {

				$name = ! empty( $value['name'] ) ? esc_html( $value['name'] ) : '';

				if ( isset( $value['class'] ) ) {
					$class = ' '.$value['class'];
				}

				if ( ! $name ) {
					$class .= ' no-name';
				}

				$output .= '<div class="postbox inner-group '.$class.'">';

				if ( $name ) {
					$output .= '<h3>'.$name.'</h3>';
				}

				if ( ! empty($value['desc']) ) {
					$output .= '<div class="section-description">'.$value['desc'].'</div>';
				}

			}

			if ( $value['type'] == 'group_end' ) {
				$output .= '</div><!-- .inner-group (end) -->';
			}

			// Wrap all options
			if ( ( $value['type'] != "group_start" ) && ( $value['type'] != "group_end" ) ) {
				if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

					// Keep all ids lowercase with no spaces
					$value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );

					$id = 'section-' . $value['id'];

					$class = 'section';
					if ( isset( $value['type'] ) ) {
						$class .= ' section-' . $value['type'];
					}
					if ( isset( $value['class'] ) ) {
						$class .= ' ' . $value['class'];
					}

					$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
					if ( isset( $value['name'] ) ) {
						$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
					}
					if ( $value['type'] != 'editor' ) {
						$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
					}
					else {
						$output .= '<div class="option">' . "\n" . '<div>' . "\n";
					}
				}
			}

			// Set default value to $val
			if ( isset( $value['std'] ) ) {
				$val = $value['std'];
			}

			// If the option is already saved, override $val
			if ( ( $value['type'] != "group_start" ) && ( $value['type'] != "group_end" ) ) {
				if ( ( $value['type'] != 'heading' ) && ( $value['type'] != 'info') ) {
					if ( isset( $settings[($value['id'])]) ) {
						$val = $settings[($value['id'])];
						// Striping slashes of non-array options
						if ( !is_array($val) ) {
							$val = stripslashes( $val );
						}
					}
				}
			}

			// If there is a description save it for labels
			$explain_value = '';
			if ( isset( $value['desc'] ) ) {
				$explain_value = $value['desc'];
			}

			// Set the placeholder if one exists
			$placeholder = '';
			if ( isset( $value['placeholder'] ) ) {
				$placeholder = ' placeholder="' . esc_attr( $value['placeholder'] ) . '"';
			}

			if ( has_filter( 'optionsframework_' . $value['type'] ) ) {
				$output .= apply_filters( 'optionsframework_' . $value['type'], $option_name, $value, $val );
			}

			/*
			 * Generate options type
			 */
			switch ( $value['type'] ) :

			// Basic text input
			case 'text':
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input anva-input-text" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '"' . $placeholder . ' />';
				break;

			// Basic number input
			case 'number':
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="number" value="' . esc_attr( $val ) . '"' . $placeholder . ' />';
				break;

			// Password input
			case 'password':
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="anva-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="password" value="' . esc_attr( $val ) . '" />';
				break;

			// Textarea
			case 'textarea':
				$rows = '8';

				if ( isset( $value['settings']['rows'] ) ) {
					$custom_rows = $value['settings']['rows'];
					if ( is_numeric( $custom_rows ) ) {
						$rows = $custom_rows;
					}
				}

				$val = stripslashes( $val );
				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="anva-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '"' . $placeholder . '>' . esc_textarea( $val ) . '</textarea>';
				break;

			// Select Box
			case 'select':
				$output .= '<label class="anva-input-label" for="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '">';
				$output .= '<select class="anva-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';

				foreach ($value['options'] as $key => $option ) {
					$output .= '<option'. selected( $val, $key, false ) .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</label>';
				break;


			// Radio Box
			case "radio":
				$name = $option_name .'['. $value['id'] .']';
				foreach ($value['options'] as $key => $option) {
					$id = $option_name . '-' . $value['id'] .'-'. $key;
					$output .= '<input class="anva-input anva-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
				}
				break;

			// Image Selectors
			case "images":
				$name = $option_name .'['. $value['id'] .']';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( $val != '' && ($val == $key) ) {
						$selected = ' anva-radio-img-selected';
					}
					$output .= '<div class="anva-radio-img-box">';
					$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="anva-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. checked( $val, $key, false ) .' />';
					$output .= '<div class="anva-radio-img-label">' . esc_html( $key ) . '</div>';
					$output .= '<img src="' . esc_url( $option ) . '" alt="' . $key .'" class="anva-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
					$output .= '</div>';
				}
				$output .= '<div class="clear"></div>';
				break;

			// Checkbox
			case "checkbox":
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox anva-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
				$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags) . '</label>';
				break;

			// Logo
			case 'logo' :
				$output .= anva_logo_option( $value['id'], $option_name, $val );
				break;

			// Social Media
			case "social_media":
				$output .= anva_social_media_option( $value['id'], $option_name, $val );
				break;

			// Columns
			case 'columns' :
				$output .= anva_columns_option( $value['id'], $option_name, $val );
				break;

			// Multicheck
			case "multicheck":
				foreach ( $value['options'] as $key => $option ) {
					$checked = '';
					$label = $option;
					$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));

					$id = $option_name . '-' . $value['id'] . '-'. $option;
					$name = $option_name . '[' . $value['id'] . '][' . $option .']';

					if ( isset($val[$option]) ) {
						$checked = checked($val[$option], 1, false);
					}

					$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox anva-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				}
				break;

			// Color picker
			case "color":
				$default_color = '';
				if ( isset($value['std']) ) {
					if ( $val !=  $value['std'] )
						$default_color = ' data-default-color="' .$value['std'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" class="anva-color" type="text" value="' . esc_attr( $val ) . '"' . $default_color .' />';

				break;

			// Uploader
			case "upload":
				$output .= Options_Framework_Media_Uploader::optionsframework_uploader( $value['id'], $val, null );

				break;

			// Range Slider
			case "range":
				// $output .= anva_range_slider_fields( $value['id'], $option_name, $val );
				$output .= '<div id="' . esc_attr( $value['id'] ) . '_range"></div>';
				$output .= '<input id="' . esc_attr( $value['id'] ) .'" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" class="anva-input-range hidden" type="text" value="' . esc_attr( $val ) . '" />';
				
				break;

			// Typography
			case 'typography':

				unset( $font_size, $font_style, $font_face, $font_color );

				$typography_defaults = array(
					'size' => '',
					'face' => '',
					'style' => '',
					'color' => '',
					'google' => '',
				);

				$typography_stored = wp_parse_args( $val, $typography_defaults );

				$typography_options = array(
					'sizes' => anva_recognized_font_sizes(),
					'faces' => anva_recognized_font_faces(),
					'styles' => anva_recognized_font_styles(),
					'color' => true,
					'google' => '',
					''
				);

				if ( isset( $value['options'] ) ) {
					$typography_options = wp_parse_args( $value['options'], $typography_options );
				}

				// Font Size
				if ( $typography_options['sizes'] ) {
					$font_size = '<select class="anva-typography anva-typography-size" name="' . esc_attr( $option_name . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '">';
					$sizes = $typography_options['sizes'];
					foreach ( $sizes as $i ) {
						$size = $i . 'px';
						$font_size .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
					}
					$font_size .= '</select>';
				}

				// Font Face
				if ( $typography_options['faces'] ) {
					$font_face = '<select class="anva-typography anva-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
					$faces = $typography_options['faces'];
					foreach ( $faces as $key => $face ) {
						$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
					}
					$font_face .= '</select>';
				}

				// Font Styles
				if ( $typography_options['styles'] ) {
					$font_style = '<select class="anva-typography anva-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
					$styles = $typography_options['styles'];
					foreach ( $styles as $key => $style ) {
						$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
					}
					$font_style .= '</select>';
				}

				// Font Color
				if ( $typography_options['color'] ) {
					$default_color = '';
					if ( isset($value['std']['color']) ) {
						if ( $val !=  $value['std']['color'] )
							$default_color = ' data-default-color="' .$value['std']['color'] . '" ';
					}
					$font_color = '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="anva-color anva-typography-color  type="text" value="' . esc_attr( $typography_stored['color'] ) . '"' . $default_color .' />';
				}

				// Allow modification/injection of typography fields
				$typography_fields = compact( 'font_size', 'font_face', 'font_style', 'font_color' );
				$typography_fields = apply_filters( 'anva_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
				$output .= implode( '', $typography_fields );

				// Google Font support
				$output .= '<div id="'.$value['id'].'_google" class="google-font hidden">';
				$output .= '<h5>'.__( 'Enter the name of a font from the <a href="'.esc_url('http://www.google.com/webfonts').'" target="_blank">Google Font Directory</a>.', 'tm' ).'</h5>';
				$output .= '<input type="text" id="' . esc_attr( $value['id'] . '_google' ) . '" name="'.esc_attr( $option_name.'['.$value['id'].'][google]' ).'" value="'.esc_attr( $typography_stored['google'] ).'" />';
				$output .= '<p class="note">'. esc_html__( 'Example Font Name', anva_textdomain() ) . ': ' .'"Open Sans"</p>';
				$output .= '</div>';

				// Font preview box
				$sample_text = apply_filters( 'anva_typography_sample_text', 'Lorem Ipsum' );
				$output .= '<div id="' . esc_attr( $value['id'] . '_sample_text' ) . '" class="sample-text-font" style="font-family: Arial;">' . esc_html( $sample_text ) . '</div>';

				break;

			// Background
			case 'background':

				$background = $val;

				// Background Color
				$default_color = '';
				if ( isset( $value['std']['color'] ) ) {
					if ( $val !=  $value['std']['color'] )
						$default_color = ' data-default-color="' .$value['std']['color'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="anva-color anva-background-color"  type="text" value="' . esc_attr( $background['color'] ) . '"' . $default_color .' />';

				// Background Image
				if ( !isset($background['image']) ) {
					$background['image'] = '';
				}

				$output .= Options_Framework_Media_Uploader::optionsframework_uploader( $value['id'], $background['image'], null, esc_attr( $option_name . '[' . $value['id'] . '][image]' ) );

				$class = 'anva-background-properties';
				if ( '' == $background['image'] ) {
					$class .= ' hide';
				}
				$output .= '<div class="' . esc_attr( $class ) . '">';

				// Background Repeat
				$output .= '<select class="anva-background anva-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
				$repeats = anva_recognized_background_repeat();

				foreach ($repeats as $key => $repeat) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
				}
				$output .= '</select>';

				// Background Position
				$output .= '<select class="anva-background anva-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
				$positions = anva_recognized_background_position();

				foreach ($positions as $key=>$position) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
				}
				$output .= '</select>';

				// Background Attachment
				$output .= '<select class="anva-background anva-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
				$attachments = anva_recognized_background_attachment();

				foreach ($attachments as $key => $attachment) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</div>';

				break;

			// Editor
			case 'editor':
				$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags ) . '</div>'."\n";
				echo $output;
				$textarea_name = esc_attr( $option_name . '[' . $value['id'] . ']' );
				$default_editor_settings = array(
					'textarea_name' => $textarea_name,
					'media_buttons' => false,
					'tinymce' => array( 'plugins' => 'wordpress, wplink' )
				);
				$editor_settings = array();
				if ( isset( $value['settings'] ) ) {
					$editor_settings = $value['settings'];
				}
				$editor_settings = array_merge( $default_editor_settings, $editor_settings );
				wp_editor( $val, $value['id'], $editor_settings );
				$output = '';
				break;

			// Info
			case "info":
				$id = '';
				$class = 'section';
				if ( isset( $value['id'] ) ) {
					$id = 'id="' . esc_attr( $value['id'] ) . '" ';
				}
				if ( isset( $value['type'] ) ) {
					$class .= ' section-' . $value['type'];
				}
				if ( isset( $value['class'] ) ) {
					$class .= ' ' . $value['class'];
				}

				$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '">' . "\n";
				if ( isset($value['name']) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				if ( isset( $value['desc'] ) ) {
					$output .= '<p>' . $value['desc'] . "</p>\n";
				}
				$output .= '</div>' . "\n";
				break;

			// Heading for Navigation
			case "heading":
				$counter++;
				if ( $counter >= 2 ) {
					$output .= '</div>'."\n";
				}
				$class = '';
				$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
				$class = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($class) );
				$output .= '<div id="options-group-' . $counter . '" class="group ' . $class . '">';
				// $output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
				break;

			endswitch;

			// Close div and add descriptions
			if ( ( $value['type'] != "group_start" ) && ( $value['type'] != "group_end" ) ) {
				if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {
					
					$output .= '</div><!-- .controls (end) -->';

					if ( ( $value['type'] != "checkbox" ) && ( $value['type'] != "editor" ) ) {
						$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
					}
					$output .= '</div><!-- .option (end) -->';
					$output .= '</div><!-- .section (end) -->'."\n";
				}
			}

			// Print html output
			echo $output;
		
		endforeach;

		// Outputs closing div if there tabs
		if ( Options_Framework_Interface::optionsframework_tabs() != '' ) {
			echo '</div><!-- .tab (end) -->';

		}
	}

}