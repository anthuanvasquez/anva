<?php
/**
 * The main template file.
 * 
 * @version 1.0.0
 */

get_header();
?>

<div class="container clearfix">
	
	<?php if ( ! is_front_page() ) : ?>
		<div class="page-title">
			<h1><?php echo anva_get_local( 'blog' ); ?></h1>
		</div><!-- .page-title -->
	<?php endif; ?>

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php echo anva_get_column_class( 'content' ); ?>">
		<div id="posts" class="<?php echo esc_attr( anva_post_classes( 'index' ) ); ?>">
			<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( 'content', 'post' );
					}
					anva_pagination();
				} else {
					get_template_part( 'content', 'none' );
				}
			?>
		</div><!-- #posts (end) -->
	</div><!-- .postcontent (end) -->
	
	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>