
<?php
/**
 * Admin template-list view. Variables here are template-scope locals, not globals.
 * The 'check_rt_mega_license_status' filter has a project prefix ('rt_mega_') and
 * is part of the free↔pro contract; renaming it would break backward compatibility.
 */
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 ?>
<div class="rtmega-templates-library">
    <div class="section-header">
        <h1><?php esc_html_e( 'Templates Library', 'rt-mega-menu' ); ?></h1>
    </div>
    <div class="rtmega-templates-row">
        <?php

        $license_status = '';
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- rt_mega_ prefix; part of free↔pro API contract.
        $license_status = apply_filters( 'check_rt_mega_license_status', $license_status );
        $templates = RTMEGA_MENU_Template_Library::instance()->get_rtmega_templates();    
        
        
        if(!empty($templates)){
            $templates = json_decode($templates, true);
        }   
        if(is_array($templates)){

            foreach ($templates as $template) {
                $thumbnail_url = RTMEGA_MENU_PL_URL.'admin/assets/img/thumbnail-placeholder.jpg';
                $title =  $template['title'];
                $template_id = $template['template_id'];
                $is_premium = $template['is_premium'];

                if(isset($template['thumbnail_url']) && !empty($template['thumbnail_url'])) {
                    $thumbnail_url = $template['thumbnail_url'];
                }
                ?>
                    <div class="rtmega-templates-item">
                        
                        <?php 
                            if($is_premium){
                                echo '<span class="template-badege badge-premium"> ' . esc_html__( 'Premium', 'rt-mega-menu' ) . ' </span>';
                            }else{
                                echo '<span class="template-badege badge-free"> ' . esc_html__( 'Free', 'rt-mega-menu' ) . ' </span>';
                            }
                        ?>
                        
                        <div class="rtmega-template-thumbnail-wrapper">
                            <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="" class="rtmega-template-thumbnail thumbnail-1">
                        </div>
                         <div class="rt-mega-template-actions">
                                <h4 class="template-title"><?php echo esc_html($title); ?></h4>
                                <div class="buttons">
                                    <a href="#" class="button preview_btn" data-thumb_url="<?php echo esc_attr($thumbnail_url);?>" title="<?php echo esc_attr($title); ?>"><?php esc_html_e( 'Preview', 'rt-mega-menu' ); ?></a>
                                    <a href="#rtmega-template-imoporter-form" data-license="<?php echo esc_attr($license_status); ?>" data-is_premium="<?php echo esc_attr( $is_premium ); ?>" class="button import_btn popup-with-form" data-template_id="<?php echo esc_attr($template_id);?>"><?php esc_html_e( 'Import', 'rt-mega-menu' ); ?></a>
                                </div>
                         </div>
                     </div>
                 <?php
            }
        }       
        ?>
    </div>     
    <div id="rtmega-menu-setting-modal" style="display: none;">
        <div class="rtmega-menu-overlay"></div>
        <div class="rtmega-modal-body">
            <button type="button" class="rtmega-menu-modal-closer"><span class="dashicons dashicons-no"></span></button>
            <div class="rtmega-modal-content">

                <div id="template-previewer">
                    <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/thumbnail-placeholder.jpg'); ?>" alt="thumbnail">
                </div>

                <form id="rtmega-template-imoporter-form" class="rtmega-template-imoporter-form">
                    <div class="ajax-loader">
                        <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/ajax-loader.gif'); ?>" alt="Ajax Loader">
                    </div>
                
                    <div class="importer-status success-status">
                        <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/success.gif'); ?>" alt="Ajax Loader">
                        <h2 class="rtmega-text-success"><?php esc_html_e( 'Successfully imported the template!', 'rt-mega-menu' ); ?></h2>
                    </div>

                    <div class="premium-notice">
                        <img src="<?php echo esc_url(RTMEGA_MENU_PL_URL.'admin/assets/img/premium.png'); ?>" alt="Premium Icon">
                        <h2 class="rtmega-text-success"><?php esc_html_e( 'Please acivate RTMega Premium License to import this template!', 'rt-mega-menu' ); ?></h2>
                        <h3><a href="<?php echo esc_url(RTMEGA_PRO_SITE_URL); ?>" target="_blank"><?php esc_html_e( 'Buy premium license', 'rt-mega-menu' ); ?></a></h3>
                    </div>
                    
                    <div class="form-groups">
                        <div class="form-group">
                            <h2><?php esc_html_e( 'Import to template library', 'rt-mega-menu' ); ?></h2>
                            <input type="hidden" name="template-id" placeholder="<?php esc_attr_e( 'Enter your page name', 'rt-mega-menu' ); ?>">
                            <a href="#" class="button button-primary import_template_btn"><?php esc_html_e( 'Import', 'rt-mega-menu' ); ?></a>
                        </div>
                        <hr>
                        <div class="form-group">
                            <h2><?php esc_html_e( 'Import to a page', 'rt-mega-menu' ); ?></h2>
                            <div>
                                <input type="text" name="page-title" placeholder="<?php esc_attr_e( 'Enter your page name', 'rt-mega-menu' ); ?>">
                                <a href="#" class="button button-primary import_template_btn"><?php esc_html_e( 'Import', 'rt-mega-menu' ); ?></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>