<?php
/**
 * This template file is a core part of the Woocommerce plugin.
 */
get_header();
?>

<div class="row grid-columns">

	<?php anva_woocommerce_sidebar_after(); ?>

	<div class="content-area col-sm-9">
		<div class="main">
			<?php woocommerce_content(); ?>
		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_woocommerce_sidebar_after(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>