<?php
/**
 * The default template for displaying content in blogroll.
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<div class="meta-wrapper">
				<?php
					$single_meta = anva_get_option( 'single_meta' );
					if ( 1 == $single_meta ) :
						anva_posted_on();
					endif;
				?>
			</div>
		</header><!-- .entry-header (end) -->
		<div class="entry-content">
			<?php echo anva_post_thumbnails( anva_get_option( 'posts_thumb' ) ); ?>
			<div class="entry-summary">
				<?php anva_excerpt(); ?>
				<a class="btn btn-default" href="<?php the_permalink(); ?>">
					<?php echo anva_get_local( 'read_more' ); ?>
				</a>
			</div><!-- .entry-summary (end) -->
			<div class="clearfix"></div>
		</div><!-- .entry-content (end) -->
		<footer class="entry-footer">
			<span class="tag">
				<?php the_tags( '<i class="fa fa-tags"></i> ', ', ' ); ?>
			</span>
		</footer><!-- .entry-footer (end) -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .article-wrapper (end) -->