<?php
/**
 * Template Name: Post List
 *
 * The template used for displaying posts in list
 */

 get_header();
 ?>

<div class="row grid-columns">

	<div class="content-area col-sm-8">
		<div class="main">
			<?php
				$the_query = anva_get_post_query();
				if ( $the_query->have_posts() ) :
					while ($the_query->have_posts()) : $the_query->the_post();
						get_template_part( 'content', 'post' );
					endwhile;
					
					anva_num_pagination( $the_query->max_num_pages) ;
					wp_reset_query();
				endif;
			?>
		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

	<?php anva_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>