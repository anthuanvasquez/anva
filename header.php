<?php
/**
 * The template for displaying the header.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php anva_before(); ?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">

<!-- CONTAINER (start) -->
<div id="container">
	
	<?php anva_top_before(); ?>

	<!-- TOP (start) -->
	<div id="top">

		<?php anva_header_above(); ?>

		<header id="header">
			<div class="header-content">	
				<div class="container clearfix">
					<?php anva_header_logo(); ?>
					<?php anva_header_extras(); ?>
				</div><!-- .header-content (end) -->
			</div><!-- .container (end) -->
			
			<?php anva_header_primary_menu(); ?>

		</header><!-- #header (end) -->

		<?php anva_header_below(); ?>

	</div><!-- TOP (end) -->

	<?php
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
		<div class="main-content">
			<div class="container clearfix">
				<?php anva_above_layout(); ?>
					<?php anva_breadcrumbs(); ?>