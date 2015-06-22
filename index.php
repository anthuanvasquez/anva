<?php
/**
 * The main template file.
 */

get_header();
?>

<div class="row grid-columns">
	<?php if ( ! is_front_page() ) : ?>
		<div class="page-title">
			<h1><?php echo __( 'Blog', anva_textdomain() ); ?></h1>
		</div><!-- .page-title -->
	<?php endif; ?>
	<div class="content-area col-sm-9">
		<div id="posts" class="<?php anva_post_classes(); ?>">
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