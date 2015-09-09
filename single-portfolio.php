<?php
/**
 * The template file for single portfolio.
 * 
 * @version 1.0.0
 */

get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>
	
	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<div id="posts">
			<?php anva_posts_content_before(); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="article-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-title">
							<h1><?php the_title(); ?></h1>
						</div><!-- .entry-title (end) -->
						
						<?php anva_posts_meta(); ?>
						<?php anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>
						
						<div class="entry-content">
							<?php the_content(); ?>
							
							<?php
								// Get galleries
								if ( is_singular( 'portfolio' ) ) :
									$gallery = anva_get_gallery_field();
									var_dump($gallery);
								endif;
							?>

						</div><!-- .entry-content (end) -->
						
						<div class="entry-footer">
							<?php anva_posts_footer(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link">' . anva_get_local( 'pages' ) . ': ', 'after' => '</div><!-- .page-link (end) -->' ) ); ?>
							<?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link">', '</span>' ); ?>
						</div><!-- .entry-footer (end) -->
					</article><!-- #post-<?php the_ID(); ?> -->

					<?php
						anva_post_nav();
						anva_post_author();
						anva_post_related();
					?>

				</div><!-- .article-wrapper (end) -->
				<?php anva_posts_comments(); ?>
			<?php endwhile; ?>
			<?php anva_posts_content_after(); ?>
		</div><!-- #posts (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar( 'right' ); ?>

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>