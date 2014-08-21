<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta">
			<?php
				$single_meta = tm_get_option( 'single_meta' );
				if ( 1 == $single_meta ) :
					tm_posted_on();
				endif;
			?>
		</div>
	</header>
	<?php
		$single_thumb = tm_get_option( 'single_thumb' );
		$output = '';

		switch ( $single_thumb ) {
			case 0:
				$output .= '<div class="entry-thumbnail medium-thumbnail">'.get_the_post_thumbnail( $post->ID, 'thumbnail_blog_medium' ).'</div>';
				break;

			case 1:
				$output .= '<div class="entry-thumbnail large-thumbnail">'.get_the_post_thumbnail( $post->ID, 'thumbnail_blog_large' ).'</div>';
				break;

			case 2:
					$output = '';
				break;

			default:
				$output .= '<div class="entry-thumbnail large-thumbnail">'.get_the_post_thumbnail( $post->ID, 'thumbnail_blog_large' ).'</div>';
				
				break;
		}

		echo $output;
	?>
	
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>