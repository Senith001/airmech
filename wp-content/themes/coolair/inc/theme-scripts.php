<?php
function coolair_scripts() {
	//register styles
	global $coolair_option;
	wp_enqueue_style( 'boostrap', get_template_directory_uri() .'/assets/css/bootstrap.min.css' );		
	wp_enqueue_style( 'swiper', get_template_directory_uri().'/assets/css/swiper-bundle.min.css' );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri().'/assets/css/magnific-popup.css' );
	wp_enqueue_style( 'rt-icons', get_template_directory_uri() .'/assets/css/rt-icons.css' );
	wp_enqueue_style( 'icofont', get_template_directory_uri() .'/assets/fonts/icofont/icofont.css' );
	wp_enqueue_style( 'coolair-style-default', get_template_directory_uri() .'/assets/scss/theme.css' );
	wp_enqueue_style( 'coolair-style-responsive', get_template_directory_uri() .'/assets/css/responsive.css' );
	wp_enqueue_style( 'coolair-style', get_stylesheet_uri() );	
	if ( is_rtl() ) {
		wp_enqueue_style('coolair-rtl', get_template_directory_uri(). '/assets/css/rtl.css' );		
	}

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '5.2.0', true );
	wp_enqueue_script( 'swiper', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', array('jquery'), '8.2.3');
	wp_enqueue_script( 'wow', get_template_directory_uri().'/assets/js/wow.min.js', array('jquery'), '1.1.2');
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/js/waypoints.min.js', array('jquery'), '2.0.3', true );
	wp_enqueue_script( 'waypoints-sticky', get_template_directory_uri() . '/assets/js/waypoints-sticky.min.js', array('jquery'), '1.6.2', true );	
	wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() . '/assets/js/jquery.counterup.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true );	
	
	wp_enqueue_script('coolair-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), wp_get_theme()->get( 'Version' ), true);	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'coolair_scripts' );

add_action( 'admin_enqueue_scripts', 'coolair_load_admin_styles' );
function coolair_load_admin_styles($screen) {
	wp_enqueue_style( 'coolair-admin-style', get_template_directory_uri() . '/assets/css/admin-style.css', true, '1.0.0' );
	wp_enqueue_script( 'coolair-admin-script', get_template_directory_uri() . '/assets/js/admin-script.js', array('jquery'), '1.0.0', true );
} 

// Enqueue scripts for CMB2
function coolair_custom_cmb2_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'coolair_custom_cmb2_scripts');