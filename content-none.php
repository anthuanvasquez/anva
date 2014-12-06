<?php
/**
 * The template used for displaying page content in 404.php
 */
?>
<div class="article-wrapper">
	<article id="post-not-found" class="post post-not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo anva_get_local( 'not_found' ); ?></h1>
		</header><!-- .entry-header (end) -->
		<div class="entry-content">
			<?php echo wpautop( anva_get_local( 'not_found_content' ) ); ?>
		</div><!-- .entry-content -->
		<div class="clearfix"></div>
	</article><!-- .post-not-found (end) -->
</div><!-- .article-wrapper (end) -->