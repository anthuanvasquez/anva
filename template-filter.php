<?php
/**
 * Template Name: Posts Filter
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

$column       = apply_filters( 'anva_template_filter_columns', 3 ); // Default Column.
$items 		  = apply_filters( 'anva_template_filter_number', 9 );
$thumbnail    = apply_filters( 'anva_template_filter_thumbnail', 'anva_post_grid' );
$current_grid = anva_get_post_meta( '_anva_grid_column' );
$grid_columns = anva_get_grid_columns();

if ( isset( $grid_columns[ $current_grid ]['column'] ) ) {
	$column = $grid_columns[ $current_grid ]['column'];
}

// Get posts.
$query = anva_get_posts();
?>

<div class="container clearfix">

	<div class="col_full">

		<?php
			/**
			 * Before post content not hooked by default.
			 */
			do_action( 'anva_post_content_before' );
		?>

		<div class="category-blog clearfix">
			<ul class="category-filter" data-container="#posts" data-items="<?php echo esc_attr( $items ); ?>" data-grid="<?php echo esc_attr( $column ); ?>">
				<li class="selected">
					<a href="#" data-category="all">
						<?php esc_html_e( 'All', 'anva' ); ?>
					</a>
				</li>
				<?php
				// Get category terms.
				$terms = get_terms( 'category' );
				$count = count( $terms );
				if ( $count > 0 ) {
					foreach ( $terms as $term ) {
						printf( '<li><a href="#" data-category="%s">%s</a></li>', esc_html( $term->slug ), esc_html( $term->name ) );
					}
				}
				?>
			</ul>
		</div>

		<div id="posts" class="<?php anva_template_class( 'grid' ); ?> grid-<?php echo esc_attr( $column ); ?> filter-container clearfix" data-layout="fitRows">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php anva_get_template_part( 'post', 'content-grid' ); ?>
			<?php endwhile; ?>
		</div><!-- #posts (end) -->

		<?php
			/**
			 * After post content not hooked by default.
			 */
			do_action( 'anva_post_content_after' );
		?>

	</div><!-- .postcontent (end) -->

	<?php wp_reset_postdata(); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
