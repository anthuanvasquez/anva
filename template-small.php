<?php
/**
 * Template Name: Posts Small
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

		<?php do_action( 'anva_posts_content_before' ); ?>

		<div id="posts" class="<?php anva_post_class( 'small' ); ?>">
			<?php
			$query = anva_get_posts();
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();
					anva_get_template_part( 'small' );
				endwhile;

				anva_num_pagination( $query->max_num_pages );
				wp_reset_postdata();
			endif;
			?>
		</div><!-- #posts (end) -->

		<?php do_action( 'anva_posts_content_after' ); ?>

	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
