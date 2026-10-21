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

defined( 'ABSPATH' ) || die();

class ReacThemes_Choose_Widget extends \Elementor\Widget_Base {   
   
    /**
     * Get widget name.
     *    
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'rt-choose';
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
        return esc_html__( 'Choose us', 'rtelements' );
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
        return 'eicon-gallery-grid';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'logo', 'clients', 'brand', 'parnter', 'image' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Content', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'rtelements'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );   
        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Title', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Name', 'rtelements' ),
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'rtelements'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__( 'Description', 'rtelements' ),
                'separator'   => 'before',
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

        $this->start_controls_section(
            '_section_settings',
            [
                'label' => esc_html__( 'Settings', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
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
                    '{{WRAPPER}} .rt-grid-figure' => 'text-align: {{VALUE}}'
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );
     $this->end_controls_section();



        $this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
               
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
            'col_xl',
            [
                'label'   => esc_html__( 'Wide Screen > 1399px', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'rsaddon' ), 
                    '2' => esc_html__( '2 Column', 'rsaddon' ),
                    '3' => esc_html__( '3 Column', 'rsaddon' ),
                    '4' => esc_html__( '4 Column', 'rsaddon' ),
                    '4.5' => esc_html__( '4.5 Column', 'rsaddon' ),
                    '5' => esc_html__( '5 Column', 'rsaddon' ),
                    '5.5' => esc_html__( '5.5 Column', 'rsaddon' ),
                    '6' => esc_html__( '6 Column', 'rsaddon' ),                 
                    '7' => esc_html__( '7 Column', 'rsaddon' ),                 
                ],
                'separator' => 'before',
            ]
            
        );

        $this->add_control(
            'col_lg',
            [
                'label'   => esc_html__( 'Desktops > 1199px', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'rtelements' ), 
                    '2' => esc_html__( '2 Column', 'rtelements' ),
                    '3' => esc_html__( '3 Column', 'rtelements' ),
                    '4' => esc_html__( '4 Column', 'rtelements' ),
                    '5' => esc_html__( '5 Column', 'rtelements' ),
                    '6' => esc_html__( '6 Column', 'rtelements' ),                 
                    '7' => esc_html__( '7 Column', 'rtelements' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__( 'Desktops > 991px', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'rtelements' ), 
                    '2' => esc_html__( '2 Column', 'rtelements' ),
                    '3' => esc_html__( '3 Column', 'rtelements' ),
                    '4' => esc_html__( '4 Column', 'rtelements' ),
                    '5' => esc_html__( '5 Column', 'rtelements' ),
                    '6' => esc_html__( '6 Column', 'rtelements' ),                     
                    '7' => esc_html__( '7 Column', 'rtelements' ),                     
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__( 'Tablets > 767px', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'rtelements' ), 
                    '2' => esc_html__( '2 Column', 'rtelements' ),
                    '3' => esc_html__( '3 Column', 'rtelements' ),
                    '4' => esc_html__( '4 Column', 'rtelements' ),
                    '6' => esc_html__( '6 Column', 'rtelements' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_xs',
            [
                'label'   => esc_html__( 'Tablets < 768px', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 1,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'rtelements' ), 
                    '2' => esc_html__( '2 Column', 'rtelements' ),
                    '3' => esc_html__( '3 Column', 'rtelements' ),
                    '4' => esc_html__( '4 Column', 'rtelements' ),
                    '6' => esc_html__( '6 Column', 'rtelements' ),                 
                ],
                'separator' => 'before',
                            
            ]            
        );

        $this->add_control(
            'slides_ToScroll',
            [
                'label'   => esc_html__( 'Slide To Scroll', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Item', 'rtelements' ),
                    '2' => esc_html__( '2 Item', 'rtelements' ),
                    '3' => esc_html__( '3 Item', 'rtelements' ),
                    '4' => esc_html__( '4 Item', 'rtelements' ),                   
                ],
                'separator' => 'before',
                            
            ]
            
        );      

        $this->add_control(
            'slider_dots',
            [
                'label'   => esc_html__( 'Navigation Dots', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),              
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
                    '{{WRAPPER}} .swiper-pagination-two .swiper-pagination-bullet' => 'background-color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .swiper-pagination-two .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
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
                    '{{WRAPPER}} .swiper-pagination-two .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}} !important;',
                ],
                'condition' => ['slider_dots' => 'true',],
            ]
        );

        $this->add_control(
            'slider_nav',
            [
                'label'   => esc_html__( 'Navigation Nav', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),              
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
                    '{{WRAPPER}}  .swiper-button-prev:hover' => 'background: {{VALUE}} !important;',
                    '{{WRAPPER}}  .swiper-button-next:hover' => 'background: {{VALUE}} !important;',
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
                    '{{WRAPPER}}  .swiper-button-prev::after' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}}  .swiper-button-next::after' => 'color: {{VALUE}} !important;',
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
                    '{{WRAPPER}}  .swiper-button-prev:hover::after' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}}  .swiper-button-next:hover::after' => 'color: {{VALUE}} !important;',
                ],
                'condition' => ['slider_nav' => 'true',],
            ]
        );
        $this->add_responsive_control(
            'nav_top_gap',
            [
                'label' => esc_html__('Nav / Dots Top Gap', 'rtelements'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'show_label' => true,
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rts-why-chosse-pagination' => 'margin-top: {{SIZE}}{{UNIT}} !important;',
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
                'label'   => esc_html__( 'Autoplay', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_diretion',
            [
                'label'   => esc_html__( 'Reverse Direction', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),              
                ],
                'separator' => 'before',
                'condition' => [
                    'slider_autoplay' => 'true',
                ],                                                      
            ]
            
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label'   => esc_html__( 'Autoplay Slide Speed', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '1000' => esc_html__( '1 Seconds', 'rtelements' ),
                    '2000' => esc_html__( '2 Seconds', 'rtelements' ), 
                    '3000' => esc_html__( '3 Seconds', 'rtelements' ), 
                    '4000' => esc_html__( '4 Seconds', 'rtelements' ), 
                    '5000' => esc_html__( '5 Seconds', 'rtelements' ), 
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
                'label'   => esc_html__( 'Stop On Interaction', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),              
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
                'label'   => esc_html__( 'Stop on Hover', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_interval',
            [
                'label'   => esc_html__( 'Autoplay Interval', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '5000' => esc_html__( '5 Seconds', 'rtelements' ), 
                    '4000' => esc_html__( '4 Seconds', 'rtelements' ), 
                    '3000' => esc_html__( '3 Seconds', 'rtelements' ), 
                    '2000' => esc_html__( '2 Seconds', 'rtelements' ), 
                    '1000' => esc_html__( '1 Seconds', 'rtelements' ),     
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_loop',
            [
                'label'   => esc_html__( 'Loop', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),
                ],
                'separator' => 'before',                            
            ]            
        );

        $this->add_control(
            'slider_centerMode',
            [
                'label'   => esc_html__( 'Center Mode', 'rtelements' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'rtelements' ),
                    'false' => esc_html__( 'Disable', 'rtelements' ),
                ],
                'separator' => 'before',                            
            ]            
        );

        $this->add_responsive_control(
            'item_gap_custom',
            [
                'label' => esc_html__( 'Item Gap', 'rsaddon' ),
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
                    '{{WRAPPER}} .item.swiper-slide' => 'margin-right:0 {{SIZE}}{{UNIT}};',                    
                ],
            ]
        );

        $this->end_controls_section();

   
        $this->start_controls_section(
            '_section_style_grid',
            [
                'label' => esc_html__( 'Item', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'grid_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'grid_bg_hover_color',
            [
                'label' => esc_html__( 'Hover Background Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'grid_border',
                'selector' => '{{WRAPPER}} .item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'grid_box_shadow',
                'selector' => '{{WRAPPER}} .item',
            ]
        ); 

        $this->add_responsive_control(
            'grid_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',           
                ],               
            ]
        );   
        $this->end_controls_section();

        $this->start_controls_section(
            '_title_style_grid',
            [
                'label' => esc_html__( 'Title Style', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'show_title',
            [
                'label' => esc_html__( 'Show Title', 'rtelements' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'rtelements' ),
                'label_off' => esc_html__( 'Hide', 'rtelements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__( 'Title HTML Tag', 'rtelements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'h1'  => [
                        'title' => esc_html__( 'H1', 'rtelements' ),
                        'icon' => 'eicon-editor-h1'
                    ],
                    'h2'  => [
                        'title' => esc_html__( 'H2', 'rtelements' ),
                        'icon' => 'eicon-editor-h2'
                    ],
                    'h3'  => [
                        'title' => esc_html__( 'H3', 'rtelements' ),
                        'icon' => 'eicon-editor-h3'
                    ],
                    'h4'  => [
                        'title' => esc_html__( 'H4', 'rtelements' ),
                        'icon' => 'eicon-editor-h4'
                    ],
                    'h5'  => [
                        'title' => esc_html__( 'H5', 'rtelements' ),
                        'icon' => 'eicon-editor-h5'
                    ],
                    'h6'  => [
                        'title' => esc_html__( 'H6', 'rtelements' ),
                        'icon' => 'eicon-editor-h6'
                    ]
                ],
                'default' => 'h3',
                'toggle' => false,
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .logo-title .title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item:hover .logo-title .title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Typography', 'rtelements' ),
                'selector' => '{{WRAPPER}}  .logo-title .title',
              
                'separator'   => 'before',
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .logo-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .logo-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'selector' => '{{WRAPPER}} .logo-title',
                'condition' => [
                    'show_title' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            '_desc_style_grid',
            [
                'label' => esc_html__( 'Description Style', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'show_desc',
            [
                'label' => esc_html__( 'Show Description', 'rtelements' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'rtelements' ),
                'label_off' => esc_html__( 'Hide', 'rtelements' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        
        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .logo-desc .description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_desc' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'desc_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item:hover .logo-desc .description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_desc' => 'yes'
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => esc_html__( 'Typography', 'rtelements' ),
                'selector' => '{{WRAPPER}}  .logo-desc .description',
              
                'separator'   => 'before',
                'condition' => [
                    'show_desc' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'desc_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .logo-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_desc' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__( 'Image Style', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__( 'Image Size', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],  
                'selectors' => [
                    '{{WRAPPER}} .rs-grid-img' => 'width: {{SIZE}}{{UNIT}};',                    
                ],
            ]
        ); 
        $this->add_control(
            'image_bg',
            [
                'label' => esc_html__( 'Background', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-grid-img' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'image_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-grid-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-grid-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-grid-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Css_Filter::get_type(),
			[
				'name' => 'hover_image_filter',
                'label' => esc_html__( 'Hover Image Filter', 'rtelements' ),
				'selector' => '{{WRAPPER}} .item:hover .rs-grid-img',
			]
		);
        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();     

        $col_xl          = $settings['col_xl'];
        $col_xl          = !empty($col_xl) ? $col_xl : 3;
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
        
        $item_gap = !empty($settings['item_gap_custom']['size']) ? $settings['item_gap_custom']['size'] : '30';
        $prev_text = $settings['pcat_prev_text'] ?? '';
        $prev_text = !empty($prev_text) ? $prev_text : '';
        $next_text = $settings['pcat_next_text'] ?? '';
        $next_text = !empty($next_text) ? $next_text : '';
        $unique = rand(2012,35120);

        $all_pcat = rselemetns_woocommerce_product_categories();
       

        if( $slider_autoplay =='true' ){
            $slider_autoplay = 'autoplay: { ' ;
            $slider_autoplay .= 'delay: '.$interval;
            $slider_autoplay .= ', reverseDirection: '.$settings['slider_diretion'];
            if(  $pauseOnHover =='true'  ){
                $slider_autoplay .= ', pauseOnMouseEnter: true';
            }else{
                $slider_autoplay .= ', pauseOnMouseEnter: false';
            }
            if(  $pauseOnInter =='true'  ){
                $slider_autoplay .= ', disableOnInteraction: true';
            }else{
                $slider_autoplay .= ', disableOnInteraction: false';
            }
            $slider_autoplay .= ' }';
        }else{
            $slider_autoplay = 'autoplay: false' ;
        }
        $blank = "";
        
        ?>
            <div class="rt_slider-<?php echo esc_attr($unique); ?> swiper rtelements-unique-slider">
                <div id="rtelements-slick-slider-<?php echo esc_attr($unique); ?>" class="rt-addon-slider swiper-wrapper logo-showcase">  
                    <?php
                        foreach ( $settings['logo_list'] as $index => $item ) :
                            
                            $image = wp_get_attachment_image_url( $item['image']['id'], $settings['thumbnail_size'] );
                            
                            $title = !empty($item['name']) ? $item['name'] : '';

                            $title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h3';
                            
                            $description = !empty($item['description']) ? $item['description'] : '';
                                            
                            

                            $show_tooltip = ( isset( $settings['show_tooltip'] ) && $settings['show_tooltip'] == 'yes' ) ? 'data-toggle= tooltip data-placement= top ' : '';
                            $animation = !empty($settings['hover_animation'])? 'elementor-animation-'.$settings['hover_animation'].'':'';

                            $backExists = (!empty($image1)) ? ' back-exists' : '';

                            ?>
                            <div class="item swiper-slide">
                                <div class="relative">
                                    <?php if(!empty($image )):?>
                                        <img class="rs-grid-img bg-color w-30 padding15 rounded-10 mb-3" src="<?php echo esc_url( $image ); ?>" title="<?php echo esc_attr( $item['name'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>">
                                    <?php endif;?>

                                    <?php if(!empty($item['name']) && $settings['show_title'] == 'yes'):?>
                                        <div class="logo-title">
                                            <<?php echo esc_attr($title_tag);?> class="title"> <?php echo esc_attr ($title);?></<?php echo esc_attr($title_tag);?>>                                    
                                        </div>
                                    <?php endif;?>

                                    <?php if(!empty($item['description']) && $settings['show_desc'] == 'yes'):?>                                          
                                        <div class="logo-desc">
                                            <p class="description"> <?php echo esc_attr ($description);?></p>
                                        </div>
                                    
                                    <?php endif;?>
                                </div>
                            </div>
                                    
                    <?php endforeach; ?>
                </div>
                <?php if( !empty($sliderDots == 'true' || $sliderNav == 'true') ) : ?>
                    <div class="rts-why-chosse-pagination">
                        <?php if( !empty($sliderDots == 'true') ) : ?>            
                            <div class="swiper-pagination-two swiper-pagination-<?php echo $unique;?>"></div> 
                        <?php endif; ?>
                        <?php if (!empty($sliderNav == 'true')) : ?>   
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        <?php else : echo $blank;
                        endif; ?>
                    </div>
                <?php endif; ?> 
            </div>
           
            <script type="text/javascript">
            jQuery(document).ready(function(){
                var swiper = new Swiper(".rt_slider-<?php echo esc_attr($unique); ?>", {				
                    slidesPerView: 1,  
                   
                    speed: <?php echo esc_attr($autoplaySpeed); ?>,
                    loop:  <?php echo esc_attr($infinite ); ?>,
                    <?php echo esc_attr($slider_autoplay); ?>,
                    centeredSlides: <?php echo esc_attr($centerMode); ?>,

                    spaceBetween:  <?php echo esc_attr($item_gap); ?>,
                    pagination: {
                        el: ".swiper-pagination-<?php echo $unique;?>",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".rt_slider-<?php echo esc_attr($unique); ?> .swiper-button-next",
                        prevEl: ".rt_slider-<?php echo esc_attr($unique); ?> .swiper-button-prev",
                    },
                    breakpoints: { 
                        <?php                       
                        echo (!empty($col_xs)) ?  '320: { slidesPerView: '. $col_xs .' },' : '';
                        echo (!empty($col_sm)) ?  '767: { slidesPerView: '. $col_sm .' },' : '';
                        echo (!empty($col_md)) ?  '991: { slidesPerView: '. $col_md .' },' : '';
                        echo (!empty($col_lg)) ?  '1199: { slidesPerView: '. $col_lg .' },' : '';
                        ?>
                        1399: {
                            slidesPerView: <?php echo esc_attr($col_xl); ?>,
                            spaceBetween:  <?php echo esc_attr($item_gap); ?>
                        }
                    }                    
                });
            });
        </script>
        <?php

    }
}