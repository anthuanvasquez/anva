<?php
/**
 * The main template file.
 */

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="main">
			<div class="primary-post-list post-list-paginated post-list">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'post' );
					endwhile;
					
					anva_num_pagination();
					
				else :
					get_template_part( 'content', 'none' );
				endif;
			?>
			</div><!-- .primary-post-list (end) -->
		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
