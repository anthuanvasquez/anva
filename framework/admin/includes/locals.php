<?php
/**
 * Return user read text strings. This function allows
 * to have all of the framework's common localized text
 * strings in once place. Also, the following filters can
 * be used to add/remove strings.
 */

 function anva_get_admin_locals( $type ) {
	
	$locals = array();
	
	switch ( $type ) {

		// General JS strings
		case 'js':
			$locals = array (
				'clear'					=> __( 'By doing this, you will clear your database of this option set. In other words, you will lose any previously saved settings. Are you sure you want to continue?', anva_textdomain() ),
				'clear_title'		=> __( 'Clear Options', anva_textdomain() ),
				'no_name'				=> __( 'Oops! You forgot to enter a name.', anva_textdomain() ),
				'invalid_name'	=> __( 'Oops! The name you entered is either taken or too close to another name you\'ve already used.', anva_textdomain() ),
				'publish'				=> __( 'Publish', anva_textdomain() ),
				'primary_query'	=> __( 'Oops! You can only have one primary query element per layout. A paginated post list or paginated post grid would be examples of primary query elements.', anva_textdomain() ),
				'reset'					=> __( 'By doing this, all of your default theme settings will be saved, and you will lose any previously saved settings. Are you sure you want to continue?', anva_textdomain() ),
				'reset_title'		=> __( 'Restore Defaults', anva_textdomain() )
			);
			break;

		// Customizer JS strings
		case 'customizer_js':
			$locals = array (
				'disclaimer'			=> __( 'Note: The customizer provides a simulated preview, and results may vary slightly when published and viewed on your live website.', anva_textdomain() )
			);
			break;
	}
	return apply_filters( 'anva_locals_' . $type, $locals );
}