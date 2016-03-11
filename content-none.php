<?php
/**
 * The default template used for displaying page content in 404.php
 * 
 * @version 1.0.0
 */
?>
<div class="article-wrapper">
	<article id="post-not-found" class="post entry post-not-found clearfix">
		<div class="entry-content">
			<div class="entry-title">
				<h1><?php echo anva_get_local( 'not_found' ); ?></h1>
			</div><!-- .entry-title (end) -->
			<?php echo wpautop( anva_get_local( 'not_found_content' ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- .post-not-found (end) -->
</div><!-- .article-wrapper (end) -->