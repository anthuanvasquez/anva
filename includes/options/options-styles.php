<?php
/**
 * Styles options.
 *
 * @package AnvaFramework
 */

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Styles options tab.
 *
 * @since  1.0.0
 * @return array $styles Options array.
 */
function anva_theme_options_styles() {

	// Assets theme path.
	$skin_path = trailingslashit( get_template_directory_uri() . '/assets/images/skins' );

	// Skin Colors.
	$schemes = array();
	foreach ( anva_get_colors_scheme( $skin_path, 'jpg' ) as $color_id => $color ) {
		$schemes[ $color_id ] = $color['image'];
	}

	// Background defaults.
	$background_defaults = array(
		'image'         => '',
		'repeat'        => 'repeat',
		'position'      => 'top center',
		'attachment'    => 'scroll',
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
					'stretched' => esc_attr__( 'Stretched', 'anva' ),
				),
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
				'options' => $schemes,
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
				),
			),
		),
		'links' => array(
			'link_color' => array(
				'name' => esc_html__( 'Link Color', 'anva' ),
				'desc' => esc_html__( 'Choose the link color.', 'anva' ),
				'id' => 'link_color',
				'std' => '#3498db',
				'type' => 'color',
			),
			'link_color_hover' => array(
				'name' => esc_html__( 'Link Color (:Hover)', 'anva' ),
				'desc' => esc_html__( 'Choose the link color on :Hover state.', 'anva' ),
				'id' => 'link_color_hover',
				'std' => '#222222',
				'type' => 'color',
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
				'receivers' => 'primary_menu_font',
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
					'color'  => '#444444',
				),
				'type' => 'typography',
				'options' => array(
					'style',
					'weight',
					'face',
					'color',
				),
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
					'dark'   => esc_attr__( 'Dark', 'anva' ),
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
				'type' => 'color',
			),
			'footer_link_color_hover' => array(
				'name' => esc_html__( 'Link Color (:Hover)', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color on :Hover state.', 'anva' ),
				'id' => 'footer_link_color_hover',
				'std' => '#555555',
				'type' => 'color',
			),
			'footer_dark_link_color' => array(
				'name' => esc_html__( 'Dark Link Color', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color when the footer is dark.', 'anva' ),
				'id' => 'footer_dark_link_color',
				'std' => '#555555',
				'type' => 'color',
			),
			'footer_dark_link_color_hover' => array(
				'name' => esc_html__( 'Dark Link Color (:Hover)', 'anva' ),
				'desc' => esc_html__( 'Choose the footer link color on :Hover state when the footer is dark.', 'anva' ),
				'id' => 'footer_dark_link_color_hover',
				'std' => '#ffffff',
				'type' => 'color',
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
					'default'    => esc_attr__( 'Default Style', 'anva' ),
					'light'      => esc_attr__( 'Light', 'anva' ),
					'dark'       => esc_attr__( 'Dark', 'anva' ),
					'text-color' => esc_attr__( 'Text Colored', 'anva' ),
					'colored'    => esc_attr__( 'Colored', 'anva' ),
				),
			),
			'social_icons_shape' => array(
				'name' => esc_html__( 'Social Icons Shape', 'anva' ),
				'desc' => esc_html__( 'choose the shape for your social icons.', 'anva' ),
				'id' => 'social_icons_shape',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default'   => esc_html__( 'Default Shape', 'anva' ),
					'rounded'   => esc_html__( 'Rounded', 'anva' ),
				),
			),
			'social_icons_border' => array(
				'name' => esc_html__( 'Social Icons Border', 'anva' ),
				'desc' => esc_html__( 'Choose the shape for your social icons.', 'anva' ),
				'id' => 'social_icons_border',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default'   => esc_html__( 'Default Border', 'anva' ),
					'borderless'    => esc_html__( 'Without Border', 'anva' ),
				),
			),
			'social_icons_size' => array(
				'name' => esc_html__( 'Social Icons Size', 'anva' ),
				'desc' => esc_html__( 'Choose the size for your social icons.', 'anva' ),
				'id' => 'social_icons_size',
				'std' => 'default',
				'type' => 'select',
				'options' => array(
					'default'   => esc_html__( 'Default Size', 'anva' ),
					'small'     => esc_html__( 'Small', 'anva' ),
					'large'     => esc_html__( 'Large', 'anva' ),
				),
			),
		),
		'background' => array(
			'background_color' => array(
				'name' => esc_html__( 'Background Color', 'anva' ),
				'desc' => esc_html__( 'Choose the background color.', 'anva' ),
				'id' => 'background_color',
				'std' => '#dddddd',
				'type' => 'color',
			),
			'background_image' => array(
				'name' => esc_html__( 'Background Image', 'anva' ),
				'desc' => esc_html__( 'Choose the background image. Note: this option only take effect if layout style is boxed.', 'anva' ),
				'id' => 'background_image',
				'std' => $background_defaults,
				'type' => 'background',
			),
			'background_cover' => array(
				'name' => null,
				'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Cover', 'anva' ), esc_html__( 'Fill background screen with the image.', 'anva' ) ),
				'id' => 'background_cover',
				'std' => '0',
				'type' => 'checkbox',
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
					'color'  => '#555555',
				),
				'type' => 'typography',
				'options' => array(
					'size',
					'weight',
					'style',
					'face',
					'color',
				),
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
					'color'  => '#444444',
				),
				'type' => 'typography',
				'options' => array(
					'size',
					'weight',
					'face',
					'color',
				),
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
					'color'  => '#444444',
				),
				'type' => 'typography',
				'options' => array(
					'face',
				),
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
				'options' => array(
					'face',
				),
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
				),
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
				),
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
				),
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
				),
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
				),
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
				),
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
			),
		),
	);

	return $styles;
}

