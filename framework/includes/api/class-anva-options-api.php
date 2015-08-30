<?php

if ( ! class_exists( 'Anva_Options_API' ) ) :

/**
 * Anva Core Options
 *
 * This class establishes all of the framework's theme options,
 * allow these options to be modified from theme side.
 *
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/admin
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */

class Anva_Options_API {

	/**
	 * A single instance of this class
 	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Raw options
	 *
	 * @since 1.0.0
	 */
	private $raw_options = array();

	/**
	 * Formatted options
	 *
	 * @since 1.0.0
	 */
	private $formatted_options = array();

	/**
	 * Creates or returns an instance of this class
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 * Hook everything in.
	 */
	private function __construct() {

		//if ( is_admin() ) {
			
			// Setup options
			$this->set_raw_options();

			// Format options
			add_action( 'after_setup_theme', array( $this, 'set_formatted_options' ), 1000 );
		//}
	}

	/**
	 * Setup raw options array for the start of the
	 * API process.
	 *
	 * Note: The framework used to reference these as
	 * "core options" before this class existed.
	 */
	public function set_raw_options() {


		/* ---------------------------------------------------------------- */
		/* Helpers
		/* ---------------------------------------------------------------- */
		
		// Fill layouts array
		$layouts = array();
		if ( is_admin() ) {
			foreach ( anva_sidebar_layouts() as $key => $value ) {
				$layouts[$key] = esc_html( $value['name'] );
			}
		}

		// Pull all the categories into an array
		$categories = array();
		if ( is_admin() ) {
			foreach ( get_categories() as $category ) {
				$categories[$category->cat_ID] = $category->cat_name;
			}
		}

		// Pull all the pages into an array
		$pages = array();
		if ( is_admin() ) {
			$pages[''] = __( 'Select a page', 'anva' ) . ':';
			foreach ( get_pages( 'sort_column=post_parent,menu_order' ) as $page ) {
				$pages[$page->ID] = $page->post_title;
			}
		}

		// Pull all gallery templates
		$galleries = array();
		if ( is_admin() ) {
			foreach ( anva_gallery_templates() as $key => $gallery ) {
				$galleries[$key] = $gallery['name'];
			}
		}

		// Pull all sliders
		$sliders = array();
		if ( is_admin() ) {
			foreach ( anva_get_sliders() as $key => $slider ) {
				$sliders[$key] = $slider['name'];
			}
			$sliders['revslider'] = 'Revolution Slider';
		}


		$animations = array();
		if ( is_admin() ) {
			foreach ( anva_get_animations() as $key => $value ) {
				$animations[$value] = $value; 
			}
		}

		// $api = Anva_Sliders_API::instance();
		
		// var_dump( $api->get_remove_sliders() );	

		/* ---------------------------------------------------------------- */
		/* Defaults
		/* ---------------------------------------------------------------- */

		// Background defaults
		$background_defaults = array(
			'color' 			=> '',
			'image' 			=> '',
			'repeat' 			=> 'repeat',
			'position' 		=> 'top center',
			'attachment' 	=> 'scroll'
		);

		// Template defaults
		$template_defaults = array(
			'blog' 				=> __( 'Classic Blog', 'anva' ),
			'search' 			=> __( 'Classic Search', 'anva' ),
			'2col' 				=> __( '2 Columns', 'anva'),
			'3col' 				=> __( '3 Columns', 'anva' )
		);

		// Social media buttons defautls
		$social_media_defaults = array(
			'dribbble'		=> 'https://dribbble.com/oidoperfecto',
			'google-plus' => 'https://plus.google.com/+AnthuanVasquez',
			'twitter' 		=> 'https://twitter.com/oidoperfecto', // Follow Me! :)
			'rss'					=> get_feed_link()
		);

		// Logo defaults
		$logo_defaults = array(
			'type' 				=> 'image',
			'custom' 			=> '',
			'image' 			=> get_template_directory_uri() . '/assets/images/logo.png',
			'image_2x' 		=> get_template_directory_uri() . '/assets/images/logo@2x.png'
		);

		// Author default credtis
		$author = '<a href="' . esc_url( 'http://anthuanvasquez.net' ) . '" target="_blank">Anthuan Vasquez</a>';

		// If using image radio buttons, define a directory path
		$image_path = get_template_directory_uri() . '/assets/images/';
		$skin_path  = $image_path . 'skins/';

		/* ---------------------------------------------------------------- */
		/* Tab #1: Styles
		/* ---------------------------------------------------------------- */

		$styles_options = array(
			
			// Layout
			'layout' => array(
				'name' => __( 'Layout', 'anva' ),
				'desc' => __( 'This is the section of layout inputs.', 'anva' ),
				'class' => 'group-layout',
				'options' => array(
					
					// Laout Style
					'layout_style' => array(
						'name' => __('Layout Style', 'anva'),
						'desc' => __('Select the layout style.', 'anva'),
						'id' => 'layout_style',
						'std' => 'boxed',
						'class' => 'input-select',
						'type' => 'select',
						'options' => array(
							'boxed' => __( 'Boxed', 'anva' ),
							'stretched' => __( 'Stretched', 'anva' )
						)
					),
					
					// Social Media Style
					'social' => array(
						'name' => __('Social Media Buttons Style', 'anva'),
						'desc' => __('Select the style for your social media buttons.', 'anva'),
						'id' => 'social_media_style',
						'std' => 'light',
						'type' => 'select',
						'options' => array(
							'light' 	=> __('Light', 'anva'),
							'colored' => __('Colored', 'anva'),
							'dark' 		=> __('Dark', 'anva'),
						)
					),
				)
			), // End Layout
			
			'typography' => array(
				'name' => __( 'Typography', 'anva' ),
				'class' => 'group-typography',
				'options'	=> array(
					'body_font' => array(
						'name' => __('Body Font', 'anva'),
						'desc' => __('This applies to most of the text on your site.', 'anva'),
						'id' => "body_font",
						'std' => array(
							'size' => '14px',
							'face' => 'google',
							'google' => 'Lato',
							'style' => 'normal',
						),
						'type' => 'typography',
						'options' => array( 'size', 'style', 'face' )
					),
					
					'heading_font' => array(
						'name' => __( 'Headings Font', 'anva'),
						'desc' => __( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', 'anva'),
						'id' => "heading_font",
						'std' => array(
							'face' => 'google',
							'google' => 'Raleway',
							'style' => 'normal'
						),
						'type' => 'typography',
						'options' => array( 'style', 'face' )
						
					),

					'heading_h1' => array(
						'name' => __('H1', 'anva'),
						'desc' => __('Select the size for H1 tag in px.', 'anva'),
						'id' => 'heading_h1',
						'std' => '27',
						'type' => 'range',
						'options' => array(
							'min' => 9,
							'max' => 72,
							'step' => 1,
							'format' => 'px',
						)
					),

					'heading_h2' => array(
						'name' => __('H2', 'anva'),
						'desc' => __('Select the size for H2 tag in px.', 'anva'),
						'id' => 'heading_h2',
						'std' => '24',
						'type' => 'range',
						'options' => array(
							'min' => 9,
							'max' => 72,
							'step' => 1,
							'format' => 'px',
						)
					),

					'heading_h3' => array(
						'name' => __('H3', 'anva'),
						'desc' => __('Select the size for H3 tag in px.', 'anva'),
						'id' => 'heading_h3',
						'std' => '18',
						'type' => 'range',
						'options' => array(
							'min' => 9,
							'max' => 72,
							'step' => 1,
							'format' => 'px',
						)
					),

					'heading_h4' => array(
						'name' => __('H4', 'anva'),
						'desc' => __('Select the size for H4 tag in px.', 'anva'),
						'id' => 'heading_h4',
						'std' => '14',
						'type' => 'range',
						'options' => array(
							'min' => 9,
							'max' => 72,
							'step' => 1,
							'format' => 'px',
						)
					),

					'heading_h5' => array(
						'name' => __('H5', 'anva'),
						'desc' => __('Select the size for H5 tag in px.', 'anva'),
						'id' => 'heading_h5',
						'std' => '13',
						'type' => 'range',
						'options' => array(
							'min' => 9,
							'max' => 72,
							'step' => 1,
							'format' => 'px',
						)
					),

					'heading_h6' => array(
						'name' => __('H6', 'anva'),
						'desc' => __('Select the size for H6 tag in px.', 'anva'),
						'id' => 'heading_h6',
						'std' => '11',
						'type' => 'range',
						'options' => array(
							'min' => 9,
							'max' => 72,
							'step' => 1,
							'format' => 'px',
						)
					),
				)
			), // End Typography
			
			// Links
			'links' => array(
				'name' => __( 'Links', 'anva' ),
				'class' => 'group-links',
				'type' 	=> 'group_start',
				'options' => array(
					
					// Link Color
					'link_color' => array(
						'name' => __('Link Color', 'anva'),
						'desc' => __('Set the link color.', 'anva'),
						'id' => 'link_color',
						'std' => '#ff0000',
						'type' => 'color'
					),
					
					// Link Color Hover
					'link_color_hover' => array(
						'name' => __('Link Color (:Hover)', 'anva'),
						'desc' => __('Set the link color.', 'anva'),
						'id' => 'link_color_hover',
						'std' => '#ff0000',
						'type' => 'color'
					)
				)
			), // End Links

			// Background
			'background' => array(
				'name' 	=> __( 'Background', 'anva' ),
				'class' => 'group-background',
				'options' => array(

					'background_color' => array(
						'name' => __('Background Color', 'anva'),
						'desc' => __('Select the background color.', 'anva'),
						'id' => 'background_color',
						'std' => '#dddddd',
						'type' => 'color'
					),

					'background_image' => array(
						'name' => __('Background Image', 'anva'),
						'desc' => __('Select the background color.', 'anva'),
						'id' => 'background_image',
						'std' => array(
							'color' => '#dddddd',
							'image' => '',
							'repeat' => 'repeat',
							'position' => 'top center',
							'attachment'=> 'scroll',
						),
						'type' => 'background'
					),

					'background_pattern' => array(
						'name' => __( 'Background Pattern', 'anva' ),
						'desc' => __( 'Select the background pattern.', 'anva' ),
						'id' => 'background_pattern',
						'std' => '',
						'type' => 'select',
						'options' => array(
							'' 								=> __( 'None' ),
							'binding_light' 	=> 'Binding Light',
							'dimension_@2X' 	=> 'Dimension',
							'hoffman_@2X' 		=> 'Hoffman',
							'knitting250px' 	=> 'Knitting',
							'noisy_grid' 			=> 'Noisy Grid',
							'pixel_weave_@2X' => 'Pixel Weave',
							'struckaxiom' 		=> 'Struckaxiom',
							'subtle_stripes' 	=> 'Subtle Stripes',
						)
					)
				)
			), // End Background
			
			'custom' => array(
				'name' 	=> __('Custom', 'anva'),
				'class' => 'group-custom',
				'options' => array(
					'css_warning' => array(
						'name' => __('Warning', 'anva'),
						'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva'),
						'id' => 'css_warning',
						'type' => 'info'
					),
					'custom_css' => array(
						'name' => __('Custom CSS', 'anva'),
						'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva'),
						'id' => 'custom_css',
						'std' => '',
						'type' => 'textarea'
					)
				)
			), // End Custom
		);

