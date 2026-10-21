<!-- Slides -->
<div class="swiper-slide v-center m-0">
    <div class="swiper-inner" style="background: url(<?php echo $image;?>);">
        <div class="sw-caption">
            <div class="container">
                <div class="row gx-5 justify-content-center align-items-center">                                            
                    <div class="spacer-double"></div>
                    <?php if($style2_item_image) : ?>
                        <div class="col-lg-6 col-6 text-center mb-sm-30">
                            <div class="relative slider-fadeIn">
                                <img src="<?php echo $style2_item_image;?>" class="img-fluid slide_img" alt="image">
                            </div>
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
                            <?php if($description || $style3_logo): ?>
                                <div class="row g-2 align-items-center">
                                    <?php if($description) : ?>
                                        <div class="col-lg-8">
                                            <p class="slider-teaser"><?php echo esc_html($description);?></p>
                                         </div>  
                                    <?php endif; ?>
                                    <?php if($style3_logo) : ?>
                                        <div class="col-md-4 col-5 m-lg-0 mb-2 slider-extra">
                                            <img src="<?php echo $style3_logo;?>" class="w-100" alt="logo">
                                         </div>  
                                    <?php endif; ?> 
                                </div>
                            <?php endif; ?>
                            <div class="spacer-10"></div>
                            <?php if($btn_text): ?>
                                <a class="btn-main" href="<?php echo esc_url($link);?>" <?php echo $target;?>><?php echo esc_html($btn_text); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>                             
    </div>
</div>
<!-- Slides -->