<?php
/**
 * The default template used for single post content.
 * 
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
	
	<div class="entry-title">
		<h2><?php the_title(); ?></h2>
	</div><!-- .entry-title (end) -->
	
	<?php do_action( 'anva_posts_meta' ); ?>
	
	<?php anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>
	
	<div class="entry-content notopmargin">
		<?php the_content(); ?>
	</div><!-- .entry-content (end) -->
	
	<div class="entry-footer">
		<?php do_action( 'anva_posts_footer' ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . anva_get_local( 'pages' ) . ': ', 'after' => '</div><!-- .page-link (end) -->' ) ); ?>
		<?php edit_post_link( anva_get_local( 'edit_post' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-footer (end) -->
	
</article><!-- .entry (end) -->

<?php anva_post_nav(); ?>
<?php anva_post_author(); ?>
<?php anva_post_related(); ?>