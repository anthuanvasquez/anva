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
		<div class="main">
			<?php woocommerce_content(); ?>
		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php
		if ( ! is_single() ) :
			?>
			<div class="sidebar-wrapper col-sm-4">
				<div class="sidebar-inner">
					<div class="widget-area widget-area-shop">
						<?php if ( dynamic_sidebar( 'shop' ) ) : endif; ?>
					</div>
				</div>
			</div><!-- .sidebar-wrapper (end) -->
			<?php
		else :
			?>
			<div class="sidebar-wrapper col-sm-4">
				<div class="sidebar-inner">
					<div class="widget-area widget-area-product">
						<?php if ( dynamic_sidebar( 'product' ) ) : endif; ?>
					</div>
				</div>
			</div><!-- .sidebar-wrapper (end) -->
			<?php
		endif;
	?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>