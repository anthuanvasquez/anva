<?php
/**
 * Launch Anva Framework
 * The main file to import the framework and theme functions.
 *
 * WARNING: Do not edit this file. Below is the code needed to load the
 * parent theme and theme framework.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the template directory and make sure it has a trailing slash.
$anva_base_dir = trailingslashit( get_template_directory() );

// Load Anva Framework.
require_once( $anva_base_dir . 'framework/class-anva.php' );

// Launch Anva Framework.
new Anva();

// Load parent theme functions.
require_once( $anva_base_dir . 'includes/theme-functions.php' );
