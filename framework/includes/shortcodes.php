<?php

/*
 * Shortcodes
 */
function anva_shortcodes_setup() {
	
	add_shortcode( 'dropcap', 'dropcap_func' );
	add_shortcode( 'button', 'button_func' );
	add_shortcode( 'toggle', 'toggle_func' );
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
add_filter( 'after_setup_theme', 'anva_shortcodes_setup'  );

/*
 * Dropcap
 */
function dropcap_func( $atts, $content ) {
	extract( shortcode_atts( array(
		'style' => 1
	), $atts ));
	$first_char = substr( $content, 0, 1 );
	$text_len 	= strlen( $content );
	$rest_text 	= substr( $content, 1, $text_len );
	$html  			= '<span class="dropcap">' . $first_char . '</span>';
	$html 		 .= wpautop( $rest_text );
	return $html;
}

/*
 * Buttons
 */
function button_func( $atts, $content )  {
	extract( shortcode_atts( array(
		'href' => '#',
		'align' => 'none',
		'color' => '',
		'size' => 'btn-sm',
		'target' => '_self',
	), $atts ));

	$bg = '';
	$text = '';

	if ( ! empty( $color ) ) {
		switch( strtolower( $color ) ) {
			case 'black':
				$bg 	= '#000000';
				$text = '#ffffff';
				break;
			case 'grey':
				$bg 	= '#666666';
				$text = '#ffffff';
				break;
			case 'white':
				$bg	= '#f5f5f5';
				$text = '#444444';
				break;
			case 'blue':
				$bg 	= '#3498DB';
				$text = '#ffffff';
				break;
			case 'yellow':
				$bg 	= '#F1C40F';
				$text = '#ffffff';
				break;
			case 'red':
				$bg 	= '#ff0000';
				$text = '#ffffff';
				break;
			case 'orange':
				$bg 	= '#ff9900';
				$text = '#ffffff';
				break;
			case 'green':
				$bg 	= '#2ECC71';
				$text = '#ffffff';
				break;
			case 'pink':
				$bg 	= '#ed6280';
				$text = '#ffffff';
				break;
			case 'purple':
				$bg 	= '#9B59B6';
				$text = '#ffffff';
				break;
		}
	}
	
	if ( ! empty( $bg ) ) {
		$border = $bg;
	} else {
		$border = 'transparent';
	}
	
	if ( ! empty( $bg ) ) { 
		$html = '<a class="btn ' . $size . ' align' . $align . '" style="background-color:' . $bg . ';border:1px solid ' . $border . ';color:' . $text . ';"';
	} else {
		$html = '<a class="btn ' . $size . ' align' . $align . '"';
	}
	
	if ( ! empty( $href ) ) {
		$html .= ' onclick="window.open(\'' . $href . '\', \'' . $target . '\')"';
	}

	$html .= '>' . $content . '</a>';

	return $html;
}

/*
 * Six columns
 */
function column_six_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
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
	$content = wpautop( trim( $content ) );
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	$html = '<div class="grid_6 grid_last '. $class .'">'. $content . '</div><div class="clearfixfix"></div>';
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
	$html .= '<div class="clearfixfix"></div>';
	return $html;
}

/*
 * Toggle
 */
function toggle_func( $atts, $content ) {
	$content = wpautop( trim( $content ) );
	extract( shortcode_atts( array(
		'title' => __( 'Click para Abrir', ANVA_DOMAIN ),
		'id' => 'default',
		'collapse' => '',
		''
	), $atts ));
	$html  = '<div class="panel-group">';
	$html .= '<div class="panel panel-default">';
	$html .= '<div class="panel-heading">';
	$html .= '<h4 class="panel-title">';
	$html .= '<a href="#'. $id .'" data-toggle="collapse">'. $title .'</a>';
	$html .= '</h4>';
	$html .= '</div>';
	$html .= '<div id="'. $id .'" class="panel-collapse collapse">';
	$html .= '<div class="panel-body">'. $content . '</div>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';	
	return $html;
}
