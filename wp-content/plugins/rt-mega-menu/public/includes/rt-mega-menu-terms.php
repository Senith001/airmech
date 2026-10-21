<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
class RTMEGA_MENU_Term_Meta{

    /**
     * Singleton
     */
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    private function __construct(){

        add_filter( 'wp_setup_nav_menu_item', [ $this, 'custom_nav_fields_data' ] );
        add_filter('wp_nav_menu_args', [ $this, '_change_nav_menu_args' ], PHP_INT_MAX);

    }

    public function custom_nav_fields_data( $menu_item ){

        // Get Menu Item Custom Data
        $item_settings = get_post_meta( $menu_item->ID, 'rtmega_menu_settings', true );


        if( !empty( $item_settings['rtmega_template'] ) ){
            $menu_item->template = $item_settings['rtmega_template'];
        }

        return $menu_item;
    }

    function _change_nav_menu_args( $args ){

        if ( is_admin() ) {
            return $args;
        }

        $current_theme_location = isset( $args['theme_location'] ) ? $args['theme_location'] : '';

        $locations = get_nav_menu_locations();

        // Menu ID
        if ( ! isset( $locations[ $current_theme_location ] ) ) return $args;     
        $menu_id = isset( $locations[ $current_theme_location ] ) ? $locations[ $current_theme_location ] : '';
        if ( ! $menu_id ) return $args;

        // Menu And Location
        if (!empty($locations[$args['theme_location']])) {
            $menu = wp_get_nav_menu_object($locations[$args['theme_location']]);
        } elseif (!empty($args['menu'])) {
            $menu = wp_get_nav_menu_object($args['menu']);
        } else {
            $menus = (array)wp_get_nav_menus();
            if ($menus) {
                foreach ($menus as $menu) {
                    $has_items = wp_get_nav_menu_items($menu->term_id, ['update_post_term_cache' => false]);
                    if ($has_items) break;
                }
            }
        }

        if (!isset($menu) || is_wp_error($menu) || !is_object($menu)) {
            return $args;
        }
        
        $settings = [];	
        $menu = wp_get_nav_menu_object($menu_id);

        if ($menu) {
            $menu_slug = $menu->slug;
            $settings = get_option( 'rtmega_menu_settings_'.$menu_slug);
        } 
       

        if ( is_array( $settings ) && isset( $settings['enable_menu'] ) && $settings['enable_menu'] === 'on' ) {


            $mobile_btn_icon = '<svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect y="14" width="18" height="2" fill="#000000"></rect>
					<rect y="7" width="18" height="2" fill="#000000"></rect>
					<rect width="18" height="2" fill="#000000"></rect>
				</svg>';

            $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
				
                
            // Mobile Menu
            $rtmega_mobile_menu_html_btn = '<div class="rtmega-menu-mobile-button-wrapper enabled-mobile-menu"><a href="#" class="rtmega-menu-mobile-button"></div>'.$mobile_btn_icon.'</a>';
            $rtmega_mobile_menu_html = '<div class="mobile-menu-area"><div class="overlay" onclick="closeRTMEGAmobile()"></div><div class="rtmega-menu-mobile-sidebar"><a class="rtmega-menu-mobile-close" onclick="closeRTMEGAmobile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M317.7 402.3c3.125 3.125 3.125 8.188 0 11.31c-3.127 3.127-8.186 3.127-11.31 0L160 267.3l-146.3 146.3c-3.127 3.127-8.186 3.127-11.31 0c-3.125-3.125-3.125-8.188 0-11.31L148.7 256L2.344 109.7c-3.125-3.125-3.125-8.188 0-11.31s8.188-3.125 11.31 0L160 244.7l146.3-146.3c3.125-3.125 8.188-3.125 11.31 0s3.125 8.188 0 11.31L171.3 256L317.7 402.3z"/></svg></a><div class="rtmega-menu-mobile-navigation"><ul id="%1$s" class="%2$s">%3$s</ul></div></div></div>';

            
            // Desktop Menu
            $items_wrap = '<div class="desktop-menu-area"><ul id="%1$s" class="%2$s">%3$s</ul></div>
            <div class="mobile-menu-area"><ul id="%1$s" class="%2$s">%3$s</ul></div>';

            $args = [
                'menu'            => $args['menu'],
                'menu_id'         => $args['menu_id'],
                'theme_location'  => $args['theme_location'],
                'container'       => 'div',
                'container_id'    => $args['container_id'],
                'menu_class'      => 'menu desktop-menu rtmega-megamenu default-nav',
				'container_class' => 'menu-wrapper rtmega-menu-container default-nav-container rtmega-menu-area',
                'fallback_cb'     => false,
                'before'          => $args['before'],
                'after'           => $args['after'],
                'link_before'     => $args['link_before'],
                'link_after'      => $args['link_after'],
                'echo'            => $args['echo'],
                'depth'           => $args['depth'],
                'items_wrap'      => $items_wrap,
                'item_spacing'    => isset($args['item_spacing']) ? $args['item_spacing'] : '',
                'submenu_parent_icon' => $submenu_parent_icon,
                'pointer_hover_effect' => 'none',
                'is_mobile_menu'	=> 'no',
                'walker'          => new RTMEGA_Nav_Walker()
            ];
            return apply_filters( 'rtmegamenu_nav_menu_args', $args );

        }else{ return $args; }

    }
}

RTMEGA_MENU_Term_Meta::instance();


// Topbar Hide
use Elementor\Controls_Manager;
use Elementor\Element_Base;

defined('ABSPATH') || die();

class RT_WIDGET_INJECTION_STICKY {
    public static function init() {
        add_action('elementor/element/container/section_layout/after_section_end', [__CLASS__, 'rt_inject_sticky_topbar_option'], 1);
    }

    public static function rt_inject_sticky_topbar_option(Element_Base $element) {
        $element->start_controls_section(
            '_section_sticky_settings',
            [
                'label' => __('Topbar Hide', 'rt-mega-menu'),
                'tab'   => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'sticky_topbar_description',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => __('Note: If there is a topbar, You can hide the top bar by turning on Sticky.', 'rt-mega-menu'),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $element->add_control(
            'rt__topbar_hide',
            [
                'label'        => esc_html__('Topbar Hide', 'rt-mega-menu'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'rt-mega-menu'),
                'label_off'    => esc_html__('No', 'rt-mega-menu'),
                'return_value' => 'rt-topbar-hide',
                'default'      => '',
                'prefix_class' => '',
            ]
        );

        $element->end_controls_section();
    }
}

RT_WIDGET_INJECTION_STICKY::init();