<?php
/**
 * The template file for single portfolio items.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */

get_header();

$author = anva_get_post_meta( '_anva_author' );
$date   = anva_get_post_meta( '_anva_date' );
$client = anva_get_post_meta( '_anva_client' );
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php anva_column_class( 'content' ); ?>">
		<div id="portfolio">

			<?php do_action( 'anva_posts_content_before' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="entry-wrap">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry clearfix' ); ?>>

						<?php // anva_the_post_thumbnail( anva_get_option( 'single_thumb' ) ); ?>

						<div class="portfolio-single-content col_three_fifth nobottommargin">
							<div class="portfolio-gallery">
								<?php
									$display_gallery = get_post_meta( $post->ID, '_anva_gallery', true );
									if ( $display_gallery ) {

										$id               = get_the_ID();
										$gallery_template = anva_get_post_meta( '_anva_gallery_template' );
										$templates        = anva_gallery_templates();

										if ( empty( $gallery_template ) ) {
											$gallery_template = anva_get_option( 'gallery_template' );
										}

										if ( isset( $templates[$gallery_template]['id'] ) && $gallery_template == $templates[$gallery_template]['id'] ) {
											$columns = $templates[$gallery_template]['layout']['col'];
											$size    = $templates[$gallery_template]['layout']['size'];
											anva_gallery_masonry( $id, $columns, $size );
										}
									}
								?>
							</div>

							<div class="portfolio-video">
								<?php
									$output = '';
									$display_video = anva_get_post_meta( '_anva_video' );

									if ( $display_video ) {
										$embed = anva_get_post_meta( '_anva_video_embed' );

										if ( $embed ) {
											$output .= html_entity_decode( esc_html( $embed ) );
										} else {
											$poster = anva_get_post_meta( '_anva_video_image' );
											$m4v    = anva_get_post_meta( '_anva_video_m4v' );
											$ogv    = anva_get_post_meta( '_anva_video_ogv' );
											$mp4    = anva_get_post_meta( '_anva_video_mp4' );

											$attr   = array(
												'poster' => $poster,
												'm4v'    => $m4v,
												'ogv'    => $ogv,
												'mp4'    => $mp4
											);

											$output .= wp_video_shortcode( $attr );
										}
									}
									echo $output;
								?>
							</div>

							<div class="portfolio-audio">
								<?php
								$output = '';
								$display_audio = get_post_meta( $post->ID, '_anva_audio', true );

								if ( $display_audio ) {
									$poster = get_post_meta( $post->ID, '_anva_audio_image', true );

									if ( $poster ) {
										$output .= sprintf( '<img src="%1$s" alt="" />', esc_url( $poster ) );
									}

									$mp3 = get_post_meta( $post->ID, '_anva_audio_mp3', true );
									$ogg = get_post_meta( $post->ID, '_anva_audio_ogg', true );
									$attr = array(
										'mp3' => $mp3,
										'ogg' => $ogg
									);
									$output .= wp_audio_shortcode($attr);
								}
								echo $output;
								?>
							</div>

							<div class="fancy-title title-dotted-border">
								<h2><?php _e( 'Project', 'anva' ); ?></h2>
							</div>

							<?php the_content(); ?>

						</div><!-- .portfolio-single-content (end) -->

						<div class="col_two_fifth col_last nobottommargin">
							<div class="panel panel-default events-meta">
								<div class="panel-body">
									<ul class="portfolio-meta nobottommargin">
										<li><span><i class="icon-user"></i> Created by:</span> <?php anva_the_post_meta( '_anva_author' ); ?></li>
										<li><span><i class="icon-calendar"></i> Completed on:</span> <?php anva_the_post_meta( '_anva_date' ); ?></li>
										<?php if ( anva_get_terms_links( 'portfolio_skill' ) ) : ?>
                                            <li><span><i class="icon-lightbulb"></i> Skills:</span> <?php anva_the_terms_links( 'portfolio_skill', ' / ' ); ?></li>
										<?php endif; ?>
                                        <li><span><i class="icon-link"></i> Client:</span> <a href="<?php anva_the_post_meta( '_anva_client_url' ); ?>"><?php anva_the_post_meta( '_anva_client' ); ?></a></li>
									</ul>
								</div>
							</div>
							<?php anva_post_share(); ?>
						</div>

						<div class="clear"></div>
						<div class="divider divider-center"><i class="icon-circle"></i></div>

					</article><!-- #post-<?php the_ID(); ?> -->
				</div><!-- .entry-wrap (end) -->

				<?php do_action( 'anva_posts_comments' ); ?>

			<?php endwhile; ?>

			<?php do_action( 'anva_posts_content_after' ); ?>

		</div><!-- #portfolio (end) -->
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>
