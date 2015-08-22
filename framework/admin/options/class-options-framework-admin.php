<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

class Options_Framework_Admin {

	/**
	 * Page hook for the options screen
	 *
	 * @since 1.7.0
	 * @type string
	 */
	protected $options_screen = null;

	/**
	 * Hook in the scripts and styles
	 *
	 * @since 1.7.0
	 */
	public function init() {

		// Gets options to load
		$options = & Options_Framework::_optionsframework_options();

		// Checks if options are available
		if ( $options ) {

			// Add the options page and menu item.
			add_action( 'admin_menu', array( $this, 'add_custom_options_page' ) );

			// Add the required scripts and styles
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

			// Settings need to be registered after admin_init
			add_action( 'admin_init', array( $this, 'settings_init' ) );

			// Adds options menu to the admin bar
			add_action( 'wp_before_admin_bar_render', array( $this, 'optionsframework_admin_bar' ) );

		}

	}

	/**
	 * Registers the settings
	 *
	 * @since 1.7.0
	 */
	function settings_init() {

		global $pagenow;

		// Get the option name
		$name = anva_get_option_name();

		// Registers the settings fields and callback
		register_setting( 'optionsframework', $name, array( $this, 'validate_options' ) );
		
		// Displays notice after options save
		add_action( 'optionsframework_after_validate', array( $this, 'save_options_notice' ) );

		// Redirect to options panel
		if ( is_admin() && isset( $_GET['activated']) && 'themes.php' == $pagenow ) :
			wp_redirect( admin_url( 'themes.php?page=' . $name ) );
		endif;

	}

	/**
	 * Define menu options
	 *
	 * Examples usage:
	 *
	 * add_filter( 'optionsframework_menu', function( $menu ) {
	 *     $menu['page_title'] = 'The Options';
	 *	   $menu['menu_title'] = 'The Options';
	 *     return $menu;
	 * });
	 *
	 * @since 1.7.0
	 *
	 */
	static function menu_settings() {

		$menu = array(

			// Modes: submenu, menu
			'mode' 				=> 'submenu',

			// Submenu default settings
			'page_title' 	=> __( 'Theme Options', 'anva' ),
			'menu_title' 	=> __( 'Theme Options', 'anva' ),
			'capability' 	=> 'edit_theme_options',
			'menu_slug'  	=> 'options-framework',
			'parent_slug' => 'themes.php',

			// Menu default settings
			'icon_url' 		=> 'dashicons-admin-generic',
			'position' 		=> '61'

		);

		return apply_filters( 'optionsframework_menu', $menu );
	}

	/**
	 * Add a subpage called "Theme Options" to the appearance menu.
	 *
	 * @since 1.7.0
	 */
	function add_custom_options_page() {

		$menu = $this->menu_settings();

		// If you want a top level menu, see this Gist:
		// https://gist.github.com/devinsays/884d6abe92857a329d99

		// Code removed because it conflicts with .org theme check.

		$this->options_screen = add_theme_page(
			$menu['page_title'],
			$menu['menu_title'],
			$menu['capability'],
			$menu['menu_slug'],
			array( $this, 'options_page' )
		);

	}

	/**
	 * Loads the required stylesheets
	 *
	 * @since 1.7.0
	 */

