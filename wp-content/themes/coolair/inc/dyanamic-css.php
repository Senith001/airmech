<?php
/*
dynamic css file. please don't edit it. it's update automatically when settins changed
*/
add_action('wp_head', 'coolair_custom_colors', 160);
function coolair_custom_colors() { 
	global $coolair_option;	
	/***styling options
	------------------*/

	if(!empty($coolair_option['body_bg_color'])) {
		$body_bg          = $coolair_option['body_bg_color'];
	}

	

	$color_primary    		= !empty($coolair_option['color-primary']) ? $coolair_option['color-primary'] : '';	
	$color_primary_2  		= !empty($coolair_option['color-primary-2']) ? $coolair_option['color-primary-2'] : '';	
	$color_secondary  		= !empty($coolair_option['color-secondary']) ? $coolair_option['color-secondary'] : '';	
	$color_secondary_2 		= !empty($coolair_option['color-secondary-2']) ? $coolair_option['color-secondary-2'] : '';	

	$link_color       = !empty($coolair_option['link_text_color']) ? $coolair_option['link_text_color'] : '';
	$link_hover_color = !empty($coolair_option['link_hover_text_color']) ? $coolair_option['link_hover_text_color'] : '';

	$button_bg 		   		= !empty($coolair_option['btn_bg_color']) ? $coolair_option['btn_bg_color'] : '';	 
	$button_hover_bg   		= !empty($coolair_option['btn_bg_hover']) ? $coolair_option['btn_bg_hover'] : '';
	$btn_text_color   		= !empty($coolair_option['btn_text_color']) ? $coolair_option['btn_text_color'] : '';	
	$btn_txt_hover_color   	= !empty($coolair_option['btn_txt_hover_color']) ? $coolair_option['btn_txt_hover_color'] : '';		

	
	//typography extract for body		
	$body_typography_font      = !empty($coolair_option['opt-typography-body']['font-family']) ? $coolair_option['opt-typography-body']['font-family'] : '';
	$body_typography_font_size = !empty($coolair_option['opt-typography-body']['font-size']) ? $coolair_option['opt-typography-body']['font-size'] : '' ;

	//typography extract for menu
	$menu_typography_color       = !empty($coolair_option['opt-typography-menu']['color']) ? $coolair_option['opt-typography-menu']['color'] : '' ;	
	$menu_typography_weight      = !empty($coolair_option['opt-typography-menu']['font-weight']) ? $coolair_option['opt-typography-menu']['font-weight']: '';	
	$menu_typography_font_family = !empty($coolair_option['opt-typography-menu']['font-family']) ? $coolair_option['opt-typography-menu']['font-family'] : '';
	$menu_typography_font_fsize  = !empty($coolair_option['opt-typography-menu']['font-size']) ? $coolair_option['opt-typography-menu']['font-size'] : '';


	$body_color  = !empty($coolair_option['body_text_color']) ? $coolair_option['body_text_color'] : '' ;

	
	
	$primary_typography_font = !empty($coolair_option['opt-typography-primary']['font-family']) ? $coolair_option['opt-typography-primary']['font-family'] : '';
	$primary_typography_font_size = !empty($coolair_option['opt-typography-primary']['font-size']) ? $coolair_option['opt-typography-primary']['font-size'] : '' ;

	?>

<!-- Typography -->
<?php if(!empty($body_color)){
	global $coolair_option;
?>
<style>	
	body{
		background:<?php echo sanitize_hex_color($body_bg); ?>;
		color:<?php echo sanitize_hex_color($body_color); ?> !important;
		<?php if(!empty($body_typography_font)){ ?>
			font-family: <?php echo esc_attr($body_typography_font);?> !important;   
		<?php } ?> 
	    font-size: <?php echo esc_attr($body_typography_font_size);?> !important;
	}		
	
	.sidenav .widget_nav_menu ul li a{
		<?php if(!empty($menu_typography_weight)){ ?>
			font-weight: <?php echo esc_attr($menu_typography_weight);?>;   
		<?php } ?>
		<?php if(!empty($menu_typography_font_family)){ ?>
			font-family: <?php echo esc_attr($menu_typography_font_family);?>;   
		<?php } ?>
		font-size:<?php echo esc_attr($menu_typography_font_fsize); ?>;
	}    

	<?php if(!empty($coolair_option['container_size'])) : ?>
		.e-con {
			--content-width: <?php echo esc_html($coolair_option['container_size']);?>;
		}
	<?php endif; ?>

	:root {		
		<?php 
		// secondary font
 		if(!empty($body_typography_font)) { ?>
			--font-secondary: <?php echo esc_attr($body_typography_font);?> !important;
			<?php 
		}
		?>
		<?php
		// primary font 
		if(!empty($primary_typography_font)) { ?>
			--font-primary: <?php echo wp_kses_post($primary_typography_font);?> !important;
			<?php
		}
		?>

		/* normal color  */
		<?php
		if(!empty($body_text_color)) { ?>
			--color-body:<?php echo sanitize_hex_color($body_text_color); ?> !important;
			<?php 
		} if(!empty($color_primary)) { ?>
			--color-primary:<?php echo sanitize_hex_color($color_primary); ?> !important;
			<?php 
		} if(!empty($color_primary_2)) { ?>
			--color-primary-2:<?php echo sanitize_hex_color($color_primary_2); ?> !important;
			<?php 
		} if(!empty($color_secondary)) { ?>
			--color-secondary:<?php echo sanitize_hex_color($color_secondary); ?> !important;
			<?php 
		} if(!empty($color_secondary_2)) { ?>
			--color-secondary-2:<?php echo sanitize_hex_color($color_secondary_2); ?> !important;
			<?php 
		} if(!empty($button_bg)) { ?>
			--color-primary-btn:<?php echo sanitize_hex_color($button_bg); ?> !important;
			<?php 
		} if(!empty($button_hover_bg)) { ?>
			--color-title:<?php echo sanitize_hex_color($button_hover_bg); ?> !important;
			<?php 
		}

		?>	
		
	}
	
	<?php if(!empty($coolair_option['breadcrumb_top_gap']) && !empty($coolair_option['breadcrumb_bottom_gap'])) : ?>
		.reactheme-breadcrumbs .breadcrumbs-inner,
		#reactheme-header.header-style-3 .reactheme-breadcrumbs .breadcrumbs-inner{
			padding-top:<?php echo esc_attr($coolair_option['breadcrumb_top_gap']); ?>;			
			padding-bottom:<?php echo esc_attr($coolair_option['breadcrumb_bottom_gap']); ?>;			
	}
	<?php endif; ?>
	<?php if(!empty($coolair_option['mobile_breadcrumb_top_gap']) && !empty($coolair_option['mobile_breadcrumb_bottom_gap'])) : ?>
		@media only screen and (max-width: 767px) {
		.reactheme-breadcrumbs .breadcrumbs-inner,
		#reactheme-header.header-style-3 .reactheme-breadcrumbs .breadcrumbs-inner{
			padding-top:<?php echo esc_attr($coolair_option['mobile_breadcrumb_top_gap']); ?>;			
			padding-bottom:<?php echo esc_attr($coolair_option['mobile_breadcrumb_bottom_gap']); ?>;			
		}
	}
	<?php endif; ?>
	
	<?php if(!empty($coolair_option['container_size'])) : ?>
		@media only screen and (min-width: 1300px) {
			.container{
				max-width:<?php echo esc_attr($coolair_option['container_size']); ?>;
			}
		}
	<?php endif; ?>

	<?php if(!empty($coolair_option['preloader_bg_color'])) : ?>
		#coolair-load{
			background: <?php echo sanitize_hex_color($coolair_option['preloader_bg_color']); ?>;  
		}
	<?php endif; ?>

	<?php if(!empty($coolair_option['page_title_color'])) : ?>
		.reactheme-breadcrumbs .page-title{
			color: <?php echo sanitize_hex_color($coolair_option['page_title_color']); ?> !important;  
		}
	<?php endif; ?>
	
	<?php if(!empty($coolair_option['body_bg_color'])) : ?>
		body.archive.tax-product_cat{
			background: <?php echo sanitize_hex_color($coolair_option['body_bg_color']); ?> !important;  
		}
	<?php endif; ?>		
