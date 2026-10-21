<?php
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function coolair_body_classes( $classes ) {
  // Adds a class of hfeed to non-singular pages.
  if ( ! is_singular() ) {
    $classes[] = 'hfeed';
  }

  return $classes;
}
add_filter( 'body_class', 'coolair_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function coolair_pingback_header() {
  if ( is_singular() && pings_open() ) {
    echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
  }
}

add_action( 'wp_head', 'coolair_pingback_header' );
/**  kses_allowed_html */
function coolair_prefix_kses_allowed_html($tags, $context) {
  switch($context) {
    case 'coolair': 
      $tags = array( 
        'a' => array('href' => array()),
        'b' => array()
      );
      return $tags;
    default: 
      return $tags;
  }
}
add_filter( 'wp_kses_allowed_html', 'coolair_prefix_kses_allowed_html', 10, 2);

/*
Register Fonts theme google font
*/
function studyhub_studio_scripts() {
  wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap', [], null );    
}
add_action( 'wp_enqueue_scripts', 'studyhub_studio_scripts' );

//Favicon Icon
function coolair_site_icon() {
 if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) {     
    global $coolair_option;
     
    if(!empty($coolair_option['rs_favicon']['url']))
    {?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url(($coolair_option['rs_favicon']['url'])); ?>"> 
  <?php 
    }
  }
}
add_filter('wp_head', 'coolair_site_icon');



//Demo content file include here

function coolair_import_files() {
  return array(
    array(
      'import_file_name'           => 'Homepage One',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/demo-1.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),

      'import_preview_image_url'   => 'https://themewant.com/products/wordpress/landing/coolair/demo/preview/homepage-1.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair',     
      
    ),
    array(
      'import_file_name'           => 'Homepage Two',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/demo-2.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),

      'import_preview_image_url'   => 'https://themewant.com/products/wordpress/landing/coolair/demo/preview/homepage-2.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-two',     
      
    ), 
    array(
      'import_file_name'           => 'Homepage Three',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/demo-3.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),

      'import_preview_image_url'   => 'https://themewant.com/products/wordpress/landing/coolair/demo/preview/homepage-3.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-three/',     
      
    ),

    array(
      'import_file_name'           => 'Homepage Four',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/demo-4.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),

      'import_preview_image_url'   => 'https://themewant.com/products/wordpress/landing/coolair/demo/preview/homepage-4.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-four/',     
      
    ),
    array(
      'import_file_name'           => 'Homepage Five',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/demo-5.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),
      'import_preview_image_url'   => 'https://themewant.com/products/wordpress/landing/coolair/demo/preview/homepage-5.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-five',           
    ),  

    array(
      'import_file_name'           => 'Homepage Six',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/demo-six.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),
      'import_preview_image_url'   => 'https://madebydesignesia.com/themes/coolair/demo/preview/homepage-6.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-six',           
    ), 

    array(
      'import_file_name'           => 'Homepage Seven',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/coolair/demo-seven.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),
      'import_preview_image_url'   => 'https://madebydesignesia.com/themes/coolair/demo/preview/homepage-7.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-seven',           
    ), 

    array(
      'import_file_name'           => 'Homepage Eight',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/coolair/demo-eight.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),
      'import_preview_image_url'   => 'https://madebydesignesia.com/themes/coolair/demo/preview/homepage-8.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-eight',           
    ), 

    array(
      'import_file_name'           => 'Homepage Nine',
      'categories'                 => array( 'Coolair Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/coolair/demo-nine.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),
      'import_preview_image_url'   => 'https://madebydesignesia.com/themes/coolair/demo/preview/homepage-9.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair/homepage-nine',           
    ), 


    array(
      'import_file_name'           => 'RTL Demo',
      'categories'                 => array( 'RTL Demo' ),
      'import_file_url'            =>  get_template_directory_uri() . '/inc/demo-data/rtl/demo-1.xml',
             
      'import_redux'               => array(
        array(
          'file_url'    =>  get_template_directory_uri() . '/inc/demo-data/coolair-options.json',
          'option_name' => 'coolair_option',
        ),
      ),

      'import_preview_image_url'   => 'https://themewant.com/products/wordpress/landing/coolair/demo/preview/homepage-1.webp',
     'import_notice'              => esc_html__( 'Caution: For importing demo data please click on "Import Demo Data" button. During demo data installation please do not refresh the page.', 'coolair' ),
      'preview_url'                => 'https://themewant.com/products/wordpress/coolair-rtl',     
      
    ),
    
  );
}

add_filter( 'pt-ocdi/import_files', 'coolair_import_files' );

function coolair_after_import_setup($selected_import) {
  // Assign menus to their locations.
  $main_menu     = get_term_by( 'name', 'Primary Menu', 'nav_menu' );  
  set_theme_mod( 'nav_menu_locations', array(
      'menu-1' => $main_menu->term_id,          
    )
  );
  if ( 'Homepage One' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage One');
  }

  if ( 'Homepage Two' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Two');
  }

  if ( 'Homepage Three' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Three');
  }

  if ( 'Homepage Four' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Four');
  }

  if ( 'Homepage Five' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Five');
  }

  if ( 'Homepage Six' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Six');
  }

  if ( 'Homepage Seven' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Seven');
  }

  if ( 'Homepage Eight' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage Eight');
  }

  if ( 'Homepage Nine' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('homepage Nine');
  }

  if ( 'RTL Demo' == $selected_import['import_file_name'] ) {
    $front_page_id = get_page_by_title('Homepage One');
  }
  
  $blog_page_id  = get_page_by_title( 'Blog' );
  update_option( 'show_on_front', 'page' );
  update_option( 'page_on_front', $front_page_id->ID );
  update_option( 'page_for_posts', $blog_page_id->ID );  
}
add_action( 'pt-ocdi/after_import', 'coolair_after_import_setup' );


//disable elementor default style 
update_option('elementor_disable_color_schemes', 'yes');
update_option('elementor_disable_typography_schemes', 'yes');

//added elementor support for custom post type
function coolair_enable_elementor_for_custom_post_type() {
  add_post_type_support( 'rt-portfolios', 'elementor' );
  add_post_type_support( 'rt-products', 'elementor' );
}
add_action( 'init', 'coolair_enable_elementor_for_custom_post_type' );

function coolair_theme_support() {
  remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'coolair_theme_support' );