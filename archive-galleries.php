<?php
/**
 * The template file for galleries archives.
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

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$column       = 2; // Default Column.
$current_grid = anva_get_post_meta( '_anva_grid_column' );
$grid_columns = anva_get_grid_columns();
$thumbnail    = 'anva_grid_2';

if ( isset( $grid_columns[ $current_grid ]['column'] ) ) {
	$column = $grid_columns[ $current_grid ]['column'];
}
?>

<div class="container clearfix">

	<div id="galleries" class="<?php anva_template_class( 'gallery' ); ?> grid-<?php echo esc_attr( $column ); ?> clearfix" data-layout="fitRows">
		<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>

				<div class="gallery-image">
					<?php anva_gallery_slider( get_the_ID(), $thumbnail ); ?>
				</div><!-- .gallery-image (end) -->

				<div class="gallery-content">
					<div class="gallery-title">
						<h2>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
					</div>
					<div class="gallery-category">
						<?php anva_the_terms_links( 'gallery_album', ' / ' ); ?>
					</div>
				</div><!-- .gallery-content (end) -->
			</div>

		<?php endwhile; ?>

	</div><!-- #galleries (end) -->

	<?php wp_reset_postdata(); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
