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
			<?php _e( 'Share this Post:', 'anva' ); ?>
		</span>
		<div class="si-share-inner">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $url ); ?>&t=<?php echo esc_attr( $title ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="<?php _e( 'Share on Facebook', 'anva' ); ?>" class="social-icon si-borderless si-facebook">
				<i class="icon-facebook"></i>
				<i class="icon-facebook"></i>
			</a>
			<a href="https://twitter.com/share?url=<?php echo esc_url( $url ); ?>&via=<?php echo $twitter; ?>&text=<?php echo esc_attr( $title ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="<?php _e( 'Share on Twitter', 'anva' ); ?>" class="social-icon si-borderless si-twitter">
				<i class="icon-twitter"></i>
				<i class="icon-twitter"></i>
			</a>
			<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( $url ); ?>&media=<?php echo esc_url( $thumbnail_url ); ?>&description=<?php echo esc_attr( $title ); ?>" target="_blank" class="social-icon si-borderless si-pinterest">
				<i class="icon-pinterest"></i>
				<i class="icon-pinterest"></i>
			</a>
			<a href="https://plus.google.com/share?url=<?php echo esc_url( $url ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;" target="_blank" title="<?php _e( 'Share on Google+', 'anva' ); ?>" class="social-icon si-borderless si-gplus">
				<i class="icon-gplus"></i>
				<i class="icon-gplus"></i>
			</a>
			<a href="<?php echo get_feed_link( 'rss2' ); ?>" class="social-icon si-borderless si-rss">
				<i class="icon-rss"></i>
				<i class="icon-rss"></i>
			</a>
			<a href="#" class="social-icon si-borderless si-email3">
				<i class="icon-email3"></i>
				<i class="icon-email3"></i>
			</a>
		</div><!-- .si-share-inner (end) -->
	</div><!-- .si-share (end) -->

	</div><!-- .si-share-wrap (end) -->