</style>
<?php
	}
	 
	if(is_home() && !is_front_page() || is_home() && is_front_page()){
		$padding_top        = get_post_meta(get_queried_object_id(), 'content_top', true);
		$padding_bottom     = get_post_meta(get_queried_object_id(), 'content_bottom', true);		
		$footer_padd_top    = get_post_meta(get_queried_object_id(), 'footer_padd_top', true);
		$footer_padd_bottom = get_post_meta(get_queried_object_id(), 'footer_padd_bottom', true);
  		if($padding_top != '' || $padding_bottom != ''){
	  	?>
	  	  <style>
	  	  	.main-contain #content,
	  	  	body.reactheme-pages-btm-gap .main-contain #content{
	  	  		<?php if(!empty($padding_top)): ?>padding-top:<?php echo esc_attr($padding_top); endif;?>;
	  	  		<?php if(!empty($padding_bottom)): ?>padding-bottom:<?php echo esc_attr($padding_bottom); endif;?>;
	  	  	}
	  	  </style>	
	  	<?php
	  	}
   		if($footer_padd_top != '' || $footer_padd_bottom != ''){
 	  	?>
 	  	  <style>
 	  	  	.reactheme-footer .footer-top{
 	  	  		<?php if(!empty($footer_padd_top)): ?>padding-top:<?php echo esc_attr($footer_padd_top); endif;?>;
 	  	  		<?php if(!empty($footer_padd_bottom)): ?>padding-bottom:<?php echo esc_attr($footer_padd_bottom); endif;?>;
 	  	  	}
 	  	  </style>	
 	  	  <?php
 	 	} 		
  }
  	else{ 
		$padding_top        = get_post_meta(get_the_ID(), 'content_top', true);
		$padding_bottom     = get_post_meta(get_the_ID(), 'content_bottom', true);		
		$footer_padd_top    = get_post_meta(get_the_ID(), 'footer_padd_top', true);
		$footer_padd_bottom = get_post_meta(get_the_ID(), 'footer_padd_bottom', true);
  		if($padding_top != '' || $padding_bottom != ''){
	  	?>
	  	  <style>
	  	  	.main-contain #content,
	  	  	body.reactheme-pages-btm-gap .main-contain #content{
	  	  		<?php if(!empty($padding_top)): ?>padding-top:<?php echo esc_attr($padding_top); endif;?>;
	  	  		<?php if(!empty($padding_bottom)): ?>padding-bottom:<?php echo esc_attr($padding_bottom); endif;?>;
	  	  	}
	  	  </style>	
	  	<?php
	  }

		if($footer_padd_top != '' || $footer_padd_bottom != ''){
	  	?>
	  	  <style>
	  	  	.reactheme-footer .footer-top{
	  	  		<?php if(!empty($footer_padd_top)): ?>padding-top:<?php echo esc_attr($footer_padd_top); endif;?> !important;
	  	  		<?php if(!empty($footer_padd_bottom)): ?>padding-bottom:<?php echo esc_attr($footer_padd_bottom); endif;?> !important;
	  	  	}
	  	  </style>	
	  	  <?php
	 	} 
}	

