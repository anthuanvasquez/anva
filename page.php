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
		
		<?php do_action( 'anva_posts_content_before' ); ?>
		
		<?php while ( have_posts() ) : the_post(); ?>
			<?php anva_get_template_part( 'page' ); ?>
			<?php do_action( 'anva_posts_comments' ); ?>
		<?php endwhile; ?>
		
		<?php do_action( 'anva_posts_content_after' ); ?>
	
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>