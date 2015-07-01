<?php
/**
 * The template file for single posts.
 */

get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>
	
	<div class="content-area col-sm-9">
		<div id="posts">
			<?php anva_posts_content_before(); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'single' ); ?>
				<?php anva_posts_comments(); ?>
			<?php endwhile; ?>
			<?php anva_posts_content_after(); ?>
		</div><!-- #posts (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar( 'right' ); ?>

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>