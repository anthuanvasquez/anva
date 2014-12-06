<?php get_header(); ?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="main">

			<header class="entry-header">
				<h1 class="entry-title">
					<?php printf( anva_get_local( 'search_result' ) . ' %s', get_search_query() ); ?>
				</h1>
			</header><!-- .page-header -->
				
			<div class="search-post-list post-list-paginated post-list">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'search' ); ?>
					<?php endwhile; ?>
					<?php anva_num_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</div><!-- .search-post-list  (end) -->

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>