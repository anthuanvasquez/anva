<?php
/**
 * The main template file.
 * 
 * @version 1.0.0
 */

get_header();
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php echo anva_get_column_class( 'content' ); ?>">
		<div id="posts" class="<?php echo esc_attr( anva_post_classes( 'index' ) ); ?>">
			<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						anva_get_template_part( 'post' );
					}
					anva_pagination();
				} else {
					anva_get_template_part( 'none' );
				}
			?>
		</div><!-- #posts (end) -->
	</div><!-- .postcontent (end) -->
	
	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>