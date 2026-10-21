<div class="<?php echo esc_html($col);?>">
        <div class="single-blog-area-style-one eight-area rt_blog_item_style">
            <div class="post-image mb-0 rounded-3 overflow-hidden">
                <a href="<?php the_permalink() ?>" class="thumbnail">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                    <?php endif; ?>
                </a>
                <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                    <div class="cat_list">
                        <?php the_category( ); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="inner-content-wrapper post-text pt-4">
                <div class="bottom-area">
                    <?php if ($settings['blog_avatar_show_hide'] == 'yes') : ?>
                        <span class="admin"><?php the_author(); ?></span>
                    <?php endif; ?>
                    <?php if ($settings['blog_date_show_hide'] == 'yes') : ?>
                        <span class="date">• <?php echo get_the_date(); ?></span>
                    <?php endif; ?>
                </div>
                <a href="<?php the_permalink() ?>">
                    <h4 class="title">
                        <?php
                           the_title();
                        ?>
                    </h4>
                </a>
                <p class="desc mb-0"><?php echo coolair_custom_excerpt(24);?></p>
                <?php if($settings['blog_readmore_show_hide'] =='yes'):?>
                    <a href="<?php the_permalink() ?>" class="btn-main btn-light-trans mt-3"><?php echo $settings['blog_btn_text'];?></a>
                <?php endif;?>
            </div>
        </div>
    </div>