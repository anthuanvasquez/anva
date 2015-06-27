<?php
/**
 * Stylesheets
 * This class sets up the framework stylesheets that get
 * enqueued on the frontend of the website.
 * Additionally, this class provides methods to add and
 * remove stylesheets. Client API-added stylesheets are organized
 * within four levels.
 *	- Level 1: Before Framework styles
 *	- Level 2: After Framework styles
 *	- Level 3: After Theme styles (implemented at theme level)
 *	- Level 4: After everything. (end of wp_head)
 */
class Anva_Stylesheets {

	/**
	 * Properties
	 */
	private static $instance = null;
	private $remove_stylesheets = array();
	private $framework_stylesheets = array();
	private $framework_deps = array();
	private $client_stylesheets = array();

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

		// Setup stylesheets from Framework and Client API.
		// No enqueuing yet.
		add_action( 'wp_enqueue_scripts', array( $this, 'set_framework_stylesheets' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'set_client_stylesheets' ), 1 );

		// Include stylesheets, framework and levels 1, 2, and 4
		// Note: Level 3 needs to be included at the theme level.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_framework_stylesheets' ), 5 );
		add_action( 'wp_head', array( $this, 'closing_stylesheets' ), 11 );
	}

	/**
	 * Set core framework stylesheet
	 */
	public function set_framework_stylesheets() {

		$this->framework_stylesheets = array();

		// Boostrap
		$this->framework_stylesheets['bootstrap'] = array(
			'handle'	=> 'bootstrap',
			'src'		=> TB_FRAMEWORK_URI.'/assets/plugins/bootstrap/css/bootstrap.min.css',
			'deps'		=> array(),
			'ver'		=> '2.3.2',
			'media'		=> 'all'

		);

		// FontAwesome
		$this->framework_stylesheets['fontawesome'] = array(
			'handle'	=> 'fontawesome',
			'src'		=> TB_FRAMEWORK_URI.'/assets/plugins/fontawesome/css/font-awesome.min.css',
			'deps'		=> array(),
			'ver'		=> '3.2.1',
			'media'		=> 'all'
		);

		// Magnific Popup
		$this->framework_stylesheets['magnific_popup'] = array(
			'handle'	=> 'magnific_popup',
			'src'		=> TB_FRAMEWORK_URI.'/assets/css/magnificpopup.min.css',
			'deps'		=> array(),
			'ver'		=> '0.9.3',
			'media'		=> 'all'
		);

		// Primary framework styles
		$this->framework_stylesheets['themeblvd'] = array(
			'handle'	=> 'themeblvd',
			'src'		=> TB_FRAMEWORK_URI.'/assets/css/themeblvd.min.css',
			'deps'		=> array(),
			'ver'		=> TB_FRAMEWORK_VERSION,
			'media'		=> 'all'
		);

		// Remove stylesheets
		if ( $this->remove_stylesheets ) {
			foreach ( $this->remove_stylesheets as $key => $handle ) {
				if ( isset( $this->framework_stylesheets[$handle] ) ) {

					// Remove framework stylesheet
					unset( $this->framework_stylesheets[$handle] );

					// Now that we've found the stylesheet and removed it,
					// we don't need to de-register it later.
					unset( $this->remove_stylesheets[$key] );

				}
			}
		}

		// Set framework $deps
		if ( $this->framework_stylesheets ) {
			foreach ( $this->framework_stylesheets as $handle => $args ) {
				$this->framework_deps[] = $handle;
			}
		}

		// Backwards compat for $deps
		$GLOBALS['anva_framework_stylesheets'] = apply_filters('anva_framework_stylesheets', $this->framework_deps );

	}

	/**
	 * Set client stylesheets
	 */
	public function set_client_stylesheets() {

		if ( ! is_admin() ) {

			// Remove stylesheets
			if ( $this->remove_stylesheets ) {
				foreach ( $this->remove_stylesheets as $handle ) {
					unset( $this->remove_stylesheets[$handle] );
				}
			}

			// Re-format array of client stylesheets that are left
			// to be organized by level.
			$temp_stylesheets = $this->client_stylesheets;

			$this->client_stylesheets = array(
				'1' => array(),	// Level 1: Before Framework styles
				'2' => array(),	// Level 2: After Framework styles
				'3' => array(),	// Level 3: After Theme styles
				'4' => array()	// Level 4: After Theme Options-generated styles
			);

			if ( $temp_stylesheets ) {
				foreach ( $temp_stylesheets as $handle => $file ) {
					$key = $file['level'];
					$this->client_stylesheets[$key][$handle] = $file;
				}

			}

		}

	}

	/**
	 * Add stylesheet
	 */
	public function add( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
		if ( ! is_admin() ) {
			$this->client_stylesheets[$handle] = array(
				'handle' 	=> $handle,
				'src' 		=> $src,
				'level' 	=> $level,
				'ver' 		=> $ver,
				'media' 	=> $media
			);
		}
	}

	/**
	 * Remove stylesheet
	 */
	public function remove( $handle ) {
		if ( ! is_admin() ) {
			$this->remove_stylesheets[] = $handle;
		}
	}

	/**
	 * Get stylehsheets to be removed
	 */
	public function get_remove_stylesheets() {
		return $this->remove_stylesheets;
	}

	/**
	 * Get framework stylesheets.
	 * Will only be fully available at the time it's enqueing everything.
	 * Not very useful in most cases.
	 */
	public function get_framework_stylesheets() {
		return $this->framework_stylesheets;
	}

	/**
	 * Get an array that could be used as your $deps if
	 * manually trying to enqueue stylehsheet after framework stylesheets.
	 */
	public function get_framework_deps() {
		return $this->framework_deps;
	}


	/**
	 * Get stylesheets added through client API
	 */
	public function get_client_stylesheets() {
		return $this->client_stylesheets;
	}

	/**
	 * Enqueue framework stylesheets
	 */
	public function enqueue_framework_stylesheets() {

		// Level 1 client stylesheets
		$this->print_styles(1);

		// Enqueue framework stylesheets
		if ( $this->framework_stylesheets ) {
			foreach ( $this->framework_stylesheets as $style ) {
				wp_enqueue_style( $style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
			}
		}

		// Level 2 client stylesheets
		$this->print_styles(2);

	}

	/**
	 * Output closing stylesheets. Hooked to wp_head, giving
	 * a chance to for a stylesheet outside of WP's enqueue
	 * system.
	 */
	public function closing_stylesheets() {
		// Level 4 stylesheets
		$this->print_styles(4);

	}

	/**
	 * Print stylesheets. For levels 1-3, this means using
	 * WP's wp_enqueue_style(), and for level 4, the stylesheet
	 * is manually outputed at the end of wp_head.
	 */
	public function print_styles( $level = 1 ) {

		// Only levels 1-4 currently exist
		if ( ! in_array( $level, array(1, 2, 3, 4) ) ) {
			return;
		}

		// Add styles
		if ( $level == 4 ) {

			// Manually insert level 4 stylesheets
			if ( $this->client_stylesheets[4] ) {
				foreach ( $this->client_stylesheets[4] as $file ) {
					printf( "<link rel='stylesheet' id='%s' href='%s' type='text/css' media='%s' />\n", $file['handle'], $file['src'], $file['media'] );
				}
			}

		} else {

			// Use WordPress's enqueue system
			if ( $this->client_stylesheets[$level] ) {
				foreach ( $this->client_stylesheets[$level] as $file ) {
					wp_enqueue_style( $file['handle'], $file['src'], array(), $file['ver'], $file['media'] );
				}
			}

		}

	}
}

/**
 * Add custom stylesheet
 */
function anva_add_stylesheet( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
	$api = Anva_Stylesheets::instance();
	$api->add( $handle, $src, $level, $ver, $media );
}

/**
 * Remove custom stylesheet
 */
function anva_remove_stylesheet( $handle ) {
	$api = Anva_Stylesheets::instance();
	$api->remove( $handle );
}

/**
 * Print out styles
 */
function anva_print_styles( $level ) {
	$api = Anva_Stylesheets::instance();
	$api->print_styles( $level );
}
