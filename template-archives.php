<?php
/**
 * Template Name: Archives
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
		<div class="entry-wrap">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
				<div class="entry-content">

					<?php rewind_posts(); ?>
					<?php the_content(); ?>

					<h2>
						<?php esc_html_e( 'Latest Posts', 'anva' ); ?>
					</h2>
					<ul>
						<?php
						$query = anva_get_posts( array(
							'posts_per_page' => 20,
						) );
						?>
						<?php if ( $query->have_posts() ) : ?>
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>
								<?php $wp_query->is_home = false; ?>
								<li>
									<a href="<?php the_permalink() ?>">
										<?php the_title(); ?>
									</a> - <?php the_time( get_option( 'date_format' ) ); ?>
								</li>
							<?php endwhile; ?>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					</ul>

					<h2>
						<?php esc_html_e( 'Categories', 'anva' ); ?>
					</h2>
					<ul>
						<?php wp_list_categories( 'title_li=&hierarchical=0&show_count=1' ) ?>
					</ul>

					<h2>
						<?php esc_html_e( 'Monthly Archives', 'anva' ); ?>
					</h2>
					<ul>
						<?php wp_get_archives( 'type=monthly&show_post_count=1' ) ?>
					</ul>
				</div><!-- .entry-content (end) -->
			</article><!-- #post-<?php the_ID(); ?> (end) -->
		</div><!-- .entry-wrap (end) -->
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
