<div class="swiper-slide slider-<?php echo esc_attr($sstyle); ?>">    
    <div class="de_testi s2">
        <blockquote>
            <i class="icofont-quote-left absolute start-30px top-30px id-color-2 quote"></i>
            <div class="de_testi_by" style="background-size: cover; background-repeat: no-repeat;">
                <?php if(!empty($item['image']['url'])) : ?>
                    <img class="bg-white p-2 circle" src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_attr('image') ?>">
                <?php endif; ?>
                <div>
                    <?php if (!empty($item['name'])) : ?>
                        <div class="name">
                            <?php echo esc_html($item['name']) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($item['sub-name'])) : ?>
                        <span class="designation"> 
                            <?php echo esc_html($item['sub-name']) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($description)): ?>
                <p class="disc">
                    <?php echo wp_kses($description, wp_kses_allowed_html('post'))  ?>
                </p>
             <?php endif ?>
            
            <div class="de-rating-ext">
                <?php                
                    $args = array(
                        'rating' => $item['testi_ratings'],
                        'type' => 'rating',
                        'number' => 1234,
                        );
                    wp_star_rating( $args );
                ?> 
            </div>
        </blockquote>
    </div>
</div>

