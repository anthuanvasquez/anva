<?php
/**
 * CSS Minify Stylesheets.
 *
 * @since      1.0.0
 * @author     Anthuan Vásquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2015, Anthuan Vásquez
 * @link       http://anthuanvasquez.net/
 */
class CSS_Minify
{

	private $original_css;

	private $compressed_css;

	private $files;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->original_css = '';
		$this->compressed_css = '';
		$this->files = array();
	}

	/**
	 * Add file as string (path and filename).
	 * 
	 * @param string|null $file
	 */
	public function add_file( $file = null )
	{

		if ( $file != null && $file != '' && substr( strrchr( $file, '.' ), 1 ) == 'css' && is_file( $file ) ) {
			$this->files[] = $file;
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Add multiple files array.
	 * 
	 * @param array|null $files [description]
	 */
	public function add_files( $files = null )
	{
		if ( $files != null && is_array( $files ) ) {
			$ok = true;
			foreach ( $files as $file ) {
				$ok = $this->add_file( $file );
			}
			return $ok;
		} else {
			return false;
		}
	}

	/**
	 * Print original css files concatenated.
	 * 
	 * @param  boolean $header
	 * @return string
	 */
	public function print_original_css( $header = false )
	{
		if ( $header ) {
			header( 'Content-type: text/css' );
		}
		return $this->original_css;
	}

	/**
	 * Print compressed css files concatenated.
	 * 
	 * @param  boolean $header
	 * @return string
	 */
	public function print_compressed_css( $header = false )
	{
		if ( $header ) {
			header( 'Content-type: text/css' );
		}
		return $this->compressed_css;
	}

	/**
	 * Sets original css loop thru all added files.
	 */
	public function set_original_css()
	{
		foreach ( $this->files as $file ) {
			$fh = fopen( $file, 'r' );
			$this->original_css .= fread( $fh, filesize( $file ) );
			fclose( $fh );
		}
	}

	/**
	 * Make simple compression with regexp.
	 */
	public function compress_css()
	{
		$patterns = array();
		$replacements = array();

		/* Remove multiline comments */
		$patterns[] = '/\/\*.*?\*\//s';
		$replacements[] = '';

		/* Remove tabs, spaces, newlines, etc. */
		$patterns[] = '/\r\n|\r|\n|\t|\s\s+/';
		$replacements[] = '';

		/* Remove whitespace on both sides of colons :*/
		$patterns[] = '/\s?\:\s?/';
		$replacements[] = ':';

		/* Remove whitespace on both sides of curly brackets {} */
		$patterns[] = '/\s?\{\s?/';
		$replacements[] = '{';
		$patterns[] = '/\s?\}\s?/';
		$replacements[] = '}';

		/* Remove whitespace on both sides of commas , */
		$patterns[] = '/\s?\,\s?/';
		$replacements[] = ',';

		/* Compress */
		$this->compressed_css = preg_replace( $patterns, $replacements, $this->original_css );
	}
}