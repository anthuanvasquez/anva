<?php
/**
 * The template for displaying footer content.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @link       https://anthuanvasquez.net
 *
 * @package    AnvaFramework
 * @subpackage Anva
 * @version    1.0.0
 * @since      1.0.0
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hooked.
 *
 * @see anva_below_layout_default, nva_sidebar_below_content
 */
do_action( 'anva_below_layout' );
?>

		</div><!-- .content-wrap (end) -->
	</section><!-- CONTENT (end) -->

	<?php
		/**
		 * Hooked.
		 *
		 * @see anva_post_reading_bar
		 */
		do_action( 'anva_content_after' );

		/**
		 * Footer above not hooked by defaulr.
		 */
		do_action( 'anva_footer_above' );

		$footer_color = anva_get_option( 'footer_color', 'dark' );
		$classes      = array();
		$attrs        = array();
		$classes[]    = 'site-footer';

		if ( $footer_color ) {
			$classes[] = $footer_color;
		}

		$attrs['class'] = implode( ' ', $classes );
	?>

	<!-- FOOTER (start) -->
	<footer <?php anva_attr( 'footer', $attrs ); ?>>

		<div class="container clearfix">
			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_footer_content_default
				 */
				do_action( 'anva_footer_content' );
			?>
		</div><!-- .container (end) -->

		<?php
			/**
			 * Hooked.
			 *
			 * @see anva_footer_copyrights_default
			 */
			do_action( 'anva_footer_copyrights' );
		?>

	</footer><!-- FOOTER (end) -->

	<?php
		/**
		 * Hooked.
		 *
		 * @see anva_sidebar_below_footer
		 */
		do_action( 'anva_footer_below' );
	?>

</div><!-- WRAPPER (end) -->

<?php
	/**
	 * Hooked.
	 *
	 * @see anva_debug
	 */
	do_action( 'anva_after' );

	/**
	 * Required hooked by WordPress.
	 */
	wp_footer();

	/**
	 * Footer after not hooked by defaulr.
	 */
	do_action( 'anva_footer_after' ); ?>
</body>
</html>
