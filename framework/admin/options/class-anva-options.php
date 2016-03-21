<?php

class Anva_Options {

	/**
	 * Gets option name.
	 *
	 * @since 1.0.0
	 */
	public function get_option_name() {

		$name = '';

		// Gets option name as defined in the theme
		if ( function_exists( 'anva_option_name' ) ) {
			$name = anva_option_name();
		}

		// Fallback
		if ( '' == $name ) {
			$name = get_option( 'stylesheet' );
			$name = preg_replace( "/\W/", "_", strtolower( $name ) );
		}

		return apply_filters( 'anva_option_name', $name );

	}

	/**
	 * Allows for manipulating or setting options via 'anva_options' filter.
	 *
	 * @since  1.0.0
	 * @return array $options
	 */
	public function get_options() {

		// Get options from api class Anva_Options_API
		$options = anva_get_formatted_options();

		// Allow setting/manipulating options via filters
		$options = apply_filters( 'anva_options', $options );

		return $options;
	}

}