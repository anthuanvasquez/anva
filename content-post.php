<?php
/**
 * The default template for displaying content in blogroll.
 */
?>

<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<?php anva_get_post_thumbnail( anva_get_option( 'posts_thumb' ) ); ?>
		<div class="entry-content">
			<div class="entry-title">
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			</div><!-- .entry-header (end) -->
			<?php anva_posts_meta(); ?>
			<div class="entry-summary">
				<?php anva_excerpt(); ?>
				<a class="button button-small" href="<?php the_permalink(); ?>">
					<?php echo anva_get_local( 'read_more' ); ?>
				</a>
			</div><!-- .entry-summary (end) -->
			<div class="entry-footer">
				<span class="entry-tags tag">
					<?php the_tags( '<i class="fa fa-tags"></i> ', ' ' ); ?>
				</span>
			</div><!-- .entry-footer (end) -->
		</div><!-- .entry-content (end) -->
	</article><!-- .entry -->
</div><!-- .article-wrapper (end) -->