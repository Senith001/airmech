<?php
namespace RtMega\MegaMenu\Tracking;

use Appsero\Client;

if ( ! defined( 'ABSPATH' ) ) exit;

class Appsero_Tracker {

    private static $instance = null;
    private $client;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->includes();
        $this->init();
    }

    private function includes() {
        if ( ! class_exists( '\\Appsero\\Client' ) ) {
            require_once RTMEGA_MENU_PL_PATH . 'apps/Client.php';
        }
    }

    private function init() {

        // Appsero Client init
        $this->client = new Client(
            '1e51d718-e4b3-4fb7-bc97-7845f1f2d007',
            'RT Mega Menu',
            RTMEGA_MENU_PL_ROOT
        );

        $this->client->set_textdomain( 'rt-mega-menu' );

        $this->client->insights()
            ->add_plugin_data()
            ->add_extra( $this->extra_data() )
            ->init();
    }

    private function extra_data() {
        return [
            'is_pro_active' => defined( 'RTMEGA_MENU_PRO_VERSION' ) ? 'Yes' : 'No',
            'pro_version'   => defined( 'RTMEGA_MENU_PRO_VERSION' ) ? RTMEGA_MENU_PRO_VERSION : '',
        ];
    }
}

// Appsero_Tracker::instance();
