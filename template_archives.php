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
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */

get_header();
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<div class="entry-wrap">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
				<div class="entry-content">
					<?php if ( 'hide' != $hide_title ) : ?>
						<div class="entry-title">
							<h1><?php the_title(); ?></h1>
						</div>
					<?php endif; ?>

					<?php rewind_posts(); ?>
					<?php the_content(); ?>
					
					<h2><?php _e( 'Latest Posts', 'anva' ); ?></h2>
						<ul>
							<?php query_posts( 'showposts=20' ); ?>
							<?php if ( have_posts() ) : ?>
								<?php while ( have_posts() ) : the_post(); ?>
									<?php $wp_query->is_home = false; ?>
									<li>
										<a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php the_time( get_option( 'date_format' ) ); ?>
									</li>
								<?php endwhile; ?>
							<?php endif; ?>
							<?php wp_reset_query(); ?>
						</ul>
						
						<h2><?php _e( 'Categories', 'anva' ); ?></h2>
						<ul>
							<?php wp_list_categories( 'title_li=&hierarchical=0&show_count=1' ) ?>
						</ul>
						
						<h2><?php _e( 'Monthly Archives', 'anva' ); ?></h2>
						<ul>
							<?php wp_get_archives( 'type=monthly&show_post_count=1' ) ?>
						</ul>
				</div><!-- .entry-content (end) -->
			</article><!-- #post-<?php the_ID(); ?> -->
		</div><!-- .entry-wrap (end) -->
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>