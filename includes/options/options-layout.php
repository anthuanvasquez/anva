<?php

function anva_theme_options_layout() {

	// Transitions.
	$transitions = array();
	foreach ( range( 0, 14 ) as $key ) {
		$transitions[ $key ] = esc_attr__( 'Loader Style', 'anva' ) . ' ' . $key;
	}
	$transitions[0] = esc_attr__( 'Disable Transition', 'anva' );
	$transitions[1] = esc_attr__( 'Default Loader Style', 'anva' );

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
			),
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
			'class' => 'hidden',
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
			'class' => 'hidden',
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
				'options' => $transitions,
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
				'options' => $transition_animations,
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
					''       => esc_attr__( 'None', 'anva' ),
					'style1' => esc_attr__( 'Style 1', 'anva' ),
					'style2' => esc_attr__( 'Style 2', 'anva' ),
					'style3' => esc_attr__( 'Style 3', 'anva' ),
				),
			),
			'login_copyright' => array(
				'name' => esc_html__( 'Copyright Text', 'anva' ),
				'desc' => esc_html__( 'Enter the copyright text you\'d like to show in the footer of your login page.', 'anva' ),
				'id' => 'login_copyright',
				'std' => sprintf(
					'%s %s %s. %s <a href="%s" target="_blank">%s</a>.',
					esc_html__( 'Copyright', 'anva' ),
					date( 'Y' ),
					esc_html( anva_get_theme( 'name' ) ),
					esc_html__( 'Designed by', 'anva' ),
					esc_url( 'https://anthuanvasquez.net' ),
					esc_html__( 'Anthuan Vasquez', 'anva' )
				),
				'type' => 'textarea',
			),
		),
	);

	return $layout;
}
