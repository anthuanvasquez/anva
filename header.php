<?php
/**
 * The template for displaying header.
 *
 * This is the template that displays all of the <head> section
 * and everything up until <div id="content">.
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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php anva_attr( 'head' ); ?>>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php
		/**
		 * Head not hooked by default.
		 */
		do_action( 'anva_wp_head' );
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
		/**
		 * Required hooked by WordPress.
		 */
		wp_head();
	?>
</head>

<body <?php anva_attr( 'body' ); ?>>

<?php
	/**
	 * Before layout not hooked by default.
	 */
	do_action( 'anva_before' );
?>

<!-- WRAPPER (start) -->
<div <?php anva_attr( 'wrapper' ); ?>>

	<?php
		/**
		 * Top before not hooked by default.
		 */
		do_action( 'anva_top_before' );

		/**
		 * Hooked.
		 *
		 * @see anva_top_bar_default, anva_sidebar_above_header
		 */
		do_action( 'anva_header_above' );
	?>

	<!-- HEADER (start) -->
	<header <?php anva_attr( 'header' ); ?>>
		<?php
			/**
			 * Hooked.
			 *
			 * @see anva_header_default
			 */
			do_action( 'anva_header' );
		?>
	</header><!-- HEADER (end) -->

	<?php
		/**
		 * Header below not hooked by default.
		 */
		do_action( 'anva_header_below' );

		/**
		 * After top not hooked by default.
		 */
		do_action( 'anva_top_after' );

		/**
		 * Hooked.
		 *
		 * @see anva_featured_before_default
		 */
		do_action( 'anva_featured_before' );

		/**
		 * Hooked.
		 *
		 * @see anva_featured_default
		 */
		do_action( 'anva_featured' );

		/**
		 * Hooked.
		 *
		 * @see anva_featured_after_default
		 */
		do_action( 'anva_featured_after' );

		/**
		 * Hooked.
		 *
		 * @see anva_page_title_default
		 */
		do_action( 'anva_content_before' );
	?>

	<!-- CONTENT (start) -->
	<section <?php anva_attr( 'content' ); ?>>
		<div class="content-wrap">
			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_sidebar_above_content, anva_above_layout_default
				 */
				do_action( 'anva_above_layout' );
