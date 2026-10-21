<?php
/**
 * Pricing table widget class
 *
 */
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class ReacTheme_Elementor_Pricing_Table_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve rsgallery widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'rt-price-table';
    }   

  
    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Pricing Table', 'rtelements' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'glyph-icon flaticon-price';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'pricing', 'table', 'package', 'product', 'plan' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'section_price__style',
			[
				'label' => esc_html__( 'Style', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pricing__style',
			[
				'label'   => esc_html__( 'Select Style', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'rtelements')
				],
			]
		);
        $this->end_controls_section();


		$this->start_controls_section(
			'_section_header',
			[
				'label' => esc_html__( 'Header', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__( 'Basic', 'rtelements' ),
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__( '', 'rtelements' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_icon',
            [
                'label' => esc_html__( 'Icon/Image', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );        

        $this->start_controls_tabs(
            'style_tabs_icon'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Icon', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Select Icon', 'rtelements' ),
                'type' => Controls_Manager::ICON,
                'options' => rsaddon_pro_get_icons(),                         
            ]
        );       

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Image', 'rtelements' ),
            ]
        );

        $this->add_control(
            'selected_image',
            [
                'label' => esc_html__( 'Choose Image', 'rtelements' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );      

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_pricing',
            [
                'label' => esc_html__( 'Pricing', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'currency',
            [
                'label' => esc_html__( 'Currency', 'rtelements' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    '' => esc_html__( 'None', 'rtelements' ),
                    'baht' => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'rtelements' ),
                    'bdt' => '&#2547; ' . _x( 'BD Taka', 'Currency Symbol', 'rtelements' ),
                    'dollar' => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'rtelements' ),
                    'euro' => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'rtelements' ),
                    'franc' => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'rtelements' ),
                    'guilder' => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'rtelements' ),
                    'krona' => 'kr ' . _x( 'Krona', 'Currency Symbol', 'rtelements' ),
                    'lira' => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'rtelements' ),
                    'peseta' => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'rtelements' ),
                    'peso' => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'rtelements' ),
                    'pound' => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'rtelements' ),
                    'real' => 'R$ ' . _x( 'Real', 'Currency Symbol', 'rtelements' ),
                    'ruble' => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'rtelements' ),
                    'rupee' => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'rtelements' ),
                    'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'rtelements' ),
                    'shekel' => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'rtelements' ),
                    'won' => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'rtelements' ),
                    'yen' => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'rtelements' ),
                    'custom' => esc_html__( 'Custom', 'rtelements' ),
                ],
                'default' => 'dollar',
            ]
        );

        $this->add_control(
            'currency_custom',
            [
                'label' => esc_html__( 'Custom Symbol', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'currency' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__( 'Price', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'default' => '11.19',
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => esc_html__( 'Period', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Per Month', 'rtelements' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_features',
            [
                'label' => esc_html__( 'Features', 'rtelements' ),
            ]
        );

        $this->add_control(
            'features_title',
            [
                'label' => esc_html__( 'Features Description', 'rtelements' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Features Description', 'rtelements' ),
                'separator' => 'after',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Exciting Feature', 'rtelements' ),
            ]
        );
        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'rt rt-check',
                    'library' => 'rt-icon',
                ],
            ]
        );

        $this->add_control(
            'features_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'default' => [
                    [
                        'text' => esc_html__( 'Social media advertising', 'rtelements' ),
                        'icon' => 'rt rt-check',
                    ],
                    [
                        'text' => esc_html__( 'Report analytics', 'rtelements' ),
                        'icon' => 'rt rt-check',
                    ],
                    [
                        'text' => esc_html__( 'Keyword research', 'rtelements' ),
                        'icon' => 'rt rt-check',
                    ],
                    [
                        'text' => esc_html__( 'Content strategy', 'rtelements' ),
                        'icon' => 'rt rt-check',
                    ],
                    [
                        'text' => esc_html__( 'Premium consulting', 'rtelements' ),
                        'icon' => 'rt rt-check',
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_footer',
            [
                'label' => esc_html__( 'Footer', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Subscribe', 'rtelements' ),
                'placeholder' => esc_html__( 'Type button text here', 'rtelements' ),
                'label_block' => false,
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'rtelements' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'https://example.com/', 'rtelements' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );       

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_badge',
            [
                'label' => esc_html__( 'Badge', 'rtelements' ),
            ]
        );

        $this->add_control(
            'show_badge',
            [
                'label' => esc_html__( 'Show', 'rtelements' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'rtelements' ),
                'label_off' => esc_html__( 'Hide', 'rtelements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

      
        $this->add_control(
            'badge_text',
            [
                'label' => esc_html__( 'Badge Text', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Popular', 'rtelements' ),
                'placeholder' => esc_html__( 'Type badge text', 'rtelements' ),
                'condition' => [
                    'show_badge' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
 

    
        $this->start_controls_section(
            '_section_style_general',
            [
                'label' => esc_html__( 'General', 'rtelements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'rtelements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'rtelements' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'rtelements' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'rtelements' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'rtelements' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}  .elementor-widget-container' => 'text-align: {{VALUE}}'
                ]
            ]
        );



        $this->add_responsive_control(
            'general_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_responsive_control(
            'general_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        $this->start_controls_tabs( '_tabs_general' );

        $this->start_controls_tab(
            'general_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-title,'
                    . '{{WRAPPER}} .rt-pricing-table-currency,'
                    . '{{WRAPPER}}  .rt-pricing-table-period,'
                    . '{{WRAPPER}} .rt-pricing-table-features-title,'
                    . '{{WRAPPER}} .rt-pricing-table-features-list li,'
                    . '{{WRAPPER}} .rt-pricing-table-price-text' => 'color: {{VALUE}} !important ;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_color',
                'label' => esc_html__( 'Background', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'general_border',
				'selector' => '{{WRAPPER}} .rt-price-table',
			]
		);
        
        $this->add_responsive_control(
            'general_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'general_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .rt-price-table'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'general_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        );

        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__( 'Text Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-title,'
                    . '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-currency,'
                    . '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-period,'
                    . '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-features-title,'
                    . '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-features-list li,'
                    . '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-price-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_hover_color',
                'label' => esc_html__( 'Background', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'general_hover_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover'
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();       


        $this->start_controls_section(
            '_section_style_icon',
            [
                'label' => esc_html__( 'Icon/Image', 'rtelements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );       
        

        $this->start_controls_tabs( '_tabs_icon' );

        $this->start_controls_tab(
            'icon_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        ); 

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rt-pricing-table-features-list li svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_bg',
                'label' => esc_html__( 'Hover Background', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-pricing-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        ); 

        $this->add_responsive_control(
            'icon_hover_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_hover_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_hover_bg',
                'label' => esc_html__( 'Hover Background', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            '_heading_icon_inner',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Icon Inner Part', 'rtelements' ),
            ]
        ); 

        $this->add_responsive_control(
            'icon_width',
            [
                'label' => esc_html__( 'Icon Width', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'width: {{SIZE}}{{UNIT}};',
                ],               
            ]
        );

        $this->add_responsive_control(
            'icon_height',
            [
                'label' => esc_html__( 'Icon Height', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'height: {{SIZE}}{{UNIT}};',
                ],                
            ]
        ); 

        $this->add_responsive_control(
            'icon_line_height',
            [
                'label' => esc_html__( 'Line Height', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],                
            ]
        );

        $this->start_controls_tabs( '_tabs_icon_inner' );

        $this->start_controls_tab(
            'icon_inner_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_inner_bg',
                'label' => esc_html__( 'Icon Background', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-pricing-icon  i',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_inner_border',
                'selector' => '{{WRAPPER}} .rt-pricing-icon i',
            ]
        );

        $this->add_responsive_control(
            'icon_inner_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_inner_top',
            [
                'label' => esc_html__( 'Top Position', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_left_position',
            [
                'label' => esc_html__( 'Left/Right Position', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_left_transform',
            [
                'label' => esc_html__( 'Transform Left/Right', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'transform: translateX({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_inner_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon  i ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_inner_hover_bg',
                'label' => esc_html__( 'Icon Hover Background', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon i',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_inner_hover_border',
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon i',
            ]
        );

        $this->add_responsive_control(
            'icon_inner_hover_border_radius',
            [
                'label' => esc_html__( 'Hover Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_hover_left_position',
            [
                'label' => esc_html__( 'Hover Left Position', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon i' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_hover_left_transform',
            [
                'label' => esc_html__( 'Hover Transform Left/Right', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-icon i' => 'transform: translateX({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();   

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Size', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],                
            ]
        );


        $this->add_responsive_control(
            'icon_bottom_spacing',
            [
                'label' => esc_html__( 'Icon Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 3,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon' => 'margin-bottom: {{SIZE}}{{UNIT}} ;',
                ],                
            ]
        );

       
        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Image Width', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon img' => 'width: {{SIZE}}{{UNIT}};',
                ],               
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Image Height', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-icon img' => 'height: {{SIZE}}{{UNIT}};',
                ],                
            ]
        );                    

        $this->end_controls_section();  

        $this->start_controls_section(
            '_section_style_header',
            [
                'label' => esc_html__( 'Header', 'rtelements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => esc_html__( 'Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_header' );

        $this->start_controls_tab(
            'header_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_bg',
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-pricing-table-title',
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .rt-pricing-table-title',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_shadows',
				'selector' => '{{WRAPPER}} .rt-pricing-table-title',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'header_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_hover_bg',
                'label' => esc_html__( 'Hover Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-title',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .rt-pricing-table-title',
              
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .rt-pricing-table-title',
            ]
        );

        $this->add_control(
			'subtitle_styles',
			[
				'label' => esc_html__( 'Subtitle', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-subtitle' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .rt-pricing-table-subtitle',
			]
		);
        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            '_section_style_pricing',
            [
                'label' => esc_html__( 'Pricing', 'rtelements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pricing_inline',
            [
                'label' => esc_html__( 'Display Inline', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'display-inline' => esc_html__( 'Enable', 'rtelements' ),
                    '' => esc_html__( 'Disable', 'rtelements' ),
                ],
            ]
        );

        $this->add_control(
            '_heading_price',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Price', 'rtelements' ),
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_spacing',
            [
                'label' => esc_html__( 'Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_pricing' );

        $this->start_controls_tab(
            'pricing_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__( 'Price Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-price-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_bg',
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-pricing-table-price',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'pricing_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'price_hover_color',
            [
                'label' => esc_html__( 'Price Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-price-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'price_hover_bg',
                'label' => esc_html__( 'Hover Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-price',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .rt-pricing-table-price-text',
            ]
        );

        $this->add_control(
            '_heading_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Currency', 'rtelements' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'currency_spacing',
            [
                'label' => esc_html__( 'Side Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-currency' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'currency_color',
            [
                'label' => esc_html__( 'Currency Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'currency_hover_color',
            [
                'label' => esc_html__( 'Currency Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'currency_typography',
                'selector' => '{{WRAPPER}} .rt-pricing-table-currency',
            ]
        );

        $this->add_control(
            '_heading_period',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Period', 'rtelements' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'period_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label' => esc_html__( 'Period Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'period_hover_color',
            [
                'label' => esc_html__( 'Period Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'period_typography',
                'selector' => '{{WRAPPER}} .rt-pricing-table-period',
            ]
        );

        $this->add_control(
            '_heading_separator',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Separator', 'rtelements' ),
                'separator' => 'before',
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_height',
            [
                'label' => esc_html__( 'Height', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period::before' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_width',
            [
                'label' => esc_html__( 'Width', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period::before' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_spacing_left',
            [
                'label' => esc_html__( 'Left Position', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period::before' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_spacing_top',
            [
                'label' => esc_html__( 'Top Position', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period::before' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label' => esc_html__( 'Separator Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-period::before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->add_control(
            'seperator_hover_color',
            [
                'label' => esc_html__( 'Separator Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-period::before' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pricing_inline' => 'display-inline'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => esc_html__( 'Features', 'rtelements' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( '_tabs_features' );

        $this->start_controls_tab(
            'features_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        ); 

        $this->add_responsive_control(
            'features_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'features_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'features_container_spacing',
            [
                'label' => esc_html__( 'Container Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-body' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'features_bg_color',
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-pricing-table-body',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'features_border',
                'selector' => '{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list',
            ]
        );

        $this->add_control(
            'features_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'features_box_shadow',
                'selector' => '{{WRAPPER}} .rt-pricing-table-body',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'features_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        ); 

        $this->add_responsive_control(
            'features_hover_padding',
            [
                'label' => esc_html__( 'Hover Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'features_hover_container_spacing',
            [
                'label' => esc_html__( 'Hover Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-body' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'features_hover_bg_color',
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-body',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'features_hover_border',
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-body',
            ]
        );

        $this->add_control(
            'features_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'features_hover_box_shadow',
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-body',
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            '_heading_features_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'Title', 'rtelements' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'features_title_spacing',
            [
                'label' => esc_html__( 'Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-features-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'features_title_color',
            [
                'label' => esc_html__( 'Feature Title Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-features-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'features_title_hover_color',
            [
                'label' => esc_html__( 'Feature Title Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-features-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_title_typography',
                'selector' => '{{WRAPPER}} .rt-pricing-table-features-title',
            ]
        );

        $this->add_control(
            'features_icon_color',
            [
                'label' => esc_html__( 'Feature Active Icon Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list li.active i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list li.active svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
			'features_icon_size',
			[
				'label' => esc_html__( 'Icon Width', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list li.active i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list li.active svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'features_right_icon',
			[
				'label' => esc_html__( 'Icon Right Spacing', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list li.active i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rt-pricing-table-body .rt-pricing-table-features-list li.active svg' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            '_heading_features_list',
            [
                'type' => Controls_Manager::HEADING,
                'label' => esc_html__( 'List', 'rtelements' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'features_list_padding',
            [
                'label' => esc_html__( 'List Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-features-list > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'features_list_spacing',
            [
                'label' => esc_html__( 'Spacing Between', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-features-list > li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'features_list_top_margin',
            [
                'label' => esc_html__( 'List Top Gap', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-features-list' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_list' );

        $this->start_controls_tab(
            'list_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'features_list_color',
            [
                'label' => esc_html__( 'List Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-features-list > li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'features_list_bg',
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-pricing-table-features-list > li',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'feature_list_border',
                'selector' => '{{WRAPPER}} .rt-pricing-table-features-list li',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        ); 

        $this->add_control(
            'features_list_hover_color',
            [
                'label' => esc_html__( 'List Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-features-list > li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'features_list_hover_bg',
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-features-list > li',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'feature_list_hover_border',
                'selector' => '{{WRAPPER}} .rt-pricing-table-features-list li',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_list_typography',
                'selector' => '{{WRAPPER}} .rt-pricing-table-features-list > li',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_footer',
            [
                'label' => esc_html__( 'Footer', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'btn_top_space',
            [
                'label' => esc_html__( 'Button Top Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-btn' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],               
            ]
        );
       
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .price-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .price-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .price-btn',
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( '_tabs_button' );

        $this->start_controls_tab(
            '_tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Text Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .price-btn',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .price-btn',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .price-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .price-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .price-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_hover_bg_color',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .price-btn:hover',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_hover_border',
                'selector' => '{{WRAPPER}} .price-btn:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .price-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .price-btn:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        
       
        $this->end_controls_section();    

        $this->start_controls_section(
            '_section_style_badge',
            [
                'label' => esc_html__( 'Badge', 'rtelements' ),
                'tab'   => Controls_Manager::TAB_STYLE,                
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->start_controls_tabs( '_tabs_badge' );

        $this->start_controls_tab(
            '_tab_badge_normal',
            [
                'label' => esc_html__( 'Normal', 'rtelements' ),
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'badge_color',
            [
                'label' => esc_html__( 'Badge Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-badge' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'badge_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-badge' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'selector' => '{{WRAPPER}} .rt-pricing-table-badge',
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-pricing-table-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_box_shadow',
                'selector' => '{{WRAPPER}} .rt-pricing-table-badge',
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'label' => esc_html__( 'Typography', 'rtelements' ),
                'selector' => '{{WRAPPER}} .rt-pricing-table-badge',
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            '_tab_badge_hover',
            [
                'label' => esc_html__( 'Hover', 'rtelements' ),
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'badge_hover_color',
            [
                'label' => esc_html__( 'Badge Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-badge' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'badge_hover_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-badge' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_hover_border',
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-badge',
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_hover_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_hover_box_shadow',
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-badge',
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_hover_typography',
                'label' => esc_html__( 'Typography', 'rtelements' ),
                'selector' => '{{WRAPPER}} .rt-price-table:hover .rt-pricing-table-badge',
                
                'condition' => [
                    'show_badge' => 'yes'
                ],
            ]
        );         

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


    }

    private static function get_currency_symbol( $symbol_name ) {
        $symbols = [
            'baht' => '&#3647;',
            'bdt' => '&#2547;',
            'dollar' => '&#36;',
            'euro' => '&#128;',
            'franc' => '&#8355;',
            'guilder' => '&fnof;',
            'indian_rupee' => '&#8377;',
            'pound' => '&#163;',
            'peso' => '&#8369;',
            'peseta' => '&#8359',
            'lira' => '&#8356;',
            'ruble' => '&#8381;',
            'shekel' => '&#8362;',
            'rupee' => '&#8360;',
            'real' => 'R$',
            'krona' => 'kr',
            'won' => '&#8361;',
            'yen' => '&#165;',
        ];

        return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'badge_text', 'class',
            [
                'rt-pricing-table-badge',                
            ]
        );

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'rt-pricing-table-title' );

        $this->add_inline_editing_attributes( 'price', 'none' );
        $this->add_render_attribute( 'price', 'class', 'rt-pricing-table-price-text' );

        $this->add_inline_editing_attributes( 'period', 'none' );
        $this->add_render_attribute( 'period', 'class', 'rt-pricing-table-period' );

        $this->add_inline_editing_attributes( 'features_title', 'basic' );
        $this->add_render_attribute( 'features_title', 'class', 'rt-pricing-table-features-title' );

        $this->add_inline_editing_attributes( 'button_text', 'none' );
        $this->add_render_attribute( 'button_text', 'class', 'rt-pricing-table-btn' );

        $this->add_render_attribute( 'button_text', 'href', esc_url( $settings['button_link']['url'] ) );
        if ( ! empty( $settings['button_link']['is_external'] ) ) {
            $this->add_render_attribute( 'button_text', 'target', '_blank' );
        }
        if ( ! empty( $settings['button_link']['nofollow'] ) ) {
            $this->add_render_attribute( 'button_text', 'rel', 'nofollow' );
        }

        if ( $settings['currency'] === 'custom' ) {
            $currency = $settings['currency_custom'];
        } else {
            $currency = self::get_currency_symbol( $settings['currency'] );
        }
        if ( $settings['pricing__style'] === 'style2' ) {
            $styleClass = ' rt-pricingt-'.$settings['pricing__style'];
        } else {
            $styleClass = '';
        }
        ?>
        
        <?php 
        if($settings['pricing__style'] == 'style1'){ ?>

        <div class="rt-price-table<?php echo esc_attr( $styleClass);?>"> 
          <?php if( !empty($settings['selected_icon']) || !empty($settings['selected_image']['url'])) : ?>
              <div class="rt-pricing-icon">
                   <?php if ( $settings['selected_icon'] ) : ?>
                      <i class="fa <?php echo esc_html($settings['selected_icon']);?>"></i>
                  <?php endif; ?>

                   <?php if ( $settings['selected_image']['url'] ) : ?>
                     <img src="<?php echo esc_url($settings['selected_image']['url']);?>"  alt="<?php echo esc_url($settings['selected_image']['url']);?>" />
                  <?php endif; ?>
              </div>
          <?php endif; ?>

          <div class="rt-pricing-table-header">
              <?php if ( $settings['title'] ) : ?>
                  <h4 <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo esc_html($settings['title']); ?></h4>
              <?php endif; ?>

              <?php if ( $settings['sub_title'] ) : ?>
                  <p class="rt-pricing-table-subtitle"><?php echo esc_html($settings['sub_title']); ?></p>
              <?php endif; ?>

          </div>
          <div class="rt-pricing-table-body">

              <div class="rt-pricing-table-price <?php echo esc_attr($settings['pricing_inline']); ?>">
                  <div class="rt-pricing-table-price-tag">
                      <span class="rt-pricing-table-currency"><?php echo esc_html( $currency ); ?></span>
                       
                      <span <?php $this->print_render_attribute_string( 'price' ); ?>><?php echo esc_html($settings['price']); ?></span><span <?php $this->print_render_attribute_string( 'period' ); ?>><?php echo esc_html($settings['period']); ?></span>
                  </div>

                  <?php if ( $settings['show_badge'] == 'yes' ) : ?>
                            <span <?php $this->print_render_attribute_string( 'badge_text' ); ?>><?php echo esc_html($settings['badge_text']); ?></span>
                        <?php endif; ?>
              </div>

          
              <?php if ( $settings['features_title'] ) : ?>
                  <h5 <?php $this->print_render_attribute_string( 'features_title' ); ?>><?php echo wp_kses_post( $settings['features_title'] ); ?></h5>
              <?php endif; ?>

              <?php if ( is_array( $settings['features_list'] ) ) : ?>
                  <ul class="rt-pricing-table-features-list">
                      <?php foreach ( $settings['features_list'] as $index => $feature ) :
                          $name_key = $this->get_repeater_setting_key( 'text', 'features_list', $index );
                          $this->add_inline_editing_attributes( $name_key, 'basic' );
                          $this->add_render_attribute( $name_key, 'class', 'rt-pricing-table-feature-text' );
                          ?>
                           <?php if ( $feature['icon'] ) : ?>
                                   
                                  <?php $active_class = $feature['icon'] == 'fa fa-close' ? 'deactive' : 'active';                                 
                               endif; ?>
                            <li class="<?php echo esc_attr( 'elementor-repeater-item-' . $feature['_id'] ); ?> <?php echo esc_attr($active_class);?>">
 

                              <?php \Elementor\Icons_Manager::render_icon( $feature['icon'], [ 'aria-hidden' => 'true' ] ); ?>

                              <span class="rt-pricing-table-feature-text "><?php echo wp_kses_post( $feature['text'] ); ?></span>
                          </li>
                      <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
              <?php if ( $settings['button_text'] ) : ?>
                  <div class="btn-part">
                      <a class="price-btn btn-main" <?php $this->print_render_attribute_string( 'button_text' ); ?>><?php echo esc_html( $settings['button_text'] ); ?>  
                      </a>                  
                  </div>
              <?php endif; ?>
          </div>           
      </div>
    <?php

        } else {
            ?>
          <div class="rt-price-table<?php echo esc_attr( $styleClass);?>"> 
            <div class="rt-pricing-table-price <?php echo esc_attr($settings['pricing_inline']); ?>">
                  <div class="rt-pricing-table-price-tag">
                  <span <?php $this->print_render_attribute_string( 'period' ); ?>><?php echo esc_html($settings['period']); ?></span>
                  <span class="rt-pricing-table-currency"><?php echo esc_html( $currency ); ?></span><span <?php $this->print_render_attribute_string( 'price' ); ?>><?php echo esc_html($settings['price']); ?></span>
                      
                     
                  </div>
            </div>

            
            <?php if ( $settings['show_badge'] ) : ?>
                        <span <?php $this->print_render_attribute_string( 'badge_text' ); ?>><?php echo esc_html($settings['badge_text']); ?></span>
                    <?php endif; ?>

          <?php if( !empty($settings['selected_icon']) || !empty($settings['selected_image']['url'])) : ?>
              <div class="rt-pricing-icon">
                   <?php if ( $settings['selected_icon'] ) : ?>
                      <i class="fa <?php echo esc_html($settings['selected_icon']);?>"></i>
                  <?php endif; ?>

                   <?php if ( $settings['selected_image']['url'] ) : ?>
                     <img src="<?php echo esc_url($settings['selected_image']['url']);?>"  alt="<?php echo esc_url($settings['selected_image']['url']);?>" />
                  <?php endif; ?>
              </div>
          <?php endif; ?>

          <div class="rt-pricing-table-header">
          <?php if ( $settings['sub_title'] ) : ?>
                  <p><?php echo esc_html($settings['sub_title']); ?></p>
              <?php endif; ?>
              <?php if ( $settings['title'] ) : ?>
                  <h2 <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo esc_html($settings['title']); ?></h2>
              <?php endif; ?>             

          </div>
          <div class="rt-pricing-table-body">              
              <?php if ( $settings['features_title'] ) : ?>
                  <h3 <?php $this->print_render_attribute_string( 'features_title' ); ?>><?php echo wp_kses_post( $settings['features_title'] ); ?></h3>
              <?php endif; ?>

              <?php if ( is_array( $settings['features_list'] ) ) : ?>
                  <ul class="rt-pricing-table-features-list">
                      <?php foreach ( $settings['features_list'] as $index => $feature ) :
                          $name_key = $this->get_repeater_setting_key( 'text', 'features_list', $index );
                          $this->add_inline_editing_attributes( $name_key, 'basic' );
                          $this->add_render_attribute( $name_key, 'class', 'rt-pricing-table-feature-text' );
                          ?>
                           <?php if ( $feature['icon'] ) : ?>
                                   
                                  <?php $active_class = $feature['icon'] == 'fa fa-close' ? 'deactive' : 'active';                                 
                               endif; ?>
                          <li class="<?php echo esc_attr( 'elementor-repeater-item-' . $feature['_id'] ); ?> <?php echo esc_attr($active_class);?>">
                              <?php if ( $feature['icon'] == 'fa fa-check' ) : ?>
                                  <i class="fas fa-check-circle"></i> 
                                                             
                              <?php  endif; ?>
                              <?php if ( $feature['icon'] == 'fa fa-close' ) : ?>
                                    <i class="fa-regular fa-check"></i>
                                                             
                              <?php  endif; ?>

                              <span class="rt-pricing-table-feature-text "><?php echo wp_kses_post( $feature['text'] ); ?></span>
                          </li>
                      <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
              <?php if ( $settings['button_text'] ) : ?>
                    <div class="btn-part">
                      <a class="price-btn" <?php $this->print_render_attribute_string( 'button_text' ); ?>><?php echo esc_html( $settings['button_text'] ); ?>  
                      </a>
                    
                  </div>
              <?php endif; ?>
          </div>           
      </div>
       
        <?php
        }
    }
}
