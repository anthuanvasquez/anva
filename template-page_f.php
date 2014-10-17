<?php
/*
 Template Name: Full Width Page
 */

get_header();
?>

<div class="grid-columns">
	<div class="full-width">
		<div class="site-main" role="main">

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