		/* ---------------------------------------------------------------- */
		/* Tab #2: Layout
		/* ---------------------------------------------------------------- */

		$layout_options = array(
			
			/*--------------------------------------------*/
			/* Header
			/*--------------------------------------------*/

			'header' => array(
				'name' 	=> __( 'Header', 'anva' ),
				'class' => 'group-header',
				'options' => array(
					'logo' => array(
						'name' => __( 'Logo', 'anva' ),
						'desc' => __( 'Configure the primary branding logo for the header of your site.<br /><br />Use the "Upload" button to either upload an image or select an image from your media library. When inserting an image with the "Upload" button, the URL and width will be inserted for you automatically. You can also type in the URL to an image in the text field along with a manually-entered width.<br /><br />If you\'re inputting a "HiDPI-optimized" image, it needs to be twice as large as you intend it to be displayed. Feel free to leave the HiDPI image field blank if you\'d like it to simply not have any effect.', 'anva' ),
						'id' => 'logo',
						'std' => $logo_defaults,
						'type' => 'logo'
					),

					'favicon' => array(
						'name' => __('Favicon', 'anva'),
						'desc' => __('Configure your won favicon.', 'anva'),
						'id' => 'favicon',
						'std' => '',
						'class' => 'input-text',
						'type' => 'upload'
					),

					'social_media' => array(
						"name" => __('Social Media', 'anva'),  
						"desc" => __('Enter the full URL you\'d like the button to link to in the corresponding text field that appears. Example: http://twitter.com/oidoperfecto. <strong>Note:</strong> If youre using the RSS button, your default RSS feed URL is: <strong>'.get_feed_link().'</strong>.', 'anva'),  
						"id" => "social_media",
						"type" => "social_media",
						"std" => $social_media_defaults
					)
				)
			),
			
			/*--------------------------------------------*/
			/* Main
			/*--------------------------------------------*/

			'main' => array(
				'name' 	=> __( 'Main', 'anva' ),
				'class' => 'group-main',
				'options' => array(
					'breadcrumbs' => array(
						'name' => __('Breadcrumbs', 'anva'),
						'desc' => __('Select whether youd like breadcrumbs to show throughout the site or not.', 'anva'),
						'id' => 'breadcrumbs',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show breadcrumbs', 'anva'),
							'hide' => __('Hide breadcrumbs', 'anva')
						)
					),

					'sidebar_layout' => array(
						'name' => __( 'Default Sidebar Layout', 'anva'),
						'desc' => __( 'Choose the default sidebar layout for the main content area of your site. </br>Note: This will be the default sidebar layout throughout your site, but you can be override this setting for any specific page.', 'anva'),
						'id' => 'sidebar_layout',
						'std' => 'right',
						'type' => 'select',
						'options' => $layouts
					),
				)
			),

