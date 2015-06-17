<?php
/**
 * The template used for displaying single post content in single.php
 */
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-title">
			<h1><?php the_title(); ?></h1>
		</div><!-- .entry-header (end) -->
		
		<?php
			$single_meta = anva_get_option( 'single_meta' );
			if ( 1 == $single_meta ) {
				anva_posted_on();
			}
		?>
		<?php anva_get_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content (end) -->
		
		<div class="entry-footer">
			<div class="entry-tags tag">
				<?php the_tags( '<i class="fa fa-tags"></i> ', ' ' ); ?>
			</div>
		</div><!-- .entry-footer (end) -->
	</article><!-- #post-<?php the_ID(); ?> -->

	<?php anva_post_nav(); ?>

</div><!-- .article-wrapper (end) -->