<?php
/**
 * The template for displaying Archives
 * Like category, tag, dates, post-formats, etc.
 */

get_header();
?>

<div class="row grid-columns">
	<div class="page-title">
		<h1><?php anva_archive_title(); ?></h1>
	</div><!-- .page-title -->
	<div class="content-area col-sm-9">
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
	
	<?php anva_sidebars( 'right', '3' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>