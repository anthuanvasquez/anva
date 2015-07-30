<?php

if ( ! class_exists( 'Anva_Sidebars' ) ) :

/**
 * Anva Sidebars
 * 
 * This class sets up the framework sidebars location. 
 * Additionally, this class provides methods to add and remove locations.
 * 
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/admin
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */
class Anva_Sidebars {

	/**
	 * A single instance of this class
	 * 
	 * @since  1.0.0
	 * @access private
	 */
	private static $instance = null;

	/**
	 * Core locations array
	 * 
	 * @since  1.0.0
	 * @access private
	 */
	private $core_locations = array();

	/**
	 * Custom locations array
	 * 
	 * @since  1.0.0
	 * @access private
	 */
	private $custom_locations = array();

	/**
	 * Remove locations array
	 * 
	 * @since  1.0.0
	 * @access private
	 */
	private $remove_locations = array();

	/**
	 * Locations
	 * 
	 * @since  1.0.0
	 * @access private
	 */
	private $locations = array();

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
	 * Constructor
	 */
	private function __construct() {

		// Set core framework locations
		$this->set_core_locations();

		add_action( 'after_setup_theme', array( $this, 'set_locations' ), 1001 );
		add_action( 'after_setup_theme', array( $this, 'register' ), 1001 );

	}

	/**
	 * Set core framework sidebar locations
	 */
	private function set_core_locations() {

		$this->core_locations = array();

		// Default Right Sidebar
		$this->core_locations['sidebar_right'] = array(
			'args' 					=> array(
				'id' 					=> 'sidebar_right',
				'name' 				=> __( 'Right', anva_textdomain() ),
				'description' => __( 'Sidebar right.', anva_textdomain() ),
			)
		);

		// Default Left Sidebar
		$this->core_locations['sidebar_left'] = array(
			'args' => array(
				'id' => 'sidebar_left',
				'name' => __( 'Left', anva_textdomain() ),
				'description' => __( 'Sidebar left.', anva_textdomain() ),
			)
		);

		$this->core_locations['above_header'] = array(
			'args' => array(
				'id' => 'above_header',
				'name' => __( 'Above Header', anva_textdomain() ),
				'description' => __( 'Sidebar above header.', anva_textdomain() ),
			)
		);

		$this->core_locations['above_content'] = array(
			'args' => array(
				'id' => 'above_content',
				'name' => __( 'Above Content', anva_textdomain() ),
				'description' => __( 'Sidebar above content.', anva_textdomain() ),
			)
		);

		$this->core_locations['below_content'] = array(
			'args' => array(
				'id' => 'below_content',
				'name' => __( 'Below Content', anva_textdomain() ),
				'description' => __( 'Sidebar below content.', anva_textdomain() ),
			)
		);

		$this->core_locations['below_footer'] = array(
			'args' => array(
				'id' => 'below_footer',
				'name' => __( 'Below Footer', anva_textdomain() ),
				'description' => __( 'Sidebar below footer.', anva_textdomain() ),
			)
		);

		$this->core_locations = apply_filters( 'anva_core_sidebar_locations', $this->core_locations );

	}

	/**
	 * Set final sidebar locations
	 * This sets the merged result of core locations and custom locations.
	 */
	public function set_locations() {

		// Merge core locations with custom locations.
		$this->locations = array_merge( $this->core_locations, $this->custom_locations );

		// Remove locations
		if ( $this->remove_locations ) {
			foreach ( $this->remove_locations as $location ) {
				unset( $this->locations[$location] );
			}
		}

		$this->locations = apply_filters( 'anva_sidebar_locations', $this->locations );

	}

	/**
	 * Add sidebar location
	 */
	public function add_location( $id, $name, $desc = '', $class = '' ) {

		if ( ! $desc ) {
			$desc = sprintf( __( 'This is default placeholder for the "%s" location.', anva_textdomain() ), $name );
		}

		// Add Sidebar location
		$this->custom_locations[$id] = array(
			'args' 					=> array(
				'id' 					=> $id,
				'name' 				=> $name,
				'description' => $desc,
				'class'				=> $class,
			)
		);

	}

	/**
	 * Remove sidebar location
	 */
	public function remove_location( $id ) {
		$this->remove_locations[] = $id;
	}

	/**
	 * Get core framework sidebar locations
	 */
	public function get_core_locations() {
		return $this->core_locations;
	}

