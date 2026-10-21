<?php
// Elementor Classes.
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Nav Menu.
 */
class RTMEGA_MENU_INLINE extends Widget_Base {
	/**
	 * Menu index.
	 *
	 * @access protected
	 * @var $nav_menu_index
	 */
	protected $nav_menu_index = 1;

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rt-mega-navigation-menu';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'RTMEGA Menu', 'rt-mega-menu' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-nav-menu';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.3.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'rtmega_category' ];
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.3.0
	 * @access protected
	 */

	public function get_style_depends() {
		return [ 'rtmegamenu-style' ];
	}

	public function get_script_depends() {
		return [ 'rtmegamenu-public', 'rtmegamenu-accordion-script' ];
	}

	/**
	 * Retrieve the menu index.
	 *
	 * Used to get index of nav menu.
	 *
	 * @since 1.3.0
	 * @access protected
	 *
	 * @return string nav index.
	 */
	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	/**
	 * Retrieve the list of available menus.
	 *
	 * Used to get the list of available menus.
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @return array get WordPress menus list.
	 */
	private function get_available_menus() {

		$menus = wp_get_nav_menus();

		$options = ['' => __('Select Menu', 'rt-mega-menu')];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Check if the Elementor is updated.
	 *
	 * @since 1.3.0
	 *
	 * @return boolean if Elementor updated.
	 */
	public static function is_elementor_updated() {
		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Register Nav Menu controls.
	 *
	 * @since 1.5.7
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_general_content_controls();
		$this->register_style_content_controls();
		$this->register_dropdown_content_controls();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'Menu', 'rt-mega-menu' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'rt-mega-menu' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					/* translators: %s Nav menu URL */
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'rt-mega-menu' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s Nav menu URL */
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'rt-mega-menu' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}
		$this->add_control(
			'mobile_menu_pro_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => '<div style="position:relative;pointer-events:none;opacity:0.6;">
					<label class="elementor-control-title">' . __( 'Mobile Menu', 'rt-mega-menu' ) . '</label>
					<select class="elementor-control-input-wrapper" disabled style="width:100%;margin-top:6px;padding:6px 8px;border:1px solid #d5dadf;border-radius:3px;background:#f9f9f9;color:#555;cursor:not-allowed;">
						<option>' . __( '— Select a menu —', 'rt-mega-menu' ) . '</option>
					</select>
				</div>
				<div style="margin-top:8px;padding:8px 10px;border-left:3px solid #f0ad00;border-radius:2px;font-size:12px;line-height:1.5;">
					' . sprintf(
						/* translators: %s: URL to the RT Mega Menu Pro upgrade page. */
						__( '<strong>Mobile Menu</strong> is a <a href="%s" target="_blank" style="color:#f0ad00;pointer-events:auto;">Pro feature</a>. Upgrade to set a separate menu for mobile devices.', 'rt-mega-menu' ),
						'https://themewant.com/downloads/rt-mega-menu-pro/'
					) . '
				</div>',
				'content_classes' => 'rtmega-pro-feature-notice',
			]
		);

		do_action( 'rtmega_mobile_menu_control_el', $this );

		$this->add_control(
			'enable_menu_description',
			[
				'label'        => __( 'Show Description', 'rt-mega-menu' ),
				'type'         => Controls_Manager::SELECT,
				'options'   => [
					'none' => __( 'No', 'rt-mega-menu' ),
					'inline-block'  => __( 'Yes', 'rt-mega-menu' ),
				],
				'default'   => 'none',
				'selectors'          => [
					'{{WRAPPER}} li.menu-item .menu-desc' => 'display: {{VALUE}};',
				],
			]
		);
		


		$this->end_controls_section();
			$this->start_controls_section(
				'section_layout',
				[
					'label' => __( 'Layout', 'rt-mega-menu' ),
				]
			);

			$this->add_control(
				'menu_layout',
				[
					'label'   => __( 'Layout', 'rt-mega-menu' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => __( 'Horizontal', 'rt-mega-menu' ),
						'vertical'   => __( 'Vertical', 'rt-mega-menu' )
					],
				]
			);
			
			$this->add_control(
				'enable_sticky_header',
				[
					'label' => esc_html__( 'Enable Sticky Header', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
					'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
					'return_value' => 'yes',
					'separator' => 'before'
				]
			);


			$this->add_control(
			    'enable_backscroll_header_top',
			    [
			        'label' => esc_html__( 'Enable Back Scroll Top Hide', 'rt-mega-menu' ),
			        'type' => \Elementor\Controls_Manager::SWITCHER,
			        'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
			        'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
			        'return_value' => 'yes',
			        'default' => '',
			    ]
			);
		$this->end_controls_section();

		$this->start_controls_section(
            'section_vertical_menu',
            [
                'label' => __( 'Vertical Menu', 'rt-mega-menu'),
				'condition' => [
					'menu_layout' => 'vertical'
				]
            ]
        );
		$this->add_control(
			'vertical_menu_background',
			[
				'label'     => __( 'Vertical Menu Background', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'vertical_menu_padding',
			[
				'label'              => __( 'Vertical Menu Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'menu_layout' => 'vertical'
				],
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'vertical_menu_border_radius',
			[
				'label'              => __( 'Vertical Menu Border Radius', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'menu_layout' => 'vertical'
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'vertical_menu_expand_mode',
			[
				'label'   => __( 'Expand Mode', 'rt-mega-menu' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'always_expand',
				'options' => [
					'click' => __( 'Expand on click', 'rt-mega-menu' ),
					'always_expand'   => __( 'Always expand', 'rt-mega-menu' )
				],
				'condition' => [
					'menu_layout' => 'vertical'
				]
			]
		);

		$this->add_control(
			'vertical_menu_expand_position',
			[
				'label'   => __( 'Menu Expand Position', 'rt-mega-menu' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'top' 	 => __( 'Overlay', 'rt-mega-menu' ),					
					'bottom' => __( 'Bottom', 'rt-mega-menu' ),
					'left' 	 => __( 'Left', 'rt-mega-menu'),
					'right'  => __( 'Right', 'rt-mega-menu'),
				],
				'condition' => [
					'menu_layout' => 'vertical',
					'vertical_menu_expand_mode' => 'click'
				]
			]
		);	
		$this->add_control(
			'vertical_menu_expand_overlay_position',
			[
				'label'   => __( 'Menu Expand Overlay Position', 'rt-mega-menu' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top' 	 => __( 'Top', 'rt-mega-menu' ),					
					'bottom' => __( 'Bottom', 'rt-mega-menu' ),
					'left' 	 => __( 'Left', 'rt-mega-menu'),
					'right'  => __( 'Right', 'rt-mega-menu'),
				],
				'condition' => [
					'menu_layout' => 'vertical',
					'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
				]
			]
		);	

		$this->add_control(
			'logo__image',
			[
				'label' => esc_html__( 'Choose Custom Logo', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
				]
			]
		);

		$this->add_responsive_control(
		    'cutom__logo_gap',
		    [
		        'label'      => __( 'Margin Bottom', 'rt-mega-menu' ),
		        'type'       => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [                        
		                'max'  => 100,
		                'step' => 1,
		            ],                    
		        ],
		        'condition'  => [
		            'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
		        ],
		        'selectors'  => [
		            '{{WRAPPER}} .rtmega-custom-logo'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
            'vertical_menu_top_icon',
            [
                'label'     => esc_html__('Menu Hamburger Icon', 'rt-mega-menu'),
                'type' => Controls_Manager::ICONS,
                'separator' => 'before',
				'condition' => [
					'menu_layout' => 'vertical',
					'vertical_menu_expand_mode' => 'click',
				]
            ]
        );

        $this->add_control(
			'vertical_menu_tops',
			[
				'label' => esc_html__( 'Menu Close Icon', 'rt-mega-menu' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-window-close',
					'library' => 'fa-solid',
				],
				'condition' => [
					'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
				]
			]
		);

		$this->add_control(
			'bg_color_ovr',
			[
				'label'     => __( 'Overlay Bg Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-top' => 'background-color: {{VALUE}} !important',
				],
				'condition' => [
					'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
				]
			]
		);

		$this->add_control(
			'_color_icon',
			[
				'label'     => __( 'Close Icon Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-top-style-cls.expand-position-top i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rtmega-menu-top-style-cls.expand-position-top svg path' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
				]
			]
		);


		$this->add_responsive_control(
		    'close__icon_size',
		    [
		        'label'      => __( 'Close Icon Size (Only Expand Top)', 'rt-mega-menu' ),
		        'type'       => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [                        
		                'max'  => 100,
		                'step' => 1,
		            ],                    
		        ],
		        'condition'  => [
		            'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
		        ],
		        'selectors'  => [
		            '{{WRAPPER}} .rtmega-menu-top-style-cls.expand-position-top svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
		            '{{WRAPPER}} .rtmega-menu-top-style-cls.expand-position-top i'   => 'font-size: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);


		$this->add_responsive_control(
		    'logo____size',
		    [
		        'label'      => __( 'Logo Size (Only Expand Top)', 'rt-mega-menu' ),
		        'type'       => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'range'      => [
		            'px' => [                        
		                'max'  => 200,
		                'step' => 1,
		            ],                    
		        ],
		        'condition'  => [
		            'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
		        ],
		        'selectors'  => [
		            '{{WRAPPER}} .rtmega-custom-logo img' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_control(
			'logo_align',
			[
				'label'     => __( 'Item Text Align', 'rt-mega-menu' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'toggle'    => true,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'rt-mega-menu' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'rt-mega-menu' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'rt-mega-menu' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rtmega-custom-logo' => 'text-align: {{VALUE}}',
				],
				'condition'  => [
				   'vertical_menu_expand_mode' => 'click',
					'vertical_menu_expand_position' => 'top',
				],
				'separator' => 'after',
			]	
		);


		$this->add_responsive_control(
			'vertical_menu_position_left',
			[
				'label'              => __( 'Menu Horizontal Position', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => ['px','%'],
				'range'              => [
					'px' => [						
						'max' => 1000,
						'min' => -1000,
					],
					
				],
				'condition' => [
					'vertical_menu_expand_position!' => 'top',
					'vertical_menu_expand_mode' => 'click'
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-bottom,
					 {{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-left' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-right' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'vertical_menu_position_top',
			[
				'label'              => __( 'Menu Vertical Position', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px','%'],
				'range'              => [
					'px' => [						
						'max' => 1000,
						'min' => -1000,
					],
					
				],
				'condition' => [
					'vertical_menu_expand_position!' => 'top',
					'vertical_menu_expand_mode' => 'click'
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-bottom' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-left,
					{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-right' => '--rtmega-menu-translate-y: {{SIZE}}{{UNIT}}; top: {{SIZE}}{{UNIT}} !important;',
					],
			]
		);
		$this->add_responsive_control(
			'vertical_menu_width',
			[
				'label'              => __( 'Menu Width', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px','%'],
				'range'              => [
					'px' => [						
						'max' => 3000,
						'step' => 10,
					],					
				],
				'condition' => [
					'menu_layout' => 'vertical',
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded:not(.expand-position-top)' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded.expand-position-top .rtmega-megamenu' => 'width: {{SIZE}}{{UNIT}};',
					],
			]
		);
		$this->add_control(
			'vertical_menu_submenu_expad_mode',
			[
				'label'   => __( 'Submenu Expand Mode', 'rt-mega-menu' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'click',
				'options' => [
					'click' => __( 'Clicked on expand', 'rt-mega-menu' ),
					'hover'   => __( 'Hover', 'rt-mega-menu' )
				],
				'condition' => [
					'menu_layout' => 'vertical'
				]
			]
		);
		$this->add_control(
			'vertical_menu_submenu_expad_mode_type', 
			[
				'label' => esc_html__( 'Sub Menu Position', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'rt-mega-menu' ),
					'right' => esc_html__( 'Right', 'rt-mega-menu' ),
				],
				'condition' => [
					'menu_layout' => 'vertical',
					'vertical_menu_submenu_expad_mode' => 'hover',
				]
			]
		);	
		$this->add_responsive_control(
			'sub_menu_width',
			[
				'label'              => __( 'SubMenu Width', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => ['px','%'],
				'range'              => [
					'px' => [						
						'max' => 3000,
						'step' => 10,
					],
					
				],
				'condition' => [
					'menu_layout' => 'vertical',
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded .sub-menu:not(.rtmegamenu-contents)' => 'width: {{SIZE}}{{UNIT}};',
					],
			]
		);
		$this->add_control(
			'vertical_menu_btn_icon',
			[
				'label'     => esc_html__('Menu Button Icon', 'rt-mega-menu'),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
				'condition'    => [
					'enable_mobile_menu_view' => [ 'yes'],
				],
			]
		);
		$this->add_responsive_control(
			'vertical_menu_btn_icon_size',
			[
				'label'              => __( 'Icon Size', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px'],
				'range'              => [
					'px' => [						
						'max' => 100,
						'step' => 1,
					],
					
				],
				'condition' => [
					'menu_layout' => 'vertical',
					'vertical_menu_expand_mode' => 'click'
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area.rtmega-menu-vertical-expand-button-wrapper a svg' => 'width: {{SIZE}}{{UNIT}};',
					],
			]
		);

		$this->add_control(
			'enable_vertical_menu_arrow',
			[
				'label' => esc_html__( 'Enable Vertical Menu Icon', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
				'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
				'return_value' => 'yes',
				'condition' => [
					'menu_layout' => 'vertical',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'vertical_menu_arrow_type', 
			[
				'label' => esc_html__( 'Icon Type', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'default' => 'rtmega-single-arrow',
				'options' => [
					'rtmega-single-arrow' => esc_html__( 'Single Arrow', 'rt-mega-menu' ),
					'rtmega-double-arrow' => esc_html__( 'Double Arrow', 'rt-mega-menu' ),
					'verticla_custom_menu_icon' => esc_html__( 'Custom Icon', 'rt-mega-menu' ),
				],
				'condition' => [
					'menu_layout' => 'vertical',
					'enable_vertical_menu_arrow' => 'yes',
				]
			]
		);
		$this->add_control(
            'vertical_menu_custom_icon',
            [
                'label'     => esc_html__('Custom Icon Type', 'rt-mega-menu'),
                'type' => Controls_Manager::ICONS,
                'separator' => 'before',
				'condition' => [
					'menu_layout' => 'vertical',
					'enable_vertical_menu_arrow' => 'yes',
					'vertical_menu_arrow_type' => 'verticla_custom_menu_icon',
				]
            ]
        );

		$this->add_control(
			'enable_vertical_menu_arrow_right',
			[
				'label' => esc_html__( 'Enable Position Right Icon', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
				'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
				'return_value' => 'yes',				
				'condition' => [
					'menu_layout' => 'vertical',
					'enable_vertical_menu_arrow' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'vertical_menu_arrow_icon_size',
			[
				'label'       => __( 'Icon Size', 'rt-mega-menu' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px'],
				'condition'   => [
					'menu_layout' => 'vertical',
					'enable_vertical_menu_arrow' => 'yes',
				],
				'selectors'   => [
					'{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add ul li a::before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add ul li a .vertical_menu_custom_icon svg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'vertical_menu_arrow_icon_top_position',
			[
				'label'       => __( 'Icon Vertical Position', 'rt-mega-menu' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px','%'],
				'condition'   => [
					'menu_layout' => 'vertical',
					'enable_vertical_menu_arrow' => 'yes',
				],
				'selectors'   => [
					'{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-left ul li a::before,
					 {{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-left ul li a .vertical_menu_custom_icon,
					 {{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-right ul li a::before,
					 {{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-right ul li a .vertical_menu_custom_icon' => 'top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'vertical_menu_arrow_icon_position',
			[
				'label'       => __( 'Icon Horizontal Position', 'rt-mega-menu' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px','%'],
				'condition'   => [
					'menu_layout' => 'vertical',
					'enable_vertical_menu_arrow' => 'yes',
				],
				'selectors'   => [
					'{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-left ul li a::before,
					 {{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-left ul li a .vertical_menu_custom_icon' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-right ul li a::before,
					{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rt-mega-arrow-add.rt-mega-arrow-add-right ul li a .vertical_menu_custom_icon' => 'right: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'vertical_menu_hover_left_space',
			[
				'label' => esc_html__( 'Hover Left Space', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .vertical-expaned-menu-area .rtmega-menu-vertical-expanded ul.rtmega-megamenu.vertical .menu-item:hover > a' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'menu_layout' => 'vertical',
				]
			]
		);
		$this->add_control(
			'enable_menu_hover_transform_scale',
			[
				'label' => esc_html__( 'Enable Menu Hover Transform Scale', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
				'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
				'return_value' => 'yes',				
				'condition' => [
					'menu_layout' => 'vertical',
				]
			]
		);
		$this->add_responsive_control(
			'menu_hover_transform_scale',
			[
				'label'              => __( 'Menu Hover Transform Scale', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 2,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1.02,
				],
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-area .rtmega-menu-vertical-expanded .rtmega-megamenu > .menu-item:hover > .menu-link' => 'transform: scale({{SIZE}});',
				],
				'condition' => [
					'menu_layout' => 'vertical',
					'enable_menu_hover_transform_scale' => 'yes'
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
            'section_mobile_menu_menu',
            [
                'label' => __( 'Responsive Menu', 'rt-mega-menu'),
            ]
        );
		$this->add_control(
			'enable_mobile_menu_view',
			[
				'label' => esc_html__( 'Enable Menu Responsive view', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
				'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
				'return_value' => 'yes',
			]
		);
		// menu open position
		$this->add_control(
			'mobile_menu_open_position',
			[
				'label' => esc_html__( 'Menu Open Position', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'rt-mega-menu' ),
					'right' => esc_html__( 'Right', 'rt-mega-menu' ),
					'top' => esc_html__( 'Top', 'rt-mega-menu' ),
				],
				'default' => 'right',
				'condition' => [
					'enable_mobile_menu_view' => 'yes'
				]
			]
		);

		$this->add_control(
            'icon_settings',
            [
                'label'     => __( 'Icon Settings', 'rt-mega-menu'),
                'type'      => \Elementor\Controls_Manager::HEADING,               
                'condition'    => [
					'enable_mobile_menu_view' => [ 'yes'],
				],
            ]
        );
		$this->add_control(
            'menu_btn_icon',
            [
                'label'     => esc_html__('Menu Button Icon', 'rt-mega-menu'),
                'type' => Controls_Manager::ICONS,
                'separator' => 'before',
				'condition'    => [
					'enable_mobile_menu_view' => [ 'yes'],
				],
            ]
        );
		$this->end_controls_section();

	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_style_content_controls() {

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label'     => __( 'Main Menu', 'rt-mega-menu' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);
		

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label'              => __( 'Horizontal Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'padding-left: {{SIZE}}{{UNIT}} !important; padding-right: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'padding-left: {{SIZE}}{{UNIT}} !important; padding-right: {{SIZE}}{{UNIT}} !important;',
					],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label'              => __( 'Vertical Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 50,
					],
				],
				'default'            => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'padding-top: {{SIZE}}{{UNIT}} !important; padding-bottom: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'padding-top: {{SIZE}}{{UNIT}} !important; padding-bottom: {{SIZE}}{{UNIT}} !important;',
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'space_between_menu_item',
			[
				'label'              => __( 'Space Between', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'          => [
					'body:not(.rtl) {{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
				'condition'    => [
					'menu_layout' => [ 'horizontal'],
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'right_gap_menu_item',
			[
				'label'              => __( 'Menu Item Right Gap', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item:not(:last-child)' => 'margin-right:{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item:not(:last-child)' => 'margin-right:{{SIZE}}{{UNIT}}',
				],
				'condition'          => [
					'menu_layout' => 'horizontal',
				],
				'frontend_available' => true,
			]
		);		
		// text align control
		$this->add_control(
			'menu_item_text_align',
			[
				'label'     => __( 'Item Text Align', 'rt-mega-menu' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'toggle'    => true,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'rt-mega-menu' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'rt-mega-menu' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'rt-mega-menu' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'text-align: {{VALUE}}',
				],
			]	
		);
		$this->add_responsive_control(
			'menu_item_margin',
			[
				'label'              => __( 'Item Margin (li)', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'menu_item_padding',
			[
				'label'              => __( 'Item Padding (li)', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'frontend_available' => true,
			]	
		);

		// Menu Item Max Width
		$this->add_responsive_control(
			'menu_item_max_width',
			[
				'label'              => __( 'Item Max Width', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px', '%' ],
				'description'        => __( 'If you need to set the maximum width for the menu item. ', 'rt-mega-menu' ),
				'range'              => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		// max-height control
		$this->add_responsive_control(
			'menu_item_max_height',
			[
				'label'              => __( 'Item Max Height', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px', '%' ],
				'description'        => __( 'If you need to set the maximum height for the menu item. ', 'rt-mega-menu' ),
				'range'              => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'height: {{SIZE}}{{UNIT}};',
				],
			]	
		);

		// display flex control
		$this->add_responsive_control(
			'display_direction',
			[
				'label' => __( 'Direction', 'rt-mega-menu' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __( 'Row', 'rt-mega-menu' ),
						'icon' => 'eicon-arrow-right',
					],
					'column' => [
						'title' => __( 'Column', 'rt-mega-menu' ),
						'icon' => 'eicon-arrow-down',
					],
					'row-reverse' => [
						'title' => __( 'Row Reverse', 'rt-mega-menu' ),
						'icon' => 'eicon-arrow-left',
					],
					'column-reverse' => [
						'title' => __( 'Column Reverse', 'rt-mega-menu' ),
						'icon' => 'eicon-arrow-up',
					],
				],
				'default' => 'row',
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'display: flex; flex-direction: {{VALUE}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'display: flex; flex-direction: {{VALUE}};',
				],
				'condition' => [
					'menu_item_max_width[size]!' => '',
				],
			]
		);
		// Justify Content Control (Choose)
		$this->add_control(
			'justify_content',
			[
				'label' => __( 'Justify Content', 'rt-mega-menu' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Start', 'rt-mega-menu' ),
						'icon' => 'eicon-flex eicon-justify-start-h',
					],
					'center' => [
						'title' => __( 'Center', 'rt-mega-menu' ),
						'icon' => 'eicon-flex eicon-justify-center-h',
					],
					'flex-end' => [
						'title' => __( 'End', 'rt-mega-menu' ),
						'icon' => 'eicon-flex eicon-justify-end-h',
					],
					'space-between' => [
						'title' => __( 'Space Between', 'rt-mega-menu' ),
						'icon' => 'eicon-flex eicon-justify-space-between-h',
					],
					'space-around' => [
						'title' => __( 'Space Around', 'rt-mega-menu' ),
						'icon' => 'eicon-flex eicon-justify-space-around-h',
					],
					'space-evenly' => [
						'title' => __( 'Space Evenly', 'rt-mega-menu' ),
						'icon' => 'eicon-flex eicon-justify-space-evenly-h',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'condition'   => [
					'menu_item_max_width[size]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'justify-content: {{VALUE}};',
				],
				
			]
		);
	
		// Align Items Control (Choose)
		$this->add_control(
			'align_items',
			[
				'label' => __( 'Align Items', 'rt-mega-menu' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Start', 'rt-mega-menu' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'rt-mega-menu' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'End', 'rt-mega-menu' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'stretch' => [
						'title' => __( 'Stretch', 'rt-mega-menu' ),
						'icon' => 'eicon-v-align-stretch',
					],
				],
				'default' => 'stretch',
				'toggle' => true,
				'condition'   => [
					'menu_item_max_width[size]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'align-items: {{VALUE}};',
				],
			]
		);


		$this->add_control(
		'pointer_menu_item',
			[
				'label'     => __( 'Link Hover Effect', 'rt-mega-menu' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					'none'        => __( 'None', 'rt-mega-menu' ),
					'underline'   => __( 'Underline', 'rt-mega-menu' ),
				],
				'condition' => [
					'menu_layout' => [ 'horizontal' ],
				],
			]
		);

	$this->add_control(
		'style_divider_menu_item',
		[
			'type' => Controls_Manager::DIVIDER,
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name'      => 'typography_menu_item',
			'separator' => 'before',
			'selector'  => '{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item .menu-link, {{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item .menu-link',
		]
	);

	$this->start_controls_tabs( 'tabs_menu_item_style' );
		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'rt-mega-menu' ),
			]
		);

			$this->add_control(
				'color_menu_item',
				[
					'label'     => __( 'Text Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'color: {{VALUE}}',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bg_color_menu_item',
				[
					'label'     => __( 'Background Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link' => 'background-color: {{VALUE}}',
					],
					
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_menu_item_hover',
				[
					'label' => __( 'Hover', 'rt-mega-menu' ),
				]
			);

				$this->add_control(
					'color_menu_item_hover',
					[
						'label'     => __( 'Hover Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item:hover > .menu-link' => 'color: {{VALUE}} ',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item:hover > .menu-link' => 'color: {{VALUE}}',
						],
					]
				);	
				$this->add_control(
					'bg_color_menu_item_hover',
					[
						'label'     => __( 'Background Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item:hover > .menu-link' => 'background-color: {{VALUE}} !important',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item:hover > .menu-link' => 'background-color: {{VALUE}} !important',
						],
						
					]
				);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_menu_item_active',
				[
					'label' => __( 'Active', 'rt-mega-menu' ),
				]
			);

				$this->add_control(
					'color_menu_item_active',
					[
						'label'     => __( 'Active Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item.current-menu-item > .menu-link' => 'color: {{VALUE}}',
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item.current-menu-parent > .menu-link' => 'color: {{VALUE}}',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item.current-menu-item > .menu-link' => 'color: {{VALUE}}',
						],
					]
				);
				$this->add_control(
					'bg_color_menu_item_active',
					[
						'label'     => __( 'Background Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item.current-menu-item > .menu-link' => 'background-color: {{VALUE}} !important',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item.current-menu-item > .menu-link' => 'background-color: {{VALUE}} !important',
						],
						
					]
				);	
			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_menu_item',
				'label' => esc_html__( 'Border', 'rt-mega-menu' ),
				'selector' => '{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link, {{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link',
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
			'border_radius_radius_menu_item',
			[
				'label'              => __( 'Border Radius', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > .menu-link'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > .menu-link'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'frontend_available' => true,
			]
		);
			// Sub Menu Icon
			$this->add_control(
				'submenu_icon_options',
				[
					'label' => esc_html__( 'Sub Menu Icon', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'enable_submenu_icon',
				[
					'label' => esc_html__( 'Disable Submenu Icon', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
					'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
					'return_value' => 'none',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item-has-children .menu-link .menu-text .submenu-parent-icon' => 'display: {{VALUE}} !important',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item-has-children .menu-link .menu-text .submenu-parent-icon' => 'display: {{VALUE}} !important',
					],
					'frontend_available' => true,
				]
			);
			
			$this->add_control(
				'submenu_icon_style',
				[
					'label' => esc_html__( 'Select Icon', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'icon1',
					'options' => [
						'icon1'  => esc_html__( 'Angle', 'rt-mega-menu' ),
						'icon2' => esc_html__( 'Plus', 'rt-mega-menu' ),						
						'icon3' => esc_html__( 'Arrow Right', 'rt-mega-menu' ),						
					],
					'condition' => ['enable_submenu_icon!' => 'none'],
				]
			);

			$this->add_control(
				'color_parent_icon',
				[
					'label'     => __( 'Icon Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item-has-children > .menu-link .menu-text .submenu-parent-icon svg' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item-has-children > .menu-link .menu-text .submenu-parent-icon svg' => 'fill: {{VALUE}} !important',
					],
					'condition' => ['enable_submenu_icon!' => 'none'],
				]
			);
			$this->add_responsive_control(
				'submenu_icon_size',
				[
					'label'              => __( 'Icon Size', 'rt-mega-menu' ),
					'type'               => Controls_Manager::SLIDER,
					'range'              => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item-has-children > .menu-link .menu-text .submenu-parent-icon svg' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item-has-children > .menu-link .menu-text .submenu-parent-icon svg' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => ['enable_submenu_icon!' => 'none'],
					'frontend_available' => true,
				]
			);


			$this->add_control(
				'enable_vertical_active_menu_icon',
				[
					'label' => esc_html__( 'Disable Vertical Active Menu Icon', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'rt-mega-menu' ),
					'label_off' => esc_html__( 'No', 'rt-mega-menu' ),
					'return_value' => 'none',              
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item.current-menu-item .vertical_menu_active_icon' => 'display: {{VALUE}} !important',
					],
					'condition' => [
						'menu_layout' => 'vertical',
					],
					'frontend_available' => true,
				]
			);
			
			$this->add_control(
				'vertical_active_menu_style',
				[
					'label' => esc_html__( 'Vertical Active Menu Icon', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'icon3',
					'options' => [
						'icon1' => esc_html__( 'Angle', 'rt-mega-menu' ),
						'icon2' => esc_html__( 'Plus', 'rt-mega-menu' ),
						'icon3' => esc_html__( 'Arrow Right', 'rt-mega-menu' ),
					],
					'condition' => [
						'menu_layout' => 'vertical',
						'enable_vertical_active_menu_icon!' => 'none',
					],
				]
			);

			$this->add_control(
				'color_verticle_icon',
				[
					'label'     => __( 'Icon Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded .current-menu-item .vertical_menu_active_icon svg' => 'fill: {{VALUE}} !important',
						
					],
					'condition' => [
						'enable_vertical_active_menu_icon!' => 'none',
						'menu_layout' => 'vertical',
					],
				]
			);

			$this->add_responsive_control(
				'width_icon',
				[
					'label'              => __( 'Icon Size', 'rt-mega-menu' ),
					'type'               => Controls_Manager::SLIDER,
					'range'              => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'default'            => [
						'size' => '12',
						'unit' => 'px',
					],
					'selectors'          => [						
						'{{WRAPPER}} .rtmega-menu-area .vertical-expaned-menu-area .rtmega-menu-vertical-expanded .current-menu-item .vertical_menu_active_icon svg' => 'height: {{SIZE}}{{UNIT}};',
						
						
					],
					'condition' => [
						'enable_vertical_active_menu_icon!' => 'none',
						'menu_layout' => 'vertical',
					],
					'frontend_available' => true,
				]
			);

			// Sticky Menu
			$this->add_control(
				'more_options',
				[
					'label' => esc_html__( 'Sticky Menu', 'rt-mega-menu' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

		
			$this->add_control(
				'sticky_color_parent_icon',
				[
					'label'     => __( 'Sticky Icon Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'header.sticky-header .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item-has-children > .menu-link .menu-text .submenu-parent-icon svg' => 'fill: {{VALUE}} !important',
						
					],
					'condition' => ['enable_submenu_icon!' => 'none'],
				]
			);

			$this->start_controls_tabs( 'tabs_menu_item_style_stikcy' );

				$this->start_controls_tab(
					'stikcy_menu_item_normal',
					[
						'label' => __( 'Normal', 'rt-mega-menu' ),
					]
				);

				$this->add_control(
					'sticky_color_menu_item',
					[
						'label'     => __( 'Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'global'    => [
							'default' => Global_Colors::COLOR_TEXT,
						],
						'selectors' => [
							'header.sticky-header .rtmega-menu-container .desktop-menu-area > .rtmega-megamenu > .menu-item > .menu-link' => 'color: {{VALUE}} !important',
						],
					]
				);					

				$this->end_controls_tab();

				$this->start_controls_tab(
					'sticky_menu_item_hover',
					[
						'label' => __( 'Hover', 'rt-mega-menu' ),
					]
				);

					$this->add_control(
						'sticky_color_menu_item_hover',
						[
							'label'     => __( 'Hover Text Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'global'    => [
								'default' => Global_Colors::COLOR_ACCENT,
							],
							'selectors' => [
								'header.sticky-header .rtmega-menu-container .desktop-menu-area > .rtmega-megamenu > .menu-item:hover > .menu-link' => 'color: {{VALUE}} !important',
							],
						]
					);					


				$this->end_controls_tab();

				$this->start_controls_tab(
					'sticky_menu_item_active',
					[
						'label' => __( 'Active', 'rt-mega-menu' ),
					]
				);

					$this->add_control(
						'sticky_color_menu_item_actve',
						[
							'label'     => __('Active Text Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'header.sticky-header .rtmega-menu-container .desktop-menu-area > .rtmega-megamenu > .menu-item.current-menu-item > .menu-link' => 'color: {{VALUE}}',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'sticky_color_bg',
				[
					'label'     => __( 'Sticky Area Bg Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default' => Global_Colors::COLOR_TEXT,
					],
					'default'   => '',
					'selectors' => [
						'header.sticky-header' => 'background: {{VALUE}} !important',
					],
				]
			);	
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'stikcy_box_shadow',				
					'selector'  => 'header.sticky-header',
					'separator' => 'after',
				]
			);

		$this->end_controls_section();

	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_dropdown_content_controls() {

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label' => __( 'Dropdown', 'rt-mega-menu' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_dropdown_item',
			[
				'label'              => __( 'Dropdown Width (px)', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'range'              => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default'            => [
					'size' => '220',
					'unit' => 'px',
				],
				'selectors'          => [						
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents):not(.rtmegamenu-contents)' => 'min-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents):not(.rtmegamenu-contents)' => 'min-width: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					
				],
				'condition'          => [
					'menu_layout' => 'horizontal',
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'dropdown_menu_align',
			[
				'label'        => __( 'Alignment', 'rt-mega-menu' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'rt-mega-menu' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'rt-mega-menu' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'rt-mega-menu' ),
						'icon'  => 'eicon-h-align-right',
					],
					
				],
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link' => 'text-align: {{VALUE}}'
				],
			]
		);


		

			$this->start_controls_tabs( 'tabs_dropdown_item_style' );

				$this->start_controls_tab(
					'tab_dropdown_item_normal',
					[
						'label' => __( 'Normal', 'rt-mega-menu' ),
					]
				);

					$this->add_control(
						'color_dropdown_item',
						[
							'label'     => __( 'Text Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) > .menu-item > .menu-link' => 'color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) > .menu-item > .menu-link' => 'color: {{VALUE}}',
							],
						]
					);
					$this->add_control(
						'bg_color_dropdown_menu_item',
						[
							'label'     => __( 'Background Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents)' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents)' => 'background-color: {{VALUE}}',
							],
							
						]
					);					

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_dropdown_item_hover',
					[
						'label' => __( 'Hover', 'rt-mega-menu' ),
					]
				);

					$this->add_control(
						'color_dropdown_item_hover',
						[
							'label'     => __( 'Hover Text Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > ul.sub-menu:not(.rtmegamenu-contents) .menu-item:hover> a 
								' => 'color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > ul.sub-menu:not(.rtmegamenu-contents) .menu-item:hover> a 
								' => 'color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > ul.sub-menu:not(.rtmegamenu-contents):after 
								' => 'border-bottom-color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > ul.sub-menu:not(.rtmegamenu-contents):after 
								' => 'border-bottom-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_dropdown_menu_item_hover',
						[
							'label'     => __( 'Hover Background Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item > ul.sub-menu:not(.rtmegamenu-contents) > .menu-item:hover > .menu-link' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item > ul.sub-menu:not(.rtmegamenu-contents) > .menu-item:hover > .menu-link' => 'background-color: {{VALUE}}',
							],
							
						]
					);				

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_dropdown_item_active',
					[
						'label' => __( 'Active', 'rt-mega-menu' ),
					]
				);

				$this->add_control(
					'color_dropdown_item_active',
					[
						'label'     => __( 'Active Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item.current-menu-item > a' => 'color: {{VALUE}}',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item.current-menu-item > a a' => 'color: {{VALUE}}',
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item.current-menu-ancestor >  a a' => 'color: {{VALUE}}',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item.current-menu-ancestor >  a a' => 'color: {{VALUE}}',

						],
					]
				);
				$this->add_control(
						'bg_color_dropdown_menu_item_active',
						[
							'label'     => __( 'Active Background Color', 'rt-mega-menu' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item.current-menu-item' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item.current-menu-item' => 'background-color: {{VALUE}}',
							],
							
						]
					);		

			
				$this->end_controls_tabs();

			$this->end_controls_tabs();
		
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'dropdown_typography',
					'separator' => 'before',
					'selector'  => '
							{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item > ul.sub-menu:not(.rtmegamenu-contents) > .menu-item > .menu-link, 
							{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item > ul.sub-menu:not(.rtmegamenu-contents) > .menu-item > .menu-link',
				]
			);
			$this->add_responsive_control(
				'dropdown_padding',
				[
					'label'              => __( 'Padding', 'rt-mega-menu' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu > .menu-item > ul.sub-menu:not(.rtmegamenu-contents)'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu > .menu-item > ul.sub-menu:not(.rtmegamenu-contents)'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'frontend_available' => true,
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'rt-mega-menu' ),
					'selector' => '
								{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents),
								{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents)',
				]
			);
			
			$this->add_responsive_control(
				'dropdown_border_radius',
				[
					'label'              => __( 'Border Radius', 'rt-mega-menu' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents)'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents)'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'frontend_available' => true,
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'dropdown_box_shadow',
					'selector'  => '
									{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents),
									{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents)',
					'separator' => 'after',
				]
			);

			$this->add_control(
				'heading_dropdown_divider',
				[
					'label'     => __( 'Dropdown Item Options', 'rt-mega-menu' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'dropdown_item_link_padding',
				[
					'label'              => __( 'Item Link Padding', 'rt-mega-menu' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'dropdown_item_border_radius',
				[
					'label'              => __( 'Item Link Border Radius', 'rt-mega-menu' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'dropdown_item_margin',
				[
					'label'              => __( 'Item Margin', 'rt-mega-menu' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'dropdown_item_padding',
				[
					'label'              => __( 'Item Padding', 'rt-mega-menu' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [ 'px', '%' ],
					'selectors'          => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'dropdown_divider_border',
				[
					'label'       => __( 'Border Style', 'rt-mega-menu' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'solid',
					'label_block' => false,
					'options'     => [
						'none'   => __( 'None', 'rt-mega-menu' ),
						'solid'  => __( 'Solid', 'rt-mega-menu' ),
						'double' => __( 'Double', 'rt-mega-menu' ),
						'dotted' => __( 'Dotted', 'rt-mega-menu' ),
						'dashed' => __( 'Dashed', 'rt-mega-menu' ),
					],
					'selectors'   => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'divider_border_color',
				[
					'label'     => __( 'Border Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#c4c4c4',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
					],
					'condition' => [
						'dropdown_divider_border!' => 'none',
					],
				]
			);

			$this->add_control(
				'dropdown_divider_width',
				[
					'label'     => __( 'Border Width', 'rt-mega-menu' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'default'   => [
						'size' => '1',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'dropdown_divider_border!' => 'none',
					],
				]
			);


			$this->add_control(
				'heading_dropdown_description',
				[
					'label'     => __( 'Dropdown Description', 'rt-mega-menu' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs( 'tabs_dropdown_item_description_style' );

			$this->start_controls_tab(
				'tab_dropdown_item_description_normal',
				[
					'label' => __( 'Normal', 'rt-mega-menu' ),
				]
			);
	
				$this->add_control(
					'color_dropdown_item_desc',
					[
						'label'     => __( 'Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#497696',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link .menu-desc' => 'color: {{VALUE}}',
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link .menu-desc' => 'color: {{VALUE}}',
						],
					]
				);				
			$this->end_controls_tab();
	
			$this->start_controls_tab(
				'tab_dropdown_item_desc_hover',
				[
					'label' => __( 'Hover', 'rt-mega-menu' ),
				]
			);
	
				$this->add_control(
					'color_dropdown_item_desc_hover',
					[
						'label'     => __( 'Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:hover> a .menu-desc' => 'color: {{VALUE}}', 
							'{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item:hover> a .menu-desc ' => 'color: {{VALUE}}',
						],
					]
				);
	
			$this->end_controls_tab();
			$this->end_controls_tabs();
		$this->end_controls_tabs();
	
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'dropdown_desc_typography',
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} .rtmega-menu-container .desktop-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link .menu-desc',
				'selector'  => '{{WRAPPER}} .rtmega-menu-container .vertical-expaned-menu-area .rtmega-megamenu .menu-item ul.sub-menu:not(.rtmegamenu-contents) .menu-item .menu-link .menu-desc'
			]
		);

		$this->end_controls_section();


		//Responsive menu icon settings

		$this->start_controls_section(
			'resonsive_menu',
			[
				'label'     => __( 'Mobile Menu', 'rt-mega-menu' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				
			]
		);
		$this->add_control(
			'mobile_menu_overlay_bg',
			[
				'label'     => __( 'Overlay Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .overlay' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_container_bg',
			[
				'label'     => __( 'Container Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'mobile_menu_container_padding',
			[
				'label'              => __( 'Container Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'mobile_menu_padding',
			[
				'label'              => __( 'Menu Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' 
				],
				'frontend_available' => true,
				'separator' => 'after'
			]
		);
		$this->add_control(
			'mobile_menu_item_styles',
			[
				'label'     => __( 'Menu Items', 'rt-mega-menu'),
				'type'      => \Elementor\Controls_Manager::HEADING,      
			]
		);
		$this->add_responsive_control(
			'padding_horizontal_mobile_menu_item',
			[
				'label'              => __( 'Horizontal Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu > .menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'padding_vertical_mobile_menu_item',
			[
				'label'              => __( 'Vertical Padding', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 50,
					],
				],
				'default' => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu > .menu-item > .menu-link' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'space_between_mobile_menu_item',
			[
				'label'              => __( 'Space Between', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'          => [
					'body:not(.rtl) {{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu > .menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
				'condition'    => [
					'menu_layout' => [ 'horizontal'],
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'right_gap_mobile_menu_item',
			[
				'label'              => __( 'Menu Item Right Gap', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px' ],
				'range'              => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu > .menu-item:not(:last-child)' => 'margin-right:{{SIZE}}{{UNIT}}',
				],
				'condition'          => [
					'menu_layout' => 'horizontal',
				],
				'frontend_available' => true,
			]
		);			

	$this->add_control(
		'style_divider_mobile_menu_item',
		[
			'type' => Controls_Manager::DIVIDER,
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name'      => 'typography_mobile_menu_item',
			'separator' => 'before',
			'selector'  => '{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item .menu-link',
		]
	);

	$this->start_controls_tabs( 'tabs_mobile_menu_item_style' );
		$this->start_controls_tab(
			'tab_mobile_menu_item_normal',
			[
				'label' => __( 'Normal', 'rt-mega-menu' ),
			]
		);

			$this->add_control(
				'color_mobile_menu_item',
				[
					'label'     => __( 'Text Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item .menu-link' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bg_color_mobile_menu_item',
				[
					'label'     => __( 'Background Color', 'rt-mega-menu' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item .menu-link' => 'background-color: {{VALUE}}',
					],
					
				]
			);

			

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_mobile_menu_item_hover',
				[
					'label' => __( 'Hover', 'rt-mega-menu' ),
				]
			);

				$this->add_control(
					'color_mobile_menu_item_hover',
					[
						'label'     => __( 'Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item:hover > .menu-link' => 'color: {{VALUE}}',
						],
					]
				);					


			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_mobile_menu_item_active',
				[
					'label' => __( 'Active', 'rt-mega-menu' ),
				]
			);

				$this->add_control(
					'color_mobile_menu_item_active',
					[
						'label'     => __( 'Text Color', 'rt-mega-menu' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item.current-menu-item > .menu-link' => 'color: {{VALUE}}',
						],
					]
				);

			
				

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_mobile_menu_item',
				'label' => esc_html__( 'Border', 'rt-mega-menu' ),
				'selector' => '{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu > .menu-item > .menu-link',
			]
		);
		

		$this->add_responsive_control(
			'border_radius_radius_mobile_menu_item',
			[
				'label'              => __( 'Border Radius', 'rt-mega-menu' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px', '%' ],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item .menu-link'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'mobile_submenu_icon_options',
			[
				'label' => esc_html__( 'Sub Menu Icon', 'rt-mega-menu' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->add_control(
			'color_parent_icon_mobile_menu',
			[
				'label'     => __( 'Icon Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-megamenu .menu-item-has-children .menu-link .menu-text .submenu-parent-icon svg' => 'fill: {{VALUE}} !important',
				],
				'separator' => 'after',
			]
		);	
					
		$this->add_control(
			'mobile_menu_toggle_styles',
			[
				'label'     => __( 'Menu Opener', 'rt-mega-menu'),
				'type'      => \Elementor\Controls_Manager::HEADING,               
				
			]
		);
		$this->add_responsive_control(
		    'mobile_menu_toggle_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rt-mega-menu' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rtmega-menu-mobile-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_responsive_control(
		    'mobile_menu_toggle_margin',
		    [
		        'label' => esc_html__( 'Margin', 'rt-mega-menu' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rtmega-menu-mobile-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'mobile_menu_toggle_border',
		        'selector' => '{{WRAPPER}} .rtmega-menu-mobile-button',
		    ]
		);
		$this->add_control(
		    'mobile_menu_toggle_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rt-mega-menu' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rtmega-menu-mobile-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->start_controls_tabs( 'tabs_toggle_style' );

		$this->start_controls_tab(
			'mobile_menu_toggle_style_normal',
			[
				'label' => __( 'Normal', 'rt-mega-menu' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label'     => __( 'Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_color_path_fill',
			[
				'label'     => __( 'SVG PATH Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button svg path' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_color_rect_fill',
			[
				'label'     => __( 'SVG RECT Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button svg rect' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_bg_color',
			[
				'label'     => __( 'Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_toggle_hover',
			[
				'label' => __( 'Hover', 'rt-mega-menu' ),
			]
		);

		$this->add_control(
			'toggle_color_hover',
			[
				'label'     => __( 'Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_color_path_fill_hover',
			[
				'label'     => __( 'SVG PATH Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button:hover svg path' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_color_rect_fill_hover',
			[
				'label'     => __( 'SVG RECT Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button:hover svg rect' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_bg_color_hover',
			[
				'label'     => __( 'Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-mobile-button:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'mobile_menu_sticky_toggle_styles',
			[
				'label'     => __( 'Menu Opener on Sticky', 'rt-mega-menu'),
				'type'      => \Elementor\Controls_Manager::HEADING,               
				
			]
		);

		$this->start_controls_tabs( 'tabs_stikcy_toggle_style' );

		$this->start_controls_tab(
			'sticky_mobile_menu_toggle_style_normal',
			[
				'label' => __( 'Normal', 'rt-mega-menu' ),
			]
		);

		$this->add_control(
			'sticky_toggle_color',
			[
				'label'     => __( 'Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header .rtmega-menu-mobile-button' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_toggle_color_path_fill',
			[
				'label'     => __( 'SVG PATH Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header .rtmega-menu-mobile-button svg path' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_toggle_color_rect_fill',
			[
				'label'     => __( 'SVG RECT Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header {{WRAPPER}} .rtmega-menu-mobile-button svg rect' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_toggle_bg_color',
			[
				'label'     => __( 'Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header .rtmega-menu-mobile-button' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'sticky_mobile_menu_toggle_hover',
			[
				'label' => __( 'Hover', 'rt-mega-menu' ),
			]
		);

		$this->add_control(
			'sticky_toggle_color_hover',
			[
				'label'     => __( 'Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header .rtmega-menu-mobile-button:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_toggle_color_path_fill_hover',
			[
				'label'     => __( 'SVG PATH Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header .rtmega-menu-mobile-button:hover svg path' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_toggle_color_rect_fill_hover',
			[
				'label'     => __( 'SVG RECT Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header {{WRAPPER}} .rtmega-menu-mobile-button:hover svg rect' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_toggle_bg_color_hover',
			[
				'label'     => __( 'Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'header.sticky-header .rtmega-menu-mobile-button:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'mobile_menu_closer_styles',
			[
				'label'     => __( 'Menu Closer', 'rt-mega-menu'),
				'type'      => \Elementor\Controls_Manager::HEADING,      
				'separator' => 'before',         
				
			]
		);
		$this->add_responsive_control(
		    'mobile_menu_closer_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rt-mega-menu' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_responsive_control(
		    'mobile_menu_closer_margin',
		    [
		        'label' => esc_html__( 'Margin', 'rt-mega-menu' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'mobile_menu_closer_border',
		        'selector' => '{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close',
		    ]
		);
		$this->add_control(
		    'mobile_menu_closer_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rt-mega-menu' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		$this->start_controls_tabs( 'tabs_mobile_menu_closer_style' );

		$this->start_controls_tab(
			'mobile_menu_closer_style_normal',
			[
				'label' => __( 'Normal', 'rt-mega-menu' ),
			]
		);

		$this->add_control(
			'mobile_menu_closer_color',
			[
				'label'     => __( 'Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_closer_color_path_fill',
			[
				'label'     => __( 'SVG PATH Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close svg path' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_closer_color_rect_fill',
			[
				'label'     => __( 'SVG RECT Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close svg rect' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_closer_bg_color',
			[
				'label'     => __( 'Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_menu_closer_hover',
			[
				'label' => __( 'Hover', 'rt-mega-menu' ),
			]
		);

		$this->add_control(
			'mobile_menu_closer_color_hover',
			[
				'label'     => __( 'Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_closer_color_path_fill_hover',
			[
				'label'     => __( 'SVG PATH Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close:hover svg path' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_closer_color_rect_fill_hover',
			[
				'label'     => __( 'SVG RECT Fill Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close:hover svg rect' => 'fill: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'mobile_menu_closer_bg_color_hover',
			[
				'label'     => __( 'Background Color', 'rt-mega-menu' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rtmega-menu-container .mobile-menu-area .rtmega-menu-mobile-sidebar .rtmega-menu-mobile-close:hover' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_mega_menu',
			[
				'label' => __( 'Mega Menu', 'rt-mega-menu' ),
			]
		);

		$this->add_responsive_control(
			'mega_menu_width',
			[
				'label'              => __( 'Mega Menu Width', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px',],
				'range'              => [
					'px' => [						
						'max' => 3000,
						'step' => 10,
					],
					
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children.rtmega_menu > .sub-menu:not(.rtmegamenu-contents)' => 'width: {{SIZE}}{{UNIT}};',
					],
			]
		);
		$this->add_responsive_control(
			'mega_menu_position_left',
			[
				'label'              => __( 'Position Left', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px', '%' ],
				'range'              => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .rtmegamenu-contents.sub-menu:not(.rtmegamenu-contents), {{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu.rtmegamenu-contents' => 'left: {{SIZE}}{{UNIT}}; width: auto;',
					],
			]
		);
		$this->add_responsive_control(
			'mega_menu_position_right',
			[
				'label'              => __( 'Position Right', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px', '%' ],
				'range'              => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .rtmegamenu-contents.sub-menu:not(.rtmegamenu-contents), {{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu.rtmegamenu-contents' => 'right: {{SIZE}}{{UNIT}}; width: auto;',
					],
			]
		);
		$this->add_responsive_control(
			'mega_menu_position_top',
			[
				'label'              => __( 'Position Top', 'rt-mega-menu' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => [ 'px', '%' ],
				'range'              => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .rtmegamenu-contents.sub-menu:not(.rtmegamenu-contents)' => 'top: {{SIZE}}{{UNIT}};',
					],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'mega_submenu_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mega_submenu_box_shadow',
				'selector' => '{{WRAPPER}} .rtmega-menu-area .desktop-menu-area ul.rtmega-megamenu .menu-item-has-children .sub-menu',
			]
		);
		$this->end_controls_section();

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- rt_mega_ prefix; intentional Elementor extensibility hook consumed by rt-mega-menu-pro.
		do_action( 'rt_mega_after_submenu_fields_el', $this );
		
		
	}

	/**
	 * Add itemprop for Navigation Schema.
	 *
	 * @since 1.5.2
	 * @param string $atts link attributes.
	 * @access public
	 */
	public function handle_link_attrs( $atts ) {

		$atts .= ' itemprop="url"';
		return $atts;
	}

	/**
	 * Add itemprop to the li tag of Navigation Schema.
	 *
	 * @since 1.6.0
	 * @param string $value link attributes.
	 * @access public
	 */
	public function handle_li_values( $value ) {

		$value .= ' itemprop="name"';
		return $value;
	}

	/**
	 * Get the menu and close icon HTML.
	 *
	 * @since 1.5.2
	 * @param array $settings Widget settings array.
	 * @access public
	 */
	public function get_menu_close_icon( $settings ) {
		$menu_icon     = '';
		$close_icon    = '';
		$icons         = [];
		$icon_settings = [
			$settings['dropdown_icon'],
			$settings['dropdown_close_icon'],
		];

		foreach ( $icon_settings as $icon ) {
			if ( $this->is_elementor_updated() ) {
				ob_start();
				\Elementor\Icons_Manager::render_icon(
					$icon,
					[
						'aria-hidden' => 'true',
						'tabindex'    => '0',
					]
				);
				$menu_icon = ob_get_clean();
			} else {
				$menu_icon = '<i class="' . esc_attr( $icon ) . '" aria-hidden="true" tabindex="0"></i>';
			}

			array_push( $icons, $menu_icon );
		}

		return $icons;
	}

	/**
	 * Render Nav Menu output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function render() { 
		

		$settings = $this->get_settings_for_display();	
		$class_responsvie =  !empty($settings['enable_mobile_menu_view']) == 'yes' ? 'enabled-mobile-menu': 'enabled-desktop-menu';
		$class_responsvie .=  !empty($settings['menu_layout']) == 'vertical' ? ' enabled-vertical-menu': '';
		$class_responsvie .=  !empty($settings['mobile_menu']) ? ' has-different-mobile-menu': '';
		$menu_layout = $settings['menu_layout'];

		// Vertical Menu Left & Right Icon 
		$menu_arrow_vertical = ($settings['enable_vertical_menu_arrow'] == 'yes') ? 'rt-mega-arrow-add' : '';
		
		$menu_arrow_vertical_right = ($settings['enable_vertical_menu_arrow'] == 'yes' && $settings['enable_vertical_menu_arrow_right'] == 'yes') ? 'rt-mega-arrow-add-right' : '';
		$menu_arrow_vertical_left = ($settings['enable_vertical_menu_arrow'] == 'yes' && $settings['enable_vertical_menu_arrow_right'] != 'yes') ? 'rt-mega-arrow-add-left' : '';

		$menu_arrow_vertical_custom = '';
		if ( $settings['vertical_menu_arrow_type'] === 'verticla_custom_menu_icon' && !empty($settings['vertical_menu_custom_icon']) ) {
			ob_start();
			echo '<span class="vertical_menu_custom_icon">';
				\Elementor\Icons_Manager::render_icon( $settings['vertical_menu_custom_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
			$menu_arrow_vertical_custom = ob_get_clean();
		}

		$menu_arrow_vertical_type = '';
		if ( $settings['enable_vertical_menu_arrow'] == 'yes' && isset($settings['vertical_menu_arrow_type']) ) {
			if ( $settings['vertical_menu_arrow_type'] === 'rtmega-single-arrow' ) {
				$menu_arrow_vertical_type = 'rtmega-single-arrow';
			}elseif( $settings['vertical_menu_arrow_type'] === 'rtmega-double-arrow' ) {
				$menu_arrow_vertical_type = 'rtmega-double-arrow';
			}else{
				$menu_arrow_vertical_type = 'rtmega-custom-icon';
			}
		}
		// End Vertical Menu Left & Right Icon 

		$rtmega_mobile_menu_html = '';
		$menu_expand_position = $settings['vertical_menu_expand_position'];
		$menu_expand_position_class = ' expand-position-' . $settings['vertical_menu_expand_position'];
		$menu_expand_overlay_position_class = ' expand-overlay-position-' . $settings['vertical_menu_expand_overlay_position'];

		

		$custom_logo_id = get_theme_mod('custom_logo');
		$logo_url = wp_get_attachment_image_src($custom_logo_id, 'full');

		$unique_id = uniqid();

			if($settings['menu_layout'] == 'vertical' && $settings['vertical_menu_expand_mode'] == 'click'){
				if (!empty($settings['vertical_menu_tops'])) {
					?>
					<span class="rtmega-menu-top-cls rtmega-menu-top-style-cls <?php echo esc_attr($menu_expand_position_class); ?>"> 
						<?php \Elementor\Icons_Manager::render_icon( $settings['vertical_menu_tops'], [ 'aria-hidden' => 'true' ] ); ?> 
					</span>
					<?php
				}
			}

				$menus = $this->get_available_menus();
				if ( empty( $menus ) ) {
					// get 
				}
				// Sub Menu Icon 			
				if($settings['submenu_icon_style'] == 'icon2'){
                    $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>';
                }
                elseif($settings['submenu_icon_style'] == 'icon3'){
                    $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>';
                }else{
                    $submenu_parent_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
                }

				// Vertical Menu Icon 	
				if($settings['vertical_active_menu_style'] == 'icon2'){
					$active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>';
				}
				elseif($settings['vertical_active_menu_style'] == 'icon3'){
					$active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>';
				}else{
					$active_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 338.7 54.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>';
				}

			
				// Mobile Menu
				if($settings['enable_mobile_menu_view'] == 'yes'){
					$mobile_menu_open_position = $settings['mobile_menu_open_position'];
					$mobile_menu_open_position_class = ' position-' . $settings['mobile_menu_open_position'];
					$rtmega_mobile_menu_html = '<div class="mobile-menu-area '.$unique_id.'">
					<div class="overlay" onclick="closeRTMEGAmobile()"></div>
					<div class="rtmega-menu-mobile-sidebar '.$mobile_menu_open_position_class.'">
						<button type="button" class="rtmega-menu-mobile-close" onclick="closeRTMEGAmobile()" aria-label="Close Menu"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M317.7 402.3c3.125 3.125 3.125 8.188 0 11.31c-3.127 3.127-8.186 3.127-11.31 0L160 267.3l-146.3 146.3c-3.127 3.127-8.186 3.127-11.31 0c-3.125-3.125-3.125-8.188 0-11.31L148.7 256L2.344 109.7c-3.125-3.125-3.125-8.188 0-11.31s8.188-3.125 11.31 0L160 244.7l146.3-146.3c3.125-3.125 8.188-3.125 11.31 0s3.125 8.188 0 11.31L171.3 256L317.7 402.3z"/></svg></button>
						<div class="rtmega-menu-mobile-navigation"><ul id="%1$s" class="%2$s">%3$s</ul></div>
						</div>
					</div>';
				}			
				
				// Vertical Expaned Menu
				if ($settings['menu_layout'] == 'vertical' && $settings['vertical_menu_expand_mode'] == 'click') {
					$custom_logo = '';
				    if (!empty($settings['logo__image']['url'])) {
				        $custom_logo = '<li class="rtmega-custom-logo"><a href="'.get_home_url().'"><img src="' . esc_url($settings['logo__image']['url']) . '" alt="Custom Logo"></a></li>';
				    }
				    $rtmega_vetical_menu_html = '<div class="vertical-expaned-menu-area ' . $unique_id . ' vertical-expaned-menu-area-' . $menu_expand_position . '">
				        <div class="rtmega-menu-vertical-expanded ' .$menu_expand_position_class .$menu_expand_overlay_position_class. '">
				            <div class="rtmega-menu-mobile-navigation '. $menu_arrow_vertical .' '. $menu_arrow_vertical_type .' '.$menu_arrow_vertical_right.''.$menu_arrow_vertical_left.'"> 
				                <ul id="%1$s" class="%2$s">
				                    ' . $custom_logo . '
				                    %3$s
				                </ul> 
				            </div>
				        </div>                            
				    </div>';
				}

			
				if($settings['menu_layout'] == 'vertical' && $settings['vertical_menu_expand_mode'] == 'always_expand'){
					$rtmega_vetical_menu_html = '<div class="vertical-expaned-menu-area '.$unique_id.' vertical-expaned-menu-area-'.$menu_expand_position.'">
						<div class="rtmega-menu-vertical-always-expanded rtmega-menu-vertical-expanded opened '. $menu_expand_position_class .'">
							<div class="rtmega-menu-mobile-navigation '. $menu_arrow_vertical .' '. $menu_arrow_vertical_type .' '. $menu_arrow_vertical_right.''.$menu_arrow_vertical_left.'"><ul id="%1$s" class="%2$s">%3$s</ul></div>
							</div>
						</div>';
				}	
				
				// Vertical Hover Submenu Position 
				$vertical_menu_submenu_expad_mode_type ='';
				if ($settings['vertical_menu_submenu_expad_mode'] == 'hover') {
					$vertical_menu_submenu_expad_mode_type = 'vertical-submenu-position-'.$settings['vertical_menu_submenu_expad_mode_type'];
				}
				// Desktop Menu
				$desktop_menu_wrap = '<div class="desktop-menu-area"><ul id="%1$s" class="%2$s">%3$s</ul></div>';
				
				if(!empty($settings['mobile_menu'])){
					$items_wrap = $desktop_menu_wrap;
				}else{
					$items_wrap = $desktop_menu_wrap.$rtmega_mobile_menu_html;
				}

				if($settings['menu_layout'] == 'vertical'){
					$items_wrap = $rtmega_vetical_menu_html;
				}

				$resolved_menu = $settings['menu'];
				if ( empty( $resolved_menu ) ) {
					$preferred_locations = [ 'primary', 'primary-menu', 'primary_menu', 'main', 'main-menu', 'main_menu' ];
					$nav_locations = get_nav_menu_locations();
					foreach ( $preferred_locations as $loc ) {
						if ( ! empty( $nav_locations[ $loc ] ) ) {
							$resolved_menu = $nav_locations[ $loc ];
							break;
						}
					}
					if ( empty( $resolved_menu ) ) {
						$all_menus = wp_get_nav_menus();
						if ( ! empty( $all_menus ) ) {
							$resolved_menu = $all_menus[0]->term_id;
						}
					}
				}

				$args = [
					'echo'        => false,
					'menu'        => $resolved_menu,
					'fallback_cb' => '__return_empty_string',
					'menu_class'      => 'menu desktop-menu rtmega-megamenu vertical-submenu-expand-mode-'.$settings['vertical_menu_submenu_expad_mode'] . ' ' .$menu_layout.' '.$vertical_menu_submenu_expad_mode_type,
					'container_class'	=> 'rtmega-elelmentor-widget menu-wrapper rtmega-menu-container rtmega-menu-area '.$class_responsvie,
					'vertical_menu_active_icon' => $active_icon,
					'submenu_parent_icon' => $submenu_parent_icon,
					'menu_layout'		  => $settings['menu_layout'],
					'items_wrap'      => $items_wrap,
					'pointer_hover_effect' => $settings['pointer_menu_item'],
					'is_mobile_menu'	=> '',
					'menu_arrow_vertical_custom' => $menu_arrow_vertical_custom,
					'walker'          	=> new RTMEGA_Nav_Walker()
				];

					echo wp_nav_menu( $args );
					if( !empty($settings['mobile_menu'])){
						$only_mobile_menu_args = $args;
						$only_mobile_menu_args['items_wrap'] = $rtmega_mobile_menu_html;
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo apply_filters( 'rtmega_mobile_menu_render', '', $settings, $only_mobile_menu_args );
					}
					

					if($settings['vertical_menu_expand_mode'] == 'click'){
						
						?>
						<div class="rtmega-menu-area rtmega-menu-vertical-expand-button-wrapper enabled-vertical-menu vertical-menu-button-<?php echo esc_attr($menu_expand_position); ?>">
							
							<?php
							if($settings['vertical_menu_top_icon']['value']){ ?>
								<button class="rtmega-menu-mobile-button" widget_id='<?php echo esc_attr( $unique_id )?>'>
									<?php \Elementor\Icons_Manager::render_icon( $settings['vertical_menu_top_icon'], [ 'aria-hidden' => 'true' ]); ?>
								</button>
							<?php } else {
								if(!empty($settings['vertical_menu_btn_icon']['value'])){
									?>
									<button class="rtmega-menu-mobile-button" widget_id='<?php echo esc_attr( $unique_id )?>'>
									<?php \Elementor\Icons_Manager::render_icon( $settings['vertical_menu_btn_icon'], [ 'aria-hidden' => 'true' ]); ?>
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
					}
					
					

					if($settings['enable_mobile_menu_view'] == 'yes'){
						?>
						<div class="rtmega-menu-area rtmega-menu-mobile-button-wrapper enabled-mobile-menu">							
								<?php
								if(!empty($settings['menu_btn_icon']['value'])){
									?>
									<button class="rtmega-menu-mobile-button" onclick="openRTMEGAmobile()" aria-label="Open Menu">										
									<?php \Elementor\Icons_Manager::render_icon( $settings['menu_btn_icon'], [ 'aria-hidden' => 'true' ]); ?>
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

					if($settings['enable_sticky_header'] == 'yes'){
						$enable_backscroll_header_top = $settings['enable_backscroll_header_top'];
						if ( $enable_backscroll_header_top == 'yes' ) { ?>						
							<script>
							    (function($) {
							        var header = $('header');
							        var page = $('#page');
							        var topbar = $('.rt-topbar-hide');
							        header.addClass("sticky-header-on");
							        header.addClass("rt-mega-up-scroll-hide");
							        function updatePaddingAndMargin() {
							            var headerHeight = header.outerHeight();
							            var topbarHeight = topbar.length ? topbar.outerHeight() : 0;

							            if (header.length && page.length) {
								            if (!header.hasClass('fixed-header')) {
						                        page.css('padding-top', headerHeight + 'px');
						                    } else {
						                        page.css('padding-top', '');
						                    }
						                }
							           	
							           	if (header.length) {
								            if (header.hasClass('rt-mega-up-scroll-hide')) {
								                header.css('margin-top', `-${topbarHeight}px`);
								            } else {
								                header.css('margin-top', '0px');
								            }
								        }
							        }

							        if ($('.sticky-header-on').length) {
							            let lastScroll = 0;

							            function sticky_header() {
							                var headerHeight = header.innerHeight();
							                let scroll = $(window).scrollTop();
							        
							                if (scroll > headerHeight ) {
							                    header.addClass('sticky-header');
							                } else {
							                    header.removeClass('sticky-header');
							                }

							                if (scroll > headerHeight ) {
							                    header.addClass('rt-mega-up-scroll-hide');
							                } else {
							                    header.removeClass('rt-mega-up-scroll-hide');
							                }

							                if (scroll > headerHeight && scroll > lastScroll) {
							                    header.addClass('sticky-headers');
							                } else if (scroll < lastScroll) {
							                    header.removeClass('sticky-headers');
							                }
							                lastScroll = scroll;
							                updatePaddingAndMargin();
							            }

							            $(document).ready(() => {
							                updatePaddingAndMargin();
							                sticky_header();
							            });

							            window.onload = () => {
							                updatePaddingAndMargin();
							                sticky_header();
							            };

							            $(window).on('scroll resize', () => {
							                sticky_header();
							                updatePaddingAndMargin();
							            });
							        }

							    })(jQuery);
							</script>
						<?php } else {
						?>
							<script>
							    (function($) {
							        var header = $('header');
							        var page = $('#page');
							        var topbar = $('.rt-topbar-hide');
							        header.addClass("sticky-header-on");
							        function updatePaddingAndMargin() {
							            var headerHeight = header.outerHeight();
							            var topbarHeight = topbar.length ? topbar.outerHeight() : 0;

							            if (header.length && page.length) {
								            if (!header.hasClass('fixed-header')) {
						                        page.css('padding-top', headerHeight + 'px');
						                    } else {
						                        page.css('padding-top', '');
						                    }
						                }
							           	
							           	if (header.length) {
								            if (header.hasClass('sticky-headers')) {
								                header.css('margin-top', `-${topbarHeight}px`);
								            } else {
								                header.css('margin-top', '0px');
								            }
								        }
							        }

							        if ($('.sticky-header-on').length) {
							            let lastScroll = 0;

							            function sticky_header() {

							                var headerHeight = header.innerHeight();
							                let scroll = $(window).scrollTop();

							                if (scroll > headerHeight ) {
							                    header.addClass('sticky-header');
							                } else {
							                    header.removeClass('sticky-header');
							                }				                 

							                if (scroll > headerHeight && scroll > lastScroll) {
							                    header.addClass('sticky-headers');
							                } else if (scroll < lastScroll) {
							                    header.removeClass('sticky-headers');
							                }

							                lastScroll = scroll;
							                updatePaddingAndMargin();
							            }

							            $(document).ready(() => {
							                updatePaddingAndMargin();
							                sticky_header();
							            });

							            window.onload = () => {
							                updatePaddingAndMargin();
							                sticky_header();
							            };

							            $(window).on('scroll resize', () => {
							                sticky_header();
							                updatePaddingAndMargin();
							            });
							        }

							    })(jQuery);
							</script>
						<?php
						}
					}
				}		
}