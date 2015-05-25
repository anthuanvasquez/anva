<?php
/**
 * The template file for single gallery posts.
 */

if ( session_id() == '' ) {
	session_start();
}

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-12">
		<div class="main" role="main">
		
		<?php anva_post_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<div class="article-wrapper">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php
						// Check if password protected
						$id 							= get_the_ID();
						$meta 						= anva_get_post_custom();
						$gallery_password = $meta['_gallery_password'][0];
						$gallery_template = $meta['_gallery_template'][0];

						if ( ! empty( $gallery_password ) ) {
							
							if ( ! isset( $_SESSION['gallery_page_' . $id] ) OR empty( $_SESSION['gallery_page_' . $id] ) ) {
								get_template_part( 'templates/template_password' );
								exit;
							}
						}
					?>

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="meta-wrapper">
							<?php
								$single_meta = anva_get_option( 'single_meta' );
								if ( 1 == $single_meta ) :
									anva_posted_on();
								endif;
							?>
						</div>
					</header><!-- .entry-header (end) -->
					
					<div class="entry-content">
						<?php the_content(); ?>
						<div class="clearfix"></div>

						<?php
							switch( $gallery_template ) :
								case 'Gallery 1 Column':
									get_template_part( 'templates/template_gallery-1' );
									break;
								case 'Gallery 2 Columns':
									get_template_part( 'templates/template_gallery-2' );
									break;		
								case 'Gallery 3 Columns':
									get_template_part( 'templates/template_gallery-3' );
									break;
								case 'Gallery 4 Columns':
									get_template_part( 'templates/template_gallery-4' );
									break;
								default:
									get_template_part( 'templates/template_gallery-1' );
									break;
							endswitch;
						?>
						<div class="clearfix"></div>
					</div><!-- .entry-content (end) -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- .article-container (end) -->
		
		<?php anva_post_after(); ?>

			<?php
				$single_comment = anva_get_option( 'single_comment' );
				if ( 1 == $single_comment ) :
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				endif;
			?>

		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>