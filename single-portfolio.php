<?php
/**
 * The template file for single portfolio.
 * 
 * @version 1.0.0
 */

get_header();
?>

<div class="row grid-columns">

	<?php get_sidebar( 'left' ); ?>
	
	<div class="content-area <?php echo anva_get_column_class( 'content' ); ?>">
		<div id="posts">
			<?php anva_posts_content_before(); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="article-wrapper">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-title">
							<h1><?php the_title(); ?></h1>
						</div><!-- .entry-title (end) -->
						
						<?php anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>

							<?php
								// Get galleries
								if ( is_singular( 'portfolio' ) ) :
									$gallery = anva_get_gallery_field();
									var_dump($gallery);
								endif;
							?>
						
						<div class="entry-content portfolio-single-content row clearfix">
							
							<div class="col-sm-7">
								<div class="portfolio-title">
									<h2><?php _e( 'Project', 'anva' ); ?></h2>
								</div>
								<?php the_content(); ?>
							</div>

							<div class="col-sm-5">
								<div class="panel panel-default">
									<div class="panel-body">
										<ul class="portfolio-meta nobottommargin">
											<li><span><i class="fa fa-user"></i> Created by:</span> <?php anva_the_field( 'author' ); ?></li>
											<li><span><i class="fa fa-calendar"></i> Completed on:</span> <?php anva_the_field( 'date' ); ?></li>
											<li><span><i class="fa fa-lightbulb-o"></i> Skills:</span> HTML5 / PHP / CSS3</li>
											<li><span><i class="fa fa-link"></i> Client:</span> <a href="<?php echo esc_url( anva_get_field( 'client_url' ) ); ?>"><?php anva_the_field( 'client' ); ?></a></li>
										</ul>
									</div>
								</div>
							</div>

						</div><!-- .entry-content (end) -->
					</article><!-- #post-<?php the_ID(); ?> -->

				</div><!-- .article-wrapper (end) -->
				<?php anva_posts_comments(); ?>
			<?php endwhile; ?>
			<?php anva_posts_content_after(); ?>
		</div><!-- #posts (end) -->
	</div><!-- .content-area (end) -->
	
	<?php get_sidebar( 'right' ); ?>

</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>