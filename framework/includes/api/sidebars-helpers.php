<?php

function anva_api_init() {
	Theme_Blvd_Sidebars_API::get_instance();
}

/*------------------------------------------------------------*/
/* (4) Widget Areas API Helpers
/*------------------------------------------------------------*/

if ( !function_exists( 'themeblvd_add_sidebar_location' ) ) :
/**
 * Add sidebar location.
 *
 * @since 2.1.0
 *
 * @param string $id ID of location
 * @param string $name Name of location
 * @param string $type Type of location - fixed or collapsible
 * @param string $desc Description or widget area
 */
function themeblvd_add_sidebar_location( $id, $name, $type, $desc = '' ) {
	$api = Theme_Blvd_Sidebars_API::get_instance();
	$api->add_location( $id, $name, $type, $desc );
}
endif;

if ( !function_exists( 'themeblvd_remove_sidebar_location' ) ) :
/**
 * Remove sidebar location.
 *
 * @since 2.1.0
 *
 * @param string $id ID of location
 */
function themeblvd_remove_sidebar_location( $id ) {
	$api = Theme_Blvd_Sidebars_API::get_instance();
	$api->remove_location( $id );
}
endif;

if ( !function_exists( 'themeblvd_get_sidebar_locations' ) ) :
/**
 * Get finalized sidebar locations.
 *
 * @since 2.0.0
 */
function themeblvd_get_sidebar_locations() {
	$api = Theme_Blvd_Sidebars_API::get_instance();
	return $api->get_locations();
}
endif;

if ( !function_exists( 'themeblvd_register_sidebars' ) ) :
/**
 * Register default sidebars (i.e. the "locations").
 *
 * @since 2.0.0
 */
function themeblvd_register_sidebars() {
	themeblvd_deprecated_function( __FUNCTION__, '2.3.0', null, __( 'Default sidebars are now registered within the register() method of the Theme_Blvd_Sidebars_API class.', 'themeblvd' ) );
	$api = Theme_Blvd_Sidebars_API::get_instance();
	$api->register();
}
endif;

if ( !function_exists( 'themeblvd_get_sidebar_location_name' ) ) :
/**
 * Get the user friendly name for a sidebar location.
 *
 * @since 2.0.0
 *
 * @param string $location ID of sidebar location
 * @return string $name name of sidebar location
 */
function themeblvd_get_sidebar_location_name( $location ) {

	$api = Theme_Blvd_Sidebars_API::get_instance();
	$sidebar = $api->get_locations( $location );

	if ( isset( $sidebar['location']['name'] ) ) {
		return $sidebar['location']['name'];
	}

	return __( 'Floating Widget Area', 'themeblvd' );
}
endif;

if ( !function_exists( 'themeblvd_display_sidebar' ) ) :
/**
 * Display sidebar of widgets.
 *
 * Whether we're in a traditional fixed sidebar or a
 * collapsible widget area like ad space, for example,
 * this function will output the widgets for that
 * widget area using WordPress's dynamic_sidebar function.
 *
 * @since 2.0.0
 *
 * @param string $location the location for the sidebar
 */
function themeblvd_display_sidebar( $location ) {
	$api = Theme_Blvd_Sidebars_API::get_instance();
	$api->display( $location );
}
endif;