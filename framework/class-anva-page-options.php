<?php

if ( ! class_exists( 'Anva_Page_Options' ) ) :

/**
 * Create the options page panel.
 *
 * @since  		1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
class Anva_Page_Options {

	/**
	 * A single instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Global option name.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $option_id = '';

	/**
	 * Global options.
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	protected $options = array();

	/**
	 * Page hook for the options screen.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $options_screen = null;

	/**
	 * If sanitization has run yet or not when saving
	 * options.
	 *
	 * @since 1.0.0
	 * @var   bool
	 */
	private $sanitized = false;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Hook in the scripts and styles.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {
		if ( is_admin() && current_user_can( anva_admin_module_cap( 'options' ) ) ) {

			// Set option name.
			$this->option_id = anva_get_option_name();

			// Get options to load.
			$this->options = anva_get_options();

			// Checks if options are available.
			if ( $this->options ) {

				// Add the options page and menu item.
				add_action( 'admin_menu', array( $this, 'add_page_options' ) );

				// Add the required assets.
				add_action( 'admin_enqueue_scripts', array( $this, 'assets' ), 10 );

				// Settings need to be registered after admin_init.
				add_action( 'admin_init', array( $this, 'settings_init' ) );

				// Adds options menu to the admin bar.
				add_action( 'wp_before_admin_bar_render', array( $this, 'admin_bar' ) );

			}
		}
	}

	/**
	 * Registers the settings fields and callback.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function settings_init() {
		register_setting( 'anva_page_options_settings', $this->option_id, array( $this, 'validate_options' ) );
	}

	/**
	 * Define menu options.
	 *
	 * @since  1.0.0
	 * @return $menu
	 */
	public static function get_menu_settings() {
		$menu = array(
			'mode' 			=> 'submenu',
			'page_title' 	=> esc_html__( 'Theme Options', 'anva' ),
			'menu_title' 	=> esc_html__( 'Theme Options', 'anva' ),
			'capability' 	=> anva_admin_module_cap( 'options' ),
			'menu_slug'  	=> anva_get_option_name(),
			'parent_slug' 	=> 'themes.php',
			'icon_url' 		=> 'dashicons-admin-generic',
			'position' 		=> '61',
		);

		return apply_filters( 'anva_page_options_menu', $menu );
	}

	/**
	 * Add a subpage to the appearance menu.
	 *
	 * @since 1.0.0
	 */
	public function add_page_options() {
		$menu = $this->get_menu_settings();

		$this->options_screen = add_theme_page(
			$menu['page_title'],
			$menu['menu_title'],
			$menu['capability'],
			$menu['menu_slug'],
			array( $this, 'display' )
		);
	}

	/**
	 * Loads the required javascript.
	 *
	 * @since  1.0.0
	 * @param  object $hook
	 * @return void
	 */
	public function assets( $hook ) {
		if ( $this->options_screen != $hook ) {
			return;
		}

		wp_enqueue_script( 'codemirror', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/codemirror.js', array( 'jquery' ), '5.13.2', true );
		wp_enqueue_script( 'codemirror_mode_css', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/mode/css/css.js', array( 'codemirror' ), '5.13.2', true );
		wp_enqueue_script( 'codemirror_mode_js', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/mode/javascript/javascript.js', array( 'codemirror' ), '5.13.2', true );
		wp_enqueue_script( 'jquery-codemirror', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/jquery.codemirror.js', array( 'jquery', 'codemirror_mode_js' ), Anva::get_version(), true );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-slider-pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.js', array( 'jquery' ), '1.7.2', true );
		wp_enqueue_script( 'jquery-animsition', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'animsition/animsition.min.js', array( 'jquery' ), '4.0.1', true );
		wp_enqueue_script( 'jquery-selectric', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'selectric/jquery.selectric.min.js', array( 'jquery' ), '1.9.6', true );
		wp_enqueue_script( 'jquery-select2', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'select2/select2.min.js', array( 'jquery' ), '4.0.3', true );
		wp_enqueue_script( 'anva_options', ANVA_FRAMEWORK_ADMIN_JS . 'admin-options.js', array( 'jquery', 'wp-color-picker' ), Anva::get_version(), true );
		wp_localize_script( 'anva_options', 'AnvaOptionsLocal', anva_get_admin_locals( 'js' ) );

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'codemirror', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/codemirror.css', array(), '5.13.2' );
		wp_enqueue_style( 'codemirror_theme', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'codemirror/theme/mdn-like.css', array(), '5.13.2' );
		wp_enqueue_style( 'jquery_ui_custom', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-custom.min.css', array(), '1.11.4' );
		wp_enqueue_style( 'jquery_ui_slider_pips', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'jquery-ui/jquery-ui-slider-pips.min.css', array(),  '1.11.3' );
		wp_enqueue_style( 'animsition', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'animsition/animsition.min.css', array(), '4.0.1' );
		wp_enqueue_style( 'selectric', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'selectric/selectric.css', array(), '1.9.6' );
		wp_enqueue_style( 'select2', ANVA_FRAMEWORK_ADMIN_PLUGINS . 'select2/select2.min.css', array(), '4.0.3' );
		wp_enqueue_style( 'anva_options', ANVA_FRAMEWORK_ADMIN_CSS . 'admin-options.css', array(), Anva::get_version() );

		// Inline scripts.
		add_action( 'admin_head', array( $this, 'head' ) );
	}

	/**
	 * Hook to add custom scripts.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function head() {
		/**
		 * Admin custom scripts not hooked by default.
		 */
		do_action( 'anva_page_options_custom_scripts' );
	}

	/**
	 * Display the options panel.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function display() {
	?>
		<div id="anva-framework-wrap" class="anva-framework-wrap wrap">

			<?php
				$menu = $this->get_menu_settings();
				printf(
					'<h2 class="anva-page-title">%1$s <span>%3$s<em>%2$s</em></span></h2>',
					esc_html( $menu['page_title'] ),
					anva_get_theme( 'version' ),
					esc_html__( 'Version', 'anva' )
				);
			 ?>

			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_admin_check_settings
				 */
				do_action( 'anva_page_options_top' );
			?>

			<?php settings_errors( 'anva-options-page-errors', false, false ); ?>

			<h2 class="nav-tab-wrapper">
				<?php anva_the_options_tabs( $this->options ); ?>
			</h2>

			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_admin_add_settings_change
				 */
				do_action( 'anva_page_options_before' );
			?>

			<div id="anva-framework-metabox" class="anva-framework-metabox metabox-holder">
				<div id="anva-framework" class="anva-framework animsition">
					<form class="anva-framework-settings options-settings" action="options.php" method="post">
						<div class="columns-1">
							<input type="hidden" id="option_name" value="<?php anva_the_option_name(); ?>" >
							<?php
								settings_fields( 'anva_page_options_settings' );

								// Fields UI.
								anva_the_options_fields( $this->option_id, anva_get_option_all(), $this->options, true );

								/**
								 * Hooked.
								 *
								 * @see anva_admin_footer_credits, anva_admin_footer_links
								 */
								do_action( 'anva_page_options_after_fields' );
							?>
						</div><!-- .columns-1 (end) -->

						<div class="columns-2">
							<div class="postbox-wrapper">
								<?php
									/**
									 * Admin page side before not hooked by default.
									 */
									do_action( 'anva_page_options_side_before' );
								?>
								<div id="anva-framework-submit" class="postbox">
									<h3>
										<span>
											<?php esc_html_e( 'Actions', 'anva' ); ?>
										</span>
									</h3>
									<div class="inside">
										<?php anva_admin_settings_last_save(); ?>
										<div class="show-all">
											<button type="button" class="button button-secondary">
												<?php esc_html_e( 'Show All Options' ); ?>
											</button>
										</div>
										<div class="actions">
											<input type="submit" class="button button-primary update-button" name="update" value="<?php esc_attr_e( 'Save Options', 'anva' ); ?>" />
											<span class="spinner"></span>
											<input type="submit" class="button button-secondary reset-button" value="<?php esc_attr_e( 'Restore Defaults', 'anva' ); ?>" />
											<div class="clear"></div>
										</div>
									</div>
								</div>
								<?php
									/**
									 * Admin page side after not hooked by default.
									 */
									do_action( 'anva_page_options_side_after' );
								?>
							</div>
						</div><!-- .columns-2 (end) -->
						<div class="clear"></div>
					</form>
				</div>
			</div><!-- #anva-framework-metabox (end) -->
			<?php
				/**
				 * Admin page after not hooked by default.
				 */
				do_action( 'anva_page_options_after' );
			?>
		</div><!-- #anva-framework-wrap (end) -->
	<?php
	}

	/**
	 * Validate Options.
	 *
	 * This runs after the submit/reset button has been clicked and
	 * validates the inputs.
	 *
	 * @uses   $_POST['reset'] to restore default options
	 *
	 * @since  1.0.0
	 * @param  array $input
	 * @return array $clean
	 */
	public function validate_options( $input ) {

		// Restore Defaults.
		if ( isset( $_POST['reset'] ) ) {

			// Reset last saved.
			delete_option( $this->option_id . '_last_save' );

			// Add notice.
			$this->save_options_notice( 'restore_defaults', esc_html__( 'Default options restored.', 'anva' ) );

			return anva_get_default_options_values();
		}

		// Update Settings.
		$clean = array();

		foreach ( $this->options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST.
			if ( 'checkbox' == $option['type'] && ! isset( $input[ $id ] ) ) {
				$input[ $id ] = false;
			}

			// Set switch to false if it wasn't sent in the $_POST.
			if ( 'switch' == $option['type'] && ! isset( $input[ $id ] ) ) {
				$input[ $id ] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST.
			if ( 'multicheck' == $option['type'] && ! isset( $input[ $id ] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[ $id ][ $key ] = false;
				}
			}

			// Set sidebar to false if it wasn't sent in the $_POST.
			if ( 'sidebar' == $option['type'] && ! isset( $input[ $id ] ) ) {
				$input[ $id ] = array();
			}

			// For a value to be submitted to database it
			// must pass through a sanitization filter.
			if ( has_filter( 'anva_sanitize_' . $option['type'] ) ) {
				$clean[ $id ] = apply_filters( 'anva_sanitize_' . $option['type'], $input[ $id ], $option );
			}
		}

		// Add update message for page re-fresh
		// Avoid duplicates.
		if ( ! $this->sanitized ) {
			$this->save_options_notice( 'save_options', esc_html__( 'Options saved.', 'anva' ) );
		}

		// We know sanitization has happenned at
		// least once at this point so set to true.
		$this->sanitized = true;

		/**
		 * Hook to run after validation.
		 */
		do_action( 'anva_page_options_after_validate', $clean );

		// Create or update the last time changed settings.
		update_option( $this->option_id . '_last_save', current_time( 'mysql' ) );

		return $clean;
	}

	/**
	 * Display message when options have been saved.
	 *
	 * @since  1.0.0
	 */
	public function save_options_notice( $id, $desc ) {
		add_settings_error( 'anva-options-page-errors', $id, $desc, 'updated fade' );
	}


	/**
	 * Add options menu item to admin bar.
	 *
	 * @global $wp_admin_bar
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_bar() {
		$menu = $this->get_menu_settings();

		global $wp_admin_bar;

		if ( 'menu' == $menu['mode'] ) {
			$href = admin_url( 'admin.php?page=' . $menu['menu_slug'] );
		} else {
			$href = admin_url( 'themes.php?page=' . $menu['menu_slug'] );
		}

		$args = array(
			'parent' => 'appearance',
			'id'     => 'anva_theme_options',
			'title'  => $menu['menu_title'],
			'href'   => $href,
		);

		$wp_admin_bar->add_menu( apply_filters( 'anva_page_options_admin_bar', $args ) );
	}

}

endif;
