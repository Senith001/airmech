<?php
    $coolair_option = get_option('coolair_option');
?>
<div class="single-content-full">
    <div class="user-info">
        <!-- single info -->
        <?php if(!empty($coolair_option['blog-author-post'])){
                if ($coolair_option['blog-author-post'] == 'show'): ?> 
                 <div class="single-info author">
                    <span>   
                        <?php
                            if( !empty($first_name) && !empty($last_name)){
                             echo esc_html($first_name).' '. esc_html($last_name);
                            } else{
                                echo get_the_author();
                           } ?>  
                    </span>
                </div>
        <?php endif; } 
         else{ ?> 
            <div class="single-info author">
                <span>
                    <?php 
                    
                    if( !empty($first_name) && !empty($last_name)){
                        echo esc_html($first_name).' '. esc_html($last_name);
                    }else{
                        echo get_the_author();
                    } ?>
                </span>
            </div>
        <?php }; ?>
        <!-- single infoe end -->
        <!-- single info -->
        <?php if(!empty($coolair_option['blog-date'])){
            if($coolair_option['blog-date'] == true){ ?>
                <!-- single info -->
                <div class="single-info date">
                    <span>•</span>
                    <span><?php echo get_the_date();?></span>
                </div>
            <!-- single infoe end -->
        <?php } 
        } ?>
        <!-- single infoe end -->
        <!-- single info -->
        <?php if(!empty($coolair_option['blog-category'])){
            if($coolair_option['blog-category'] == 'show'){ ?>
            <div class="single-info cat">
                <span> 
                    <?php 
                        if(get_the_category()):
                        the_category(', ');                                                 
                        endif; ?>
                </span>
            </div>
            <?php } 
            } else{ ?>
            <div class="single-info cat">
                <span>                           
                    <?php
                        //tag add
                        $seperator = ', '; // blank instead of comma
                        $after = '';
                        $before = '';                    
                        ?>                        
                        <?php
                        the_category(',  ');                    
                    ?> 
                </span>
            </div>
        <?php   } ?>
        <!-- single info end -->
</div>
<div class="bs-desc">
    <?php
        the_content();
        wp_link_pages( array(
          'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'coolair' ),
          'after'       => '</div>',
          'link_before' => '<span class="page-number">',
          'link_after'  => '</span>',
        ) );
    ?>
</div>
 <?php 
    if(has_tag()){ ?>
    <div class="bs-info single-page-info tags">
        <?php
            //tag add
            $seperator = ' ,'; // blank instead of comma
            $after = '';
            echo esc_html__( 'Tags: ', 'coolair' );
            the_tags( '', $seperator, $after );
        ?>             
    </div> 
   <?php } ?>
</div>