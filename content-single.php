<?php
/**
 * The template used for displaying single post content in single.php
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-title">
			<h1><?php the_title(); ?></h1>
		</div><!-- .entry-title (end) -->
		
		<?php anva_posts_meta(); ?>
		<?php anva_get_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>
		
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content (end) -->
		
		<div class="entry-footer">
			<?php anva_posts_tag(); ?>
		</div><!-- .entry-footer (end) -->
	</article><!-- #post-<?php the_ID(); ?> -->

	<?php
		anva_post_nav();
		anva_post_author();
		anva_post_related();
	?>

</div><!-- .article-wrapper (end) -->