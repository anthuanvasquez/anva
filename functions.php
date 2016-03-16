<?php
/**
 * Anva WordPress Framework
 * 
 * The main file to import the frameworks and theme functions.
 * Do not edit this file. Below is the code needed to load the
 * parent theme and theme framework.
 */

// Get the template directory and make sure it has a trailing slash
$anva_base_dir = trailingslashit( get_template_directory() );

// Load Anva Framework
require_once( $anva_base_dir . 'framework/class-anva.php' );

// Launch Anva Framework
new Anva();

// Load theme functions
require_once( $anva_base_dir . 'includes/theme-functions.php' );