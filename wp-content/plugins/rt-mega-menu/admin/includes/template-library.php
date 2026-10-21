<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
define('RTMEGA_TEMPLATES_SOURCE_SITE_URL', 'https://rtmega.themewant.com');
define('RTMEGA_PRO_SITE_URL', 'https://themewant.com/downloads/rt-mega-menu-pro/#pricing_section');
class RTMEGA_MENU_Template_Library{ 

    public static $templateapi = '';
    public static $api_args = [];

    // Get Instance
    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct(){
        if ( is_admin() ) {
            add_action( 'admin_menu', [ $this, 'admin_menu' ], 225 );
            add_action( 'wp_ajax_import_rtmega_template', [ $this, 'import_rtmega_template' ] );
        }        

        self::$api_args = [
            'plugin_version' => RTMEGA_MENU_VERSION,
            'url'            => home_url(),
        ];

    }

    // Plugins Library Register
    function admin_menu() {
        add_submenu_page(
            'rt-mega-menu', 
            esc_html__( 'Templates Library', 'rt-mega-menu' ),
            esc_html__( 'Templates Library', 'rt-mega-menu' ), 
            'manage_options', 
            'rtmegamenu_templates', 
            array ( $this, 'library_render_html' ) 
        );
    }

    function library_render_html(){
        require_once __DIR__ . '/templates_list.php';
    }

    public static function get_rtmega_templates() {

        $TEMPLATES_SOURCE_URL = RTMEGA_TEMPLATES_SOURCE_SITE_URL . '/wp-json/reacthemes/v1/get_rt_el_templates';
         
        $body = [];

        $response = wp_remote_post( $TEMPLATES_SOURCE_URL, array(
            'headers'     => [
                'Content-Type' => 'application/json',
            ],
            'timeout'     => 60,
            'redirection' => 5,
            'blocking'    => true,
            'httpversion' => '1.0',
            'sslverify'   => true,
            'data_format' => 'body',
            'body'        => $body
        ) );

        if ( is_wp_error( $response ) ) {
            return '';
        }

        return wp_remote_retrieve_body( $response );
    }

    function get_rtmega_template_by_id($template_id) {

        $TEMPLATES_SOURCE_URL = RTMEGA_TEMPLATES_SOURCE_SITE_URL . '/wp-json/reacthemes/v1/get_rt_el_template_data_by_id';
        
        $body = [];
        $body['template_id'] = $template_id;

       $response = wp_remote_post( $TEMPLATES_SOURCE_URL, array(
           'headers'     => [],
           'timeout'     => 60,
           'redirection' => 5,
           'blocking'    => true,
           'httpversion' => '1.0',
           'sslverify'   => true,
           'body'        => $body
       ) );

       if ( is_wp_error( $response ) ) {
           return array();
       }

       $result = json_decode( wp_remote_retrieve_body( $response ), true );
       return is_array( $result ) ? $result : array();
   }

    function import_rtmega_template(){

       check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to import templates.', 'rt-mega-menu' ) ) );
        }

        if ( isset( $_REQUEST ) ) {

            $template_id = !empty($_REQUEST['templateId']) ? (int) sanitize_text_field(wp_unslash($_REQUEST['templateId'])) : 0;
            $page_title = !empty($_REQUEST['pageTitle']) ? sanitize_text_field(wp_unslash($_REQUEST['pageTitle'])) : '';


            $response_data = $this->get_rtmega_template_by_id( $template_id );

            if ( ! is_array( $response_data ) || empty( $response_data ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'Unable to fetch template data from the template server.', 'rt-mega-menu' ) ) );
            }

            $is_premium = ! empty( $response_data['is_premium'] );

            if($is_premium){
                $license_status = '';
                // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- rt_mega_ prefix; part of free↔pro API contract.
                $license_status = apply_filters( 'check_rt_mega_license_status', $license_status );

                if($license_status != 'active'){
                    wp_send_json_error(
                        array(
                        'license' => $license_status, 
                        'message' => 'Please acivate RTMega Premium License to import this template!',
                        )
                    );
                }
            }


            $default_title = !empty( $response_data['title'] ) ? $response_data['title'] : __( 'New Template RTMEGA', 'rt-mega-menu' );

            $args = [
                'post_type'    => !empty( $page_title ) ? 'page' : 'elementor_library',
                'post_status'  => !empty( $page_title ) ? 'draft' : 'publish',
                'post_title'   => !empty( $page_title ) ? $page_title : $default_title,
                'post_content' => '',
            ];

            $new_post_id = wp_insert_post( $args, true );

            if ( is_wp_error( $new_post_id ) || ! $new_post_id ) {
                wp_send_json_error( array( 'message' => esc_html__( 'Failed to create the template.', 'rt-mega-menu' ) ) );
            }

            update_post_meta( $new_post_id, '_elementor_data', isset( $response_data['elementor_data'] ) ? $response_data['elementor_data'] : '' );
            update_post_meta( $new_post_id, '_elementor_page_settings', isset( $response_data['page_settings'] ) ? $response_data['page_settings'] : '' );
            update_post_meta( $new_post_id, '_elementor_template_type', isset( $response_data['template_type'] ) ? $response_data['template_type'] : '' );
            update_post_meta( $new_post_id, '_elementor_edit_mode', 'builder' );
            update_post_meta( $new_post_id, '_wp_page_template', ! empty( $response_data['page_template'] ) ? $response_data['page_template'] : 'elementor_header_footer' );

            echo wp_json_encode(
                array( 
                    'id' => $new_post_id,
                    'edittxt' => esc_html__( 'Edit Template', 'rt-mega-menu' )
                )
            );

        }

        die();
    }
}

RTMEGA_MENU_Template_Library::instance();