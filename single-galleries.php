<?php
/**
 * The template file for single galleries.
 * 
 * @version 1.0.0
 */

get_header();
?>
<div class="container clearfix">

	<div class="postcontent">
		<div id="galleries">
		
		<?php anva_posts_content_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<div class="article-wrap">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
						$id 				= get_the_ID();
						$gallery_template 	= anva_get_field( 'gallery_template' );
						$templates			= anva_gallery_templates();

						if ( empty( $gallery_template ) ) {
							$gallery_template = anva_get_option( 'gallery_template' );
						}
					?>
					<div class="entry-content">
						<div class="entry-title">
							<h1><?php the_title(); ?></h1>
						</div><!-- .entry-title (end) -->
						<?php
							the_content();

							if ( ! post_password_required() ) {
								if ( isset( $templates[$gallery_template]['id'] ) && $gallery_template == $templates[$gallery_template]['id'] ) {
									$columns = $templates[$gallery_template]['layout']['col'];
									$size = $templates[$gallery_template]['layout']['size'];
									echo anva_gallery_grid( $id, $columns, $size );
								}
							}
						?>
						<div class="clearfix"></div>
					</div><!-- .entry-content (end) -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- .article-wrap (end) -->
			
			<?php anva_posts_comments(); ?>
		<?php endwhile; ?>

		<?php anva_posts_content_after(); ?>

		</div><!-- #galleries (end) -->
	</div><!-- .postcontent (end) -->

</div><!-- .container (end) -->

<?php get_footer(); ?>