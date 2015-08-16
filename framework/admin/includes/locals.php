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
			$locals = array(
				'reset_title'		=> __( 'Restore Defaults', anva_textdomain() )
			);
			break;

		// Metabox JS Strings
		case 'metabox_js':
			$locals = array(
				'ajaxurl' 							=> admin_url( 'admin-ajax.php' ),
				'builder_empty_options' => __( 'Select an item to add it to the list.', anva_textdomain() )
			);
			break;

		// Customizer JS strings
		case 'customizer_js':
			$locals = array(
				'disclaimer'			=> __( 'Note: The customizer provides a simulated preview, and results may vary slightly when published and viewed on your live website.', anva_textdomain() )
			);
			break;
	}
	return apply_filters( 'anva_admin_locals_' . $type, $locals );
}