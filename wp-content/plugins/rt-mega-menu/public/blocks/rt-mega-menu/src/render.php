<?php
/**
 * Render callback for the RT Mega Menu block.
 *
 * All $-variables in this file are local to the render callback scope (not globals),
 * so the non-prefixed-variable sniff is disabled for the whole file.
 */

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Generate unique ID for this block instance
$unique_id = 'rtmega-' . wp_rand( 100, 99999 );
$selector  = '.' . $unique_id;

$menu_slug = isset($attributes['menu_slug']) ? $attributes['menu_slug'] : '';
if ( empty( $menu_slug ) ) {
    return;
}

$menu = wp_get_nav_menu_object( $menu_slug );
if ( ! $menu ) {
    return;
}

$menu_layout = isset($attributes['menu_layout']) ? sanitize_html_class($attributes['menu_layout']) : 'horizontal';
if ( ! in_array( $menu_layout, array( 'horizontal', 'vertical' ), true ) ) {
    $menu_layout = 'horizontal';
}
$submenu_icon_style = isset($attributes['submenu_icon_style']) ? $attributes['submenu_icon_style'] : 'icon1';
$vertical_active_menu_style = isset($attributes['vertical_active_menu_style']) ? $attributes['vertical_active_menu_style'] : 'icon1';
$pointer_menu_item = isset($attributes['pointer_menu_item']) ? $attributes['pointer_menu_item'] : 'none';
$enableMobileMenu = isset($attributes['enableMobileMenu']) ? $attributes['enableMobileMenu'] : false;
$mobileMenuSlug = isset($attributes['mobileMenuSlug']) ? $attributes['mobileMenuSlug'] : '';
$mobileMenuOpenPosition = isset($attributes['mobileMenuOpenPosition']) ? $attributes['mobileMenuOpenPosition'] : 'right';

$mobileMenuOpenPositionClass = 'position-right';
if($mobileMenuOpenPosition == 'left'){
    $mobileMenuOpenPositionClass = 'position-left';
}elseif($mobileMenuOpenPosition == 'right'){
    $mobileMenuOpenPositionClass = 'position-right';
}elseif($mobileMenuOpenPosition == 'top'){
    $mobileMenuOpenPositionClass = 'position-top';
}



// --- Style handling ---

// 1. Menu Style (Wrapper)
$wrapper_styles = ['desktop' => [], 'tablet' => [], 'mobile' => []];
if (!empty($attributes['wrapperBgGradient'])) {
    $wrapper_styles['desktop']['background'] = $attributes['wrapperBgGradient'];
} elseif (!empty($attributes['wrapperBgColor'])) {
    $wrapper_styles['desktop']['background-color'] = $attributes['wrapperBgColor'];
}

RTMEGA_Helper::add_responsive_vars($attributes, $wrapper_styles, 'wrapperPadding', '', [
  'top'    => 'padding-top',
  'right'  => 'padding-right',
  'bottom' => 'padding-bottom',
  'left'   => 'padding-left'
], true);

RTMEGA_Helper::add_responsive_vars($attributes, $wrapper_styles, 'wrapperMargin', '', [
  'top'    => 'margin-top',
  'right'  => 'margin-right',
  'bottom' => 'margin-bottom',
  'left'   => 'margin-left'
], true);


$menu_styles = ['desktop' => [], 'tablet' => [], 'mobile' => []];
RTMEGA_Helper::add_responsive_vars($attributes, $menu_styles, 'menuSpaceBetween', 'gap', [], false);

// 2. Alignment (applied to .desktop-menu-area)
$align_styles = ['desktop' => [], 'tablet' => [], 'mobile' => []];
RTMEGA_Helper::add_responsive_vars($attributes, $align_styles, 'menuAlign', 'text-align', [], false);

// 3. Menu Item Styles
$item_styles = ['desktop' => [], 'tablet' => [], 'mobile' => []];
if (!empty($attributes['menuItemColor'])) $item_styles['desktop']['color'] = $attributes['menuItemColor'];
if (!empty($attributes['menuItemBgGradient'])) {
    $item_styles['desktop']['background'] = $attributes['menuItemBgGradient'];
} elseif (!empty($attributes['menuItemBgColor'])) {
    $item_styles['desktop']['background-color'] = $attributes['menuItemBgColor'];
}

