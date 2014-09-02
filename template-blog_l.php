<?php
/*
 Template Name: Blog with Left Sidebar
 */

 get_header(); ?>


<div class="grid-columns row-fluid">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area right">
		<div class="site-main" role="main">
			<?php
				// First, initialize how many posts to render per page
				$number = get_option( 'posts_per_page' );

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
					endwhile;
					
					tm_num_pagination($the_query->max_num_pages);
					wp_reset_query();

				endif;
			?>	

		</div><!-- .site-main (end) -->
	</div><!-- .content-area (end) -->
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>