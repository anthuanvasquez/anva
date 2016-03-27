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
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php do_action( 'anva_wp_head' ); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<?php
	$data = '';
	$classes = '';
	$loader = anva_get_option( 'page_loader', 1 );
	$color = anva_get_option( 'page_loader_color', 1 );
	$timeout = anva_get_option( 'page_loader_timeout', 1000 );
	$speed_in = anva_get_option( 'page_loader_speed_in', 800 );
	$speed_out = anva_get_option( 'page_loader_speed_out', 800 );
	$animation_in = anva_get_option( 'page_loader_animation_in', 'fadeIn' );
	$animation_out = anva_get_option( 'page_loader_animation_out', 'fadeOut' );
	$html = anva_get_option( 'page_loader_html' );

	if ( ! $loader ) {
		$classes = 'no-transition';
	}

	if ( $loader ) {
		$data .= 'data-loader="' . esc_attr( $loader ) . '"';
		$data .= 'data-loader-color="' . esc_attr( $color ) . '"';
		$data .= 'data-loader-timeout="' . esc_attr( $timeout ) . '"';
		$data .= 'data-speed-in="' . esc_attr( $speed_in ) . '"';
		$data .= 'data-speed-out="' . esc_attr( $speed_out ) . '"';
		$data .= 'data-animation-in="' . esc_attr( $animation_in ) . '"';
		$data .= 'data-animation-out="' . esc_attr( $animation_out ) . '"';
		
		if ( $html ) {
			$data .= 'data-loader-html="' . esc_attr( $html ) . '"';
		}
	}
?>

<body <?php echo $data; ?><?php body_class( $classes ); ?>>

<?php do_action( 'anva_before' ); ?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">
		
	<?php do_action( 'anva_top_before' ); ?>

	<?php do_action( 'anva_header_above' ); ?>

	<!-- HEADER (start) -->
	<header id="header" <?php anva_header_class(); ?>>
		<div id="header-wrap">
			<div class="container clearfix">
				<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
				<?php do_action( 'anva_header_logo' ); ?>
				<?php do_action( 'anva_header_extras' ); ?>
				<?php do_action( 'anva_header_primary_menu' ); ?>
			</div>
		</div><!-- .header-wrap (end) -->
	</header><!-- HEADER (end) -->
	
	<?php
		// Below Header
		do_action( 'anva_header_below' );

		// After Top
		do_action( 'anva_top_after' );

		// Featured
		do_action( 'anva_featured_before' );
		do_action( 'anva_featured' );
		do_action( 'anva_featured_after' );
		
		// Content Before
		do_action( 'anva_content_before' );
	?>

	<!-- CONTENT (start) -->
	<section id="content">
		<div class="content-wrap">
			<?php do_action( 'anva_above_layout' ); ?>