// Typography Responsively
RTMEGA_Helper::add_responsive_vars($attributes, $item_styles, 'menuTypography', '', [
    'fontSize'      => 'font-size',
    'fontWeight'    => 'font-weight',
    'lineHeight'    => 'line-height',
    'textTransform' => 'text-transform',
    'letterSpacing' => 'letter-spacing'
], true);

RTMEGA_Helper::add_responsive_vars($attributes, $item_styles, 'menuPadding', '', [
  'top'    => 'padding-top',
  'right'  => 'padding-right',
  'bottom' => 'padding-bottom',
  'left'   => 'padding-left'
], true);

RTMEGA_Helper::add_responsive_vars($attributes, $item_styles, 'menuMargin', '', [
  'top'    => 'margin-top',
  'right'  => 'margin-right',
  'bottom' => 'margin-bottom',
  'left'   => 'margin-left'
], true);

// Hover Item
$item_hover_styles = [];
if (!empty($attributes['menuItemHoverColor'])) $item_hover_styles['color'] = $attributes['menuItemHoverColor'];
if (!empty($attributes['menuItemHoverBgGradient'])) {
    $item_hover_styles['background'] = $attributes['menuItemHoverBgGradient'];
} elseif (!empty($attributes['menuItemHoverBgColor'])) {
    $item_hover_styles['background-color'] = $attributes['menuItemHoverBgColor'];
}

// 4. Sub Menu Styles
$submenu_styles = ['desktop' => [], 'tablet' => [], 'mobile' => []];
if (!empty($attributes['submenuBgGradient'])) {
    $submenu_styles['desktop']['background'] = $attributes['submenuBgGradient'];
} elseif (!empty($attributes['submenuBgColor'])) {
    $submenu_styles['desktop']['background-color'] = $attributes['submenuBgColor'];
}
if (!empty($attributes['boxShadow'])) $submenu_styles['desktop']['box-shadow'] = $attributes['boxShadow'];

// 5. Sub Menu Item Styles
// Initialize as responsive to support generated CSS
$submenu_item_styles = ['desktop' => [], 'tablet' => [], 'mobile' => []];

if (!empty($attributes['submenuItemColor'])) $submenu_item_styles['desktop']['color'] = $attributes['submenuItemColor'];
if (!empty($attributes['submenuItemBgColor'])) $submenu_item_styles['desktop']['background-color'] = $attributes['submenuItemBgColor'];

$submenu_item_hover_styles = [];
if (!empty($attributes['submenuItemHoverColor'])) $submenu_item_hover_styles['color'] = $attributes['submenuItemHoverColor'];
if (!empty($attributes['submenuItemHoverBgColor'])) $submenu_item_hover_styles['background-color'] = $attributes['submenuItemHoverBgColor'];

// Typography for Submenu Item - move to responsive structure
if (!empty($attributes['submenuTypography'])) {
    $typo = $attributes['submenuTypography'];
    if (!empty($typo['fontSize'])) $submenu_item_styles['desktop']['font-size'] = RTMEGA_Helper::ensure_unit($typo['fontSize']);
    if (!empty($typo['fontWeight']) && $typo['fontWeight'] !== 'inherit') $submenu_item_styles['desktop']['font-weight'] = $typo['fontWeight'];
    if (!empty($typo['lineHeight'])) $submenu_item_styles['desktop']['line-height'] = $typo['lineHeight'];
    if (!empty($typo['textTransform']) && $typo['textTransform'] !== 'none') $submenu_item_styles['desktop']['text-transform'] = $typo['textTransform'];
    if (!empty($typo['letterSpacing'])) $submenu_item_styles['desktop']['letter-spacing'] = RTMEGA_Helper::ensure_unit($typo['letterSpacing']);
}

RTMEGA_Helper::add_responsive_vars($attributes, $submenu_item_styles, 'submenuItemPadding', '', [
    'top'    => 'padding-top',
    'right'  => 'padding-right',
    'bottom' => 'padding-bottom',
    'left'   => 'padding-left'
], true);

RTMEGA_Helper::add_responsive_vars($attributes, $submenu_item_styles, 'subMenuSpaceBetween', 'margin-bottom', [], false);

