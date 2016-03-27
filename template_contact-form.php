<?php
/**
 * Template Name: Contact Form
 * 
 * The template file for contact page.
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
			<div class="entry-wrap">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
					
					<!-- CONTACT FORM (start)-->
					<?php anva_contact_form(); ?>
					<!-- CONTACT FORM (end) -->

				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- .entry-wrap (end) -->
		<?php endwhile; ?>
		
		<?php do_action( 'anva_posts_content_after' ); ?>
	
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>