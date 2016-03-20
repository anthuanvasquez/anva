<?php
/**
 * The template for displaying Archives.
 * 
 * Like category, tag, dates, post-formats, etc.
 * 
 * @version 1.0.0
 */

get_header();
$archive_title = anva_get_field( 'archive_title' );
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php echo anva_get_column_class( 'content' ); ?>">
		<div id="posts" class="<?php echo esc_attr( anva_post_classes( 'archive' ) ); ?>">
			<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( 'content', 'post' );
					}
					anva_num_pagination();				
				} else {
					get_template_part( 'content', 'none' );
				}
			?>
		</div><!-- #posts (end) -->
	</div><!-- .postcontent (end) -->
	
	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>