<?php

/**
 * Builder Options
 *
 * @since 1.0.0
 */
function anva_get_builder_options() {

	//Get all galleries
	$args = array(
		'numberposts' => -1,
		'post_type' => array( 'galleries' ),
	);

	$galleries_arr = get_posts($args);
	$galleries_select = array();
	if ( count( $galleries_arr ) > 0 ) {
		$galleries_select[''] = '';
		foreach($galleries_arr as $gallery){
			$galleries_select[$gallery->ID] = $gallery->post_title;
		}
	}

	//Get all categories
	$categories_arr = get_categories();
	$categories_select = array();
	$categories_select[''] = '';

	foreach ($categories_arr as $cat) {
		$categories_select[$cat->cat_ID] = $cat->cat_name;
	}

	//Get all gallery categories
	$gallery_cats_arr           = get_terms( 'gallery_cat', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
	$gallery_cats_select        = array();
	if ( count( $gallery_cats_arr ) > 0 ) {
		$gallery_cats_select['']    = '';
		foreach ( $gallery_cats_arr as $gallery_cat ) {
			$gallery_cats_select[$gallery_cat->slug] = $gallery_cat->name;
		}
	}

	//Get all testimonials categories
	// $testimonial_cats_arr = get_terms('testimonialcats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
	// $testimonial_cats_select = array();
	// if ( count( $testimonial_cats_arr ) > 0 ) {
	// 	$testimonial_cats_select[''] = '';
	// 	foreach ($testimonial_cats_arr as $testimonial_cat) {
	// 		$testimonial_cats_select[$testimonial_cat->slug] = $testimonial_cat->name;
	// 	}
	// }

	// Get all pricing categories
	// $pricing_cat_arr = get_terms('pricingcats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
	// $pricing_cat_select = array();
	// if ( count( $pricing_cat_arr ) > 0 ) {
	// 	$pricing_cat_select[''] = '';
	// 	foreach($pricing_cat_arr as $pricing_cat){
	// 		$pricing_cat_select[$pricing_cat->slug] = $pricing_cat->name;
	// 	}
	// }

	//Get all sidebars
	$theme_sidebar = array(
		'' => '',
		'Page Sidebar' => 'Page Sidebar', 
		'Blog Sidebar' => 'Blog Sidebar', 
		'Single Post Sidebar' => 'Single Post Sidebar',
		'Single Image Page Sidebar' => 'Single Image Page Sidebar',
		'Archive Sidebar' => 'Archive Sidebar',
		'Category Sidebar' => 'Category Sidebar',
		'Search Sidebar' => 'Search Sidebar',
		'Tag Sidebar' => 'Tag Sidebar', 
		'Footer Sidebar' => 'Footer Sidebar',
	);
	$dynamic_sidebar = get_option('pp_sidebar');

	if(!empty($dynamic_sidebar))
	{
		foreach($dynamic_sidebar as $sidebar)
		{
			$theme_sidebar[$sidebar] = $sidebar;
		}
	}

	//Get order options
	$order_select = array(
		'default' 	=> 'By Default',
		'newest'	=> 'By Newest',
		'oldest'	=> 'By Oldest',
		'title'		=> 'By Title',
		'random'	=> 'By Random',
	);

	//Get column options
	$column_select = array(
		'1' => '1 Column',
		'2' => '2 Columns',
		'3'	=> '3 Columns',
		'4'	=> '4 Columns',
	);

	//Get column options
	$team_column_select = array(
		'3'	=> '3 Columns',
		'4'	=> '4 Columns',
		'5' => '5 Columns',
	);

	$testimonial_column_select = array(
		'2' => '2 Columns',
		'3'	=> '3 Columns',
		'4'	=> '4 Columns',
	);

	$gallery_column_select = array(
		'3'	=> '3 Columns',
		'4'	=> '4 Columns',
	);

	$text_block_layout_select = array(
		'fixedwidth'=> 'Fixed Width',
		'fullwidth'	=> 'Fullwidth',
	);

	$portfolio_column_select = array(
		'3'	=> '3 Columns',
		'4'	=> '4 Columns',
	);


	$portfolio_layout_select = array(
		'fullwidth'	=> 'Fullwidth',
		'fixedwidth'=> 'Fixed Width',
	);

	$gallery_layout_select = array(
		'fullwidth'	=> 'Fullwidth',
		'fixedwidth'=> 'Fixed Width',
	);

	//Get service alignment options
	$service_align_select = array(
		'left' => 'Align Left',
		'center' => 'Align Center',
		'center_nocircle' => 'Align Center No Circle',
		'boxed center' => 'Boxed Align Center',
	);

	/**
	 * Builder Options
	 *
	 * @since 1.0.0
	 */

	$ppb_shortcodes = array(
		1 => array(
			'title' => 'Elements',
		),
		'ppb_divider' => array(
			'title' =>  'Paragraph Break',
			'icon' => 'divider.png',
			'attr' => array(),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_header' => array(
			'title' =>  'Header',
			'icon' => 'header.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'width' => array(
					'title' => 'Content Width',
					'type' => 'select',
					'options' => array(
						'100%' 	=> '100%',
						'90%' 	=> '90%',
						'80%' 	=> '80%',
						'70%' 	=> '70%',
						'60%' 	=> '60%',
						'50%' 	=> '50%',
					),
					'desc' => 'Select width in percentage for this content',
				),
				/*'textalign' => array(
					'title' => 'Text Alignment',
					'type' => 'select',
					'options' => array(
						'left' 	=> 'Left',
						'center' => 'center',
						'right'	=> 'Right',
					),
					'desc' => 'Select width in percentage for this content',
				),*/
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this this block',
				),
				'fontcolor' => array(
					'title' => 'Font Color',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_header_image' => array(
			'title' =>  'Header With Background Image',
			'icon' => 'header_image.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				/*'textalign' => array(
					'title' => 'Text Alignment',
					'type' => 'select',
					'options' => array(
						'left' 	=> 'Left',
						'center' => 'center',
						'right'	=> 'Right',
					),
					'desc' => 'Select width in percentage for this content',
				),*/
				'background' => array(
					'title' => 'Background Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display as background',
				),
				'background_parallax' => array(
					'title' => 'Background Parallax',
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => 'Select to enable parallax effect to background image',
				),
				'background_position' => array(
					'title' => 'Background Position (Optional)',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'fontcolor' => array(
					'title' => 'Font Color',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_text' => array(
			'title' =>  'Text Fullwidth',
			'icon' => 'text.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'width' => array(
					'title' => 'Content Width',
					'type' => 'select',
					'options' => array(
						'100%' 	=> '100%',
						'90%' 	=> '90%',
						'80%' 	=> '80%',
						'70%' 	=> '70%',
						'60%' 	=> '60%',
						'50%' 	=> '50%',
					),
					'desc' => 'Select width in percentage for this content',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'fontcolor' => array(
					'title' => 'Font Color',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_text_image' => array(
			'title' =>  'Text With Background Image',
			'icon' => 'text_image.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'background' => array(
					'title' => 'Background Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display as background',
				),
				'background_parallax' => array(
					'title' => 'Background Parallax',
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => 'Select to enable parallax effect to background image',
				),
				'background_position' => array(
					'title' => 'Background Position (Optional)',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'fontcolor' => array(
					'title' => 'Font Color',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for content on this block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_text_sidebar' => array(
			'title' =>  'Text With Sidebar',
			'icon' => 'contact_sidebar.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'sidebar' => array(
					'Title' => 'Content Sidebar',
					'type' => 'select',
					'options' => $theme_sidebar,
					'desc' => 'You can select sidebar to display next to classic blog content',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_image_fullwidth' => array(
			'title' =>  'Image Fullwidth',
			'icon' => 'image_full.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'title' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'height' => array(
					'title' => 'Height',
					'type' => 'jslider',
					"std" => "600",
					"min" => 30,
					"max" => 1000,
					"step" => 5,
					'desc' => 'Select number of height for this content (in pixel)',
				),
				'background_position' => array(
					'title' => 'Background Position',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'display_caption' => array(
					'title' => 'Display caption',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_image_parallax' => array(
			'title' =>  'Image Parallax',
			'icon' => 'image_parallax.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'title' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'height' => array(
					'title' => 'Height',
					'type' => 'jslider',
					"std" => "600",
					"min" => 30,
					"max" => 1000,
					"step" => 5,
					'desc' => 'Select number of height for this content (in pixel)',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_image_fixed_width' => array(
			'title' =>  'Image Fixed Width',
			'icon' => 'image_fixed.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'title' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'title' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_content_half_bg' => array(
			'title' =>  'One Half Content with Background',
			'icon' => 'half_content_bg.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'background' => array(
					'title' => 'Background Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display as background',
				),
				'background_parallax' => array(
					'title' => 'Background Parallax',
					'type' => 'select',
					'options' => array(
						'' => 'No Parallax',
						'yes' => 'Yes',
					),
					'desc' => 'Select to enable parallax effect to background image',
				),
				'background_position' => array(
					'title' => 'Background Position (Optional)',
					'type' => 'select',
					'options' => array(
						'top' => 'Top',
						'center' => 'Center',
						'bottom' => 'Bottom',
					),
					'desc' => 'Select image background position option',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 400,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Content Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this content block',
				),
				'opacity' => array(
					'title' => 'Content Background Opacity',
					'type' => 'jslider',
					"std" => "100",
					"min" => 10,
					"max" => 100,
					"step" => 5,
					'desc' => 'Select background opacity for this content block',
				),
				'fontcolor' => array(
					'title' => 'Font Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for this content',
				),
				'align' => array(
					'title' => 'Content Box alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for content box',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_image_half_fixed_width' => array(
			'title' =>  'Image One Half Width',
			'icon' => 'image_half_fixed.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image' => array(
					'title' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'align' => array(
					'title' => 'Image alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for image',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_image_half_fullwidth' => array(
			'title' =>  'Image One Half Fullwidth',
			'icon' => 'image_half_full.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'image' => array(
					'title' => 'Image',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'height' => array(
					'title' => 'Height',
					'type' => 'jslider',
					"std" => "600",
					"min" => 30,
					"max" => 1000,
					"step" => 5,
					'desc' => 'Select number of height for this content (in pixel)',
				),
				'align' => array(
					'title' => 'Image alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for image',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'fontcolor' => array(
					'title' => 'Font Color',
					'type' => 'colorpicker',
					"std" => "#000000",
					'desc' => 'Select font color for title and subtitle',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_two_cols_images' => array(
			'title' =>  'Images Two Columns',
			'icon' => 'images_two_cols.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image1' => array(
					'title' => 'Image 1',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image2' => array(
					'title' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'title' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_three_cols_images' => array(
			'title' =>  'Images Three Columns',
			'icon' => 'images_three_cols.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image1' => array(
					'title' => 'Image 1',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image2' => array(
					'title' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image3' => array(
					'title' => 'Image 3',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'title' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_three_images_block' => array(
			'title' =>  'Images Three blocks',
			'icon' => 'images_three_block.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image_portrait' => array(
					'title' => 'Image Portrait',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content (Portrait image size)',
				),
				'image_portrait_align' => array(
					'title' => 'Image Portrait alignment',
					'type' => 'select',
					'options' => array(
						'left' => 'Left',
						'right' => 'Right'
					),
					'desc' => 'Select the alignment for image portrait size',
				),
				'image2' => array(
					'title' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image3' => array(
					'title' => 'Image 3',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'title' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_four_images_block' => array(
			'title' =>  'Images Four blocks',
			'icon' => 'images_four_block.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'image1' => array(
					'title' => 'Image 1',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image2' => array(
					'title' => 'Image 2',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image3' => array(
					'title' => 'Image 3',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'image4' => array(
					'title' => 'Image 4',
					'type' => 'file',
					'desc' => 'Upload image you want to display for this content',
				),
				'display_caption' => array(
					'title' => 'Display caption and description',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => '',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),
		
		2 => array(
			'title' => 'Close',
		),
		
		3 => array(
			'title' => 'Contents',
		),
		
		'ppb_galleries' => array(
			'title' =>  'Gallery Archive',
			'icon' => 'galleries.png',
			'attr' => array(
				'cat' => array(
					'title' => 'Gallery Category',
					'type' => 'select',
					'options' => $gallery_cats_select,
					'desc' => 'Select the gallery category (optional)',
				),
				'items' => array(
					'type' => 'jslider',
					"std" => "12",
					"min" => 1,
					"max" => 100,
					"step" => 1,
					'desc' => 'Enter number of items to display',
				),
				'bgcolor' => array(
					'title' => 'Background Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this content block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),
		
		'ppb_gallery_slider' => array(
			'title' =>  'Gallery Slider Fullwidth',
			'icon' => 'gallery_slider_full.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'gallery' => array(
					'title' => 'Gallery',
					'type' => 'select',
					'options' => $galleries_select,
					'desc' => 'Select the gallery you want to display',
				),
				'autoplay' => array(
					'title' => 'Auto Play',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => 'Auto play gallery image slider',
				),
				'timer' => array(
					'title' => 'Timer',
					'type' => 'jslider',
					"std" => "5",
					"min" => 1,
					"max" => 60,
					"step" => 1,
					'desc' => 'Select number of seconds for slider timer',
				),
				'caption' => array(
					'title' => 'Display Image Caption',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => 'Display gallery image caption',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_gallery_slider_fixed_width' => array(
			'title' =>  'Gallery Slider Fixed Width',
			'icon' => 'gallery_slider_fixed.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'gallery' => array(
					'title' => 'Gallery',
					'type' => 'select',
					'options' => $galleries_select,
					'desc' => 'Select the gallery you want to display',
				),
				'autoplay' => array(
					'title' => 'Auto Play',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => 'Auto play gallery image slider',
				),
				'timer' => array(
					'title' => 'Timer',
					'type' => 'jslider',
					"std" => "5",
					"min" => 1,
					"max" => 60,
					"step" => 1,
					'desc' => 'Select number of seconds for slider timer',
				),
				'caption' => array(
					'title' => 'Display Image Caption',
					'type' => 'select',
					'options' => array(
						1 => 'Yes',
						0 => 'No'
					),
					'desc' => 'Display gallery image caption',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'bgcolor' => array(
					'title' => 'Background Color',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_animated_gallery_grid' => array(
			'title' =>  'Animated Gallery Grid',
			'icon' => 'animated_grid.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'gallery_id' => array(
					'title' => 'Gallery',
					'type' => 'select',
					'options' => $galleries_select,
					'desc' => 'Select the gallery you want to display',
				),
				'logo' => array(
					'title' => 'Retina Logo or Signature Image (Optional)',
					'type' => 'file',
					'desc' => 'Enter custom logo or signature image URL',
				),
				'bgcolor' => array(
					'title' => 'Background Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#ffffff",
					'desc' => 'Select background color for this content block',
				),
				'opacity' => array(
					'title' => 'Content Background Opacity',
					'type' => 'jslider',
					"std" => "100",
					"min" => 10,
					"max" => 100,
					"step" => 5,
					'desc' => 'Select background opacity for this content block',
				),
				'fontcolor' => array(
					'title' => 'Font Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for this content',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_gallery_grid' => array(
			'title' =>  'Gallery Grid',
			'icon' => 'gallery_grid.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'gallery_id' => array(
					'title' => 'Gallery',
					'type' => 'select',
					'options' => $galleries_select,
					'desc' => 'Select the gallery you want to display',
				),
				'bgcolor' => array(
					'title' => 'Background Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#ffffff",
					'desc' => 'Select background color for this content block',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_gallery_masonry' => array(
			'title' =>  'Gallery Masonry',
			'icon' => 'gallery_masonry.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'gallery_id' => array(
					'title' => 'Gallery',
					'type' => 'select',
					'options' => $galleries_select,
					'desc' => 'Select the gallery you want to display',
				),
				'bgcolor' => array(
					'title' => 'Background Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#ffffff",
					'desc' => 'Select background color for this content block',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		'ppb_blog_grid' => array(
			'title' =>  'Blog Grid',
			'icon' => 'blog.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'cat' => array(
					'title' => 'Filter by category',
					'type' => 'select',
					'options' => $categories_select,
					'desc' => 'You can choose to display only some posts from selected category',
				),
				'items' => array(
					'type' => 'jslider',
					"std" => "9",
					"min" => 1,
					"max" => 100,
					"step" => 1,
					'desc' => 'Enter number of items to display',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'link_title' => array(
					'title' => 'Enter button title (Optional)',
					'type' => 'text',
					'desc' => 'Enter link button to display link to your blog page for example. Read more',
				),
				'link_url' => array(
					'title' => 'Button Link URL (Optional)',
					'type' => 'text',
					'desc' => 'Enter redirected link URL when button is clicked',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),

		// 'ppb_testimonial_column' => array(
		// 	'title' =>  'Testimonials',
		// 	'icon' => 'testimonial_column.png',
		// 	'attr' => array(
		// 		'slug' => array(
		// 			'title' => 'Slug (Optional)',
		// 			'type' => 'text',
		// 			'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
		// 		),
		// 		'columns' => array(
		// 			'title' => 'Columns',
		// 			'type' => 'select',
		// 			'options' => $testimonial_column_select,
		// 			'desc' => 'Select how many columns you want to display service items in a row',
		// 		),
		// 		'cat' => array(
		// 			'title' => 'Filter by testimonials category',
		// 			'type' => 'select',
		// 			'options' => $testimonial_cats_select,
		// 			'desc' => 'You can choose to display only some testimonials from selected testimonial category',
		// 		),
		// 		'items' => array(
		// 			'type' => 'jslider',
		// 			"std" => "4",
		// 			"min" => 1,
		// 			"max" => 50,
		// 			"step" => 1,
		// 			'desc' => 'Enter number of items to display',
		// 		),
		// 		'padding' => array(
		// 			'title' => 'Content Padding',
		// 			'type' => 'jslider',
		// 			"std" => "30",
		// 			"min" => 0,
		// 			"max" => 200,
		// 			"step" => 5,
		// 			'desc' => 'Select padding top and bottom value for this header block',
		// 		),
		// 		'bgcolor' => array(
		// 			'title' => 'Background Color (Optional)',
		// 			'type' => 'colorpicker',
		// 			"std" => "#f9f9f9",
		// 			'desc' => 'Select background color for this content block',
		// 		),
		// 		'fontcolor' => array(
		// 			'title' => 'Font Color (Optional)',
		// 			'type' => 'colorpicker',
		// 			"std" => "#444444",
		// 			'desc' => 'Select font color for this content',
		// 		),
		// 		'custom_css' => array(
		// 			'title' => 'Custom CSS',
		// 			'type' => 'text',
		// 			'desc' => 'You can add custom CSS style for this block (advanced user only)',
		// 		),
		// 	),
		// 	'desc' => array(),
		// 	'content' => FALSE
		// ),

		// 'ppb_pricing' => array(
		// 		'title' => 'Pricing Table',
		// 		'icon' => 'pricing_table.png',
		// 		'attr' => array(
		// 			'slug' => array(
		// 				'title' => 'Slug (Optional)',
		// 				'type' => 'text',
		// 				'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
		// 			),
		// 			'skin' => array(
		// 				'title' => 'Skin',
		// 				'type' => 'select',
		// 				'options' => array(
		// 					'light' => 'Light',
		// 					'normal' => 'Normal',
		// 				),
		// 				'desc' => 'Select skin for this content',
		// 			),
		// 			'cat' => array(
		// 				'title' => 'Filter by prciing category',
		// 				'type' => 'select',
		// 				'options' => $pricing_cat_select,
		// 				'desc' => 'You can choose to display only some items from selected pricing category',
		// 			),
		// 			'columns' => array(
		// 				'title' => 'Columns',
		// 				'type' => 'select',
		// 				'options' => array(
		// 					2 => '2 Columns',
		// 					3 => '3 Columns',
		// 					4 => '4 Columns',
		// 				),
		// 				'desc' => 'Select Number of Pricing Columns',
		// 			),
		// 			'items' => array(
		// 				'type' => 'jslider',
		// 				"std" => "4",
		// 				"min" => 1,
		// 				"max" => 50,
		// 				"step" => 1,
		// 				'desc' => 'Enter number of items to display',
		// 			),
		// 			'padding' => array(
		// 				'title' => 'Content Padding',
		// 				'type' => 'jslider',
		// 				"std" => "30",
		// 				"min" => 0,
		// 				"max" => 200,
		// 				"step" => 5,
		// 				'desc' => 'Select padding top and bottom value for this header block',
		// 			),
		// 			'highlightcolor' => array(
		// 				'title' => 'Highlight Color',
		// 				'type' => 'colorpicker',
		// 				"std" => "#001d2c",
		// 				'desc' => 'Select hightlight color for this content',
		// 			),
		// 			'bgcolor' => array(
		// 				'title' => 'Background Color (Optional)',
		// 				'type' => 'colorpicker',
		// 				"std" => "#f9f9f9",
		// 				'desc' => 'Select background color for this content block',
		// 			),
		// 			'custom_css' => array(
		// 				'title' => 'Custom CSS',
		// 				'type' => 'text',
		// 				'desc' => 'You can add custom CSS style for this block (advanced user only)',
		// 			),
		// 		),
		// 		'desc' => array(),
		// 		'content' => FALSE
		// 	),

		'ppb_contact_map' => array(
			'title' =>  'Contact Form With Map',
			'icon' => 'contact_map.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'type' => array(
					'title' => 'Map Type',
					'type' => 'select',
					'options' => array(
						'ROADMAP' => 'Roadmap',
						'SATELLITE' => 'Satellite',
						'HYBRID' => 'Hybrid',
						'TERRAIN' => 'Terrain',
					),
					'desc' => 'Select google map type',
				),
				'lat' => array(
					'title' => 'Latitude',
					'type' => 'text',
					'desc' => 'Map latitude <a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>',
				),
				'long' => array(
					'title' => 'Longtitude',
					'type' => 'text',
					'desc' => 'Map longitude <a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>',
				),
				'zoom' => array(
					'title' => 'Zoom Level',
					'type' => 'jslider',
					"std" => "8",
					"min" => 1,
					"max" => 16,
					"step" => 1,
					'desc' => 'Enter zoom level',
				),
				'popup' => array(
					'title' => 'Popup Text',
					'type' => 'text',
					'desc' => 'Enter text to display as popup above location on map for example. your company name',
				),
				'marker' => array(
					'title' => 'Custom Marker Icon (Optional)',
					'type' => 'file',
					'desc' => 'Enter custom marker image URL',
				),
				'bgcolor' => array(
					'title' => 'Background Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#f9f9f9",
					'desc' => 'Select background color for this content block',
				),
				'fontcolor' => array(
					'title' => 'Font Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#444444",
					'desc' => 'Select font color for this content',
				),
				'buttonbgcolor' => array(
					'title' => 'Button Background Color (Optional)',
					'type' => 'colorpicker',
					"std" => "#000000",
					'desc' => 'Select background color for contact form button',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_contact_sidebar' => array(
			'title' =>  'Contact Form With Sidebar',
			'icon' => 'contact_sidebar.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'subtitle' => array(
					'title' => 'Sub Title (Optional)',
					'type' => 'text',
					'desc' => 'Enter short description for this header',
				),
				'sidebar' => array(
					'Title' => 'Content Sidebar',
					'type' => 'select',
					'options' => $theme_sidebar,
					'desc' => 'You can select sidebar to display next to classic blog content',
				),
				'padding' => array(
					'title' => 'Content Padding',
					'type' => 'jslider',
					"std" => "30",
					"min" => 0,
					"max" => 200,
					"step" => 5,
					'desc' => 'Select padding top and bottom value for this header block',
				),
				'custom_css' => array(
					'title' => 'Custom CSS',
					'type' => 'text',
					'desc' => 'You can add custom CSS style for this block (advanced user only)',
				),
			),
			'desc' => array(),
			'content' => TRUE
		),

		'ppb_map' => array(
			'title' =>  'Fullwidth Map',
			'icon' => 'googlemap.png',
			'attr' => array(
				'slug' => array(
					'title' => 'Slug (Optional)',
					'type' => 'text',
					'desc' => 'The "slug" is the URL-friendly version of this content. It is usually all lowercase and contains only letters, numbers, and hyphens.',
				),
				'type' => array(
					'title' => 'Map Type',
					'type' => 'select',
					'options' => array(
						'ROADMAP' => 'Roadmap',
						'SATELLITE' => 'Satellite',
						'HYBRID' => 'Hybrid',
						'TERRAIN' => 'Terrain',
					),
					'desc' => 'Select google map type',
				),
				'height' => array(
					'title' => 'Height',
					'type' => 'jslider',
					"std" => "600",
					"min" => 10,
					"max" => 1000,
					"step" => 10,
					'desc' => 'Select map height (in px)',
				),
				'lat' => array(
					'title' => 'Latitude',
					'type' => 'text',
					'desc' => 'Map latitude <a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>',
				),
				'long' => array(
					'title' => 'Longtitude',
					'type' => 'text',
					'desc' => 'Map longitude <a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>',
				),
				'zoom' => array(
					'title' => 'Zoom Level',
					'type' => 'jslider',
					"std" => "8",
					"min" => 1,
					"max" => 16,
					"step" => 1,
					'desc' => 'Enter zoom level',
				),
				'popup' => array(
					'title' => 'Popup Text',
					'type' => 'text',
					'desc' => 'Enter text to display as popup above location on map for example. your company name',
				),
				'marker' => array(
					'title' => 'Custom Marker Icon (Optional)',
					'type' => 'file',
					'desc' => 'Enter custom marker image URL',
				),
			),
			'desc' => array(),
			'content' => FALSE
		),
	);

	$ppb_shortcodes[4] = array(
		'title' => 'Close',
	);

	return $ppb_shortcodes;
}