<?php

add_filter( 'the_content', 'anva_fix_shortcodes' );
add_filter( 'after_setup_theme', 'anva_shortcodes_init' );

/*
 * Shortcodes
 */
function anva_shortcodes_init() {
	
	add_shortcode( 'drop', 'anva_dropcap' );
	add_shortcode( 'button', 'anva_button' );
	add_shortcode( 'toggle', 'anva_toggle' );
	add_shortcode( 'counter', 'anva_counter' );

	add_shortcode( 'column_full', 'column_full' );
	add_shortcode( 'column_six', 'column_six_func' );
	add_shortcode( 'column_six_last', 'column_six_last_func' );	
	add_shortcode( 'column_four', 'column_four_func' );
	add_shortcode( 'column_four_last', 'column_four_last_func' );	
	add_shortcode( 'column_three', 'column_three_func' );
	add_shortcode( 'column_three_last', 'column_three_last_func' );	
	add_shortcode( 'column_two', 'column_two_func' );
	add_shortcode( 'column_two_last', 'column_two_last_func' );
	add_shortcode( 'column_one', 'column_one_func' );
	add_shortcode( 'column_one_last', 'column_one_last_func' );
	
}

function anva_fix_shortcodes( $content ) {
	$array = array (
		'<p>[' 		=> '[', 
		']</p>' 	=> ']', 
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}

/*
 * Buttons
 */
function anva_button( $atts, $content ) {

	extract( shortcode_atts( array(
		'href' 		=> '',
		'align' 	=> '',
		'icon'		=> '',
		'size' 		=> '',
		'color'		=> '',
		'style'		=> '',
		'target' 	=> '',
	), $atts ));

	$classes = array();

	if ( ! empty( $icon ) ) {
		$icon = '<i class="fa fa-'. $icon .'"></i>';
	}

	if ( ! empty( $align ) ) {
		$classes[] = 'align'. $align;
	}

	if ( ! empty( $href ) ) {
		$href	= 'href="'. $href .'"';
	}

	if ( ! empty( $target ) ) {
		$target = 'target="'. $target .'"';
	}

	switch ( $style ) {
		case 'round':
			$classes[] = 'button-rounded';
			break;

		case '3d':
			$classes[] = 'button-3d';
			break;
	}

	// Sizes
	switch ( $size ) {
		case 'mini':
			$classes[] = 'button-mini';
			break;
		
		case 'small':
			$classes[] = 'button-small';
			break;

		case 'large':
			$classes[] = 'button-large';
			break;

		case 'xlarge':
			$classes[] = 'button-xlarge';
			break;
	}

	// Colors
	switch ( $color ) {
		case 'orange':
			$classes[] = 'button-orange';
			break;
	}

	$classes = implode( ' ', $classes );
	
	$html  = '<a class="button '. $classes . '" '. $href .' '. $target .'>';
	$html .= $icon;
	$html .= $content;
	$html .= '</a>';

	return $html;
}

/*
 * Six columns
 */
function column_six_func( $atts, $content ) {
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_6 '. $class .'">'. $content . '</div>';
	return $html;
}

/*
 * Six columns last
 */
function column_six_last_func( $atts, $content ) {
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_6 grid_last '. $class .'">'. $content . '</div>';
	return $html;
}

/*
 * Four columns
 */
function column_four_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_4 '. $class .'">'. $content . '</div>';
	return $html;
}

/*
 * Four columns last
 */
function column_four_last_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_4 grid_last '. $class .'">'. $content . '</div><div class="clearfix"></div>';
	return $html;
}

/*
 * Three columns
 */
function column_three_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_3 '. $class .'">'. $content . '</div>';
	return $html;
}

/*
 * Three columns last
 */
function column_three_last_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_3 grid_last '. $class .'">'. $content . '</div><div class="clearfix"></div>';
	return $html;
}

/*
 * Two columns
 */
function column_two_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_2 '. $class .'">'. $content . '</div>';
	return $html;
}

/*
 * Two columns last
 */
function column_two_last_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_2 grid_last '. $class .'">'. $content . '</div><div class="clearfix"></div>';
	return $html;
}

/*
 * One column
 */
function column_one_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract( shortcode_atts( array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_1 '. $class .'">' . $content . '</div>';
	return $html;
}

/*
 * One column last
 */
function column_one_last_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract( shortcode_atts( array(
		'class' => '',
	), $atts ));
	$html  = '<div class="grid_1 grid_last '. $class .'">' . $content . '</div>';
	$html .= '<div class="clearfix"></div>';
	return $html;
}

function column_full( $atts, $content ) {
	extract( shortcode_atts( array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_12 '. $class .'">' . $content . '</div>';
	return $html;
}

/*
 * Dropcap
 */
function anva_dropcap( $atts, $content ) {
	extract( shortcode_atts( array(
		'style' => ''
	), $atts ));

	$first_char = substr( $content, 0, 1 );
	$text_len 	= strlen( $content );
	$rest_text 	= substr( $content, 1, $text_len );
	$classes 		= '';

	switch ( $style ) {
		case 'bg':
			$classes .= 'dropcap-bg';
			break;
		case 'border':
			$classes .= 'dropcap-border';
			break;
	}

	$html  = '<span class="dropcap '. $classes .'">' . $first_char . '</span>';
	$html .= wpautop( $rest_text );
	return $html;
}

/*
 * Toggle
 */
function anva_toggle( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract( shortcode_atts( array(
		'title' 	=> __( 'Click para ver el Contenido', ANVA_DOMAIN ),
		'id' 			=> '',
		'style'		=> ''
	), $atts ));

	$classes = '';

	if ( ! empty( $id ) ) {
		$id = 'id="'. esc_attr( $id ) . '"';
	}

	switch ( $style ) {
		case 'bg':
			$classes .= 'toggle-bg';
			break;
		case 'border':
			$classes .= 'toggle-border';
			break;
	}

	$html  = '<div class="toggle '. esc_attr( $classes ) .'" '. $id .'>';
	$html .= '<div class="toggle-title" "><i class="toggle-closed fa fa-minus-circle"></i><i class="toggle-open fa fa-plus-circle"></i>'. esc_html( $title ) .'</div>';
	$html .= '<div class="toggle-content">'. $content . '</div>';
	$html .= '</div>';	
	return $html;
}

/*
 * Counter
 */
function anva_counter( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract( shortcode_atts( array(
		'from' 			=> 0,
		'to' 				=> 100,
		'interval'	=> 100,  // Refresh interval
		'speed' 		=> 2000, // Speed animation
		'size'			=> ''
	), $atts ));

	$classes = '';

	switch ( $size ) {
		case 'small':
			$classes = 'counter-small';
			break;
		case 'large':
			$classes = 'counter-large';
			break;
	}

	$html  = '<div class="counter text-center '. $classes .'">';
	$html .= '<span data-from="'. $from .'" data-to="'. $to .'" data-refresh-interval="'. $interval .'" data-speed="'. $speed .'"></span>';
	$html .= '</div>';
	return $html;
}
