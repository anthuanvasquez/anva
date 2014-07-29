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
		$posts_thumb = tm_get_option( 'posts_thumb' );
		$output = '';

		switch ( $posts_thumb ) {
			case 0:				
				if ( has_post_thumbnail() ) :
				$output .= '<div class="entry-thumbnail medium-thumbnail">';
				$output .= '<a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_post_thumbnail( $post->ID, 'thumbnail_blog_medium' ).'</a>';
				$output .= '</div>';
				endif;
				break;

			case 1:
				if ( has_post_thumbnail() ) :
				$output .= '<div class="entry-thumbnail large-thumbnail">';
				$output .= '<a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_post_thumbnail( $post->ID, 'thumbnail_blog_large' ).'</a>';
				$output .= '</div>';
				endif;
				break;

			case 2:
					$output = '';
				break;

			default:
				if ( has_post_thumbnail() ) :
				$output .= '<div class="entry-thumbnail large-thumbnail">';
				$output .= '<a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_post_thumbnail( $post->ID, 'thumbnail_blog_large' ).'</a>';
				$output .= '</div>';
				endif;
				break;
		}

		echo $output;
		?>
		
		

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a class="button" href="<?php the_permalink(); ?>">
				<?php echo tm_get_local( 'read_more' ); ?>
			</a>
		</div>
	</div>
</article>