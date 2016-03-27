<?php
/**
 * The default template used for displaying page content in page.php
 * 
 * @version 1.0.0
 */

?>
<div class="entry-wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .entry-wrap (end) -->