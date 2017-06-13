<?php

/**
 * Blog posts filter by categories.
 *
 * @since 1.0.0.
 */
function anva_blog_posts_filter() {

	$column  = apply_filters( 'anva_template_filter_ajax_columns', 3 );
	$items   = apply_filters( 'anva_template_filter_ajax_items', 6 );
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
		'numberposts' => $items,
	);

	if ( isset( $_POST['cat'] ) && ! empty( $_POST['cat'] ) && 'all' !== $_POST['cat'] ) {
		$args['category_name'] = $_POST['cat'];
	}

	$query = anva_get_posts( $args );

	while ( $query->have_posts() ) : $query->the_post();
		anva_get_template_part( 'grid' );
	endwhile;

	wp_reset_postdata();

	die();
}
