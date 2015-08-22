<?php
/**
 * The template file for single gallery posts.
 * 
 * @version 1.0.0
 */

// Start session
if ( session_id() == '' ) {
	session_start();
}

get_header();
?>
<div class="row grid-columns">

	<div class="content-area col-sm-12">
		<div id="galleries">
		
		<?php anva_posts_content_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<div class="article-wrapper">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
						$id 							= get_the_ID();
						$gallery_password = anva_get_field( 'gallery_password' );
						$gallery_template = anva_get_field( 'gallery_template' );
						$templates				= anva_gallery_templates();

						if ( empty( $gallery_template ) ) {
							$gallery_template = anva_get_option( 'gallery_template' );
						}
						
						if ( ! empty( $gallery_password ) && ! isset( $_SESSION['gallery_page_' . $id] ) ) :
							
							if ( ! isset( $_SESSION['gallery_page_' . $id] ) || empty( $_SESSION['gallery_page_' . $id] ) ) :
								anva_get_template_part( 'password' );
							endif;

						else :
						?>
					
						<div class="entry-content">
							<div class="entry-title">
								<h1><?php the_title(); ?></h1>
							</div><!-- .entry-title (end) -->
							<?php the_content(); ?>
							<?php

								// if ( post_password_required() ) {
								// 	return '';
								// }

								if ( isset( $templates[$gallery_template]['id'] ) && $gallery_template == $templates[$gallery_template]['id'] ) {
									$columns = $templates[$gallery_template]['layout']['col'];
									$size = $templates[$gallery_template]['layout']['size'];
									$type = $templates[$gallery_template]['layout']['type'];
									echo anva_gallery_grid( $id, $columns, $size, $type );
								}
							?>
							<div class="clearfix"></div>
						</div><!-- .entry-content (end) -->

						<?php endif; ?>
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- .article-wrapper (end) -->
			
			<?php anva_posts_comments(); ?>
		<?php endwhile; ?>

		<?php anva_posts_content_after(); ?>

		</div><!-- #galleries (end) -->
	</div><!-- .content-area (end) -->

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>