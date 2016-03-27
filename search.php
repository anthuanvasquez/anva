<?php
/**
 * The template file for search results.
 *
 * @version 1.0.0
 */

get_header();
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php echo anva_get_column_class( 'content' ); ?>">
		
		<?php do_action( 'anva_posts_content_before' ); ?>
		
		<div class="<?php echo esc_attr( anva_post_classes( 'search' ) ); ?>">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php anva_get_template_part( 'search' ); ?>
				<?php endwhile; ?>
				<?php anva_num_pagination(); ?>
			<?php else : ?>
				<?php anva_get_template_part( 'none' ); ?>
			<?php endif; ?>
		</div><!-- .search-post-list (end) -->

		<?php do_action( 'anva_posts_content_after' ); ?>
	
	</div><!-- .postcontent (end) -->
	
	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>