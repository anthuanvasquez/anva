<?php
/**
 * WARNING: This template file is a core part of the
 * Woocommerce plugin.
 * @link https://wordpress.org/plugins/woocommerce/
 * 
 * This file contain extra settings for WooCommerce plugin.
 */

/**
 * Remove Woocoomerce Stylesheets
 */
function wc_change_styles( $styles ) {

	unset( $styles['woocommerce-layout'] );
	unset( $styles['woocommerce-smallscreen'] );
	unset( $styles['woocommerce-general'] );
	
	$styles['woocommerce-general'] = array(
		'src'     => get_stylesheet_directory_uri() . '/assets/css/woocommerce.css',
		'deps'    => '',
		'version' => '',
		'media'   => 'all'
	);
	return $styles;
}
add_filter( 'woocommerce_enqueue_styles', 'wc_change_styles' );

/**
 * Remove Woocommerce Scripts on unnecessary pages
 */
function wc_remove_script() {
	if ( function_exists( 'is_woocommerce' ) ) {
		// if we're not on a Woocommerce page, dequeue all of these scripts
		if ( ! is_front_page() && ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'jquery-cookie' );
			wp_dequeue_script( 'wc-cart-fragments' );
		}
	}
}
add_action( 'wp_print_scripts', 'wc_remove_script', 100 );

/**
 * Remove Woocommerce generator tag from head
 */
function wc_remove_woocommerce_generator() {
	if ( function_exists( 'is_woocommerce' ) ) {
		// if we're not on a woo page, remove the generator tag
		if ( ! is_woocommerce() ) {
			remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'wc_remove_woocommerce_generator', 99 );

/**
 * Load Woocoomerce Mod Stylesheet
 */
function wc_load_scripts() {
	wp_enqueue_style( 'woocommerce-screen', get_template_directory_uri() . '/assets/css/woocommerce-screen.css' );
}
add_action( 'wp_enqueue_scripts', 'wc_load_scripts' ); 

/**
 * Add woocomemrce sidebar locations
 */
function wc_add_sidebar_locations( $locations ) {

	// Add shop shidebar
	$locations['shop'] = array(
		'args' => array(
			'id' => 'shop',
			'name' => __( 'Shop', ANVA_DOMAIN ),
			'description' => __( 'Shop Sidebar.', ANVA_DOMAIN ),
		),
	);

	// Add product sidebar
	$locations['product'] = array(
		'args' => array(
			'id' => 'product',
			'name' => __( 'Product', ANVA_DOMAIN ),
			'description' => __( 'Product Sidebar.', ANVA_DOMAIN ),
		),
	);

	return $locations;
}
add_filter( 'anva_get_sidebar_locations', 'wc_add_sidebar_locations' );

/*
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 */
function wc_related_products_limit() {
	global $product;
	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'wc_related_products_limit' );

/*
 * Change product columns number on shop pages
 */
function wc_product_columns_frontend() {
		global $woocommerce;

		// Default Value also used for categories and sub_categories
		$columns = 3;

		//Related Products
		if ( is_product() ) :
			$columns = 3;
		endif;

	return $columns;
}
add_filter( 'loop_shop_columns', 'wc_product_columns_frontend' );

/*
 * Use WC 2.0 variable price format
 */
function wc_variation_price_format( $price, $product ) {
	$min_price = $product->get_variation_price( 'min', true );
	$price = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $min_price ) ); // Add From: ?
	return $price;
}
add_filter( 'woocommerce_variable_sale_price_html', 'wc_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_variation_price_format', 10, 2 );

/*
 * Add Payment Type to Emails
 */
function wc_add_payment_type_to_emails( $order, $is_admin_email ) {
	$heading = "
		color:#333333;
		display:block;
		font-family:Arial;
		font-size:14px;
		font-weight:bold;
		margin:15px 0 10px;
		text-align:left;
		line-height:150%;
		padding:5px;
		background:#ddd;
	";
	echo '<h2 style="'.$heading.'">Payment Method:</h2>';
	echo '<p><strong>Payment Type:</strong> ' . $order->payment_method_title . '</p>';
}
add_action( 'woocommerce_email_after_order_table', 'wc_add_payment_type_to_emails', 15, 2 );

/*
 * Change text onsale
 */
function wc_custom_sale_flash( $text, $post, $_product ) {
	return '<span class="onsale">Sale!</span>';  
}
add_filter('woocommerce_sale_flash', 'wc_custom_sale_flash', 10, 3);