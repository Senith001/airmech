<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
if ( ! class_exists('RTMEGA_MENU_admin_settings')) {
    class RTMEGA_MENU_admin_settings {

        private $rtmega_menu_options;
    
        function __construct(){   
            
            add_action( 'admin_menu', [$this, 'rtmega_menu_register'] );
            add_action( 'admin_init', [$this, 'rtmega_menu_settings'] );   
    
        }   
    
        public function rtmega_menu_register (){
            add_menu_page( 
                __('RT Mega Menu', 'rt-mega-menu'), 
                __('RT Mega Menu', 'rt-mega-menu'), 
                'manage_options', 
                'rt-mega-menu', 
                array($this, 'rtmega_menu_plugin_page'), 
                'dashicons-editor-kitchensink',
                100
             );
        }
    
    
    
        public function rtmega_menu_settings() {
    
            register_setting(    
                'rtmega_menu_options_group', // option_group    
                'rtmega_menu_options', // option_name
                array(
                    'sanitize_callback' => array($this, 'rtmega_menu_options_sanitize')
                )
            );
    
            add_settings_section(    
                'rtmega_menu_setting_section', // id    
                '', // title    
                array( $this, 'rtmega_menu_settings_section' ), // callback    
                'rtmega-menu-settings' // page    
            );  
    
            add_settings_field(
    
                'rt_mega_menu_width', // id
    
                'Width', // title
    
                array( $this, 'rtmega_render_menu_opts' ), // callback
    
                'rtmega-menu-settings', // page
    
                'rtmega_menu_setting_section' // section
    
            );
    
        }

        function rtmega_menu_options_sanitize( $input ) {
            $output = array();

            if ( ! empty( $input ) && is_array( $input ) ) {
                foreach ( $input as $key => $value ) {
                    
                    $safe_key = sanitize_key( $key );

                    if ( is_array( $value ) ) {
                        // nested array ecursive sanitize
                        $output[ $safe_key ] = array_map( 'sanitize_text_field', $value );
                    } else {
                        $output[ $safe_key ] = sanitize_text_field( $value );
                    }
                }
            }

            return $output;
        }

    
        public function rtmega_get_settings_fields() {
    
            $rtmega_settings_fields = array();
    
            $style_fields = array(
                array(
                    'id'    => 'menu_sections_start',
                    'name'  => 'menu_sections_start',
                    'type'  => 'section_start',
                    'label' => 'Main Menu:',
                ),
                array(
                    'id'    => 'menu_color',
                    'name'  => 'menu_color',
                    'type'  => 'wpcolor',
                    'label' => 'Menu Color',
                ),
                array(
                    'id'    => 'menu_hover_color',
                    'name'  => 'menu_hover_color',
                    'type'  => 'wpcolor',
                    'label' => 'Menu Hover Color',
                ),
                array(
                    'id'    => 'menu_active_color',
                    'name'  => 'menu_active_color',
                    'type'  => 'wpcolor',
                    'label' => 'Menu Active Color',
                ),
                array(
                    'id'    => 'submenu_sections_start',
                    'name'  => 'submenu_sections_start',
                    'type'  => 'section_start',
                    'label' => 'Sub Menu:',
                ),
                array(
                    'id'    => 'submenu_color',
                    'name'  => 'submenu_color',
                    'type'  => 'wpcolor',
                    'label' => 'Menu Color',
                ),
                array(
                    'id'    => 'submenu_hover_color',
                    'name'  => 'submenu_hover_color',
                    'type'  => 'wpcolor',
                    'label' => 'Menu Hover Color',
                ),
                array(
                    'id'    => 'submenu_bg_color',
                    'name'  => 'submenu_bg_color',
                    'type'  => 'wpcolor',
                    'label' => 'Menu Background Color',
                ),
                array(
                    'id'    => 'submenu_width',
                    'name'  => 'submenu_width',
                    'type'  => 'text',
                    'label' => 'Menu Width',
                ),
                
            );
    
            $rtmega_settings_fields['style_fields'] = $style_fields;
            return $rtmega_settings_fields;
    
        }
    
        public function rtmega_menu_plugin_page (){
            
            $this->rtmega_menu_options = get_option( 'rtmega_menu_options' ); ?>
            <h1><?php echo esc_html__( 'RTMEGA Menu Settings', 'rt-mega-menu' ); ?></h1>
            <?php settings_errors(); ?>
            <div class="">
                <form method="POST" action="options.php">
                    <div class="tabs rtmega-menu-settings-tabs">
                        <ul id="tabs-nav">
                            <li><a href="#tab1"><?php echo esc_html__( 'Mega Menu Styles', 'rt-mega-menu' ); ?></a></li>
                            <li><a href="#tab2"><?php echo esc_html__( 'Pro Features', 'rt-mega-menu' ); ?></a></li>
                            <?php do_action( 'rtmega_after_settings_tab_nav_item' ); ?>
                        </ul> <!-- END tabs-nav -->
                        <div class="tab-contents-wrapper">
                            <div id="tab1" class="tab-content" style="display: none;">
                                <?php
                                    settings_fields( 'rtmega_menu_options_group' );	
                                    do_settings_sections( 'rtmega-menu-settings' ); 
                                    submit_button();
                                ?>
                            </div>
                            <div id="tab2" class="tab-content" style="display: none;">
                                <h1><?php echo esc_html__( 'RT Menu Free Vs RT Menu Pro Features', 'rt-mega-menu' ); ?></h1>
                                <div class="rtmega-features-list-wrapper">
                                    <div class="rtmega-features-list rtmega-features-list-free">
                                        <h3><?php echo esc_html__( 'RT Menu Free', 'rt-mega-menu' ); ?></h3>
                                        <ul>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Template Option.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Individual Menu Width Control Option.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Sub Menu Position.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Menu Icon Picker.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Menu Icon Color.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Menu Badge.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Menu Badge Color.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Menu Badge Background Color.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'User-based menu item visibility controls.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Location-based menu item visibility controls.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'Device-based menu item visibility controls.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-no"></span><?php echo esc_html__( 'WooCommerce customer visibility rules (Logged-in status, Purchase history, and Cart contents)', 'rt-mega-menu' ); ?></li>
                                        </ul>
                                    </div>
                                    <div class="rtmega-features-list rtmega-features-list-free">
                                        <h3><?php echo esc_html__( 'RT Menu Pro', 'rt-mega-menu' ); ?></h3>
                                        <ul>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Template Option.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Individual Menu Width Control Option.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Sub Menu Position.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Icon Picker.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Icon Color.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Badge.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Badge Color.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Menu Badge Background Color.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'User-based menu item visibility controls.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Location-based menu item visibility controls.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Device-based menu item visibility controls.', 'rt-mega-menu' ); ?></li>
                                            <li><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'WooCommerce customer visibility rules (Logged-in status, Purchase history, and Cart contents)', 'rt-mega-menu' ); ?></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                                <a href="https://rtmega.themewant.com" target="_blank" class="button button-primary"><?php echo esc_html__( 'Buy Now', 'rt-mega-menu' ); ?></a>
                            </div>
                            <?php do_action( 'rtmega_after_settings_tab_content' ); ?>
                        </div>
                    </div> <!-- END tabs -->
                    
                </form>
            </div>
            <script>
                (function($){
    
                    $(document).ready(function () {
                    
                        // Show the first tab and hide the rest
                        $('#tabs-nav li:first-child').addClass('active');
                        $('.tab-content').hide();
                        $('.tab-content:first').show();
    
                        // Click function
                        $('#tabs-nav li').click(function(){
                            $('#tabs-nav li').removeClass('active');
                            $(this).addClass('active');
                            $('.tab-content').hide();
                            
                            var activeTab = $(this).find('a').attr('href');
                            $(activeTab).fadeIn();
                            return false;
                        });
    
                        $('input[type="wpcolor"]').wpColorPicker();
    
    
    
                    });
    
                })(jQuery);
            </script>

            <?php
        }
    
    
        public function rtmega_menu_settings_section (){ 
            
        }
    
        public function rtmega_render_menu_opts() {
    
            $rtmega_settings_fields = $this->rtmega_get_settings_fields();
    
            
    
            foreach ($rtmega_settings_fields['style_fields'] as $field) {
                if($field['type'] == 'section_start'){
                    ?>
                    <h3 class="settings-section"><?php echo esc_html($field['label']) ?></h3>
                    <?php
                }else{
    
                    $val = '';
                    if( isset( $this->rtmega_menu_options[$field['name']]) ){
                        $val = $this->rtmega_menu_options[$field['name']];
                    }else if(isset($field['default'])){
                        $val = $field['default'];
                    }
    
    
                    printf(
                        '<div class="settings-item"><label>'. esc_html($field['label']) .'</label>
                        <input type="'. esc_html($field['type']).'" name="rtmega_menu_options['. esc_html($field['name']) .']" id="rtmega_render_menu_opts" value="%s"></div>',esc_html($val)
                    );
                }
                
            }  
            
        }   
    
    }

    new RTMEGA_MENU_admin_settings();
}