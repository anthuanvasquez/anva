<?php
/*
 Template Name: Post List
 */

 get_header(); ?>


<div class="grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area right">
		<div class="main" role="main">
			<?php
				
				$the_query = tm_get_post_query();
					
				if ( $the_query->have_posts() ) :
					while ($the_query->have_posts()) : $the_query->the_post();
						get_template_part( 'content', 'post' );
					endwhile;
					
					tm_num_pagination($the_query->max_num_pages);
					wp_reset_query();

				endif;
			?>	

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>