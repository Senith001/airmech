<?php

use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

defined('ABSPATH') || die();

class Reactheme_Elementor_Services_Grid_Widget extends \Elementor\Widget_Base
{


	/**
	 * Get widget name.
	 *
	 * Retrieve counter widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'rt-service-grid';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve counter widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('RT Services', 'rtelements');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve counter widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'glyph-icon flaticon-support';
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_categories()
	{
		return ['pielements_category'];
	}


	/**
	 * Register services widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{


		$this->start_controls_section(
			'service_general_content',
			[
				'label' => esc_html__('General', 'rtelements')
			]
		);

		$this->add_control(
			'general_section_style',
			[
				'label'     => esc_html__('Service Style', 'rtelements'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'style_one',
				'options'   => [
					'style_one'      => esc_html__('Style 1', 'rtelements'),
					'style_two'      => esc_html__('Style 2', 'rtelements'),
					'style_three'    => esc_html__('Style 3', 'rtelements'),					
					'style_four'     => esc_html__('Style 4', 'rtelements'),	
					'style_five'     => esc_html__('Style 5', 'rtelements'),					
				],
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'service_contents',
			[
				'label' => esc_html__('Content', 'rtelements')
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-clock',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
				'condition' => [
					'general_section_style' => array('style_one', 'style_two', 'style_four', 'style_five')
				],
			]
		);	

		$this->add_control(
            'service_image',
            [
                'label' => esc_html__( 'Choose Image', 'rtelements' ),
                'type' => \Elementor\Controls_Manager::MEDIA,     
                'separator' => 'before',
				'condition' => [
					'general_section_style' => array('style_one', 'style_three', 'style_four', 'style_five')
				],
            ]
        ); 

		$this->add_control(
			'image_position',
			[
				'label'     => esc_html__('Image Position', 'rtelements'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'style_one',
				'options'   => [
					''      => esc_html__('Content Top', 'rtelements'),
					's2_image_bottom'      => esc_html__('Content Bottom', 'rtelements'),					
				],
				'condition' => [
					'general_section_style' => ['style_one'],
				],
			]
		);

		$this->add_control(
            'service-title',
            [
                'label' => esc_html__( 'Title', 'rtelements' ),
                'label_block'=> true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Engaging Content', 'rtelements' ),
            ]
        );

		$this->add_control(
            'service-des',
            [
                'label' => esc_html__( 'Description', 'rtelements' ),
                'label_block'=> true,
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Get organic traffic and high rankings with multi-team collaboration that will help you optimize on-page and off-page SEO.', 'rtelements' ),
            ]
        );        

		
		
        $this->add_control(
            'service-btn',
            [
                'label' => esc_html__( 'Button Text', 'rtelements' ),
                'label_block'=> true,
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Get Started', 'rtelements' ),
				'condition' => [
					'general_section_style' => array('style_one', 'style_three','style_four', 'style_five')
				],
            ]
        );
		

        $this->add_control(
            'service-url',
            [
                'label' => esc_html__( 'Button URL', 'rtelements' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'Insert your link',
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'general_section_style' => array('style_one', 'style_three','style_four')
				],
            ]
        );

		
				
		$this->end_controls_section();


		$this->start_controls_section(
            '_section_animation',
            [
                'label' => esc_html__( 'Animation', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        ); 

        $this->add_control(
            'rt_image_animation',
            [
                'label'   => esc_html__('Select Animation', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'default-animation' => esc_html__('default', 'rtelements'),  
					'wow fadeInUp' => esc_html__('FadeIn UP', 'rtelements'),
					'wow fadeInDown' => esc_html__('FadeIn Down', 'rtelements'),
					'wow fadeInLeft' => esc_html__('FadeIn Left', 'rtelements'),
					'wow fadeInRight' => esc_html__('FadeIn Right', 'rtelements'),     
                    'wow scaleIn' => esc_html__('Scale In', 'rtelements'),  
                    'wow scaleOut' => esc_html__('scale Out', 'rtelements'),  
                               
                ],
            ]
        );

        $this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Animation Delay', 'textdomain' ),
                'description' =>esc_html__( 'Animation Delay example (.4s)', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
		);

        $this->end_controls_section();


		/*============= Services Styles ============*/

