<?php
/**
 * The template file for header.
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

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php
		/**
		 * Head not hooked by default.
		 */
		do_action( 'anva_wp_head' );
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php
		/**
		 * Required hooked by WordPress.
		 */
		wp_head();
	?>
</head>

<body <?php body_class(); ?> <?php anva_page_transition_data(); ?>>

<?php
	/**
	 * Before layout not hooked by default.
	 */
	do_action( 'anva_before' );
?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">

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
	<header id="header" <?php anva_header_class( 'header' ); ?>>
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
	<section id="content">
		<div class="content-wrap">
			<?php
				/**
				 * Hooked.
				 *
				 * @see anva_sidebar_above_content, anva_above_layout_default
				 */
				do_action( 'anva_above_layout' );
			?>
