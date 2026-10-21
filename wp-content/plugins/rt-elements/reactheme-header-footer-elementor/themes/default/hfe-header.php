<?php global $coolair_option; 
    $site_defualt_mode = !empty($coolair_option['site_defualt_mode']) ? $coolair_option['site_defualt_mode'] : '';
    $site_mode = ($site_defualt_mode =='dark') ? 'data-theme="dark"' : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo $site_mode; ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="//gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'wp_body_open' ); ?>
    
    <div class="close-button body-close"></div>
    
  
    <!--Preloader start here-->
    <?php get_template_part( 'inc/header/preloader' ); ?>
    <!--Preloader area end here-->
    
    <?php
        $gap = ''; 
        if ( is_active_sidebar( 'footer_top' )){
        $gap = 'footer-bottom-gaps';
        
    }$header_id = Header_Footer_Elementor::get_settings( 'type_header', '' );    
    $fixed_header = get_post_meta($header_id, 'header-position', true);
    $fixed_header = !empty($fixed_header) ? 'fixed-header' : '';?>
    
    <?php        
        $extrapadding       = !empty($coolair_option['show_call_btns']) ? '' : 'lesspadding';   
        $sticky             = !empty($coolair_option['off_sticky']) ? $coolair_option['off_sticky'] : ''; 
        $sticky_menu        = ($sticky == 1) ? ' menu-sticky' : '';   
    ?>
    <div id="page" class="site <?php echo esc_attr( $gap );?> <?php echo esc_attr($extrapadding);?>">
    <?php  get_template_part('inc/header/search'); get_template_part('inc/header/off-canvas'); ?>
    	<header id="reactheme-header" class="header-style-1  mainsmenu <?php echo $fixed_header ;?>">   
	     
	    <div class="header-inner<?php echo esc_attr($sticky_menu);?>">
       <?php 

		if( is_404() ){
			return;
		} else {
			do_action( 'hfe_header' );
		} ?>
        </div>
    </header>
    <?php 
        do_action( 'hfe_footer_before' );
        
        if (!has_action('hfe_footer_before')) {
            get_template_part('inc/breadcrumbs');
        }  
     ?>
        <div class="main-contain offcontents"> 
       <?php if ( class_exists( 'WooCommerce' ) ) {
		if(is_shop() || is_product_category() || is_product_tag() || is_product('product')){ ?>
			<div class="container">
            <div id="content">
		<?php }
       }
       if(is_search()){ ?>
        <div class="container">
        <div id="content">
    <?php }
	