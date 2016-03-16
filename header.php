<?php
/**
 * The template for displaying the header.
 *
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
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

<body <?php body_class(); ?> data-loader="1">

<?php anva_before(); ?>

<!-- WRAPPER (start) -->
<div id="wrapper" class="clearfix">
		
	<?php anva_top_before(); ?>

	<?php anva_header_above(); ?>
	
	<!-- HEADER (start) -->
	<header id="header" class="full-header">
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

	<?php if ( is_page() ) : ?>
	<!-- Page Title -->
	<section id="page-title">
		<div class="container clearfix">
			<h1><?php echo get_the_title(); ?></h1>
			<span>Page Content on the Left &amp; Sidebar on the Right</span>
			<?php anva_breadcrumbs(); ?>
		</div>
	</section><!-- #page-title end -->
	<?php endif; ?>

	<!-- CONTENT (start) -->
	<section id="content">
		<div class="content-wrap">
			<?php anva_above_layout(); ?>