			/*--------------------------------------------*/
			/* Gallery
			/*--------------------------------------------*/

			'gallery' => array(
				'name' => __( 'Gallery', 'anva' ),
				'class' => 'group-gallery',
				'options' => array(

					'gallery_sort' => array(
						'name' => __('Images Sorting', 'anva'),
						'desc' => __('Select how you want to sort gallery images.', 'anva'),
						'id' => 'gallery_sort',
						'std' => 'drag',
						'type' => 'select',
						'options' => array(
							'drag' => __('Drag & Drop', 'anva'),
							'desc' => __('Newest', 'anva'),
							'asc' => __('Oldest', 'anva'),
							'rand' => __('Random', 'anva'),
							'title' => __('Title', 'anva')
						)
					),

					'gallery_template' => array(
						'name' => __('Default Template', 'anva'),
						'desc' => __('Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', 'anva'),
						'id' => 'gallery_template',
						'std' => '3-col',
						'type' => 'select',
						'options' => $galleries
					),

					'gallery_animate' => array(
						'name' => __( 'Animate', 'anva' ),
						'desc' => __( 'Choose the default animation for gallery images.', 'anva' ),
						'id' => 'gallery_animate',
						'std' => 'fadeIn',
						'type' => 'select',
						'options' => $animations
					),

					'gallery_delay' => array(
						'name' => __( 'Delay', 'anva' ),
						'desc' => __( 'Choose the default delay for animation.', 'anva' ),
						'id' => 'gallery_delay',
						'std' => '400',
						'type' => 'range',
						'options' => array(
							'min' => 400,
							'max' => 2000,
							'step' => 100,
						)
					),
				)
			),

