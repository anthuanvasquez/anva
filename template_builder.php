<?php
/**
 * Template Name: Builder
 * 
 * The template file used for displaying the content builder.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */

get_header();

// Verify is Page Builder is enabled
$settings = anva_get_page_builder_field();
?>

<?php if ( ! isset( $settings['enable'] ) || ! $settings['enable'] ) : ?>

	<div class="container clearfix">
		<div class="col_full">
			<?php printf( '<div class="alert alert-warning">%s</div>', __( 'Anva Page Builder is empty or is disabled.', 'anva' ) ) ; ?>
		</div><!-- .col_full (end) -->
	</div><!-- .container (end) -->

<?php else : ?>

	<?php anva_elements(); ?>

<?php endif; ?>

<?php get_footer(); ?>