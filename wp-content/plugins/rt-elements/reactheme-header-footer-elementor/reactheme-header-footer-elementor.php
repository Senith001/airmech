<?php

define( 'RTSHFE_VER', '1.0.0' );
define( 'RTSHFE_FILE', __FILE__ );
define( 'RTSHFE_DIR', plugin_dir_path( __FILE__ ) );
define( 'RTSHFE_URL', plugins_url( '/', __FILE__ ) );
define( 'RTSHFE_PATH', plugin_basename( __FILE__ ) );
define( 'RTSHFE_DOMAIN', trailingslashit( 'https://reacthemes.com' ) );
define( 'RTSHFE_DIR_URL_ADMIN', plugin_dir_url( __FILE__ ) );
define( 'RTSHFE_ASSETS_ADMIN', trailingslashit( RTSHFE_DIR_URL_ADMIN ) );

/**
 * Load the class loader.
 */
require_once RTSHFE_DIR . '/inc/class-header-footer-elementor.php';

/**
 * Load the Plugin Class.
 */
function rtshfe_plugin_activation() {	
	update_option( 'hfe_plugin_is_activated', 'yes' );
	update_option( 'rtshfe_addon_option', $footer_widget );
}
register_activation_hook( RTSHFE_FILE, 'rtshfe_plugin_activation' );

/**
 * Load the Plugin Class.
 */
function rtshfe_init() {
	Header_Footer_Elementor::instance();
}
add_action( 'plugins_loaded', 'rtshfe_init' );

/**
 * Ensure Elementor / Elementor Pro icon & widget styles are available.
 */
function rts_enqueue_elementor_icon_styles() {

    // If Elementor is not active, do nothing.
    if ( ! class_exists( '\Elementor\Plugin' ) ) {
        return;
    }

    /**
     * 1. Elementor core icons (eIcons)
     * Handle printed in HTML as: id="elementor-icons-css"
     */
    if ( wp_style_is( 'elementor-icons', 'registered' ) ) {
        wp_enqueue_style( 'elementor-icons' );
    }

    /**
     * 2. Font Awesome 5 from Elementor
     * Handles printed as: font-awesome-5-all-css, font-awesome-4-shim-css
     */
    if ( wp_style_is( 'font-awesome-5-all', 'registered' ) ) {
        wp_enqueue_style( 'font-awesome-5-all' );
    }

    // Optional: if you still have v4 icons in some content.
    if ( wp_style_is( 'font-awesome-4-shim', 'registered' ) ) {
        wp_enqueue_style( 'font-awesome-4-shim' );
    }

    /**
     * 3. Elementor Pro frontend styles (blockquote, nav menu, mega menu, etc.)
     */
    if ( class_exists( '\ElementorPro\Plugin' ) && wp_style_is( 'elementor-pro-frontend', 'registered' ) ) {
        wp_enqueue_style( 'elementor-pro-frontend' );
    }

    /**
     * 4. (Optional) Force specific widget styles if you use their HTML outside Elementor.
     * These handles are internal but commonly used.
     */
    $widget_styles = array(
        'widget-icon-list',       // Icon List widget
        'widget-social-icons',    // Social Icons widget
        'widget-nav-menu',        // Nav Menu widget (Elementor Pro)
        'widget-blockquote',      // Blockquote widget (Elementor Pro)
    );

    foreach ( $widget_styles as $handle ) {
        if ( wp_style_is( $handle, 'registered' ) ) {
            wp_enqueue_style( $handle );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'rts_enqueue_elementor_icon_styles', 20 );