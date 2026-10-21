<div class="reactheme-breadcrumbs  porfolio-details">  
  <?php 
    $coolair_option = get_option('coolair_option');
    if(!empty($coolair_option['blog_banner_main']['url'])) { ?>
    <div class="breadcrumbs-single" style="background-image: url('<?php echo esc_url($coolair_option['blog_banner_main']['url']);?>')">
    <?php }
    elseif(!empty($coolair_option['breadcrumb_bg_color'])) { ?>
      <div class="breadcrumbs-single" style="background:<?php echo esc_attr($coolair_option['breadcrumb_bg_color']);?>">
      <?php }
    else { ?>
        <div class="breadcrumbs-single">
    <?php } ?>
      <div class="reactheme-breadcrumbs-inner">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="breadcrumbs-inner">
              <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'coolair' ), '<span>' . get_search_query() . '</span>' ); ?></h1>            
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
</div>