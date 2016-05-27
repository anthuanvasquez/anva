<?php

add_action( 'wp_ajax_anva_ajax_search', 'anva_ajax_search' );
add_action( 'wp_ajax_nopriv_anva_ajax_search', 'anva_ajax_search' );

/**
 * Ajax Search Auto Complete.
 *
 * @global $wpdb
 *
 * @since  1.0.0
 */
function anva_ajax_search() {

	global $wpdb;

	if ( strlen( $_POST['s'] ) > 0 ) {

		$limit    = 5;
		$s        = strtolower(addslashes($_POST['s']));

		$querystr = "
			SELECT $wpdb->posts.*
			FROM $wpdb->posts
			WHERE 1 = 1 AND ((lower($wpdb->posts.post_title) like %s))
			AND $wpdb->posts.post_type IN ('post', 'page', 'attachment', 'projects', 'galleries')
			AND (post_status = 'publish')
			ORDER BY $wpdb->posts.post_date DESC
			LIMIT $limit;
		";

		$pageposts = $wpdb->get_results( $wpdb->prepare( $querystr, '%'. $wpdb->esc_like( $s ) .'%' ), OBJECT);

		$html = '';

		if ( ! empty( $pageposts ) ) {

			$html .= '<ul>';

			foreach ( $pageposts as $result_item ) {

				$post            = $result_item;
				$post_type       = get_post_type( $post->ID );
				$post_type_class = '';
				$post_type_title = '';
				$post_thumb = array();

				$html .= '<li class="mpost clearfix">';

				if ( has_post_thumbnail( $post->ID ) ) {

					$image_id   = get_post_thumbnail_id( $post->ID );
					$post_thumb = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
					$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

					if ( isset( $post_thumb[0] ) && ! empty( $post_thumb[0] ) ) {
						$thumbnail = '<img class="img-circle" src="' . $post_thumb[0] . '" alt="' . esc_attr( $image_alt ) . '"/></div>';
						$html .= '<div class="entry-image">';
						$html .= '<a class="nobg" href="' . get_permalink( $post->ID ) . '">' . $thumbnail . '</a>';
						$html .= '</div>';
					}
				}

				$html .= '<div class="entry-c">';
				$html .= '<div class="entry-title">';
				$html .= '<h4><a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</h4>';
				$html .= '<ul class="entry-meta">';
				$html .= '<li>' . date( THEMEDATEFORMAT, strtotime( $post->post_date ) ) . '</li>';
				$html .= '</ul>';
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</li>';
			}

			$html .= '<li class="view-all"><a href="javascript:jQuery(\'#searchform\').submit()">' . __( 'View All Results', 'anva' ) . '</a></li>';
			$html .= '</ul>';
		}

		echo $html;

	}

	die();
}
