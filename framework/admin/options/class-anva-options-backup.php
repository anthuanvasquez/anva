<?php

/**
 * Backup your theme options to a downloadable json file.
 *
 * @since  1.0.0
 * @author Anthuan Vásquez <me@anthuanvasquez.net>
 */
class Anva_Options_Backup
{
	/**
	 * Admin page.
	 *
	 * @access private
	 * @var string
	 */
	private $admin_page;

	/**
	 * Current slug of the page.
	 *
	 * @access private
	 * @var string
	 */
	private $token = '';

	/**
	 * Default option name from DB.
	 *
	 * @access private
	 * @var string
	 */
	private $name = '';

	/**
	 * Constructor. Setup settings.
	 */
	public function __construct()
	{
		// Get default option name
		$option_name = anva_get_option_name();

		// Setup properties
		$this->admin_page = '';
		$this->token 	  = $option_name . '_backup';
		$this->name 	  = $option_name;
	}

	/**
	 * Register the admin screen.
	 *
	 * @since 1.0.0
	 */
	public function init ()
	{
		if ( is_admin() && current_user_can( anva_admin_module_cap( 'backup' ) ) ) {
			add_action( 'admin_menu', array( $this, 'register_admin_screen' ) );
		}
	}

	/**
	 * Register the admin screen within WordPress.
	 *
	 * @since 1.0.0
	 */
	function register_admin_screen ()
	{
		$menu = apply_filters( 'anva_options_backup_menu', array(
			'page_title' 	=> __( 'Backup Options', 'anva' ),
			'menu_title' 	=> __( 'Backup Options', 'anva' ),
			'capability' 	=> anva_admin_module_cap( 'backup' ),
			'slug' 			=> $this->token,
			'screen' 		=> array( $this, 'admin_screen' )
		));

		$this->admin_page = add_theme_page(
			$menu['page_title'],
			$menu['menu_title'],
			$menu['capability'],
			$menu['slug'],
			$menu['screen']
		);

		// Adds actions to hook in the required css and javascript
		add_action( "admin_print_styles-$this->admin_page", array( $this, 'load_adminstyles' ) );

		// Admin screen logic.
		add_action( 'load-' . $this->admin_page, array( $this, 'admin_screen_logic' ) );

		// Add contextual help.
		add_action( 'contextual_help', array( $this, 'admin_screen_help' ), 10, 3 );

		add_action( 'admin_notices', array( $this, 'admin_notices' ), 10 );
	}

	/**
	 * Load the CSS
	 *
	 * @since 1.0.0
	 */
	public function load_adminstyles()
	{
		wp_enqueue_style( 'sweetalert', ANVA_FRAMEWORK_ADMIN_CSS . 'sweetalert.min.css', array(), '1.1.3' );
		wp_enqueue_script( 'sweetalert', ANVA_FRAMEWORK_ADMIN_JS . 'sweetalert.min.js', array( 'jquery' ), '1.1.3' );
		wp_enqueue_style( 'anva-options', ANVA_FRAMEWORK_ADMIN_CSS . 'options.min.css', array(), ANVA_FRAMEWORK_VERSION, 'all' );
	}

