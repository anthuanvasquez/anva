<?php
/**
 * Template Name: Archives
 * 
 * The template used for displaying archives content.
 * 
 * @version 1.0.0
 */
get_header();

$hide_title = anva_get_post_meta( '_hide_title' );
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<div class="article-wrapper">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
				<div class="entry-content">
					<?php if ( 'hide' != $hide_title ) : ?>
						<div class="entry-title">
							<h1><?php the_title(); ?></h1>
						</div>
					<?php endif; ?>

					<?php rewind_posts(); ?>
					<?php the_content(); ?>
					
					<h2><?php _e( 'Latest Posts', anva_textdomain() ); ?></h2>
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
						
						<h2><?php _e( 'Categories' ); ?></h2>
						<ul>
							<?php wp_list_categories( 'title_li=&hierarchical=0&show_count=1' ) ?>
						</ul>
						
						<h2><?php _e( 'Monthly Archives' ); ?></h2>
						<ul>
							<?php wp_get_archives( 'type=monthly&show_post_count=1' ) ?>
						</ul>
				</div><!-- .entry-content (end) -->
			</article><!-- #post-<?php the_ID(); ?> -->
		</div><!-- .article-wrapper (end) -->
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>