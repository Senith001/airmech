<?php
// This file is generated. Do not modify it manually.
return array(
	'build' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'rt-mega-menu/mega-menu',
		'version' => '1.0.0',
		'title' => 'RT Mega Menu',
		'category' => 'rt-mega-menu',
		'icon' => 'menu',
		'description' => 'Display a RT Mega Menu with full style customization.',
		'supports' => array(
			'html' => false,
			'reusable' => false
		),
		'attributes' => array(
			'menu_slug' => array(
				'type' => 'string',
				'default' => ''
			),
			'menu_layout' => array(
				'type' => 'string',
				'default' => 'horizontal'
			),
			'submenu_icon_style' => array(
				'type' => 'string',
				'default' => 'icon1'
			),
			'vertical_active_menu_style' => array(
				'type' => 'string',
				'default' => 'icon1'
			),
			'enable_vertical_menu_arrow' => array(
				'type' => 'boolean',
				'default' => false
			),
			'vertical_menu_arrow_type' => array(
				'type' => 'string',
				'default' => 'rtmega-single-arrow'
			),
			'enable_vertical_menu_arrow_right' => array(
				'type' => 'boolean',
				'default' => true
			),
			'verticla_custom_menu_icon' => array(
				'type' => 'string',
				'default' => ''
			),
			'vertical_menu_close_icon' => array(
				'type' => 'string',
				'default' => 'far fa-window-close'
			),
			'vertical_menu_toggle_icon' => array(
				'type' => 'string',
				'default' => 'fas fa-bars'
			),
			'vertical_menu_expand_mode' => array(
				'type' => 'string',
				'default' => 'always_expand'
			),
			'vertical_menu_expand_position' => array(
				'type' => 'string',
				'default' => 'bottom'
			),
			'vertical_menu_expand_overlay_position' => array(
				'type' => 'string',
				'default' => 'top'
			),
			'pointer_menu_item' => array(
				'type' => 'string',
				'default' => 'none'
			),
			'enableMobileMenu' => array(
				'type' => 'boolean',
				'default' => true
			),
			'mobileMenuOpenPosition' => array(
				'type' => 'string',
				'default' => 'right'
			),
			'mobileMenuIcon' => array(
				'type' => 'string',
				'default' => 'fas fa-bars'
			),
			'menuAlign' => array(
				'type' => 'string',
				'default' => 'left'
			),
			'menuAlignTablet' => array(
				'type' => 'string'
			),
			'menuAlignMobile' => array(
				'type' => 'string'
			),
			'wrapperBgColor' => array(
				'type' => 'string'
			),
			'wrapperBgGradient' => array(
				'type' => 'string'
			),
			'wrapperPadding' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'wrapperPaddingTablet' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'wrapperPaddingMobile' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'wrapperMargin' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'wrapperMarginTablet' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'wrapperMarginMobile' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuItemColor' => array(
				'type' => 'string'
			),
			'menuItemHoverColor' => array(
				'type' => 'string'
			),
			'menuItemBgColor' => array(
				'type' => 'string'
			),
			'menuItemBgGradient' => array(
				'type' => 'string'
			),
			'menuItemHoverBgColor' => array(
				'type' => 'string'
			),
			'menuItemHoverBgGradient' => array(
				'type' => 'string'
			),
			'menuTypography' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuTypographyTablet' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuTypographyMobile' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuPadding' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuPaddingTablet' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuPaddingMobile' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuMargin' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuMarginTablet' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuMarginMobile' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'menuSpaceBetween' => array(
				'type' => 'string',
				'default' => '0px'
			),
			'menuSpaceBetweenTablet' => array(
				'type' => 'string',
				'default' => '0px'
			),
			'menuSpaceBetweenMobile' => array(
				'type' => 'string',
				'default' => '0px'
			),
			'submenuBgColor' => array(
				'type' => 'string'
			),
			'submenuBgGradient' => array(
				'type' => 'string'
			),
			'subMenuSpaceBetween' => array(
				'type' => 'string',
				'default' => '0px'
			),
			'subMenuSpaceBetweenTablet' => array(
				'type' => 'string',
				'default' => '0px'
			),
			'subMenuSpaceBetweenMobile' => array(
				'type' => 'string',
				'default' => '0px'
			),
			'submenuItemPadding' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'submenuItemPaddingTablet' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'submenuItemPaddingMobile' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'submenuItemColor' => array(
				'type' => 'string'
			),
			'submenuItemHoverColor' => array(
				'type' => 'string'
			),
			'submenuItemBgColor' => array(
				'type' => 'string'
			),
			'submenuItemHoverBgColor' => array(
				'type' => 'string'
			),
			'submenuTypography' => array(
				'type' => 'object',
				'default' => array(
					
				)
			),
			'boxShadow' => array(
				'type' => 'string'
			),
			'boxShadowX' => array(
				'type' => 'number',
				'default' => 0
			),
			'boxShadowY' => array(
				'type' => 'number',
				'default' => 0
			),
			'boxShadowBlur' => array(
				'type' => 'number',
				'default' => 0
			),
			'boxShadowSpread' => array(
				'type' => 'number',
				'default' => 0
			),
			'boxShadowColor' => array(
				'type' => 'string',
				'default' => 'rgba(0,0,0,0.1)'
			),
			'mobileMenuSlug' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'textdomain' => 'rt-mega-menu',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'rtmegamenu-style',
		'render' => 'file:./render.php'
	)
);
