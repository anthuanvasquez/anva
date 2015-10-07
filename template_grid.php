<?php
/**
 * Template Name: Posts Grid
 *
 * The template used for displaying posts grid.
 * 
 * @version 1.0.0
 */

get_header();

$class 					= '';
$column 				= 2; // Default Column
$hide_title   	= anva_get_field( 'hide_title' );
$current_grid 	= anva_get_field( 'grid_column' );
$grid_columns 	= anva_get_grid_columns();
$thumbnail 			= 'anva_post_grid';

if ( isset( $grid_columns[$current_grid]['class'] ) ) {
	$class = $grid_columns[$current_grid]['class'];
}

if ( isset( $grid_columns[$current_grid]['column'] ) ) {
	$column = $grid_columns[$current_grid]['column'];
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

<div class="row grid-columns">
	
	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">

		<?php if ( 'hide' != $hide_title ) : ?>
		<div class="entry-title">
			<h1><?php the_title(); ?></h1>
		</div><!-- .entry-title (end) -->
		<?php endif; ?>

		<div class="<?php echo esc_attr( anva_post_classes( 'grid' ) ); ?> post-grid-col-<?php echo esc_attr( $column ); ?>">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php if ( 1 == $count ): echo $open_row; endif ?>
					
				<div class="post-grid-item <?php echo esc_attr( $class ); ?>">
					<div class="article-wrapper">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
							<div class="entry-content">
								<?php anva_the_post_grid_thumbnail( $thumbnail ); ?>
								<div class="entry-title">
									<h2 class="h3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								</div>
								<div class="entry-summary">
									<?php anva_excerpt(); ?>
									<a class="button button-small" href="<?php the_permalink(); ?>">
										<?php echo anva_get_local( 'read_more' ); ?>
									</a>
								</div>
							</div>
						</article>
					</div>
				</div><!-- .post-grid-item (end) -->
					
				<?php if ( 0 == $count % $column ): echo $close_row; endif ?>
				<?php if ( $count % $column == 0 && $limit != $count ) : echo $open_row; endif; ?>

				<?php $count++; ?>

			<?php endwhile; ?>

			<?php if ( ( $count - 1 ) != $limit ) : echo $close_row; endif; ?>

			<?php anva_num_pagination( $query->max_num_pages ); ?>
			<?php	wp_reset_postdata(); ?>

		</div><!-- .primary-post-grid (end) -->
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>