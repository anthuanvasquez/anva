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
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

get_header();
?>

	<?php
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
	?>

<?php get_footer(); ?>
