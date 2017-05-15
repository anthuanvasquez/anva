<?php
/**
 * The default template used for posts share buttons.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

?>
<div class="si-share-wrap">
	<?php
	$url           = get_permalink();
	$title         = get_the_title();
	$thumbnail_url = anva_get_featured_image_src( get_the_ID(), 'medium' );
	$social_icons  = anva_get_option( 'social_icons_profiles' );
	$twitter       = '';

	if ( isset( $social_icons['twitter'] ) ) {
		$twitter = str_replace( 'http://twitter.com/', '', $social_icons['twitter'] );
		$twitter = str_replace( 'https://twitter.com/', '', $twitter );
	}
	?>
	<div class="clear"></div>

	<div class="si-share noborder clearfix">
		<span>
			<?php esc_html_e( 'Share this Post:', 'anva' ); ?>
		</span>
		<div class="si-share-inner">
			<button type="button" class="si-share-button social-icon si-borderless si-facebook" data-network="facebook" data-url="<?php echo esc_url( $url ); ?>" title="<?php esc_html_e( 'Share on Facebook', 'anva' ); ?>">
				<i class="icon-facebook"></i>
				<i class="icon-facebook"></i>
			</button>
			<button type="button" class="si-share-button social-icon si-borderless si-twitter" data-network="twitter" data-url="<?php echo esc_url( $url ); ?>" data-via="<?php echo esc_attr( $twitter ); ?>" data-text="<?php echo esc_attr( $title ); ?>" data-sbg-hashtags="#" title="<?php esc_html_e( 'Share on Twitter', 'anva' ); ?>">
				<i class="icon-twitter"></i>
				<i class="icon-twitter"></i>
			</button>
			<button tpye="button" class="si-share-button social-icon si-borderless si-pinterest" data-network="pinterest" data-url="<?php echo esc_url( $url ); ?>" data-media="<?php echo esc_url( $thumbnail_url ); ?>" data-description="<?php echo esc_attr( $title ); ?>" title="<?php esc_html_e( 'Share on Pinterest', 'anva' ); ?>">
				<i class="icon-pinterest"></i>
				<i class="icon-pinterest"></i>
			</button>
			<button type="button" class="si-share-button social-icon si-borderless si-gplus" data-network="googleplus" data-url="<?php echo esc_url( $url ); ?>" data-media="<?php echo esc_url( $thumbnail_url ); ?>" data-description="<?php echo esc_attr( $title ); ?>" title="<?php esc_html_e( 'Share on Google+', 'anva' ); ?>">
				<i class="icon-gplus"></i>
				<i class="icon-gplus"></i>
			</button>
			<button type="button" class="si-share-button social-icon si-borderless si-rss" data-network="rss" data-url="<?php echo esc_url( get_feed_link( 'rss2' ) ); ?>">
				<i class="icon-rss"></i>
				<i class="icon-rss"></i>
			</button>
			<button type="button" class="si-share-button social-icon si-borderless si-email3" data-network="email" data-url="#">
				<i class="icon-email3"></i>
				<i class="icon-email3"></i>
			</button>
		</div><!-- .si-share-inner (end) -->
	</div><!-- .si-share (end) -->
</div><!-- .si-share-wrap (end) -->
