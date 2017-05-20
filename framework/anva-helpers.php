<?php

/**
 * Init framework's API.
 *
 * @since  1.0.0
 * @return void
 */
function anva_api_init() {

	// Setup Framework Core Options.
	Anva_Options::instance();

	// Setup Framework Stylesheets.
	Anva_Styles::instance();

	// Setup Framework Scripts.
	Anva_Scripts::instance();

	// Setup Framework Sidebars Locations.
	Anva_Sidebars::instance();

	// Setup Framework Core Sliders.
	Anva_Sliders::instance();

	// Setup Framework Builder Components.
	Anva_Builder_Components::instance();

	// Setup import export options.
	//Anva_Options_Import_Export::instance();

	// Setup customizer API.
	$GLOBALS['_anva_customizer_sections'] = array();

}

/**
 * This is for print theme option value.
 *
 * @since 1.0.0
 * @param string               $name
 * @param string|array|boolean $default
 */
function anva_the_option( $name, $default = false ) {
	echo anva_get_option( $name, $default );
}

/**
 * Get theme option value.
 *
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 * Based on "Options Framework" by Devin Price.
 *
 * @link http://wptheming.com
 *
 * @since  1.0.0
 * @param  string               $name
 * @param  string|array|boolean $default
 * @return string|array|boolean $options
 */
function anva_get_option( $name, $default = false ) {

	// Get option name.
	$option_name = anva_get_option_name();

	// Get settings from database.
	$options = get_option( $option_name );

	// Return specific option.
	if ( isset( $options[ $name ] ) ) {
		return $options[ $name ];
	}

	// Return default.
	return $default;
}

/**
 * Get raw options.
 *
 * @since  1.0.0
 * @return array
 */
function anva_get_core_options() {
	$api = Anva_Options::instance();
	return $api->get_raw_options();
}

/**
 * Get formatted options. Note that options will not be
 * formatted until after WP's after_setup_theme hook.
 *
 * @since 1.0.0
 */
function anva_get_formatted_options() {
	$api = Anva_Options::instance();
	return $api->get_formatted_options();
}

function anva_the_option_name() {
	echo anva_get_option_name();
}

/**
 * Gets option name.
 *
 * @since 1.0.0
 */
function anva_get_option_name() {
	$name = get_option( 'stylesheet' );
	$name = preg_replace( '/\W/', '_', strtolower( $name ) );
	return apply_filters( 'anva_option_name', $name );

}

/**
 * Allows for manipulating or setting options
 * via 'anva_options' filter.
 *
 * @since  1.0.0
 * @return array $options
 */
function anva_get_options() {

	// Get options from api class Anva_Options_API.
	$options = anva_get_formatted_options();

	// Allow setting/manipulating options via filters.
	$options = apply_filters( 'anva_options', $options );

	return $options;
}

/**
 * Add theme option tab.
 *
 * @since 1.0.0
 */
function anva_add_option_tab( $tab_id, $tab_name, $top = false, $icon = 's' ) {
	$api = Anva_Options::instance();
	$api->add_tab( $tab_id, $tab_name, $top, $icon );
}

/**
 * Remove theme option tab
 *
 * @since 1.0.0
 */
function anva_remove_option_tab( $tab_id ) {
	$api = Anva_Options::instance();
	$api->remove_tab( $tab_id );
}

/**
 * Add theme option section
 *
 * @since 1.0.0
 */
function anva_add_option_section( $tab_id, $section_id, $section_name, $section_desc = null, $options = null, $top = false ) {
	$api = Anva_Options::instance();
	$api->add_section( $tab_id, $section_id, $section_name, $section_desc, $options, $top );
}

/**
 * Remove theme option section
 *
 * @since 1.0.0
 */
function anva_remove_option_section( $tab_id, $section_id ) {
	$api = Anva_Options::instance();
	$api->remove_section( $tab_id, $section_id );
}

/**
 * Add theme option
 *
 * @since 1.0.0
 */
function anva_add_option( $tab_id, $section_id, $option_id, $option ) {
	$api = Anva_Options::instance();
	$api->add_option( $tab_id, $section_id, $option_id, $option );
}

/**
 * Remove theme option
 *
 * @since 1.0.0
 */
function anva_remove_option( $tab_id, $section_id, $option_id ) {
	$api = Anva_Options::instance();
	$api->remove_option( $tab_id, $section_id, $option_id );
}

/**
 * Edit theme option
 *
 * @since 1.0.0
 */
function anva_edit_option( $tab_id, $section_id, $option_id, $att, $value ) {
	$api = Anva_Options::instance();
	$api->edit_option( $tab_id, $section_id, $option_id, $att, $value );
}

/**
 * Get all core elements of Page Builder
 *
 * @since 1.0.0
 */
function anva_get_core_elements() {
	$api = Anva_Builder_Components::instance();
	return $api->get_core_elements();
}

/**
 * Get layout builder's elements after new elements
 * have been given a chance to be added at the theme-level.
 *
 * @since 1.0.0
 */
function anva_get_elements() {
	$api = Anva_Builder_Components::instance();
	return $api->get_elements();
}

/**
 * Check that the element ID exists.
 *
 * @since  1.0.0
 * @param  string $element_id
 * @return string $element_id
 */
function anva_element_exists( $element_id ) {
	$api = Anva_Builder_Components::instance();
	return $api->is_element( $element_id );
}