		$this->start_controls_section(
		    'service-styles',
		    [
		        'label' => esc_html__( 'Box Style', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'service-normal-box-background',
						'types' => [ 'classic', 'gradient', 'video' ],
						'selector' => '{{WRAPPER}} .bg-color-3, {{WRAPPER}} .sBox-bg',
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'service-normal-border',
						'selector' => '{{WRAPPER}} .rounded-20px',
					]
				);
				$this->add_responsive_control(
				    'service-normal-border-radius',
				    [
				        'label' => esc_html__( 'Border Radius', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .rounded-20px' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				           
				        ],
				    ]
				);
				
				
	      

		$this->end_controls_section();


		// Icon style
		$this->start_controls_section(			
		    '_sec-icon-styles',
		    [
		        'label' => esc_html__( 'Icon', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);
		
	
				$this->add_control(
					'_icon_heading',
					[
						'label' => esc_html__( 'Icon', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'_icon_color',
					[
						'label' => esc_html__( 'Color', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .service-area svg' => 'fill: {{VALUE}}',					
							'{{WRAPPER}} .service-area svg path' => 'fill: {{VALUE}}',					
							
						],
					]
				);	
				
				$this->add_control(
					'icon_bg_style',
					[
						'label'   => esc_html__('Select Background', 'rtelements'),
						'type'    => Controls_Manager::SELECT,
						'default' => 'custom',
						'options' => [
							'custom' => esc_html__('Custom', 'rtelements'),
							'bg-color' => esc_html__('Primary BG', 'rtelements'),
							'bg-color-2' => esc_html__('Secondary BG', 'rtelements'),
							'bg-color-3' => esc_html__('Tertiary BG', 'rtelements'),
						],
						'separator' => 'before',
							
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'service-icon-area',
						'types' => [ 'classic', 'gradient', 'video' ],
						'selector' => '{{WRAPPER}}   .service-area svg',
						'condition' => [
							'icon_bg_style' => 'custom',
				],
					]
				);		
				$this->add_responsive_control(
					'_icon_width',
					[
						'label' => esc_html__( 'Icon Size', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
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
						
							'{{WRAPPER}} .service-area svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
							
						],
					]
				);
				
				$this->add_responsive_control(
				    'normal_icon_box_border_radius',
				    [
				        'label' => esc_html__( 'Border Radius', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .service-area svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        
				        ],
				    ]
				);
				$this->add_responsive_control(
				    'normal_icon_box_margin',
				    [
				        'label' => esc_html__( 'Margin', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .service-area .sIcon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				          
				        ],
				    ]
				);
				$this->add_responsive_control(
				    'normal_icon_box_padding',
				    [
				        'label' => esc_html__( 'Padding', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .service-area svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				          
				        ],
				    ]
				);
	
		$this->end_controls_section();

		// title style
		$this->start_controls_section(			
		    '_sec-service-title-styles',
		    [
		        'label' => esc_html__( 'Title Style', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);
		
			    
			$this->add_control(
				'service_normal_title_color',
				[
					'label' => esc_html__( 'Color', 'rtelements' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .service-area h4' => 'color: {{VALUE}}',
						
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'service_normal_title_typo',
					'selector' => '{{WRAPPER}} .service-area h4',
				]
			);		       

	        
		$this->end_controls_section();	


		// description style
		$this->start_controls_section(			
		    '_sec-service-des-styles',
		    [
		        'label' => esc_html__( 'Description', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);
		
				$this->add_control(
					'service_normal_des_color',
					[
						'label' => esc_html__( 'Color', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .service-area p.disc' => 'color: {{VALUE}}',
						
						],
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'service_normal_des_typo',
						'selector' => '{{WRAPPER}} .service-area p.disc',
					]
				);
				$this->add_responsive_control(
				    'service_normal_des_margin',
				    [
				        'label' => esc_html__( 'Margin', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .service-area p.disc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				          
				        ],
				    ]
				);
		
		$this->end_controls_section();

	
		// Button style
		$this->start_controls_section(			
		    '_sec-button-styles',
		    [
		        'label' => esc_html__( 'Button', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);
		
		$this->start_controls_tabs( '_tabs_button' );	

	        $this->start_controls_tab(
	            'tab_button_normal',
	            [
	                'label' => esc_html__( 'Normal', 'rtelements' ),
	            ]
	        );
	        	$this->add_control(
					'button_normal_bg',
					[
						'label' => esc_html__( 'Background', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .service-area a.btn-main' => 'background: {{VALUE}}',							
						],
					]
				);
				$this->add_control(
					'button_normal_color',
					[
						'label' => esc_html__( 'Color', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [							
							'{{WRAPPER}} .service-area a.btn-main' => 'color: {{VALUE}}',
						],
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'button_normal_typo',
						'selector' => '{{WRAPPER}} .service-area a.btn-main',
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'button_normal_border',
						'selector' => '{{WRAPPER}} .service-area a.btn-main',
					]
				);
				$this->add_responsive_control(
				    'normal_button_border_radius',
				    [
				        'label' => esc_html__( 'Border Radius', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .service-area a.btn-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				            
				        ],
				    ]
				);
				$this->add_responsive_control(
				    'normal_button_padding',
				    [
				        'label' => esc_html__( 'Padding', 'rtelements' ),
				        'type' => Controls_Manager::DIMENSIONS,
				        'size_units' => [ 'px', 'em', '%' ],
				        'selectors' => [
				            '{{WRAPPER}} .service-area a.btn-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				        ],
				    ]
				);
				$this->add_responsive_control(
					'normal_button_width',
					[
						'label' => esc_html__( 'Button Width', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 1000,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .service-area a.btn-main' => 'width: {{SIZE}}{{UNIT}};',
							
						],
					]
				);
				
	        $this->end_controls_tab();

	        $this->start_controls_tab(
	            'tab_button_hover',
	            [
	                'label' => esc_html__( 'Hover', 'rtelements' ),
	            ]
	        );
	        	$this->add_control(
					'button_hover_bg',
					[
						'label' => esc_html__( 'Background', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .service-area a.btn-main:hover' => 'background: {{VALUE}}',							
						],
					]
				);
				$this->add_control(
					'button_hover_color',
					[
						'label' => esc_html__( 'Color', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .service-area a.btn-main:hover' => 'color: {{VALUE}}',							
						],
					]
				);
			
		
	        $this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	/**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$animation = $settings['rt_image_animation'] ? $settings['rt_image_animation'] : '';
        $delay = $settings['delay'] ? 'data-wow-delay="'.$settings['delay'].'"' : '';  
		?>		
		<?php 
		if ($settings['general_section_style'] == 'style_one') {
			include plugin_dir_path(__FILE__)."/style1.php";	
		} 
		if ($settings['general_section_style'] == 'style_two') {
			include plugin_dir_path(__FILE__)."/style2.php";	
		} 
		if ($settings['general_section_style'] == 'style_three') {
			include plugin_dir_path(__FILE__)."/style3.php";	
		} 
		if ($settings['general_section_style'] == 'style_four') {
			include plugin_dir_path(__FILE__)."/style4.php";	
		} 
		if ($settings['general_section_style'] == 'style_five') {
			include plugin_dir_path(__FILE__)."/style5.php";	
		} 
	}
}