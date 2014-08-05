<?php

function tm_layout_before_default() {
	?>
	<div class="wrapper">
	<?php
}

function tm_layout_after_default() {
	?>
	</div>
	<?php
}

function tm_ie_browser_message() {
	?>
	<!--[if lt IE 9]><p class="browsehappy"><?php _e('Estas utilizando un navegador obsoleto. Actualiza tu navegador para <a href="http://browsehappy.com/">mejorar tu experiencia.</a>', TM_THEME_DOMAIN); ?></p><![endif]-->
	<?php
}

function tm_header_logo_default() {
	?>
	<a id="logo" class="logo" href="<?php echo home_url(); ?>">
	<?php
		$logo = tm_get_option('logo');
		if( ! empty( $logo ) ) :
			$logo_image = '<img src="'. get_template_directory_uri() .'/assets/images/logo.png">';
		else :
			$logo_image = '<img src="'.$logo.'">';
		endif;
		
		echo $logo_image;
	?>
	<span class="screen-reader-text"><?php bloginfo( 'name' ); ?></span>
	</a>
	<?php
}

function tm_social_icons() {

	$class = apply_filters( 'tm_social_media_style', 'color' );
	
	echo '<ul class="social-media social-style-'.$class.'">'. tm_social_media() .'</ul>';
}

function tm_apple_touch_icon() {
	?>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/assets/images/favicon.png'; ?>" />
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon.png'; ?>" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon-72x72.png'; ?>" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon-114x114.png'; ?>" />
	<?php
}

function tm_custom_css() {
	$custom_css = tm_get_option( 'custom_css' );
	echo '<style type="text/css">'.$custom_css.'</style>';
}

function tm_footer_text_default() {
	?><p>
	<?php
	$string = '<strong>%s</strong> &copy; %d %s %s %s';
	$name = get_bloginfo( 'name' );
	$date = date( 'Y' );
	$copyright = tm_get_local( 'footer_copyright' );
	$text = tm_get_local( 'footer_text' );
	$author = '<a href="'. esc_url( 'http://3mentes.com/') .'">3mentes.</a>';

	echo sprintf( $string, $name, $date, $copyright, $text, $author );
	?></p>
	<?php
}

function tm_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
	}
}

function tm_navigation() {	
	$nav = tm_get_option( 'navigation' );
	switch( $nav ) :
	case 'off_canvas_navigation': ?>
	<script type="text/javascript">
	jQuery(document).ready( function() {
		// Off Canvas Navigation
		var offCanvas = jQuery('#off-canvas-button'),
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
			jQuery('#primary-nav').slideToggle();
		});

		// ---------------------------------------------------------
		// Show main navigation if is hide
		// ---------------------------------------------------------
		jQuery(window).resize( function() {
			var nav_display = jQuery('#primary-nav').css('display');
			if( nav_display === 'none' ) {
				jQuery('#primary-nav').css('display', 'block');
			}
		});
	});
	</script>
	<?php break;
	endswitch;
}