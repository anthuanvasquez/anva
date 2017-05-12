<?php
/**
 * The template file for single posts.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

get_header();
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php anva_column_class( 'content' ); ?>">
		<div class="single-post nobottommargin">

			<?php do_action( 'anva_post_content_before' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php anva_get_template_part( 'post', 'content-single' ); ?>

				<?php if ( anva_get_area( 'comments', 'single' ) ) : ?>
					<?php
						/**
						 * Hooked
						 *
						 * @see anva_post_comments_default
						 */
						do_action( 'anva_post_comments' );
					?>
				<?php endif; ?>
			<?php endwhile; ?>

			<?php do_action( 'anva_post_content_after' ); ?>

		</div><!-- .single-post (end) -->
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
