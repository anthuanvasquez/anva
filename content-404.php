<?php
/**
 * The template used is post not found
 */
?>
<div class="article-wrapper">
	<article id="page-404" class="page page-404">
		<div class="entry-content">
			<div class="entry-title">
				<h1><?php echo anva_get_local( '404_title' ); ?></h1>
			</div><!-- .entry-title (end) -->
			<?php echo wpautop( anva_get_local( '404_description' ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- .page-not-found (end) -->
</div><!-- .article-wrapper (end) -->