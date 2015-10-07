<?php

/**
 * Setup theme for customizer
 */
function eren_customizer() {

	$background_options = array(
		'background_color' => array(
			'name' 		=> __( 'Background Color', 'anva' ),
			'id' 		=> 'background_color',
			'type' 		=> 'color',
			'transport'	=> 'postMessage',
			'priority'	=> 1
		),
		'body_text' => array(
			'name' 		=> __( 'Background Color Brightness', 'anva' ),
			'id' 		=> 'body_text',
			'type' 		=> 'radio',
			'options'	=> array(
				'body_text_light' => __( 'I chose a dark color in the previous option.', 'anva' ),
				'body_text_dark' => __( 'I chose a light color in the previous option.', 'anva' )
			),
			'transport'	=> 'postMessage',
			'priority'	=> 2
		),
	);
	anva_add_customizer_section( 'background', __( 'Background', 'anva' ), $background_options, 1 );

	// Setup logo options
	$header_options = array(
		'logo' => array(
			'name' 		=> __( 'Logo', 'anva' ),
			'id' 		=> 'logo',
			'type' 		=> 'logo',
			'transport'	=> 'postMessage',
			'priority'	=> 1
		),
		'header_text' => array(
			'name' 		=> __( 'Header Text', 'anva' ),
			'id'		=> 'header_text',
			'type' 		=> 'text',
			'transport'	=> 'postMessage',
			'priority'	=> 20
		),
		'social_media_style' => array(
			'name' 		=> __( 'Socia Media Button Style', 'anva' ),
			'id'		=> 'social_media_style',
			'type' 		=> 'select',
			'options'	=> array(
				'color' => __( 'Color', 'anva' ),
				'light' => __( 'Light', 'anva' ),
				'dark' => __( 'Dark', 'anva' ),
				'grey' => __( 'Grey', 'anva' )
			),
			'transport'	=> 'postMessage',
			'priority'	=> 21
		)
	);
	anva_add_customizer_section( 'header', __( 'Header', 'anva' ), $header_options, 2 );

	$main_styles_options = array(
		'layout_style' => array(
			'name' 		=> __( 'Layout Style', 'anva' ),
			'id'		=> 'layout_style',
			'type' 		=> 'select',
			'options'	=> array(
				'boxed' => __( 'Boxed', 'anva' ),
				'stretched' => __( 'Stretched', 'anva' )
			),
			'transport'	=> 'postMessage',
			'priority'	=> 1
		),
		'menu_style' => array(
			'name' 		=> __( 'Main Menu Style', 'anva' ),
			'id' 		=> 'menu_style',
			'type' 		=> 'select',
			'options'	=> array(
				'menu_style_block' => __( 'Block', 'anva' ),
				'menu_style_classic' => __( 'Classic', 'anva' )
			),
			'transport'	=> 'postMessage',
			'priority'	=> 2
		),
		'style' => array(
			'name' 		=> __( 'Primary Color', 'anva' ),
			'id'		=> 'style',
			'type' 		=> 'select',
			'options'	=> array(
				'style_black' 		=> __( 'Black', 'anva' ),
				'style_blue' 		=> __( 'Blue', 'anva' ),
				'style_brown' 		=> __( 'Brown', 'anva' ),
				'style_dark_purple' => __( 'Dark Purple', 'anva' ),
				'style_dark' 		=> __( 'Dark', 'anva' ),
				'style_green' 		=> __( 'Green', 'anva' ),
				'style_light_blue' 	=> __( 'Light Blue', 'anva' ),
				'style_light' 		=> __( 'Light', 'anva' ),
				'style_navy' 		=> __( 'Navy', 'anva' ),
				'style_orange' 		=> __( 'Orange', 'anva' ),
				'style_pink' 		=> __( 'Pink', 'anva' ),
				'style_purple' 		=> __( 'Purple', 'anva' ),
				'style_red' 		=> __( 'Red', 'anva' ),
				'style_slate' 		=> __( 'Slate Grey', 'anva' ),
				'style_teal' 		=> __( 'Teal', 'anva' )
			),
			'transport'	=> 'postMessage',
			'priority'	=> 3
		),
		'content_color' => array(
			'name' 		=> __( 'Content Style', 'anva' ),
			'id' 		=> 'content_color',
			'type' 		=> 'select',
			'options'	=> array(
				'content_light' => __( 'Light', 'anva' ),
				'content_dark' => __( 'Dark', 'anva' )
			),
			'transport'	=> 'refresh',
			'priority'	=> 4
		)
	);
	anva_add_customizer_section( 'main_styles', __( 'Main Styles', 'anva' ), $main_styles_options, 101 );

	// Setup primary font options
	$font_options = array(
		'typography_body' => array(
			'name' 		=> __( 'Primary Font', 'anva' ),
			'id' 		=> 'typography_body',
			'atts'		=> array('size', 'style', 'face'),
			'type' 		=> 'typography',
			'transport'	=> 'postMessage'
		),
		'typography_header' => array(
			'name' 		=> __( 'Header Font', 'anva' ),
			'id' 		=> 'typography_header',
			'atts'		=> array('style', 'face'),
			'type' 		=> 'typography',
			'transport'	=> 'postMessage'
		),
		'typography_special' => array(
			'name' 		=> __( 'Special Font', 'anva' ),
			'id' 		=> 'typography_special',
			'atts'		=> array('style', 'face'),
			'type' 		=> 'typography',
			'transport'	=> 'postMessage'
		)
	);
	anva_add_customizer_section( 'typography', __( 'Typography', 'anva' ), $font_options, 102 );

	// Setup link options
	$link_options = array(
		'link_color' => array(
			'name' 		=> __( 'Link Color', 'anva' ),
			'id' 		=> 'link_color',
			'type' 		=> 'color',
			'priority'	=> 1
		),
		'link_hover_color' => array(
			'name' 		=> __( 'Link Hover Color', 'anva' ),
			'id' 		=> 'link_hover_color',
			'type' 		=> 'color',
			'priority'	=> 2
		),
		'featured_link_color' => array(
			'name' 		=> __( 'Featured Area Link Color', 'anva' ),
			'id' 		=> 'featured_link_color',
			'type' 		=> 'color',
			'priority'	=> 3
		),
		'featured_link_hover_color' => array(
			'name' 		=> __( 'Featured Area Link Hover Color', 'anva' ),
			'id' 		=> 'featured_link_hover_color',
			'type' 		=> 'color',
			'priority'	=> 4
		),
		'footer_link_color' => array(
			'name' 		=> __( 'Footer Link Color', 'anva' ),
			'id' 		=> 'footer_link_color',
			'type' 		=> 'color',
			'priority'	=> 5
		),
		'footer_link_hover_color' => array(
			'name' 		=> __( 'Footer Link Hover Color', 'anva' ),
			'id' 		=> 'footer_link_hover_color',
			'type' 		=> 'color',
			'priority'	=> 6
		)
	);
	anva_add_customizer_section( 'links', __( 'Links', 'anva' ), $link_options, 103 );

	// Setup custom styles option
	$custom_css_options = array(
		'custom_css' => array(
			'name' 		=> __( 'Enter styles to preview their results.', 'anva' ),
			'id' 		=> 'custom_css',
			'type' 		=> 'textarea',
			'transport'	=> 'postMessage'
		)
	);
	anva_add_customizer_section( 'custom_css', __( 'Custom CSS', 'anva' ), $custom_css_options, 121 );

}
add_action( 'after_setup_theme', 'eren_customizer' );

