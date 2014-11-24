<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php
			$single_meta = tm_get_option( 'single_meta' );
			if ( 1 == $single_meta ) :
				tm_posted_on();
			endif;
		?>
	</header><!-- .entry-header (end) -->
	
	<div class="entry-content">
		<div class="featured-image-wrapper">
			<div class="featured-image">
				<div class="featured-image-inner">
					<?php tm_post_thumbnails( tm_get_option( 'single_thumb' ) ); ?>
				</div>
			</div>
		</div><!-- .featured-image-wrapper (end) -->

		<?php the_content(); ?>
	</div><!-- .entry-content (end) -->

</article>