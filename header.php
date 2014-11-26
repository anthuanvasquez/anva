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
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php tm_layout_before(); ?>

<div id="off-canvas" class="off-canvas-navigation">	
	<div  class="off-canvas-inner off-canva-left">
	<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 
				'theme_location'  => 'primary',
				'container'       => 'div',
				'container_class' => 'navigation-inner',
				'container_id'    => '',
				'menu_class'      => 'navigation-menu',
				'menu_id'         => '',
				'echo'            => true,
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
			);
		}
	?>
	</div><!-- .off-canvas-inner (end) -->
</div><!-- #off-canvas (end) -->
				
<div id="container">

	<div id="top">
		<header id="header">
			<div class="header-inner inner">
				
				<div class="header-content">
					<div class="header-content-inner">
						
						<div class="header-content-group group">

							<div id="brand" class="brand">
								<?php tm_header_logo(); ?>
							</div><!-- #brand (end) -->

							<div id="addon" class="addon">
								<?php tm_header_addon(); ?>
							</div><!-- #addon (end) -->

						</div>

					</div><!-- .header-content-inner (end) -->
				</div><!-- .header-content (end) -->

				<a href="#" id="mobile-navigation" class="mobile-toggle-button">
					<i class="fa fa-bars"></i>
					<span class="sr-only"><?php echo tm_get_local( 'menu' ); ?></span>
				</a>

				<nav id="main-navigation" class="main-navigation horizontal-navigation group" role="navigation">
					<?php
						if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array( 
								'theme_location'  => 'primary',
								'container'       => 'div',
								'container_class' => 'navigation-inner',
								'container_id'    => '',
								'menu_class'      => 'navigation-menu sf-menu group',
								'menu_id'         => '',
								'echo'            => true,
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
							);
						} else {
							echo tm_get_local( 'menu_message' );
						}
					?>
				</nav><!-- #main-navigation (end) -->

			</div><!-- .header-inner (end) -->
		</header><!-- #header (end) -->
	</div><!-- #top (end) -->
	
	<?php if ( is_front_page() ) : ?>
		<div id="featured">
			<div class="featured-inner inner">
				<?php
					if ( function_exists( 'tm_slideshows_slides' ) ) {
						echo tm_slideshows_slides( 'homepage' );
					}
				?>
			</div><!-- .featured-inner (end) -->
		</div><!-- #featured (end) -->
	<?php endif; ?>

	<div id="main">
		<div class="main-inner">
			<div class="main-content">
				
				<?php tm_content_before(); ?>