<?php

if ( ! class_exists( 'Anva_Sliders_API' ) ) :
/**
 * Anva Sliders API
 *
 * This sets up the default slider and provides
 * an API to add custom slider.
 * 
 * @since 1.0.0
 */
class Anva_Sliders_API {

	/**
	 * A single instance of this class
	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Core slider types
	 *
	 * @since 1.0.0
	 */
	private $core_sliders = array();

	/**
	 * Custom slider types
	 *
	 * @since 1.0.0
	 */
	private $custom_sliders = array();

	/**
	 * Slider types to be removed
	 *
	 * @since 1.0.0
	 */
	private $remove_sliders = array();

	/**
	 * Final slider types, core combined
	 * with custom slider types.
	 *
	 * @since 1.0.0
	 */
	private $sliders = array();

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
	 * 
	 * Hook everything in.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		//if ( is_admin() ) {

			// Setup plugin default slider types
			$this->set_core_sliders();
			$this->set_sliders();
			
			// Establish slider types based on custom modifications
			// combined with plugin defaults
			add_action( 'after_setup_theme', array( $this, 'set_sliders' ), 1000 );

		//}

	}

	/**
	 * Set default slider types
	 *
	 * @since 1.0.0
	 */
	public function set_core_sliders() {

		$this->core_sliders = array(
			'standard' => array(
				'name' 					=> 'Standard',
				'id'						=> 'standard',
				'custom_size' 	=> true
			),
			'owl' => array(
				'name' 					=> 'OWL',
				'id'						=> 'owl',
				'custom_size' 	=> false
			),
			'nivo' => array(
				'name' 					=> 'Nivo',
				'id'						=> 'nivo',
				'custom_size' 	=> true
			),
			'bootstrap' => array(
				'name' 					=> 'Bootstrap Carousel',
				'id'						=> 'bootstrap',
				'custom_size' 	=> false
			),
			'swiper' => array(
				'name' 					=> 'Swiper',
				'id'						=> 'swiper',
				'custom_size' 	=> false
			),
			'camera' => array(
				'name' 					=> 'Camera',
				'id'						=> 'camera',
				'custom_size' 	=> false
			),
		);

		/*--------------------------------------------*/
		/* Standard - Flex Slider
		/*--------------------------------------------*/

		// Slide Types
		$this->core_sliders['standard']['types'] = array(
			'image' => array(
				'name'			=> __( 'Image Slide', 'anva' ),
				'main_title' 	=> __( 'Setup Image', 'anva' )
			),
			'video' => array(
				'name' 			=> __( 'Video Slide', 'anva' ),
				'main_title' 	=> __( 'Setup Video', 'anva' )
			)
		);

		// Slide Media Positions
		$this->core_sliders['standard']['positions'] = array(
			'full' 			=> 'slider_lg',
			'align-left' 	=> 'slider-staged',
			'align-right' 	=> 'slider-staged'
		);

		// Slide Elements
		$this->core_sliders['standard']['elements'] = array(
			'image_link',
			'description'
		);

		// Slider Options
		$this->core_sliders['standard']['options'] = array(
			array(
				'type'		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle'
			),
			array(
				'id'			=> 'fx',
				'name'		=> __( 'How to transition between slides?', 'anva' ),
				'std'			=> 'fade',
				'type'		=> 'select',
				'options'	=> array(
					'fade' 	=> 'Fade',
					'slide'	=> 'Slide'
				),
				'class' 	=> 'trigger'
			),
			array(
				'id'			=> 'smoothheight',
				'name'		=> __( 'Allow height to adjust on each transition?', 'anva' ),
				'std'			=> 'false',
				'type'		=> 'select',
				'options'	=> array(
					'true' 	=> 'Yes, enable smoothHeight.',
					'false'	=> 'No, display as height of tallest slide.'
				),
				'class'		=> 'hide receiver receiver-slide'
			),
			array(
				'type'		=> 'subgroup_end'
			),
		);

		/*--------------------------------------------*/
		/* OWL Slider
		/*--------------------------------------------*/

		// Slide Types
		$this->core_sliders['owl']['types'] = array(
			'image' => array(
				'name' 			=> __( 'Image Slide', 'anva' ),
				'main_title' 	=> __( 'Setup Image', 'anva' )
			)
		);

		// Slide Media Positions
		$this->core_sliders['owl']['positions'] = array(
			'full' => 'grid_4' // Default
		);

		// Slide Elements
		$this->core_sliders['owl']['elements'] = array(
			'image_link'
		);

		// Slider Options
		$this->core_sliders['owl']['options'] = array(
			array(
				'id'			=> 'nav_arrows',
				'name'		=> __( 'Show next/prev arrows?', 'anva' ),
				'std'			=> '1',
				'type'		=> 'select',
				'options'	=> array(
					'1'	=> __( 'Yes, show arrows.', 'anva' ),
					'0'	=> __( 'No, don\'t show them.', 'anva' )
				)
			),
			array(
				'id'			=> 'mobile_fallback',
				'name'		=> __( 'How to display on mobile devices?', 'anva' ),
				'std'			=> 'full_list',
				'type'		=> 'radio',
				'options'	=> array(
					'full_list'		=> __( 'List out slides for a more user-friendly mobile experience.', 'anva' ),
					'first_slide'	=> __( 'Show first slide only for a more simple mobile experience.', 'anva' ),
					'display'			=> __( 'Attempt to show full animated slider on mobile devices.', 'anva' )
				)
			)
		);

		/*--------------------------------------------*/
		/* Nivo Slider
		/*--------------------------------------------*/

		// Slide Types
		$this->core_sliders['nivo']['types'] = array(
			'image' => array(
				'name' 			=> __( 'Image Slide', 'anva' ),
				'main_title'	=> __( 'Setup Image', 'anva' )
			)
		);

		// Slide Media Positions
		$this->core_sliders['nivo']['positions'] = array(
			'full' => 'slider_lg' // Default
		);

		// Slide Elements
		$this->core_sliders['nivo']['elements'] = array(
			'image_link',
			'description'
		);

		// Slider Options
		$this->core_sliders['nivo']['options'] = array(
			array(
				'type'		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle'
			),
			array(
				'id'				=> 'fx',
				'name'			=> __( 'How to transition between slides?', 'anva' ),
				'std'				=> 'random',
				'type'			=> 'select',
				'options'		=> array(
					'boxRandom'				=> 'boxRandom',
					'boxRain'				=> 'boxRain',
					'boxRainReverse'		=> 'boxRainReverse',
					'boxRainGrow'			=> 'boxRainGrow',
					'boxRainGrowReverse'	=> 'boxRainGrowReverse',
					'fold'					=> 'fold',
					'fade'					=> 'fade',
					'random'				=> 'random',
					'sliceDown'				=> 'sliceDown',
					'sliceDownLeft'			=> 'sliceDownLeft',
					'sliceUp'				=> 'sliceUp',
					'sliceUpLeft'			=> 'sliceUpLeft',
					'sliceUpDown'			=> 'sliceUpDown',
					'sliceUpDownLeft'		=> 'sliceUpDownLeft',
					'slideInRight'			=> 'slideInRight',
					'slideInLeft'			=> 'slideInLeft'
				),
				'class' 	=> 'trigger'
			),
			array(
				'id'		=> 'boxcols',
				'name' 		=> __( 'Number of box columns for transition?', 'anva' ),
				'std'		=> '8',
				'type'		=> 'text',
				'class'		=> 'hide receiver receiver-boxRandom receiver-boxRain receiver-boxRainReverse receiver-boxRainGrow receiver-boxRainGrowReverse'
			),
			array(
				'type'		=> 'subgroup_end'
			),
		);
		
		/*--------------------------------------------*/
		/* Bootstrap Carousel
		/*--------------------------------------------*/

		// Slide Types
		$this->core_sliders['bootstrap']['types'] = array(
			'image' => array(
				'name' 			=> __( 'Image Slide', 'anva' ),
				'main_title'	=> __( 'Setup Image', 'anva' )
			)
		);

		// Slide Media Positions
		$this->core_sliders['bootstrap']['positions'] = array(
			'full' => 'slider-large' // Default
		);

		// Slide Elements
		$this->core_sliders['bootstrap']['elements'] = array(
			'image_link',
			'headline',
			'description'
		);

		// Slider Options
		$this->core_sliders['bootstrap']['options'] = array(
			array(
				'id'			=> 'interval',
				'name' 		=> __( 'Seconds between each transition?', 'anva' ),
				'std'			=> '5',
				'type'		=> 'text'
			),
			array(
				'id'			=> 'pause',
				'name'		=> __( 'Enable pause on hover?', 'anva' ),
				'std'			=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'hover'	=> __( 'Yes, pause slider on hover.', 'anva' ),
					'false'	=> __( 'No, don\'t pause slider on hover.', 'anva' )
				)
			),
			array(
				'id'			=> 'wrap',
				'name'		=> __( 'Cycle carousel continuously?', 'anva' ),
				'std'			=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'true'	=> __( 'Yes, cycle continuously.', 'anva' ),
					'false'	=> __( 'No, stop cycling.', 'anva' )
				)
			),
		);

		/*--------------------------------------------*/
		/* Swiper
		/*--------------------------------------------*/

		// Slider Options
		$this->core_sliders['swiper']['options'] = array(
			array(
				'id'			=> 'interval',
				'name' 		=> __( 'Seconds between each transition?', 'anva' ),
				'std'			=> '5',
				'type'		=> 'text'
			),
			array(
				'id'			=> 'pause',
				'name'		=> __( 'Enable pause on hover?', 'anva' ),
				'std'			=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'hover'	=> __( 'Yes, pause slider on hover.', 'anva' ),
					'false'	=> __( 'No, don\'t pause slider on hover.', 'anva' )
				)
			),
		);

		/*--------------------------------------------*/
		/* Camera
		/*--------------------------------------------*/

		// Slider Options
		$this->core_sliders['camera']['options'] = array(
			array(
				'id'			=> 'interval',
				'name' 		=> __( 'Seconds between each transition?', 'anva' ),
				'std'			=> '5',
				'type'		=> 'text'
			),
			array(
				'id'			=> 'pause',
				'name'		=> __( 'Enable pause on hover?', 'anva' ),
				'std'			=> 'true',
				'type'		=> 'select',
				'options'	=> array(
					'hover'	=> __( 'Yes, pause slider on hover.', 'anva' ),
					'false'	=> __( 'No, don\'t pause slider on hover.', 'anva' )
				)
			),
		);

		/*--------------------------------------------*/
		/* Extend
		/*--------------------------------------------*/

		$this->core_sliders = apply_filters( 'anva_core_sliders', $this->core_sliders );

	}

	/**
	 * Set slider types
	 * 
	 * Then remove any types that have been set to be removed.
	 *
	 * @since 1.0.0
	 */
	public function set_sliders() {

		// Combine core sliders with custom sliders
		$this->sliders = array_merge( $this->core_sliders, $this->custom_sliders );

		// Remove elements
		if ( $this->remove_sliders ) {
			foreach ( $this->remove_sliders as $slider_id ) {
				if ( isset( $this->sliders[$slider_id] ) ) {
					unset( $this->sliders[$slider_id] );
				}
			}
		}

		// Extend
		$this->sliders = apply_filters( 'anva_recognized_sliders', $this->sliders );

	}

	/**
	 * Add custom slider
	 *
	 * @since 1.0.0
	 */
	public function add( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options ) {

		//if ( is_admin() ) {

			// Start new slider
			$new_slider  = array(
				'name' 		 => $slider_name,
				'id'			 => $slider_id,
				'options'	 => $options,
				'elements' => $elements
			);

			// Slide Types
			// $slide_types should look something like: array( 'image', 'video', 'custom' )
			$new_slider['types'] = array();

			if ( $slide_types ) {
				foreach ( $slide_types as $type ) {
					switch ( $type ) {

						case 'image' :
							$new_slider['types']['image'] = array(
								'name' 			=> __( 'Image Slide', 'anva' ),
								'main_title' 	=> __( 'Setup Image', 'anva' )
							);
							break;

						case 'video' :
							$new_slider['types']['video'] = array(
								'name' 			=> __( 'Video Slide', 'anva' ),
								'main_title' 	=> __( 'Video Link', 'anva' )
							);
							break;

						case 'custom' :
							$new_slider['types']['custom'] = array(
								'name' 			=> __( 'Custom Slide', 'anva' ),
								'main_title' 	=> __( 'Setup Custom Content', 'anva' )
							);
							break;

					}
				}
			}

			// Slide Media Positions
			// $media_positions should look something like: array( 'full' => 'crop_size', 'align-left' => 'crop_size', 'align-right' => 'crop_size' )
			$new_slider['positions'] = array();

			$positions = apply_filters( 'anva_slider_image_positions', array( 'full', 'align-left', 'align-right' ) );

			if ( $media_positions ) {
				foreach ( $media_positions as $position => $crop_size ) {
					if ( in_array( $position, $positions ) ) {
						$new_slider['positions'][$position] = $crop_size;
					}
				}
			}

			// Add new slider
			$this->custom_sliders[$slider_id] = $new_slider;

		//}

		// Add frontend display
		//add_action( 'anva_slider_' . $slider_id, );
	}

	/**
	 * Remove slider
	 *
	 * @since 1.0.0
	 */
	public function remove( $slider_id ) {
		$this->remove_sliders[] = $slider_id;
	}

	/**
	 * Get default sliders
	 *
	 * @since 1.0.0
	 */
	public function get_core_sliders() {
		return $this->core_sliders;
	}

	/**
	 * Get custom sliders
	 *
	 * @since 1.0.0
	 */
	public function get_custom_sliders() {
		return $this->custom_sliders;
	}

	/**
	 * Get sliders to be removed
	 *
	 * @since 1.0.0
	 */
	public function get_remove_sliders() {
		return $this->remove_sliders;
	}

	/**
	 * Get finalized sliders
	 *
	 * @since 1.0.0
	 */
	public function get_sliders( $slider_id = '' ) {

		if ( ! $slider_id ) {
			return $this->sliders;
		}

		if ( isset( $this->sliders[$slider_id] ) ) {
			return $this->sliders[$slider_id];
		}

		return array();

	}

	/**
	 * Determine if slider type is valid
	 *
	 * @since 1.0.0
	 */
	public function is_slider( $slider_id ) {

		if ( isset( $this->sliders[$slider_id] ) ) {
			return true;
		}

		return false;
	}

}
endif;