<?php
/**
 * WARNING: This template file is a core part of the
 * Woocommerce plugin.
 * @link https://wordpress.org/plugins/woocommerce/
 */

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="inner">
		
		<?php woocommerce_content(); ?>

		</div><!-- .inner (end) -->
	</div><!-- .content-area (end) -->
	
	<?php
		if ( ! is_single() ) :
			?>
			<div class="sidebar-wrapper col-sm-4">
				<div class="sidebar-inner">
					<div class="widget-area">
							<?php if ( dynamic_sidebar( 'shop-sidebar' ) ) : endif; ?>
						</div>
				</div>
			</div><!-- .sidebar-wrapper (end) -->
			<?php
		else :
			?>
			<div class="sidebar-wrapper col-sm-4">
				<div class="sidebar-inner">
					<div class="widget-area">
							<?php if ( dynamic_sidebar( 'product-sidebar' ) ) : endif; ?>
						</div>
				</div>
			</div><!-- .sidebar-wrapper (end) -->
			<?php
		endif;
	?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>