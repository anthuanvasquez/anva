<?php

/**
 * Get all theme locals.
 *
 * @since  1.0.0
 * @return array $localize 
 */
function anva_get_text_locals() {
	
	$localize = array(
		'blog'                 => __( 'Blog', 'anva' ),
		'asc'                  => __( 'ASC', 'anva' ),
		'desc'                 => __( 'DESC', 'anva' ),
		'posts_number'         => __( 'Posts Number', 'anva' ),
		'order_by'             => __( 'Order by', 'anva' ),
		'rand'                 => __( 'Random', 'anva' ),
		'show_thumbnails'      => __( 'Show Thumbnails', 'anva' ),
		'menu'                 => __( 'Menu', 'anva' ),
		'menu_primary'         => __( 'Primary Menu', 'anva' ),
		'menu_secondary'       => __( 'Secondary Menu', 'anva' ),
		'menu_message'         => __( 'Please set the menu in Administration / Appearance / Menus', 'anva' ),
		'404_title'            => __( 'Whoops! page not found', 'anva' ),
		'404_sub_title'		   => __( 'Ooopps.! The Page you were looking for, couldn\'t be found.', 'anva' ),
		'404_description'      => __( 'Try doing a search on the site or return to the home page.', 'anva' ),
		'not_found'            => __( 'No posts found', 'anva' ),
		'not_found_content'    => __( 'No posts found.', 'anva' ),
		'read_more'            => __( 'Read More', 'anva' ),
		'prev'                 => __( 'Previous', 'anva' ),
		'next'                 => __( 'Next', 'anva' ),
		'comment_prev'         => __( 'Previous Comments', 'anva' ),
		'comment_next'         => __( 'Next Comments', 'anva' ),
		'no_comment'           => __( 'Comments close.', 'anva' ),
		'search_for'           => __( 'Search for', 'anva' ),
		'search_result'        => __( 'Search Results for', 'anva' ),
		'search'               => __( 'Search', 'anva' ),
		'video'                => __( 'Video', 'anva'),
		'page'                 => __( 'Page', 'anva' ),
		'pages'                => __( 'Pages', 'anva' ),
		'edit_post'            => __( 'Edit Post', 'anva' ),
		'page_options'         => __( 'Page Options', 'anva'),
		'page_title'           => __( 'Page Title', 'anva' ),
		'page_title_show'      => __( 'Show Title', 'anva' ),
		'page_title_hide'      => __( 'Hide Title', 'anva' ),
		'sidebar_title'        => __( 'Sidebar Column', 'anva' ),
		'sidebar_left'         => __( 'Sidebar Left', 'anva' ),
		'sidebar_right'        => __( 'Sidebar Right', 'anva' ),
		'sidebar_fullwidth'    => __( 'Sidebar Full Width', 'anva' ),
		'sidebar_double'       => __( 'Double Sidebar', 'anva' ),
		'sidebar_double_left'  => __( 'Double Sidebar Left', 'anva' ),
		'sidebar_double_right' => __( 'Double Sidebar Right', 'anva' ),
		'post_grid'            => __( 'Post Grid', 'anva' ),
		'grid_2_columns'       => __( '2 Columns', 'anva' ),
		'grid_3_columns'       => __( '3 Columns', 'anva' ),
		'grid_4_columns'       => __( '4 Columns', 'anva' ),
		'posted_on'            => __( 'Posted on', 'anva' ),
		'by'                   => __( 'by', 'anva' ),
		'day'                  => __( 'Day', 'anva' ),
		'month'                => __( 'Month', 'anva' ),
		'year'                 => __( 'Year', 'anva' ),
		'author'               => __( 'Author', 'anva' ),
		'asides'               => __( 'Asides', 'anva' ),
		'galleries'            => __( 'Galleries', 'anva'),
		'images'               => __( 'Images', 'anva'),
		'videos'               => __( 'Videos', 'anva' ),
		'quotes'               => __( 'Quotes', 'anva' ),
		'links'                => __( 'Links', 'anva' ),
		'status'               => __( 'Estatus', 'anva' ),
		'audios'               => __( 'Audios', 'anva' ),
		'chats'                => __( 'Chats', 'anva' ),
		'archives'             => __( 'Archives', 'anva' ),
		'name'                 => __( 'Name', 'anva' ),
		'name_place'           => __( 'Complete Name', 'anva' ),
		'name_required'        => __( 'Please enter your name.', 'anva' ),
		'email'                => __( 'E-Mail', 'anva' ),
		'email_place'          => __( 'E-Mail', 'anva' ),
		'email_required'       => __( 'Please enter a valid Email.', 'anva'),
		'email_error'          => __( 'The E-Mail must have a valid format ex. name@email.com.', 'anva' ),
		'subject'              => __( 'Subject', 'anva' ),
		'subject_required'     => __( 'Please enter a subject.', 'anva' ),
		'message'              => __( 'Message', 'anva' ),
		'message_place'        => __( 'Message', 'anva' ),
		'message_required'     => __( 'Please enter your message.', 'anva' ),
		'message_min'          => __( 'Must enter minimun char lenth 10.', 'anva' ),
		'mobile'               => __( 'Mobile', 'anva' ),
		'company_name'         => __( 'Company Name', 'anva' ),
		'captcha_place'        => __( 'Enter the result', 'anva' ),
		'captcha_required'     => __( 'Enter the captcha result.', 'anva' ),
		'captcha_number'       => __( 'The answer must a integer number.', 'anva' ),
		'captcha_equalto'      => __( 'Incorrect answer.', 'anva' ),
		'submit'               => __( 'Submit Message', 'anva' ),
		'submit_message'       => __( 'Thanks, your E-Mail send succefully.', 'anva' ),
		'submit_error'         => __( 'Sorry, verify the required fields.', 'anva' ),
		'footer_copyright'     => __( 'All Rights Reserved' , 'anva' ),
		'footer_text'          => __( 'Design by', 'anva' ),
		'get_in_touch'         => __( 'Get in Touch', 'anva' ),
		'home'                 => __( 'Home', 'anva' ),
		'add_autop'            => __( 'Add automatic Paragraph', 'anva' ),
		'featured_image'       => __( 'Featured Image', 'anva' ),
		'options'              => __( 'Options', 'anva' ),
		'browsehappy'          => __( 'You are using an outdated browser. Update your browser to <a href="%s">improve your web experience</a>.', 'anva' ),
		'skype'                => __( 'Skype', 'anva' ),
		'phone'                => __( 'Phone', 'anva' ),
		'title'                => __( 'Title', 'anva' ),
		'date'                 => __( 'Date', 'anva' ),
		'order'                => __( 'Order', 'anva' ),
		'image'                => __( 'Image', 'anva' ),
		'link'                 => __( 'Link', 'anva' ),
		'image_url'            => __( 'Image URL', 'anva' ),
		'url'                  => __( 'URL', 'anva' ),
		'slide_id'             => __( 'Slide ID', 'anva' ),
		'slide_area'           => __( 'Select the Slide area', 'anva' ),
		'slide_content'        => __( 'Hide or Show content', 'anva' ),
		'slide_title'          => __( 'Show title only', 'anva' ),
		'slide_desc'           => __( 'Show description only', 'anva' ),
		'slide_show'           => __( 'Show title and description', 'anva' ),
		'slide_hide'           => __( 'Hide Both', 'anva' ),
		'slide_meta'           => __( 'Slide Options', 'anva' ),
	);

	return apply_filters( 'anva_text_locals', $localize );

}

/**
 * Get separate local.
 *
 * @since  1.0.0
 * @param  string $id
 * @return string $text
 */
function anva_get_local( $id ) {

	$text = null;
	$localize = anva_get_text_locals();

	if ( isset( $localize[ $id ] ) ) {
		$text = $localize[ $id ];
	}

	return $text;
}

/**
 * Get all js locals.
 *
 * @since  1.0.0
 * @return array $localize
 */
function anva_get_js_locals() {
	
	$localize = array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'themeUrl' => get_template_directory_uri(),
		'themeImages' => get_template_directory_uri() . '/assets/images',
	);

	return apply_filters( 'anva_get_js_locals', $localize );
}