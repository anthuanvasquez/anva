<?php
/**
 * The default template used for displaying page content in search.php
 * 
 * @version 1.0.0
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<div class="entry-content">
			<div class="entry-title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div><!-- .entry-title (end) -->
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