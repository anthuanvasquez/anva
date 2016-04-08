<?php

if ( ! class_exists( 'Anva_Options_Import_Export' ) ) :

class Anva_Options_Import_Export
{	
	/**
	 * A single instance of this class.
 	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = NULL;

	/**
	 * Theme options from database.
 	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private $theme_options;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance()
	{	
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	
	public function __construct()
	{
		// Get theme option name.
		$option_name = anva_get_option_name();

		// Set option name key.
		$this->option_id = $option_name;

		// Get options from database.
		$this->theme_options = get_option( $option_name );

		add_action( 'after_setup_theme', array( $this, 'add_options' ) );
		add_action( 'admin_init', array( $this, 'import_settings' ) );
		add_action( 'appearance_page_' . $option_name, array( $this, 'add_save_notice' ) );
	}
	
	/**
	 * Add import/export options to advanced tab.
	 *
	 * @since  1.0.0
	 */
	public function add_options()
	{
		$import_export_options = array(
			'import' => array(
				'name' => __( 'Import', 'anva' ),
				'id' => 'import_settings',
				'std' => '',
				'type' => 'import',
				'rows' => 10,
			),
			'export' => array(
				'name' => __( 'Export', 'anva' ),
				'id' => 'export_settings',
				'std' => '',
				'desc' => __( 'Select all and copy to export your settings.', 'anva'  ),
				'type' => 'export'
			),
		);

		anva_add_option_section( 'advanced', 'import_export', __( 'Import Options', 'anva' ), null, $import_export_options, false );
	}

	/**
	 * Define the import option.
	 *
	 * @since  1.0.0
	 * @return string|html $output
	 */
    public function import_option()
    {	
		$output = sprintf( '<textarea name="%s[import_settings]" class="anva-input anva-textarea" rows="10"></textarea>', $this->option_id );
		
		$description = esc_html__( 'Paste your exported settings here. When you click "Import" your settings will be imported to this site. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'anva' );
		
		// Close "</div>" control.
		$output .= '</div><!-- .controls (end) -->';

		$output .= sprintf( '<div class="explain">%s<p><input type="submit" class="button button-secondary import-button" value="%s" /></p></div><!-- .explain (end) -->', $description, esc_attr__( 'Import', 'anva' ) );
				
		return $output;
		 
    }

	/**
	 * Define the export option.
	 *
	 * @since  1.0.0
	 * @param  array       $options
	 * @return string|html $output
	 */
    public function export_option()
    {
		if ( ! $this->theme_options && is_array( ! $this->theme_options ) ) {
			$output = sprintf( '<div class="anva-disclaimer">%s</div>', __( 'ERROR! You don\'t have any options to export. Trying saving your options first.', 'anva' ) );
			return $output;
		}
		
		// Add the theme name
		$this->theme_options['theme_name'] = $this->option_id;
		
		// Generate the export data.
		$val = base64_encode( maybe_serialize( (array)$this->theme_options ) );
		
		$output = '<textarea disabled="disabled" class="anva-input" rows="10" onclick="this.focus();this.select()">' . esc_textarea( $val ) . '</textarea>';

		return $output;
		
		 
    }

	/**
	 * Import the settings
	 * happens on options validation hook, but re-directs before OF's validation can run
	 *
	 * @since  1.0.0
	 * @param  array $input
	 * @return array
	 *
	 */
    public function import_settings()
    {
		if ( isset( $_POST['import'] ) ) {
			
			// Decode the pasted data
			$data = (array) maybe_unserialize( base64_decode( $_POST[ $this->option_id ]['import_settings'] ) );
			
			if ( is_array( $data ) && isset( $data['theme_name'] ) && $this->option_id == $data['theme_name'] ) {
	
				unset( $data['theme_name'] );

				// @TODO sanitize settings before update option
				
				// Update the settings in the database
				update_option( $this->option_id, $data );
				update_option( 'anva_import_happened', 'success' );
			
			} else {
				update_option( 'anva_import_happened', 'fail' );
			}

			/**
			 * Redirect back to the settings page that was submitted
			 */
			$goback = add_query_arg( 'settings-imported', 'true',  wp_get_referer() );
			wp_redirect( $goback );
			exit;
		
		}
    }

	/**
	 * Add notices for import success/failure.
	 *
	 * @since  1.0.0
	 */
	public function add_save_notice()
	{
		$success = get_option( 'anva_import_happened', false );
		
		if ( $success ) {
			
			if ( $success === 'success' ) {
				add_settings_error( 'anva-options-page-errors', 'import_options', __( 'Options imported successfully.', 'anva' ), 'updated fade' );	
			} else {
				add_settings_error( 'anva-options-page-errors', 'import_options_fail', __( 'Options could not be imported.', 'anva' ), 'error fade' );
			}

		}
		
		delete_option( 'anva_import_happened' );
	}
}

endif;