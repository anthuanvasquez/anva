<?php
/**
 * The template file for portfolio archives.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

get_header();
?>

<div class="container clearfix">

	<ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">
		<li class="activeFilter">
			<a href="#" data-filter="*">
				<?php esc_html_e( 'Show All', 'anva' ); ?>
			</a>
		</li>
		<?php
		// Get portfolio type terms.
		$terms = get_terms( 'portfolio_type' );
		$count = count( $terms );
		if ( $count > 0 ) {
			foreach ( $terms as $term ) {
				printf( '<li><a href="#" data-filter=".%s">%s</a></li>', esc_html( $term->slug ), esc_html( $term->name ) );
			}
		}
		?>
	</ul><!-- #portfolio-filter end -->

	<div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
		<i class="icon-random"></i>
	</div><!-- #portfolio-shuffle -->

	<div class="clear"></div>

	<?php do_action( 'anva_posts_content_before' ); ?>

	<div id="portfolio" class="<?php anva_post_class( 'portfolio' ); ?>">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				$terms = anva_get_terms_links( 'portfolio_type', ' ', false, 'slug' );
				?>
					<article id="portfolio-item-<?php the_ID(); ?>" <?php post_class( "portfolio-item {$terms}" ); ?>>
						<div class="portfolio-image">
							<?php the_post_thumbnail( 'anva_grid_2', array( 'title' => get_the_title() ) ); ?>
							<div class="portfolio-overlay">
								<a href="<?php anva_the_featured_image_src( get_the_ID(), 'full' ); ?>" class="left-icon" data-lightbox="image">
									<i class="icon-line-plus"></i>
								</a>
								<a href="<?php the_permalink(); ?>" class="right-icon">
									<i class="icon-line-ellipsis"></i>
								</a>
							</div>
						</div>
						<div class="portfolio-desc">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( $terms ) : ?>
								<span><?php anva_the_terms_links( 'portfolio_type', ', ' ); ?></span>
							<?php endif; ?>
						</div>
					</article>
				<?php
			endwhile;

			anva_num_pagination();
		endif;
		?>
	</div><!-- #portfolio (end) -->

	<?php do_action( 'anva_posts_content_after' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
