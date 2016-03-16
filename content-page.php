<?php
/**
 * The default template used for displaying page content in page.php
 * 
 * @version 1.0.0
 */

// @todo move to global part with title
// using action anva_page_title()
$hide_title = anva_get_field( 'hide_title' );
?>
<div class="entry-wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .entry-wrap (end) -->