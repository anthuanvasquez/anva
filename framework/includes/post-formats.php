<?php

/**
 * Get the icon ID to represent a post format.
 *
 * @since  1.0.0
 * @param  string $format Post format
 * @param  book $force Force icon return, if no post format
 * @return string FontAwesime icon ID
 */
function anva_get_post_format_icon( $format = '', $force = false ) {

	$icon = '';
	$post_type = get_post_type();

	if ( ! $format && $force ) {
		switch ( $post_type ) {
			case 'page' :               // Standard Pages
				$format = 'page';
				break;
			case 'attachment' :         // Media Library
				$format = 'attachment';
				break;
			case 'attachment' :         // Gallery
				$format = 'gallery';
				break;
			case 'portfolio' :          // Portfolio
				$format = 'portfolio';
				break;
			case 'product' :            // WooCommerce
				$format = 'product';
				break;
			default :                   // Standard Post
				$format = 'standard';
		}
	}

	$icons = apply_filters( 'anva_post_format_icons', array(
		'standard'   => 'pencil',
		'audio'      => 'music2',
		'aside'      => 'file-text',
		'attachment' => 'picture',
		'chat'       => 'comments',
		'gallery'    => 'picture',
		'image'      => 'camera-retro',
		'link'       => 'link',
		'page'       => 'file',
		'portfolio'  => 'briefcase',
		'product'    => 'shopping-cart',
		'quote'      => 'quote-left',
		'status'     => 'align-justify2',
		'video'      => 'film'
	) );

	if ( ! empty( $icons[ $format ] ) ) {
		$icon = $icons[ $format ];
	}

	return apply_filters( 'anva_post_format_icon', $icon, $format, $force, $post_type );
}

function anva_content_status() {

	if ( ! has_post_format( 'status' ) ) {
		return;
	}

	$content = get_the_content();

	if ( $content ) {
		printf( '<div class="panel panel-default"><div class="panel-body">%s</div></div>', $content );
	}
	
}

/**
 * Filter out the first URL or HTML link of the
 * content in a "Link" format post.
 *
 * @since  1.0.0
 * @param  string $content Content of post
 * @return string $content Filtered content of post
 */
function anva_content_format_link( $content ) {

	// Only continue if this is a "link" format post.
	if ( ! has_post_format( 'link' ) ) {
		return $content;
	}

	// Get the URL from the content.
	$url = anva_get_content_link( $content );

	// Remove that URL from the start of content,
	// if that's where it was.
	if ( $url ) {
		$content = str_replace( $url[0], '', $content ); // $url[0] is first line of content
	}

	return $content;

}

/**
 * Extract a URL from first line of passed content, if
 * possible. Checks for a URL on the first line of the
 * content or and <a> tag.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_get_content_link( $content ) {

	if ( empty( $content ) ) {
		return '';
	}

	$trimmed = trim( $content );
	$lines = explode( "\n", $trimmed );
	$line = trim( array_shift( $lines ) );

	$find_link = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";

	if ( preg_match( "/$find_link/siU", $line, $matches ) ) {

		// First line of content is HTML link
		return array( $line, $matches[2] );

	} else if ( stripos( $line, 'http' ) === 0 ) {

		// First line of content is URL
		return array( $line, esc_url_raw( $line ) );

	}

	return '';
}

function anva_content_link() {

	if ( ! has_post_format( 'link' ) ) {
		return;
	}

	$url = anva_get_content_link( get_the_content(), false );

	if ( $url ) {
		printf( '<a href="%1$s" class="entry-link" target="_blank">%2$s <span>- %1$s</span></a>', $url[0], get_the_title() );
	}
	
}

/**
 * Filter out the first video from the
 * content in a "Video" format post.
 *
 * @since  1.0.0
 * @param  string $content Content of post
 * @return string $content Filtered content of post
 */
function anva_content_format_video( $content ) {

	// Only continue if this is a "link" format post.
	if ( ! has_post_format( 'video' ) ) {
		return $content;
	}

	// Get the URL from the content.
	$video = anva_get_content_video( $content, false );

	// Remove that URL from the start of content,
	// if that's where it was.
	if ( $video ) {
		$content = str_replace( $video, '', $content );
	}

	return $content;

}

/**
 * Extract a video from first line of passed content, if
 * possible. Checks for a <blockquote> on the first line of the
 * content or the first encountered href attribute.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_get_content_video( $content, $run = true ) {

	if ( empty( $content ) ) {
		return '';
	}

	$trimmed = trim( $content );
	$lines = explode( "\n", $trimmed );
	$line = trim( array_shift( $lines ) );

	// Video oembed get
	if ( strpos( $line, 'http' ) === 0 ) {
		if ( $run ) {
			return wp_oembed_get( $line );
		} else {
			return $line;
		}
	}

	// [video]
	if ( strpos( $trimmed, '[video' ) === 0 ) {

		$end = strpos( $trimmed, '[/video]' ) + 8;
		$video = substr( $trimmed, 0, $end );

		if ( $run ) {
			$video = do_shortcode( $video );
		}

		return $video;
	}

	return '';
}

/**
 * Display first video from current post's content in the loop.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_content_video() {

	// Only continue if this is a "video" format post.
	if ( ! has_post_format( 'video' ) ) {
		return;
	}

	$video = anva_get_content_video( get_the_content() );

	if ( $video && apply_filters( 'anva_featured_thumb_frame', false ) ) {
		$video = sprintf( '<div class="thumbnail">%s</div>', $video );
	}

	echo $video;
}

/**
 * Filter out the first audio from the
 * content in a "Audio" format post.
 *
 * @since  1.0.0
 * @param  string $content Content of post
 * @return string $content Filtered content of post
 */
