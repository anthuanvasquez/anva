<?php get_header(); ?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="main">

		<?php if ( have_posts() ) : ?>

			<header class="entry-header">
				<h1 class="entry-title">
					<?php tm_archive_title(); ?>
				</h1>
			</header><!-- .page-header -->
			
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'post' ); ?>

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
