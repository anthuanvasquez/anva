<?php
/**
 * The default template for displaying content in blogroll.
 */
?>

<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<?php anva_get_post_thumbnail( anva_get_option( 'primary_thumb' ) ); ?>
		<div class="entry-content">
			<div class="entry-title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div><!-- .entry-title (end) -->
			<?php anva_posts_meta(); ?>
			<div class="entry-summary">	
				<?php anva_posts_content(); ?>
			</div><!-- .entry-summary (end) -->
			<div class="entry-footer">
				<span class="entry-tags tag">
					<?php the_tags( '<i class="fa fa-tags"></i> ', ' ' ); ?>
				</span>
			</div><!-- .entry-footer (end) -->
		</div><!-- .entry-content (end) -->
	</article><!-- .entry -->
</div><!-- .article-wrapper (end) -->