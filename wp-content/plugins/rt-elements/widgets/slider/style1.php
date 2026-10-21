<div class="swiper-slide v-center cHeight" >
    <div class="swiper-inner item-block-bg" style="background: url(<?php echo $image;?>);">
        <div class="sw-caption">
            <div class="container">
                <div class="row gx-5 align-items-center">
                    <div class="spacer-double"></div>
                    <div class="col-lg-8 offset-lg-2 text-center">     
                        <div class="spacer-single"></div>
                        <div class="sw-text-wrapper">
                            <?php if($sub_title) : ?>
                                <div class="subtitle s2 mb-2"><?php echo esc_html($sub_title);?></div>
                            <?php endif; ?>
                            <?php if($title) : ?>
                                <h2 class="slider-title mb-3"><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>
                            <?php if($description) : ?>
                                <h3 class="slider-teaser mb-3"><?php echo esc_html($description);?></h3>
                            <?php endif; ?>
                            <div class="spacer-10"></div>
                            <?php if($btn_text): ?>
                                <a class="btn-main mb10 mb-3" href="<?php echo esc_url($link);?>" <?php echo $target;?>><?php echo esc_html($btn_text); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="spacer-single"></div>
                </div>
                <div class="row g-4 slider-extra sm-hide">
                    <?php $x = 0; 
                        if($settings['feature_list']):
                            foreach ($settings['feature_list'] as $index => $item) : 
                            $x++;                
                            $title        = !empty($item['title']) ? $item['title'] : '';
                            $sub_title    = !empty($item['sub-name']) ? $item['sub-name'] : '';
                            $description  = !empty($item['fe_description']) ? $item['fe_description'] : '';
                            $btn_text     = !empty($item['btn_text']) ? $item['btn_text'] : '';
                            $target       = !empty($item['link']['is_external']) ? 'target=_blank' : '';
                            $link         = !empty($item['link']['url']) ? $item['link']['url'] : ''; 
                    ?>
                        <div class="col-lg-4 col-md-6 mb-sm-30">
                            <div class="f-box f-icon-left f-icon-rounded">
                            <?php if(!empty($item['image'])): ?>
                                <div class="bg-color-2 text-white  circle svg-icon"><?php \Elementor\Icons_Manager::render_icon( $item['image'], [ 'aria-hidden' => 'true' ] ); ?></div>
                            <?php endif; ?>                          
                            
                                <div class="fb-text">
                                    <h4><?php echo  $title;?></h4>
                                    <p><?php echo $description;?></p>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; 
                        endif;
                    ?>              
            
                 
                </div>
            </div>
        </div>
        <img src="<?php echo esc_url($image);?>" class="img-fluid absolute top-0 slider_bg_image" alt="logo">
        <div class="sw-overlay"></div>
    </div>
</div>
<!-- Slides -->