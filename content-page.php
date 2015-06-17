<?php
/**
 * The template used for displaying page content in page.php
 */
$hide_title = anva_get_post_meta( '_hide_title' );
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<div class="entry-content">
			<?php if ( 'hide' != $hide_title ) : ?>
				<div class="entry-title">
					<h1><?php the_title(); ?></h1>
				</div><!-- .entry-header (end) -->
			<?php endif; ?>
			<div class="entry-summary">
				<?php the_content(); ?>
			</div><!-- .entry-summary -->
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .article-wrapper (end) -->