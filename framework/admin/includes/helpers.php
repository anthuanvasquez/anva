<?php
/**
 * Admin helper functions.
 *
 * @package AnvaFramework
 */

/**
 * Pull all the layouts into array;
 *
 * @since  1.0.0
 * @return array The layouts list.
 */
function anva_pull_layouts() {
	$layouts = array();
	foreach ( anva_get_sidebar_layouts() as $key => $value ) {
		$layouts[ $key ] = $value['icon'];
	}
	return $layouts;
}

/**
 * Pull all the categories into an array.
 *
 * @since  1.0.0
 * @return array The categories list.
 */
function anva_pull_categories() {
	$categories = array();
	foreach ( get_categories() as $category ) {
		$categories[ $category->cat_ID ] = $category->cat_name;
	}
	return $categories;
}


/**
 * Pull all the pages into an array.
 *
 * @since  1.0.0
 * @return array The pages list.
 */
function anva_pull_pages() {
	$pages = array();
	$pages[''] = __( 'Select a page', 'anva' ) . ':';
	foreach ( get_pages( 'sort_column=post_parent,menu_order' ) as $page ) {
		$pages[ $page->ID ] = $page->post_title;
	}
	return $pages;
}
