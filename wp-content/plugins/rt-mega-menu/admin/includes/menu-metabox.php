<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
if ( !class_exists('RTMEGA_MENU_Nav')) {
    class RTMEGA_MENU_Nav {

        function __construct(){
            add_action( 'admin_footer', array( $this, 'rtmega_menu_pop_up_content' ) );
            add_action( "wp_ajax_rtmega_get_menu_switch", array ( $this, 'rtmega_get_menu_switch' ) );
        }

  
        public function rtmega_get_menu_switch (){

            check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to manage menu options.', 'rt-mega-menu' ) ) );
            }

            $selected_menu_id = isset( $_REQUEST['menu_id'] ) ? absint( $_REQUEST['menu_id'] ) : 0;

            $menu = wp_get_nav_menu_object($selected_menu_id);

            $rtmega_menu_options = array();

            if ($menu) {
                $menu_slug = $menu->slug;
                $rtmega_menu_options = get_option( 'rtmega_menu_settings_'.$menu_slug);
            } 

            $rtmega_menu_options_switch = isset($rtmega_menu_options['enable_menu']) ? $rtmega_menu_options['enable_menu'] : '';

            ?>
                <div class="rtmega-menu-switch-wrapper">
                    <div class="ajax-loader">
                        <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/ajax-loader.gif'); ?>" alt="Ajax Loader">
                    </div>
                    <label class="menu-item-title">
                
                        <input 
                        type="checkbox" 
                        class="menu-item-checkbox rt_mega_menu_switch" 
                        name="rt_mega_menu_switch" 
                        value="<?php echo esc_attr( $rtmega_menu_options_switch == 'on' ? 'on' : '' ) ?>" <?php echo esc_attr( $rtmega_menu_options_switch == 'on' ? 'checked' : '' ) ?>>
                            <?php echo esc_html__( 'Enable RT Mega Menu', 'rt-mega-menu' )?>
                    </label>
                    <p><input type="submit" class="button button-primary button-large save-rtmega-menu" value="<?php esc_attr_e( 'Save', 'rt-mega-menu' ); ?>"></p>
                    </div>
            <?php
            wp_die();

        }

        public function rtmega_menu_pop_up_content(){
            ob_start();
            $contents = ob_get_clean();

            ?>
                <div id="rtmega-menu-setting-modal" style="display: none;">
                    <div class="rtmega-menu-overlay"></div>
                    <div class="rtmega-modal-body">
                        <div class="ajax-loader">
                            <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/ajax-loader.gif'); ?>" alt="Ajax Loader">
                        </div>
                        <button type="button" class="rtmega-menu-modal-closer"><span class="dashicons dashicons-no"></span></button>
                        <div class="rtmega-modal-content">
                            
                                <div class="tabs">
                                    <ul id="tabs-nav">
                                        <li><a href="#tab1"><?php echo esc_html__( 'Content Template', 'rt-mega-menu' )?></a></li>
                                        <li><a href="#tab2"><?php echo esc_html__( 'Style', 'rt-mega-menu' )?></a></li>
                                        <li><a href="#tab3"><?php echo esc_html__( 'Conditions', 'rt-mega-menu' )?></a></li>
                                        <?php do_action( 'rtmega_menu_item_tab_nav' ); ?>
                                    </ul> <!-- END tabs-nav -->
                                    <div class="tab-contents-wrapper">

                                    </div>
                                    <p class="form-status"></p>
                                    <div class="tab-footer">
                                        <button type="button" data-action="save" class="button save-rt-menu-item-options"><?php echo esc_html__( 'Save', 'rt-mega-menu' )?></button>
                                        <button type="button" data-action="save-close" class="button save-rt-menu-item-options"><?php echo esc_html__( 'Save & Close', 'rt-mega-menu' )?></button>
                                        <button type="button" data-action="disable" class="button delete-rt-menu-item-options"><?php echo esc_html__( 'Disable Mega Menu', 'rt-mega-menu' )?></button>
                                    </div>
                                </div> <!-- END tabs -->
                            
                        </div>
                    </div>
                </div>
            <?php
            echo esc_html($contents);
        }
       
    }
    $RTMEGA_MENU_Nav = new RTMEGA_MENU_Nav();
}


