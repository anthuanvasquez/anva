<?php
/**
 * The template file for single galleries.
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
?>
<div class="container clearfix">

	<div class="col_full nobottommargin clearfix">
		<div id="galleries">

			<?php do_action( 'anva_posts_content_before' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="entry-wrap">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							$id 				= get_the_ID();
							$gallery_template 	= anva_get_post_meta( '_anva_gallery_template' );
							$templates			= anva_gallery_templates();

							if ( empty( $gallery_template ) ) {
								$gallery_template = anva_get_option( 'gallery_template' );
							}
						?>
						<div class="entry-content">
							<?php
								the_content();

								if ( ! post_password_required() ) {
									if ( isset( $templates[$gallery_template]['id'] ) && $gallery_template == $templates[$gallery_template]['id'] ) {
										$columns = $templates[ $gallery_template ]['layout']['col'];
										$size    = $templates[ $gallery_template ]['layout']['size'];
										anva_gallery_masonry( $id, $columns, $size );
									}
								}
							?>
							<div class="clearfix"></div>
						</div><!-- .entry-content (end) -->
					</article><!-- #post-<?php the_ID(); ?> -->
				</div><!-- .entry-wrap (end) -->

				<?php do_action( 'anva_posts_comments' ); ?>

			<?php endwhile; ?>

			<?php do_action( 'anva_posts_content_after' ); ?>

		</div><!-- #galleries (end) -->
	</div><!-- .postcontent (end) -->

</div><!-- .container (end) -->

<?php get_footer(); ?>
