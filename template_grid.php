<?php
/**
 * Template Name: Posts Grid
 * The template used for displaying posts grid
 */

get_header();

$class 					= '';
$column 				= '';
$hide_title   	= anva_get_post_meta( '_hide_title' );
$grid_columns 	= anva_grid_columns();
$current_grid 	= anva_get_post_meta( '_grid_column' );
$size 					= 'blog_md';

if ( isset( $grid_columns[$current_grid]['class'] ) ) {
	$class = $grid_columns[$current_grid]['class'];
}

if ( isset( $grid_columns[$current_grid]['column'] ) ) {
	$column = $grid_columns[$current_grid]['column'];
}

// Counter
$count = 0;

// Get posts
$the_query = anva_get_query_posts();

?>

<div class="row grid-columns">
	<div class="content-area col-sm-12">

		<?php if ( 'hide' != $hide_title ) : ?>
			<div class="entry-title">
				<h1><?php the_title(); ?></h1>
			</div><!-- .entry-header (end) -->
		<?php endif; ?>

		<div class="<?php echo esc_attr( anva_post_classes( 'grid' ) ); ?> post-grid-col-<?php echo esc_attr( $column ); ?>">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<?php $count++; ?>

				<?php if ( 0 == ( $count - 1 ) % $column ) : ?>
				<div class="post-grid-row row">
				<?php endif ?>
					
				<div class="post-grid-item <?php echo esc_attr( $class ); ?>">
					<div class="article-wrapper">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
							<div class="entry-content">
								<?php echo anva_get_post_grid_thumbnails( $size ); ?>
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
				</div><!-- post-grid-item (end) -->
					
				<?php if ( 0 == $count % $column ) : ?>
				</div>
				<?php endif; ?>

			<?php endwhile; ?>
			<?php	wp_reset_query(); ?>
			<?php anva_num_pagination( $the_query->max_num_pages ); ?>

		</div><!-- .primary-post-grid (end) -->
	</div><!-- .content-area (end) -->
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>