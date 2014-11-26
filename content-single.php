<?php
/**
 * The template used for displaying single post content in single.php
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="meta-wrapper">
				<?php
					$single_meta = tm_get_option( 'single_meta' );
					if ( 1 == $single_meta ) :
						tm_posted_on();
					endif;
				?>
			</div>
		</header><!-- .entry-header (end) -->
		
		<div class="entry-content">
			<div class="featured-image-wrapper">
				<div class="featured-image">
					<div class="featured-image-inner">
						<?php echo tm_post_thumbnails( tm_get_option( 'single_thumb' ) ); ?>
					</div>
				</div>
			</div><!-- .featured-image-wrapper (end) -->
			<?php the_content(); ?>
			<div class="clearfix"></div>
			<footer class="entry-footer">
				<span class="tag">
					<?php the_tags( '<i class="fa fa-tags"></i> ', ', ' ); ?>
				</span>
			</footer><!-- .entry-footer (end) -->
		</div><!-- .entry-content (end) -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .article-container (end) -->