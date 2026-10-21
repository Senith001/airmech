<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="//gmpg.org/xfn/11">
<?php $coolair_option = get_option('coolair_option'); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  
   <div class="close-button body-close"></div>   
    <!--Preloader start here-->
    <?php get_template_part( 'inc/header/preloader' ); ?>
    <!--Preloader area end here-->
    <?php 
		if( ! function_exists( 'wp_body_open' ) ) {
		    function wp_body_open() {
		    	do_action( 'wp_body_open' );
		    }
		}
	?>  
    
 
    <div id="page" class="site">
        <?php
            get_template_part('inc/header/header'); 
        ?> 
        <!-- End Header Menu End -->
        <?php 
            $page_bg = get_post_meta(get_the_ID(), 'page_bg', true);
            if($page_bg !='' && is_page()): ?>
                <div class="main-contain offcontents" style="background-image: url('<?php echo esc_url( $page_bg );?>'); ">
            <?php else: ?>
                <div class="main-contain offcontents">                
            <?php endif;
        ?>