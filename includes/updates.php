<?php

/**
 * Setup auto updates.
 */
function anva_envato_updates() {

	global $_envato_updates;

	// Include update classes
	if ( ! class_exists( 'Envato_Protected_API' ) ) {
		include_once( anva_get_core_directory() . '/admin/vendor/class-envato-protected-api.php' );
	}

	if ( ! class_exists( 'Anva_Envato_Updates' ) ) {
		include_once( anva_get_core_directory() . '/admin/includes/class-anva-envato-updates.php' );
	}

	// Admin page
	if ( current_user_can( 'edit_theme_options' ) ) {

		// Options to display on page
		$update_options = array(
			'envato_info' => array(
				'name'			=> __( 'Configuration', 'anva' ),
				'id' 				=> 'envato_info',
				'type' 			=> 'info',
				'desc'			=> __('<strong>Warning:</strong> Although there is a backup option below, we recommend that you still always backup your theme files before running any automatic updates. Additionally, it\'s a good idea to never update any plugin or theme on a live website without first testing its compatibility with your specific WordPress site.', 'anva' )
			),
			'username' 		=> array(
				'name'			=> __( 'Envato Username', 'anva' ),
				'id'				=> 'username',
				'desc'			=> __( 'Enter the username that you have purchased the theme with through ThemeForest.', 'anva' ),
				'type' 			=> 'text'
			),
			'api' 				=> array(
				'name'			=> __( 'Envato API Key', 'anva' ),
				'id'				=> 'api',
				'desc'			=> sprintf( __( 'Enter an %s key associated with your Envato username.', 'anva' ), '<a href="http://extras.envato.com/api/" target="_blank">Envato API</a>' ),
				'type' 			=> 'text'
			),
			'backup' 			=> array(
				'name'			=> __( 'Backups', 'anva' ),
				'id'				=> 'backup',
				'desc'			=> __( 'Select if you\'d like a backup made of the previous theme version on your server before updating to the new version.', 'anva' ),
				'std'				=> 'yes',
				'type' 			=> 'radio',
				'options'		=> array(
					'yes' 		=> __( 'Yes, make theme backups when updating.', 'anva' ),
					'no' 			=> __( 'No, do not make theme backups.', 'anva' )
				)
			),
		);

		$update_options = apply_filters( 'anva_envato_options', $update_options );

		anva_add_option_section( 'advanced', 'updates', __( 'Envato Updates', 'anva' ), null, $update_options, false );

	}

	// Setup arguments for Theme_Blvd_Envato_Updates class based on user-configured options.
	$settings = array(
		'username' => anva_get_option( 'username' ),
		'api' 		 => anva_get_option( 'api' ),
		'backup'	 => anva_get_option( 'backup' ),
	);

	$username = '';
	if ( isset( $settings['username'] ) ) {
		$username = $settings['username'];
	}

	$api_key = '';
	if ( isset( $settings['api'] ) ) {
		$api_key = $settings['api'];
	}

	$backup = '';
	if ( isset( $settings['backup'] ) ) {
		$backup = $settings['backup'];
	}

	$args = array(
		'envato_username'	=> $username,
		'envato_api_key'	=> $api_key,
		'backup'					=> $backup
	);

	$args = apply_filters( 'anva_envato_update_args', $args );

	// Run Envato Updates
	$_envato_updates = new Anva_Envato_Updates( $args );

}
add_action( 'after_setup_theme', 'anva_envato_updates' );