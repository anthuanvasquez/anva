<?php
/**
 * Anva Options
 *
 * This class establishes all of the framework's theme options,
 * allow these options to be modified from theme side.
 *
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/admin
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */

if ( ! class_exists( 'Anva_Core_Options' ) ) :

class Anva_Core_Options {

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

		// Setup options
		$this->set_raw_options();

		// Format options, and store saved settings
		add_action( 'after_setup_theme', array( $this, 'set_formatted_options' ), 1000 );

	}

	/**
	 * Setup raw options array for the start of the
	 * API process.
	 *
	 * Note: The framework used to reference these as
	 * "core options" before this class existed.
	 */
	private function set_raw_options() {


		/* ---------------------------------------------------------------- */
		/* Helpers
		/* ---------------------------------------------------------------- */

		// Text Domain
		$domain = anva_textdomain();

		// Pull all the categories into an array
		$options_categories = array();
		$options_categories_obj = get_categories();
		foreach ( $options_categories_obj as $category ) {
			$options_categories[$category->cat_ID] = $category->cat_name;
		}

		// Pull all the pages into an array
		// $options_pages = array();
		// $options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
		// $options_pages[''] = __( 'Select a page:', anva_textdomain() );
		// foreach ( $options_pages_obj as $page ) {
		// 	$options_pages[$page->ID] = $page->post_title;
		// }

		// Pull all gallery templates
		$options_galleries = array();
		$options_galleries_obj = anva_gallery_templates();
		foreach ( $options_galleries_obj as $key => $gallery ) {
			$options_galleries[$key] = $gallery['name'];
		}

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
			'blog' 				=> __( 'Classic Blog', $domain ),
			'search' 			=> __( 'Classic Search', $domain ),
			'2col' 				=> __( '2 Columns', $domain),
			'3col' 				=> __( '3 Columns', $domain )
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
				'name' => __( 'Layout', $domain ),
				'desc' => __( 'This is the section of layout inputs.', $domain ),
				'class' => 'group-layout',
				'options' => array(
					
					// Laout Style
					'layout_style' => array(
						'name' => __('Layout Style', $domain),
						'desc' => __('Select the layout style.', $domain),
						'id' => 'layout_style',
						'std' => 'boxed',
						'class' => 'input-select',
						'type' => 'select',
						'options' => array(
							'boxed' => __( 'Boxed', $domain ),
							'stretched' => __( 'Stretched', $domain )
						)
					),
					
					// Social Media Style
					'social' => array(
						'name' => __('Social Media Buttons Style', $domain),
						'desc' => __('Select the style for your social media buttons.', $domain),
						'id' => 'social_media_style',
						'std' => 'light',
						'type' => 'select',
						'options' => array(
							'light' 	=> __('Light', $domain),
							'colored' => __('Colored', $domain),
							'dark' 		=> __('Dark', $domain),
						)
					),
				)
			), // End Layout
			
			'typography' => array(
				'name' => __( 'Typography', $domain ),
				'class' => 'group-typography',
				'options'	=> array(
					'body_font' => array(
						'name' => __('Body Font', $domain),
						'desc' => __('This applies to most of the text on your site.', $domain),
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
						'name' => __( 'Headings Font', $domain),
						'desc' => __( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', $domain),
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
						'name' => __('H1', $domain),
						'desc' => __('Select the size for H1 tag in px.', $domain),
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
						'name' => __('H2', $domain),
						'desc' => __('Select the size for H2 tag in px.', $domain),
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
						'name' => __('H3', $domain),
						'desc' => __('Select the size for H3 tag in px.', $domain),
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
						'name' => __('H4', $domain),
						'desc' => __('Select the size for H4 tag in px.', $domain),
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
						'name' => __('H5', $domain),
						'desc' => __('Select the size for H5 tag in px.', $domain),
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
						'name' => __('H6', $domain),
						'desc' => __('Select the size for H6 tag in px.', $domain),
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
				'name' => __( 'Links', $domain ),
				'class' => 'group-links',
				'type' 	=> 'group_start',
				'options' => array(
					
					// Link Color
					'link_color' => array(
						'name' => __('Link Color', $domain),
						'desc' => __('Set the link color.', $domain),
						'id' => 'link_color',
						'std' => '#ff0000',
						'type' => 'color'
					),
					
					// Link Color Hover
					'link_color_hover' => array(
						'name' => __('Link Color (:Hover)', $domain),
						'desc' => __('Set the link color.', $domain),
						'id' => 'link_color_hover',
						'std' => '#ff0000',
						'type' => 'color'
					)
				)
			), // End Links

			// Background
			'background' => array(
				'name' 	=> __( 'Background', $domain ),
				'class' => 'group-background',
				'options' => array(

					'background_color' => array(
						'name' => __('Background Color', $domain),
						'desc' => __('Select the background color.', $domain),
						'id' => 'background_color',
						'std' => '#dddddd',
						'type' => 'color'
					),

					'background_image' => array(
						'name' => __('Background Image', $domain),
						'desc' => __('Select the background color.', $domain),
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
						'name' => __( 'Background Pattern', $domain ),
						'desc' => __( 'Select the background pattern.', $domain ),
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
				'name' 	=> __('Custom', $domain),
				'class' => 'group-custom',
				'options' => array(
					'css_warning' => array(
						'name' => __('Warning', $domain),
						'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', $domain),
						'id' => 'css_warning',
						'type' => 'info'
					),
					'custom_css' => array(
						'name' => __('Custom CSS', $domain),
						'desc' => __('If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', $domain),
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
			
			'header' => array(
				'name' 	=> __( 'Header', $domain ),
				'class' => 'group-header',
				'options' => array(
					'logo' => array(
						'name' => __( 'Logo', $domain ),
						'desc' => __( 'Configure the primary branding logo for the header of your site.<br /><br />Use the "Upload" button to either upload an image or select an image from your media library. When inserting an image with the "Upload" button, the URL and width will be inserted for you automatically. You can also type in the URL to an image in the text field along with a manually-entered width.<br /><br />If you\'re inputting a "HiDPI-optimized" image, it needs to be twice as large as you intend it to be displayed. Feel free to leave the HiDPI image field blank if you\'d like it to simply not have any effect.', $domain ),
						'id' => 'logo',
						'std' => $logo_defaults,
						'type' => 'logo'
					),

					'favicon' => array(
						'name' => __('Favicon', $domain),
						'desc' => __('Configure your won favicon.', $domain),
						'id' => 'favicon',
						'std' => '',
						'class' => 'input-text',
						'type' => 'upload'
					),

					'social_media' => array(
						"name" => __('Social Media', $domain),  
						"desc" => __('Enter the full URL you\'d like the button to link to in the corresponding text field that appears. Example: http://twitter.com/oidoperfecto. <strong>Note:</strong> If youre using the RSS button, your default RSS feed URL is: <strong>'.get_feed_link().'</strong>.', $domain),  
						"id" => "social_media",
						"type" => "social_media",
						"std" => $social_media_defaults
					)
				)
			), // End Header
			
			'main' => array(
				'name' 	=> __( 'Main', $domain ),
				'class' => 'group-main',
				'options' => array(
					'breadcrumbs' => array(
						'name' => __('Breadcrumbs', $domain),
						'desc' => __('Select whether youd like breadcrumbs to show throughout the site or not.', $domain),
						'id' => 'breadcrumbs',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show breadcrumbs', $domain),
							'hide' => __('Hide breadcrumbs', $domain)
						)
					),

					'sidebar_layout' => array(
						'name' => __( 'Default Sidebar Layout', $domain),
						'desc' => __( 'Choose the default sidebar layout for the main content area of your site. </br>Note: This will be the default sidebar layout throughout your site, but you can be override this setting for any specific page.', $domain),
						'id' => 'sidebar_layout',
						'std' => 'right',
						'type' => 'select',
						'options' => array(
							'fullwidth' 		=> __( 'Full Width', $domain ),
							'right' 				=> __( 'Sidebar Right', $domain ),
							'left' 					=> __( 'Sidebar Left', $domain ),
							'double' 				=> __( 'Double Sidebars', $domain ),
							'double_right' 	=> __( 'Double Right Sidebars', $domain ),
							'double_left' 	=> __( 'Double Left Sidebars', $domain )
						)
					),
				)
			), // End Main

			'gallery' => array(
				'name' => __( 'Gallery', $domain ),
				'class' => 'group-gallery',
				'options' => array(

					'gallery_sort' => array(
						'name' => __('Images Sorting', $domain),
						'desc' => __('Select how you want to sort gallery images.', $domain),
						'id' => 'gallery_sort',
						'std' => 'drag',
						'type' => 'select',
						'options' => array(
							'drag' => __('By Drag & Drop', $domain),
							'desc' => __('By Newest', $domain),
							'asc' => __('By Oldest', $domain),
							'rand' => __('By Random', $domain),
							'title' => __('By Title', $domain)
						)
					),

					'gallery_template' => array(
						'name' => __('Default Template', $domain),
						'desc' => __('Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', $domain),
						'id' => 'gallery_template',
						'std' => '3-col',
						'type' => 'select',
						'options' => $options_galleries
					),
				)
			), // End Gallery
			
			'slider' => array(
				'name' => __( 'Flex Slider', $domain ),
				'class' => 'group-slider',
				'options' => array(

					'slider_active' => array(
						'name' => __( 'Active Flex Slider', $domain),
						'desc' => __( 'Active the flex slider.', $domain),
						'id' => 'slider_active',
						'std' => 1,
						'type' => 'checkbox',
						'options' => array(
							'show' => 1,
							'hide' => 0
						)
					),

					'slider_speed' => array(
						'name' => __('Speed', $domain),
						'desc' => __('Set the slider speed. Default is 7000 in milliseconds.', $domain),
						'id' => 'slider_speed',
						'std' => '7000',
						'type' => 'number'
					),

					'slider_control' => array(
						'name' => __('Control Navigation', $domain),
						'desc' => __('Show or hide the slider control navigation.', $domain),
						'id' => 'slider_control',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show the slider control', $domain),
							'hide' => __('Hide the slider control', $domain)
						)
					),

					'slider_direction' => array(
						'name' => __('Direction Navigation', $domain),
						'desc' => __('Show or hide the slider direction navigation.', $domain),
						'id' => 'slider_direction',
						'std' => 'show',
						'type' => 'select',
						'options' => array(
							'show' => __('Show the slider direction', $domain),
							'hide' => __('Hide the slider direction', $domain)
						)
					),
				)
			), // End Flex Slider

			'footer' => array(
				'name' => __( 'Footer', $domain ),
				'class' => 'group-header',
				'options' => array(
					
					'footer_setup' => array(
						'name'		=> __( 'Setup Columns', $domain ),
						'desc'		=> __( 'Choose the number of columns along with the corresponding width configurations.', $domain ),
						'id' 			=> 'footer_setup',
						'type'		=> 'columns'
					),

					'footer_copyright' => array(
						'name' => __( 'Copyright Text', $domain ),
						'desc' => __( 'Enter the copyright text you\'d like to show in the footer of your site.', $domain ),
						'id' => "footer_copyright",
						'std' => sprintf( __( 'Copyright %s %s. Designed by %s.', $domain ), date( 'Y' ), get_bloginfo( 'name' ), $author ),
						'type' => "textarea"
					),
				)
			), // End Footer
		);

		/* ---------------------------------------------------------------- */
		/* Tab #3: Layout
		/* ---------------------------------------------------------------- */

		$content_options = array(
			
			'single' => array(
				'name' => __( 'Single Posts', $domain ),
				'desc' => __( 'These settings will only apply to vewing single posts.', $domain ),
				'class' => 'group-single-posts',
				'options' => array(

					'single_meta' => array(
						'name' => __('Show meta info', $domain),
						'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the post.', $domain),
						'id' => 'single_meta',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show meta info', $domain),
							'hide' => __('Hide meta info', $domain),
						)
					),

					'single_thumb' => array(
						'name' => __('Show featured images', $domain),
						'desc' => __('Choose how you want your featured images to show at the top of the posts.', $domain),
						'id' => 'single_thumb',
						'std' => 'large',
						'type' => 'radio',
						'options' => array(
							'small' => __('Show small thumbnails', $domain),
							'large' => __('Show large thumbnails', $domain),
							'hide' => __('Hide thumbnails', $domain),
						)
					),

					'single_comments' => array(
						'name' => __('Show comments', $domain),
						'desc' => __('Select if you\'d like to completely hide comments or not below the post.', $domain),
						'id' => 'single_comments',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show comments', $domain),
							'hide' => __('Hide comments', $domain),
						)
					),

					'single_share' => array(
						'name' => __('Show share buttons', $domain),
						'desc' => __('Select to display socials sharing in single posts.', $domain),
						'id' => 'single_share',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show share buttons', $domain),
							'hide' => __('Hide share buttons', $domain)
						)
					),

					'single_author' => array(
						'name' => __('Show about author', $domain),
						'desc' => __('Select to display about the author in single posts.', $domain),
						'id' => 'single_author',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show about author', $domain),
							'hide' => __('Hide about author', $domain)
						)
					),

					'single_related' => array(
						'name' => __('Show related posts', $domain),
						'desc' => __('Select to display related posts in single posts.', $domain),
						'id' => 'single_related',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show related posts', $domain),
							'hide' => __('Hide related posts', $domain),
						)
					),

					'single_navigation' => array(
						'name' => __('Show navigation posts', $domain),
						'desc' => __('Select to display next and previous posts in single posts.', $domain),
						'id' => 'single_navigation',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show navigation posts', $domain),
							'hide' => __('Hide navigation posts', $domain),
						)
					),
				)
			), // End Single

			'primary' => array(
				'name' 	=> __( 'Primary Posts', $domain ),
				'desc' 	=> __( 'These settings apply to your primary posts page', $domain ),
				'class' => 'group-primary-posts',
				'options' => array(

					'primary_meta' => array(
						'name' => __('Show meta info', $domain),
						'desc' => __('Select if you\'d like the meta information (date posted, author, etc) to show at the top of the primary posts.', $domain),
						'id' => 'primary_meta',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show meta info', $domain),
							'hide' => __('Hide meta info', $domain),
						)
					),

					'primary_thumb' => array(
						'name' => __('Show featured images', $domain),
						'desc' => __('Choose how you want your featured images to show in primary posts.', $domain),
						'id' => 'primary_thumb',
						'std' => 'large',
						'type' => 'radio',
						'options' => array(
							'small' => __('Show small thumbnails', $domain),
							'large' => __('Show large thumbnails', $domain),
							'hide' => __('Hide thumbnails', $domain),
						)
					),

					'primary_content' => array(
						'name' => __('Show excerpt or full content', $domain),
						'desc' => __('Choose whether you want to show full content or post excerpts only.', $domain),
						'id' => 'primary_content',
						'std' => 'excerpt',
						'type' => 'radio',
						'options' => array(
							'content' => __('Show full content', $domain),
							'excerpt' => __('Show excerpt', $domain),
						)
					),

					'exclude_categories' => array(
						'name' => __('Exclude Categories', $domain),
						'desc' => __('Select any categories you\'d like to be excluded from your blog.', $domain),
						'id' => 'exclude_categories',
						'std' => array(),
						'type' => 'multicheck',
						'options' => $options_categories
					),
				)
			), // End Primary

			'archives' => array(
				'name' => __( 'Archives', $domain ),
				'desc' => __( 'These settings apply any time you\'re viewing search results or posts specific to a category, tag, date, author, format, etc.', $domain ),
				'class' => 'group-archives',
				'options' => array(
					
					'archive_title' => array(
						'name' => __('Show titles', $domain),
						'desc' => __('Choose whether or not you want the title to show on tag archives, category archives, date archives, author archives and search result pages.', $domain),
						'id' => 'archive_title',
						'std' => 'show',
						'type' => 'radio',
						'options' => array(
							'show' => __('Show the title', $domain),
							'hide' => __('Hide title', $domain),
						)
					),

					'archive_page' => array(
						'name' => __('Page Layout', $domain),
						'desc' => __('Select default layout for archive page.', $domain),
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
				'name' 	=> __( 'Responsive', $domain ),
				'class' => 'group-responsive',
				'type' 	=> 'group_start',
				'options' => array(

					'responsive' => array(
						'name' => __( 'Responsive', $domain ),
						'desc' => __( 'This theme comes with a special stylesheet that will target the screen resolution of your website vistors and show them a slightly modified design if their screen resolution matches common sizes for a tablet or a mobile device.', $domain ),
						'id' => "responsive",
						'std' => 'yes',
						'type' => 'radio',
						'options' => array(
							'yes' => __( 'Yes, apply special styles to tablets and mobile devices', $domain ),
							'no' 	=> __( 'No, allow website to show normally on tablets and mobile devices', $domain ),
						)
					),

					'responsive_css_992' => array(
						'name' => __( 'Add styles to tablet devices only', $domain ),
						'desc' => __( 'This CSS styles apply to breakpoint @media screen and (max-width: 992px).', $domain ),
						'id' => 'responsive_css_992',
						'std' => '',
						'type' => 'textarea'

					),

					'responsive_css_768' => array(
						'name' => __( 'Add styles to mobile devices only', $domain ),
						'desc' => __( 'This CSS styles apply to breakpoint @media screen and (max-width: 768px).', $domain ),
						'id' => 'responsive_css_768',
						'std' => '',
						'type' => 'textarea'
					)
				)
			), // End Responsive

			'minify' => array(
				'name' 	=> __( 'Minify', $domain ),
				'class' => 'group-minify',
				'type' 	=> 'group_start',
				'options' => array(

					'css_warning' => array(
						'name' => __( 'Warning', $domain),
						'desc' => __( 'If you have a cache plugin installed in your site desactive this options.', $domain ),
						'id' 	 => 'css_warning',
						'type' => 'info'
					),

					'compress_css' => array(
						'name' => __('Combine and Compress CSS files', $domain),
						'desc' => __('Combine and compress all CSS files to one. Help reduce page load time and increase server resources.', $domain),
						'id' => "compress_css",
						'std' => '0',
						'type' => 'checkbox'
					),

					'compress_js' => array(
						'name' => __('Combine and Compress Javascript files', $domain),
						'desc' => __('Combine and compress all Javascript files to one. Help reduce page load time and increase server resource.', $domain),
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
