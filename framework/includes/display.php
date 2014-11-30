<?php

/*
 * IE browser warning
 */
function tm_ie_browser_message() {
	?>
	<!--[if lt IE 9]>
		<p class="alert alert-warning browsehappy"><?php printf( tm_get_local( 'browsehappy' ), esc_url( 'http://browsehappy.com/' ) ); ?></p>
	<![endif]-->
	<?php
}

/*
 * Display default header logo 
 */
function tm_header_logo_default() {
	$logo 	= tm_get_option('logo');
	$image 	= get_template_directory_uri() . '/assets/images/logo.png';
	$name 	= get_bloginfo( 'name' );
	?>
	<a id="logo" class="logo" href="<?php echo home_url(); ?>" title="<?php echo $name; ?>">
		<?php
			printf(
				'<img src="%1$s" alt="%2$s" /><span class="sr-only">%2$s</span>',
				( empty( $logo ) ? esc_url( $image ) : esc_url( $logo ) ),
				get_bloginfo( 'name' )
			);
		?>
	</a>
	<?php
}

/*
 * Display default main navigation
 */
function tm_main_navigation_default() {
	?>
	<a href="#" id="mobile-toggle" class="mobile-toggle">
		<i class="fa fa-bars"></i>
		<span class="sr-only"><?php echo tm_get_local( 'menu' ); ?></span>
	</a>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav id="navigation" class="navigation clearfix" role="navigation">
			<?php
				wp_nav_menu( apply_filters( 'tm_main_navigation_default', array( 
					'theme_location'  => 'primary',
					'container'       => 'div',
					'container_class' => 'navigation-inner',
					'container_id'    => 'primary',
					'menu_class'      => 'navigation-menu sf-menu clearfix',
					'menu_id'         => 'primary-menu',
					'echo'            => true,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
				));
			?>
		</nav><!-- #main-navigation (end) -->
	<?php else : ?>
		<div class="well well-sm"><?php echo tm_get_local( 'menu_message' ); ?></div>
	<?php endif;
}

/*
 * Display social media icons
 */
function tm_social_icons() {
	$class = 'normal';
	printf(
		'<ul class="social-media social-style-%2$s social-icon-24">%1$s</ul>',
		tm_social_media(),
		apply_filters( 'tm_social_media_style', $class )
	);
}

/*
 * Print favion and apple touch icons in head
 */
function tm_apple_touch_icon() {
	$image_path = get_template_directory_uri() . '/assets/images';
	?>
	<!-- ICONS START -->
	<link rel="shortcut icon" href="<?php echo $image_path . '/favicon.png'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo $image_path . '/apple-touch-icon.png'; ?>" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $image_path . '/apple-touch-icon-72x72.png'; ?>" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $image_path . '/apple-touch-icon-114x114.png'; ?>" />
	<!-- ICONS (end) -->
	<?php
}

/*
 * Print custom css styles in head
 */
function tm_custom_css() {
	$styles = '';
	$custom_css = tm_get_option( 'custom_css' );
	$custom_css = tm_compress( $custom_css );
	if ( ! empty( $custom_css ) ) {
		$styles = '<style type="text/css">' . $custom_css . '</style>';
	}
	
	echo $styles; 
}

/*
 * Display default footer text copyright
 */
function tm_footer_text_default() {
	printf(
		'<p>&copy; %s <strong>%s</strong> %s %s %s <a id="gotop" href="#"><i class="fa fa-chevron-up"></i><span class="sr-only">Go Top</span></a></p>',
		tm_get_current_year( apply_filters( 'tm_footer_year', date( 'Y' ) ) ),
		get_bloginfo( 'name' ),
		tm_get_local( 'footer_copyright' ),
		tm_get_local( 'footer_text' ),
		apply_filters( 'tm_footer_author', '<a href="'. esc_url( 'http://3mentes.com/') .'">3 Mentes</a>.' )
	);
}

/*
 * Wrapper start
 */
function tm_layout_before_default() {
	?>
	<div id="wrapper">
	<?php
}

/*
 * Wrapper end
 */
function tm_layout_after_default() {
	?>
	</div><!-- #wrapper (end) -->
	<?php
}

/*
 * Display breadcrumbs
 */
function tm_breadcrumbs() {
	$single_breadcrumb = tm_get_option( 'single_breadcrumb' );
	if ( 1 == $single_breadcrumb ) {
		if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() && ! is_home() ) {
			?>
			<div id="breadcrumbs">
				<div class="breadcrumbs-inner">
					<div class="breadcrumbs-content">
						<?php yoast_breadcrumb( '<p>', '</p>' ); ?>
					</div><!-- breadcrumbs-content (end) -->
				</div><!-- breadcrumbs-inner (end) -->
			</div><!-- #breadcrumbs (end) -->
			<?php
		}
	}
}

