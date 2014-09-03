<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<div class="entry-meta">
			<?php
				$single_meta = tm_get_option( 'single_meta' );
				if( 1 == $single_meta ) :
					tm_posted_on();
				endif;
			?>
		</div>
	</header>

	<div class="entry-container group">

		<?php
			$grid_columns = get_post_meta( $post->ID, '_grid_columns', true );
			$size = 'thumbnail_grid_'. $grid_columns;
			var_dump($size);
			echo tm_post_grid_thumbnails( $size );
		?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a class="button" href="<?php the_permalink(); ?>">
				<?php echo tm_get_local( 'read_more' ); ?>
			</a>
		</div>
	</div>
</article>