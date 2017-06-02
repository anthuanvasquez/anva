<?php
/**
 * Theme options.
 *
 * WARNING: This file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, and filters.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */

/**
 * Use Anva_Options_API to add options onto options already
 * present in framework.
 *
 * @since  1.0.0
 * @return void
 */
function anva_theme_options() {

	/**
	 * Styles Tab Options.
	 */

	// Assets theme path.
	$skin_path = trailingslashit( get_template_directory_uri() . '/assets/images/skins' );

	// Skin Colors.
	$schemes = array();
	foreach ( anva_get_colors_scheme( $skin_path, 'jpg' ) as $color_id => $color ) {
		$schemes[ $color_id ] = $color['image'];
	}

	// Background defaults.
	$background_defaults = array(
		'image' 		=> '',
		'repeat' 		=> 'repeat',
		'position' 		=> 'top center',
		'attachment' 	=> 'scroll',
	);

	// Transitions.
	$transitions = array();
	foreach ( range( 0, 14 ) as $key ) {
		$transitions[ $key ] = esc_attr__( 'Loader Style', 'anva' ) . ' ' . $key;
	}
	$transitions[0] = esc_attr__( 'Disable Transition', 'anva' );
	$transitions[1] = esc_attr__( 'Default Loader Style', 'anva' );

	// Animations.
	$animations = array();
	foreach ( anva_get_animations() as $animation_id => $animation ) {
		$animations[ $animation ] = $animation;
	}

	$transition_animations = array(
		'fadeIn'    => 'fadeIn',
		'fadeOut'   => 'fadeOut',
		'fadeDown'  => 'fadeDown',
		'fadeUp'    => 'fadeUp',
		'fadeLeft'  => 'fadeLeft',
		'fadeRight' => 'fadeRight',
		'rotate'    => 'rotate',
		'flipX'     => 'flipX',
		'flipY'     => 'flipY',
		'zoom'      => 'zoom',
	);

	$styles = array(
		'general' => array(
			'layout_style' => array(
				'name' => esc_html__( 'Site Layout Style', 'anva' ),
				'desc' => esc_html__( 'Select the layout style of the site, you can use boxed or stretched.', 'anva' ),
				'id' => 'layout_style',
				'std' => 'stretched',
				'class' => 'input-select',
				'type' => 'select2',
				'options' => array(
					'boxed'     => esc_attr__( 'Boxed', 'anva' ),
					'stretched' => esc_attr__( 'Stretched', 'anva' )
				)
			),
			'base_color' => array(
				'name' => esc_html__( 'Site Color Scheme', 'anva' ),
				'desc' => sprintf(
					esc_html__( 'Select the color scheme of the site. Check live preview in the %s.', 'anva' ),
					sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=base_color' ) . '">%s</a>', esc_html__( 'Customizer', 'anva' ) )
				),
				'id' => 'base_color',
				'std' => 'blue',
				'type' => 'images',
				'options' => $schemes
			),
			'base_color_style' => array(
				'name' => esc_html__( 'Site Color Style', 'anva' ),
				'desc' => sprintf(
					esc_html__( 'Select the color style of the theme. Check live preview in the %s.', 'anva' ),
					sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=base_color_style' ) . '">%s</a>', esc_html__( 'Customizer', 'anva' ) )
				),
				'id' => 'base_color_style',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => esc_attr__( 'Light', 'anva' ),
					'dark'  => esc_attr__( 'Dark', 'anva' ),
				)
			),
		),
		'links' => array(
			'link_color' => array(
				'name' => esc_html__( 'Link Color', 'anva' ),
				'desc' => esc_html__( 'Choose the link color.', 'anva' ),
				'id' => 'link_color',
				'std' => '#3498db',
				'type' => 'color'
			),
			'link_color_hover' => array(
				'name' => esc_html__( 'Link Color (:Hover)', 'anva' ),
				'desc' => esc_html__( 'Choose the link color on :Hover state.', 'anva' ),
				'id' => 'link_color_hover',
				'std' => '#222222',
				'type' => 'color'
			),
		),
		'header' => array(
			'top_bar_color' => array(
				'name' => esc_html__( 'Top Bar Color', 'anva' ),
				'desc' => esc_html__( 'Select the color of the top bar.', 'anva' ),
				'id' => 'top_bar_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light'  => esc_attr__( 'Light', 'anva' ),
					'dark'   => esc_attr__( 'Dark', 'anva' ),
					'custom' => esc_attr__( 'Custom Color', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'top_bar_bg_color top_bar_text_color',
			),
			'top_bar_bg_color' => array(
				'name' => esc_html__( 'Top Bar Color', 'anva' ),
				'desc' => esc_html__( 'Select the background color of the top bar.', 'anva' ),
				'id' => 'top_bar_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
			),
			'top_bar_text_color' => array(
				'name' => null,
				'desc' => sprintf( '<strong>%s</strong> %s', esc_html__( 'Topbar Text' ), esc_html__( 'Use light text color for background.', 'anva' ) ),
				'id' => 'top_bar_text_color',
				'std' => '0',
				'type' => 'checkbox',
			),
			'header_color' => array(
				'name' => esc_html__( 'Header Color', 'anva' ),
				'desc' => esc_html__( 'Select the color of the header.', 'anva' ),
				'id' => 'header_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light'  => esc_attr__( 'Light', 'anva' ),
					'dark'   => esc_attr__( 'Dark', 'anva' ),
					'custom' => esc_attr__( 'Custom Color', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'header_bg_color header_image header_border_color header_text_color',
			),
			'header_bg_color' => array(
				'name' => esc_html__( 'Background Color', 'anva' ),
				'desc' => esc_html__( 'Select the custom color of the header background', 'anva' ),
				'id' => 'header_bg_color',
				'std' => '#ffffff',
				'type' => 'color',
				'class' => 'hidden',
			),
			'header_image' => array(
				'name' => esc_html__( 'Background Image', 'anva' ),
				'desc' => esc_html__( 'Select the backgrund image of the header, will replace the option above.', 'anva' ),
				'id' => 'header_image',
				'std' => '',
				'type' => 'upload',
				'class' => 'hidden',
			),
			'header_border_color' => array(
				'name' => esc_html__( 'Border Color', 'anva' ),
				'desc' => esc_html__( 'Select the border color of the header.', 'anva' ),
				'id' => 'header_border_color',
				'std' => '#f5f5f5',
				'type' => 'color',
				'class' => 'hidden',
			),
			'header_text_color' => array(
				'name' => esc_html__( 'Text Color', 'anva' ),
				'desc' => esc_html__( 'Select the text color if you have a header using a custom background color or image.', 'anva' ),
				'id' => 'header_text_color',
				'std' => '#ffffff',
				'type' => 'color',
				'class' => 'hidden',
			),
		),
		'navigation' => array(
			'primary_menu_color' => array(
				'name' => esc_html__( 'Primary Menu Color', 'anva' ),
				'desc' => esc_html__( 'Select the color style of the primary navigation. Note: changes will not applied when header type is side.', 'anva' ),
				'id' => 'primary_menu_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light' => esc_attr__( 'Light', 'anva' ),
					'dark'  => esc_attr__( 'Dark', 'anva' ),
				),
			),
			'primary_menu_font_check' => array(
				'name' => null,
				'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Font', 'anva' ), esc_html__( 'Apply font to primary navigation.', 'anva' ) ),
				'id' => 'primary_menu_font_check',
				'std' => '0',
				'type' => 'checkbox',
				'trigger' => 1,
				'receivers' => 'primary_menu_font'
			),
			'primary_menu_font' => array(
				'name' => esc_html__( 'Headings Font', 'anva' ),
				'desc' => esc_html__( 'This applies to all of the primary menu links.', 'anva' ),
				'id' => 'primary_menu_font',
				'std' => array(
					'face'   => 'google',
					'style'  => 'uppercase',
					'weight' => '700',
					'google' => 'Raleway:400,600,700',
					'color'  => '#444444'
				),
				'type' => 'typography',
				'options' => array( 'style', 'weight', 'face', 'color' )
			),
			'side_panel_color' => array(
				'name' => esc_html__( 'Side Panel Color', 'anva' ),
				'desc' => esc_html__( 'Select the color style of the side panel. Note: changes will not applied when header type is side.', 'anva' ),
				'id' => 'side_panel_color',
				'std' => 'light',
				'type' => 'select',
				'options' => array(
					'light'  => esc_attr__( 'Light', 'anva' ),
					'dark'   => esc_attr__( 'Dark', 'anva' ),
					'custom' => esc_attr__( 'Custom', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'side_panel_bg_color',
			),
			'side_panel_bg_color' => array(
				'name' => esc_html__( 'Background Color', 'anva' ),
				'desc' => esc_html__( 'Select the custom color of the side panel background.', 'anva' ),
				'id' => 'side_panel_bg_color',
				'std' => '#f8f8f8',
				'type' => 'color',
				'class' => 'hidden',
			),
		),
		'footer' => array(
			'footer_color' => array(
				'name' => esc_html__( 'Color Style', 'anva' ),
				'desc' => esc_html__( 'Select the color style of the footer.', 'anva' ),
				'id' => 'footer_color',
				'std' => 'dark',
				'type' => 'select',
				'options' => array(
					'light'  => esc_attr__( 'Light', 'anva' ),
					'dark' 	 => esc_attr__( 'Dark', 'anva' ),
					'custom' => esc_attr__( 'Custom', 'anva' ),
				),
				'trigger' => 'custom',
				'receivers' => 'footer_bg_color footer_bg_image footer_text_color',
			),
			'footer_bg_color' => array(
				'name' => esc_html__( 'Background Color', 'anva' ),
				'desc' => esc_html__( 'Select the custom color of the footer background.', 'anva' ),
				'id' => 'footer_bg_color',
				'std' => '#333333',
				'type' => 'color',
			),
			'footer_bg_image' => array(
				'name' => esc_html__( 'Background Image', 'anva' ),
				'desc' => esc_html__( 'Select the backgrund image of the footer, will replace the option above.', 'anva' ),
				'id' => 'footer_bg_image',
				'std' => '',
				'type' => 'upload',
			),
			'footer_text_color' => array(
				'name' => esc_html__( 'Text Color', 'anva' ),
				'desc' => esc_html__( 'Select the text color if footer use a custom background color or image.', 'anva' ),
				'id' => 'footer_text_color',
				'std' => '',
				'type' => 'color',
			),
			'footer_link_color' => array(
				'name' => esc_html__( 'Link Color', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color.', 'anva' ),
				'id' => 'footer_link_color',
				'std' => '#555555',
				'type' => 'color'
			),
			'footer_link_color_hover' => array(
				'name' => esc_html__( 'Link Color (:Hover)', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color on :Hover state.', 'anva' ),
				'id' => 'footer_link_color_hover',
				'std' => '#555555',
				'type' => 'color'
			),
			'footer_dark_link_color' => array(
				'name' => esc_html__( 'Dark Link Color', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color when the footer is dark.', 'anva' ),
				'id' => 'footer_dark_link_color',
				'std' => '#555555',
				'type' => 'color'
			),
			'footer_dark_link_color_hover' => array(
				'name' => esc_html__( 'Dark Link Color (:Hover)', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color on :Hover state when the footer is dark.', 'anva' ),
				'id' => 'footer_dark_link_color_hover',
				'std' => '#ffffff',
				'type' => 'color'
			),
		),
		'social_icons' => array(
			'social_icons_style' => array(
				'name' => esc_html__( 'Social Icons Style', 'anva' ),
				'desc' => esc_html__( 'choose the style for your social icons.', 'anva' ),
				'id' => 'social_icons_style',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	 => esc_attr__( 'Default Style', 'anva' ),
					'light' 	 => esc_attr__( 'Light', 'anva' ),
					'dark' 		 => esc_attr__( 'Dark', 'anva' ),
					'text-color' => esc_attr__( 'Text Colored', 'anva' ),
					'colored'    => esc_attr__( 'Colored', 'anva' ),
				)
			),
			'social_icons_shape' => array(
				'name' => esc_html__( 'Social Icons Shape', 'anva' ),
				'desc' => esc_html__( 'choose the shape for your social icons.', 'anva' ),
				'id' => 'social_icons_shape',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> esc_html__( 'Default Shape', 'anva' ),
					'rounded' 	=> esc_html__( 'Rounded', 'anva' ),
				)
			),
			'social_icons_border' => array(
				'name' => esc_html__( 'Social Icons Border', 'anva' ),
				'desc' => esc_html__( 'Choose the shape for your social icons.', 'anva' ),
				'id' => 'social_icons_border',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> esc_html__( 'Default Border', 'anva' ),
					'borderless' 	=> esc_html__( 'Without Border', 'anva' ),
				)
			),
			'social_icons_size' => array(
				'name' => esc_html__( 'Social Icons Size', 'anva' ),
				'desc' => esc_html__( 'Choose the size for your social icons.', 'anva' ),
				'id' => 'social_icons_size',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default' 	=> esc_html__( 'Default Size', 'anva' ),
					'small' 	=> esc_html__( 'Small', 'anva' ),
					'large' 	=> esc_html__( 'Large', 'anva' ),
				)
			),
		),
		'background' => array(
			'background_color' => array(
				'name' => esc_html__( 'Background Color', 'anva' ),
				'desc' => esc_html__( 'Choose the background color.', 'anva' ),
				'id' => 'background_color',
				'std' => '#dddddd',
				'type' => 'color'
			),
			'background_image' => array(
				'name' => esc_html__( 'Background Image', 'anva' ),
				'desc' => esc_html__( 'Choose the background image. Note: this option only take effect if layout style is boxed.', 'anva' ),
				'id' => 'background_image',
				'std' => $background_defaults,
				'type' => 'background'
			),
			'background_cover' => array(
				'name' => null,
				'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Cover', 'anva' ), esc_html__( 'Fill background screen with the image.', 'anva' ) ),
				'id' => 'background_cover',
				'std' => '0',
				'type' => 'checkbox'
			),
			'background_pattern' => array(
				'name' => esc_html__( 'Background Pattern', 'anva' ),
				'desc' => sprintf( esc_html__( 'Choose the background pattern. Note: this option is only applied if the braclground image option is empty. Check live preview in the %s.', 'anva' ), sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=background_pattern' ) . '">%s</a>', esc_html__( 'Customizer', 'anva' ) ) ),
				'id' => 'background_pattern',
				'std' => '',
				'type' => 'select',
				'options' => array(
					''                     => esc_attr__( 'None', 'anva' ),
					'binding_light'        => esc_attr__( 'Binding Light', 'anva' ),
					'dimension_@2X'        => esc_attr__( 'Dimension', 'anva' ),
					'hoffman_@2X'          => esc_attr__( 'Hoffman', 'anva' ),
					'knitting250px'        => esc_attr__( 'Knitting', 'anva' ),
					'noisy_grid'           => esc_attr__( 'Noisy Grid', 'anva' ),
					'pixel_weave_@2X'      => esc_attr__( 'Pixel Weave', 'anva' ),
					'struckaxiom'          => esc_attr__( 'Struckaxiom', 'anva' ),
					'subtle_stripes'       => esc_attr__( 'Subtle Stripes', 'anva' ),
					'white_brick_wall_@2X' => esc_attr__( 'White Brick Wall', 'anva' ),
					'gplaypattern'         => esc_attr__( 'G Play Pattern', 'anva' ),
					'blackmamba'           => esc_attr__( 'Black Mamba', 'anva' ),
					'carbon_fibre'         => esc_attr__( 'Carbon Fibre', 'anva' ),
					'congruent_outline'    => esc_attr__( 'Congruent Outline', 'anva' ),
					'moulin'               => esc_attr__( 'Moulin', 'anva' ),
					'wild_oliva'           => esc_attr__( 'Wild Oliva', 'anva' ),
				),
				'pattern_preview' => 'show',
			),
		),
		'typography' => array(
			'body_font' => array(
				'name' => esc_html__( 'Body Font', 'anva' ),
				'desc' => esc_html__( 'This applies to most of the text on your site.', 'anva' ),
				'id' => 'body_font',
				'std' => array(
					'size'   => '14',
					'style'  => 'normal',
					'weight' => '400',
					'face'   => 'google',
					'google' => 'Lato:300,400,400italic,600,700',
					'color'  => '#555555'
				),
				'type' => 'typography',
				'options' => array( 'size', 'weight', 'style', 'face', 'color' )
			),
			'heading_font' => array(
				'name' => esc_html__( 'Headings Font', 'anva' ),
				'desc' => esc_html__( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', 'anva' ),
				'id' => 'heading_font',
				'std' => array(
					'size'   => '14',
					'face'   => 'google',
					'style'  => 'uppercase',
					'weight' => '600',
					'google' => 'Raleway:300,400,500,600,700',
					'color'  => '#444444'
				),
				'type' => 'typography',
				'options' => array( 'size', 'weight', 'face', 'color' )
			),
			'widget_title_font' => array(
				'name' => esc_html__( 'Widget Titles Font', 'anva' ),
				'desc' => esc_html__( 'This applies to all widget titles.', 'anva' ),
				'id' => 'widget_title_font',
				'std' => array(
					'face'   => 'google',
					'style'  => 'uppercase',
					'weight' => '600',
					'google' => 'Raleway:300,400,500,600,700',
					'color'  => '#444444'
				),
				'type' => 'typography',
				'options' => array( 'face' )
			),
			'meta_font' => array(
				'name' => esc_html__( 'Meta Font', 'anva' ),
				'desc' => esc_html__( 'This applies to all of the meta information of your site.', 'anva' ),
				'id' => 'meta_font',
				'std' => array(
					'face' => 'google',
					'google' => 'Crete Round:400italic',
				),
				'type' => 'typography',
				'options' => array( 'face' )
			),
			'heading_h1' => array(
				'name' => esc_html__( 'H1', 'anva' ),
				'desc' => esc_html__( 'Select the size for H1 tag in px.', 'anva' ),
				'id' => 'heading_h1',
				'std' => '36',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h2' => array(
				'name' => esc_html__( 'H2', 'anva' ),
				'desc' => esc_html__( 'Select the size for H2 tag in px.', 'anva' ),
				'id' => 'heading_h2',
				'std' => '30',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h3' => array(
				'name' => esc_html__( 'H3', 'anva' ),
				'desc' => esc_html__( 'Select the size for H3 tag in px.', 'anva' ),
				'id' => 'heading_h3',
				'std' => '24',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h4' => array(
				'name' => esc_html__( 'H4', 'anva' ),
				'desc' => esc_html__( 'Select the size for H4 tag in px.', 'anva' ),
				'id' => 'heading_h4',
				'std' => '18',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h5' => array(
				'name' => esc_html__( 'H5', 'anva' ),
				'desc' => esc_html__( 'Select the size for H5 tag in px.', 'anva' ),
				'id' => 'heading_h5',
				'std' => '14',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
			'heading_h6' => array(
				'name' => esc_html__( 'H6', 'anva' ),
				'desc' => esc_html__( 'Select the size for H6 tag in px.', 'anva' ),
				'id' => 'heading_h6',
				'std' => '12',
				'type' => 'range',
				'options' => array(
					'min' => 9,
					'max' => 72,
					'step' => 1,
					'units' => 'px',
				)
			),
		),
		'custom' => array(
			'css_warning' => array(
				'name' => esc_html__( 'Info', 'anva' ),
				'desc' => esc_html__( 'If you have some minor CSS changes, you can put them here to override the theme default styles. However, if you plan to make a lot of CSS changes, it would be best to create a child theme.', 'anva' ),
				'id' => 'css_warning',
				'type' => 'info',
			),
			'custom_css' => array(
				'name' => esc_html__( 'Custom CSS', 'anva' ),
				'desc' => esc_html__( 'Use custom CSS to override the theme styles.', 'anva' ),
				'id' => 'custom_css',
				'std' => '',
				'type' => 'code',
				'mode' => 'css',
			),
			'custom_css_stylesheet' => array(
				'name' => null,
				'desc' => sprintf( '<strong>%s</strong> %s', esc_html__( 'Stylesheet' ), esc_html__( 'Add a custom css stylesheet to the head, custom.css.', 'anva' ) ),
				'id' => 'custom_css_stylesheet',
				'std' => '0',
				'type' => 'checkbox',
			)
		),
	);

	anva_add_option_tab( 'styles', esc_html__( 'Styles', 'anva' ), true, 'admin-appearance' );
	anva_add_option_section( 'styles', 'general', esc_html__( 'General', 'anva' ), null, $styles['general'] );
	anva_add_option_section( 'styles', 'links', esc_html__( 'Links', 'anva' ), null, $styles['links'], false );
	anva_add_option_section( 'styles', 'header', esc_html__( 'Header', 'anva' ), null, $styles['header'], false  );
	anva_add_option_section( 'styles', 'navigation', esc_html__( 'Navigation', 'anva' ), null, $styles['navigation'], false  );
	anva_add_option_section( 'styles', 'footer', esc_html__( 'Footer', 'anva' ), null, $styles['footer'], false );
	anva_add_option_section( 'styles', 'social_icons', esc_html__( 'Social Icons', 'anva' ), null, $styles['social_icons'], false );
	anva_add_option_section( 'styles', 'background', esc_html__( 'Background', 'anva' ), null, $styles['background'], false );
	anva_add_option_section( 'styles', 'typography', esc_html__( 'Typography', 'anva' ), null, $styles['typography'], false );
	anva_add_option_section( 'styles', 'custom', esc_html__( 'Custom', 'anva' ), null, $styles['custom'], false );

	/**
	 * Layout Tab Options.
	 */

	// Get header types
	$header_types = array();
	foreach ( anva_get_header_types() as $type_id => $type ) {
		if ( 'no_sticky' == $type_id ) {
			continue;
		}
		$header_types[ $type_id ] = $type['name'];
	}

	// Get menu styles
	$menu_styles = array();
	foreach ( anva_get_primary_menu_styles() as $style_id => $style ) {
		$menu_styles[ $style_id ] = $style['name'];
	}

	// Get side panel types
	$side_panel_types = array();
	foreach ( anva_get_side_panel_types() as $type_id => $type ) {
		$side_panel_types[ $type_id ] = $type['name'];
	}

	$animations = array();
	foreach ( anva_get_animations() as $key => $value ) {
		$animations[ $value ] = $value;
	}

	// Pull all gallery templates
	$galleries = array();
	foreach ( anva_gallery_templates() as $key => $gallery ) {
		$galleries[$key] = $gallery['name'];
	}

	// Get all sliders
	$sliders = anva_get_sliders();

	// Pull all sliders
	$slider_select = array();
	foreach ( $sliders as $slider_id => $slider ) {
		$slider_select[ $slider_id ] = $slider['name'];
	}

	// Revolution Slider
	if ( class_exists( 'RevSliderAdmin' ) ) {
		$slider_select['revslider'] = 'Revolution Slider';
	}

	$layout = array(
		'header_type' => array(
			'name' => esc_html__( 'Header Type', 'anva' ),
			'desc' => esc_html__( 'Select the type of the header.', 'anva' ),
			'id' => 'header_type',
			'std' => 'default',
			'type' => 'select',
			'options' => $header_types,
		),
		'header_sticky' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Sticky', 'anva' ), esc_html__( 'I don\'t want the header sticky.', 'anva' ) ),
			'id' => 'header_sticky',
			'std' => '1',
			'type' => 'checkbox',
		),
		'header_layout' => array(
			'name' => esc_html__( 'Header Layout', 'anva' ),
			'desc' => esc_html__( 'Select the layout of the header.', 'anva' ),
			'id' => 'header_layout',
			'std' => '',
			'type' => 'select',
			'options' => array(
				'' => esc_attr__( 'Boxed', 'anva' ),
				'full-header' => esc_attr__( 'Full Header', 'anva' ),
			),
		),
		'top_bar_display' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Top Bar', 'anva' ), esc_html__( 'Display top bar above header.', 'anva' ) ),
			'id' => 'top_bar',
			'std' => '',
			'type' => 'checkbox',
			'trigger' => '1',
			'receivers' => 'top_bar_layout',
		),
		'top_bar_layout' => array(
			'name' => esc_html__( 'Top Bar Layout', 'anva' ),
			'desc' => esc_html__( 'Select the top bar layout you want to show.', 'anva' ),
			'id' => 'top_bar_layout',
			'std' => 'menu_icons',
			'type' => 'select',
			'options' => array(
				'menu_icons' => esc_attr__( 'Menu + Social Icons with Contact Info', 'anva' ),
				'icons_menu' => esc_attr__( 'Social Icons with Contact Info + Menu', 'anva' ),
			)
		),
		'side_panel_display' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Side Panel', 'anva' ), esc_html__( 'Display the side panel content.', 'anva' ) ),
			'id' => 'side_panel_display',
			'std' => '0',
			'type' => 'checkbox',
			'trigger' => '1',
			'receivers' => 'side_panel_type side_panel_icons',
		),
		'side_panel_type' => array(
			'name' => esc_html__( 'Side Panel', 'anva' ),
			'desc' => esc_html__( 'Select the side panel you want to show in the site. Note: changes will not applied when header type is side.', 'anva' ),
			'id' => 'side_panel_type',
			'std' => 'left_overlay',
			'type' => 'select',
			'options' => $side_panel_types,
			'class' => 'hidden'
		),
		'side_header_icons' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s</strong> %s', esc_html__( 'Icons' ), esc_html__( 'Display social icons below primary menu when header type is side.', 'anva' ) ),
			'id' => 'side_header_icons',
			'std' => '1',
			'type' => 'checkbox',
		),
		'primary_menu_style' => array(
			'name' => esc_html__( 'Primary Menu Style', 'anva' ),
			'desc' => esc_html__( 'Select the style of the primary navigation. Note: changes will not applied when header type is side.', 'anva' ),
			'id' => 'primary_menu_style',
			'std' => 'default',
			'type' => 'select',
			'options' => $menu_styles,
			'trigger' => 'style_7',
			'receivers' => 'header_extras header_extras_info',
		),
		'header_extras' => array(
			'name' => esc_html__( 'Header Extra Info', 'anva' ),
			'desc' => esc_html__( 'Select if you want to show the header extra info in the right.', 'anva' ),
			'id' => 'header_extras',
			'std' => 'hide',
			'type' => 'select',
			'options' => array(
				'show' => esc_attr__( 'Show header extras', 'anva' ),
				'hide' => esc_attr__( 'Hide header extras', 'anva' ),
			),
			'class' => 'hidden'
		),
		'header_extras_info' => array(
			'name' => esc_html__( 'Header Extra Info Text', 'anva' ),
			'desc' => esc_html__( 'Enter the text you want show in extra info.', 'anva' ),
			'id' => 'header_extras_info',
			'std' => '',
			'type' => 'text',
			'class' => 'hidden',
		),
		'breaking_display' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Breaking News', 'anva' ), esc_html__( 'Display breaking news above header.', 'anva' ) ),
			'id' => 'breaking_display',
			'std' => '0',
			'type' => 'checkbox',
			'trigger' => '1',
			'receivers' => 'breaking_categories breaking_items',
		),
		'breaking_items' => array(
			'name' => esc_html__( 'Breaking News Items', 'anva' ),
			'desc' => esc_html__( 'Choose the default items to show on breaking news.', 'anva' ),
			'id'   => 'breaking_items',
			'std'  => 5,
			'type' => 'number',
		),
		'breaking_categories' => array(
			'name' => esc_html__( 'Breaking News Categories', 'anva' ),
			'desc' => esc_html__( 'Select the categories from blog you want to show on breaking news.', 'anva' ),
			'id' => 'breaking_categories',
			'std' => array(),
			'type' => 'multicheck',
			'options' => anva_pull_categories(),
		),
		'footer_extra_display' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Extra Info' ), esc_html__( 'Display extra information in footer.', 'anva' ) ),
			'id' => 'footer_extra_display',
			'std' => '1',
			'type' => 'checkbox',
			'trigger' => '1',
			'receivers' => 'footer_extra_info',
		),
		'footer_extra_info' => array(
			'name' => esc_html__( 'Extra Information Text', 'anva' ),
			'desc' => esc_html__( 'Enter the extra information text you\'d like to show in the footer below the social icons. You can use basic HTML, or any icon ID formatted like %name%.', 'anva' ),
			'id' => 'footer_extra_info',
			'std' => '%call% 1-800-999-999 %email3% admin@yoursite.com',
			'type' => 'textarea',
		),
		'footer_gototop' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Go To Top' ), esc_html__( 'Add a Go To Top to allow your users to scroll to the Top of the page.', 'anva' ) ),
			'id' => 'footer_gototop',
			'std' => '1',
			'type' => 'checkbox',
		),
		'footer_icons' => array(
			'name' => null,
			'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Icons' ), esc_html__( 'Display social icons on the footer.', 'anva' ) ),
			'id' => 'footer_icons',
			'std' => '1',
			'type' => 'checkbox',
		),
		'page_transition' => array(
			'page_loader' => array(
				'name' => esc_html__( 'Loader', 'anva' ),
				'desc' => esc_html__( 'Choose the loading styles of the Animation you want to show to your visitors while the pages of you Website loads in the background.', 'anva' ),
				'id' => 'page_loader',
				'std' => '1',
				'type' => 'select',
				'options' => $transitions
			),
			'page_loader_color' => array(
				'name' => esc_html__( 'Color', 'anva' ),
				'desc' => esc_html__( 'Choose the loader color.', 'anva' ),
				'id' => 'page_loader_color',
				'std' => '#dddddd',
				'type' => 'color',
			),
			'page_loader_timeout' => array(
				'name' => esc_html__( 'Timeout', 'anva' ),
				'desc' => esc_html__( 'Enter the timeOut in milliseconds to end the page preloader immaturely. Default is 1000.', 'anva' ),
				'id' => 'page_loader_timeout',
				'std' => 1000,
				'type' => 'number',
			),
			'page_loader_speed_in' => array(
				'name' => esc_html__( 'Speed In', 'anva' ),
				'desc' => esc_html__( 'Enter the speed of the animation in milliseconds on page load. Default is 800.', 'anva' ),
				'id' => 'page_loader_speed_in',
				'std' => 800,
				'type' => 'number',
			),
			'page_loader_speed_out' => array(
				'name' => esc_html__( 'Speed Out', 'anva' ),
				'desc' => esc_html__( 'Enter the speed of the animation in milliseconds on page load. Default is 800.', 'anva' ),
				'id' => 'page_loader_speed_out',
				'std' => 800,
				'type' => 'number',
			),
			'page_loader_animation_in' => array(
				'name' => esc_html__( 'Animation In', 'anva' ),
				'desc' => esc_html__( 'Choose the animation style on page load.', 'anva' ),
				'id' => 'page_loader_animation_in',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $transition_animations,
			),
			'page_loader_animation_out' => array(
				'name' => esc_html__( 'Animation Out', 'anva' ),
				'desc' => esc_html__( 'Choose the animation style on page out.', 'anva' ),
				'id' => 'page_loader_animation_out',
				'std' => 'fadeOut',
				'type' => 'select',
				'options' => $transition_animations
			),
			'page_loader_html' => array(
				'name' => esc_html__( 'HTML', 'anva' ),
				'desc' => esc_html__( 'Enter the custom HTML you want to show.', 'anva' ),
				'id' => 'page_loader_html',
				'std' => '',
				'type' => 'editor',
			),
		),
		'login' => array(
			'login_style' => array(
				'name' => esc_html__( 'Style', 'anva' ),
				'desc' => esc_html__( 'Select the login style.', 'anva' ),
				'id' => 'login_style',
				'std' => '',
				'type' => 'select',
				'options' => array(
					'' 	     => esc_attr__( 'None', 'anva' ),
					'style1' => esc_attr__( 'Style 1', 'anva' ),
					'style2' => esc_attr__( 'Style 2', 'anva' ),
					'style3' => esc_attr__( 'Style 3', 'anva' )
				)
			),
			'login_copyright' => array(
				'name' => esc_html__( 'Copyright Text', 'anva' ),
				'desc' => esc_html__( 'Enter the copyright text you\'d like to show in the footer of your login page.', 'anva' ),
				'id' => 'login_copyright',
				'std' => sprintf( esc_html__( 'Copyright %s %s. Designed by %s.', 'anva' ), date( 'Y' ), anva_get_theme( 'name' ), '<a href="' . esc_url( 'http://anthuanvasquez.net' ) . '" target="_blank">Anthuan Vasquez</a>' ),
				'type' => 'textarea',
			),
		),
	);

	anva_add_option( 'layout', 'header', 'header_type', $layout['header_type'] );
	anva_add_option( 'layout', 'header', 'header_sticky', $layout['header_sticky'] );
	anva_add_option( 'layout', 'header', 'header_layout', $layout['header_layout'] );
	anva_add_option( 'layout', 'header', 'top_bar_display',$layout['top_bar_display'] );
	anva_add_option( 'layout', 'header', 'top_bar_layout',$layout['top_bar_layout'] );
	anva_add_option( 'layout', 'header', 'side_panel_display', $layout['side_panel_display'] );
	anva_add_option( 'layout', 'header', 'side_panel_type', $layout['side_panel_type'] );
	anva_add_option( 'layout', 'header', 'side_header_icons', $layout['side_header_icons'] );
	anva_add_option( 'layout', 'header', 'primary_menu_style', $layout['primary_menu_style'] );
	anva_add_option( 'layout', 'header', 'header_extras', $layout['header_extras'] );
	anva_add_option( 'layout', 'header', 'header_extras_info', $layout['header_extras_info'] );
	anva_add_option( 'layout', 'header', 'breaking_display', $layout['breaking_display'] );
	anva_add_option( 'layout', 'header', 'breaking_items', $layout['breaking_items'] );
	anva_add_option( 'layout', 'header', 'breaking_categories', $layout['breaking_categories'] );
	anva_add_option( 'layout', 'footer', 'footer_extra_display', $layout['footer_extra_display'] );
	anva_add_option( 'layout', 'footer', 'footer_extra_info', $layout['footer_extra_info'] );
	anva_add_option( 'layout', 'footer', 'footer_gototop', $layout['footer_gototop'] );
	anva_add_option( 'layout', 'footer', 'footer_icons', $layout['footer_icons'] );
	anva_add_option_section( 'layout', 'page_transition', esc_html__( 'Page Transition', 'anva' ), null, $layout['page_transition'], false );

	// Add slider options.
	foreach ( $sliders as $slider_id => $slider ) {
		foreach ( $slider['options'] as $option_id => $option ) {
			anva_add_option( 'layout', 'slideshows', $option_id, $option );
		}
	}

	// Login Feature Support.
	if ( anva_support_feature( 'anva-login' ) ) {
		anva_add_option_section( 'layout', 'login', esc_html__( 'Login', 'anva' ), null, $layout['login'], false );
	}

	/**
	 * Feature Tab Options.
	 */
	$custom = array(
		'gallery' => array(
			'gallery_sort' => array(
				'name' => esc_html__( 'Images Sorting', 'anva' ),
				'desc' => esc_html__( 'Select how you want to sort gallery images.', 'anva' ),
				'id' => 'gallery_sort',
				'std' => 'drag',
				'type' => 'select',
				'options' => array(
					'drag'  => esc_attr__( 'Drag & Drop', 'anva' ),
					'desc'  => esc_attr__( 'Newest', 'anva' ),
					'asc'   => esc_attr__( 'Oldest', 'anva' ),
					'rand'  => esc_attr__( 'Random', 'anva' ),
					'title' => esc_attr__( 'Title', 'anva' )
				)
			),
			'gallery_template' => array(
				'name' => esc_html__( 'Default Template', 'anva' ),
				'desc' => esc_html__( 'Choose the default template for galleries. </br>Note: This will be the default template throughout your galleries, but you can be override this setting for any specific gallery page.', 'anva' ),
				'id' => 'gallery_template',
				'std' => '3-col',
				'type' => 'select',
				'options' => $galleries
			),
			'gallery_animate' => array(
				'name' => esc_html__( 'Animate', 'anva' ),
				'desc' => sprintf(
					esc_html__( 'Choose the default animation for gallery images. Get a %s of the animations.', 'anva' ),
					sprintf( '<a href="' . esc_url( 'https://daneden.github.io/animate.css/' ) . '" target="_blank">%s</a>', esc_html__( 'preview', 'anva' ) )
				),
				'id' => 'gallery_animate',
				'std' => 'fadeIn',
				'type' => 'select',
				'options' => $animations
			),
			'gallery_delay' => array(
				'name' => esc_html__( 'Delay', 'anva' ),
				'desc' => esc_html__( 'Choose the default delay for animation.', 'anva' ),
				'id' => 'gallery_delay',
				'std' => 400,
				'type' => 'number'
			),
		),
		'slideshows' => array(
			'slider_id' => array(
				'name' => esc_html__( 'Slider', 'anva' ),
				'desc' => esc_html__( 'Select the main slider. Based on the slider you select, the options below may change.', 'anva' ),
				'id' => 'slider_id',
				'std' => 'standard',
				'type' => 'select',
				'options' => $slider_select
			),
			'slider_style' => array(
				'name' => esc_html__( 'Style', 'anva' ),
				'desc' => esc_html__( 'Select the slider style.', 'anva' ),
				'id' => 'slider_style',
				'std' => 'full-screen',
				'type' => 'select',
				'options' => array(
					'slider-boxed' => esc_attr__( 'Boxed', 'anva' ),
					'full-screen'  => esc_attr__( 'Full Screen', 'anva' ),
				)
			),
			'slider_parallax' => array(
				'name' => esc_html__( 'Parallax', 'anva' ),
				'desc' => esc_html__( 'If you use the parallax effect for sliders enable this option.', 'anva' ),
				'id' => 'slider_parallax',
				'std' => 'false',
				'type' => 'select',
				'options'	=> array(
					'true' 	=> esc_attr__( 'Yes, enable parallax', 'anva' ),
					'false'	=> esc_attr__( 'No, disable parallax', 'anva' ),
				),
			),
			'slider_thumbnails' => array(
				'name' => esc_html__( 'Thumbnails Size', 'anva' ),
				'desc' => esc_html__( 'Select the image size you want to show in featured content.', 'anva' ),
				'id' => 'slider_thumbnails',
				'std' => 'anva_xl',
				'type' => 'select',
				'options' => anva_get_image_sizes_thumbnail(),
			),
			'revslider_id' => array(
				'name' => esc_html__( 'Revolution Slider ID', 'anva' ),
				'desc' => esc_html__( 'Show or hide the slider direction navigation.', 'anva' ),
				'id' => 'revslider_id',
				'std' => '',
				'type' => 'text',
				'class' => 'slider-item revslider hide'
			),
			'slider_area' => array(
				'name' => esc_html__( 'Slider Area', 'anva' ),
				'desc' => esc_html__( 'Select the slider area.', 'anva' ),
				'id' => 'slider_area',
				'std' => array( 'front' => '1' ),
				'type' => 'multicheck',
				'options' => anva_get_default_slider_areas(),
			),
			'slider_group_area' => array(
				'name' => esc_html__( 'Slider Group and Areas', 'anva' ),
				'desc' => esc_html__( 'Select the slider area and groups slides.', 'anva'  ),
				'id'   => 'slider_group_area',
				'type' => 'slider_group_area',
			),
		),
	);

	anva_add_option_tab( 'features', esc_html__( 'Features', 'anva' ), false, 'pressthis' );
	anva_add_option_section( 'features', 'gallery', esc_html__( 'Galleries', 'anva' ), null, $custom['gallery'], false );;
	anva_add_option_section( 'features', 'slideshows', esc_html__( 'Slideshows', 'anva' ), null, $custom['slideshows'], false );

	/**
	 * Advanced Tab Options.
	 */
	$advanced = array(
		'general' => array(
			'responsive' => array(
				'name' => esc_html__( 'Responsive', 'anva' ),
				'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Responsive', 'anva' ), esc_html__( 'Apply special styles to tablets and mobile devices.', 'anva' ) ),
				'id' => "responsive",
				'std' => '1',
				'type' => 'checkbox',
			),
			'debug' => array(
				'name' => null,
				'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Debug' ), esc_html__( 'Display debug information in the footer.', 'anva' ) ),
				'id' => 'debug',
				'std' => '0',
				'type' => 'checkbox',
			),
		),
	);

	anva_add_option_tab( 'advanced', esc_html__( 'Advanced', 'anva' ), false, 'admin-settings' );
	anva_add_option_section( 'advanced', 'general', esc_html__( 'General', 'anva' ), null, $advanced['general'], false );

}
add_action( 'after_setup_theme', 'anva_theme_options', 9 );
