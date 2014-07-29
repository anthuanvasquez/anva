<?php

/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 */

add_action( 'wp_enqueue_scripts', 'wc_load_scripts' ); 
function wc_load_scripts() {
	wp_enqueue_style( 'woocommerce-mod', get_template_directory_uri() . '/assets/css/woocommerce-mod.css' );
}

// Change number of related products on product page
// Set your own value for 'posts_per_page'
// -----------------------------------------------
add_filter( 'woocommerce_output_related_products_args', 'wc_related_products_limit' );
function wc_related_products_limit() {
	
	global $product;
	
	$args['posts_per_page'] = 3;
	
	return $args;
}

// Change product columns number on shop pages
// -----------------------------------------------
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

// Use WC 2.0 variable price format
// -----------------------------------------------
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );
function wc_wc20_variation_price_format( $price, $product ) {
	$min_price = $product->get_variation_price( 'min', true );
	$price = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $min_price ) ); // Add From: ?
	return $price;
}

// Add Payment Type to Emails
// -----------------------------------------------
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

// Change text onsale
// -----------------------------------------------
add_filter('woocommerce_sale_flash', 'wc_custom_sale_flash', 10, 3);
function wc_custom_sale_flash( $text, $post, $_product ) {
  return '<span class="onsale">Sale!</span>';  
}
 
// add_action( 'woocommerce_email_after_order_table', 'wc_add_payment_type_to_admin_emails', 15, 2 );
// function wc_add_payment_type_to_admin_emails( $order, $is_admin_email ) {
// 	if ( $is_admin_email ) {
// 		$heading = "
// 			color:#333333;
// 			display:block;
// 			font-family:
// 			Arial;
// 			font-size:14px;
// 			font-weight:bold;
// 			margin:15px 0 10px;
// 			text-align:left;
// 			line-height:150%;
// 			padding:5px;
// 			background:#ddd;
// 		";

// 		echo '<h2 style="'.$heading.'">Payment Method:</h2>';
// 		echo '<p><strong>Payment Type:</strong> ' . $order->payment_method_title . '</p>';
// 	}
// }

// add_filter( 'woocommerce_enqueue_styles', 'wc_change_styles' );
// function wc_change_styles( $styles ) {
// 	unset( $styles['woocommerce-layout'] );
// 	unset( $styles['woocommerce-smallscreen'] );
// 	$styles['woocommerce-layout'] = array(
// 		'src'     => get_stylesheet_directory_uri() . '/assets/css/woocommerce-layout.css',
// 		'deps'    => '',
// 		'version' => '',
// 		'media'   => 'all'
// 	);
// 	return $styles;
// }

// add_filter( 'woocommerce_variable_price_html', 'custom_variation_price', 10, 2 );
// function custom_variation_price( $price, $product ) {
// 	$price = '';
// 	if ( ! $product->min_variation_price || $product->min_variation_price !== $product->max_variation_price ) {
// 		$price .= '<span class="from">' . _x('From', 'min_price', 'woocommerce') . ' </span>';
// 	}	
// 	$price .= woocommerce_price($product->get_price());
// 	if ( $product->max_variation_price && $product->max_variation_price !== $product->min_variation_price ) {
// 		$price .= '<span class="to"> ' . _x('to', 'max_price', 'woocommerce') . ' </span>';
// 		$price .= woocommerce_price($product->max_variation_price);
// 	}
// 	return $price;
// }