			/*--------------------------------------------*/
			/* Sliders
			/*--------------------------------------------*/
			
			'slider' => array(
				'name' => __( 'Sliders', 'anva' ),
				'class' => 'group-slider',
				'options' => array(

					'slider_id' => array(
						'name' => __( 'Slider', 'anva'),
						'desc' => __( 'Select the slider.', 'anva'),
						'id' => 'slider_id',
						'std' => 'standard',
						'type' => 'select',
						'options' => $sliders
					),

					'slider_speed' => array(
						'name' => __('Speed', 'anva'),
						'desc' => __('Set the slider speed. Default is 7000 in milliseconds.', 'anva'),
						'id' => 'slider_speed',
						'std' => '7000',
						'type' => 'number'
					),

					'slider_control' => array(
						'name' => __('Control Navigation', 'anva'),
						'desc' => __('Show or hide the slider control navigation.', 'anva'),
						'id' => 'slider_control',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show the slider control', 'anva'),
							'hide' => __('Hide the slider control', 'anva')
						)
					),

					'slider_direction' => array(
						'name' => __('Direction Navigation', 'anva'),
						'desc' => __('Show or hide the slider direction navigation.', 'anva'),
						'id' => 'slider_direction',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show the slider direction', 'anva'),
							'hide' => __('Hide the slider direction', 'anva')
						)
					),

