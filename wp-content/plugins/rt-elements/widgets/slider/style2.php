<!-- Slides -->
<div class="swiper-slide v-center">
    <div class="swiper-inner" style="background: url(<?php echo $image;?>);">
        <div class="sw-caption">
            <div class="container">
                <div class="row gx-5 justify-content-center align-items-center">                                            
                    <div class="spacer-double"></div>
                    <?php if($style2_item_image) : ?>
                        <div class="col-lg-6 col-10 text-center mb-sm-30">
                            <img src="<?php echo $style2_item_image;?>;" class="img-fluid slide_img" alt="image">
                        </div>
                    <?php endif; ?>
                    <div class="col-lg-6 mb-sm-30">
                        <div class="sw-text-wrapper border-left">
                            <?php if($sub_title) : ?>
                                <div class="subtitle mb-2"><?php echo esc_html($sub_title);?></div>
                            <?php endif; ?>
                            <?php if($title) : ?>
                                <h2 class="slider-title mb-2"><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>
                            <?php if($description) : ?>
                                <p class="slider-teaser"><?php echo esc_html($description);?></p>
                            <?php endif; ?>
                            <div class="spacer-10"></div>
                            <?php if($btn_text): ?>
                                <a class="btn-main" href="<?php echo esc_url($link);?>" <?php echo $target;?>><?php echo esc_html($btn_text); ?></a>
                            <?php endif; ?>

                            <div class="row mt-4 slider-extra">
                            <?php 
                                if($settings['slider2_feature_list']):
                                foreach ($settings['slider2_feature_list'] as $index => $item) : 
                            ?>
                                <div class="col-3">
                                    <img src="<?php echo esc_url($item['slider_logo_image']['url'])?>" class="img-fluid px-2" alt="logo">
                                </div>
                                <?php endforeach; 
                                    endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>
<!-- Slides -->