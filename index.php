<?php get_header(); ?>

<div class="grid-columns row-fluid">
	<div class="content-area">
		<div class="site-main" role="main">

		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'post' );
				endwhile;
				
				tm_num_pagination();
				
			else :
				get_template_part( 'content', 'none' );
			endif;
		?>

		</div><!-- .site-main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
