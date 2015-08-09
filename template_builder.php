<?php
/**
 * Template Name: Builder
 * The template used for displaying content builder.
 *
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/admin
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 * @template   Builder
 */

get_header();

// Get current page ID
$page_id = '';
$page = get_page( $post->ID );
if ( isset( $page->ID ) ) {
  $page_id = $page->ID;
}

// Verify is Page Builder is enabled
$enable = anva_get_builder_field();
?>

<?php if ( empty( $enable['enable'] ) ) : ?>

	<div class="row grid-columns">
		<div class="content-area col-sm-12">
			<?php _e( 'The Page Builder is Empty.' ); ?>
		</div><!-- .content-area (end) -->
	</div><!-- .grid-columns (end) -->

<?php else : ?>
		<?php anva_page_builder_elements( $page_id  ); ?>
<?php endif; ?>

<?php get_footer(); ?>