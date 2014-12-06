<?php
/**
 * The template used for displaying page content in page.php
 */
$hide_title = anva_get_post_meta( '_hide_title' );
?>
<div class="article-wrapper">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( 'hide' != $hide_title ) : ?>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header (end) -->
		<?php endif; ?>
		<div class="entry-content">
			<?php the_content(); ?>
			<div class="clearfix"></div>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .article-wrapper (end) -->