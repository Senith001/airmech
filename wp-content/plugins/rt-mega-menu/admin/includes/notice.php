<?php
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('RTMEGA__NOTICE__SOURCE_SITE_URL', 'https://themewant.com/menuicon');
class rtmega_NOTICE{ 

    // Get Instance
    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct(){
        add_action('admin_notices', array($this, 'add_notice_to_notice_bar'));
        add_action('wp_dashboard_setup', array($this, 'add_notice_to_dashboard_widget'), 0);
        add_action('wp_ajax_rtmega_ignore_plugin_notice', array($this, 'rtmega_ignore_plugin_notice'));
    }

    public function rtmega_ignore_plugin_notice() {
	
        check_ajax_referer('rtmega_nonce', 'nonce');

        if ( ! current_user_can( 'read' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to perform this action.', 'rt-mega-menu' ) ) );
        }

        $user_id = get_current_user_id();

        if (isset($_POST['notice_id']) && !empty($_POST['notice_id'])) {
            $notice_id = sanitize_text_field(wp_unslash($_POST['notice_id']));

            if ($user_id && !get_user_meta($user_id, 'rtmega_notice_ignore_'.$notice_id, true)) {
                add_user_meta($user_id, 'rtmega_notice_ignore_'.$notice_id, 'true', true);
            }else{
                update_user_meta( $user_id, 'rtmega_notice_ignore_'.$notice_id, 'true' );
            }

            wp_send_json_success();
        }

        wp_die();
        
    }

    public function get_notice_status($notice_id){
        $user_id = get_current_user_id();
        $status = get_user_meta( $user_id, 'rtmega_notice_ignore_'.$notice_id, true );
        return $status;
    }

    public static function get_rtmega_notice($args=[]) {

        $notice_source_url = RTMEGA__NOTICE__SOURCE_SITE_URL . '/wp-json/reacthemes/v1/get_rtmega_notice';

        $cache_key = 'rtmega_notice_' . md5( wp_json_encode( $args ) );
        $cached    = get_transient( $cache_key );
        if ( false !== $cached ) {
            return $cached;
        }

        // Prepare the body with the page parameter
        $body = wp_json_encode($args); // Encode the array to JSON

        $response = wp_remote_post( $notice_source_url, array(
            'headers'     => [
                'Content-Type' => 'application/json',
            ],
            'timeout'     => 10,
            'redirection' => 5,
            'blocking'    => true,
            'httpversion' => '1.0',
            'sslverify'   => true,
            'data_format' => 'body',
            'body'        => $body
        ) );

        if ( is_wp_error( $response ) ) {
            set_transient( $cache_key, '', 10 * MINUTE_IN_SECONDS );
            return '';
        }

        $notice_body = wp_remote_retrieve_body( $response );
        set_transient( $cache_key, $notice_body, 12 * HOUR_IN_SECONDS );

        return $notice_body;
    }

    public function expire_notice_by_date($notice_id, $expire_timestamp){

        $today_date = gmdate('Y-m-d');
        $today_timestamp = strtotime($today_date);

        if($today_timestamp >= $expire_timestamp){

            $user_id = get_current_user_id();
            delete_user_meta( $user_id, 'rtmega_notice_ignore_'.$notice_id );
            
        }
    }

    public function add_notice_to_notice_bar(){

       

        $args = [
            'screen' => 'notice-bar',
        ];

        $all_notice = $this->get_rtmega_notice($args); 

        if(!empty($all_notice) && is_array($all_notice) && $all_notice != '[]' && count($all_notice) > 0){

            $today_date = gmdate('Y-m-d');
            $today_timestamp = strtotime($today_date);
            $all_notice = json_decode($all_notice, true);

            foreach ($all_notice as $key => $notice) {
                $notice_id = isset($notice['notice_id']) ? $notice['notice_id'] : '';
                $thumbnail_url = isset($notice['thumbnail_url']) ? $notice['thumbnail_url'] : '';
                $title = isset($notice['title']) ? $notice['title'] : '';
                $sub_title = isset($notice['sub_title']) ? $notice['sub_title'] : '';
                $content = isset($notice['content']) ? $notice['content'] : '';
                $action_buttons = isset($notice['action_buttons']) ? $notice['action_buttons'] : '';
                $expire_timestamp = isset($notice['expire_date']) ? strtotime($notice['expire_date']): '';
                
           
               $this->expire_notice_by_date($notice_id, $expire_timestamp);
    
               $notice_ignore_status = $this->get_notice_status($notice_id);
                
            
    
                if($notice_ignore_status != 'true' && $today_timestamp <= $expire_timestamp){

                    ?>
                    <div data-notice_id="<?php echo esc_attr( $notice_id )?>" id="rtmega-notice-<?php echo esc_attr( $notice_id )?>" class="rtmega-notice notice is-dismissible" expired_time="<?php echo esc_attr( $notice_id )?>" dismissible="global">
    
                        <?php 
                            if(!empty($thumbnail_url)){ ?>
                                <img class="notice-logo" style="" src="<?php echo esc_url($thumbnail_url) ?>">
                            <?php }
                        ?>
                        <div class="notice-right-container ">
                            <div class="notice-contents">
                               
                                <?php 
                                    if(!empty($content)){
                                        echo wp_kses_post( $content );
                                    }
                                ?>              
                            </div>
    
                            <?php 
                                if(!empty($action_buttons) && count($action_buttons) > 0){
                                    
                                   echo '<div class="rtmega-notice-action-buttons">'; 
                                        foreach ($action_buttons as $key => $button) {
                                            $action_url = isset($button['url']) && !empty($button['url']) ? $button['url'] : '';
                                            $action_title = isset($button['title']) && !empty($button['title']) ? $button['title'] : '';
                                            if(!empty($action_url)){
                                               echo '<a href="'. esc_url($action_url) .'" class="rtmega-notice-button button-small" target="_blank">'. esc_html($action_title) .'</a>';
                                            }
                                            
                                        }
                                   echo '</div>';
                                    
                                }
                            ?>
                            
                        </div>
                        <div style="clear:both"></div>
    
                    </div>
                <?php
                }
            }

        }    

    }


    public function add_notice_to_dashboard_widget() {

        // Add the widget
        wp_add_dashboard_widget(
            'rtmega_notice_widget',          // Widget ID
            'RT Mega Menu Stories',      // Widget title
            array($this, 'rtmega_notice_widget_callback'), // Display callback
        );

        global $wp_meta_boxes;

        // Move the widget to the top
        $my_widget = array('rtmega_notice_widget' => $wp_meta_boxes['dashboard']['normal']['core']['rtmega_notice_widget']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['rtmega_notice_widget']);
        
        // Prepend it to the beginning of the array
        $wp_meta_boxes['dashboard']['normal']['core'] = $my_widget + $wp_meta_boxes['dashboard']['normal']['core'];
        


    }
    
    public function rtmega_notice_widget_callback() {

        $args = [
            'screen' => 'in-widget',
        ];
        
        $all_notice = $this->get_rtmega_notice($args); 
        

        if(!empty($all_notice)){

            $today_date = gmdate('Y-m-d');
            $today_timestamp = strtotime($today_date);
            $all_notice = json_decode($all_notice, true);

            foreach ($all_notice as $key => $notice) {
                $notice_id = isset($notice['notice_id']) ? $notice['notice_id'] : '';
                $thumbnail_url = isset($notice['thumbnail_url']) ? $notice['thumbnail_url'] : '';
                $title = isset($notice['title']) ? $notice['title'] : '';
                $sub_title = isset($notice['sub_title']) ? $notice['sub_title'] : '';
                $content = isset($notice['content']) ? $notice['content'] : '';
                $action_buttons = isset($notice['action_buttons']) ? $notice['action_buttons'] : '';
                $expire_timestamp = isset($notice['expire_date']) ? strtotime($notice['expire_date']): '';
                
           
                $this->expire_notice_by_date($notice_id, $expire_timestamp);
    
                $notice_ignore_status = $this->get_notice_status($notice_id);
                
            
    
                if($notice_ignore_status != 'true' && $today_timestamp <= $expire_timestamp){
                    ?>
                    <div data-notice_id="<?php echo esc_attr( $notice_id )?>" id="rtmega-notice-<?php echo esc_attr( $notice_id )?>" class="rtmega-notice-widget-inner" expired_time="<?php echo esc_attr( $notice_id )?>">
    
                        <?php 
                            if(!empty($thumbnail_url)){ ?>
                                <img class="feature-image" style="" src="<?php echo esc_url($thumbnail_url) ?>">
                            <?php }
                        ?>
                        <div class="notice-contents-wrapper">
                            <div class="notice-contents">
                               
                                <?php 
                                    if(!empty($content)){
                                        echo wp_kses_post( $content );
                                    }
                                ?>              
                            </div>
                            <?php 
                                if(!empty($action_buttons) && count($action_buttons) > 0){
                                    
                                   echo '<div class="rtmega-notice-action-buttons">'; 
                                        foreach ($action_buttons as $key => $button) {
                                            $action_url = isset($button['url']) && !empty($button['url']) ? $button['url'] : '';
                                            $action_title = isset($button['title']) && !empty($button['title']) ? $button['title'] : '';
                                            if(!empty($action_url)){
                                               echo '<a href="'. esc_url($action_url) .'" class="button-secondary button-small" target="_blank">'. esc_html($action_title) .'</a>';
                                            }
                                            
                                        }
                                   echo '</div>';
                                    
                                }
                            ?>
                            
                        </div>
    
                    </div>
                <?php
                }
            }
        }     
        
    }

    public function rtmega_pro_plugin_available_notice(){
        $notice_id = 'rtmega_pro_plugin_notice';
        $notice_ignore_status = $this->get_notice_status($notice_id);

        if($notice_ignore_status != 'true'){
        
            $content = '"Upgrade to RT MEGA MENU PRO and unlock premium features to enhance your website menu with advanced styling options, more icon packs, badges and priority support.';
            $action_buttons = array(
                array(
                    'title' => 'RT Mega Menu Pro',
                    'url'   => 'https://themewant.com/downloads/rt-mega-menu-pro/',
                ),
            );
            
            ?>
            <div data-notice_id="<?php echo esc_attr( $notice_id )?>" id="rtmega-notice-<?php echo esc_attr( $notice_id )?>" class="rtmega-notice notice is-dismissible" expired_time="<?php echo esc_attr( $notice_id )?>" dismissible="global">

            
                <div class="notice-right-container ">
                    <div class="notice-contents">
                        
                        <?php 
                            if(!empty($content)){
                                echo wp_kses_post( $content );
                            }
                        ?>              
                    </div>

                    <?php 
                        if(!empty($action_buttons) && count($action_buttons) > 0){
                            
                            echo '<div class="rtmega-notice-action-buttons">'; 
                                foreach ($action_buttons as $key => $button) {
                                    $action_url = isset($button['url']) && !empty($button['url']) ? $button['url'] : '';
                                    $action_title = isset($button['title']) && !empty($button['title']) ? $button['title'] : '';
                                    if(!empty($action_url)){
                                        echo '<a href="'. esc_url($action_url) .'" class="rtmega-notice-button button-small" target="_blank">'. esc_html($action_title) .'</a>';
                                    }
                                    
                                }
                            echo '</div>';
                            
                        }
                    ?>
                    
                </div>
                <div style="clear:both"></div>

            </div>
        <?php
        }
    }

    public static function rtmega_after_plugin_activation() {
        $user_id = get_current_user_id();
        
        if ($user_id && !get_user_meta($user_id, 'rtmega_notice_ignore_rtmega_pro_plugin_notice', true)) {
            add_user_meta($user_id, 'rtmega_notice_ignore_rtmega_pro_plugin_notice', 'false', true);
        }else{
            update_user_meta( $user_id, 'rtmega_notice_ignore_rtmega_pro_plugin_notice', 'false' );
        }
    }


}

// Instantiate the class to ensure the menu is registered
if ( class_exists( 'rtmega_NOTICE' ) ) {
    $rtmega_NOTICE = new rtmega_NOTICE();
}