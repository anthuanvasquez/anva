<?php
/**
 * The template for displaying the header.
 *
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php anva_wp_head(); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<!-- @temp -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
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

<?php anva_before(); ?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">
		
	<?php anva_top_before(); ?>

	<?php anva_header_above(); ?>

	<!-- HEADER (start) -->
	<header id="header" <?php anva_header_class(); ?>>
		<div id="header-wrap">
			<div class="container clearfix">
				<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
				<?php anva_header_logo(); ?>
				<?php anva_header_primary_menu(); ?>
			</div>
		</div><!-- .header-wrap (end) -->
	</header><!-- HEADER (end) -->

	<?php
		// Below Header
		anva_header_below();

		// After Top
		anva_top_after();

		// Featured
		anva_featured_before();
		anva_featured();
		anva_featured_after();
	?>
	
	<?php anva_content_before(); ?>

	<!-- CONTENT (start) -->
	<section id="content">
		<div class="content-wrap">
			<?php anva_above_layout(); ?>