function anva_content_format_audio( $content ) {

	// Only continue if this is a "audio" format post.
	if ( ! has_post_format( 'audio' ) ) {
		return $content;
	}

	// Get the URL from the content.
	$audio = anva_get_content_audio( $content, false );

	// Remove that URL from the start of content,
	// if that's where it was.
	if ( $audio ) {
		$content = str_replace( $audio, '', $content );
	}

	return $content;

}

/**
 * Extract a audio from first line of passed content, if
 * possible. Checks for a <blockquote> on the first line of the
 * content or the first encountered href attribute.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_get_content_audio( $content, $run = true ) {

	if ( empty( $content ) ) {
		return '';
	}

	$trimmed = trim( $content);
	$lines = explode( "\n", $trimmed );
	$line = trim( array_shift( $lines ) );

	// Audio oembed get
	if ( strpos( $line, 'http' ) === 0 ) {
		if ( $run ) {
			return wp_oembed_get( $line );
		} else {
			return $line;
		}
	}

	// [audio]
	if ( strpos( $trimmed, '[audio') === 0 ) {

		$end = strpos( $trimmed, '[/audio]' ) + 8;
		$audio = substr( $trimmed, 0, $end );

		if ( $run ) {
			$audio = do_shortcode( $audio );
		}

		return $audio;
	}

	// [soundcloud]
	if ( strpos( $trimmed, '[soundcloud') === 0 ) {

		$end = strpos( $trimmed, '[/soundcloud]' ) + 13;
		$audio = substr( $trimmed, 0, $end );

		if ( $run ) {
			$audio = do_shortcode( $audio );
		}

		return $audio;
	}

	return '';
}

/**
 * Display first audio from current post's content in the loop.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_content_audio() {

	// Only continue if this is a "audio" format post.
	if ( ! has_post_format( 'audio' ) ) {
		return;
	}

	$audio = anva_get_content_audio( get_the_content(), false );
	$img = get_the_post_thumbnail( get_queried_object_id(), 'full' );

	//var_dump(strpos( $audio, 'http' ));

	if ( strpos( $audio, 'http' ) === 0 ) {

		$audio = wp_oembed_get( $audio );

		if ( apply_filters( 'anva_featured_thumb_frame', false ) ) {
			$audio = sprintf( '<div class="thumbnail">%s</div>', $audio );
		}

	} else {
		$audio = do_shortcode( $audio );
	}

	if ( $img ) {
		printf( '<div class="entry-audio-image">%s<div class="audio-wrap">%s</div></div>', $img, $audio );
	} else {
		echo $audio;
	}
}

/**
 * Filter out the first quote from the
 * content in a "Quote" format post.
 * (Framework does not implement by default)
 *
 * @since  1.0.0
 * @param  string $content Content of post
 * @return string $content Filtered content of post
 */
function anva_content_format_quote( $content ) {

	// Only continue if this is a "quote" format post.
	if ( ! has_post_format( 'quote' ) ) {
		return $content;
	}

	// Get the quote from the content.
	$quote = anva_get_content_quote( $content, false );

	// Remove that quote from the start of content,
	// if that's where it was.
	if ( $quote ) {
		$content = str_replace( $quote, '', $content );
	}

	return $content;

}

/**
 * Extract a quote from first line of passed content, if
 * possible. Checks for a <blockquote> on the first line of the
 * content or [blockquote] shortcode.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_get_content_quote( $content, $run = true ) {

	if ( empty( $content ) ) {
		return '';
	}

	$trimmed = trim( $content);
	$lines   = explode( "\n", $trimmed );
	$line    = trim( array_shift( $lines ) );

	// [blockquote]
	if ( strpos( $line, '[blockquote' ) === 0 ) {
		if ( $run ) {
			return do_shortcode( $line );
		} else {
			return $line;
		}
	}

	// <blockquote>
	if ( strpos( $trimmed, '<blockquote') === 0 ) {
		$end = strpos( $trimmed, '</blockquote>' ) + 13;
		return substr( $trimmed, 0, $end );
	}

	return '';
}

/**
 * Display first quote from current post's content in the loop.
 *
 * @since  1.0.0
 * @param  string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_content_quote() {

	// Only continue if this is a "quote" format post.
	if ( ! has_post_format( 'quote' ) ) {
		return;
	}

	echo anva_get_content_quote( get_the_content() );
}