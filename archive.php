<?php
/**
 * The template for displaying Archives
 * Like category, tag, dates, post-formats, etc.
 */

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-9">
		<div class="main">

			<div class="page-title">
				<h1>
					<?php anva_archive_title(); ?>
				</h1>
			</div><!-- .entry-header -->

			<div class="<?php anva_post_classes(); ?>">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'post' ); ?>
					<?php endwhile; ?>
					<?php anva_num_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</div><!-- .archive-post-list (end) -->

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebars( 'right', '3' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>