<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

add_action( 'wp_enqueue_scripts', 'rtmega_menu_dynamic_css', 20 );
function rtmega_menu_dynamic_css() {

    $css = rtmega_menu_build_dynamic_css();
    if ( empty( $css ) ) {
        return;
    }

    // Attach to the already enqueued front-end stylesheet (see plugin-scripts.php).
    wp_add_inline_style( 'rtmegamenu-style', $css );
}

/**
 * Build the dynamic CSS string from the saved menu options.
 *
 * @return string
 */
function rtmega_menu_build_dynamic_css() {

    $rtmega_menu_options = get_option( 'rtmega_menu_options' );
    if ( empty( $rtmega_menu_options ) ) {
        return '';
    }

    $css = '';

    if ( ! empty( $rtmega_menu_options['menu_color'] ) ) {
        $color = sanitize_hex_color( $rtmega_menu_options['menu_color'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu > .menu-item > .menu-link{color:{$color};}";
    }

    if ( ! empty( $rtmega_menu_options['menu_hover_color'] ) ) {
        $color = sanitize_hex_color( $rtmega_menu_options['menu_hover_color'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu.default-nav .menu-item:hover > .menu-link{color:{$color};}";
    }

    if ( ! empty( $rtmega_menu_options['menu_active_color'] ) ) {
        $color = sanitize_hex_color( $rtmega_menu_options['menu_active_color'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu.default-nav .menu-item.current-menu-item > .menu-link,"
               . ".rtmega-menu-container .rtmega-megamenu.default-nav .menu-item ul.sub-menu .menu-item.current-menu-item > .menu-link{color:{$color};}";
    }

    if ( ! empty( $rtmega_menu_options['submenu_color'] ) ) {
        $color = sanitize_hex_color( $rtmega_menu_options['submenu_color'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu.default-nav .menu-item ul.sub-menu > .menu-item > .menu-link{color:{$color};}";
    }

    if ( ! empty( $rtmega_menu_options['submenu_hover_color'] ) ) {
        $color = sanitize_hex_color( $rtmega_menu_options['submenu_hover_color'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu.default-nav .menu-item ul.sub-menu > .menu-item:hover > .menu-link{color:{$color};}";
    }

    if ( ! empty( $rtmega_menu_options['submenu_bg_color'] ) ) {
        $color = sanitize_hex_color( $rtmega_menu_options['submenu_bg_color'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu.default-nav .menu-item ul.sub-menu > .menu-item > .menu-link{background:{$color};}";
    }

    if ( ! empty( $rtmega_menu_options['submenu_width'] ) ) {
        $width = esc_html( $rtmega_menu_options['submenu_width'] );
        $css  .= ".rtmega-menu-container .rtmega-megamenu .menu-item ul.sub-menu{width:{$width};}";
    }

    return $css;
}
