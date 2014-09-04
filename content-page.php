<?php
	$hide_title = get_post_meta( $post->ID, '_hide_title', true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'hide' != $hide_title ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		<div class="entry-meta">
			<?php
				$single_meta = tm_get_option( 'single_meta' );
				if ( 1 == $single_meta ) :
					tm_posted_on();
				endif;
			?>
		</div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

</article>