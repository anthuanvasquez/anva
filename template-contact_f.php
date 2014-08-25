<?php
/*
 Template Name: Contact Us FullWidth
 */
?>

<?php get_header(); ?>

<div class="grid-columns row-fluid">
	<div class="content-area">
		<div class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<?php get_template_part( 'framework/plugins/contact' ); ?>
		<?php endwhile; ?>

		</div><!-- .site-main (end) -->
	</div><!-- .content-area (end) -->	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
