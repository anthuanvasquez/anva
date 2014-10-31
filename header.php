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
	
	<a href="#" id="off-canvas-button" class="toggle-button">
		<i class="fa fa-bars"></i>
		<span class="screen-reader-text"><?php echo tm_get_local( 'menu' ); ?></span>
	</a>
	
	<header id="header">
		<div class="header-inner inner">
			
			<div class="header-top group">				
				<div id="brand" class="brand">
					<?php tm_header_logo(); ?>
				</div>

				<div id="addon" class="addon">
					<?php tm_header_addon(); ?>
				</div>
			</div><!-- .header-top (end) -->
			
			<div class="header-bottom">
				
				<div class="mobile-navigation">
					<a href="#" id="mobile-navigation" class="toggle-button">
						<i class="fa fa-bars"></i>
						<span class="screen-reader-text"><?php echo tm_get_local( 'menu' ); ?></span>
					</a>
				</div>

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
			</div><!-- .header-bottom (end) -->
		</div><!-- .header-inner (end) -->
	</header><!-- #header (end) -->
	
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

	<?php tm_content_before(); ?>