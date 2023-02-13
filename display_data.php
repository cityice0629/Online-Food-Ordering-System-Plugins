<?php
/*
Plugin Name: Display Data on Product Page
Description: Display Data on Product Page
Author: Shi Bin
*/

function custom_data_on_product_page_styles() {
    echo "<style>
            .custom-data {
                border: solid 2px green;
                padding: 10px;
                color: green;
            }
            .data-item {
                margin-bottom: 10px;
                border-bottom: solid 1px green;
                padding-bottom: 10px;
            }
        </style>";
}
add_action('wp_head', 'custom_data_on_product_page_styles');

function get_custom_data() {
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM online_food_ordering.product");
    return $results;
}

function custom_data_on_product_page() {
    global $product;
    $product_id = $product->get_id();
    $custom_data = get_custom_data();
    if (!empty($custom_data)) {
        echo "<div class='custom-data'>";
        foreach ($custom_data as $data) {
            if ($data->product_id == $product_id) {
                echo "Nutritional Facts <br>";
                echo "1 portion - 100g <br>";
                echo "<div class='data-item'>";
                echo "Average nutritional values <br>";
                echo "</div>";
                echo "<div class='data-item'>";
                echo "Name : ".$data->name."<br>";
                echo "</div>";
                echo "<div class='data-item'>";
                echo "Description : ".$data->description."<br>";
                echo "</div>";
                echo "<div class='data-item'>";
                echo "Price : ".$data->price."<br>";
                echo "</div>";
                echo "<div class='data-item'>";
                echo "Energy Value : ".$data->energy_value."%<br>";
                echo "</div>";
                echo "<div class='data-item'>";
				echo "Proteins : ".$data->proteins."%<br>";
                echo "</div>";
                echo "<div class='data-item'>";
				echo "Fats (of which saturated fatty acids): ".$data->fats."%<br>";
                echo "</div>";
                echo "<div class='data-item'>";
				echo "Carbohydrates (from which sugars) : ".$data->carbohydrates."%<br>";
                echo "</div>";
                echo "<div class='data-item'>";
				echo "Fibers : ".$data->fibers."%<br>";
                echo "</div>";
                echo "<div class='data-item'>";
				echo "Salt (Sodium) : ".$data->salt."%<br>";
                echo "</div>";
                echo "<div class='data-item'>";
				echo "Magnesium : ".$data->magnesium."%<br>";
                echo "</div>";
                echo " *RPC = Reference quantities <br>";
                echo " for abn average adult <br>";
                echo " (8,400 kJ / 2,000 kcal <br>";
                break;
            }
        }
        echo "</div>";
    }
}
add_action('woocommerce_single_product_summary', 'custom_data_on_product_page', 30);
