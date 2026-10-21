<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
if ( !class_exists('RTMEGA_MENU_Admin_Ajax')) {
    class RTMEGA_MENU_Admin_Ajax {

        function __construct(){

            add_action( "wp_ajax_rtmega_update_menu_options", array ( $this, 'rtmega_update_menu_options' ) );
            add_action( "wp_ajax_rtmega_get_menu_options", array ( $this, 'rtmega_get_menu_options' ) );
            add_action( "wp_ajax_rtmega_set_menu_item_mega_button", array ( $this, 'rtmega_set_menu_item_mega_button' ) );
            add_action( "wp_ajax_rtmega_delete_menu_options", array ( $this, 'rtmega_delete_menu_options' ) );
            add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'rtmega_menu_item_pro_fields' ), 10, 2 );
            add_action( "wp_ajax_rtmega_get_templates_data_by_source", array ( $this, 'rtmega_get_templates_data_by_source' ) );
            add_action( "wp_ajax_rtmega_create_new_template", array ( $this, 'rtmega_create_new_template' ) );
        }

        function rtmega_menu_item_pro_fields( $item_id, $item ) {
                ?>  
                    <div class="rtmega-pro-nav-fields">
                        <hr>
                            <div class="rtmega_saved_icon_wrapper_free" style="clear: both;">
                            <div class="rtmega_saved_icon"><i class=""></i></div>
                            <div class="rtmega_saved_icon_actions">
                                <button type="button" class="rtmega_set_icon_toggle_in_nav_item_free" data-menu_item_id="<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Add Icon', 'rt-mega-menu' ); ?></button>
                            </div>
                        </div>
                        <button type="button" class="button rtmega-set-visibility-conditions rtmega-set-visibility-conditions-free"><?php echo esc_html__( 'Visibility Conditions', 'rt-mega-menu' )?></button>
                        <hr>
                    </div>
                    
                <?php
        }

        public function rtmega_update_menu_options() {

            check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to manage menu options.', 'rt-mega-menu' ) ) );
            }

            if (!isset($_POST['settings'], $_POST['actualAction'])) {
                wp_send_json_error(['message' => esc_html__('Invalid request.', 'rt-mega-menu')]);
                wp_die();
            }
        
            $actual_action = sanitize_text_field(wp_unslash($_POST['actualAction']));
            
            if ($actual_action === 'saveMenuOptions' && isset($_POST['menu_id'])) {
                $menu_id = absint($_POST['menu_id']); // No need to sanitize twice
                $menu = wp_get_nav_menu_object($menu_id);

                if ($menu) {

                    $menu_slug = $menu->slug;
                    $settings = isset($_POST['settings']) ? array_map('sanitize_text_field', (array)wp_unslash($_POST['settings'])) : [];
                    update_option("rtmega_menu_settings_$menu_slug", $settings);
                }
        
            } else {
                if (!isset($_POST['menu_item_id'])) {
                    wp_send_json_error(['message' => esc_html__('Menu item ID is missing.', 'rt-mega-menu')]);
                    wp_die();
                }
        
                $menu_item_id = absint( wp_unslash( $_POST['menu_item_id'] ) );
                if ( ! $menu_item_id || 'nav_menu_item' !== get_post_type( $menu_item_id ) ) {
                    wp_send_json_error( array( 'message' => esc_html__( 'Invalid menu item.', 'rt-mega-menu' ) ) );
                }
                
                $settings   = !empty($_POST['settings'])   ? array_map('sanitize_text_field', (array) wp_unslash($_POST['settings']))   : [];
                $css        = !empty($_POST['css'])        ? array_map('sanitize_text_field', (array) wp_unslash($_POST['css']))        : [];
              
                foreach ( array( 'left', 'right', 'top', 'width' ) as $rtmega_css_key ) {
                    if ( isset( $css[ $rtmega_css_key ] ) ) {
                        $css[ $rtmega_css_key ] = $this->rtmega_validate_css_value( $css[ $rtmega_css_key ] );
                    }
                }
                
                $conditions = !empty($_POST['conditions']) ? array_map('sanitize_text_field', (array) wp_unslash($_POST['conditions'])) : [];

                update_post_meta($menu_item_id, 'rtmega_menu_settings', ['switch' => 'on', 'content' => $settings, 'css' => $css, 'conditions' => $conditions]);
            }
        
            wp_send_json_success([
                'message' => esc_html__('Successfully saved data.', 'rt-mega-menu'), 
                'settings' => $settings, 
                'actual_action' => $actual_action
            ]);
            
            wp_die();
        }
        

        /**
         * Validate a CSS length/position value before it is stored.
         *
         * Accepts a single numeric value with an optional CSS unit (e.g. 100px,
         * 50%, -20px, 1.5rem, 0), a small set of safe keywords, or a simple
         * calc() expression. Anything else is discarded (returns '').
         *
         * @param mixed $value Raw value.
         * @return string Safe value or empty string.
         */
        private function rtmega_validate_css_value( $value ) {
            $value = trim( (string) $value );

            if ( '' === $value ) {
                return '';
            }

            $keywords = array( 'auto', 'inherit', 'initial', 'unset', 'revert', 'none', 'fit-content', 'max-content', 'min-content' );
            if ( in_array( strtolower( $value ), $keywords, true ) ) {
                return strtolower( $value );
            }

            // Single number with an optional CSS unit, e.g. 100px, 50%, -20px, 1.5rem, 0.
            if ( preg_match( '/^-?(?:\d+(?:\.\d+)?|\.\d+)(?:px|%|em|rem|vw|vh|vmin|vmax|ex|ch|cm|mm|in|pt|pc|q|fr)?$/i', $value ) ) {
                return $value;
            }

            // Simple calc() expression containing only safe characters.
            if ( preg_match( '/^calc\(\s*[0-9a-z.%+\-*\/\s()]+\)$/i', $value ) ) {
                return $value;
            }

            return '';
        }

        public function rtmega_set_menu_item_mega_button() {

            check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to manage menu options.', 'rt-mega-menu' ) ) );
            }

            if(isset($_POST['menu_item_id'])){

                $menu_item_id = absint( wp_unslash( $_POST['menu_item_id'] ) );
                if ( ! $menu_item_id || 'nav_menu_item' !== get_post_type( $menu_item_id ) ) {
                    wp_send_json_error( array( 'message' => esc_html__( 'Invalid menu item.', 'rt-mega-menu' ) ) );
                }
                $rtmega_menu_item_settings = get_post_meta( $menu_item_id, 'rtmega_menu_settings', true );

                wp_send_json_success( $rtmega_menu_item_settings ) ;

            }
            wp_die();
        }

        public function rtmega_delete_menu_options() {

            check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to manage menu options.', 'rt-mega-menu' ) ) );
            }

            if(isset($_POST['menu_item_id'])){

                $menu_item_id = absint( wp_unslash( $_POST['menu_item_id'] ) );
                if ( ! $menu_item_id || 'nav_menu_item' !== get_post_type( $menu_item_id ) ) {
                    wp_send_json_error( array( 'message' => esc_html__( 'Invalid menu item.', 'rt-mega-menu' ) ) );
                }
                $rtmega_menu_item_settings = get_post_meta( $menu_item_id, 'rtmega_menu_settings', true );

                if(isset($rtmega_menu_item_settings)){
                    delete_post_meta( $menu_item_id, 'rtmega_menu_settings' );
                    wp_send_json_success( $rtmega_menu_item_settings, 200 );
                }else{
                    wp_send_json_success( $rtmega_menu_item_settings, 404 );
                }
            }
            wp_die();

        }

        public function rtmega_get_menu_options() {

            check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to manage menu options.', 'rt-mega-menu' ) ) );
            }

            if(isset($_POST['menu_item_id'])){
                $menu_item_id = absint( wp_unslash( $_POST['menu_item_id'] ) );

                if ( ! $menu_item_id || 'nav_menu_item' !== get_post_type( $menu_item_id ) ) {
                    wp_send_json_error( array( 'message' => esc_html__( 'Invalid menu item.', 'rt-mega-menu' ) ) );
                }
                
                $active_tab_id = isset($_POST['active_tab']) ? sanitize_text_field(wp_unslash($_POST['active_tab'])) : '';
                $rtmega_menu_item_settings = get_post_meta($menu_item_id, 'rtmega_menu_settings', true);

                $css = ( is_array( $rtmega_menu_item_settings ) && ! empty( $rtmega_menu_item_settings['css'] ) && is_array( $rtmega_menu_item_settings['css'] ) )
                    ? $rtmega_menu_item_settings['css']
                    : array();

                $rtmega_menupos_left  = $css['left']  ?? '';
                $rtmega_menupos_right = $css['right'] ?? '';
                $rtmega_menupos_top   = $css['top']   ?? '';
                $rtmega_menuwidth     = $css['width'] ?? '';


                $content_tempalte = '';
                $template_source = 'elementor';
                if(isset($rtmega_menu_item_settings['content']['rtmega_template'])){
                    $content_tempalte = absint( $rtmega_menu_item_settings['content']['rtmega_template'] );
                }
                if(isset($rtmega_menu_item_settings['content']['template_source']) && in_array($rtmega_menu_item_settings['content']['template_source'], array('elementor', 'gutenberg'), true)){
                    $template_source = $rtmega_menu_item_settings['content']['template_source'];
                }

                ?>
                    <div id="tabs-content">
                        <div id="tab1" class="tab-content" style="display: <?php echo esc_attr( $active_tab_id == '1' ? 'block' : 'none'); ?>">
                            <h2><?php echo esc_html__( 'Select a template', 'rt-mega-menu' )?></h2>
                            <!-- elementor_library -->
                            <?php
                                $activeKitId = get_option( 'elementor_active_kit' );
                                $activeKitId = intval($activeKitId);

                                $elementor_library_query_args = array(
                                    'post_type' => $template_source == 'elementor' ? 'elementor_library' : 'rtmega_menu',
                                    'posts_per_page' => -1,
                                    'orderby' => 'id',
                                    'order' => 'DESC',
                                    // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in -- Excluding the Elementor active kit (single ID) from template lists; negligible perf cost.
                                    'post__not_in' => array($activeKitId)
                                );

                                $elementor_library_query = new WP_Query($elementor_library_query_args);
                            ?>
                            <form action="" onsubmit="return false" id='rtmega_menu_items_settings'>    
                                <div class="rtmega-menu-option-inputs">
                                    <ul class="rtmega-menu-option-input-list"> 
                                        <li>
                                            <select name="template_source" id="rtmega-template-source-select">
                                                <option value="" <?php selected( $template_source, '' ); ?>>
                                                    <?php echo esc_html__('Select a template source', 'rt-mega-menu'); ?>
                                                </option>
                                                <option value="elementor" <?php selected($template_source, 'elementor'); ?>>
                                                    <?php echo esc_html__('Elementor', 'rt-mega-menu'); ?>
                                                </option>
                                                <option value="gutenberg" <?php selected($template_source, 'gutenberg'); ?>>
                                                    <?php echo esc_html__('Gutenberg', 'rt-mega-menu'); ?>
                                                </option>
                                            </select>
                                            <?php 
                                                if($elementor_library_query->have_posts()){
                                                    $is_template_exist = $elementor_library_query->have_posts();
                                                    ?>
                                                    <select name="rtmega_template" id="rtmega-template-select" style="<?php echo esc_attr($is_template_exist ? '' : 'display: none;'); ?>">
                                                        <option value=""><?php echo esc_html__('Select Template', 'rt-mega-menu'); ?></option>
                                                        <?php 
                                                            
                                                            while ($elementor_library_query->have_posts()) {
                                                                $elementor_library_query->the_post();
                                                                $current_id = get_the_ID();


                                                                ?>
                                                                    <option value="<?php echo esc_attr( get_the_ID() );?>" <?php echo esc_attr($content_tempalte == get_the_ID() ? 'selected' : ''); ?> ><?php the_title(); ?></option>
                                                                <?php
                                                                
                                                            }
                                                            wp_reset_postdata();
                                                        ?>
                                                    </select>
                                                    <?php
                                                }
                                              
                                                
                                            ?>
                                            <strong class="rtmega-text-danger rtmega-template-not-found-message" style="<?php echo esc_attr($elementor_library_query->have_posts() ? 'display: none;' : ''); ?>">
                                                <?php echo esc_html__('Ops! Templates not found.', 'rt-mega-menu') ?> <a href="<?php echo esc_url(admin_url('edit.php?post_type=elementor_library&tabs_group=library')); ?>" title="<?php esc_attr_e( 'Click here to create a template.', 'rt-mega-menu' ); ?>" id="rtmega-create-new-template"><?php echo esc_html__('Create', 'rt-mega-menu'); ?></a> <?php echo esc_html__('a new template.', 'rt-mega-menu'); ?></strong>
                                            <?php
                                            
                                            $edit_link = $template_source == 'elementor' ? admin_url('post.php?post='. esc_attr( $content_tempalte ) .'&action=elementor') : admin_url('post.php?post='. esc_attr( $content_tempalte ) .'&action=edit');
                                            ?>
                                            <a href="<?php echo esc_url( $edit_link ); ?>" id="edit-remega-selected-template" class="button" target="_blank" style="<?php echo empty($content_tempalte) ? 'display: none;' : ''; ?>"><?php echo esc_html__( 'Edit Template', 'rt-mega-menu' ); ?></a>
                                            <a href="<?php echo esc_url( admin_url('post.php?post='. esc_attr( $content_tempalte ) .'&action=edit' ) ) ?>" id="add-remega-template" class="button" target="_blank" style="<?php echo esc_attr( $elementor_library_query->have_posts() ? '' : 'display: none;'); ?>"><?php echo esc_html__('Add New', 'rt-mega-menu'); ?></a>
                                           
                                        </li>
                                        <li class="pro-features-placeholders">
                                            <div class="option-label"><?php echo esc_html__('Badge', 'rt-mega-menu'); ?> : </div>
                                            <div class="option-inputs">
                                                <img src="<?php echo esc_url( RTMEGA_MENU_PL_URL.'admin/assets/img/badge_pro_condition.png'); ?>" class="rtmega_pro_warning_img" alt="badge_pro_condition">
                                                <p class="rtmega-pro-notice rtmega-text-danger"><?php echo esc_html__('Please activate plugin license to use this advanced features', 'rt-mega-menu'); ?></p>
                                            </div>
                                        </li>
                                        <li class="pro-features-placeholders">   
                                            <div class="option-label"><?php echo esc_html__('Icon', 'rt-mega-menu'); ?> : </div>
                                            <div class="option-inputs">
                                                <img src="<?php echo esc_url( RTMEGA_MENU_PL_URL.'admin/assets/img/icon_pro_condition.png'); ?>" class="rtmega_pro_warning_img" alt="icon_pro_condition">
                                                <p class="rtmega-pro-notice rtmega-text-danger"><?php echo esc_html__('Please activate plugin license to use this advanced features', 'rt-mega-menu'); ?></p>
                                            </div>
                                        </li>
                                        <?php
                                        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- rt_mega_menu suffix; intentional extensibility hook consumed by rt-mega-menu-pro.
                                        do_action( 'after_content_options_rt_mega_menu' );
                                        ?>
                                    </ul>
                                </div>
                            </form>
                            
                        </div>
                        <!-- settings and conditions -->
                        <div id="tab2" class="tab-content" style="display: <?php echo esc_attr($active_tab_id == '2' ? 'block' : 'none'); ?>;">
                            <form action="" onsubmit="return false" id='rtmega_menu_items_css'>          
                                <div class="rtmega-menu-option-inputs">
                                    <ul class="rtmega-menu-option-input-list">
                                        <li>
                                            <div class="option-label"><?php echo esc_html__('Position', 'rt-mega-menu'); ?> : </div>
                                            <div class="option-inputs">
                                                <label>
                                                    <strong><?php echo esc_html__('Left', 'rt-mega-menu'); ?> <?php echo esc_html__('(ex: 100px or 100%)', 'rt-mega-menu'); ?></strong>
                                                    <input type="text" name="left" value="<?php echo esc_attr($rtmega_menupos_left); ?>">
                                                </label>
                                                <label>
                                                    <strong><?php echo esc_html__('Right', 'rt-mega-menu'); ?> <?php echo esc_html__('(ex: 100px or 100%)', 'rt-mega-menu'); ?></strong>
                                                    <input type="text" name="right" value="<?php echo esc_attr($rtmega_menupos_right); ?>">
                                                </label>
                                                <label>
                                                    <strong><?php echo esc_html__('Top', 'rt-mega-menu'); ?> <?php echo esc_html__('(ex: 100px or 100%)', 'rt-mega-menu'); ?></strong>
                                                    <input type="text" name="top" value="<?php echo esc_attr( $rtmega_menupos_top ); ?>">
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="option-label"><?php echo esc_html__('Mega Menu Size', 'rt-mega-menu'); ?> : </div>
                                            <div class="option-inputs">
                                                <label>
                                                    <strong><?php echo esc_html__('Width', 'rt-mega-menu'); ?> <?php echo esc_html__('(ex: 100px or 100%)', 'rt-mega-menu'); ?></strong>
                                                    <input type="text" name="width" value="<?php echo esc_attr($rtmega_menuwidth); ?>">
                                                </label>
                                            </div>
                                        </li>
                                        <?php
                                        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- rt_mega_menu suffix; intentional extensibility hook consumed by rt-mega-menu-pro.
                                        do_action( 'after_style_options_rt_mega_menu' );
                                        ?>
                                    </ul>
                                </div>
                            </form>
                        </div>
                        <div id="tab3" class="tab-content visibility-conditions-tab" style="display: <?php echo esc_attr($active_tab_id == '3' ? 'block' : 'none'); ?>;">
                            <form action="" onsubmit="return false" id='rtmega_menu_items_conditions'>
                                <div class="rtmega-menu-option-inputs">
                                    <ul class="rtmega-menu-option-input-list rtmega-menu-option-input-list rtmega-conditions-list"> 
                                        <li class="pro-features-placeholders d-block">
                                            <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/visibility_conditions_pro.png'); ?>" class="rtmega_pro_warning_img" alt="badge_pro_condition">
                                            <p class="rtmega-pro-notice rtmega-text-danger"><?php echo esc_html__('Please activate plugin license to use this advanced features', 'rt-mega-menu'); ?></p>
                                        </li>
                                        <?php do_action( 'rtmega_menu_item_visibility_conditions_content', $menu_item_id );?>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div> <!-- END tabs-content -->
                <?php

            } else {
                wp_send_json_error( array( 'message' => esc_html__( 'Menu item ID is missing.', 'rt-mega-menu' ) ) );
            }

            wp_die();
        }

        public function rtmega_get_templates_data_by_source() {
            
            check_ajax_referer('rtmega_templates_import_nonce', 'nonce');

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to manage menu options.', 'rt-mega-menu' ) ) );
            }

            if(isset($_POST['template_source'])){

                $template_source = sanitize_text_field(wp_unslash($_POST['template_source']));
                $post_type = $template_source == 'elementor' ? 'elementor_library' : 'rtmega_menu';
                $template_data = array();
                $menu_item_id = isset($_POST['menu_item_id']) ? sanitize_text_field(wp_unslash($_POST['menu_item_id'])) : '';
                $rtmega_menu_item_settings = $menu_item_id ? get_post_meta($menu_item_id, 'rtmega_menu_settings', true) : [];
                $current_template_id = isset($rtmega_menu_item_settings['content']['rtmega_template']) ? $rtmega_menu_item_settings['content']['rtmega_template'] : '';
                $add_new_link = $template_source == 'elementor' ? admin_url('post.php?post=-1&action=elementor') : admin_url('post-new.php?post_type='. $post_type);
                $activeKitId = get_option( 'elementor_active_kit' );
                $activeKitId = intval($activeKitId);
                $args = array(
                    'post_type' => $post_type,
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in -- Excluding the Elementor active kit (single ID) from template lists; negligible perf cost.
                    'post__not_in' => array($activeKitId)
                );
                $elementor_library_query = new WP_Query($args);
                if($elementor_library_query->have_posts()){
                    while($elementor_library_query->have_posts()){
                        $elementor_library_query->the_post();
                        $template_id = get_the_ID();
                        $template_title = get_the_title();
                        $edit_link = $template_source == 'elementor' ? admin_url('post.php?post='. $template_id .'&action=elementor') : admin_url('post.php?post='. $template_id .'&action=edit');
                        $template_data[] = array(
                            'id' => $template_id,
                            'title' => $template_title,
                            'edit_link' => $edit_link,
                        );
                    }
                    $template_data['current_template_id'] = $current_template_id;
                    wp_send_json_success($template_data);   
                }else{
                    $template_data['add_new_link'] = $add_new_link;
                    wp_send_json_error($template_data);
                }
                
            }
            wp_die();
        }

        public function rtmega_create_new_template() {
            check_ajax_referer( 'rtmega_templates_import_nonce', 'nonce' );
            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to create a template.', 'rt-mega-menu' ) ) );
            }

            $template_source = isset($_POST['template_source']) ? sanitize_text_field(wp_unslash($_POST['template_source'])) : '';
            if ( ! in_array( $template_source, array( 'elementor', 'gutenberg' ), true ) ) {
                $template_source = 'gutenberg';
            }

            $menu_item_id = isset($_POST['menu_item_id']) ? absint( wp_unslash($_POST['menu_item_id']) ) : 0;
            if ( ! $menu_item_id || 'nav_menu_item' !== get_post_type( $menu_item_id ) ) {
                wp_send_json_error( array( 'message' => esc_html__( 'Invalid menu item.', 'rt-mega-menu' ) ) );
            }

            $rtmega_menu_item_settings = get_post_meta($menu_item_id, 'rtmega_menu_settings', true);
            $post_type = $template_source == 'elementor' ? 'elementor_library' : 'rtmega_menu';
            $template_data = array();

            if($menu_item_id){
                $template_id = wp_insert_post(array(
                    'post_title'    => 'Mega Menu Template - '  . wp_rand(1000, 9999),
                    'post_status'   => 'publish',
                    'post_type' => $post_type,
                ));
                if(!is_wp_error($template_id)){

                    if(empty($template_id)){
                        wp_die('No template found');
                    }

                    // update menu item settings
                    if(!is_array($rtmega_menu_item_settings)){
                        $rtmega_menu_item_settings = array();
                    }
                    if(!isset($rtmega_menu_item_settings['content'])){
                        $rtmega_menu_item_settings['content'] = array();
                    }

                    $rtmega_menu_item_settings['content']['rtmega_template'] = $template_id;
                    $rtmega_menu_item_settings['content']['template_source'] = $template_source;
                    update_post_meta($menu_item_id, 'rtmega_menu_settings', $rtmega_menu_item_settings);


                    if($template_source == 'elementor'){
                        // Set Elementor template type to "container"
                        update_post_meta(
                            $template_id,
                            'elementor_library_type',
                            'container'
                        );

                        // (Optional: some Elementor installs use this)
                        update_post_meta(
                            $template_id,
                            '_elementor_template_type',
                            'container'
                        );

                        $edit_link = admin_url('post.php?post='. $template_id .'&action=elementor');
                    }else{
                        $edit_link = admin_url('post.php?post='. $template_id .'&action=edit');
                    }

                    $template_data = [
                        'id' => $template_id,
                        'title' => get_the_title($template_id),
                        'edit_link' => $edit_link,
                    ];
                    
                    wp_send_json_success($template_data);
                    wp_die();
                }
            }
        }
    }

    $RTMEGA_MENU_Admin_Ajax = new RTMEGA_MENU_Admin_Ajax();
}