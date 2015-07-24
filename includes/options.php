<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */

// function optionsframework_option_name() {
// Change this to use your theme slug
// return 'options-framework-theme';
// }

function theme_options() {
	$skin_option = array(
		'name' => "Skin Colors",
		'desc' => "Choose skin color for the theme.",
		'id' => "skin",
		'std' => "blue",
		'type' => "select",
		'options' => array(
			'blue' 		=> 'Blue',
			'green' 	=> 'Green',
			'orange' 	=> 'Orange',
			'red' 		=> 'Red',
			'teal' 		=> 'Teal',
		)
	);

	anva_add_option( 'styles', 'layout', 'skin', $skin_option );
}
add_action( 'after_setup_theme', 'theme_options' );
