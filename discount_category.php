<?php
/*
Plugin Name: Woocommerce Discount Category
Description: A plugin that applies a 50% discount to all products in the WooCommerce cart and displays the discounted price on the product page and product list page.
Version: 1.0
Author: Tan Shi Bin
*/
add_action( 'woocommerce_before_calculate_totals', 'apply_cart_discount' );
add_action( 'woocommerce_single_product_summary', 'display_discounted_price', 15 );
add_filter( 'woocommerce_get_price_html', 'custom_price_html', 10, 2 );

function apply_cart_discount( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) {
        return;
    }

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id = $cart_item['product_id'];
        $terms = get_the_terms( $product_id, 'product_cat' );
        $category_name = !empty( $terms[0]->name ) ? $terms[0]->name : '';

        if ( $category_name === 'Rice' ) {
            $price = $cart_item['data']->get_price();
            $discounted_price = $price * 0.5;
            $cart_item['data']->set_price( $discounted_price );
        }
    }
}

function display_discounted_price() {
    global $product;
    $price = $product->get_price();
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    $category_name = !empty( $terms[0]->name ) ? $terms[0]->name : '';
    
    if ( $category_name === 'Rice' ) {
        $discounted_price = $price * 0.5;
        echo '<p style="text-decoration: line-through;">' . wc_price( $price ) . '</p>';
        echo '<p>Discounted Price: ' . wc_price( $discounted_price ) . '</p>';
    }
}



function custom_price_html( $price_html, $product ) {
    if ( has_term( 'Rice', 'product_cat', $product->get_id() ) ) {
        $price = $product->get_price();
        $discounted_price = $price * 0.5;
        $price_html = '<p style="text-decoration: line-through;">' . wc_price( $price ) . '</p>';
        $price_html .= '<p>Discounted Price: ' . wc_price( $discounted_price ) . '</p>';
    }
    return $price_html;
}

