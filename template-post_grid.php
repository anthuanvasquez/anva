<?php
/*
 Template Name: Post Grid
 */

get_header();


$grid_columns = tm_get_post_meta('_grid_columns');
$columns = '';
$size = 'grid_'. $grid_columns;

switch ( $grid_columns ) {
	case 2:
		$columns = 6;
		break;
	case 3:
		$columns = 4;
		break;
	case 4:
		$columns = 3;
		break;
}
?>

<div class="row grid-columns">
	<div class="col-sm-12">
		<div class="main" role="main">
			<div class="row grid-columns">
			<?php

				$count = 1;
				$the_query = tm_get_post_query();
				
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts()) : $the_query->the_post();						
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-' . $columns ); ?>>
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>
							<?php
								$single_meta = tm_get_option( 'single_meta' );
								if ( 1 == $single_meta ) :
									tm_posted_on();
								endif;
							?>
						</header>

						<div class="entry-container group">
							<?php echo tm_post_grid_thumbnails( $size ); ?>
							<div class="entry-summary">
								<?php tm_excerpt_limit(); ?>
								<a class="button" href="<?php the_permalink(); ?>">
									<?php echo tm_get_local( 'read_more' ); ?>
								</a>
							</div>
						</div>
					</article>
					<?php

					if ( $count % $grid_columns == 0 ) {
						echo '<div class="clearfix"></div>';
					}
					$count++;
					endwhile;
					
					tm_num_pagination($the_query->max_num_pages);
					wp_reset_query();

				endif;
			?>	
			</div><!-- .grid-columns -->

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>