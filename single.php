<?php
/**
 * The template file for single posts.
 */

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-9">
		<div class="main" role="main">
		
			<?php anva_content_post_before(); ?>

			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', 'single' ); ?>

				<?php
					$single_comment = anva_get_option( 'single_comment' );
					if ( 1 == $single_comment ) {
						if ( comments_open() || '0' != get_comments_number() ) {
							comments_template();
						}
					}
				?>

			<?php endwhile; ?>

			<?php anva_content_post_after(); ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebars( 'right', '3' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>