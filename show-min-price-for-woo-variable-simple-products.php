<?php

/**
 * @snippet Show min price for WooCommerce Variable/Simple Products
 */

add_filter('woocommerce_get_price_html', 'force_display_min_price_with_prefix', 10, 2);

function force_display_min_price_with_prefix($price, $product) {
    // If the product is variable
    if ($product->is_type('variable')) {
        $prices = $product->get_variation_prices(true);

        // Get the minimum price among variations
        $min_price = !empty($prices['price']) ? current($prices['price']) : '';

        // If a minimum price is found, format it
        if (!empty($min_price)) {
            $price = wc_price($min_price);
        }
    } 
    // If the product is simple
    else {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        // Use sale price if available, otherwise regular price
        if (!empty($sale_price)) {
            $price = wc_price($sale_price);
        } elseif (!empty($regular_price)) {
            $price = wc_price($regular_price);
        }
    }

    // Add "From" text before the price
    if (!empty($price)) {
        $price = sprintf(__('From: %s', 'woocommerce'), $price);
    }
	
	// Add "net" text at the end of the price
    if (!empty($price)) {
        $price .= ' ' . __('net', 'woocommerce');
    }

    return $price;
}

?>