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

							switch ( $gallery_template ) {
								case 'Gallery 1 Column':
									anva_gallery_grid( '1-col', 'blog_full' );
									break;
								case 'Gallery 2 Columns':
									anva_gallery_grid( '2-col', 'gallery_2' );
									break;		
								case 'Gallery 3 Columns':
									anva_gallery_grid( '3-col', 'gallery_2' );
									break;
								case 'Gallery 4 Columns':
									anva_gallery_grid( '4-col', 'gallery_2' );
									break;
								case 'Gallery 5 Columns':
									anva_gallery_grid( '5-col', 'gallery_3' );
									break;
								case 'Gallery Masonry 2 Columns':
									anva_get_template_part( 'gallery-masonry-2' );
									break;
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