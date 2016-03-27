<?php
/**
 * The default template used for displaying content in blogroll.
 *
 * @version 1.0.0
 */
?>

<div class="entry-wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>
		
		<?php anva_the_post_thumbnail( anva_get_option( 'primary_thumb' ) ); ?>
		
		<div class="entry-title">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</div><!-- .entry-title (end) -->
		
		<?php do_action( 'anva_posts_meta' ); ?>
		
		<div class="entry-content">
			<?php do_action( 'anva_posts_content' ); ?>
			<div class="entry-footer clearfix">
				<?php do_action( 'anva_posts_footer' ); ?>
			</div>
		</div><!-- .entry-content (end) -->
		
	</article><!-- .entry (end) -->
</div><!-- .entry-wrap (end) -->