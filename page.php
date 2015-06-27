<?php
/**
 * The template file for page.
 */
get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<?php anva_posts_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php
				$single_comment = anva_get_option( 'single_comment' );
				if ( 1 == $single_comment ) :
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				endif;
			?>

		<?php endwhile; ?>

		<?php anva_posts_after(); ?>
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>