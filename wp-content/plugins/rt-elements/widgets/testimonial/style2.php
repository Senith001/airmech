<div class="swiper-slide slider-<?php echo esc_attr($sstyle); ?>">    
    <div class="de_testi s3">
        <blockquote>
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

            <?php if (!empty($description)): ?>
                <p class="disc">
                    <?php echo wp_kses($description, wp_kses_allowed_html('post'))  ?>
                </p>
            <?php endif ?>

            <div class="d-flex align-items-center justify-content-center gap-2">
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
        </blockquote>
    </div>
</div>

