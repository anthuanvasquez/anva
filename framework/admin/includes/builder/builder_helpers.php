<?php

function page_update_custom_meta($postID, $newvalue, $field_name) {
	if (isset($_POST['pp_meta_form'])) 
	{
		if (!get_post_meta($postID, $field_name)) {
			add_post_meta($postID, $field_name, $newvalue);
		} else {
			update_post_meta($postID, $field_name, $newvalue);
		}
	}
}

/**
 * Builder elemeents
 *
 * @since 1.0.0
 */
function anva_page_builder_elements( $page_id, $post_type = 'page' ) {
	
	$ppb_form_data_order = get_post_meta($page_id, 'ppb_form_data_order');
	
	if(isset($ppb_form_data_order[0]))
	{
			$ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
	}
	
	if($post_type=='page')
	{
		$ppb_shortcodes = anva_get_builder_options();
	}
	//pp_debug($ppb_shortcodes);
	
	if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
	{
			$ppb_shortcode_code = '';
	
			foreach($ppb_form_item_arr as $key => $ppb_form_item)
			{
				$ppb_form_item_data = get_post_meta($page_id, $ppb_form_item.'_data');
				$ppb_form_item_size = get_post_meta($page_id, $ppb_form_item.'_size');
				$ppb_form_item_data_obj = json_decode($ppb_form_item_data[0]);
				//pp_debug($ppb_form_item_data_obj);
				$ppb_shortcode_content_name = $ppb_form_item_data_obj->shortcode.'_content';
				
				if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
				{
					$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
					
					//Get shortcode title
					$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
					if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
					{
						$ppb_shortcode_code.= 'title="'.esc_attr(urldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
					}
					
					//Get shortcode attributes
					$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
					
					foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
					{
						$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
						
						if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
						{
							$ppb_shortcode_code.= $attr_name.'="'.esc_attr($ppb_form_item_data_obj->$ppb_shortcode_attr_name).'" ';
						}
					}

					$ppb_shortcode_code.= ']'.wp_kses_post(urldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name)).'[/'.$ppb_form_item_data_obj->shortcode.']';
				}
				else if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
				{
					$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[0].'" ';
					
					//Get shortcode title
					$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
					if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
					{
						$ppb_shortcode_code.= 'title="'.esc_attr(urldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
					}
					
					//Get shortcode attributes
					$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
					
					foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
					{
						$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
						
						if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
						{
							$ppb_shortcode_code.= $attr_name.'="'.esc_attr($ppb_form_item_data_obj->$ppb_shortcode_attr_name).'" ';
						}
					}
					
					$ppb_shortcode_code.= ']';
				}
				
				echo tg_apply_content($ppb_shortcode_code);
				}
		}
		
		return false;
}

function tg_apply_content($pp_content) {
	$pp_content = apply_filters('the_content', $pp_content);
	$pp_content = str_replace(']]>', ']]>', $pp_content);
	return $pp_content;
}

function pp_get_image_id( $image_url ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $image_url ));
	if(isset($attachment[0])){
		return $attachment[0]; 
	}else{
		return '';
	}
}