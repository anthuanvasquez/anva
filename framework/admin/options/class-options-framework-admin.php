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
		if ( is_admin() && current_user_can( anva_admin_module_cap( 'options' ) ) ) {
			// Gets options to load
			$options = anva_get_options();

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
	 * @since 1.7.0
	 */
	static function menu_settings() {

		$menu = array(
			'mode' 			=> 'submenu',
			'page_title' 	=> __( 'Theme Options', 'anva' ),
			'menu_title' 	=> __( 'Theme Options', 'anva' ),
			'capability' 	=> 'edit_theme_options',
			'menu_slug'  	=> 'options-framework',
			'parent_slug' 	=> 'themes.php',
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
		wp_enqueue_style( 'anva-animate', anva_get_core_uri() . '/assets/css/admin/animate.min.css', array(), ANVA_FRAMEWORK_VERSION );
		wp_enqueue_style( 'sweetalert', anva_get_core_uri() . '/assets/css/admin/sweetalert.min.css', array(), '1.1.3' );
		wp_enqueue_style( 'optionsframework', anva_get_core_uri() . '/assets/css/admin/options.min.css', array(), ANVA_FRAMEWORK_VERSION );
		wp_enqueue_style( 'jquery-slider-pips', anva_get_core_uri(). '/assets/css/admin/jquery-ui-slider-pips.min.css', array(),  '1.7.2' );
		wp_enqueue_style( 'jquery-ui-custom', anva_get_core_uri() . '/assets/css/admin/jquery-ui-custom.min.css', array(), '1.11.4' );
		
	}

	/**
	 * Loads the required javascript
	 *
	 * @since 1.7.0
	 */
	function enqueue_admin_scripts( $hook ) {

		if ( $this->options_screen != $hook )
			return;

		wp_enqueue_script( 'optionsframework',  anva_get_core_uri() . '/assets/js/admin/options.js', array( 'jquery','wp-color-picker' ), ANVA_FRAMEWORK_VERSION );

		// Enqueue custom option panel JS
		wp_enqueue_script( 'sweetalert',  anva_get_core_uri() . '/assets/js/admin/sweetalert.min.js', array( 'jquery' ), '1.1.3' );
		wp_enqueue_script( 'jquery-slider-pips',  anva_get_core_uri() . '/assets/js/admin/jquery-ui-slider-pips.min.js', array( 'jquery' ), '1.7.2' );
		wp_enqueue_script( 'optionsframework' );
		wp_localize_script( 'optionsframework', 'anvaJs', anva_get_admin_locals( 'js' ) );

		
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

			<?php
				$menu = $this->menu_settings();
				$options = anva_get_options();
			?>
			
			<h2><?php echo $menu['page_title']; ?> <span>v<?php echo anva_get_theme( 'version' ); ?></span></h2>
			
			<?php do_action( 'optionsframework_top' ); ?>

			<h2 class="nav-tab-wrapper">
				<?php echo anva_get_options_tabs( $options ); ?>
			</h2>
			
			<?php settings_errors( 'options-framework' ); ?>
			
			<?php do_action( 'optionsframework_before' ); ?>

			<div id="optionsframework-metabox" class="metabox-holder">
				<div id="optionsframework">
					<form class="options-settings" action="options.php" method="post">
						<div class="columns-1">
							<?php echo '<input type="hidden" id="option_name" value="' . anva_get_option_name()  . '" >';  ?>
							<?php settings_fields( 'optionsframework' ); ?>
							<?php
								/* Settings */
								$option_name = anva_get_option_name();
								$settings = get_option( $option_name );
								anva_get_options_fields( $option_name, $settings, $options );
							?>
							<?php do_action( 'optionsframework_after_fields' ); ?>
						</div><!-- .columns-1 (end) -->
						<div class="columns-2">
							<div class="postbox-wrapper">
								<?php do_action( 'optionsframework_side_before' ); ?>
								<div id="optionsframework-submit" class="postbox">
									<h3><span><?php esc_html_e( 'Actions', 'anva' );?></span></h3>
									<div class="inside">
										<?php anva_admin_settings_log(); ?>
										<div class="actions">
											<input type="submit" class="button button-primary update-button" name="update" value="<?php esc_attr_e( 'Save Options', 'anva' ); ?>" />
											<span class="spinner"></span>
											<input type="submit" class="button button-secondary reset-button" value="<?php esc_attr_e( 'Restore Defaults', 'anva' ); ?>" />
											<div class="clear"></div>
										</div>
									</div>
								</div>
								<?php do_action( 'optionsframework_side_after' ); ?>
							</div>
						</div><!-- .columns-2 (end) -->
						<div class="clear"></div>
					</form>
				</div><!-- #optionsframework (end) -->
			</div><!-- #optionsframework-metabox (end) -->
			<?php do_action( 'optionsframework_after' ); ?>
		</div><!-- .wrap (end) -->

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

		// Need it to create log for the changed settings
		$option_name = anva_get_option_name();

		/*
		 * Restore Defaults
		 *
		 * In the event that the user clicked the "Restore Defaults"
		 * button, the options defined in the theme's options.php
		 * file will be added to the option for the active theme.
		 * 
		 */
		if ( isset( $_POST['reset'] ) ) {

			global $_anva_settings_error;

			$_anva_settings_error = array(
				'title' => __( 'Options Restored!', 'anva' ),
				'message' => __( 'Default options restored.', 'anva' ),
				'type' => 'success',
			);

			// Delete log
			delete_option( $option_name . '_log' );

			// Add notice
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
		
		$options = anva_get_options();
		
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

		// Create or update the last changed settings
		update_option( $option_name . '_log', current_time( 'mysql' ) );

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
		$config = anva_get_options();
		
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