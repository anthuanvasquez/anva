<?php

/**
 * Add page and post meta boxes
 *
 * @since 1.0.0
 * @return class Anva_Meta_box
 */
function anva_add_builder_meta_box() {

	// Page Builder Meta Box
	$builder_meta = anva_setup_page_builder_options();
	$builder_meta_box = new Anva_Builder_Meta_Box( $builder_meta['args']['id'], $builder_meta['args'], $builder_meta['options'] );

}

/**
 * Page meta setup array
 *
 * @since 1.0.0
 * @return array $setup
 */
function anva_setup_page_builder_options() {
	$setup = array(
		'args' => array(
			'id' 				=> 'anva_page_builder_options',
			'title' 		=> __( 'Page Builder', anva_textdomain() ),
			'page'			=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'default',
		),
		'options'			=> anva_get_builder_options()
	);
	return apply_filters( 'anva_page_buider_meta', $setup );
}