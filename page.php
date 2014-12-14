<?php
/**
 * The template file for page.
 */

$classes = '';
$sidebar = anva_get_post_meta( '_sidebar_column' );

if ( 'left' == $sidebar || 'right' == $sidebar ) {
	$classes = 'col-sm-8';

} elseif ( 'double' == $sidebar || 'double_left' == $sidebar || 'double_right' == $sidebar  ) {
	$classes = 'col-sm-6';

} elseif ( 'fullwidth' == $sidebar ) {
	$classes = 'col-sm-12';

} else {
	$classes = 'col-sm-8';
	
}

get_header();
?>

<div class="row grid-columns">

	<?php anva_sidebar_layout_before(); ?>

	<div class="content-area <?php echo esc_attr($classes); ?>">
		<div class="main">

			<?php anva_post_before(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>
			
			<?php anva_post_after(); ?>

				<?php
					$single_comment = anva_get_option( 'single_comment' );
					if ( 1 == $single_comment ) :
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					endif;
				?>

			<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebar_layout_after(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>