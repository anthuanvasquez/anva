<?php

/*
 * IE browser warning
 */
function anva_ie_browser_message() {
	?>
	<!--[if lt IE 9]>
		<p class="alert alert-warning browsehappy"><?php printf( anva_get_local( 'browsehappy' ), esc_url( 'http://browsehappy.com/' ) ); ?></p>
	<![endif]-->
	<?php
}

/*
 * Display default header logo 
 */
function anva_header_logo_default() {
	$logo 	= anva_get_option('logo');
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
function anva_main_navigation_default() {
	?>
	<a href="#" id="mobile-toggle" class="mobile-toggle" data-toggle="tooltip" data-placement="right" title="<?php echo anva_get_local( 'menu' ); ?>">
		<i class="fa fa-bars"></i>
		<span class="sr-only"><?php echo anva_get_local( 'menu' ); ?></span>
	</a>

	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav id="navigation" class="navigation clearfix" role="navigation">
			<?php
				wp_nav_menu( apply_filters( 'anva_main_navigation_default', array( 
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
		<div class="well well-sm"><?php echo anva_get_local( 'menu_message' ); ?></div>
	<?php endif;
}

/*
 * Display social media icons
 */
function anva_social_icons() {
	$class = 'normal';
	$size = 24;
	printf(
		'<ul class="social-media social-style-%2$s social-icon-%3$s">%1$s</ul>',
		anva_social_media(),
		apply_filters( 'anva_social_media_style', $class ),
		apply_filters( 'anva_social_media_size', $size )
	);
}

/*
 * Print favion and apple touch icons in head
 */
function anva_apple_touch_icon() {
	$image_path = get_template_directory_uri() . '/assets/images';
	?>
	<!-- ICONS (start) -->
	<link rel="shortcut icon" href="<?php echo $image_path . '/favicon.png'; ?>" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $image_path . '/apple-touch-icon-76x76.png'; ?>" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $image_path . '/apple-touch-icon-120x120.png'; ?>" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $image_path . '/apple-touch-icon-152x152.png'; ?>" />
	<!-- ICONS (end) -->
	<?php
}

/*
 * Print meta viewport
 */
function anva_viewport() {
	if ( 1 == anva_get_option( 'responsive' ) ) :
	?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	endif;
}

/*
 * Print custom css styles in head
 */
function anva_custom_css() {
	$styles = '';
	$custom_css = anva_get_option( 'custom_css' );
	$custom_css = anva_compress( $custom_css );
	if ( ! empty( $custom_css ) ) {
		$styles = '<style type="text/css">' . $custom_css . '</style>';
	}
	echo $styles; 
}

/*
 * Display footer widgets
 */
function anva_footer_widget() {
	?>
	<div class="footer-widget">
		<div class="grid-columns">
			<?php if ( ! dynamic_sidebar( 'footer' ) ) : endif; ?>
		</div>
	</div>
	<?php
}

/*
 * Display default footer text copyright
 */
function anva_footer_text_default() {
	printf(
		'<p>&copy; %1$s <strong>%2$s</strong> %3$s %4$s %5$s. <a id="gotop" href="#"><i class="fa fa-chevron-up"></i><span class="sr-only">Go Top</span></a></p>',
		anva_get_current_year( apply_filters( 'anva_footer_year', date( 'Y' ) ) ),
		get_bloginfo( 'name' ),
		anva_get_local( 'footer_copyright' ),
		apply_filters( 'anva_footer_credits', anva_get_local( 'footer_text' ) ),
		apply_filters( 'anva_footer_author', '<a href="'. esc_url( 'http://anthuanvasquez.net/') .'">Anthuan Vasquez</a>' )
	);
}

/*
 * Wrapper start
 */
function anva_layout_before_default() {
	?>
	<div id="wrapper">
	<?php
}

/*
 * Wrapper end
 */
function anva_layout_after_default() {
	?>
	</div><!-- #wrapper (end) -->
	<?php
}

/*
 * Display breadcrumbs
 */
function anva_breadcrumbs() {
	$single_breadcrumb = anva_get_option( 'single_breadcrumb' );
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
function anva_content_before_default() {
	?>
	<div id="sidebar-layout">
		<div class="sidebar-layout-inner">
	<?php
}

/*
 * Wrapper main content end
 */
function anva_content_after_default() {
	?>
			</div><!-- .sidebar-layout-inner (end) -->
	</div><!-- #sidebar-layout (end) -->
	<?php
}

/*
 * Display sidebars location before
 */
function anva_sidebar_layout_before_default() {
	if ( is_page() ) {
		
		$sidebar = anva_get_post_meta( '_sidebar_column' );
		
		// One sidebar
		if ( 'left' == $sidebar ) {
			anva_sidebars( 'left', '4' );

		// Two sidebar
		} elseif( 'double' == $sidebar ) {
			anva_sidebars( 'left', '3' );

		// Two sidebar left
		} elseif ( 'double_left' == $sidebar ) {
			anva_sidebars( 'left', '3' );
			anva_sidebars( 'right', '3' );
		}
	}
}

/*
 * Display sidebars location after
 */
function anva_sidebar_layout_after_default() {
	if ( is_page() ) {
		
		$sidebar = anva_get_post_meta( '_sidebar_column' );
		
		// One sidebar
		if ( 'right' == $sidebar ) {
			anva_sidebars( 'right', '4' );

		// Two sidebar
		} elseif ( 'double' == $sidebar ) {
			anva_sidebars( 'right', '3' );

		// Two sidebar right
		} elseif ( 'double_right' == $sidebar ) {
			anva_sidebars( 'left', '3' );
			anva_sidebars( 'right', '3' );
		}
	}
}

/*
 * Change navigation
 */
function anva_navigation() {
	$nav = anva_get_option( 'navigation' );
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
 * and current user caen adminsitrator 
 */
function anva_debug_queries() {
	if ( true == WP_DEBUG && current_user_can( 'administrator' ) ) :
	?>
		<div class="alert alert-warning text-center">Page generated in <?php timer_stop(1); ?> seconds with <?php echo get_num_queries(); ?> database queries.</div>
	<?php
	endif;
}