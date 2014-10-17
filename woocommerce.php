<?php get_header(); ?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main" role="main">
		
		<?php woocommerce_content(); ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php
		if ( ! is_single() ) {
			get_sidebar( 'shop' ); 
		} else {
			get_sidebar( 'product' ); 
		}
	?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