	/**
	 * Get added custom locations
	 */
	public function get_custom_locations() {
		return $this->custom_locations;
	}

	/**
	 * Get locations to be removed
	 */
	public function get_remove_locations() {
		return $this->remove_locations;
	}

	/**
	 * Get final sidebar locations
	 * This is the merged result of core locations and custom added locations.
	 */
	public function get_locations( $location_id = '' ) {

		if ( ! $location_id ) {
			return $this->locations;
		}

		if ( isset( $this->locations[$location_id] ) ) {
			return $this->locations[$location_id];
		}

		return array();
	}

	/**
	 * Register sidebars with WordPress
	 */
	public function register() {

		foreach ( $this->locations as $sidebar ) {

			// Filter args for each of default sidebar
			$args = anva_add_sidebar_args(
				$sidebar['args']['id'],
				$sidebar['args']['name'],
				$sidebar['args']['description'],
				( isset( $sidebar['args']['class'] ) ? $sidebar['args']['class'] : '' )
			);

			register_sidebar( $args );

		}

	}

	/**
	 * Display Sidebar
	 */
	public function display( $location ) {
		
		$config = array();

		$locations = $this->get_locations();

		foreach ( $locations as $location_id => $default_sidebar ) {

			$sidebar_id = apply_filters( 'anva_custom_sidebar_id', $location_id );
			
			$config[$location_id]['id'] = $sidebar_id;
			$config[$location_id]['error'] = false;

			if ( ! is_active_sidebar( $sidebar_id ) ) {
	    	$config[$location_id]['error'] = true;
	    }
		}

		$sidebar = $config[$location];

		if ( ! $sidebar['error'] && ! is_active_sidebar( $sidebar['id'] ) ) {
			return;
		}

		do_action( 'anva_sidebar_'. $location .'_before' );
		
		echo '<div class="widget-area widget-area-'. esc_attr( $location ) .' clearfix">';
		
		if ( $sidebar['error'] ) {

			$message = sprintf(
				__( 'This is a fixed sidebar with ID, <strong>%s</strong>, but you haven\'t put any widgets in it yet.', anva_textdomain() ),
				$sidebar['id']
			);

			echo '<div class="alert alert-warning">';
			echo '<p>'. $message .'</p>';
			echo '</div><!-- .alert (end) -->';

		} else {

			dynamic_sidebar( $sidebar['id'] );

		}

		echo '</div><!-- .widget-area (end) -->';

		do_action( 'anva_sidebar_'. $location .'_after' );
		
	}
}
endif;

/* ---------------------------------------------------------------- */
/* Helpers
/* ---------------------------------------------------------------- */

/**
 * Add sidebar location
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_location( $id, $name, $desc = '' ) {
	$api = Anva_Sidebars::instance();
	$api->add_location( $id, $name, $desc );
}

/**
 * Remove sidebar location
 * 
 * @since 1.0.0
 */
function anva_remove_sidebar_location( $id ) {
	$api = Anva_Sidebars::instance();
	$api->remove_location( $id );
}

/**
 * Get sidebar locations
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_locations() {
	$api = Anva_Sidebars::instance();
	return $api->get_locations();
}

/**
 * Get sidebar location name or slug name
 * 
 * @since 1.0.0
 */
function anva_get_sidebar_location_name( $location, $slug = false ) {
	$api = Anva_Sidebars::instance();
	$sidebar = $api->get_locations( $location );

	if ( isset( $sidebar['args']['name'] ) ) {
		if ( $slug ) {
			return sanitize_title( $sidebar['args']['name'] );
		}
		return $sidebar['args']['name'];
	}

	return __( 'Widget Area', anva_textdomain() );
}

/**
 * Display sidebar location
 * 
 * @since 1.0.0
 */
function anva_display_sidebar( $location ) {
	$api = Anva_Sidebars::instance();
	$api->display( $location );
}

/**
 * Add sidebar args when register locations
 * 
 * @since 1.0.0
 */
function anva_add_sidebar_args( $id, $name, $desc = '', $classes = '' ) {	
	$args = array(
		'id'            => $id,
		'name'          => $name,
		'description'		=> $desc,
		'before_widget' => '<aside id="%1$s" class="widget %2$s '. esc_attr( $classes ) .'"><div class="widget-inner clearfix">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);
	return apply_filters( 'anva_add_sidebar_args', $args );
}
