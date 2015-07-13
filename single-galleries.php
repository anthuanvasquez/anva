<?php
/**
 * The template file for single gallery posts.
 */

if ( session_id() == '' ) {
	session_start();
}

get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<div id="galleries">
		
		<?php anva_posts_content_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<div class="article-wrapper">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php
						// Check if password protected
						$id 							= get_the_ID();
						$meta 						= anva_get_post_custom();
						$gallery_password = $meta['_gallery_password'][0];
						$gallery_template = $meta['_gallery_template'][0];
						$templates				= anva_gallery_templates();
						
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

							if ( empty( $gallery_template ) ) {
								$gallery_template = anva_get_option( 'gallery_template' );
							}

							if ( isset( $templates[$gallery_template]['id'] ) && $gallery_template == $templates[$gallery_template]['id'] ) {
								$column = $templates[$gallery_template]['layout']['col'];
								$size = $templates[$gallery_template]['layout']['size'];
								$type = $templates[$gallery_template]['layout']['type'];
								anva_gallery_grid( $column, $size, $type );
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

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>