// Generate CSS
$css = "";
$css .= RTMEGA_Helper::generate_responsive_css($selector . '.rtmega-block-wrap', $wrapper_styles);
$css .= RTMEGA_Helper::generate_responsive_css($selector . ' .desktop-menu-area', $align_styles);
$css .= RTMEGA_Helper::generate_responsive_css($selector . ' .desktop-menu-area .desktop-menu', $menu_styles);
$css .= RTMEGA_Helper::generate_responsive_css($selector . ' .rtmega-menu-area ul.rtmega-megamenu > .menu-item > .menu-link', $item_styles);
$css .= RTMEGA_Helper::generate_responsive_css($selector . ' .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu', $submenu_styles);
$css .= RTMEGA_Helper::generate_responsive_css($selector . ' .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu > .menu-item > .menu-link', $submenu_item_styles);

$sub_styles = [
    '.rtmega-menu-area ul.rtmega-megamenu > .menu-item:hover .menu-link' => RTMEGA_Helper::get_inline_styles($item_hover_styles),
    '.rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu > .menu-item:hover > .menu-link' => RTMEGA_Helper::get_inline_styles($submenu_item_hover_styles),
];

// Re-enqueue handle
wp_enqueue_style( 'rtmegamenu-style' );

// Inject Styles
RTMEGA_Helper::add_custom_style( 'rtmegamenu-style', $selector, $css, $sub_styles );


// Sub Menu Icon based on style
if($submenu_icon_style == 'icon2'){
    $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>';
}
elseif($submenu_icon_style == 'icon3'){
    $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>';
}else{
    $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
}

// Vertical Menu Icon 	
if($vertical_active_menu_style == 'icon2'){
    $vertical_menu_active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>';
}
elseif($vertical_active_menu_style == 'icon3'){
    $vertical_menu_active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>';
}else{
    $vertical_menu_active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
}

// Build the menu classes
$class_responsvie =  $enableMobileMenu == true ? 'enabled-mobile-menu': 'enabled-desktop-menu';
$class_responsvie .=  $menu_layout == 'vertical' ? ' enabled-vertical-menu': '';
$menu_class = 'menu desktop-menu rtmega-megamenu vertical-submenu-expand-mode-click ' . $menu_layout;
$container_class = 'rtmega-menu-container rtmega-menu-area ' . $class_responsvie;
$container_class .=  !empty($mobileMenuSlug) ? ' has-different-mobile-menu': '';

if ($menu_layout == 'vertical') {
    $container_class .= ' enabled-vertical-menu';
}

// Mobile Menu HTML
$rtmega_mobile_menu_html = '';
if($enableMobileMenu){
    $rtmega_mobile_menu_html = '<div class="mobile-menu-area '.$unique_id.'">
    <div class="overlay" onclick="closeRTMEGAmobile()"></div>
    <div class="rtmega-menu-mobile-sidebar '.$mobileMenuOpenPositionClass.'">
        <button type="button" class="rtmega-menu-mobile-close" onclick="closeRTMEGAmobile()" aria-label="Close Menu"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M317.7 402.3c3.125 3.125 3.125 8.188 0 11.31c-3.127 3.127-8.186 3.127-11.31 0L160 267.3l-146.3 146.3c-3.127 3.127-8.186 3.127-11.31 0c-3.125-3.125-3.125-8.188 0-11.31L148.7 256L2.344 109.7c-3.125-3.125-3.125-8.188 0-11.31s8.188-3.125 11.31 0L160 244.7l146.3-146.3c3.125-3.125 8.188-3.125 11.31 0s3.125 8.188 0 11.31L171.3 256L317.7 402.3z"/></svg></button>
        <div class="rtmega-menu-mobile-navigation"><ul id="%1$s" class="%2$s">%3$s</ul></div>
    </div>
</div>';
}



// Vertical Menu Left & Right Icon 
$menu_arrow_vertical = ($attributes['enable_vertical_menu_arrow'] == 'yes') ? 'rt-mega-arrow-add' : '';