	/**
	 * admin_screen()
	 *
	 * @since 1.0.0
	 */
	public function admin_screen ()
	{
	?>
	<div id="anva-framework-wrap" class="wrap">
		
		<h2><?php _e( 'Import / Export Settings', 'anva' ); ?></h2>
		
		<div id="anva-framework-metabox" class="metabox-holder">
			<?php do_action( 'anva_options_backup_importer_before' ); ?>
			<div id="anva-framework">
				<div class="options-settings import-export-settings">
					
					<div class="column-1">
						
						<div id="import-notice" class="section-info warning">
							<p><?php printf( __( 'Please note that this backup manager backs up only your theme settings and not your content. To backup your content, please use the %sWordPress Export Tool%s.', 'anva' ), '<a href="' . esc_url( admin_url( 'export.php' ) ) . '">', '</a>' ); ?></p>
						</div><!-- #import-notice (end) -->

						<div class="postbox inner-group">
							<h3><?php _e( 'Import Settings', 'anva' ); ?></h3>
							<div class="section-description">
								 <?php _e( 'To get started, upload your backup file to import from below.', 'anva' ); ?>
							</div>
							<div class="section section-import">
								<h4 class="heading"><?php printf( __( 'Upload File: (Maximum Size: %s)', 'anva' ), ini_get( 'post_max_size' ) ); ?></h4>
								<div class="option option-import">
									<div class="controls">
										<form enctype="multipart/form-data" method="post" action="<?php echo admin_url( 'admin.php?page=' . $this->token ); ?>">
											<?php wp_nonce_field( 'anva-options-backup-import' ); ?>
											<input type="file" id="anva-options-import-file" name="anva-options-import-file" class="anva-input-file" />
											<input type="hidden" name="anva-options-backup-import" value="1" />
											<input type="submit" class="button" value="<?php _e( 'Upload File and Import', 'anva' ); ?>" />
										</form>
									</div>
									<div class="explain">
										<?php _e( 'If you have settings in a backup file on your computer, the Import / Export system can import those into this site.', 'anva' ); ?>
									</div>
								</div><!-- .import (end) -->
							</div><!-- .section -->
						</div><!-- .iinner-group (end) -->
						
						<div class="postbox inner-group">
							<h3><?php _e( 'Export Settings', 'anva' ); ?></h3>
							<div class="section-description">
								<?php _e( 'When you click the button below, the Import / Export system will create a json file for you to save to your computer.', 'anva' ); ?>
							</div>
							<div class="section section-export">
								<h4 class="heading"><?php _e( 'Export File:', 'anva' ); ?></h4>
								<div class="option option-export">
									<div class="controls">
										<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=' . $this->token ) ); ?>">
											<?php wp_nonce_field( 'anva-options-backup-export' ); ?>
											<input type="hidden" name="anva-options-backup-export" value="1" />
											<input type="submit" class="button" value="<?php _e( 'Download Export File' , 'anva' ); ?>" />
										</form>
									</div>
									<div class="explain">
										<?php printf( __( 'This json file can be used to restore your settings here on "%s", or to easily setup another website with the same settings. Note: te file encrypted to protect your settings data.', 'anva' ), get_bloginfo( 'name' ) ); ?>
									</div>
								</div><!-- .export (end) -->
							</div><!-- .section (end) -->
						</div><!-- .inner-group (end) -->
						<?php do_action( 'anva_options_backup_after_fields' ); ?>
					</div><!-- .column-1 (end) -->

					<div class="column-2">
					</div><!-- .column-2 (end) -->

					<div class="clear"></div>

				</div><!-- .import-export-settings (end) -->
			</div>
			<?php do_action( 'anva_options_backup_importer_after' ); ?>
		</div><!-- #anva-framework-metabox (nd) -->
	</div><!-- #anva-framework-wrap-->
	<?php
	}

	/**
	 * Add contextual help to the admin screen.
	 *
	 * @since 1.0.0
	 */
	public function admin_screen_help ( $contextual_help, $screen_id, $screen )
	{
		if ( $this->admin_page == $screen->id ) {
			$contextual_help =
				'<h3>' . sprintf( __( 'Welcome to the %s Backup Manager.', 'anva' ), ucfirst ( $this->name ) ) . '</h3>' .
				'<p>' . __( 'Here are a few notes on using this screen.', 'anva' ) . '</p>' .
				'<p>' . __( 'The backup manager allows you to backup or restore your "Theme Options" and other settings to or from a text file.', 'anva' ) . '</p>' .
				'<p>' . __( 'To create a backup, simply select the setting type you\'d like to backup (or "All Settings") and hit the "Download Export File" button.', 'anva' ) . '</p>' .
				'<p>' . __( 'To restore your settings from a backup, browse your computer for the file (under the "Import Settings" heading) and hit the "Upload File and Import" button. This will restore only the settings that have changed since the backup.', 'anva' ) . '</p>' .
				'<p><strong>' . sprintf( __( 'Please note that only valid backup files generated through the %s Backup Manager should be imported.', 'anva' ), ucfirst ( $this->name ) ) . '</strong></p>' .
				'<p><strong>' . __( 'Looking for assistance?', 'anva' ) . '</strong></p>' .
				'<p>' . sprintf( __( 'Please post your query on the %s where we will do our best to assist you further.', 'anva' ), sprintf( '<a href="' . esc_url( 'http://www.themeforest.com/user/oidoperfecto/portfolio' ) . '" target="_blank">%s</a>', __( 'ThemeForest Support Item', 'anva' ) ) ) . '</p>';
		}
		return $contextual_help;
	}

