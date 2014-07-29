<?php
/**
 * This file contain extra settings for
 * WooCommerce plugin
 */

/**
 * Load Woocoomerce Mod Stylesheet
 * @since 1.5.0
 */
add_action( 'wp_enqueue_scripts', 'wc_load_scripts' ); 
function wc_load_scripts() {
	if ( class_exists('Woocommerce' ) ) {
		wp_enqueue_style( 'woocommerce-mod', get_template_directory_uri() . '/assets/css/woocommerce-mod.css' );
	}
}

/*
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 * @since 1.5.0
 */
add_filter( 'woocommerce_output_related_products_args', 'wc_related_products_limit' );
function wc_related_products_limit() {
	
	global $product;
	
	$args['posts_per_page'] = 3;
	
	return $args;
}

/*
 * Change product columns number on shop pages
 * @since 1.5.0
 */
add_filter( 'loop_shop_columns', 'woo_product_columns_frontend' );
function woo_product_columns_frontend() {
		global $woocommerce;

		// Default Value also used for categories and sub_categories
		$columns = 3;

		//Related Products
		if ( is_product() ) :
				$columns = 3;
		endif;

	return $columns;
}

/* Use WC 2.0 variable price format
 * @since 1.5.0
 */
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );
function wc_wc20_variation_price_format( $price, $product ) {
	$min_price = $product->get_variation_price( 'min', true );
	$price = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $min_price ) ); // Add From: ?
	return $price;
}

/*
 * Add Payment Type to Emails
 * @since 1.5.0
 */
add_action( 'woocommerce_email_after_order_table', 'wc_add_payment_type_to_emails', 15, 2 );
function wc_add_payment_type_to_emails( $order, $is_admin_email ) {
	$heading = "
			color:#333333;
			display:block;
			font-family:
			Arial;
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

/*
 * Change text onsale
 * @since 1.5.0
 */
add_filter('woocommerce_sale_flash', 'wc_custom_sale_flash', 10, 3);
function wc_custom_sale_flash( $text, $post, $_product ) {
  return '<span class="onsale">Sale!</span>';  
}