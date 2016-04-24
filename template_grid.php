<?php
/**
 * Template Name: Posts Grid
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */

get_header();

$class        = '';
$column       = 2; // Default Column
$current_grid = anva_get_post_meta( '_anva_grid_column' );
$grid_columns = anva_get_grid_columns();
$thumbnail    = 'anva_post_grid';

if ( isset( $grid_columns[ $current_grid ]['class'] ) ) {
	$class = $grid_columns[ $current_grid ]['class'];
}

if ( isset( $grid_columns[ $current_grid ]['column'] ) ) {
	$column = $grid_columns[ $current_grid ]['column'];
}

// Counter
$count = 1;

// Grid rows
$open_row  = '<div class="post-grid-row row">';
$close_row = '</div><!-- .post-grid-row (end) -->';

// Get posts
$query = anva_get_query_posts();
$limit = count( $query->posts() );
?>

<div class="container clearfix">

	<div id="posts" class="<?php anva_post_class( 'grid' ); ?> grid-<?php echo esc_attr( $column ); ?> clearfix" data-layout="fitRows">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
				<?php anva_the_post_grid_thumbnail( $thumbnail ); ?>
				<div class="entry-title">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<?php anva_the_excerpt(); ?>
			</article>

		<?php endwhile; ?>

	</div><!-- #posts (end) -->

	<?php anva_num_pagination( $query->max_num_pages ); ?>
	<?php wp_reset_postdata(); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>