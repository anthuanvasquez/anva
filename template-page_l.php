<?php
/*
 Template Name: Sidebar Left
 */
?>

<?php get_header(); ?>

<div class="grid-columns">

	<?php get_sidebar( 'left' ); ?>
	
	<div class="content-area right">
		<div class="main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>