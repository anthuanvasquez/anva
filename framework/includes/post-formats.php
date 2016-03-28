<?php

/**
 * Extract a quote from first line of passed content, if
 * possible. Checks for a <blockquote> on the first line of the
 * content or [blockquote] shortcode.
 *
 * @since 1.0.0
 * @param string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_get_content_quote( $content, $run = true ) {

    if ( empty( $content ) ) {
        return '';
    }

    $trimmed = trim( $content);
    $lines = explode( "\n", $trimmed );
    $line = trim( array_shift( $lines ) );

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
 * @since 1.0.0
 * @param string $content A string which might contain a URL, passed by reference.
 * @return string The found URL.
 */
function anva_content_quote() {

    // Only continue if this is a "quote" format post.
    if ( ! has_post_format( 'quote' ) ) {
        return;
    }

    echo anva_get_content_quote( get_the_content() );
}