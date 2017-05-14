<?php
/**
 * Template Name: Contact Form
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

		<?php do_action( 'anva_post_content_before' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<div class="entry-wrap">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

					<!-- CONTACT FORM (start)-->
					<?php
						/**
						 * Hooked.
						 *
						 * @see anva_contact_form_default
						 */
						do_action( 'anva_contact_form' );
					?>
					<!-- CONTACT FORM (end) -->

				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- .entry-wrap (end) -->
		<?php endwhile; ?>

		<?php do_action( 'anva_post_content_after' ); ?>

	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
