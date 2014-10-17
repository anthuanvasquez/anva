<?php
/*
 Template Name: Contact Us
 */
?>

<?php get_header(); ?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<?php echo tm_contact_form(); ?>
		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>