$menu_arrow_vertical_right = ($attributes['enable_vertical_menu_arrow'] == 'yes' && $attributes['enable_vertical_menu_arrow_right'] == 'yes') ? 'rt-mega-arrow-add-right' : '';
$menu_arrow_vertical_left = ($attributes['enable_vertical_menu_arrow'] == 'yes' && $attributes['enable_vertical_menu_arrow_right'] != 'yes') ? 'rt-mega-arrow-add-left' : '';

$menu_arrow_vertical_custom = '';
if ( $attributes['vertical_menu_arrow_type'] === 'verticla_custom_menu_icon' && !empty($attributes['vertical_menu_custom_icon']) ) {
    ob_start();
    echo '<span class="vertical_menu_custom_icon">';
        \Elementor\Icons_Manager::render_icon( $attributes['vertical_active_menu_style']['vertical_menu_custom_icon'], [ 'aria-hidden' => 'true' ] );
    echo '</span>';
    $menu_arrow_vertical_custom = ob_get_clean();
}

$menu_expand_position = isset($attributes['vertical_menu_expand_position']) ? sanitize_html_class($attributes['vertical_menu_expand_position']) : '';
$menu_expand_overlay_position = isset($attributes['vertical_menu_expand_overlay_position']) ? sanitize_html_class($attributes['vertical_menu_expand_overlay_position']) : '';
$menu_expand_position_class = ' expand-position-' . $menu_expand_position;
$menu_expand_overlay_position_class = ' expand-overlay-position-' . $menu_expand_overlay_position;

$menu_arrow_vertical_type = '';
if ( $attributes['enable_vertical_menu_arrow'] == 'yes' && isset($attributes['vertical_menu_arrow_type']) ) {
    if ( $attributes['vertical_menu_arrow_type'] === 'rtmega-single-arrow' ) {
        $menu_arrow_vertical_type = 'rtmega-single-arrow';
    }elseif( $attributes['vertical_menu_arrow_type'] === 'rtmega-double-arrow' ) {
        $menu_arrow_vertical_type = 'rtmega-double-arrow';
    }else{
        $menu_arrow_vertical_type = 'rtmega-custom-icon';
    }
}



// Vertical Expaned Menu
if ($menu_layout == 'vertical' && $attributes['vertical_menu_expand_mode'] == 'click') {
    $rtmega_vetical_menu_html = '<div class="vertical-expaned-menu-area ' . $unique_id . ' vertical-expaned-menu-area-' . $menu_expand_position . '">
        <div class="rtmega-menu-vertical-expanded ' .$menu_expand_position_class .$menu_expand_overlay_position_class. '">
            <div class="rtmega-menu-mobile-navigation '. $menu_arrow_vertical .' '. $menu_arrow_vertical_type .' '.$menu_arrow_vertical_right.''.$menu_arrow_vertical_left.'"> 
                <ul id="%1$s" class="%2$s">
                    %3$s
                </ul> 
            </div>
        </div>                            
    </div>';
}


if($menu_layout == 'vertical' && $attributes['vertical_menu_expand_mode'] == 'always_expand'){
    $rtmega_vetical_menu_html = '<div class="vertical-expaned-menu-area '.$unique_id.' vertical-expaned-menu-area-'.$menu_expand_position.'">
        <div class="rtmega-menu-vertical-always-expanded rtmega-menu-vertical-expanded opened '. $menu_expand_position_class .'">
            <div class="rtmega-menu-mobile-navigation '. $menu_arrow_vertical .' '. $menu_arrow_vertical_type .' '. $menu_arrow_vertical_right.''.$menu_arrow_vertical_left.'"><ul id="%1$s" class="%2$s">%3$s</ul></div>
            </div>
        </div>';
}

$desktop_menu_wrap = '<div class="desktop-menu-area"><ul id="%1$s" class="%2$s">%3$s</ul></div>';
$mobile_menu_wrap = $rtmega_mobile_menu_html;

if(!empty($attributes['mobileMenuSlug'])){
    $items_wrap = $desktop_menu_wrap;
}else{
    $items_wrap = $desktop_menu_wrap.$rtmega_mobile_menu_html;
}

if($menu_layout == 'vertical'){
    $items_wrap = $rtmega_vetical_menu_html;
}

