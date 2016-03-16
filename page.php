<?php
/**
 * The template file for page.
 * 
 * @version 1.0.0
 */
get_header();
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php echo anva_get_column_class( 'content' ); ?>">
		<?php anva_posts_content_before(); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part('content', 'page'); ?>
			<?php anva_posts_comments(); ?>
		<?php endwhile; ?>
		<?php anva_posts_content_after(); ?>
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>