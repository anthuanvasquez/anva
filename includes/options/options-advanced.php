<?php
/**
 * Advanced options.
 *
 * @package AnvaFramework
 */

/**
 * Advanced options tab.
 *
 * @since  1.0.0
 * @return array $advanced Options array.
 */
function anva_theme_options_advanced() {
	$advanced = array(
		'general' => array(
			'responsive' => array(
				'name' => esc_html__( 'Responsive', 'anva' ),
				'desc' => sprintf( '<strong>%s:</strong> %s', esc_html__( 'Responsive', 'anva' ), esc_html__( 'Apply special styles to tablets and mobile devices.', 'anva' ) ),
				'id' => 'responsive',
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
	return $advanced;
}