	/**
	 * Display admin notices when performing backup/restore.
	 *
	 * @since 1.0.0
	 */
	public function admin_notices ()
	{
		if ( ! isset( $_GET['page'] ) || ( $_GET['page'] != $this->token ) ) {
			return;
		}

		if ( isset( $_GET['error-import'] ) && $_GET['error-import'] == 'true' ) {
			anva_flash_message( __( 'Error', 'anva' ), __( 'There was a problem importing your settings. Please Try again.', 'anva' ), 'error' );
		}

		if ( isset( $_GET['error-export'] ) && $_GET['error-export'] == 'true' ) {
			anva_flash_message( __( 'Error', 'anva' ), __( 'There was a problem exporting your settings. Please Try again.', 'anva' ), 'error' );		
		}

		if ( isset( $_GET['invalid'] ) && $_GET['invalid'] == 'true' ) {
			anva_flash_message( __( 'Invalid', 'anva' ), __( 'The import file you\'ve provided is invalid. Please try again.', 'anva' ), 'error' );
		}
		
		if ( isset( $_GET['imported'] ) && $_GET['imported'] == 'true' ) {
			anva_flash_message( __( 'Pass!', 'anva' ), __( 'Settings successfully imported.', 'anva' ), 'success' );
		}

		if ( isset( $_GET['imported-error'] ) && $_GET['imported-error'] == 'true' ) {
			anva_flash_message( __( 'Error', 'anva' ), __( 'Import settings failed when it tried to update the options.', 'anva' ), 'error' );
		}
	}

	/**
	 * The processing code to generate the backup or restore from a previous backup.
	 *
	 * @since 1.0.0
	 */
	public function admin_screen_logic () {
		if ( isset( $_POST['anva-options-backup-import'] ) && ( $_POST['anva-options-backup-import'] == true ) ) {
			$this->import();
		}

		if ( isset( $_POST['anva-options-backup-export'] ) && ( $_POST['anva-options-backup-export'] == true ) ) {
			$this->export();
		}
	}

	/**
	 * Import settings from a backup file.
	 *
	 * @return void
	 */
	public function import()
	{
		check_admin_referer( 'anva-options-backup-import' ); // Security check.

		if ( ! isset( $_FILES['anva-options-import-file'] ) ) { return; } // We can't import the settings without a settings file.

		// Extract file contents
		$upload = file_get_contents( $_FILES['anva-options-import-file']['tmp_name'] );

		// Decode base64
		$data = base64_decode( $upload );

		// Decode the JSON from the uploaded file
		$datafile = json_decode( $data, true );

		// Check for errors
		if ( $_FILES['anva-options-import-file']['error'] ) {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&error-import=true' ) );
			exit;
		}

		// Make sure this is a valid backup file.
		if ( ! isset( $datafile['anva-options-backup-validator'] ) ) {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&invalid=true' ) );
			exit;
		
		} else {
			// Now that we've checked it.
			// We don't need the field anymore.
			unset( $datafile['anva-options-backup-validator'] );
		}

		// Get the theme name from database.
		$option_name = $this->name;

		// Update the settings in database
		if ( update_option( $option_name, $datafile ) ) {

			// Redirect, add success flag to the URI
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&imported=true' ) );
			exit;

		} else {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&imported-error=true' ) );
			exit;
		}
	}

	/**
	 * Export settings to a backup file.
	 *
	 * @return void
	 */
	public function export()
	{	
		check_admin_referer( 'anva-options-backup-export' ); // Security check.

		// Get option name
		$option_name = $this->name;
		$database_options = get_option( $option_name );

		// Error trapping for the export.
		if ( $database_options == '' ) {
			wp_redirect( admin_url( 'admin.php?page=' . $this->token . '&error-export=true' ) );
			return;
		}

		if ( ! $database_options ) {
			return;
		}

		// Add our custom marker, to ensure only valid files are imported successfully.
		$database_options['anva-options-backup-validator'] = date( 'Y-m-d h:i:s' );

		// Generate the export file to json.
		$json = json_encode( (array)$database_options );

		// Encode json file with base64 to protect the data
		$hash = base64_encode( $json );

		// Get the file
		$output = $hash;

		header( 'Content-Description: File Transfer' );
		header( 'Cache-Control: public, must-revalidate' );
		header( 'Pragma: hack' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Disposition: attachment; filename="' . $option_name . '-' . $this->token . '-' . date( 'Y-m-d-His' ) . '.json"' );
		header( 'Content-Length: ' . strlen( $output ) );
		echo $output;
		exit;
	}
}