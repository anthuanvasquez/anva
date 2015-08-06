<?php

/**
 * Add page and post meta boxes
 *
 * @since 1.0.0
 * @return class Anva_Meta_box
 */
function anva_add_meta_boxes_default() {

	// Page meta box
	$page_meta = anva_setup_page_meta();
	$page_meta_box = new Anva_Meta_Box( $page_meta['args']['id'], $page_meta['args'], $page_meta['options'] );

}

/**
 * Page meta setup array
 *
 * @since 1.0.0
 * @return array $setup
 */
function anva_setup_page_meta() {
	
	$domain = anva_textdomain();
	$columns = array();
	$layouts = array();

	// Fill columns array
	$columns[''] = esc_html__( 'Default Grid Columns', $domain );
	foreach ( anva_grid_columns() as $key => $value ) {
		$columns[$key] = esc_html( $value['name'] );
	}
	// Remove 1 Column Grid
	unset( $columns[1] );

	// Fill layouts array
	$layouts[''] = esc_html__( 'Default Sidebar Layout', $domain );
	foreach ( anva_sidebar_layouts() as $key => $value ) {
		$layouts[$key] = esc_html( $value['name'] );
	}

	$setup = array(
		'args' => array(
			'id' 				=> 'anva_page_options',
			'title' 		=> __( 'Page Options', $domain ),
			'page'			=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'default',
			'desc'			=> __( 'Page Options Desc', $domain )
		),
		'options' => array(
			'layout' => array(
				'id' 			=> 'layout',
				'name'		=> __( 'Layout', $domain ),
				'type' 		=> 'heading'
			),
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
			),
			'sidebar_layout' => array(
				'id'			=> 'sidebar_layout',
				'name' 		=> __( 'Sidebar Layout', $domain ),
				'desc'		=> __( 'Select a sidebar layout.', $domain ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> $layouts
			),
			'grid_column' => array(
				'id'			=> 'grid_column',
				'name' 		=> __( 'Post Grid', $domain ),
				'desc'		=> __( 'Select a grid column for posts list.', $domain ),
				'type' 		=> 'select',
				'std'			=> '',
				'options'	=> $columns
			),

			'others' => array(
				'id' 			=> 'others',
				'name'		=> __( 'Others', $domain ),
				'type' 		=> 'heading'
			),
			'textarea' => array(
				'name' => 'Textarea',
				'desc'  => 'A description for the field.',
				'id'    => 'textarea',
				'type'  => 'textarea',
				'std'			=> 'Hello'
			),
			'checkbox' => array(
				'name' => 'Checkbox Input',
				'desc'  => 'A description for the field.',
				'id'    => 'checkbox',
				'type'  => 'checkbox',
				'std'		=> '1',
			),
			'radio' => array(
				'name' => 'Radio Group',
				'desc'  => 'A description for the field.',
				'id'    => 'radio',
				'std'		=> 'value2',
				'type'  => 'radio',
				'options' => array(
					'value1' => 'One',
					'value2' => 'Two',
					'value3' => 'Three'
				)
			),
			'multicheck' => array(
				'name' => 'Checkbox Group',
				'desc'  => 'A description for the field.',
				'id'    => 'multicheck',
				'type'  => 'multicheck',
				'std'		=> array( 'one' => '1' ),
				'options' => array(
					'one' => __( 'French Toast', 'theme-textdomain' ),
					'two' => __( 'Pancake', 'theme-textdomain' ),
					'three' => __( 'Omelette', 'theme-textdomain' ),
					'four' => __( 'Crepe', 'theme-textdomain' ),
					'five' => __( 'Waffle', 'theme-textdomain' )
				)
			),
			'date' => array(
				'name' => 'Date',
				'desc'  => 'A description for the field.',
				'id'    => 'date',
				'type'  => 'date',
				'std'		=> '07/11/2018'
			),
			'repeatable' => array(
				'name' => 'Repeatable',
				'desc'  => 'A description for the field.',
				'id'    => 'repeatable',
				'type'  => 'repeatable'
			)
		)
	);

	return apply_filters( 'anva_page_meta', $setup );
}