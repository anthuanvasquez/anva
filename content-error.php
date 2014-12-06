<?php
/**
 * The template used is post not found
 */
?>
<div class="article-wrapper">
	<article id="page-not-found" class="page page-not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo anva_get_local( '404_title' ); ?></h1>
		</header><!-- .entry-header (end) -->
		<div class="entry-content">
			<?php echo wpautop( anva_get_local( '404_description' ) ); ?>
		</div><!-- .entry-content -->
		<div class="clearfix"></div>
	</article><!-- .page-not-found (end) -->
</div><!-- .article-wrapper (end) -->