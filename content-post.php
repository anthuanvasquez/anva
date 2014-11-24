<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<?php
			$single_meta = tm_get_option( 'single_meta' );
			if ( 1 == $single_meta ) :
				tm_posted_on();
			endif;
		?>
	</header>

	<div class="entry-container group">

		<?php tm_post_thumbnails( tm_get_option( 'posts_thumb' ) ); ?>

		<div class="entry-summary">
			<?php tm_excerpt_limit(); ?>
			<a class="btn btn-default" href="<?php the_permalink(); ?>">
				<?php echo tm_get_local( 'read_more' ); ?>
			</a>
		</div>
	</div>
</article>