/*
 * Wrapper main content start
 */
function tm_content_before_default() {
	?>
	<div id="sidebar-layout">
		<div class="sidebar-layout-inner">
	<?php
}

/*
 * Wrapper main content end
 */
function tm_content_after_default() {
	?>
			</div><!-- .sidebar-layout-inner (end) -->
	</div><!-- #sidebar-layout (end) -->
	<?php
}

/*
 * Display sidebars locations before
 */
function tm_sidebar_layout_before_default() {
	if ( is_page() ) {
		
		$sidebar = tm_get_post_meta( '_sidebar_column' );
		
		// One sidebar
		if ( 'left' == $sidebar ) {
			tm_sidebars( 'left', '4' );

		// Two sidebar
		} elseif( 'double' == $sidebar ) {
			tm_sidebars( 'left', '3' );

		// Two sidebar left
		} elseif ( 'double_left' == $sidebar ) {
			tm_sidebars( 'left', '3' );
			tm_sidebars( 'right', '3' );

		}
	}
}

/*
 * Display sidebars locations after
 */
function tm_sidebar_layout_after_default() {
	if ( is_page() ) {
		
		$sidebar = tm_get_post_meta( '_sidebar_column' );
		
		// One sidebar
		if ( 'right' == $sidebar ) {
			tm_sidebars( 'right', '4' );

		// Two sidebar
		} elseif ( 'double' == $sidebar ) {
			tm_sidebars( 'right', '3' );

		// Two sidebar right
		} elseif ( 'double_right' == $sidebar ) {
			tm_sidebars( 'left', '3' );
			tm_sidebars( 'right', '3' );

		}
	}
}

/*
 * Change navigation
 */
function tm_navigation() {	
	$nav = tm_get_option( 'navigation' );
	switch( $nav ) :
	case 'off_canvas_navigation': ?>
	<script type="text/javascript">
	jQuery(document).ready( function() {
		// Off Canvas Navigation
		var offCanvas = jQuery('#off-canvas-toggle'),
			offCanvasNav = jQuery('#off-canvas'),
			pageCanvas = jQuery('#container'),
			bodyCanvas = jQuery('body');

		bodyCanvas.addClass('js-ready');

		offCanvas.click( function(e) {
			e.preventDefault();
			offCanvasNav.toggleClass('is-active');
			pageCanvas.toggleClass('is-active');
		});

		// Hide Off Canvas Nav on Windows Resize
		jQuery(window).resize( function() {
			var off_canvas_nav_display = jQuery('#off-canvas').css('display');
			if( off_canvas_nav_display === 'block' ) {
				jQuery('#off-canvas').removeClass('is-active');
				jQuery('#container').removeClass('is-active');
			}
		});
	});
	</script>
	<?php break;
	case 'toggle_navigation': ?>
	<script type="text/javascript">
	jQuery(document).ready( function() {
		// ---------------------------------------------------------
		// Show main navigation with slidetoggle effect
		// ---------------------------------------------------------
		jQuery('#mobile-toggle').click( function(e) {
			e.preventDefault();
			jQuery('nav#navigation').slideToggle();
		});

		// ---------------------------------------------------------
		// Show main navigation if is hide
		// ---------------------------------------------------------
		jQuery(window).resize( function() {
			var nav_display = jQuery('nav#navigation').css('display');
			if( nav_display === 'none' ) {
				jQuery('nav#navigation').css('display', 'block');
			}
		});
	});
	</script>
	<?php break;
	endswitch;
}

/*
 * Display debug information if WP_DEBUG is enabled
 * and current user if adminsitrator 
 */
function tm_debug_queries() {
	if ( true == WP_DEBUG && current_user_can( 'administrator' ) ) :
	?>
		<div class="alert alert-warning text-center">Page generated in <?php timer_stop(1); ?> seconds with <?php echo get_num_queries(); ?> database queries.</div>
	<?php
	endif;
}