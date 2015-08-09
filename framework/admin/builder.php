<?php
/**
 * Anva Page Builder
 *
 * @package   Anva
 * @author    Anthuan Vasquez <eigthy@gmail.com>
 * @copyright 2015 WP Theming
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'anva_builder_init' ) ) :
/*
 * Don't load if optionsframework_init is already defined
 */
function anva_builder_init() {

	require_once( ANVA_FRAMEWORK . '/admin/builder/class-builder-meta-box.php' );
	require_once( ANVA_FRAMEWORK . '/admin/builder/fields.php' );
	require_once( ANVA_FRAMEWORK . '/admin/builder/options.php' );
	require_once( ANVA_FRAMEWORK . '/admin/builder/elements.php' );
	require_once( ANVA_FRAMEWORK . '/admin/builder/helpers.php' );

}

add_action( 'init', 'anva_builder_init', 20 );

endif;