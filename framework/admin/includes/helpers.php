<?php
/**
 * Admin helper functions.
 *
 * @package AnvaFramework
 */

/**
 * Print generated tabs.
 *
 * @since 1.0.0
 * @param array $options Global formatted options.
 */
function anva_the_options_tabs( $options ) {
	echo anva_get_options_tabs( $options );
}

/**
 * Get generated tabs.
 *
 * @since 1.0.0
 * @param array $options Global formatted options.
 */
function anva_get_options_tabs( $options ) {
	$tabs = Anva_Options_UI::instance();
	return $tabs->get_tabs( $options );
}

/**
 * Print generated options fields.
 *
 * @see anva_get_options_fields
 *
 * @since  1.0.0
 * @param  string $option_name
 * @param  array  $settings
 * @param  array  $options
 * @return string $output
 */
function anva_the_options_fields( $option_name, $settings, $options, $prefix = '' ) {
	anva_get_options_fields( $option_name, $settings, $options, $prefix );
}

/**
 * Get generated options fields.
 *
 * @see anva_get_options_fields
 *
 * @since  1.0.0
 * @param  string $option_name
 * @param  array  $settings
 * @param  array  $options
 * @return string $output
 */
function anva_get_options_fields( $option_name, $settings, $options, $prefix = '' ) {
	$fields = Anva_Options_UI::instance();
	return $fields->get_fields( $option_name, $settings, $options, $prefix );
}

/**
 * Get options page menu settings.
 *
 * @since  1.0.0
 * @return array $options_page
 */
function anva_get_options_page_menu() {
	$options_page = new Anva_Page_Options;
	return $options_page->menu_settings();
}

/**
 * Get default options.
 *
 * @since  1.0.0
 * @return array Default Options
 */
function anva_get_options_defaults() {
	$options_page = new Anva_Page_Options;
	return $options_page->get_default_values();
}

/**
 * Register a new meta box.
 *
 * @param string $id      The meabox id.
 * @param array  $args    The metabox page arguments.
 * @param array  $options The metabox fileds options.
 * @since 1.0.0
 */
function anva_add_meta_box( $id, $args, $options ) {
	new Anva_Page_Meta_Box( $id, $args, $options );
}

/**
 * Pull all the layouts into array;
 *
 * @since  1.0.0
 * @return array The layouts list.
 */
function anva_pull_layouts() {
	$layouts = array();
	foreach ( anva_get_sidebar_layouts() as $key => $value ) {
		$layouts[ $key ] = $value['icon'];
	}
	return $layouts;
}

/**
 * Pull all the categories into an array.
 *
 * @since  1.0.0
 * @return array The categories list.
 */
function anva_pull_categories() {
	$categories = array();
	foreach ( get_categories() as $category ) {
		$categories[ $category->cat_ID ] = $category->cat_name;
	}
	return $categories;
}

/**
 * Pull all the pages into an array.
 *
 * @since  1.0.0
 * @return array The pages list.
 */
function anva_pull_pages() {
	$pages = array();
	$pages[''] = __( 'Select a page', 'anva' ) . ':';
	foreach ( get_pages( 'sort_column=post_parent,menu_order' ) as $page ) {
		$pages[ $page->ID ] = $page->post_title;
	}
	return $pages;
}
