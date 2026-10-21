<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "coolair_option";

// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters('coolair/opt_name', $opt_name);

/*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

$theme = wp_get_theme(); // For use with some settings. Not necessary.
$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    'page_priority'        => 8,
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__('Coolair Options', 'coolair'),
    'page_title'           => esc_html__('Coolair Options', 'coolair'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 20,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    'forced_dev_mode_off' => true,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    'compiler' => true,
    // OPTIONAL -> Give you extra features
    'page_priority'        => 20,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.
    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    'force_output' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);
// Panel Intro text -> before the form
if (!isset($args['global_variable']) || $args['global_variable'] !== false) {
    if (!empty($args['global_variable'])) {
        $v = $args['global_variable'];
    } else {
        $v = str_replace('-', '_', $args['opt_name']);
    }
    $args['intro_text'] = sprintf(esc_html__('coolair Theme', 'coolair'), $v);
} else {
    $args['intro_text'] = esc_html__('coolair Theme', 'coolair');
}
Redux::setArgs($opt_name, $args);
/*
     * ---> END ARGUMENTScoolair
      
     */
// -> START General Settings
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('General Settings', 'coolair'),
        'id'               => 'basic-checkbox',
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id'       => 'enable_global',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Global Settings', 'coolair'),
                'subtitle' => esc_html__('If you enable global settings all option will be work only theme option', 'coolair'),
                'default'  => false,
            ),

            array(
                'id'       => 'container_size',
                'title'    => esc_html__('Container Size', 'coolair'),
                'subtitle' => esc_html__('Container Size example(1200px)', 'coolair'),
                'type'     => 'text',
                'default'  => '1320px'
            ),

            array(
                'id'       => 'rs_favicon',
                'type'     => 'media',
                'title'    => esc_html__('Upload Favicon', 'coolair'),
                'subtitle' => esc_html__('Upload your faviocn here', 'coolair'),
                'url' => true
            ),

            array(
                'id'       => 'off_sticky',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Sticky Menu', 'coolair'),
                'subtitle' => esc_html__('You can show or hide sticky menu here', 'coolair'),
                'default'  => false,
            ),  
            array(
                'id'       => 'show_top_bottom',
                'type'     => 'switch', 
                'title'    => esc_html__('Scroll to Top', 'coolair'),
                'subtitle' => esc_html__('You can show or hide here', 'coolair'),
                'default'  => false,
            ),         
        )
    )
);
//Preloader settings
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Preloader Style', 'coolair'),
        'desc'   => esc_html__('Preloader Style Here', 'coolair'),
        'fields' => array(
            array(
                'id'       => 'show_preloader',
                'type'     => 'switch',
                'title'    => esc_html__('Show Preloader', 'coolair'),
                'subtitle' => esc_html__('You can show or hide preloader', 'coolair'),
                'default'  => false,
            ),

            array(
                'id'        => 'preloader_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Preloader Background Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#083D59',
                'validate'  => 'color',
                'output'    => array('background' => '#de-loader')
            ),
           

            array(
                'id'        => 'preloader_animate_color2',
                'type'      => 'color',
                'title'     => esc_html__('Preloader Animate Middle Circle Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
               
                'validate'  => 'color',
                'output'    => array('background' => '.lds-roller div:after')
            ),        
           
        )
    )
);
//End Preloader settings  
// -> START Style Section
Redux::setSection($opt_name, array(
    'title'            => esc_html__('Style', 'coolair'),
    'id'               => 'stle',
    'customizer_width' => '450px',
    'icon' => 'el el-brush',
));
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Global Style', 'coolair'),
        'desc'   => esc_html__('Style your theme', 'coolair'),
        'subsection' => true,
        'fields' => array(

            array(
                'id'        => 'body_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Body Backgroud Color', 'coolair'),
                'subtitle'  => esc_html__('Pick body background color', 'coolair'),
                'default'   => '#ffffff',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'body_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Text Color', 'coolair'),
                'subtitle'  => esc_html__('Pick text color', 'coolair'),
                'default'   => '#4F4F55',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'color-primary',
                'type'      => 'color',
                'title'     => esc_html__('Primary Color', 'coolair'),
                'subtitle'  => esc_html__('Select Primary Color.', 'coolair'),
                'default'   => '#614CE1',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'color-primary-2',
                'type'      => 'color',
                'title'     => esc_html__('Primary Color Two', 'coolair'),
                'subtitle'  => esc_html__('Select Primary Color two.', 'coolair'),
                'default'   => '#4C4FF8',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'color-secondary',
                'type'      => 'color',
                'title'     => esc_html__('Secondary Color', 'coolair'),
                'subtitle'  => esc_html__('Select Secondary Color.', 'coolair'),
                'default'   => '#1F1F25',
                'validate'  => 'color',
            ),            
            array(
                'id'        => 'color-secondary-2',
                'type'      => 'color',
                'title'     => esc_html__('Secondary Color Two', 'coolair'),
                'subtitle'  => esc_html__('Select Secondary Color Two.', 'coolair'),
                'default'   => '#FF6354',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'link_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Link Color', 'coolair'),
                'subtitle'  => esc_html__('Pick Link color', 'coolair'),
                'default'   => '#FF6354',
                'validate'  => 'color',
            ),

            array(
                'id'        => 'link_hover_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Link Hover Color', 'coolair'),
                'subtitle'  => esc_html__('Pick link hover color', 'coolair'),
                'default'   => '#083D59',
                'validate'  => 'color',
            ),

        )
    )
);
//Button settings
Redux::setSection(
    $opt_name,
    array(
        'title'      => esc_html__('Button Style', 'coolair'),
        'desc'       => esc_html__('Button Style Here', 'coolair'),
        'subsection' => true,
        'fields' => array(

            array(
                'id'        => 'btn_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Background Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#614CE1',
                'validate'  => 'color',
                'output'    => array('background-color' => '.react-button a')
            ),

            array(
                'id'        => 'btn_bg_hover',
                'type'      => 'color',
                'title'     => esc_html__('Hover Background', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#26262C',
                'validate'  => 'color',
                'output'    => array('background' => '.react-button a:hover')

            ), 
            array(
                'id'        => 'btn_text_color',
                'type'      => 'color',
                'title'     => esc_html__('Text Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#ffffff',
                'validate'  => 'color',
                'output'    => array('.react-button a')
            ),

            array(
                'id'        => 'btn_txt_hover_color',
                'type'      => 'color',
                'title'     => esc_html__('Hover Text Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#ffffff',
                'validate'  => 'color',
                'output'    => array('.react-button a:hover')
            )
        )
    )
);
//Breadcrumb settings
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Banner Area Style', 'coolair'),
        'subsection' => true,
        'fields' => array(

            array(
                'id'       => 'off_banner',
                'type'     => 'switch',
                'title'    => esc_html__('Disable Banner Area', 'coolair'),
                'subtitle' => esc_html__('You can show or hide off pages banner area', 'coolair'),
                'default'  => true,
            ),
            array(
                'id'       => 'off_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Show off Breadcrumb', 'coolair'),
                'subtitle' => esc_html__('You can show or hide off breadcrumb here', 'coolair'),
                'default'  => true,
            ),
            array(
                'id'       => 'align_breadcrumb',
                'type'     => 'switch',
                'title'    => esc_html__('Breadcrumb Align Left', 'coolair'),
                'subtitle' => esc_html__('You can breadcrumb align left', 'coolair'),
                'default'  => false,
            ),
            array(
                'id'        => 'breadcrumb_bg_color',
                'type'      => 'color',
                'title'     => esc_html__('Background Bg Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#f6f6f6',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'page_title_color',
                'type'      => 'color',
                'title'     => esc_html__('Banner Title Color', 'coolair'),
                'subtitle'  => esc_html__('Pick color', 'coolair'),
                'default'   => '#000',
                'validate'  => 'color',               
            ),
            array(
                'id'          => 'opt-typography',
                'type'        => 'typography', 
                'title'       => __('Banner Title Typography', 'coolair'),    
                'output'      => array('.reactheme-breadcrumbs .page-title'),
                'units'       =>'px',
                'subtitle'    => __('Typography option with each property can be called individually.', 'coolair'),                
            ),
            array(
                'id'        => 'breadcrumb_top_gap',
                'type'      => 'text',
                'title'     => esc_html__('Top Gap', 'coolair'),
                'default'   => '30px',
            ),          
            array(
                'id'       => 'page_banner_main',
                'type'     => 'media',
                'title'    => esc_html__('Background Banner', 'coolair'),
                'subtitle' => esc_html__('Upload your banner', 'coolair'),
            ),
            array(
                'id'        => 'breadcrumb_top_gap',
                'type'      => 'text',
                'title'     => esc_html__('Top Gap', 'coolair'),
                'default'   => '190px',

            ),
            array(
                'id'        => 'breadcrumb_bottom_gap',
                'type'      => 'text',
                'title'     => esc_html__('Bottom Gap', 'coolair'),
                'default'   => '100px',
            ),

            array(
                'id'        => 'mobile_breadcrumb_top_gap',
                'type'      => 'text',
                'title'     => esc_html__('Mobile Top Gap', 'coolair'),
                'default'   => '150px',

            ),
            array(
                'id'        => 'mobile_breadcrumb_bottom_gap',
                'type'      => 'text',
                'title'     => esc_html__('Mobile Bottom Gap', 'coolair'),
                'default'   => '80px',
            ),

        )
    )
);
//-> START Typography
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('Typography', 'coolair'),
        'id'     => 'typography',
        'desc'   => esc_html__('You can specify your body and heading font here', 'coolair'),
        'icon'   => 'el el-font',
        'fields' => array(
            array(
                'id'       => 'opt-typography-body',
                'type'     => 'typography',
                'title'    => esc_html__('Body Font', 'coolair'),
                'subtitle' => esc_html__('Specify the body font properties.', 'coolair'),
                'google'   => true,
                'font-style' => false,
                'default'  => array(
                    'font-size'   => '16px',
                    'font-family' => 'Jost',
                    'font-weight' => '400',
                ),
            ),
            array(
                'id'       => 'opt-typography-primary',
                'type'     => 'typography',
                'title'    => esc_html__('Primary Font', 'coolair'),
                'subtitle' => esc_html__('Specify the primary font properties.', 'coolair'),
                'google'   => true,
                'font-style' => false,
                'default'  => array(
                    'color'       => '',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '',
                    'font-weight' => '',
                ),
            ),
            array(
                'id'       => 'opt-typography-menu',
                'type'     => 'typography',
                'title'    => esc_html__('Navigation Font', 'coolair'),
                'subtitle' => esc_html__('Specify the menu font properties.', 'coolair'),
                'google'   => true,
                'font-backup' => true,
                'all_styles'  => true,
                'default'  => array(
                    'color'       => '',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '15px',
                    'font-weight' => '500',
                ),
            ),
            array(
                'id'          => 'opt-typography-h1',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H1', 'coolair'),
                'font-backup' => true,
                'all_styles'  => true,
                'units'       => 'px',
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'coolair'),
                'default'     => array(
                    'color'       => '#083d59',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '46px',
                    'line-height' => '56px'

                ),
                'output'        => array('h1','.react-heading h1.title', '.rs-dual-heading h1.title')
            ),
            array(
                'id'          => 'opt-typography-h2',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H2', 'coolair'),
                'font-backup' => true,
                'all_styles'  => true,
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'coolair'),
                'default'     => array(
                    'color'       => '#083d59',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '36px',
                    'line-height' => '46px'

                ),
                'output'        => array('h2','.react-heading .title-inner h2.title', '.rs-dual-heading .title-inner h2.title')
            ),
            array(
                'id'          => 'opt-typography-h3',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H3', 'coolair'),
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'coolair'),
                'default'     => array(
                    'color'       => '#083d59',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '28px',
                    'line-height' => '32px'

                ),
                'output'        => array('h3','.react-heading .title-inner h3.title', '.rs-dual-heading .title-inner h3.title')
            ),
            array(
                'id'          => 'opt-typography-h4',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H4', 'coolair'),
                'font-backup' => false,
                'all_styles'  => true,
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'coolair'),
                'default'     => array(
                    'color'       => '#083d59',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '20px',
                    'line-height' => '28px'
                ),
                'output'        => array('h4','.react-heading .title-inner h4.title', '.rs-dual-heading .title-inner h4.title')
            ),
            array(
                'id'          => 'opt-typography-h5',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H5', 'coolair'),
                'font-backup' => false,
                'all_styles'  => true,
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'coolair'),
                'default'     => array(
                    'color'       => '#083d59',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '18px',
                    'line-height' => '26px'
                ),
                'output'        => array('h5','.react-heading .title-inner h5.title', '.rs-dual-heading .title-inner h5.title')
            ),
            array(
                'id'          => 'opt-typography-6',
                'type'        => 'typography',
                'title'       => esc_html__('Heading H6', 'coolair'),

                'font-backup' => false,
                'all_styles'  => true,
                'units'       => 'px',
                // Defaults to px
                'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'coolair'),
                'default'     => array(
                    'color'       => '#083d59',
                    'font-style'  => '700',
                    'font-family' => '',
                    'google'      => true,
                    'font-size'   => '16px',
                    'line-height' => '20px'
                ),
                'output'        => array('h6','.react-heading .title-inner h6.title', '.rs-dual-heading .title-inner h6.title')
            ),

        )
    )

);
if (class_exists('WooCommerce')) {
    Redux::setSection(
        $opt_name,
        array(
            'title'            => esc_html__('Woocommerce', 'coolair'),
            'id'               => 'shop_layout',
            'customizer_width' => '450px',
            'icon'   => 'el el-shopping-cart',
            'fields'           => array(
                array(
                    'id'       => 'wc_num_product',
                    'type'     => 'text',
                    'title'    => esc_html__('Number of Products Per Page', 'coolair'),
                    'default'  => '9',
                ),
                array(
                    'id'       => 'wc_num_product_per_row',
                    'type'     => 'text',
                    'title'    => esc_html__('Number of Products Per Row', 'coolair'),
                    'default'  => '3',
                ),
            )
        )
    );
};

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Portfolio Section', 'coolair' ),
    'id'               => 'Portfolio',
    'customizer_width' => '450px',
    'icon' => 'el el-align-right',
    'fields'           => array(
    
       
         array(
                'id'       => 'portfolio_slug',                               
                'title'    => esc_html__( 'Portfolio Slug', 'coolair' ),
                'subtitle' => esc_html__( 'Enter Portfolio Slug Here', 'coolair' ),
                'type'     => 'text',
                'default'  => 'rt-portfolios',                
            ), 
            array(
                'id'       => 'portfolio_cat_slug',                               
                'title'    => esc_html__( 'Portfolio Category Slug', 'coolair' ),
                'subtitle' => esc_html__( 'Enter Portfolio Cat Slug Here', 'coolair' ),
                'type'     => 'text',
                'default'  => '',                    
            ),

           
        )
     ) 
);

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Product Section', 'coolair' ),
    'id'               => 'product',
    'customizer_width' => '450px',
    'icon' => 'el el-align-right',
    'fields'           => array(
    
       
         array(
                'id'       => 'product_slug',                               
                'title'    => esc_html__( 'Product Slug', 'coolair' ),
                'subtitle' => esc_html__( 'Enter Product Slug Here', 'coolair' ),
                'type'     => 'text',
                'default'  => 'rt-product',               
            ),
        )
     ) 
);
/*Blog Sections*/
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Blog', 'coolair'),
        'id'               => 'blog',
        'customizer_width' => '450px',
        'icon' => 'el el-comment',
    )
);
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Blog Settings', 'coolair'),
        'id'               => 'blog-settings',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'    => 'blog_banner_main',
                'url'   => true,
                'title' => esc_html__('Blog Page Banner', 'coolair'),
                'type'  => 'media',
            ),

            array(
                'id'    => 'blog_banner_icon',
                'url'   => true,
                'title' => esc_html__('Blog Icon', 'coolair'),
                'type'  => 'media',
            ),

            array(
                'id'       => 'blog_sub_title',
                'title'    => esc_html__('Blog  Sub Title', 'coolair'),
                'subtitle' => esc_html__('Enter Blog  Sub Title Here', 'coolair'),
                'default'  => 'Our Blog',
                'type'     => 'text',
            ),          


            array(
                'id'       => 'blog_title',
                'title'    => esc_html__('Blog  Title', 'coolair'),
                'subtitle' => esc_html__('Enter Blog  Title Here', 'coolair'),
                'type'     => 'text',
            ),  
            
            array(
                'id'       => 'blog_tagline',
                'title'    => esc_html__('Blog  Tag Line', 'coolair'),
                'subtitle' => esc_html__('Enter Blog Tagline Here', 'coolair'),
                'type'     => 'text',
            ),
            array(
                'id'               => 'blog-layout',
                'type'             => 'image_select',
                'title'            => esc_html__('Select Blog Layout', 'coolair'),
                'subtitle'         => esc_html__('Select your blog layout', 'coolair'),
                'options'          => array(
                    'full'             => array(
                        'alt'              => esc_html__('Blog Style 1', 'coolair'),
                        'img'              => get_template_directory_uri() . '/libs/img/1c.png'
                    ),
                    '2right'           => array(
                        'alt'              => esc_html__('Blog Style 2', 'coolair'),
                        'img'              => get_template_directory_uri() . '/libs/img/2cr.png'
                    ),
                    '2left'            => array(
                        'alt'              => esc_html__('Blog Style 3', 'coolair'),
                        'img'              => get_template_directory_uri() . '/libs/img/2cl.png'
                    ),
                ),
                'default'          => '2right'
            ),

            array(
                'id'               => 'blog-grid',
                'type'             => 'select',
                'title'            => esc_html__('Select Blog Gird', 'coolair'),
                'desc'             => esc_html__('Select your blog gird layout', 'coolair'),
                //Must provide key => value pairs for select options
                'options'          => array(
                    '12'               => esc_html__('1 Column', 'coolair'),
                    '6'                => esc_html__('2 Column', 'coolair'),
                    '4'                => esc_html__('3 Column', 'coolair'),
                    '3'                => esc_html__('4 Column', 'coolair'),
                ),
                'default'          => '12',
            ),

            array(
                'id'               => 'blog-author-post',
                'type'             => 'select',
                'title'            => esc_html__('Show Author Info ', 'coolair'),
                'desc'             => esc_html__('Select author info show or hide', 'coolair'),
                //Must provide key => value pairs for select options
                'options'          => array(
                    'show'             => esc_html__('Show', 'coolair'),
                    'hide'             => esc_html__('Hide', 'coolair'),
                ),
                'default'          => 'show',

            ),

            array(
                'id'               => 'blog-category',
                'type'             => 'select',
                'title'            => esc_html__('Show Category', 'coolair'),

                //Must provide key => value pairs for select options
                'options'          => array(
                    'show'             => esc_html__('Show', 'coolair'),
                    'hide'             => esc_html__('Hide', 'coolair'),
                ),
                'default'          => 'show',

            ),
            array(
                'id'               => 'blog-date',
                'type'             => 'switch',
                'title'            => esc_html__('Show Date', 'coolair'),
                'desc'             => esc_html__('You can show/hide date at blog page', 'coolair'),

                'default'          => true,
            ),
            array(
                'id'               => 'blog-post-content',
                'type'             => 'select',
                'title'            => esc_html__('Show Blog Content ', 'coolair'),
                'desc'             => esc_html__('Show your blog content', 'coolair'),
                //Must provide key => value pairs for select options
                'options'          => array(
                    'show'             => esc_html__('Show', 'coolair'),
                    'hide'             => esc_html__('Hide', 'coolair'),
                ),
                'default'          => 'show',

            ),
            array(
                'id'               => 'blog_readmore',
                'title'            => esc_html__('Blog  ReadMore Text', 'coolair'),
                'subtitle'         => esc_html__('Enter Blog  ReadMore Here', 'coolair'),
                'type'             => 'text',
            ),

        )
    )
);
/*Single Post Sections*/
Redux::setSection(
    $opt_name,
    array(
        'title'            => esc_html__('Single Post', 'coolair'),
        'id'               => 'spost',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id'       => 'single_blog_title',
                'title'    => esc_html__('Single Blog  Title', 'coolair'),
                'subtitle' => esc_html__('Enter Title Here', 'coolair'),
                'type'     => 'text',
            ),
            array(
                'id'       => 'blog_banner',
                'url'      => true,
                'title'    => esc_html__('Blog Single page banner', 'coolair'),
                'type'     => 'media',

            ),
           
            array(
                'id'       => 'blog-comments',
                'type'     => 'select',
                'title'    => esc_html__('Show Comment', 'coolair'),
                'desc'     => esc_html__('Select comments show or hide', 'coolair'),
                //Must provide key => value pairs for select options
                'options'  => array(
                    'show' => esc_html__('Show', 'coolair'),
                    'hide' => esc_html__('Hide', 'coolair'),
                ),
                'default'  => 'show',

            ),

            array(
                'id'       => 'blog-author',
                'type'     => 'select',
                'title'    => esc_html__('Show Ahthor Info', 'coolair'),
                'desc'     => esc_html__('Select author info show or hide', 'coolair'),
                //Must provide key => value pairs for select options
                'options'  => array(
                    'show' => esc_html__('Show', 'coolair'),
                    'hide' => esc_html__('Hide', 'coolair'),
                ),
                'default'  => 'show',
            ),
            
            array(
                'id'       => 'single_blog_img_size',
                'title'    => esc_html__('Single Blog  Image Size', 'coolair'),
                'subtitle' => esc_html__('Enter Image Size Here', 'coolair'),
                'type'     => 'text',
                'default'  => '400px',
            ),

        )
    )
);
Redux::setSection(
    $opt_name,
    array(
        'title'  => esc_html__('404 Error Page', 'coolair'),
        'desc'   => esc_html__('404 details  here', 'coolair'),
        'icon'   => 'el el-error-alt',
        'fields' => array(

            array(
                'id'       => 'title_404',
                'type'     => 'text',
                'title'    => esc_html__('Title', 'coolair'),
                'subtitle' => esc_html__('Enter title for 404 page', 'coolair'),
                'default'  => esc_html__('404', 'coolair')
            ),

            array(
                'id'       => 'text_404',
                'type'     => 'text',
                'title'    => esc_html__('Text', 'coolair'),
                'subtitle' => esc_html__('Enter text for 404 page', 'coolair'),
                'default'  => esc_html__('Page Not Found', 'coolair')
            ),


            array(
                'id'       => 'back_home',
                'type'     => 'text',
                'title'    => esc_html__('Back to Home Button Label', 'coolair'),
                'subtitle' => esc_html__('Enter label for "Back to Home" button', 'coolair'),
                'default'  => esc_html__('Back to Homepage', 'coolair')

            ),
            array(
                'id'       => '404_bg',
                'type'     => 'media',
                'title'    => esc_html__('404 page Image', 'coolair'),
                'subtitle' => esc_html__('Upload your image', 'coolair'),
                'url' => true
            ),


        )
    )
);
if (!function_exists('compiler_action')) {
    function compiler_action($options, $css, $changed_values)
    {
        echo '<h1>The compiler hook has run!</h1>';
        echo "<pre>";
        print_r($changed_values); // Values that have changed since the last save
        echo "</pre>";
    }
}
/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')) {
    function redux_validate_callback_function($field, $value, $existing_value)
    {
        $error   = false;
        $warning = false;

        //do your validation
        if ($value == 1) {
            $error = true;
            $value = $existing_value;
        } elseif ($value == 2) {
            $warning = true;
            $value   = $existing_value;
        }

        $return['value'] = $value;

        if ($error == true) {
            $field['msg']    = 'your custom error message';
            $return['error'] = $field;
        }

        if ($warning == true) {
            $field['msg']      = 'your custom warning message';
            $return['warning'] = $field;
        }

        return $return;
    }
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')) {
    function redux_my_custom_field($field, $value)
    {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
}

/**
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.     
 * */
if (!function_exists('dynamic_section')) {
    function dynamic_section($sections)
    {
        //$sections = array();
        $sections[] = array(
            'title'  => esc_html__('Section via hook', 'coolair'),
            'desc'   => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'coolair'),
            'icon'   => 'el el-paper-clip',
            'fields' => array()
        );
        return $sections;
    }
}

/**
 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
 * */
if (!function_exists('change_arguments')) {
    function change_arguments($args)
    {
        return $args;
    }
}

/**
 * Filter hook for filtering the default value of any given field. Very useful in development mode.
 * */
if (!function_exists('change_defaults')) {
    function change_defaults($defaults)
    {
        $defaults['str_replace'] = 'Testing filter hook!';
        return $defaults;
    }
}

/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if (!function_exists('remove_demo')) {
    function remove_demo()
    {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if (class_exists('ReduxFrameworkPlugin')) {
            remove_action('plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2);
            remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
        }
    }
}
