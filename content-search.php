<?php
/**
 * The template used for displaying page content in search.php
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		</header><!-- .entry-header (end) -->
		<div class="entry-content">
			<div class="entry-summary">
				<?php anva_excerpt(); ?>
				<a class="btn btn-default" href="<?php the_permalink(); ?>">
					<?php echo anva_get_local( 'read_more' ); ?>
				</a>
			</div><!-- .entry-summary (end) -->
			<div class="clearfix"></div>
		</div><!-- .entry-content (end) -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .article-wrapper (end) -->