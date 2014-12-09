<?php
/**
 * Template Name: Homepage
 *
 * The template used for displaying page content in front page
 */

$hide_title = anva_get_post_meta( '_hide_title' );

get_header();
?>

<div class="row grid-columns">
	<div class="content col-sm-12">
		<div class="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
				<?php if ( 'hide' != $hide_title ) : ?>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
					<div class="clearfix"></div>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
		<?php endwhile; ?>
		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

	<div class="sidebar-wrapper sidebar-home col-sm-12">
		<div class="sidebar-inner">
			<div class="widget-area widget-area-home">
				<div class="grid-columns">
					<?php if ( dynamic_sidebar( 'homepage' ) ) : endif; ?>
				</div><!-- .grid-columns (end) -->
			</div>
		</div>
	</div><!-- .sidebar-wrapperr (end) -->
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>