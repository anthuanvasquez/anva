<?php

/* ---------------------------------------------------------------- */
/* Site: Before / After
/* ---------------------------------------------------------------- */

/**
 * Before site. After the body tag.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_before() {
	do_action( 'anva_before' );
}

/**
 * After site. Before the body tag.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_after() {
	do_action( 'anva_after' );
}

/* ---------------------------------------------------------------- */
/* Header
/* ---------------------------------------------------------------- */


/**
 * This action is just to put valid head tags like meta tags.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_wp_head() {
	do_action( 'anva_wp_head' );
}

/**
 * Before top.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_top_before() {
	do_action( 'anva_top_before' );
}

/**
 * After top.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_top_after() {
	do_action( 'anva_top_after' );
}

/**
 * Header above.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_above() {
	do_action( 'anva_header_above' );
}

/**
 * Header below.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_below() {
	do_action( 'anva_header_below' );
}

/**
 * Header logo.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_logo() {
	do_action( 'anva_header_logo' );
}

/**
 * Header extras addons.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_extras() {
	do_action( 'anva_header_extras' );
}

/**
 * Primary menu.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_primary_menu() {
	do_action( 'anva_header_primary_menu' );
}

/**
 * Primary menu addons.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_primary_menu_addon() {
	do_action( 'anva_header_primary_menu_addon' );
}

/**
 * Secondary menu.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_header_secondary_menu() {
	do_action( 'anva_header_secondary_menu' );
}

/* ---------------------------------------------------------------- */
/* Featured
/* ---------------------------------------------------------------- */

/**
 * Before featured content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_featured_before() {
	do_action( 'anva_featured_before' );
}

/**
 * After featured content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_featured_after() {
	do_action( 'anva_featured_after' );
}

/**
 * Featured content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_featured() {
	do_action( 'anva_featured' );
}

/* ---------------------------------------------------------------- */
/* Footer
/* ---------------------------------------------------------------- */

/**
 * Bottom before.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_bottom_before() {
	do_action( 'anva_bottom_before' );
}

/**
 * Bottom after.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_bottom_after() {
	do_action( 'anva_bottom_after' );
}

/**
 * Footer above.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_footer_above() {
	do_action( 'anva_footer_above' );
}

/**
 * Footer below.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_footer_below() {
	do_action( 'anva_footer_below' );
}

/**
 * Footer content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_footer_content() {
	do_action( 'anva_footer_content' );
}

/**
 * Footer footer copyrights.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_footer_copyrights() {
	do_action( 'anva_footer_copyrights' );
}

/* ---------------------------------------------------------------- */
/* Sidebars
/* ---------------------------------------------------------------- */

/**
 * Sidebars.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_sidebars( $position ) {
	do_action( 'anva_sidebars', $position );
}

/* ---------------------------------------------------------------- */
/* Content
/* ---------------------------------------------------------------- */

/**
 * Breadcrumbs.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_breadcrumbs() {
	do_action( 'anva_breadcrumbs' );
}

/**
 * Content before.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_content_before() {
	do_action( 'anva_content_before' );
}

/**
 * Content after.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_content_after() {
	do_action( 'anva_content_after' );
}

/**
 * Layout above.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_above_layout() {
	do_action( 'anva_above_layout' );
}

/**
 * Layout below.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_below_layout() {
	do_action( 'anva_below_layout' );
}

/* ---------------------------------------------------------------- */
/* Posts
/* ---------------------------------------------------------------- */

/**
 * Posts title.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_title() {
	do_action( 'anva_posts_title' );
}

/**
 * Posts meta.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_meta() {
	do_action( 'anva_posts_meta' );
}

/**
 * Posts content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_content() {
	do_action( 'anva_posts_content' );
}

/**
 * Posts footer.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_footer() {
	do_action( 'anva_posts_footer' );
}

/**
 * Posts related.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_related() {
	do_action( 'anva_posts_related' );
}

/**
 * Before posts content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_content_before() {
	do_action( 'anva_posts_content_before' );
}

/**
 * After posts content.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_content_after() {
	do_action( 'anva_posts_content_after' );
}

/**
 * Posts comments.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_posts_comments() {
	do_action( 'anva_posts_comments' );
}

/**
 * Before posts comments.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_comments_before() {
	do_action( 'anva_comments_before' );
}

/**
 * After posts comments.
 *
 * @since   1.0.0
 * @return  void
 */
function anva_comments_after() {
	do_action( 'anva_comments_after' );
}