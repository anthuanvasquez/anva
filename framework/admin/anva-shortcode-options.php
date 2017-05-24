<?php

/**
 * Shortcode options generator.
 *
 * @return array $shortcodes
 */
function anva_get_shortcode_options() {

	// Get all pricing categories.
	$pricing_cat_arr        = get_terms( 'pricingcats', 'hide_empty=0&hierarchical=0&parent=0' );
	$pricing_cat_select     = array();
	$pricing_cat_select[''] = '';

	foreach ( $pricing_cat_arr as $pricing_cat ) {
		if ( is_object( $pricing_cat ) ) {
			$pricing_cat_select[ $pricing_cat->slug ] = $pricing_cat->name;
		}
	}

	// Get all testimonials categories.
	$testimonial_cat_arr        = get_terms( 'testimonialcats', 'hide_empty=0&hierarchical=0&parent=0' );
	$testimonial_cat_select     = array();
	$testimonial_cat_select[''] = '';

	foreach ( $testimonial_cat_arr as $testimonial_cat ) {
		if ( is_object( $testimonial_cat ) ) {
			$testimonial_cat_select[$testimonial_cat->slug] = $testimonial_cat->name;
		}
	}

	// Begin shortcode array.
	$shortcodes = array(
		'dropcap' => array(
			'name'    => __( 'Dropcap', 'anva' ),
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
		),
		'quote' => array(
			'name'    => __( 'Quote Text', 'anva' ),
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
		),
		'button' => array(
			'name' => __( 'Button', 'anva' ),
			'attr' => array(
				'href'       => 'text',
				'color'      => 'select',
				'bg_color'   => 'colorpicker',
				'text_color' => 'colorpicker',
			),
			'title' => array(
				'href'       => __( 'URL', 'anva' ),
				'color'      => __( 'Skin', 'anva' ),
				'bg_color'   => __( 'Custom Background Color (Optional)', 'anva' ),
				'text_color' => __( 'Custom Font Color (Optional)', 'anva' ),
			),
			'desc' => array(
				'href'       => __( 'Enter URL for button', 'anva' ),
				'color'      => __( 'Select predefined button colors', 'anva' ),
				'bg_color'   => __( 'Enter custom button background color code ex. #4ec380', 'anva' ),
				'text_color' => __( 'Enter custom button text color code ex. #ffffff', 'anva' ),
			),
			'options' => array(
				'color' => anva_get_button_colors(),
			),
			'content'      => true,
			'content_text' => __( 'Enter text on button', 'anva' ),
		),
		'alert_box' => array(
			'name' => 'Alert Box',
			'attr' => array(
				'style' => 'select',
			),
			'title' => array(
				'style' => 'Type',
			),
			'desc' => array(
				'style' => 'Select alert box type',
			),
			'options' => array(
				'style' => array(
					'error'   => __( 'Error', 'anva' ),
					'success' => __( 'Success', 'anva' ),
					'notice'  => __( 'Notice', 'anva' ),
				),
			),
			'content' => true,
		),
		'one_half' => array(
			'name'    => 'One Half Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
			'repeat'  => 1,
		),
		'one_half_last' => array(
			'name'    => 'One Half Last Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
			'repeat'  => 1,
		),
		'one_third' => array(
			'name'    => 'One Third Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
			'repeat'  => 2,
		),
		'one_third_last' => array(
			'name'    => 'One Third Last Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
		),
		'two_third' => array(
			'name'    => 'Two Third Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
		),
		'two_third_last' => array(
			'name'    => 'Two Third Last Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
		),
		'one_fourth' => array(
			'name'    => 'One Fourth Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
			'repeat'  => 3,
		),
		'one_fifth' => array(
			'name'    => 'One Fifth Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
			'repeat'  => 4,
		),
		'one_sixth' => array(
			'name'    => 'One Sixth Column',
			'attr'    => array(),
			'desc'    => array(),
			'content' => true,
			'repeat'  => 5,
		),
		'one_half_bg' => array(
			'name' => 'One Half Column With Background',
			'attr' => array(
				'bgcolor'   => 'colorpicker',
				'fontcolor' => 'colorpicker',
				'padding'   => 'text',
			),
			'title' => array(
				'bgcolor'   => 'Background Color',
				'fontcolor' => 'Font Color',
				'padding'   => 'Padding (Optional)',
			),
			'desc' => array(
				'bgcolor'   => 'Select background color',
				'fontcolor' => 'Select font color',
				'padding'   => 'Enter padding for this content (in px)',
			),
			'content' => true,
		),
		'one_third_bg' => array(
			'name' => 'One Third Column With Background',
			'attr' => array(
				'bgcolor'   => 'colorpicker',
				'fontcolor' => 'colorpicker',
				'padding'   => 'text',
			),
			'title' => array(
				'bgcolor'   => 'Background Color',
				'fontcolor' => 'Font Color',
				'padding'   => 'Padding (Optional)',
			),
			'desc' => array(
				'bgcolor'   => 'Select background color',
				'fontcolor' => 'Select font color',
				'padding'   => 'Enter padding for this content (in px)',
			),
			'content' => true,
		),
		'two_third_bg' => array(
			'name' => 'Two Third Column With Background',
			'attr' => array(
				'bgcolor'   => 'colorpicker',
				'fontcolor' => 'colorpicker',
				'padding'   => 'text',
			),
			'title' => array(
				'bgcolor'   => 'Background Color',
				'fontcolor' => 'Font Color',
				'padding'   => 'Padding (Optional)',
			),
			'desc' => array(
				'bgcolor'   => 'Select background color',
				'fontcolor' => 'Select font color',
				'padding'   => 'Enter padding for this content (in px)',
			),
			'content' => true,
		),
		'one_fourth_bg' => array(
			'name' => 'One Fourth Column With Background',
			'attr' => array(
				'bgcolor'   => 'colorpicker',
				'fontcolor' => 'colorpicker',
				'padding'   => 'text',
			),
			'title' => array(
				'bgcolor'   => 'Background Color',
				'fontcolor' => 'Font Color',
				'padding'   => 'Padding (Optional)',
			),
			'desc' => array(
				'bgcolor'   => 'Select background color',
				'fontcolor' => 'Select font color',
				'padding'   => 'Enter padding for this content (in px)',
			),
			'content' => true,
		),
		'map' => array(
			'name' => 'Google Map',
			'attr' => array(
				'type'   => 'select',
				'width'  => 'text',
				'height' => 'text',
				'lat'    => 'text',
				'long'   => 'text',
				'zoom'   => 'text',
				'popup'  => 'text',
				'marker' => 'text',
			),
			'title' => array(
				'type'   => __( 'Map Type', 'anva' ),
				'width'  => __( 'Width', 'anva' ),
				'height' => __( 'Height', 'anva' ),
				'lat'    => __( 'Latitude', 'anva' ),
				'long'   => __( 'Longtitude', 'anva' ),
				'zoom'   => __( 'Zoom Level', 'anva' ),
				'popup'  => __( 'Popup Text (Optional)', 'anva' ),
				'marker' => __( 'Custom Marker Icon (Optional)', 'anva' ),
			),
			'desc' => array(
				'type'   => __( 'Select map display type', 'anva' ),
				'width'  => __( 'Map width in pixels', 'anva' ),
				'height' => __( 'Map height in pixels', 'anva' ),
				'lat'    => __( 'Map latitude <a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>', 'anva' ),
				'long'   => __( 'Map longitude <a href="http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/">Find here</a>', 'anva' ),
				'zoom'   => __( 'Enter zoom number (1-16)', 'anva' ),
				'popup'  => __( 'Enter text to display as popup above location on map for example. your company name', 'anva' ),
				'marker' => __( 'Enter custom marker image URL', 'anva' ),
			),
			'content' => false,
			'options' => array(
				'type' => array(
					'ROADMAP'   => __( 'Roadmap', 'anva' ),
					'SATELLITE' => __( 'Satellite', 'anva' ),
					'HYBRID'    => __( 'Hybrid', 'anva' ),
					'TERRAIN'   => __( 'Terrain', 'anva' ),
				)
			),
		),
		'googlefont' => array(
			'name' => 'Google Font',
			'attr' => array(
				'font'     => 'text',
				'fontsize' => 'text',
				'style'    => 'text',
			),
			'title' => array(
				'font'     => 'Font Name',
				'fontsize' => 'Font Size',
				'style'    => 'Custom CSS style ex. font-style:italic; (Optional)',
			),
			'desc' => array(
				'font'     => 'Enter Google Web Font Name you want to use',
				'fontsize' => 'Enter font size in pixels',
				'style'    => 'Enter custom CSS styling code',
			),
			'content' => true,
		),
		'thumb_gallery' => array(
			'name' => 'Gallery Thumbnails',
			'attr' => array(
				'gallery_id' => 'select',
				'width'      => 'text',
				'height'     => 'text',
			),
			'title' => array(
				'gallery_id' => 'Gallery',
				'width'      => 'Width',
				'height'     => 'Height',
			),
			'desc' => array(
				'gallery_id' => 'Select gallery you want to display its images',
				'width'      => 'Gallery image width in pixels',
				'height'     => 'Gallery image height in pixels',
			),
			'options' => array(
				'gallery_id' => anva_pull_galleries(),
			),
			'content' => false,
		),
		'grid_gallery' => array(
			'name' => 'Gallery Grid',
			'attr' => array(
				'gallery_id' => 'select',
				'layout' => 'select',
				'columns' => 'select',
			),
			'title' => array(
				'gallery_id' => 'Gallery',
				'layout' => 'Layout',
				'columns' => 'Columns',
			),
			'desc' => array(
				'gallery_id' => 'Select gallery you want to display its images',
				'layout'     => 'Select gallery layout you to display its images',
				'columns'    => 'Select gallery columns you to display its images',
			),
			'options' => array(
				'gallery_id' => anva_pull_galleries(),
				'layout' => array(
					'contain' => 'Contain',
					'wide' => 'Wide',
				),
				'columns' => array(
					2 => '2 Colmuns',
					3 => '3 Colmuns',
					4 => '4 Colmuns',
				),
			),
			'content' => false,
		),
		'masonry_gallery' => array(
			'name' => 'Gallery Masonry',
			'attr' => array(
				'gallery_id' => 'select',
				'layout' => 'select',
				'columns' => 'select',
			),
			'title' => array(
				'gallery_id' => 'Gallery',
				'layout' => 'Layout',
				'columns' => 'Columns',
			),
			'desc' => array(
				'gallery_id' => __( 'Select gallery you want to display its images', 'anva' ),
				'layout'     => __( 'Select gallery layout you to display its images', 'anva' ),
				'columns'    => __( 'Select gallery columns you to display its images', 'anva' ),
			),
			'options' => array(
				'gallery_id' => anva_pull_galleries(),
				'layout' => array(
					'contain' => 'Contain',
					'wide'    => 'Wide',
				),
				'columns' => array(
					2 => __( '2 Colmuns', 'anva' ),
					3 => __( '3 Colmuns', 'anva' ),
					4 => __( '4 Colmuns', 'anva' ),
				),
			),
			'content' => false,
		),
		'gallery_slider' => array(
			'name' => 'Gallery Slider',
			'attr' => array(
				'gallery_id' => 'select',
			),
			'title' => array(
				'gallery_id' => 'Gallery',
			),
			'desc' => array(
				'gallery_id' => 'Select gallery you want to display its images',
			),
			'options' => array(
				'gallery_id' => anva_pull_galleries()
			),
			'content' => false,
		),
		'social_icons' => array(
			'name' => 'Social Icons',
			'attr' => array(
				'style' => 'select',
				'size' => 'text',
			),
			'title' => array(
				'style' => 'Color Style',
				'size' => 'Icon Size',
			),
			'desc' => array(
				'style' => 'Select color style for social icons',
				'size'  => 'Enter icon size between small and large',
			),
			'options' => array(
				'style' => array(
					'dark' => 'Dark',
					'light' => 'Light',
				)
			),
			'content' => false,
		),
		'social_share' => array(
			'name' => 'Social Share',
			'attr' => array(),
			'content' => false,
		),
		'promo_box' => array(
			'name' => 'Promo Box',
			'attr' => array(
				'title'       => 'text',
				'bgcolor'     => 'colorpicker',
				'fontcolor'   => 'colorpicker',
				'bordercolor' => 'colorpicker',
				'button_text' => 'text',
				'button_url'  => 'text',
				'buttoncolor' => 'colorpicker',
			),
			'title' => array(
				'title'       => __( 'Title (Optional)', 'anva' ),
				'bgcolor'     => __( 'Background Color', 'anva' ),
				'fontcolor'   => __( 'Font Color', 'anva' ),
				'bordercolor' => __( 'Border Color', 'anva' ),
				'button_text' => __( 'Button Text', 'anva' ),
				'button_url'  => __( 'Button Link URL', 'anva' ),
				'buttoncolor' => __( 'Button Color', 'anva' ),
			),
			'desc' => array(
				'title'       => __( 'Enter promo box title', 'anva' ),
				'bgcolor'     => __( 'Select background color for this content', 'anva' ),
				'fontcolor'   => __( 'Select font color for this content', 'anva' ),
				'bordercolor' => __( 'Select border color for this content', 'anva' ),
				'button_text' => __( 'Enter promo box button text. For example More Info', 'anva' ),
				'button_url'  => __( 'Enter promo box button link URL', 'anva' ),
				'bordercolor' => __( 'Select button color', 'anva' ),
			),
			'content' => true,
		),
		'accordion' => array(
			'name' => 'Accordion & Toggle',
			'attr' => array(
				'title' => 'text',
				'icon'  => 'text',
				'close' => 'select',
			),
			'title' => array(
				'title' => 'Title',
				'icon'  => 'Icon (optional)',
				'close' => 'Open State',
			),
			'desc' => array(
				'title' => __( 'Enter Accordion\'s title', 'anva' ),
				'icon'  => __( 'Enter icon class name ex. fa-star. <a href="http://fontawesome.io/cheatsheet/">See all possible here</a>', 'anva' ),
				'close' => __( 'Select default status (close or open)', 'anva' ),
			),
			'content' => true,
			'options' => array(
				'close' => array(
					0 => 'Open',
					1 => 'Close',
				)
			),
		),
		'image' => array(
			'name' => 'Image Animation',
			'attr' => array(
				'src'       => 'text',
				'animation' => 'select',
				'frame'     => 'select',
			),
			'title' => array(
				'src'       => 'Image URL',
				'animation' => 'Animation Type',
				'frame'     => 'Frame Style',
			),
			'desc' => array(
				'src'       => 'Enter image URL',
				'animation' => 'Select animation type',
				'frame'     => 'Select image frame style',
			),
			'content' => true,
			'options' => array(
				'animation' => array(
					'slideRight' => 'Slide Right',
					'slideLeft'  => 'Slide Left',
					'slideUp'    => 'Slide Up',
					'fadeIn'     => 'Fade In',
				),
				'frame' => array(
					''             => 'None',
					'border'       => 'Border',
					'glow'         => 'Glow',
					'dropshadow'   => 'Drop Shadow',
					'bottomshadow' => 'Bottom Shadow',
				),
			),
			'content' => false,
		),
		'divider' => array(
			'name' => 'Divider',
			'attr' => array(
				'style' => 'select',
			),
			'title' => array(
				'style' => 'Style',
			),
			'desc' => array(
				'style' => 'Select HR divider style',
			),
			'options' => array(
				'style' => array(
					'normal' => 'Normal',
					'thick'  => 'Thick',
					'dotted' => 'Dotted',
					'dashed' => 'Dashed',
					'faded'  => 'Faded',
					'totop'  => 'Go To Top',
				)
			),
			'content' => false,
		),
		'teaser' => array(
			'name' => 'Image Teaser',
			'attr' => array(
				'columns'   => 'select',
				'image'     => 'text',
				'title'     => 'text',
				'align'     => 'select',
				'bgcolor'   => 'colorpicker',
				'fontcolor' => 'colorpicker',
			),
			'title' => array(
				'columns'   => 'Columns Type',
				'image'     => 'image URL',
				'title'     => 'Title',
				'align'     => 'Content Align',
				'bgcolor'   => 'Background Color',
				'fontcolor' => 'Font Color',
			),
			'desc' => array(
				'columns'   => __( 'Select columns for image teaser', 'anva' ),
				'image'     => __( 'Enter full image URL', 'anva' ),
				'title'     => __( 'Enter teaser title', 'anva' ),
				'align'     => __( 'Enter teaser content text align from left, center and right', 'anva' ),
				'bgcolor'   => __( 'Select background color for this content', 'anva' ),
				'fontcolor' => __( 'Select font color for this content', 'anva' ),
			),
			'options' => array(
				'columns' => array(
					'one'             => __( 'Fullwidth', 'anva' ),
					'one_half'        => __( 'One Half', 'anva' ),
					'one_half last'   => __( 'One Half Last', 'anva' ),
					'one_third'       => __( 'One Third', 'anva' ),
					'one_half last'   => __( 'One Third Last', 'anva' ),
					'one_fourth'      => __( 'One Fourth', 'anva' ),
					'one_fourth last' => __( 'One Fourth Last', 'anva' ),
				),
				'align' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
			),
			'content' => true,
		),
		'lightbox' => array(
			'name' => 'Media Lightbox',
			'attr' => array(
				'type' => 'select',
				'src' => 'text',
				'href' => 'text',
				'vimeo_id' => 'text',
				'youtube_id' => 'text',
			),
			'title' => array(
				'type' => 'Content Type',
				'src' => 'Image URL',
				'href' => 'Link URL',
				'vimeo_id' => 'Vimeo Video ID',
				'youtube_id' => 'Youtube Video ID',
			),
			'desc' => array(
				'type'       => __( 'Select ligthbox content type', 'anva' ),
				'src'        => __( 'Enter lightbox preview image URL', 'anva' ),
				'href'       => __( 'If you selected "Image". Enter full image URL here', 'anva' ),
				'vimeo_id'   => __( 'If you selected "Vimeo". Enter Vimeo video ID here ex. 82095744', 'anva' ),
				'youtube_id' => __( 'If you selected "Youtube". Enter Youtube video ID here ex. hT_nvWreIhg', 'anva' ),
			),
			'content' => true,
			'options' => array(
				'type' => array(
					'image' => 'Image',
					'vimeo' => 'Vimeo',
					'youtube' => 'Youtube',
				)
			),
			'content' => false,
		),
		'youtube' => array(
			'name' => 'Youtube Video',
			'attr' => array(
				'width' => 'text',
				'height' => 'text',
				'video_id' => 'text',
			),
			'title' => array(
				'width' => 'Width',
				'height' => 'Height',
				'video_id' => 'Youtube Video ID',
			),
			'desc' => array(
				'width'    => 'Enter video width in pixels',
				'height'   => 'Enter video height in pixels',
				'video_id' => 'Enter Youtube video ID here ex. hT_nvWreIhg',
			),
			'content' => false,
		),
		'vimeo' => array(
			'name' => 'Vimeo Video',
			'attr' => array(
				'width' => 'text',
				'height' => 'text',
				'video_id' => 'text',
			),
			'title' => array(
				'width' => 'Width',
				'height' => 'Height',
				'video_id' => 'Vimeo Video ID',
			),
			'desc' => array(
				'width'    => 'Enter video width in pixels',
				'height'   => 'Enter video height in pixels',
				'video_id' => 'Enter Vimeo video ID here ex. 82095744',
			),
			'content' => false,
		),
		'animate_counter' => array(
			'name' => 'Animated Counter',
			'attr' => array(
				'start'         => 'text',
				'end'           => 'text',
				'fontsize'      => 'text',
				'fontcolor'     => 'colorpicker',
				'count_subject' => 'text',
			),
			'title' => array(
				'start'         => 'Start',
				'end'           => 'End',
				'fontsize'      => 'Font Size',
				'fontcolor'     => 'Font Color',
				'count_subject' => 'Subject',
			),
			'desc' => array(
				'start'         => 'Enter start number ex. 0',
				'end'           => 'Enter end number ex. 100',
				'fontsize'      => 'Enter counter number font size in pixel ex. 38',
				'fontcolor'     => 'Enter counter number font color code ex. #000000',
				'count_subject' => 'Enter count subject ex. followers',
			),
			'content' => true,
		),
		'animate_bar' => array(
			'name' => 'Animated Progress Bar',
			'attr' => array(
				'percent' => 'text',
				'color'   => 'colorpicker',
				'height'  => 'text',
			),
			'title' => array(
				'percent' => 'Percentage (Maximum 100)',
				'color'   => 'Bar Color',
				'height'  => 'Bar Height (In px)',
			),
			'desc' => array(
				'percent' => 'Enter number of percent value (maximum 100)',
				'color'   => 'Enter progress bar background color code ex. #000000',
				'height'  => 'Enter progress bar height',
			),
			'content' => true,
		),
		'animate_circle' => array(
			'name' => 'Animated Circle',
			'attr' => array(
				'percent' => 'text',
				'dimension' => 'text',
				'width' => 'text',
				'color' => 'colorpicker',
				'fontsize' => 'text',
				'subject' => 'text',
			),
			'title' => array(
				'percent'   => 'Percentage (Maximum 100)',
				'dimension' => 'Circle Dimension (In px)',
				'width'     => 'Circle Border Width (In px)',
				'color'     => 'Circle Border Color',
				'fontsize'  => 'Font Size',
				'subject'   => 'Sbuject',
			),
			'desc' => array(
				'percent'   => 'Enter percent completion number ex. 90',
				'dimension' => 'Enter circle dimension ex. 200',
				'width'     => 'Enter circle border width ex. 10',
				'color'     => 'Enter circle border color code ex. #000000',
				'fontsize'  => 'Enter title font size in pixel ex. 38',
				'subject'   => 'Enter circle subject info ex. completion',
			),
			'content' => true,
		),
		'pricing' => array(
			'name' => 'Pricing Table',
			'attr' => array(
				'skin'           => 'select',
				'category'       => 'select',
				'columns'        => 'select',
				'items'          => 'text',
				'highlightcolor' => 'colorpicker',
			),
			'title' => array(
				'skin'           => 'Skin',
				'category'       => 'Pricing Category (Optional)',
				'columns'        => 'Columns',
				'items'          => 'Items',
				'highlightcolor' => 'Highlight Color',
			),
			'desc' => array(
				'skin'           => 'Select skin for this content',
				'category'       => 'Select Pricing Category to filter content',
				'columns'        => 'Select Number of Pricing Columns',
				'items'          => 'Enter number of items you want to display',
				'highlightcolor' => 'Select hightlight color for this content',
			),
			'content' => true,
			'options' => array(
				'skin' => array(
					'light'  => 'Light',
					'normal' => 'Normal',
				),
				'category' => $pricing_cat_select,
				'columns' => array(
					2 => '2 Columns',
					3 => '3 Columns',
					4 => '4 Columns',
				),
			),
			'content' => false,
		),
		'testimonial_slider' => array(
			'name' => 'Testimonials Slider',
			'attr' => array(
				'cat' => 'select',
				'items' => 'text',
				'fontcolor' => 'colorpicker',
			),
			'title' => array(
				'cat' => 'Testimonial Category (Optinal)',
				'items' => 'Items',
				'fontcolor' => 'Font Color',
			),
			'desc' => array(
				'cat'       => 'Select testimonials category you want to display its contents',
				'items'     => 'Enter number of items you want to display',
				'fontcolor' => 'Select font color for this content',
			),
			'options' => array(
				'cat' => $testimonial_cat_select,
			),
			'content' => false,
		),
	);

	anva_asort( $shortcodes, 'name' );

	return $shortcodes;
}
