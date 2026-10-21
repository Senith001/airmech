<?php
if( !defined('ABSPATH')) exit; // Exit if accessed directly.

if( !class_exists('RTMEGA_MENU_Post_Types')){
    class RTMEGA_MENU_Post_Types{
        function __construct(){
            add_action('init', array($this, 'rtmega_register_post_types'));
            add_filter( 'allowed_block_types_all', array($this, 'rtmega_allowed_block_types_all'), 10, 2 );
        }

        function rtmega_register_post_types(){
            $labels = array(
                'name' => _x('RT Mega Menu', 'post type general name', 'rt-mega-menu'),
                'singular_name' => _x('RT Mega Menu', 'post type singular name', 'rt-mega-menu'),
                'menu_name' => _x('RT Mega Menu', 'admin menu', 'rt-mega-menu'),
                'name_admin_bar' => _x('RT Mega Menu', 'add new on admin bar', 'rt-mega-menu'),
                'add_new' => _x('Add New', 'add new', 'rt-mega-menu'),
                'add_new_item' => __('Add New RT Mega Menu', 'rt-mega-menu'),
                'new_item' => __('New RT Mega Menu', 'rt-mega-menu'),
                'edit_item' => __('Edit RT Mega Menu', 'rt-mega-menu'),
                'view_item' => __('View RT Mega Menu', 'rt-mega-menu'),
                'all_items' => __('All RT Mega Menu', 'rt-mega-menu'),
                'search_items' => __('Search RT Mega Menu', 'rt-mega-menu'),
                'parent_item_colon' => __('Parent RT Mega Menu:', 'rt-mega-menu'),
                'not_found' => __('No RT Mega Menu found.', 'rt-mega-menu'),
                'not_found_in_trash' => __('No RT Mega Menu found in Trash.', 'rt-mega-menu'),
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'query_var' => true,
                'rewrite' => array('slug' => 'rtmega-menu'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'author', 'thumbnail'),
                'show_in_rest' => true,
            );

            register_post_type('rtmega_menu', $args);
        }

        function rtmega_allowed_block_types_all( $allowed_blocks, $editor_context ) {
            $rtmega_allowed_blocks = $allowed_blocks;
            // Check the post type
            if ( isset( $editor_context->post ) && $editor_context->post->post_type === 'rtmega_menu' ) {
                // Allowed blocks for this post type
                $rtmega_allowed_blocks = [
                    'core/columns',
                    'core/column',
                    'core/group',
                    'core/row',
                    'core/stack',
                    'core/button',
                    'core/button-group',
                    'core/list',
                    'core/list-item',
                    'core/paragraph',
                    'core/image',
                    'core/heading',
                    'rt-mega-menu/mega-menu',
                    
                ];
            }

            // For other post types, allow all blocks
            return apply_filters( 'rtmega_allowed_block_types_all', $rtmega_allowed_blocks, $allowed_blocks, $editor_context );
        }
        
    }
    $RTMEGA_MENU_Post_Types = new RTMEGA_MENU_Post_Types();
}