// Render the menu using wp_nav_menu with RTMEGA_Nav_Walker
$menu_args = array(
    'menu'              => $menu_slug,
    'container'         => 'nav',
    'container_class'   => $container_class,
    'menu_class'        => $menu_class,
    'walker'            => new RTMEGA_Nav_Walker(),
    'echo'              => false,
    'fallback_cb'       => false,
    'items_wrap'        => $items_wrap,
    'submenu_parent_icon' => $submenu_parent_icon,
    'vertical_menu_active_icon' => $vertical_menu_active_icon,
    'menu_layout'       => $menu_layout,
    'pointer_hover_effect' => $pointer_menu_item,
);


$block_wrap_attr = get_block_wrapper_attributes( array( 'class' => 'rtmega-block-wrap ' . $unique_id ) );
?>
<div <?php echo wp_kses_post($block_wrap_attr); ?>>
    <?php echo wp_nav_menu( $menu_args ); ?>
    <?php 
    $only_mobile_menu_args = $menu_args;
    $only_mobile_menu_args['items_wrap'] = $rtmega_mobile_menu_html;
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo wp_kses_post( apply_filters( 'rtmega_block_mobile_menu_render', '', $attributes, $only_mobile_menu_args ) );
    ?>
    <?php
    if($enableMobileMenu){
        ?>
        <div class="rtmega-menu-area rtmega-menu-mobile-button-wrapper enabled-mobile-menu">							
                <?php
                if(isset($attributes['mobileMenuIcon']) && !empty($attributes['mobileMenuIcon'])){
                    ?>
                    <button class="rtmega-menu-mobile-button" onclick="openRTMEGAmobile()" aria-label="Open Menu">										
                        <i class="<?php echo esc_attr($attributes['mobileMenuIcon']); ?>" aria-hidden="true"></i>
                    </button>
                    <?php
                }else{
                    ?>
                    <button class="rtmega-menu-mobile-button" onclick="openRTMEGAmobile()" aria-label="Open Menu">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect y="14" width="18" height="2" fill="#000000"></rect>
                            <rect y="7" width="18" height="2" fill="#000000"></rect>
                            <rect width="18" height="2" fill="#000000"></rect>
                        </svg>
                    </button>
                    <?php
                }
                ?>								
        </div>							
        <?php
    }

    if($menu_layout == 'vertical' && $attributes['vertical_menu_expand_mode'] == 'click'){
						
        ?>
            <div class="rtmega-menu-area rtmega-menu-vertical-expand-button-wrapper enabled-vertical-menu vertical-menu-button-<?php echo esc_attr($menu_expand_position); ?>">
                
                <?php
                if(!empty($attributes['vertical_menu_toggle_icon'])){ ?>
                    <button class="rtmega-menu-mobile-button" widget_id='<?php echo esc_attr( $unique_id )?>'>
                        <i class="<?php echo esc_attr($attributes['vertical_menu_toggle_icon']); ?>" aria-hidden="true"></i>
                    </button>
                <?php } else {
                    if(isset($attributes['mobileMenuIcon']) && !empty($attributes['mobileMenuIcon'])){
                        ?>
                        <button class="rtmega-menu-mobile-button" widget_id='<?php echo esc_attr( $unique_id )?>'>
                            <i class="<?php echo esc_attr($attributes['mobileMenuIcon']); ?>" aria-hidden="true"></i>
                        </button>
                        <?php
                    }else{
                        ?>
                        <button class="rtmega-menu-mobile-button" widget_id='<?php echo esc_attr( $unique_id )?>'>
                            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="14" width="18" height="2" fill="#000000"></rect>
                                <rect y="7" width="18" height="2" fill="#000000"></rect>
                                <rect width="18" height="2" fill="#000000"></rect>
                            </svg>
                        </button>
                        <?php
                    }
                }
                ?>
                    
            </div>
            
            <?php
            if (!empty($attributes['vertical_menu_close_icon'])) {
                ?>
                <span class="rtmega-menu-top-cls rtmega-menu-top-style-cls <?php echo esc_attr($menu_expand_position_class); ?>"> 
                    <i class="<?php echo esc_attr($attributes['vertical_menu_close_icon']); ?>" aria-hidden="true"></i>
                </span>
                <?php
            }
                
    }
    ?>
</div>
