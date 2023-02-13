<?php
/*
Plugin Name: Woocommerce Discount All
Description: A plugin that applies a 50% discount to all products in the WooCommerce cart and displays the discounted price on the product page and product list page.
Version: 1.0
Author: Tan Shi Bin
*/

add_action( 'woocommerce_before_calculate_totals', 'apply_cart_discount' );
add_filter( 'woocommerce_get_price_html', 'display_discounted_price', 10, 2 );

function apply_cart_discount( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
        return;
    }

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $price = $cart_item['data']->get_price();
        $discounted_price = $price * 0.5;
        $cart_item['data']->set_price( $discounted_price );
    }
}

function display_discounted_price( $price_html, $product ) {
    $price = $product->get_price();
    $discounted_price = $price * 0.5;
    $price_html = '<p style="text-decoration: line-through;">' . wc_price( $price ) . '</p>';
    $price_html .= '<p>Discounted Price: ' . wc_price( $discounted_price ) . '</p>';
    return $price_html;
}
