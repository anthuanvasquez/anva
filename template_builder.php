<?php
/**
 * Template Name: Builder
 * 
 * The template used for displaying content builder.
 *
 * @version 1.0.0
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