if ( !class_exists('ReduxFrameworkPlugin') ) {  ?>	
	<style>
	@media only screen and (max-width: 1024px){
		.sidebarmenu-area.primary-menu.mobilehum {
			display: block !important;
		}
	} 
	</style>
<?php } ?>

<!--  Single Blog Image Size -->
<?php if(!empty($coolair_option['single_blog_img_size'])) : ?>
	<style>
		.single .bs-img img{
		height:<?php echo esc_attr($coolair_option['single_blog_img_size']);?> !important;
	}
	</style>
<?php endif;?>

<?php if (class_exists('WooCommerce') ) {  ?>	
	<!--  Woocommerce -->
	<style>
		.woocommerce a.button,
		.woocommerce-page .wp-element-button,
		.woocommerce .product form.cart .button,
		.single-product #review_form #respond .form-submit input,
		.woocommerce-page .woocommerce-address-fields button,
		.woocommerce-page .woocommerce-MyAccount-content button,
		.woocommerce-page .woocommerce-form-login button{
			background:<?php echo esc_attr($button_bg);?> !important;
			color: <?php echo esc_attr($btn_text_color);?> !important;
		}
		.woocommerce a.button:hover,
		.woocommerce-page .wp-element-button:hover,
		.woocommerce .product form.cart .button:hover,
		.single-product #review_form #respond .form-submit input:hover,
		.woocommerce-page .woocommerce-address-fields button:hover,
		.woocommerce-page .woocommerce-MyAccount-content button:hover,
		.woocommerce-page .woocommerce-form-login button:hover{
			background:<?php echo esc_attr($button_hover_bg);?> !important;
			color: <?php echo esc_attr($btn_txt_hover_color);?> !important;
		}
	</style>
<?php 
}
 }
?>