<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// register category
function rtmega_block_categories( $block_categories, $editor_context ) {
    ///if ( ! empty( $editor_context->post ) ) {
       $attr = array(
            array(
                'slug'  => 'rt-mega-menu',
                'title' => __( 'RT Mega Menu', 'rt-mega-menu' ),
            )
        );
        $block_categories =  array_merge( $attr, $block_categories );
	   
   //}
    return $block_categories;
}

add_filter( 'block_categories_all', 'rtmega_block_categories', 999999, 2 );

function rtmega_register_blocks() {
	if ( function_exists( 'register_block_type' ) ) {
		register_block_type( RTMEGA_MENU_PL_PATH . 'public/blocks/rt-mega-menu/build' );
	}
}
add_action( 'init', 'rtmega_register_blocks' );

add_action( 'enqueue_block_editor_assets', 'rtmega_block_mobile_menu_notice_script' );

function rtmega_block_mobile_menu_notice_script() {
	wp_register_script(
		'rtmega-block-mobile-menu-notice',
		false,
		[ 'wp-hooks', 'wp-element', 'wp-block-editor', 'wp-components' ],
		RTMEGA_MENU_VERSION,
		true
	);
	wp_enqueue_script( 'rtmega-block-mobile-menu-notice' );
	wp_add_inline_script( 'rtmega-block-mobile-menu-notice', '
(function(wp) {
    if (!wp || !wp.hooks) return;
    var el = wp.element.createElement;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;

    wp.hooks.addFilter("editor.BlockEdit", "rt-mega-menu/mobile-menu-notice", function(BlockEdit) {
        return function(props) {
            if (props.name !== "rt-mega-menu/mega-menu") return el(BlockEdit, props);
            return el(wp.element.Fragment, null,
                el(BlockEdit, props),
                el(InspectorControls, null,
                    el(PanelBody, { title: "Mobile Menu", className: "rtmega-mobile-menu-pro-notice-panel" },
                        el("div", { className: "rtmega-mobile-menu-pro-notice" },
                            el("div", { style: { pointerEvents: "none", opacity: 0.6 } },
                                el("p", { style: { marginBottom: "4px", fontWeight: 600 } }, "Mobile Menu"),
                                el("select", {
                                    disabled: true,
                                    style: { width: "100%", padding: "6px 8px", border: "1px solid #d5dadf", borderRadius: "3px", background: "#f9f9f9", color: "#555", cursor: "not-allowed" }
                                }, el("option", null, "— Select a menu —"))
                            ),
                            el("div", {
                                style: { marginTop: "8px", padding: "8px 10px", background: "#fff8e5", borderLeft: "3px solid #f0ad00", borderRadius: "2px", fontSize: "12px", lineHeight: "1.5" }
                            },
                                el("strong", null, "Mobile Menu"),
                                " is a ",
                                el("a", { href: "https://themewant.com/downloads/rt-mega-menu-pro/", target: "_blank", style: { color: "#f0ad00" } }, "Pro feature"),
                                ". Upgrade to set a separate menu for mobile devices."
                            )
                        )
                    )
                )
            );
        };
    });
})(window.wp);
' );
}
