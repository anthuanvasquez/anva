<?php

/**
 * Include the TGM_Plugin_Activation class.
 */

if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require_once ( ANVA_FRAMEWORK_DIR . 'vendor/class-tgm-plugin-activation.php' );
}

/**
 * Register the required plugins for this theme.
 */
function anva_register_required_plugins() {
	
	// Array of plugin arrays. Required keys are name and slug.
	// If the source is NOT from the .org repo, then source is also required.
	$plugins = apply_filters( 'anva_required_plugins', array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name'               => 'TGM Example Plugin', // The plugin name.
			'slug'               => 'tgm-example-plugin', // The plugin slug (typically the folder name).
			'source'             => ANVA_FRAMEWORK_ADMIN . 'plugins/packages/tgm-example-plugin.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

	) );

	// Array of configuration settings. Amend each line as needed.
	$config = array(
		'id'           							=> 'anva',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' 							=> '',                      // Default absolute path to bundled plugins.
		'menu'         							=> 'anva_plugins', 			// Menu slug.
		'has_notices'  							=> true,                    // Show admin notices or not.
		'dismissable'  							=> true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  							=> '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' 							=> false,                   // Automatically activate plugins after installation or not.
		'message'      							=> '',                      // Message to output right before the plugins table.
		'strings'      							=> array(
			'page_title'                    	=> __( 'Theme Required Plugins', 'anva' ),
			'menu_title'                    	=> __( 'Theme Plugins', 'anva' ),
			'installing'                    	=> __( 'Installing Plugin: %s', 'anva' ), // %s = plugin name.
			'oops'                          	=> __( 'Something went wrong with the plugin API.', 'anva' ),
			'notice_can_install_required'   	=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'anva' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  	=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'anva' ), // %1$s = plugin name(s).
			'notice_cannot_install'           	=> _n_noop('Sorry, but you do not have the correct permissions to install the %1$s plugin.','Sorry, but you do not have the correct permissions to install the %1$s plugins.','anva'), // %1$s = plugin name(s).
			'notice_ask_to_update'            	=> _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.','The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','anva'), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      	=> _n_noop('There is an update available for: %1$s.','There are updates available for the following plugins: %1$s.','anva'), // %1$s = plugin name(s).
			'notice_cannot_update'            	=> _n_noop('Sorry, but you do not have the correct permissions to update the %1$s plugin.','Sorry, but you do not have the correct permissions to update the %1$s plugins.','anva'), // %1$s = plugin name(s).
			'notice_can_activate_required'    	=> _n_noop('The following required plugin is currently inactive: %1$s.','The following required plugins are currently inactive: %1$s.','anva'), // %1$s = plugin name(s).
			'notice_can_activate_recommended' 	=> _n_noop('The following recommended plugin is currently inactive: %1$s.','The following recommended plugins are currently inactive: %1$s.','anva'), // %1$s = plugin name(s).
			'notice_cannot_activate'          	=> _n_noop('Sorry, but you do not have the correct permissions to activate the %1$s plugin.','Sorry, but you do not have the correct permissions to activate the %1$s plugins.','anva'), // %1$s = plugin name(s).
			'install_link'                    	=> _n_noop('Begin installing plugin','Begin installing plugins','anva'),
			'update_link' 					  	=> _n_noop('Begin updating plugin','Begin updating plugins','anva'),
			'activate_link'                   	=> _n_noop('Begin activating plugin','Begin activating plugins','anva'),
			'return'                          	=> __( 'Return to Required Plugins Installer', 'anva' ),
			'plugin_activated'                	=> __( 'Plugin activated successfully.', 'anva' ),
			'activated_successfully'          	=> __( 'The following plugin was activated successfully:', 'anva' ),
			'plugin_already_active'           	=> __( 'No action taken. Plugin %1$s was already active.', 'anva' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     	=> __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'anva' ),  // %1$s = plugin name(s).
			'complete'                        	=> __( 'All plugins installed and activated successfully. %1$s', 'anva' ), // %s = dashboard link.
			'contact_admin'                   	=> __( 'Please contact the administrator of this site for help.', 'anva' ),
			'nag_type'                        	=> 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'anva_register_required_plugins', 100 );
