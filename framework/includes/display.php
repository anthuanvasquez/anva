<?php

function tm_ie_browser_message() {
	$string = tm_get_local( 'browsehappy' );
	$url = esc_url( 'http://browsehappy.com/' );
	?>
	<!--[if lt IE 9]><p class="alert alert-warning browsehappy"><?php echo sprintf( $string, $url ); ?></p><![endif]-->
	<?php
}

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

function tm_social_icons() {
	$class = apply_filters( 'tm_social_media_style', 'color' );
	echo '<ul class="social-media social-style-' . $class . '">' . tm_social_media() . '</ul>';
}

function tm_apple_touch_icon() {
	$image_path = get_template_directory_uri() . '/assets/images';
	?>
	<!-- ICONS -->
	<link rel="shortcut icon" href="<?php echo $image_path . '/favicon.png'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo $image_path . '/apple-touch-icon.png'; ?>" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $image_path . '/apple-touch-icon-72x72.png'; ?>" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $image_path . '/apple-touch-icon-114x114.png'; ?>" />
	<!-- ICONS (end) -->
	<?php
}

function tm_custom_css() {
	$styles = '';
	$custom_css = tm_get_option( 'custom_css' );
	$custom_css = tm_compress( $custom_css );
	if ( ! empty( $custom_css ) ) {
		$styles = '<style type="text/css">' . $custom_css . '</style>';
	}
	
	echo $styles; 
}

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

function tm_layout_before_default() {
	?>
	<div id="wrapper">
	<?php
}

function tm_layout_after_default() {
	?>
	</div><!-- #wrapper (end) -->
	<?php
}

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

function tm_content_before_default() {
	?>
	<div id="sidebar-layout">
		<div class="sidebar-layout-inner">
	<?php
}

function tm_content_after_default() {
	?>
			</div><!-- .sidebar-layout-inner (end) -->
	</div><!-- #sidebar-layout (end) -->
	<?php
}

function tm_sidebar_layout_before_default() {
	if ( is_page() ) {
		
		$sidebar = tm_get_post_meta('_sidebar_column');
		
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

function tm_sidebar_layout_after_default() {
	if ( is_page() ) {
		
		$sidebar = tm_get_post_meta('_sidebar_column');
		
		// One sidebar
		if ( 'right' == $sidebar ) {
			tm_sidebars( 'right', '4' );

		// Two sidebar
		} elseif ( 'double' == $sidebar ) {
			tm_sidebars( 'right', '3' );

		// Two sidebar
		} elseif ( 'double_right' == $sidebar ) {
			tm_sidebars( 'left', '3' );
			tm_sidebars( 'right', '3' );

		}
	}
}

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
		jQuery('#mobile-navigation').click( function(e) {
			e.preventDefault();
			jQuery('#main-navigation').slideToggle();
		});

		// ---------------------------------------------------------
		// Show main navigation if is hide
		// ---------------------------------------------------------
		jQuery(window).resize( function() {
			var nav_display = jQuery('#main-navigation').css('display');
			if( nav_display === 'none' ) {
				jQuery('#main-navigation').css('display', 'block');
			}
		});
	});
	</script>
	<?php break;
	endswitch;
}

function tm_debug_queries() {
	if ( true == WP_DEBUG && current_user_can( 'administrator' ) ) :
	?>
		<div class="alert alert-warning text-center">Page generated in <?php timer_stop(1); ?> seconds with <?php echo get_num_queries(); ?> database queries.</div>
	<?php
	endif;
}