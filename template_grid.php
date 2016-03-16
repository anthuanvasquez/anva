<?php
/**
 * Template Name: Posts Grid
 *
 * The template used for displaying posts grid.
 * 
 * @version 1.0.0
 */

get_header();

$class 			= '';
$column 		= 2; // Default Column
$hide_title   	= anva_get_field( 'hide_title' ); // @todo move to global
$current_grid 	= anva_get_field( 'grid_column' );
$grid_columns 	= anva_get_grid_columns();
$thumbnail 		= 'anva_post_grid';

if ( isset( $grid_columns[ $current_grid ]['class'] ) ) {
	$class = $grid_columns[ $current_grid ]['class'];
}

if ( isset( $grid_columns[ $current_grid ]['column'] ) ) {
	$column = $grid_columns[ $current_grid ]['column'];
}

// Counter
$count = 1;

// Grid rows
$open_row = '<div class="post-grid-row row">';
$close_row = '</div><!-- .post-grid-row (end) -->';

// Get posts
$query = anva_get_query_posts();
$limit = count( $query->posts() );
?>

<div class="container clearfix">

	<div id="posts" class="<?php echo esc_attr( anva_post_classes( 'grid' ) ); ?> grid-<?php echo esc_attr( $column ); ?> clearfix" data-layout="fitRows">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
				<?php anva_the_post_grid_thumbnail( $thumbnail ); ?>
				<div class="entry-title">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<?php anva_excerpt(); ?>
			</article>

		<?php endwhile; ?>

	</div><!-- #posts (end) -->

	<?php anva_num_pagination( $query->max_num_pages ); ?>
	<?php wp_reset_postdata(); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>