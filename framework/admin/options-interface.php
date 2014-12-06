<?php

/**
 * Options interface.
 * @since 1.3.1
 */
function anva_settings_inputs( $tab ) {
	
	global $options;
	
	$settings = unserialize(ANVA_SETTINGS);

	$output = '';

	foreach( $options as $value ) {

		if ( $tab == $value['tab'] ) {


			if( $value['type'] != 'open' && $value['type'] != 'close' ) {
				$id = $value['id'];
				$id_name = $value['name'];
				$id_desc = $value['desc'];
				$id_class = strtolower($value['name']);
				$id_class = str_replace(' ', '-', $id_class);
			}

			if( 'image' == $value['type'] ) {

				$image = $settings[$id];

				$output .= '<div id="section-'.$id_class.'" class="inner-section section-input-'.$value['type'].'">';
				
				if( isset( $value['title'] ) ) $output .= '<h3>'.$value['title'].'</h3>';

				$output .= '<h4 class="heading">'.$id_name.'</h4>';
				$output .= '<div class="option-wrapper">';
				$output .= '<div class="control">';
				$output .= '<input type="text" id="'.$id.'" name="'.$id.'" value="'.$settings[$id].'">';
				
				if( ! empty( $image ) ) {
					$output .= '<div class="image-wrapper">';
					$output .= '<a href="'. esc_url( $image . '?TB_iframe=true&width=600&height=550' ) .'" class="thickbox" title="'. $value['name'] .'">';
					$output .= '<img src="'. esc_url( $image ) .'" class="image-preview" alt="'.$id_name.'" /></a>';
					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '<div class="description">'.$id_desc.'</div>';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			if( 'radio' == $value['type'] ) {

				$radio = $settings[$value['id']];

				$output .= '<div id="section-'.$id_class.'" class="inner-section section-input-'.$value['type'].'">';
				$output .= '<h4 class="heading">'.$id_name.'</h4>';
				$output .= '<div class="option-wrapper">';
				$output .= '<div class="control">';

				foreach( $value['options'] as $key => $option ) {
					$output .= '<div class="radio-input">';
					$output .= '<input id="'. $value['id'] .'" name="'. $value['id'] .'" type="radio" '. checked($radio, $key, false).' value="'.$key.'">';
					$output .= '<label for="'.$value['id'].'">'.$option.'</label>';
					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '<div class="description">'.$id_desc.'</div>';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			if( 'text' == $value['type'] ) {

				$output .= '<div id="section-'.$id_class.'" class="inner-section section-input-'.$value['type'].'">';
				$output .= '<h4 class="heading">'.$id_name.'</h4>';
				$output .= '<div class="option-wrapper">';
				$output .= '<div class="control">';
				$output .= '<input type="text" id="'.$id.'" name="'.$id.'" value="'.$settings[$id].'">';
				$output .= '</div>';
				$output .= '<div class="description">'.$id_desc.'</div>';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			if( 'textarea' == $value['type'] ) {
				$output .= '<div id="section-'.$id_class.'" class="inner-section section-input-'.$value['type'].'">';
				$output .= '<h4 class="heading">'.$id_name.'</h4>';
				$output .= '<div class="option-wrapper">';
				$output .= '<div class="control">';
				$output .= '<textarea id="'.$id.'" name="'.$id.'" rows="5">'.esc_textarea($settings[$id]).'</textarea>';
				$output .= '</div>';
				$output .= '<div class="description">'.$id_desc.'</div>';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			if( 'url' == $value['type'] ) {
				
				$output .= '<div id="section-'.$id_class.'" class="inner-section section-input-'.$value['type'].'">';
				$output .= '<h4 class="heading">'.$id_name.'</h4>';
				$output .= '<div class="option-wrapper">';
				$output .= '<div class="control">';
				$output .= '<input type="url" id="'.$id.'" name="'.$id.'" value="'.$settings["$id"].'">';
				$output .= '</div>';
				$output .= '<div class="description">'.$id_desc.'</div>';
				$output .= '<div class="clear"></div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			// Open Section
			if( 'open' == $value['type'] ) {
				$output .= '<div class="postbox section-open">';
				if( isset( $value['title'] ) && ! empty( $value['title'] ) )
					$output .= '<h3>'.$value['title'].'</h3>';

				if( isset( $value['msg'] ) && ! empty( $value['msg'] ) )
					$output .= '<div class="section-description">'.$value['msg'].'</div>';
			}

			// Close Section
			if( 'close' == $value['type'] ) {
				$output .= '</div>';
			}

		}
	}

	return $output;
	
}