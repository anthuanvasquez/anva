<?php get_header(); ?>

<div class="grid-columns">
	<div class="content-area">
		<div class="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							$string = tm_get_local( 'search_for_post' ) . ' %s';
							$query =  get_search_query();
							echo sprintf( $string, $query );
						?>
					</h1>
				</header><!-- .page-header -->
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>
				<?php tm_num_pagination(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php tm_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>