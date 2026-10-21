<?php 
global $coolair_option;
$preloader_img = "";
if(!empty($coolair_option['show_preloader']))
  {
    $loading = $coolair_option['show_preloader'];
    
    if(!empty($coolair_option['preloader_img'])){
        $preloader_img = $coolair_option['preloader_img'];
    }

    if($loading == 1){?>
      <!-- page preloader begin -->
            <div id="de-loader">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
        <!-- page preloader close -->              
  <?php }
}?>

<?php 
    if(!empty($coolair_option['off_sticky'])):   
        $sticky = $coolair_option['off_sticky'];         
        if($sticky == 1):
            $sticky_menu ='menu-sticky';        
        endif;
        else:
            $sticky_menu ='';
    endif;

    if( is_page() ){

        $post_meta_header = get_post_meta($post->ID, 'trans_header', true);  

        if($post_meta_header == 'Default Header'){       
            $header_style = 'default_header';             
        }
        else{
            $header_style = 'transparent_header';
        }
    }
    else{
        $header_style = 'transparent_header';
    }
 ?>   