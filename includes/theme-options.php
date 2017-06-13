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
 * @link        https://anthuanvasquez.net
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

	// Include options files.
	include_once( 'options/options-styles.php' );
	include_once( 'options/options-layout.php' );
	include_once( 'options/options-feature.php' );
	include_once( 'options/options-advanced.php' );

	/**
	 * Styles Tab Options.
	 */
	$styles = anva_theme_options_styles();

	anva_add_option_tab( 'styles', esc_html__( 'Styles', 'anva' ), true, 'admin-appearance' );
	anva_add_option_section( 'styles', 'general', esc_html__( 'General', 'anva' ), null, $styles['general'] );
	anva_add_option_section( 'styles', 'links', esc_html__( 'Links', 'anva' ), null, $styles['links'], false );
	anva_add_option_section( 'styles', 'header', esc_html__( 'Header', 'anva' ), null, $styles['header'], false );
	anva_add_option_section( 'styles', 'navigation', esc_html__( 'Navigation', 'anva' ), null, $styles['navigation'], false );
	anva_add_option_section( 'styles', 'footer', esc_html__( 'Footer', 'anva' ), null, $styles['footer'], false );
	anva_add_option_section( 'styles', 'social_icons', esc_html__( 'Social Icons', 'anva' ), null, $styles['social_icons'], false );
	anva_add_option_section( 'styles', 'background', esc_html__( 'Background', 'anva' ), null, $styles['background'], false );
	anva_add_option_section( 'styles', 'typography', esc_html__( 'Typography', 'anva' ), null, $styles['typography'], false );
	anva_add_option_section( 'styles', 'custom', esc_html__( 'Custom', 'anva' ), null, $styles['custom'], false );

	/**
	 * Layout Tab Options.
	 */
	$layout = anva_theme_options_layout();

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

	/**
	 * Feature Tab Options.
	 */
	$feature = anva_theme_options_feature();

	anva_add_option_tab( 'features', esc_html__( 'Features', 'anva' ), false, 'pressthis' );
	anva_add_option_section( 'features', 'gallery', esc_html__( 'Galleries', 'anva' ), null, $feature['gallery'], false );
	anva_add_option_section( 'features', 'slideshows', esc_html__( 'Slideshows', 'anva' ), null, $feature['slideshows'], false );

	// Login Feature Support.
	if ( anva_support_feature( 'anva-login' ) ) {
		anva_add_option_section( 'features', 'login', esc_html__( 'Login', 'anva' ), null, $feature['login'], false );
	}

	/**
	 * Advanced Tab Options.
	 */
	$advanced = anva_theme_options_advanced();

	anva_add_option_tab( 'advanced', esc_html__( 'Advanced', 'anva' ), false, 'admin-settings' );
	anva_add_option_section( 'advanced', 'general', esc_html__( 'General', 'anva' ), null, $advanced['general'], false );

}
add_action( 'after_setup_theme', 'anva_theme_options', 9 );
