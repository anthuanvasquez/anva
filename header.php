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
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php anva_layout_before(); ?>

<div id="off-canvas" class="off-canvas">	
	<div  class="off-canvas-inner">
		<div class="off-canvas-content">
			<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array( 
						'theme_location'  => 'primary',
						'container'       => 'div',
						'container_class' => 'off-canvas-menu-wrapper',
						'container_id'    => '',
						'menu_class'      => 'off-canvas-menu sf-menu',
						'menu_id'         => '',
						'echo'            => true,
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
					);
				}
			?>
		</div>
	</div>
</div><!-- #off-canvas (end) -->

<!-- CONTAINER (start) -->
<div id="container">

	<a href="#" id="off-canvas-toggle" class="off-canvas-toggle">
		<i class="fa fa-bars"></i>
		<span class="sr-only"><?php echo anva_get_local( 'menu' ); ?></span>
	</a>

	<!-- TOP (start) -->
	<div id="top">
		<header id="header">
			<div class="header-inner inner">
				
				<div class="header-content">
					<div class="header-content-inner">
						
						<div class="header-content-group group">

							<div id="brand" class="brand">
								<?php anva_header_logo(); ?>
							</div><!-- #brand (end) -->

							<div id="addon" class="addon">
								<?php anva_header_addon(); ?>
							</div><!-- #addon (end) -->

						</div>

					</div><!-- .header-content-inner (end) -->
				</div><!-- .header-content (end) -->

				<?php anva_main_navigation(); ?>

			</div><!-- .header-inner (end) -->
		</header><!-- #header (end) -->
	</div><!-- TOP (end) -->
	
	<?php if ( is_front_page() ) : ?>
		<!-- FEATURED (start) -->
		<div id="featured">
			<div class="featured-inner">
				<?php
					if ( function_exists( 'anva_slideshows_featured' ) ) {
						echo anva_slideshows_featured( 'homepage' );
					}
				?>
			</div><!-- .featured-inner (end) -->
		</div><!-- FEATURED (end) -->
	<?php endif; ?>

	<!-- MAIN (start) -->
	<div id="main">
		<div class="main-inner">
			<div class="main-content">
				
				<?php anva_content_before(); ?>