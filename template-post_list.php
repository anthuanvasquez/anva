<?php
/*
 Template Name: Post List
 */

 get_header(); ?>

<div class="row grid-columns">

	<div class="content-area col-sm-8">
		<div class="main">
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

	<?php tm_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>