<?php
/*
 Template Name: Blog 2 Columns
 */

 get_header(); ?>


<div class="grid-columns row-fluid">
	<div class="content-area">
		<div class="site-main" role="main">
			<?php
				// First, initialize how many posts to render per page
				$number = get_option( 'posts_per_page' );
				$count = 0;
				// Next, get the current page
				$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

				// After that, calculate the offset
				$offset = ( $page - 1 ) * $number;

				// Finally, we'll set the query arguments and instantiate WP_Query
				$query_args = array(
				  'post_type'  =>  array( 'post' ),
				  'posts_per_page' => $number,
				  'orderby'    =>  'date',
				  'order'      =>  'desc',
				  'number'     =>  $number,
				  'page'       =>  $page,
				  'offset'     =>  $offset
				);

				$the_query = new WP_Query( $query_args );
					
				if ( $the_query->have_posts() ) :
					
					while ($the_query->have_posts()) : $the_query->the_post();
						
						get_template_part( 'content', 'post' );
						
						if ( $count % 2 === 0 ) :
							echo '<div class="clear"></div>';
						endif;

						$count++;

					endwhile;
					
					tm_num_pagination($the_query->max_num_pages);
					wp_reset_query();

				endif;
			?>	

		</div><!-- .site-main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>