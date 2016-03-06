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
						
						<?php // anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>
						
						<div class="entry-content portfolio-single-content row clearfix">

							<div class="col-sm-12 portfolio-gallery">
							<?php
								$display_gallery = get_post_meta( $post->ID, '_tzp_display_gallery', true );
								if ( $display_gallery ) {

									$id 							= get_the_ID();
									$gallery_template = anva_get_field( 'gallery_template' );
									$templates				= anva_gallery_templates();

									if ( empty( $gallery_template ) ) {
										$gallery_template = anva_get_option( 'gallery_template' );
									}

									if ( isset( $templates[$gallery_template]['id'] ) && $gallery_template == $templates[$gallery_template]['id'] ) {
										$columns = $templates[$gallery_template]['layout']['col'];
										$size = $templates[$gallery_template]['layout']['size'];
										echo anva_gallery_grid( $id, $columns, $size );
									}
								}
							?>
							</div>

							<div class="col-sm-12 portfolio-video">
								<?php
									$output = '';
									$display_video = get_post_meta( $post->ID, '_tzp_display_video', true );
									if ( $display_video ) {
									$embed = get_post_meta( $post->ID, '_tzp_video_embed', true );

									if ( $embed ) {
										$output .= html_entity_decode( esc_html( $embed ) );
									} else {
										$poster = get_post_meta( $post->ID, '_tzp_video_poster_url', true );
										$m4v = get_post_meta( $post->ID, '_tzp_video_file_m4v', true );
										$ogv = get_post_meta( $post->ID, '_tzp_video_file_ogv', true );
										$mp4 = get_post_meta( $post->ID, '_tzp_video_file_mp4', true );
										$attr = array(
											'poster' => $poster,
											'm4v' => $m4v,
											'ogv' => $ogv,
											'mp4' => $mp4
										);
										$output .= wp_video_shortcode( $attr );
									}
								}
								echo $output;
								?>
							</div>
							
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
								<div class="portfolio-audio">
									<?php
									$output = '';
									$display_audio = get_post_meta( $post->ID, '_tzp_display_audio', true );
									if ( $display_audio ) {
										$poster = get_post_meta( $post->ID, '_tzp_audio_poster_url', true );
										
										if ( $poster ) {
											$output .= sprintf( '<img src="%1$s" alt="" />', esc_url( $poster ) );
										}

										$mp3 = get_post_meta( $post->ID, '_tzp_audio_file_mp3', true );
										$ogg = get_post_meta( $post->ID, '_tzp_audio_file_ogg', true );
										$attr = array(
											'mp3' => $mp3,
											'ogg' => $ogg
										);
										$output .= wp_audio_shortcode($attr);
									}
									echo $output;
									?>
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