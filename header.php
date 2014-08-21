<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<?php
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) )
		header( 'X-UA-Compatible: IE=edge,chrome=1' );
	?>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php tm_layout_before(); ?>

<div id="off-canvas" class="off-canvas-navigation">	
	<div  class="off-canva-left">
	<?php
		if( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 
				'theme_location'  => 'primary',
				'container'       => 'div',
				'container_class' => 'navigation-container',
				'container_id'    => '',
				'menu_class'      => 'navigation-menu',
				'menu_id'         => '',
				'echo'            => true,
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
			);
		}
	?>
	</div>
</div>
				
<div id="container" class="container">
	
	<a href="#" id="off-canvas-button" class="toggle-button">
		<i class="fa fa-bars"></i>
		<span class="screen-reader-text"><?php echo tm_get_local( 'menu' ); ?></span>
	</a>
	
	<header id="header" class="header-container" role="banner">
		<div class="site-header">
			<div class="header-top group">				
				<div class="site-branding">
					<?php tm_header_logo(); ?>
				</div>

				<div class="site-addon">
					<?php tm_header_addon(); ?>
				</div>
			</div>
			
			<div class="header-bottom">
				
				<div class="mobile-navigation">
					<a href="#" id="mobile-navigation" class="toggle-button">
						<i class="fa fa-bars"></i>
						<span class="screen-reader-text"><?php echo tm_get_local( 'menu' ); ?></span>
					</a>
				</div>

				<nav id="primary-nav" class="site-navigation horizontal-navigation group" role="navigation">
					<?php
						if( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array( 
								'theme_location'  => 'primary',
								'container'       => 'div',
								'container_class' => 'navigation-container',
								'container_id'    => '',
								'menu_class'      => 'navigation-menu',
								'menu_id'         => '',
								'echo'            => true,
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
							);
						} else {
							echo tm_get_local( 'menu_nav_off' );
						}
					?>
				</nav>
				
			</div>
		</div><!-- .site-header (end) -->
	</header><!-- #header (end) -->
	
	<?php if ( is_front_page() ) : ?>
		<div id="featured" class="featured-container">
			<div class="featured-inner">
				<?php
					if ( function_exists( 'flexslider_rotator' ) ) {
						echo flexslider_rotator( 'homepage' );
					}
				?>
			</div><!-- .featured-inner (end) -->
		</div><!-- #featured (end) -->
	<?php endif; ?>

	<div id="content" class="content-container">
		<div class="site-content">