	function enqueue_admin_styles( $hook ) {

		if ( $this->options_screen != $hook )
			return;

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'optionsframework', anva_get_core_url() . '/assets/css/admin/options.min.css', array(), Options_Framework::VERSION );
		wp_enqueue_style( 'jquery-slider-pips', anva_get_core_url(). '/assets/css/admin/jquery-ui-slider-pips.min.css', array(),  '' );
		wp_enqueue_style( 'jquery-ui-custom', anva_get_core_url() . '/assets/css/admin/jquery-ui-custom.min.css', array(), '' );
		
	}

	/**
	 * Loads the required javascript
	 *
	 * @since 1.7.0
	 */
	function enqueue_admin_scripts( $hook ) {

		if ( $this->options_screen != $hook )
			return;

		// Enqueue custom option panel JS
		wp_enqueue_script( 'jquery-slider-pips',  anva_get_core_url() . '/assets/js/admin/jquery-ui-slider-pips.min.js', array( 'jquery' ), '' );
		wp_enqueue_script( 'options-custom',  anva_get_core_url() . '/assets/js/admin/options.js', array( 'jquery','wp-color-picker' ), Options_Framework::VERSION );
		
		// Inline scripts from options-interface.php
		add_action( 'admin_head', array( $this, 'anva_admin_head' ) );
	}

	function anva_admin_head() {
		// Hook to add custom scripts
		do_action( 'optionsframework_custom_scripts' );
	}

	/**
	 * Builds out the options panel.
	 *
	 * If we were using the Settings API as it was intended we would use
	 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
	 * we'll call our own custom optionsframework_fields.  See options-interface.php
	 * for specifics on how each individual field is generated.
	 *
	 * Nonces are provided using the settings_fields()
	 *
	 * @since 1.7.0
	 */
	 function options_page() { ?>
		
		<div id="optionsframework-wrap" class="wrap">

			<?php $menu = $this->menu_settings(); ?>
			
			<h2><?php echo $menu['page_title']; ?> <span>v<?php echo THEME_VERSION; ?></span></h2>
			
			<?php do_action( 'optionsframework_top' ); ?>

			<h2 class="nav-tab-wrapper">
					<?php echo Options_Framework_Interface::optionsframework_tabs(); ?>
			</h2>

			<?php settings_errors( 'options-framework' ); ?>
			<?php do_action( 'optionsframework_before' ); ?>
			<div id="optionsframework-metabox" class="metabox-holder">
				<div id="optionsframework">
					<form class="options-settings" action="options.php" method="post">
						<div class="column-1">
							<?php settings_fields( 'optionsframework' ); ?>
							<?php Options_Framework_Interface::optionsframework_fields(); /* Settings */ ?>
						</div><!-- .column-1 (end) -->
						<div class="column-2">
							<div class="postbox-wrapper">
								<?php do_action( 'optionsframework_side_before' ); ?>
								<div id="optionsframework-submit" class="postbox">
									<h3><span><?php _e( 'Actions', 'anva' );?></span></h3>
									<div class="inside">
										<?php anva_admin_settings_log(); ?>
										<div class="actions">
											<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options', 'anva' ); ?>" />
											<span class="spinner"></span>
											<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'anva' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'anva' ) ); ?>' );" />
											<div class="clear"></div>
										</div>
									</div>
								</div>
								<?php do_action( 'optionsframework_side_after' ); ?>
							</div>
						</div><!-- .column-2 (end) -->
						<div class="clear"></div>
					</form>
				</div> <!-- #optionsframework (end) -->
			</div><!-- #optionsframework-metabox (end) -->
			<?php do_action( 'optionsframework_after' ); ?>
		</div><!-- .wrap -->

	<?php
	}

	/**
	 * Validate Options.
	 *
	 * This runs after the submit/reset button has been clicked and
	 * validates the inputs.
	 *
	 * @uses $_POST['reset'] to restore default options
	 */
	function validate_options( $input ) {

		/*
		 * Restore Defaults.
		 *
		 * In the event that the user clicked the "Restore Defaults"
		 * button, the options defined in the theme's options.php
		 * file will be added to the option for the active theme.
		 */

		if ( isset( $_POST['reset'] ) ) {
			// Delete log option
			$option_name = Options_Framework::get_option_name();
			delete_option( $option_name .'_log' );

			add_settings_error( 'options-framework', 'restore_defaults', __( 'Default options restored.', 'anva' ), 'updated fade' );
			return $this->get_default_values();
		}

		/*
		 * Update Settings
		 *
		 * This used to check for $_POST['update'], but has been updated
		 * to be compatible with the theme customizer introduced in WordPress 3.4
		 */

		$clean = array();
		$options = & Options_Framework::_optionsframework_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'anva_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'anva_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		// Hook to run after validation
		do_action( 'optionsframework_after_validate', $clean );

		// Create log option
		$option_name = Options_Framework::get_option_name();
		update_option( $option_name .'_log', current_time( 'mysql' ) );

		return $clean;
	}

	/**
	 * Display message when options have been saved
	 */

	function save_options_notice() {
		add_settings_error( 'options-framework', 'save_options', __( 'Options saved.', 'anva' ), 'updated fade' );
	}

	/**
	 * Get the default values for all the theme options
	 *
	 * Get an array of all default values as set in
	 * options.php. The 'id','std' and 'type' keys need
	 * to be defined in the configuration array. In the
	 * event that these keys are not present the option
	 * will not be included in this function's output.
	 *
	 * @return array Re-keyed options configuration array.
	 *
	 */
	function get_default_values() {
		$output = array();
		$config = & Options_Framework::_optionsframework_options();
		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
			if ( has_filter( 'anva_sanitize_' . $option['type'] ) ) {
				$output[$option['id']] = apply_filters( 'anva_sanitize_' . $option['type'], $option['std'], $option );
			}
		}

		return $output;
	}

	/**
	 * Add options menu item to admin bar
	 */

	function optionsframework_admin_bar() {

		$menu = $this->menu_settings();

		global $wp_admin_bar;

		if ( 'menu' == $menu['mode'] ) {
			$href = admin_url( 'admin.php?page=' . $menu['menu_slug'] );
		} else {
			$href = admin_url( 'themes.php?page=' . $menu['menu_slug'] );
		}

		$args = array(
			'parent' => 'appearance',
			'id' => 'anva_theme_options',
			'title' => $menu['menu_title'],
			'href' => $href
		);

		$wp_admin_bar->add_menu( apply_filters( 'optionsframework_admin_bar', $args ) );
	}

}