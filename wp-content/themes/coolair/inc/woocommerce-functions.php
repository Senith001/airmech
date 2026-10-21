<?php
    /* All Functions for woocommerce
    -----------------------------------------*/
    /*-------------------------------------
    #. Theme supports for WooCommerce
    ---------------------------------------*/

    function mindthera_add_woocommerce_support() {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-slider');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
    }
    add_action('after_setup_theme', 'mindthera_add_woocommerce_support');


    /* Shop hide default page title */
    function mindthera_wc_hide_page_title() {
        return false;
    }
    add_filter('woocommerce_show_page_title', 'mindthera_wc_hide_page_title');


    /* Loop shop per page */
    if (!function_exists('mindthera_wc_loop_shop_per_page')) {
        function mindthera_wc_loop_shop_per_page() {
            global $coolair_option;
            $layout = !empty($coolair_option['wc_num_product']) ? $coolair_option['wc_num_product'] : 9;
            return $layout;
        }
    }
    add_action('loop_shop_per_page', 'mindthera_wc_loop_shop_per_page');

    // Change number or products per row
    if (!function_exists('mindthera_loop_columns')) {
        function mindthera_loop_columns() {
            global $coolair_option;
            $layout_col = !empty($coolair_option['wc_num_product_per_row']) ? $coolair_option['wc_num_product_per_row'] : 3;
            return $layout_col;
        }
    }
    add_filter('loop_shop_columns', 'mindthera_loop_columns');
    

    /**
     * Change number of related products output
     */ 
 
    add_filter( 'woocommerce_output_related_products_args', 'mindthera_related_products_args', 20 );
        function mindthera_related_products_args( $args ) {
        $args['posts_per_page'] = 3; // 4 related products
        $args['columns'] = 3; // arranged in 2 columns
        return $args;
    }
    function after_shop_loop_item_title() {
        return false;
    }

    /* Breadcrumb Remove Action*/
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    
    /* woocommerce sidebar remove */
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

    /* Product ID Name*/
    function mindthera_get_all_products_id_name() {
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => array('product', 'product_variation'),
        );
        $products   = [];
        $Q_products = new WP_Query($args);
        $QP_product = $Q_products->posts;
        if (is_array($QP_product)) {
            foreach ($QP_product as $prod) {
                $products[$prod->ID] = get_the_title($prod->ID);
            }
        }
        return $products;
    }


    // Woocommerce checkout page

    add_filter('woocommerce_checkout_fields', 'mindthera_override_checkout_fields');
    function mindthera_override_checkout_fields($fields) {
        $fields['shipping']['shipping_first_name']['placeholder'] = esc_html__('First Name', 'mindthera');
        $fields['shipping']['shipping_last_name']['placeholder']  = esc_html__('Last Name', 'mindthera');
        $fields['billing']['billing_first_name']['placeholder']   = esc_html__('First Name', 'mindthera');
        $fields['billing']['billing_last_name']['placeholder']    = esc_html__('Last Name', 'mindthera');
        $fields['billing']['billing_company']['placeholder']      = esc_html__('Business Name', 'mindthera');
        $fields['billing']['billing_company']['label']            = esc_html__('Business Name', 'mindthera');
        $fields['shipping']['shipping_company']['placeholder']    = esc_html__('Company Name', 'mindthera');
        $fields['billing']['billing_email']['placeholder']        = esc_html__('Email Address', 'mindthera');
        $fields['billing']['billing_phone']['placeholder']        = esc_html__('Phone', 'mindthera');
        $fields['billing']['billing_state']['placeholder']        = esc_html__('State', 'mindthera');
        $fields['billing']['billing_city']['placeholder']         = esc_html__('City', 'mindthera');
        $fields['billing']['billing_postcode']['placeholder']     = esc_html__('Post Code', 'mindthera');
        return $fields;
    }

    add_filter('woocommerce_sale_flash', 'mindthera_add_percentage_to_sale_badge', 20, 3);

    function mindthera_add_percentage_to_sale_badge($html, $post, $product) {
        if ($product->is_type('variable')) {
            $percentages = array();
            // Get all variation prices
            $prices = $product->get_variation_prices();
            // Loop through variation prices
            foreach ($prices['price'] as $key => $price) {
                // Only on sale variations
                if ($prices['regular_price'][$key] !== $price) {
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round(100 - (floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100));
                }
            }
            // We keep the highest value
            $percentage = max($percentages) . '%';
        } elseif ($product->is_type('grouped')) {
            $percentages = array();
            // Get all variation prices
            $children_ids = $product->get_children();
            // Loop through variation prices
            foreach ($children_ids as $child_id) {
                $child_product = wc_get_product($child_id);
                $regular_price = (float) $child_product->get_regular_price();
                $sale_price    = (float) $child_product->get_sale_price();
                if ($sale_price != 0 || !empty($sale_price)) {
                    // Calculate and set in the array the percentage for each child on sale
                    $percentages[] = round(100 - ($sale_price / $regular_price * 100));
                }
            }
            // We keep the highest value
            $percentage = max($percentages) . '%';
        } else {
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();
            if ($sale_price != 0 || !empty($sale_price)) {
                $percentage = round(100 - ($sale_price / $regular_price * 100)) . '%';
            } else {
                return $html;
            }
        }

        return '<span class="onsale sale-rs">' . esc_html__('-', 'mindthera') . $percentage . '</span>';
    }