<?php get_header(); ?>

<?php
	$classes = '';
	$sidebar = tm_get_post_meta('_sidebar_column');

	if ( 'left' == $sidebar || 'right' == $sidebar ) {
		$classes = 'content-area col-sm-8';

	} elseif ( 'double' == $sidebar || 'double_left' == $sidebar || 'double_right' == $sidebar  ) {
		$classes = 'content-area col-sm-6';

	} elseif ( 'fullwidth' ) {
		$classes = 'content-area col-sm-12';
	}
?>

<div class="row grid-columns">

	<?php tm_sidebar_layout_before(); ?>

	<div class="<?php echo esc_html( $classes ); ?>">
		<div class="main" role="main">

			<?php tm_post_before(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>
			
			<?php tm_post_after(); ?>

				<?php
					$single_comment = tm_get_option( 'single_comment' );
					if ( 1 == $single_comment ) :
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					endif;
				?>

			<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php tm_sidebar_layout_after(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>