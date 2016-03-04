<?php
/**
 * Template Name: Contact Form
 * 
 * The template file for page.
 * 
 * @version 1.0.0
 */
get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>

	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<?php anva_posts_content_before(); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php $hide_title = anva_get_field( 'hide_title' ); ?>
			<div class="article-wrapper">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
					<div class="entry-content">
						<?php if ( 'hide' != $hide_title ) : ?>
							<div class="entry-title">
								<h1><?php the_title(); ?></h1>
							</div><!-- .entry-title (end) -->
						<?php endif; ?>
						<div class="entry-summary">
							
							<?php the_content(); ?>

							<?php anva_contact_form(); ?>

						</div><!-- .entry-summary -->
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- .article-wrapper (end) -->

		<?php endwhile; ?>
		<?php anva_posts_content_after(); ?>
	</div><!-- .content-area (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>