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

function theme_fields() {
	$domain = anva_textdomain();
	$post_meta = array(
		'args' => array(
			'id' 				=> 'anva_post_options',
			'title' 		=> __( 'Post Options', $domain ),
			'page'			=> array( 'post' ),
			'context' 	=> 'normal',
			'priority'	=> 'default',
			'desc'			=> __( 'Post Options Description.', $domain )
		),
		'options' => array(
			'hide_title' => array(
				'id'			=> 'hide_title',
				'name' 		=> __( 'Page Title', $domain ),
				'desc'		=> __( 'Show or hide page\'s titles.', $domain ),
				'type' 		=> 'select',
				'std'			=> 'show',
				'options'	=> array(
					'show' 	=> __( 'Show page\'s title', $domain ),
					'hide'	=> __( 'Hide page\'s title', $domain )
				)
			)
		)
	);

	anva_add_new_meta_box( $post_meta['args']['id'], $post_meta['args'], $post_meta['options'] );
}
add_action( 'admin_init', 'theme_fields' );
