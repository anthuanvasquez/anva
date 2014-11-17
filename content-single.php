<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php
			$single_meta = tm_get_option( 'single_meta' );
			if ( 1 == $single_meta ) :
				tm_posted_on();
			endif;
		?>
	</header>
	
	<div class="entry-content">
		<?php tm_post_thumbnails( tm_get_option( 'single_thumb' ) ); ?>
		<?php the_content(); ?>
	</div>
</article>