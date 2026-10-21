<?php
    $coolair_option = get_option('coolair_option');   
    $header_width_meta = get_post_meta(get_queried_object_id(), 'header_width_custom', true);

    if ($header_width_meta != ''){
        $header_width = ( $header_width_meta == 'full' ) ? 'container-fluid': 'container';
    }else{
        $header_width = !empty($coolair_option['header-grid']) ? $coolair_option['header-grid'] : '';
        $header_width = ( $header_width == 'full' ) ? 'container-fluid': 'container';
    }

    $post_menu_type = get_post_meta(get_queried_object_id(), 'menu-type', true);
    $post_meta_data = get_post_meta(get_queried_object_id(), 'banner_image', true);
    $content_banner = get_post_meta(get_queried_object_id(), 'content_banner', true); 
    $post_id        = get_the_id();
    $author_id      = get_post_field ('post_author', $post_id);
    $display_name   = get_the_author_meta( 'display_name' , $author_id );
 ?>

<div class="reactheme-breadcrumbs porfolio-details">
<?php

if (!empty($coolair_option['blog_banner']['url'])) {?>
<div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url( $coolair_option['blog_banner']['url'] );?>')">         
        <div class="breadcrumbs-inner bread-<?php echo esc_attr($post_menu_type); ?>"> 
            <div class="row">
                <div class="col-lg-12 text-center">  
                    <?php 
                    $post_meta_title = get_post_meta(get_the_ID(), 'select-title', true);?>
                                   
                    <h1 class="page-title">                       
                           <?php  the_title();                           
                        ?>
                    </h1> <?php                     
                            
                        if(function_exists('bcn_display')){?>
                            <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                        <?php }                      
                 
                    ?>
                        
                </div>   
                
            </div>
        </div>        
    </div>
</div>
<?php }else{?>
    <div class="reactheme-breadcrumbs-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumbs-inner bread-<?php echo esc_attr($post_menu_type); ?>"> 
                        <h1 class="page-title">
                            <?php 
                                the_title();
                            
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

</div>