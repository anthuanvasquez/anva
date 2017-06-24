<?php
/**
 * Template Name: Content Builder
 *
 * The template file used for displaying the content builder.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @link       https://anthuanvasquez.net
 *
 * @package    AnvaFramework
 * @subpackage Anva
 * @version    1.0.0
 * @since      1.0.0
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * Before post content not hooked by default.
 */
do_action( 'anva_post_content_before' );
?>

<div class="custom-content-layout clearfix">
	<?php
		/**
		 * Hooked @see anva_elements
		 */
		do_action( 'anva_content_builder' );
	?>
</div><!-- .custom-content-layout (end) -->

<?php
/**
 * After post content not hooked by default.
 */
do_action( 'anva_post_content_after' );

get_footer();
