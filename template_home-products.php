<?php
/**
 * Template Name: Woocommerce Products
 *
 * The template used for displaying products in front page
 * Woocommerce plugin is required.
 * @link https://wordpress.org/plugins/woocommerce/
 */

get_header();
?>

<div class="row grid-columns">
	<div class="coontent-area col-sm-12">
		<div class="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<header class="entry-header" style="display:none;">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->

		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

	<div class="latest-products col-sm-12">
		<div class="special-products">
			<h2 class="h3"><?php echo anva_get_local( 'product_featured' ) ?></h2>
			<?php echo do_shortcode( '[featured_products per_page="4" columns="4" orderby="rand"]' ); ?>
		</div>

		<div class="new-products">
			<h2 class="h3"><?php echo anva_get_local( 'product_latest' ); ?></h2>
			<?php echo do_shortcode( '[recent_products per_page="4" columns="4" orderby="rand"]' ); ?>
		</div>
	</div><!-- latest-products (end) -->

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>