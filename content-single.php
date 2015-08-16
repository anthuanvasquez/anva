<?php
/**
 * The template used for displaying single post content in single.php
 *
 * @version 1.0.0
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-title">
			<h1><?php the_title(); ?></h1>
		</div><!-- .entry-title (end) -->
		
		<?php anva_posts_meta(); ?>
		<?php anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>
		
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content (end) -->
		
		<div class="entry-footer">
			<?php anva_posts_footer(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . anva_get_local( 'pages' ) . ': ', 'after' => '</div><!-- .page-link (end) -->' ) ); ?>
			<?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-footer (end) -->
	</article><!-- #post-<?php the_ID(); ?> -->

	<?php
		anva_post_nav();
		anva_post_author();
		anva_post_related();
	?>

</div><!-- .article-wrapper (end) -->