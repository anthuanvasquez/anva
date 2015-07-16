<?php
/**
 * Anva Options API
 *
 * This class establishes all of the Theme Blvd
 * framework's theme options, and sets up the API
 * system to allow these options to be modified
 * from the client-side.
 *
 * Also, this class provides access to the saved
 * settings cooresponding to the these theme options.
 */
class Anva_Options_API {

	/**
	 * A single instance of this class
	 */
	private static $instance = null;
	private $raw_options = array();
	private $formatted_options = array();

	/**
	 * Creates or returns an instance of this class
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor. Hook everything in and setup API
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
		$options_pages = array();
		$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
		$options_pages[''] = __( 'Select a page:', anva_textdomain() );
		foreach ( $options_pages_obj as $page ) {
			$options_pages[$page->ID] = $page->post_title;
		}

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
			'attachment' 	=> 'scroll' );

		// Template defaults
		$template_defaults = array(
			'blog' 				=> __('Classic Blog', $domain),
			'search' 			=> __('Classic Search', $domain),
			'2col' 				=> __('2 Columns', $domain),
			'3col' 				=> __('3 Columns', $domain));

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
			'image' 			=> get_template_directory_uri() .'/assets/images/logo.png',
			'image_2x' 		=> get_template_directory_uri() .'/assets/images/logo@2x.png'
		);

		// Author default credtis
		$author = '<a href="'. esc_url( 'http://anthuanvasquez.net' ) .'" target="_blank">Anthuan Vasquez</a>';

		/* ---------------------------------------------------------------- */
		/* Tab #1: Styles
		/* ---------------------------------------------------------------- */

		$styles_options = array(
			
			// Section Layout
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
					// Skin Colors
					'schema' => array(
						'name' => "Schema Color",
						'desc' => "Choose schema color for the theme.",
						'id' => "skin",
						'std' => "blue",
						'type' => "select",
						'options' => array(
							'blue' 		=> 'Blue',
							'green' 	=> 'Green',
							'orange' 	=> 'Orange',
							'red' 		=> 'Red',
							'teal' 		=> 'Teal',
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
			
			// Section Links
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
				'type' 	=> 'group_start',
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

		);

		/* ---------------------------------------------------------------- */
		/* Tab #4: Advanced
		/* ---------------------------------------------------------------- */

		$advances_options = array(

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
				'sections' 	=> array()
			),
			'content' 		=> array(
				'icon'			=> 'format-status',
				'name' 			=> __( 'Content', 'anva' ),
				'sections' 	=> array()
			),
			'advanced' 		=> array(
				'icon'			=> 'admin-generic',
				'name' 			=> __( 'Advanced', 'anva' ),
				'sections' 	=> $advances_options
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

} // End class Anva_Options_API


/**
 * Get raw options. This helper function is more
 * for backwards compatibility. Realistically, it
 * doesn't have much use unless an old plugin is
 * still using it.
 */
function anva_get_core_options() {
	$api = Anva_Options_API::instance();
	return $api->get_raw_options();
}

/**
 * Get formatted options. Note that options will not be
 * formatted until after WP's after_setup_theme hook.
 */
function anva_get_formatted_options() {
	$api = Anva_Options_API::instance();
	return $api->get_formatted_options();
}

/**
 * Add theme option tab
 */
function anva_add_option_tab( $tab_id, $tab_name, $top = false ) {
	$api = Anva_Options_API::instance();
	$api->add_tab( $tab_id, $tab_name, $top );
}

/**
 * Remove theme option tab
 */
function anva_remove_option_tab( $tab_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_tab( $tab_id );
}

/**
 * Add theme option section
 */
function anva_add_option_section( $tab_id, $section_id, $section_name, $section_desc = null, $options = null, $top = false ) {
	$api = Anva_Options_API::instance();
	$api->add_section( $tab_id, $section_id, $section_name, $section_desc, $options, $top );
}

/**
 * Remove theme option section
 */
function anva_remove_option_section( $tab_id, $section_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_section( $tab_id, $section_id );
}

/**
 * Add theme option
 */
function anva_add_option( $tab_id, $section_id, $option_id, $option ) {
	$api = Anva_Options_API::instance();
	$api->add_option( $tab_id, $section_id, $option_id, $option );
}

/**
 * Remove theme option
 */
function anva_remove_option( $tab_id, $section_id, $option_id ) {
	$api = Anva_Options_API::instance();
	$api->remove_option( $tab_id, $section_id, $option_id );
}

/**
 * Remove theme option
 */
function anva_edit_option( $tab_id, $section_id, $option_id, $att, $value ) {
	$api = Anva_Options_API::instance();
	$api->edit_option( $tab_id, $section_id, $option_id, $att, $value );
}
