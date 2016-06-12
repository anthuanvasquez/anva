<?php

add_action('wp_ajax_anva_blog_posts_filter', 'anva_blog_posts_filter');
add_action('wp_ajax_nopriv_anva_blog_posts_filter', 'anva_blog_posts_filter');

/**
 * Blog posts filter by categories.
 *
 * @since 1.0.0.
 */
function anva_blog_posts_filter() {

	$items = apply_filters( 'anva_blog_posts_filter_items', 6 );
	$column = apply_filters( 'anva_blog_posts_filter_grid', 3 );
	$counter = 0;

	if ( isset( $_POST['items'] ) ) {
		$items = $_POST['items'];
	}

	if ( isset( $_POST['grid'] ) ) {
		$column = $_POST['grid'];
	}

	// Get recent posts
	$args = array(
		'order'       => 'DESC',
		'orderby'     => 'date',
		'post_type'   => array( 'post' ),
		'numberposts' => $items
	);

	if ( isset( $_POST['cat'] ) && ! empty( $_POST['cat'] ) && $_POST['cat'] != 'all' ) {
		$args['category_name'] = $_POST['cat'];
	}

	$query = anva_get_posts( $args );

	while ( $query->have_posts() ) : $query->the_post();
		anva_get_template_part( 'grid' );
	endwhile;

	wp_reset_postdata();

	die();
}