					'revslider_id' => array(
						'name' => __( 'Revolution Slider ID', 'anva' ),
						'desc' => __( 'Show or hide the slider direction navigation.', 'anva' ),
						'id' => 'revslider_id',
						'std' => '',
						'type' => 'text',
					),
				)
			),

			/*--------------------------------------------*/
			/* Footer
			/*--------------------------------------------*/

			'footer' => array(
				'name' => __( 'Footer', 'anva' ),
				'class' => 'group-header',
				'options' => array(
					
					'footer_setup' => array(
						'name'		=> __( 'Setup Columns', 'anva' ),
						'desc'		=> __( 'Choose the number of columns along with the corresponding width configurations.', 'anva' ),
						'id' 			=> 'footer_setup',
						'type'		=> 'columns'
					),

					'footer_copyright' => array(
						'name' => __( 'Copyright Text', 'anva' ),
						'desc' => __( 'Enter the copyright text you\'d like to show in the footer of your site.', 'anva' ),
						'id' => "footer_copyright",
						'std' => sprintf( __( 'Copyright %s %s. Designed by %s.', 'anva' ), date( 'Y' ), get_bloginfo( 'name' ), $author ),
						'type' => "textarea"
					),
				)
			),
		);

		/* ---------------------------------------------------------------- */
		/* Tab #3: Layout
		/* ---------------------------------------------------------------- */

		$content_options = array(
			
			'single' => array(
				'name' => __( 'Single Posts', 'anva' ),
				'desc' => __( 'These settings will only apply to vewing single posts.', 'anva' ),
				'class' => 'group-single-posts',
				'options' => array(

					'single_meta' => array(
						'name' => __('Show meta info', 'anva'),
						'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the post.', 'anva'),
						'id' => 'single_meta',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show meta info', 'anva'),
							'hide' => __('Hide meta info', 'anva'),
						)
					),

					'single_thumb' => array(
						'name' => __('Show featured images', 'anva'),
						'desc' => __('Choose how you want your featured images to show at the top of the posts.', 'anva'),
						'id' => 'single_thumb',
						'std' => 'large',
						'type' => 'radio',
						'options' => array(
							'small' => __('Show small thumbnails', 'anva'),
							'large' => __('Show large thumbnails', 'anva'),
							'full' => __('Show full width thumbnails', 'anva'),
							'hide' => __('Hide thumbnails', 'anva'),
						)
					),

					'single_comments' => array(
						'name' => __('Show comments', 'anva'),
						'desc' => __('Select if you\'d like to completely hide comments or not below the post.', 'anva'),
						'id' => 'single_comments',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show comments', 'anva'),
							'hide' => __('Hide comments', 'anva'),
						)
					),

					'single_share' => array(
						'name' => __('Show share buttons', 'anva'),
						'desc' => __('Select to display socials sharing in single posts.', 'anva'),
						'id' => 'single_share',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show share buttons', 'anva'),
							'hide' => __('Hide share buttons', 'anva')
						)
					),

					'single_author' => array(
						'name' => __('Show about author', 'anva'),
						'desc' => __('Select to display about the author in single posts.', 'anva'),
						'id' => 'single_author',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show about author', 'anva'),
							'hide' => __('Hide about author', 'anva')
						)
					),

					'single_related' => array(
						'name' => __('Show related posts', 'anva'),
						'desc' => __('Select to display related posts in single posts.', 'anva'),
						'id' => 'single_related',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show related posts', 'anva'),
							'hide' => __('Hide related posts', 'anva'),
						)
					),

					'single_navigation' => array(
						'name' => __('Show navigation posts', 'anva'),
						'desc' => __('Select to display next and previous posts in single posts.', 'anva'),
						'id' => 'single_navigation',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show navigation posts', 'anva'),
							'hide' => __('Hide navigation posts', 'anva'),
						)
					),
				)
			), // End Single

			'primary' => array(
				'name' 	=> __( 'Primary Posts', 'anva' ),
				'desc' 	=> __( 'These settings apply to your primary posts page', 'anva' ),
				'class' => 'group-primary-posts',
				'options' => array(

					'primary_meta' => array(
						'name' => __('Show meta info', 'anva'),
						'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the primary posts.', 'anva'),
						'id' => 'primary_meta',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show meta info', 'anva'),
							'hide' => __('Hide meta info', 'anva'),
						)
					),

					'primary_thumb' => array(
						'name' => __('Show featured images', 'anva'),
						'desc' => __('Choose how you want your featured images to show in primary posts.', 'anva'),
						'id' => 'primary_thumb',
						'std' => 'large',
						'type' => 'radio',
						'options' => array(
							'small' => __('Show small thumbnails', 'anva'),
							'large' => __('Show large thumbnails', 'anva'),
							'full' => __('Show full width thumbnails', 'anva'),
							'hide' => __('Hide thumbnails', 'anva'),
						)
					),

					'primary_content' => array(
						'name' => __('Show excerpt or full content', 'anva'),
						'desc' => __('Choose whether you want to show full content or post excerpts only.', 'anva'),
						'id' => 'primary_content',
						'std' => 'excerpt',
						'type' => 'radio',
						'options' => array(
							'content' => __('Show full content', 'anva'),
							'excerpt' => __('Show excerpt', 'anva'),
						)
					),

					'exclude_categories' => array(
						'name' => __('Exclude Categories', 'anva'),
						'desc' => __('Select any categories you\'d like to be excluded from your blog.', 'anva'),
						'id' => 'exclude_categories',
						'std' => array(),
						'type' => 'multicheck',
						'options' => $categories
					),
				)
			), // End Primary

			'archives' => array(
				'name' => __( 'Archives', 'anva' ),
				'desc' => __( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', 'anva' ),
				'class' => 'group-archives',
				'options' => array(
					
					'archive_title' => array(
						'name' => __('Show titles', 'anva'),
						'desc' => __('Choose whether or not you want the title to show on tag archives, category archives, date archives, author archives and search result pages.', 'anva'),
						'id' => 'archive_title',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show the title', 'anva'),
							'hide' => __('Hide title', 'anva'),
						)
					),

					'archive_page' => array(
						'name' => __('Page Layout', 'anva'),
						'desc' => __('Select default layout for archive page.', 'anva'),
						'id' => 'archive_page',
						'std' => 'blog',
						'type' => 'select',
						'options' => $template_defaults
					),
				)
			), // End Archives
		);

		/* ---------------------------------------------------------------- */
		/* Tab #4: Advanced
		/* ---------------------------------------------------------------- */

		$advanced_options = array(

			'responsive' => array(
				'name' 	=> __( 'Responsive', 'anva' ),
				'class' => 'group-responsive',
				'type' 	=> 'group_start',
				'options' => array(

					'responsive' => array(
						'name' => __( 'Responsive', 'anva' ),
						'desc' => __( 'This theme comes with a special stylesheet that will target the screen resolution of your website vistors and show them a slightly modified design if their screen resolution matches common sizes for a tablet or a mobile device.', 'anva' ),
						'id' => "responsive",
						'std' => 'yes',
						'type' => 'radio',
						'options' => array(
							'yes' => __( 'Yes, apply special styles to tablets and mobile devices', 'anva' ),
							'no' 	=> __( 'No, allow website to show normally on tablets and mobile devices', 'anva' ),
						)
					),

					'responsive_css_992' => array(
						'name' => __( 'Add styles to tablet devices only', 'anva' ),
						'desc' => __( 'This CSS styles apply to breakpoint @media screen and (max-width: 992px).', 'anva' ),
						'id' => 'responsive_css_992',
						'std' => '',
						'type' => 'textarea'

					),

					'responsive_css_768' => array(
						'name' => __( 'Add styles to mobile devices only', 'anva' ),
						'desc' => __( 'This CSS styles apply to breakpoint @media screen and (max-width: 768px).', 'anva' ),
						'id' => 'responsive_css_768',
						'std' => '',
						'type' => 'textarea'
					)
				)
			), // End Responsive

			'minify' => array(
				'name' 	=> __( 'Minify', 'anva' ),
				'class' => 'group-minify',
				'type' 	=> 'group_start',
				'options' => array(

					'css_warning' => array(
						'name' => __( 'Warning', 'anva'),
						'desc' => __( 'If you have a cache plugin installed in your site desactive this options.', 'anva' ),
						'id' 	 => 'css_warning',
						'type' => 'info'
					),

					'compress_css' => array(
						'name' => __('Combine and Compress CSS files', 'anva'),
						'desc' => __('Combine and compress all CSS files to one. Help reduce page load time and increase server resources.', 'anva'),
						'id' => "compress_css",
						'std' => '0',
						'type' => 'checkbox'
					),

					'compress_js' => array(
						'name' => __('Combine and Compress Javascript files', 'anva' ),
						'desc' => __('Combine and compress all Javascript files to one. Help reduce page load time and increase server resource.', 'anva'),
						'id' => "compress_js",
						'std' => '0',
						'type' => 'checkbox'
					)
				)
			)// End Minify
		);

		/* ---------------------------------------------------------------- */
		/* Finalize and extend
		/* ---------------------------------------------------------------- */

		$this->raw_options = array(
			'styles' 			=> array(
				'icon'			=> 'admin-appearance',
				'name' 			=> __( 'Styles', 'anva' ),
				'sections' 	=> $styles_options
			),
			'layout' 			=> array(
				'icon'			=> 'grid-view',
				'name' 			=> __( 'Layout', 'anva' ),
				'sections' 	=> $layout_options
			),
			'content' 		=> array(
				'icon'			=> 'format-status',
				'name' 			=> __( 'Content', 'anva' ),
				'sections' 	=> $content_options
			),
			'advanced' 		=> array(
				'icon'			=> 'admin-generic',
				'name' 			=> __( 'Advanced', 'anva' ),
				'sections' 	=> $advanced_options
			)
		);

		// The following filter probably won't be used often,
		// but if there's something that can't be accomplished
		// through the client mutator API methods, then this
		// provides a way to modify these raw options.
		$this->raw_options = apply_filters( 'anva_core_options', $this->raw_options );

	}

	/**
	 * Format raw options after client has had a chance to
	 * modifty options.
	 *
	 * This works because our set_formatted_options()
	 * mutator is hooked in to the WP loading process at
	 * after_setup_theme.
	 */
	public function set_formatted_options() {

		$this->formatted_options = array();

		// Tab Level
		foreach ( $this->raw_options as $tab_id => $tab ) {

			$icon = '';
			if ( $tab['icon'] ) {
				$icon = $tab['icon'];
			}

			// Insert Tab Heading
			$this->formatted_options[] = array(
				'id' 		=> $tab_id,
				'icon'	=> $icon,
				'name' 	=> $tab['name'],
				'type' 	=> 'heading'
			);

			// Section Level
			if ( $tab['sections'] ) {
				foreach ( $tab['sections'] as $section_id => $section ) {

					$desc = '';
					$class = '';

					// Start section
					if ( isset( $section['desc'] ) ) {
						$desc = $section['desc'];
					}

					if ( isset( $section['class'] ) ) {
						$class= $section['class'];
					}

					$this->formatted_options[] = array(
						'id'	 => $section_id,
						'name' => $section['name'],
						'desc' => $desc,
						'class'=> $class,
						'type' => 'group_start'
					);

					// Options Level
					if ( $section['options'] ) {
						foreach ( $section['options'] as $option_id => $option ) {
							$this->formatted_options[] = $option;
						}
					}

					// End section
					$this->formatted_options[] = array(
						'type' => 'group_end'
					);
				}
			}
		}

		// Apply filters
		$this->formatted_options = apply_filters( 'anva_formatted_options', $this->formatted_options );

	}

	/**
	 * Add options panel tab
	 */
	public function add_tab( $tab_id, $tab_name, $top = false ) {

		// Can't create a tab that already exists. 
		// Must use remove_tab() first to modify.
		if ( isset( $this->raw_options[$tab_id] ) ) {
			return;
		}

		if ( $top ) {

			// Add tab to the top of array
			$new_options = array();
			$new_options[$tab_id] = array(
				'name' 			=> $tab_name,
				'sections' 	=> array()
			);
			$this->raw_options = array_merge( $new_options, $this->raw_options );

		} else {

			// Add tab to the end of global array
			$this->raw_options[$tab_id] = array(
				'name' 			=> $tab_name,
				'sections' 	=> array()
			);

		}
	}

	/**
	 * Remove options panel tab
	 */
	public function remove_tab( $tab_id ) {
		unset( $this->raw_options[$tab_id] );
	}

	/**
	 * Add section to an options panel tab
	 */
	public function add_section( $tab_id, $section_id, $section_name, $section_desc = '', $options = array(), $top = false ) {

		// Make sure tab exists
		if ( ! isset( $this->raw_options[$tab_id] ) )
			return;

		// Format options array
		$new_options = array();
		if ( $options ) {
			foreach ( $options as $option ) {
				if ( isset( $option['id'] ) ) {
					$new_options[$option['id']] = $option;
				}
			}
		}

		// Does the options section already exist?
		if ( isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			$this->raw_options[$tab_id]['sections'][$section_id]['options'] = array_merge( $this->raw_options[$tab_id]['sections'][$section_id]['options'], $new_options );
			return;
		}

		// Add new section to top or bottom
		if ( $top ) {

			$previous_sections = $this->raw_options[$tab_id]['sections'];

			$this->raw_options[$tab_id]['sections'] = array(
				$section_id => array(
					'name' 		=> $section_name,
					'desc' 		=> $section_desc,
					'options' => $new_options
				)
			);

			$this->raw_options[$tab_id]['sections'] = array_merge( $this->raw_options[$tab_id]['sections'], $previous_sections );

		} else {

			$this->raw_options[$tab_id]['sections'][$section_id] = array(
				'name'		=> $section_name,
				'desc'		=> $section_desc,
				'options'	=> $new_options
			);

		}

	}

	/**
	 * Remove section from an options panel tab
	 */
	public function remove_section( $tab_id, $section_id ) {
		unset( $this->raw_options[$tab_id]['sections'][$section_id] );
	}

	/**
	 * Add option
	 */
	public function add_option( $tab_id, $section_id, $option_id, $option ) {

		if ( ! isset( $this->raw_options[$tab_id] ) ) {
			return;
		}

		if ( ! isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			return;
		}

		$this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] = $option;
	}

	/**
	 * Remove option
	 */
	public function remove_option( $tab_id, $section_id, $option_id ) {

		if ( ! isset( $this->raw_options[$tab_id] ) || ! isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			return;
		}

		if ( isset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] ) ) {

			// If option has element's ID as key, we can find and
			// remove it easier.
			unset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] );

		} else {

			// If this is an option added by a child theme or plugin,
			// and it doesn't have the element's ID as the key, we'll
			// need to loop through to find it in order to remove it.
			foreach ( $this->raw_options[$tab_id]['sections'][$section_id]['options'] as $key => $value ) {
				if ( $value['id'] == $option_id ) {
					unset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$key] );
				}
			}

		}
	}

	/**
	 * Edit option
	 */
	public function edit_option( $tab_id, $section_id, $option_id, $att, $value ) {

		if ( ! isset( $this->raw_options[$tab_id] ) ) {
			return;
		}

		if ( ! isset( $this->raw_options[$tab_id]['sections'][$section_id] ) ) {
			return;
		}

		if ( ! isset( $this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id] ) ) {
			return;
		}

		$this->raw_options[$tab_id]['sections'][$section_id]['options'][$option_id][$att] = $value;
	}

	/**
	 * Get core options
	 */
	public function get_raw_options() {
		return $this->raw_options;
	}

	/**
	 * Get formatted options
	 */
	public function get_formatted_options() {
		return $this->formatted_options;
	}

} // End Class
endif;
