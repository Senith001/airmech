<?php

/**
 * Logo widget class
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
use Elementor\register_controls;

defined('ABSPATH') || die();
class Reactheme_Elementor_Slider_Widget  extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *   
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name()
    {
        return 'rt-slider';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */

    public function get_title()
    {
        return esc_html__('RT Banner Slider', 'rtelements');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }
    public function get_categories()
    {
        return ['pielements_category'];
    }
    public function get_keywords()
    {
        return ['slider'];
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            '_services_slider_s',
            [
                'label' => esc_html__('Slider Style', 'rtelements'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'rt_slider_style',
            [
                'label'   => esc_html__('Select Style', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'rtelements'),                   
                    'style2' => esc_html__('Style 2', 'rtelements'),                   
                    'style3' => esc_html__('Style 3', 'rtelements'),                   
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_height',
            [
                'label' => esc_html__('Slider Height', 'rtelements'),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-slider .v-center' => 'min-height:{{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__('Slider Item', 'rtelements'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Background Image', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        $repeater->add_control(
			'style2_item_image',
			[
				'label' => esc_html__( 'Style 2 Item Image', 'rtelements' ),
                'description' => 'This item image field just for style 2, style 3',
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        
        $repeater->add_control(
            'sub-name',
            [
                'label' => esc_html__('Sub Title', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Subtitle', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__('subtitle', 'rtelements'),
                'separator'   => 'before',
            ]
        );
        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Title', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Slider Name', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__('Name', 'rtelements'),
                'separator'   => 'before',
            ]
        );
        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'rtelements'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__('Description', 'rtelements'),
                'separator'   => 'before',
            ]
        );
        $repeater->add_control(
            'btn_text',
            [
                'label' => esc_html__('Button Text', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Book A Repair', 'rtelements'),
                'label_block' => true,              
                'separator'   => 'before',
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'rtelements'),
                'type' => Controls_Manager::URL,
            ]
        );
        $repeater->add_control(
			'style3_logo',
			[
				'label' => esc_html__( 'Style 3 Logo', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'description' => 'This image field just for style 3 logo item',
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        $this->add_control(
            'logo_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'default' => [
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                ]
            ]
        );

       
        $this->end_controls_section();        

        // Style 1 Slider Feature Repeater
        $this->start_controls_section(
            '_section_features',
            [
                'label' => esc_html__('Slider Features', 'rtelements'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'rt_slider_style' => ['style1','style2'],                   
                ],
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				
			]
		);        
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'rtelements'),
                'type' => Controls_Manager::TEXT,              
                'label_block' => true,                
                'separator'   => 'before',
            ]
        );      
        $repeater->add_control(
            'fe_description',
            [
                'label' => esc_html__('Description', 'rtelements'),
                'type' => Controls_Manager::TEXTAREA,             
                'label_block' => true,               
                'separator'   => 'before',
            ]
        );
        $this->add_control(
            'feature_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
                'condition' => [
                    'rt_slider_style' => 'style1',                   
                ],
            ]
        );

        // Style 2 Slider Feature Repeater
        $repeater = new Repeater();
        $repeater->add_control(
			'slider_logo_image',
			[
				'label' => esc_html__( 'Choose Logo', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				
			]
		);
        $this->add_control(
            'slider2_feature_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => [
                    'rt_slider_style' => 'style2',                   
                ],
            ]
        );
       
        $this->end_controls_section(); 

        $this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__('Slider Settings', 'rtelements'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'col_xl',
            [
                'label'   => esc_html__('Wide Screen > 1399px', 'rsaddon'),
                'type'    => Controls_Manager::SELECT,
                'default' => 4,
                'options' => [
                    '1' => esc_html__('1 Column', 'rsaddon'),
                    '2' => esc_html__('2 Column', 'rsaddon'),
                    '3' => esc_html__('3 Column', 'rsaddon'),
                    '4' => esc_html__('4 Column', 'rsaddon'),
                    '4.5' => esc_html__('4.5 Column', 'rsaddon'),
                    '5' => esc_html__('5 Column', 'rsaddon'),
                    '6' => esc_html__('6 Column', 'rsaddon'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_control(
            'col_lg',
            [
                'label'   => esc_html__('Desktops > 1199px', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 4,
                'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__('Desktops > 991px', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 3,
                'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__('Tablets > 767px', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 2,
                'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_control(
            'col_xs',
            [
                'label'   => esc_html__('Tablets < 768px', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_control(
            'slides_ToScroll',
            [
                'label'   => esc_html__('Slide To Scroll', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 2,
                'options' => [
                    '1' => esc_html__('1 Item', 'rtelements'),
                    '2' => esc_html__('2 Item', 'rtelements'),
                    '3' => esc_html__('3 Item', 'rtelements'),
                    '4' => esc_html__('4 Item', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );
        $this->add_control(
            'rt_pslider_effect',
            [
                'label' => esc_html__('Slider Effect', 'rsaddon'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'rsaddon'),
                    'fade' => esc_html__('Fade', 'rsaddon'),
                    'flip' => esc_html__('Flip', 'rsaddon'),
                    'cube' => esc_html__('Cube', 'rsaddon'),
                    'coverflow' => esc_html__('Coverflow', 'rsaddon'),
                    'creative' => esc_html__('Creative', 'rsaddon'),
                    'cards' => esc_html__('Cards', 'rsaddon'),
                ],
            ]
        );

        $this->add_control(
            'slider_dots',
            [
                'label'   => esc_html__('Navigation Dots', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',
            ]

        );
        $this->add_control(
            'slider_dots_color',
            [
                'label' => esc_html__('Navigation Dots Color', 'rsaddon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => ['slider_dots' => 'true',],
            ]
        );
        $this->add_control(
			'slider_dots_opacity',
			[
				'label' => esc_html__( 'Opacity', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'opacity: {{SIZE}}{{UNIT}};',
				],
                'condition' => ['slider_dots' => 'true',],
			]
		);
        $this->add_control(
            'slider_dots_color_active',
            [
                'label' => esc_html__('Active Navigation Dots Color', 'rsaddon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}} !important;',
                ],
                'condition' => ['slider_dots' => 'true',],
            ]
        );

        $this->add_responsive_control(
            'slider_nav',
            [
                'label'   => esc_html__('Navigation Nav', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pcat_nav_text_bg',
            [
                'label' => esc_html__('Nav BG Color', 'rsaddon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev' => 'background: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-button-next' => 'background: {{VALUE}} !important;',
                ],
                'condition' => ['slider_nav' => 'true',],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg_hover',
            [
                'label' => esc_html__('Nav BG Hover Color', 'rsaddon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev:hover' => 'background: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-button-next:hover' => 'background: {{VALUE}} !important;',
                ],
                'condition' => ['slider_nav' => 'true',],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg_icon',
            [
                'label' => esc_html__('Nav BG Icon Color', 'rsaddon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-button-next' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-pagination-current' => 'color: {{VALUE}} !important;',
                ],
                'condition' => ['slider_nav' => 'true',],
            ]
        );
        $this->add_control(
            'pcat_nav_text_bg_hover_icon',
            [
                'label' => esc_html__('Nav BG Icon Hover Color', 'rsaddon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .swiper-button-next:hover' => 'color: {{VALUE}} !important;',
                ],
                'condition' => ['slider_nav' => 'true',],
            ]
        );

        $this->add_responsive_control(
            'nav_top_gap',
            [
                'label' => esc_html__('Navigation Top Gap', 'rtelements'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'show_label' => true,
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .swiper-button-next' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'slider_dots',
                            'operator' => '==',
                            'value' => 'true',
                        ],
                        [
                            'name' => 'slider_nav',
                            'operator' => '==',
                            'value' => 'true',
                        ],
                    ],
                ],
                
            ]
        );
        

        $this->add_control(
            'slider_autoplay',
            [
                'label'   => esc_html__('Autoplay', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label'   => esc_html__('Autoplay Slide Speed', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 3000,
                'options' => [
                    '1000' => esc_html__('1 Seconds', 'rtelements'),
                    '2000' => esc_html__('2 Seconds', 'rtelements'),
                    '3000' => esc_html__('3 Seconds', 'rtelements'),
                    '4000' => esc_html__('4 Seconds', 'rtelements'),
                    '5000' => esc_html__('5 Seconds', 'rtelements'),
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],
            ]
        );

        $this->add_control(
            'slider_interval',
            [
                'label'   => esc_html__('Autoplay Interval', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 3000,
                'options' => [
                    '5000' => esc_html__('5 Seconds', 'rtelements'),
                    '4000' => esc_html__('4 Seconds', 'rtelements'),
                    '3000' => esc_html__('3 Seconds', 'rtelements'),
                    '2000' => esc_html__('2 Seconds', 'rtelements'),
                    '1000' => esc_html__('1 Seconds', 'rtelements'),
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],
            ]
        );

        $this->add_control(
            'slider_stop_on_interaction',
            [
                'label'   => esc_html__('Stop On Interaction', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],
            ]

        );

        $this->add_control(
            'slider_stop_on_hover',
            [
                'label'   => esc_html__('Stop on Hover', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],
            ]

        );

        $this->add_control(
            'slider_loop',
            [
                'label'   => esc_html__('Loop', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slider_centerMode',
            [
                'label'   => esc_html__('Center Mode', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__('Enable', 'rtelements'),
                    'false' => esc_html__('Disable', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_responsive_control(
            'item_gap_custom',
            [
                'label' => esc_html__('Item Gap', 'rtelements'),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],

                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .grid-item' => 'padding:0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section(); 

        /** 
         ************* STYLE
         */ 

        // Title 
        $this->start_controls_section(
            'slider_title_styles',
            [
                'label' => esc_html__('Title', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-title' => 'color: {{VALUE}}',
                    
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .slider-title',
            ]
        );
        $this->add_control(
            'title_border_color',
            [
                'label' => esc_html__('Border Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sw-text-wrapper.border-left' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'rt_slider_style' => ['style2','style3'],                   
                ],
            ]
        );
        $this->add_responsive_control(
			'title_border_size',
			[
				'label' => esc_html__( 'Border Size', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sw-text-wrapper.border-left' => 'border-left-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
            'title__margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        
        $this->end_controls_section();     

        $this->start_controls_section(
            'designation_styles',
            [
                'label' => esc_html__('Sub Title', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'color: {{VALUE}}',                    
                ],
            ]
        );
        $this->add_control(
            'subtitle_bg_color',
            [
                'label' => esc_html__('Background Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'background: {{VALUE}}',                    
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle__padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle__margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        $this->add_responsive_control(
            'subtitle_border_radius',
            [
                'label' => esc_html__('Border Radius', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        $this->end_controls_section(); 

        $this->start_controls_section(
            'des__styles',
            [
                'label' => esc_html__('Description', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'des__color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slider-teaser' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'des__typography',
                'selector' => '{{WRAPPER}} .slider-teaser',
            ]
        );
       
        $this->end_controls_section(); 

        // Button 
        $this->start_controls_section(
            'btn__styles',
            [
                'label' => esc_html__('Button', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
			'btn_styles_tabs'
		);
            $this->start_controls_tab(
                'btn_styles_tab',
                [
                    'label' => esc_html__( 'Normal', 'rtelements' ),
                ]
            );
                $this->add_control(
                    'btn__color',
                    [
                        'label' => esc_html__('Color', 'rtelements'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .btn-main' => 'color: {{VALUE}}',
                        ],
                    ]
                );
                $this->add_control(
                    'btn_bg_color',
                    [
                        'label' => esc_html__('Background Color', 'rtelements'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .btn-main' => 'background: {{VALUE}}',                    
                        ],
                    ]
                );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'btn_hover_styles_tab',
                [
                    'label' => esc_html__( 'Hover', 'textdomain' ),
                ]
            );
                $this->add_control(
                    'btn_hover_color',
                    [
                        'label' => esc_html__('Color', 'rtelements'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .btn-main:hover' => 'color: {{VALUE}}',
                        ],
                    ]
                );
                $this->add_control(
                    'btn_bg_hover_color',
                    [
                        'label' => esc_html__('Background Color', 'rtelements'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .btn-main:hover' => 'background: {{VALUE}}',                    
                        ],
                    ]
                );
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'btn_hover_box_shadow',
                        'selector' => '{{WRAPPER}} .btn-main:hover',
                    ]
                );
            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn__typography',
                'selector' => '{{WRAPPER}} .btn-main',
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .btn-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .btn-main' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .btn-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'btn_box_shadow',
                'selector' => '{{WRAPPER}} .btn-main',
            ]
        );
        $this->end_controls_section();   
        
        // Feature Style 1
        $this->start_controls_section(
            'feature_style',
            [
                'label' => esc_html__('Feature Style', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'rt_slider_style' => 'style1',                   
                ],
            ]
        );
        
        $this->add_control(
			'f_title_options',
			[
				'label' => esc_html__( 'Title Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'f_title__color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fb-text h4' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'f_title_typography',
                'selector' => '{{WRAPPER}} .fb-text h4',
            ]
        );
        $this->add_responsive_control(
            'f_title_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .fb-text h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        // Description
        $this->add_control(
			'f_desc_options',
			[
				'label' => esc_html__( 'Description Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'f_desc__color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .fb-text p' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'f_desc_typography',
                'selector' => '{{WRAPPER}} .fb-text p',
            ]
        );
        $this->add_responsive_control(
            'f_desc_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .fb-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        // Icon
        $this->add_control(
			'f_icon_options',
			[
				'label' => esc_html__( 'Icon Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'f_icon__color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .svg-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .svg-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'f_icon__color_bg',
            [
                'label' => esc_html__('Background Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .svg-icon' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
			'f_icon__size',
			[
				'label' => esc_html__( 'Size', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .svg-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .svg-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
            'f_icon_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .svg-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
       
        $this->end_controls_section(); 

        // Image
        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image Style', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'rt_slider_style' => ['style2','style3'],                   
                ],
            ]
        );
        $this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Size', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slide_img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
      
        $this->end_controls_section(); 

         // Logo Image
         $this->start_controls_section(
            'logo_style',
            [
                'label' => esc_html__('Logo Style', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'rt_slider_style' => ['style2','style3'],                   
                ],
            ]
        );
        $this->add_responsive_control(
			'logo_image_size',
			[
				'label' => esc_html__( 'Size', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slider-extra img' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
        $this->add_responsive_control(
            'logo_img_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .slider-extra' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                 ],
            ]
        );
        $this->end_controls_section(); 
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $col_xl          = $settings['col_xl'];
        $col_xl          = !empty($col_xl) ? $col_xl : 4;
        $slidesToShow    = $col_xl;
        $autoplaySpeed   = $settings['slider_autoplay_speed'];
        $autoplaySpeed   = !empty($autoplaySpeed) ? $autoplaySpeed : '1000';
        $interval        = $settings['slider_interval'];
        $interval        = !empty($interval) ? $interval : '3000';
        $slidesToScroll  = $settings['slides_ToScroll'];
        $slider_autoplay = $settings['slider_autoplay'] === 'true' ? 'true' : 'false';
        $pauseOnHover    = $settings['slider_stop_on_hover'] === 'true' ? 'true' : 'false';
        $pauseOnInter    = $settings['slider_stop_on_interaction'] === 'true' ? 'true' : 'false';
        $sliderDots      = $settings['slider_dots'] == 'true' ? 'true' : 'false';
        $sliderNav       = $settings['slider_nav'] == 'true' ? 'true' : 'false';
        $infinite        = $settings['slider_loop'] === 'true' ? 'true' : 'false';
        $centerMode      = $settings['slider_centerMode'] === 'true' ? 'true' : 'false';
        $col_lg          = $settings['col_lg'];
        $col_md          = $settings['col_md'];
        $col_sm          = $settings['col_sm'];
        $col_xs          = $settings['col_xs'];
        $item_gap        = $settings['item_gap_custom']['size'];
        $item_gap        = !empty($item_gap) ? $item_gap : '30';

        $next_text       = !empty($next_text) ? $next_text : '';
        $unique          = rand(2012, 35120);
        $all_pcat = rselemetns_woocommerce_product_categories();
        if ($slider_autoplay == 'true') {
            $slider_autoplay = 'autoplay: { ';
            $slider_autoplay .= 'delay: ' . $interval;
            if ($pauseOnHover == 'true') {
                $slider_autoplay .= ', pauseOnMouseEnter: true';
            } else {
                $slider_autoplay .= ', pauseOnMouseEnter: false';
            }
            if ($pauseOnInter == 'true') {
                $slider_autoplay .= ', disableOnInteraction: true';
            } else {
                $slider_autoplay .= ', disableOnInteraction: false';
            }
            $slider_autoplay .= ' }';
        } else {
            $slider_autoplay = 'autoplay: false';
        }

        $effect = $settings['rt_pslider_effect'];

        if ($effect == 'fade') {
            $seffect = "effect: 'fade', fadeEffect: { crossFade: true, },";
        } elseif ($effect == 'cube') {
            $seffect = "effect: 'cube',";
        } elseif ($effect == 'flip') {
            $seffect = "effect: 'flip',";
        } elseif ($effect == 'coverflow') {
            $seffect = "effect: 'coverflow',";
        } elseif ($effect == 'creative') {
            $seffect = "effect: 'creative', creativeEffect: { prev: { translate: [0, 0, -400], }, next: { translate: ['100%', 0, 0], }, },";
        } elseif ($effect == 'cards') {
            $seffect = "effect: 'cards',";
        } else {
            $seffect = '';
        }
        if (empty($settings['logo_list'])) {
            return;
        }
        $sstyle = $settings['rt_slider_style'];

        $blank = "";
        ?>
      
        <div class="rt-slider slider-inner-wrapper section-dark text-light no-top no-bottom position-relative overflow-hidden z-1000">            
            <div class="swiper  rt_slider-<?php echo esc_attr($unique); ?>">
                <div class="swiper-wrapper">
                    <?php
                        foreach ($settings['logo_list'] as $index => $item) :
                            $image        = wp_get_attachment_image_url( $item['image']['id'], 'full' );
                            $title        = !empty($item['name']) ? $item['name'] : '';
                            $sub_title    = !empty($item['sub-name']) ? $item['sub-name'] : '';
                            $description  = !empty($item['description']) ? $item['description'] : '';
                            $btn_text     = !empty($item['btn_text']) ? $item['btn_text'] : '';
                            $target       = !empty($item['link']['is_external']) ? 'target=_blank' : '';
                            $link         = !empty($item['link']['url']) ? $item['link']['url'] : '';
                            $style2_item_image = $item['style2_item_image']['url'];
                            $style3_logo = !empty($item['style3_logo']['url']) ? $item['style3_logo']['url'] : '';;

                            if ($sstyle) {
                                require plugin_dir_path(__FILE__) . "/$sstyle.php";
                            }else {
                                require plugin_dir_path(__FILE__) . "/style1.php";
                            }
                        endforeach; 
                    ?>
                </div>  
            </div>                
        </div>
        <?php if( !empty($sliderDots == 'true' || $sliderNav == 'true') ) : ?>
            <div class="swiper-pagination"></div>
                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar"></div>
        <?php endif; ?>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                var swiper<?php echo esc_attr($unique); ?><?php echo esc_attr($unique); ?> = new Swiper(".rt_slider-<?php echo esc_attr($unique); ?>", {
                    slidesPerView: 1,
                    <?php echo $seffect; ?>
                    speed: <?php echo esc_attr($autoplaySpeed); ?>,
                    slidesPerGroup: 1,
                    loop: <?php echo esc_attr($infinite); ?>,
                    <?php echo esc_attr($slider_autoplay); ?>,
                    spaceBetween: <?php echo esc_attr($item_gap); ?>,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        type: "fraction",
                    },
                    centeredSlides: <?php echo esc_attr($centerMode); ?>,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        <?php
                                echo (!empty($col_xs)) ?  '575: { slidesPerView: ' . $col_xs . ' },' : '';
                                echo (!empty($col_sm)) ?  '767: { slidesPerView: ' . $col_sm . ' },' : '';
                                echo (!empty($col_md)) ?  '991: { slidesPerView: ' . $col_md . ' },' : '';
                                echo (!empty($col_lg)) ?  '1199: { slidesPerView: ' . $col_lg . ' },' : '';
                                ?>
                        1399: {
                            slidesPerView: <?php echo esc_attr($col_xl); ?>,
                            spaceBetween: <?php echo esc_attr($item_gap); ?>
                        }
                    }
                });
            });
        </script>
<?php
    }
}