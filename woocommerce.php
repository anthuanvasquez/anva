<?php
/**
 * This template file is a core part of the Woocommerce plugin.
 * 
 * @version 1.0.0
 */
get_header();
?>

<div class="row grid-columns">

	<?php anva_woocommerce_sidebar_after(); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<div id="products">
			<?php woocommerce_content(); ?>
		</div><!-- #products (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_woocommerce_sidebar_after(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>