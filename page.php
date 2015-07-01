<?php
/**
 * The template file for page.
 */
get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<?php anva_posts_content_before(); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<?php anva_posts_comments(); ?>
		<?php endwhile; ?>
		<?php anva_posts_content_after(); ?>
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>