/**
 * Add specific theme elements to customizer
 */
function eren_customizer_init( $wp_customize ) {

	// Remove custom background options
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );

	// Add real-time option edits
	if ( $wp_customize->is_preview() ) {
		add_action( 'wp_footer', 'eren_customizer_preview', 21 );
	}

}
add_action( 'customize_register', 'eren_customizer_init' );

/**
 * Add real-time option edits for this theme in customizer
 */
function eren_customizer_preview() {

	// Global option name
	$option_name = anva_get_option_name();

	// Begin output
	?>
	<script type="text/javascript">
	window.onload = function() { // window.onload for silly IE9 bug fix
		(function($) {

			// Variables
			var template_url = "<?php echo get_template_directory_uri(); ?>";

			// ---------------------------------------------------------
			// Background
			// ---------------------------------------------------------

			/* Body Color */
			wp.customize('<?php echo $option_name; ?>[background_color]',function( value ) {
				value.bind(function(color) {
					$('body').css('background-color', color );
				});
			});

			/* Body BG Color Brightness */
			wp.customize('<?php echo $option_name; ?>[body_text]',function( value ) {
				value.bind(function(brightness) {
					$('body').removeClass('body_text_light body_text_dark');
					$('body').addClass(brightness);
				});
			});

			/* Body Texture */
			wp.customize('<?php echo $option_name; ?>[bg_texture]',function( value ) {
				value.bind(function(texture) {
					$('body').css('background-image', 'url('+template_url+'/framework/frontend/assets/images/textures/'+texture+'.png)' );
				});
			});

			// ---------------------------------------------------------
			// Header
			// ---------------------------------------------------------

			<?php anva_customizer_preview_logo(); ?>

			/* Header Tagline */
			wp.customize('<?php echo $option_name; ?>[header_text]',function( value ) {
				value.bind(function(to) {
					$('.header-text').html(to);
				});
			});

			/* Social Media Style */
			wp.customize('<?php echo $option_name; ?>[social_media_style]',function( value ) {
				value.bind(function(value) {
					$('#branding .anva-contact-bar li a').css({
						'background-image' : 'url('+template_url+'/framework/frontend/assets/images/parts/social-media-'+value+'_48x48.png)',
						'background-size' : '24px 744px'
					});

				});
			});

			// ---------------------------------------------------------
			// Main Styles
			// ---------------------------------------------------------

			/* Layout Style */
			wp.customize('<?php echo $option_name; ?>[layout_style]',function( value ) {
				value.bind(function(value) {
					$('body').removeClass('boxed stretched');
					$('body').addClass(value);
				});
			});

			/* Main Menu Style */
			wp.customize('<?php echo $option_name; ?>[menu_style]',function( value ) {
				value.bind(function(value) {
					$('.menu_style').removeClass('menu_style_block menu_style_classic');
					$('.menu_style').addClass(value);
				});
			});

			/* Primary Color */
			wp.customize('<?php echo $option_name; ?>[style]',function( value ) {
				value.bind(function(value) {
					$('body').removeClass('style_black style_blue style_brown style_dark_purple style_dark style_green style_light_blue style_light style_navy style_orange style_pink style_purple style_red style_slate style_teal');
					$('body').addClass(value);
				});
			});

			// ---------------------------------------------------------
			// Typography
			// ---------------------------------------------------------

			<?php anva_customizer_preview_font_prep(); ?>
			<?php anva_customizer_preview_primary_font(); ?>
			<?php anva_customizer_preview_header_font(); ?>

			// ---------------------------------------------------------
			// Special Typography
			// ---------------------------------------------------------

			var special_font_selectors = '#branding .header_logo .tb-text-logo, #content .media-full .slide-title, #featured_below .media-full .slide-title, .element-slogan .slogan .slogan-text, .element-tweet';

			/* Special Typography - Style */
			wp.customize('<?php echo $option_name; ?>[typography_special][style]',function( value ) {
				value.bind(function(style) {
					// Possible choices: normal, bold, italic, bold-italic
					if ( style == 'normal' ) {
						$(special_font_selectors).css('font-weight', 'normal');
						$(special_font_selectors).css('font-style', 'normal');

					} else if ( style == 'bold' ) {
						$(special_font_selectors).css('font-weight', 'bold');
						$(special_font_selectors).css('font-style', 'normal');

					} else if ( style == 'italic' ) {
						$(special_font_selectors).css('font-weight', 'normal');
						$(special_font_selectors).css('font-style', 'italic');

					} else if ( style == 'bold-italic' ) {
						$(special_font_selectors).css('font-weight', 'bold');
						$(special_font_selectors).css('font-style', 'italic');
					}
				});
			});

			/* Special Typography - Face */
			wp.customize('<?php echo $option_name; ?>[typography_special][face]',function( value ) {
				value.bind(function(face) {
					if( face == 'google' ){
						googleFonts.specialToggle = true;
						var google_font = googleFonts.specialName.split(":"),
							google_font = google_font[0];
						$(special_font_selectors).css('font-family', google_font);
					}
					else
					{
						googleFonts.specialToggle = false;
						$(special_font_selectors).css('font-family', fontStacks[face]);
					}
				});
			});

			/* Special Typography - Google */
			wp.customize('<?php echo $option_name; ?>[typography_special][google]',function( value ) {
				value.bind(function(google_font) {
					// Only proceed if user has actually selected for
					// a google font to show in previous option.
					if(googleFonts.specialToggle)
					{
						// Set global google font for reference in
						// other options.
						googleFonts.specialName = google_font;

						// Remove previous google font to avoid clutter.
						$('.preview_google_special_font').remove();

						// Format font name for inclusion
						var include_google_font = google_font.replace(/ /g,'+');

						// Include font
						$('head').append('<link href="http://fonts.googleapis.com/css?family='+include_google_font+'" rel="stylesheet" type="text/css" class="preview_google_special_font" />');

						// Format for CSS
						google_font = google_font.split(":");
						google_font = google_font[0];

						// Apply font in CSS
						$(special_font_selectors).css('font-family', google_font);
					}
				});
			});

			// ---------------------------------------------------------
			// Custom CSS
			// ---------------------------------------------------------

			<?php anva_customizer_preview_styles(); ?>

		})(jQuery);
	} // End window.onload for silly IE9 bug
	</script>
	<?php
}