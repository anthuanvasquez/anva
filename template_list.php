<?php
/**
 * Template Name: Posts List
 *
 * The template used for displaying posts in list.
 */

 get_header();
 ?>

<div class="row grid-columns">
	
	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<?php anva_posts_content_before(); ?>
		<div id="posts" class="<?php echo esc_attr( anva_post_classes( 'list' ) ); ?>">
			<?php
				$query = anva_get_query_posts();
				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) : $query->the_post();
						get_template_part( 'content', 'post' );
					endwhile;

					anva_num_pagination( $query->max_num_pages );
					wp_reset_postdata();
				endif;
			?>
		</div><!-- #posts (end) -->
		<?php anva_posts_content_after(); ?>
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>