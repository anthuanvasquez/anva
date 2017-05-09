<?php
// Get current breadcrumbs
$current_breadcrumb = anva_get_post_meta( '_anva_breadcrumbs' );

// Set default breadcrumbs
if ( empty ( $current_breadcrumb ) ) {
    $current_breadcrumb = anva_get_option( 'breadcrumbs', 'show' );
}

// Display breadcrumbs
if ( 'show' == $current_breadcrumb ) {
	anva_the_breadcrumbs();
}
