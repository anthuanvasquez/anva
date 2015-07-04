<?php

if ( ! class_exists( 'Anva_Widgets' ) ) :

/**
 * Class Anva_Widgets
 * Manage widgets.
 */
class Anva_Widgets {

	/**
	 * Properties
	 */
	private static $instance = null;
	private $core_widgets = array();
	private $custom_widgets = array();
	private $remove_widgets = array();
	private $widgets = array();

	/**
	 * Creates or returns an instance of this class
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/*
	 * Constructor
	 */
	private function __construct() {

		// Set core widgets
		$this->set_core_widgets();
		
		add_action( 'after_setup_theme', array( $this, 'include_core_widgets' ) );
		add_action( 'after_setup_theme', array( $this, 'set_widgets' ) );
		add_action( 'widgets_init', array( $this, 'register' ) );
	}

	/**
	 * Includes core widgets
	 */
	public function include_core_widgets() {
		include_once( anva_get_core_directory() . '/widgets/class-anva-social-icons.php' );
		include_once( anva_get_core_directory() . '/widgets/class-anva-services.php' );
		include_once( anva_get_core_directory() . '/widgets/class-anva-quick-contact.php' );
		include_once( anva_get_core_directory() . '/widgets/class-anva-posts-list.php' );
	}

	/**
	 * Set core framework widgets
	 */
	private function set_core_widgets() {
		
		$this->core_widgets = array();

		// Default core widgets
		$this->core_widgets[] = 'Anva_Services';			// Services Image
		$this->core_widgets[] = 'Anva_Contact';				// Quick Contact Information
		$this->core_widgets[] = 'Anva_Posts_List';		// Posts List
		$this->core_widgets[] = 'Anva_Social_Media';	// Socia Media Buttons

		$this->core_widgets = apply_filters( 'anva_core_widgets', $this->core_widgets );

	}

	/**
	 * Set final widgets
	 * This sets the merged result of core widgets and custom widgets.
	 */
	public function set_widgets() {

		$this->widgets = array_merge( $this->core_widgets, $this->custom_widgets );

		// Remove widgets
		if ( $this->remove_widgets ) {
			foreach ( $this->remove_widgets as $widget ) {
				// Remove array $key by $value
				if ( ( $key = array_search( $widget, $this->widgets ) ) !== false ) {
    			unset( $this->widgets[$key] );
				}
			}
		}

		$this->widgets = apply_filters( 'anva_widgets', $this->widgets );

	}

	/**
	 * Add widget
	 */
	public function add_widget( $class ) {
		$this->custom_widgets[] = $class;
	}

	/**
	 * Remove widget
	 */
	public function remove_widget( $class ) {
		$this->remove_widgets[] = $class;
	}

	/**
	 * Get core widgets
	 */
	public function get_core_widgets() {
		return $this->core_widgets;
	}

	/**
	 * Get custom widgets
	 */
	public function get_custom_widgets() {
		return $this->custom_widgets;
	}

	/**
	 * Add widget
	 */
	public function get_remove_widgets() {
		return $this->remove_widgets;
	}

	/**
	 * Get final widgets
	 */
	public function get_widgets( $class = '' ) {

		if ( ! $class ) {
			return $this->widgets;
		}

		if ( isset( $this->widgets[$class] ) ) {
			return $this->widgets[$class];
		}

		return array();
	}

	/**
	 * Register widgets with WordPress
	 */
	public function register() {
		foreach ( $this->widgets as $widget ) {
			// Validate if widget class exists
			if ( class_exists( $widget ) ) {
				register_widget( $widget );
			}
		}
	}
}
endif;

/**
 * Add widget
 */
function anva_add_widget( $class ) {
	$api = Anva_Widgets::instance();
	$api->add_widget( $class );
}

/**
 * Remove widget
 */
function anva_remove_widget( $class ) {
	$api = Anva_Widgets::instance();
	$api->remove_widget( $class ); 
}

/**
 * Get widgets
 */
function anva_get_widgets() {
	$api = Anva_Widgets::instance();
	return $api->get_widgets();
}