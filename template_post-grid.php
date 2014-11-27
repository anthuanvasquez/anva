<?php
/**
 * Template Name: Post Grid
 *
 * The template used for displaying posts in grid
 */

get_header();

$grid_columns = tm_get_post_meta('_grid_columns');
$size = 'grid_'. $grid_columns;
$columns = '';

// Config grid
if ( 2 == $grid_columns ) {
	$columns = 6;
} elseif ( 3 == $grid_columns ) {
	$columns = 4;
} elseif ( 4 == $grid_columns ) {
	$columns = 3;
}

// Counter
$count = 0;

// Get posts
$the_query = tm_get_post_query();

?>

<div class="row grid-columns">
	<div class="col-sm-12">
		<div class="main">

			<div class="primary-post-grid post-grid-paginated post-grid">
				<div class="grid-columns">
				<?php if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts()) : $the_query->the_post();

						// Counter
						$count++;

						// Validate column number
						if ( 0 == ( $count - 1 ) % $grid_columns || 1 == $grid_columns )
							echo '<div class="grid_row row">'; ?>
							
						<div class="post-grid_item col-sm-<?php echo $columns; ?>">
							<div class="article-container">
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="entry-container group">
										<?php echo tm_post_grid_thumbnails( $size ); ?>
										<h2 class="entry-title">
											<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h2>
										<div class="entry-summary">
											<?php tm_excerpt_limit(); ?>
											<a class="btn btn-default" href="<?php the_permalink(); ?>">
												<?php echo tm_get_local( 'read_more' ); ?>
											</a>
										</div>
									</div>
								</article>
							</div>
						</div>
							
						<?php if ( 0 == $count % $grid_columns ) echo '</div>'; ?>
					<?php endwhile; ?>
					<?php	wp_reset_query(); ?>
					
				<?php endif; ?>
				
				</div><!-- .grid-columns -->
				<?php tm_num_pagination($the_query->max_num_pages); ?>
			</div><!-- .primary-post-grid -->

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>