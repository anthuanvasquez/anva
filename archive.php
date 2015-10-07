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

<div class="row grid-columns">
	
	<?php if ( 'hide' != $archive_title ) : ?>
	<div class="page-title col-sm-12">
		<h1><?php anva_archive_title(); ?></h1>
	</div><!-- .page-title -->
	<?php endif; ?>

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
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
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>