/**
 * Add custom element to page content builder.
 *
 * @since 1.0.0
 */
function anva_add_builder_Components( $element_id, $name, $icon, $attr, $desc, $content ) {
	$api = Anva_Builder_Components::instance();
	$api->add_element( $element_id, $name, $icon, $attr, $desc, $content );
}

/**
 * Remove element from page content builder.
 *
 * @since 1.0.0
 */
function anva_remove_builder_Components( $element_id ) {
	$api = Anva_Builder_Components::instance();
	$api->remove_element( $element_id );
}

/**
 * Add sidebar location.
 *
 * @since 1.0.0
 */
function anva_add_sidebar_location( $id, $name, $desc = '' ) {
	$api = Anva_Sidebars::instance();
	$api->add_location( $id, $name, $desc );
}

/**
 * Remove sidebar location.
 *
 * @since 1.0.0
 */
function anva_remove_sidebar_location( $id ) {
	$api = Anva_Sidebars::instance();
	$api->remove_location( $id );
}

/**
 * Get sidebar locations.
 *
 * @since 1.0.0
 */
function anva_get_sidebar_locations() {
	$api = Anva_Sidebars::instance();
	return $api->get_locations();
}

/**
 * Get sidebar location name or slug name.
 *
 * @since 1.0.0
 */
function anva_get_sidebar_location_name( $location, $slug = false ) {
	$api = Anva_Sidebars::instance();
	$sidebar = $api->get_locations( $location );

	if ( isset( $sidebar['args']['name'] ) ) {
		if ( $slug ) {
			return sanitize_title( $sidebar['args']['name'] );
		}
		return $sidebar['args']['name'];
	}

	return __( 'Widget Area', 'anva' );
}

/**
 * Display sidebar location.
 *
 * @since 1.0.0
 */
function anva_display_sidebar( $location ) {
	$api = Anva_Sidebars::instance();
	$api->display( $location );
}

/**
 * Add sidebar arguments when register locations.
 *
 * @since 1.0.0
 */
function anva_add_sidebar_args( $id, $name, $desc = '', $classes = '' ) {
	if ( ! empty( $classes ) ) {
		$classes = ' ' . $classes;
	}

	$args = array(
		'id'            => $id,
		'name'          => $name,
		'description'   => $desc,
		'before_widget' => '<div id="%1$s" class="widget %2$s'. esc_attr( $classes ) .'">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	);

	return apply_filters( 'anva_add_sidebar_args', $args );
}

/**
 * Add stylesheet.
 *
 * @since 1.0.0
 */
function anva_add_stylesheet( $handle, $src, $level = 4, $ver = null, $media = 'all' ) {
	$api = Anva_Styles::instance();
	$api->add( $handle, $src, $level, $ver, $media );
}

/**
 * Remove stylesheet.
 *
 * @since 1.0.0
 */
function anva_remove_stylesheet( $handle ) {
	$api = Anva_Styles::instance();
	$api->remove( $handle );
}

/**
 * Get framework stylesheets.
 *
 * @since 1.0.0
 */
function anva_get_stylesheets() {
	$api    = Anva_Styles::instance();
	$core   = $api->get_framework_stylesheets();
	$custom = $api->get_custom_stylesheets();
	return array_merge( $core, $custom );
}

/**
 * Print out styles.
 *
 * @since 1.0.0
 */
function anva_print_styles( $level ) {
	$api = Anva_Styles::instance();
	$api->print_styles( $level );
}

/**
 * Add script.
 *
 * @since 1.0.0
 */
function anva_add_script( $handle, $src, $level = 4, $ver = null, $footer = true ) {
	$api = Anva_Scripts::instance();
	$api->add( $handle, $src, $level, $ver, $footer );
}

/**
 * Remove script.
 *
 * @since 1.0.0
 */
function anva_remove_script( $handle ) {
	$api = Anva_Scripts::instance();
	$api->remove( $handle );
}

/**
 * Get framework scripts.
 *
 * @since 1.0.0
 */
function anva_get_scripts() {
	$api    = Anva_Scripts::instance();
	$core   = $api->get_framework_scripts();
	$custom = $api->get_custom_scripts();
	return array_merge( $core, $custom );
}

/**
 * Print out scripts.
 *
 * @since 1.0.0
 */
function anva_print_scripts( $level ) {
	$api = Anva_Scripts::instance();
	$api->print_scripts( $level );
}

/**
 * Add slider.
 *
 * @since 1.0.0
 */
function anva_add_slider( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options ) {
	$api = Anva_Sliders::instance();
	$api->add( $slider_id, $slider_name, $slide_types, $media_positions, $elements, $options );
}

/**
 * Remove slider.
 *
 * @since 1.0.0
 */
function anva_remove_slider( $slider_id ) {
	$api = Anva_Sliders::instance();
	$api->remove( $slider_id );
}

/**
 * Get framework sliders.
 *
 * @since 1.0.0
 */
function anva_get_sliders( $slider_id = '' ) {
	$api = Anva_Sliders::instance();
	return $api->get_sliders( $slider_id );
}

/**
 * Check that the slider ID exists.
 *
 * @since  1.0.0
 * @param  string $slider_id
 * @return string $sldier_id
 */
function anva_slider_exists( $slider_id ) {
	$api = Anva_Sliders::instance();
	return $api->is_slider( $slider_id );
}
