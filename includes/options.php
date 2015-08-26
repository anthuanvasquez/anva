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

function theme_elements() {
	
	$image_path = anva_get_core_url() . '/assets/images/builder/';
	
	$elements['box'] = array(
		'id' => 'box',
		'name' => 'This Box',
		'icon' => $image_path . 'header.png',
		'attr' => array(
			'subtitle' => array(
				'title' => 'Sub Title (Optional)',
				'type' => 'text',
				'desc' => 'Enter short description for this header',
			)
		),
		'desc' => 'This is a Box'
	);
	anva_add_builder_element( $elements['box']['id'], $elements['box']['name'], $elements['box']['icon'], $elements['box']['attr'], $elements['box']['desc'], true );
	
	// anva_remove_builder_element( 'header' );

	//var_dump(anva_get_elements());
	//var_dump(anva_is_block_element( 'box', 'subtitle' ));
	// $args_block = array(
	// 	'title' => 'Font Color (Optional)',
	// 	'type' => 'colorpicker',
	// 	"std" => "#444444",
	// 	'desc' => 'Select font color for this content',
	// );
	// 'box', 'fontcolor', $args_block 
	
}
add_action( 'after_setup_theme', 'theme_elements' );

$args = array(
	'element_id' => 'header',
	'block_id' => 'customcolor',
	'key' => 'bgcolor',
	'attr' => array(
		'title' => 'Custom Color (Optional)',
		'type' => 'colorpicker',
		"std" => "#ff0000",
		'desc' => 'Select font color for this content'
	)
);

anva_add_block_element( $args );


