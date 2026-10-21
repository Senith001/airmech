<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Enqueue parent then child styles
add_action( 'wp_enqueue_scripts', function() {
    $parent = 'coolair-parent-style';
    wp_enqueue_style( $parent, get_template_directory_uri() . '/style.css', array(), wp_get_theme( 'coolair' )->get('Version') );
    wp_enqueue_style( 'coolair-child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent ), '1.0.0' );
}, 20 );

// Allow SVG uploads (needed for the airmech.lk SVG assets)
add_filter( 'upload_mimes', function( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
} );
add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes ) {
    if ( ! $data['type'] ) {
        $ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
        if ( $ext === 'svg' || $ext === 'svgz' ) {
            $data['type'] = 'image/svg+xml';
            $data['ext']  = $ext;
        }
    }
    return $data;
}, 10, 4 );
