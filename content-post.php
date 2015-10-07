<?php
/**
 * The default template for displaying content in blogroll.
 *
 * @version 1.0.0
 */
?>

<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<?php anva_the_post_thumbnail( anva_get_option( 'primary_thumb' ) ); ?>
		<div class="entry-content">
			<div class="entry-title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div><!-- .entry-title (end) -->
			<?php anva_posts_meta(); ?>
			<div class="entry-summary">	
				<?php anva_posts_content(); ?>
			</div><!-- .entry-summary (end) -->
			<div class="entry-footer">
				<?php anva_posts_footer(); ?>
				<div class="clearfix"></div>
			</div><!-- .entry-footer (end) -->
		</div><!-- .entry-content (end) -->
	</article><!-- .entry -->
</div><!-- .article-wrapper (end) -->