<?php
/**
 * Product custom post type
 * This file is the basic custom post type for use anywhere in the theme.
 * 
 * @package Product Post Type
 * @author ReacTheme
 * @link http://www.reactheme.com
 */

// Register Product Post Type
function reactheme_product_register_post_type() {
    $labels = array(
        'name'               => esc_html__( 'Product', 'rtelements'),
        'singular_name'      => esc_html__( 'Product', 'rtelements'),
        'add_new'            => esc_html_x( 'Add New Product', 'rtelements'),
        'add_new_item'       => esc_html__( 'Add New Product', 'rtelements'),
        'edit_item'          => esc_html__( 'Edit Product', 'rtelements'),
        'new_item'           => esc_html__( 'New Product', 'rtelements'),
        'all_items'          => esc_html__( 'All Product', 'rtelements'),
        'view_item'          => esc_html__( 'View Product', 'rtelements'),
        'search_items'       => esc_html__( 'Search Products', 'rtelements'),
        'not_found'          => esc_html__( 'No Products found', 'rtelements'),
        'not_found_in_trash' => esc_html__( 'No Products found in Trash', 'rtelements'),
        'parent_item_colon'  => esc_html__( 'Parent Product:', 'rtelements'),
        'menu_name'          => esc_html__( 'Products', 'rtelements'),
    ); 

    global $coolair_option;
	$product_slug = (!empty($coolair_option['product_slug']))? $coolair_option['product_slug'] :'rt-product';
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'can_export'         => true,
        'has_archive'        => false,
        'hierarchical'       => true,
        'menu_position'      => 20,       
        'rewrite' => 		 array('slug' => $product_slug,'with_front' => false),
        'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
        'supports'           => array( 'title', 'thumbnail', 'editor', 'page-attributes','excerpt' )
    );
    register_post_type( 'rt-products', $args );
}

add_action( 'init', 'reactheme_product_register_post_type' );

function reactheme_tr_create_product() {
    register_taxonomy(
        'rt-product-category',
        'rt-products',
        array(
            'label' => esc_html__( 'Product Categories','rtelements'),            
            'hierarchical' => true,
            'show_admin_column' => true,        
        )
    );
}
add_action( 'init', 'reactheme_tr_create_product' );

?>