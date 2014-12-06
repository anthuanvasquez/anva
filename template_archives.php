<?php
/**
 * Template Name: Archives
 *
 * The template used for displaying archives content
 */

 get_header();

 $hide_title = anva_get_post_meta( '_hide_title' );
 ?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php if ( 'hide' != $hide_title ) : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php endif; ?>
				</header>
				<div class="entry-content">
					<?php rewind_posts(); ?>
					<?php the_content(); ?>
					
					<h2>Ultimas Publicaciones</h2>
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
						
						<h2>Categorias</h2>
						<ul>
							<?php wp_list_categories( 'title_li=&hierarchical=0&show_count=1' ) ?>
						</ul>
						
						<h2>Archivos Mensuales</h2>
						<ul>
							<?php wp_get_archives( 'type=monthly&show_post_count=1' ) ?>
						</ul>
				</div><!-- .entry-content (end) -->
			</article>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->

	<?php anva_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>