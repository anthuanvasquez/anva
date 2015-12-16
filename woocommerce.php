<?php
/**
 * This template file is a core part of the Woocommerce plugin.
 * 
 * @version 1.0.0
 */
get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<?php woocommerce_content(); ?>
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>