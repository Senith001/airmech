<?php
    get_header();
    $coolair_option = get_option('coolair_option');
    $post_id      = get_the_id();
    $author_id    = get_post_field ('post_author', $post_id);
    $display_name = get_the_author_meta( 'display_name' , $author_id );

    //checking page layout 
    $page_layout = get_post_meta( $post->ID, 'layout', true );
    $col_side = '';
    $col_letf = '';
    if($page_layout == '2left'){
        $col_side = '8';
        $col_letf = 'left-sidebar';}
    else if($page_layout == '2right' && is_active_sidebar( 'sidebar-1' )){
        $col_side = '8';}
    else{
        $col_side = '12';
    }
    ?>
    <div class="container"><div id="content">
    <!-- Blog Detail Start -->
    <div class="reactheme-blog-details pt-70 pb-70">
        <div class="row padding-<?php echo esc_attr( $col_letf) ?>">
            <div class="col-lg-<?php echo esc_attr( $col_side). ' ' .esc_attr( $col_letf) ?>">
                <div class="news-details-inner">
                    <?php
                        while ( have_posts() ) : the_post();
                    ?>             
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>             
                        <?php if(has_post_thumbnail()){ ?>
                        <div class="bs-img">
                          <?php the_post_thumbnail()?>
                        </div>
                        <?php } ?>
                       
                        <?php
                          get_template_part( 'template-parts/post/content', get_post_format() );         
                        ?>
                        <div class="clear-fix"></div>      
                    </article> 
                
                    <?php                    
                        $author_data = !empty($coolair_option['blog-author']) ? $coolair_option['blog-author'] : '';
                        if( !empty($author_data) ){
                           if($author_data == 'show'){
                        ?>
                            <div class="author-block">
                                <div class="author-img"> <?php echo get_avatar(get_the_author_meta( 'ID' ), 200);?> </div>
                                <div class="author-desc">
                                    <h3 class="author-title">
                                        <?php the_author();?>
                                    </h3>
                                    <p>
                                        <?php   
                                            echo wpautop( get_the_author_meta( 'description' ) );
                                        ?>
                                    </p>
                                     <!-- Author Socila Info  -->
                                       <?php
                                            if (is_single()) {
                                                $author_ID = get_the_author_meta('ID');
                                                $twitter_url = get_the_author_meta('twitter_url', $author_ID);
                                                $instagram_url = get_the_author_meta('instagram_url', $author_ID);
                                                $pinterest_url = get_the_author_meta('pinterest_url', $author_ID);
                                                $signature_image = get_the_author_meta('user_signature_image', $author_ID);
                                            }
                                        ?>

                                        <div class="rts-author-social-area">
                                            <ul>
                                                <?php
                                                if ($twitter_url || $instagram_url || $pinterest_url) {
                                                    if ($twitter_url) {
                                                        echo '<li><a href="' . esc_url($twitter_url) . '" target="_blank" class="t"><i class="fab fa-twitter"></i></a></li>';
                                                    }
                                                    if ($instagram_url) {
                                                        echo '<li><a href="' . esc_url($instagram_url) . '" target="_blank" class="in"><i class="fab fa-instagram"></i></a></li>';
                                                    }
                                                    if ($pinterest_url) {
                                                        echo '<li><a href="' . esc_url($pinterest_url) . '" target="_blank" class="p"><i class="fab fa-pinterest"></i></a></li>';
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <div class="author_signature">
                                                <?php 
                                                    if ($signature_image) {
                                                        echo esc_url($signature_image) ? '<img src="' . esc_url($signature_image) . '" alt="signature_image"></img>' : '';  
                                                    }          
                                                ?>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                            <!-- .author-block -->
                    <?php }   }         
                    $blog_author = '';
                    if($blog_author == ""){
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    }
                    else
                        {
                        $blog_author = $coolair_option['blog-comments'];
                        if($blog_author == 'show'){     
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                          comments_template();
                        endif;
                        }
                    }
                endwhile; // End of the loop.
                ?>
            </div>
        </div>
          <?php
            if( $page_layout == '2left' || $page_layout == '2right'):
                get_sidebar('single');
            endif;
          ?>    
        </div>
    </div>
    <!-- Blog Detail End --> 
      
<?php
get_footer();