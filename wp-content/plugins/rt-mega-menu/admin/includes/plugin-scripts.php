<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
add_action( 'enqueue_block_editor_assets', 'rtmega_menu_admin_enqueue_scripts' );
add_action('admin_enqueue_scripts', 'rtmega_menu_admin_enqueue_scripts');
function rtmega_menu_admin_enqueue_scripts (){

    if ( ! current_user_can( 'edit_theme_options' ) ) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');

    wp_enqueue_style( 'rtmegamenu-admin-style', RTMEGA_MENU_PL_URL . 'admin/assets/css/rtmega-menu-admin.css', array(), RTMEGA_MENU_VERSION );

    $rtmega_admin_js_deps = array('jquery');
    $screen = get_current_screen();
    if ( is_object($screen) && $screen->is_block_editor() ) {
        $rtmega_admin_js_deps = array_merge($rtmega_admin_js_deps, array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components', 'wp-hooks' ));
    }

    wp_enqueue_script( 'rtmegamenu-admin', RTMEGA_MENU_PL_URL . 'admin/assets/js/rtmega-menu-admin.js', $rtmega_admin_js_deps, RTMEGA_MENU_VERSION, TRUE );
    wp_enqueue_script( 'rtmegamenu-template', RTMEGA_MENU_PL_URL . 'admin/assets/js/rtmega-template.js', array('jquery'), RTMEGA_MENU_VERSION, TRUE );

    $pro_warning_msg = 'Please use Premium Verison of this plugin to use this advanced features!';
    if ( get_option( 'rtmega_license_key' ) !== false ) {
        $pro_warning_msg = 'Please activate plugin license to use this advanced features!';
    }


    $current_user = wp_get_current_user();

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $selected_menu_id = isset( $_REQUEST['menu'] ) ? absint( wp_unslash( $_REQUEST['menu'] ) ) : 0;
    if ( ! $selected_menu_id ) {
        $selected_menu_id = get_user_option( 'nav_menu_recently_edited' );
    }
    
    // Validate if menu exists
    $rtmega_menu_options_check = wp_get_nav_menu_object( $selected_menu_id );
    if ( ! $rtmega_menu_options_check ) {
        $nav_menus = wp_get_nav_menus();
        if ( ! empty( $nav_menus ) ) {
            $selected_menu_id = $nav_menus[0]->term_id;
        } else {
            $selected_menu_id = 0;
        }
    }

    $rtmega_menu_options_switch = '';
    $rtmega_active_menu_items = [];

    if( $selected_menu_id > 0) {
        $menu = wp_get_nav_menu_object($selected_menu_id);
        if ($menu) {
            $menu_slug = $menu->slug;
            $rtmega_menu_options = get_option( 'rtmega_menu_settings_'.$menu_slug);
            $rtmega_menu_options_switch = isset($rtmega_menu_options['enable_menu']) ? $rtmega_menu_options['enable_menu'] : '';
        }
        
        $menu_items = wp_get_nav_menu_items( $selected_menu_id );
        if ( $menu_items ) {
            foreach ( $menu_items as $menu_item ) {
                 $rtmega_menu_item_settings = get_post_meta($menu_item->ID, 'rtmega_menu_settings', true);
                 if ( isset($rtmega_menu_item_settings['content']['rtmega_template']) && !empty($rtmega_menu_item_settings['content']['rtmega_template']) ) {
                     $rtmega_active_menu_items[] = $menu_item->ID;
                 }
            }
        }
    }

    wp_localize_script(
            'rtmegamenu-admin', 
            'rtmegamenu_ajax',
                [
                    'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                    'adminURL'         => admin_url(),
                    'postEditUrl'      => admin_url( 'post.php?action=edit&post=' ),    
                    'elementorURL'     => admin_url( 'edit.php?post_type=elementor_library' ),
                    'nonce'            => wp_create_nonce('rtmega_templates_import_nonce'),
                    'version'          => RTMEGA_MENU_VERSION,
                    'pluginURL'        => plugin_dir_url( __FILE__ ),
                    'ajaxLoaderUrl'    => RTMEGA_MENU_PL_URL . 'admin/assets/img/ajax-loader.gif',
                    'packagedesc'      => __( 'Templates in this package', 'rt-mega-menu' ),
                    'rtmega_pro_warning_msg' => ( $pro_warning_msg ),
                    'rtmega_menu_options_switch' => $rtmega_menu_options_switch,
                    'rtmega_active_menu_items' => $rtmega_active_menu_items,
                    'user'             => [
                        'email' => $current_user->user_email,
                    ]
                ]
        );

}

