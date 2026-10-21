<?php
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Reactheme_Portfolio_Grid_Widget extends \Elementor\Widget_Base {

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
		return 'rt-portfolio-grid';
	}		

	/**
	 * Get widget title.
	 *
	 * Retrieve rsgallery widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'RT Portfolio Grid', 'rtelements' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve rsgallery widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the rsgallery widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        return [ 'pielements_category' ];
    }

	
	/**
	 * Register rsgallery widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {


		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'portfolio_grid_style',
			[
				'label'   => esc_html__( 'Select Style', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Style 1',
					'2' => 'Style 2',
					'3' => 'Style 3',
				],											
			]
		);
		$this->add_control(
			'portfolio_category',
			[
				'label'   => esc_html__( 'Category', 'rtelements' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options' => $this->getCategories(),
				'multiple' => true,	
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
                ],
                'separator' => 'before',
            ]
        );

	
		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Project Show Per Page', 'rtelements' ),
				'type' => Controls_Manager::TEXT,
				'default' => -1,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'portfolio_columns',
			[
				'label'   => esc_html__( 'Columns', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,				
				'options' => [
					'6' => esc_html__( '2 Column', 'rtelements' ),
					'4' => esc_html__( '3 Column', 'rtelements' ),
					'3' => esc_html__( '4 Column', 'rtelements' ),
					'2' => esc_html__( '6 Column', 'rtelements' ),
					'12' => esc_html__( '1 Column', 'rtelements' ),					
				],
				'separator' => 'before',							
			]
		);

		$this->add_control(
            'btn_content',
            [
                'label' => esc_html__('Button', 'rtelements'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Text', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'View case study', 'rtelements' ),
				'placeholder' => esc_html__( 'Type your text here', 'rtelements' ),
                'condition' => ['portfolio_grid_style' => ['2']],
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'rt rt-arrow-up-right',
					'library' => 'rt-icon',
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
                'condition' => ['portfolio_grid_style' => ['1','2','3']],
			]
		); 

		$this->add_control(
            'item__style',
            [
                'label' => esc_html__('Item', 'rtelements'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
		
		$this->add_responsive_control(
			'item_bottom_spacing',
			[
				'label' => esc_html__( 'Item Bottom Gap', 'rtelements' ),
				'type' => Controls_Manager::SLIDER,
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
				'default' => [
					'unit' => '%',
					'size' => 6,
				],	
				'selectors' => [
                    '{{WRAPPER}} .grid-portfolio .grid .row' => '--bs-gutter-y: {{SIZE}}{{UNIT}} !important;',
                ],
			]
		);

		$this->add_responsive_control(
			'item_mid_spacing',
			[
				'label' => esc_html__( 'Item Middle Gap', 'rtelements' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
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
				'default' => [
					'unit' => '%',
					'size' => 5,
				],	
				'selectors' => [
                    '{{WRAPPER}} .grid-portfolio .grid .row' => '--bs-gutter-x: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .single-portfolio-box-style.style-five' => 'gap: {{SIZE}}{{UNIT}} !important;',                ],
			]
		);
				
		$this->end_controls_section();

		$this->start_controls_section(
			'portfolio_wrap_styles',
			[
				'label' => esc_html__( 'Wrapper', 'rtelements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_background',
				'label' => esc_html__( 'Background', 'rtelements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .dynamic, {{WRAPPER}} .rt-portfolio-style2 .grid .col-md-6:nth-child(even) .single-portfolio-box-style.style-five',
			]
		);	
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wrapper_border',
				'selector' => '{{WRAPPER}} .dynamic',
			]
		);
		$this->add_control(
			'wrapper_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);		
		$this->add_control(
			'wrapper_padding',
			[
				'label' => esc_html__( 'Padding', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);	
		$this->add_control(
			'wrapper_margin',
			[
				'label' => esc_html__( 'Margin', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_section();
		
        $this->start_controls_section(
			'section_slider_style',
			[
				'label' => esc_html__( 'Style', 'rtelements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dynamic .p-title a' => 'color: {{VALUE}};',   
                    '{{WRAPPER}} .dynamic .title' => 'color: {{VALUE}};',   
                ],                
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dynamic .p-title a:hover' => 'color: {{VALUE}};',                                     
                    '{{WRAPPER}} .dynamic .title:hover' => 'color: {{VALUE}};',                                     
                ],                
            ]
            
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .dynamic .p-title,{{WRAPPER}} .dynamic .title',                    
			]
		);
		$this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',          
				'condition' => ['portfolio_grid_style' => ['1','2']],
                'selectors' => [
                    '{{WRAPPER}} .dynamic .desc' => 'color: {{VALUE}};',                 
                    '{{WRAPPER}} .dynamic p' => 'color: {{VALUE}};',       
                ],                
            ]
        );	
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'des_typography',
				'label' => esc_html__( 'Description Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .dynamic .desc,{{WRAPPER}} .dynamic p',            
				'condition' => ['portfolio_grid_style' => ['1','2']],
			]
		);
        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Category Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .dynamic .p-category a' => 'color: {{VALUE}};',                 
                    '{{WRAPPER}} .dynamic .pre a' => 'color: {{VALUE}} !important;', 
                    '{{WRAPPER}} .dynamic .inner-content span a' => 'color: {{VALUE}} !important;', 
                ],                
            ]
        );
        $this->add_control(
            'category_color_hover',
            [
                'label' => esc_html__( 'Category Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dynamic .p-category a:hover' => 'color: {{VALUE}};',     
					'{{WRAPPER}} .dynamic .pre a:hover' => 'color: {{VALUE}} !important;',  
                    '{{WRAPPER}} .dynamic .inner-content span a' => 'color: {{VALUE}} !important;', 
                ],                
            ]            
        ); 		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'spinddner_typography',
				'label' => esc_html__( 'Category Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .dynamic .p-category a,{{WRAPPER}} .dynamic .pre a,{{WRAPPER}} .dynamic .inner-content span a',
			]
		);

        $this->end_controls_section();

        	$this->start_controls_section(
        		    '_section_style_button',
        		    [
        		        'label' => esc_html__( 'Button', 'rtelements' ),
        		        'tab' => Controls_Manager::TAB_STYLE,
        		        'condition' => [
							'portfolio_grid_style' => ['1','2','3'],
						],
        		    ]
        		);
        		$this->start_controls_tabs( '_tabs_button' );

        		$this->start_controls_tab(
                    'style_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', 'rtelements' ),
                    ]
                ); 
        		$this->add_control(
        		    'btn_text_color',
        		    [
        		        'label' => esc_html__( 'Color', 'rtelements' ),
        		        'type' => Controls_Manager::COLOR,		      
        		        'selectors' => [
							'{{WRAPPER}} .dynamic .porfolio_icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .dynamic .porfolio_icon svg' => 'fill: {{VALUE}};',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4,{{WRAPPER}} .dynamic .rts-btn.btn-primary-4 i' => 'color: {{VALUE}};',							
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4 svg path' => 'fill: {{VALUE}};',							
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right i' => 'color: {{VALUE}};',	
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right svg path' => 'fill: {{VALUE}};',	
        		        ],
        		    ]
        		);
				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'content_typography',
						'selector' => '{{WRAPPER}} .dynamic .rts-btn.btn-primary-4, {{WRAPPER}} .dynamic .thumbnail .icon-top-right',
						'condition' => [
							'portfolio_grid_style' => ['2','3'],
						],
					]
				);
        		$this->add_group_control(
        		    Group_Control_Background::get_type(),
        			[
        				'name' => 'background_normal',
        				'label' => esc_html__( 'Background', 'rtelements' ),
        				'types' => [ 'classic', 'gradient' ],
        				'selector' => '{{WRAPPER}} .dynamic .porfolio_icon,{{WRAPPER}} .dynamic .rts-btn.btn-primary-4,{{WRAPPER}} .rt-portfolio-style2 .grid .col-md-6:nth-child(even) .single-portfolio-box-style.style-five .inner-content .left-content .rts-btn,{{WRAPPER}} .dynamic .thumbnail .icon-top-right',
        			]
        		);				
				$this->add_responsive_control(
					'icon_size',
					[
						'label' => esc_html__( 'Icon Size', 'rtelements' ),
						'type' => Controls_Manager::SLIDER,
						'separator' => 'before',
						'size_units' => [ 'px', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
								'step' => 1,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 16,
						],	
						'selectors' => [
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4 i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4 svg' => 'width: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .porfolio_icon svg' => 'width: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .porfolio_icon i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right svg' => 'width: {{SIZE}}{{UNIT}} !important;',
						],
					]
				);
				$this->add_responsive_control(
					'icon_space',
					[
						'label' => esc_html__( 'Icon Spacing', 'rtelements' ),
						'type' => Controls_Manager::SLIDER,
						'size_units' => [ 'px', 'custom' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 50,
								'step' => 1,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4 i' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4 svg' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .porfolio_icon svg' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .porfolio_icon i' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right svg' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right i' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
						],
					]
				);
				$this->add_control(
					'icon_padding',
					[
						'label' => esc_html__( 'Padding', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'selectors' => [
							'{{WRAPPER}} .dynamic .porfolio_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
						],
					]
				);
				$this->add_control(
					'icon_margin',
					[
						'label' => esc_html__( 'Margin', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'selectors' => [
							'{{WRAPPER}} .dynamic .porfolio_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
						],
					]
				);
				$this->add_control(
					'icon_border_radius',
					[
						'label' => esc_html__( 'Border Radius', 'rtelements' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
						'selectors' => [
							'{{WRAPPER}} .dynamic .porfolio_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
						],
					]
				);

        	$this->end_controls_tab();

        	$this->start_controls_tab(
                    'style_hover_tab',
                    [
                        'label' => esc_html__( 'Hover', 'rtelements' ),
                    ]
                ); 

        		$this->add_control(
        		    'btn_text_hover_color',
        		    [
        		        'label' => esc_html__( 'Hover Color', 'rtelements' ),
        		        'type' => Controls_Manager::COLOR,		      
        		        'selectors' => [
        		            '{{WRAPPER}} .dynamic .porfolio_icon i:hover' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .dynamic .porfolio_icon svg:hover' => 'fill: {{VALUE}} !important;',
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4:hover,{{WRAPPER}} .dynamic .rts-btn.btn-primary-4:hover i' => 'color: {{VALUE}};',							
							'{{WRAPPER}} .dynamic .rts-btn.btn-primary-4:hover svg' => 'fill: {{VALUE}};',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right:hover i' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .dynamic .thumbnail .icon-top-right:hover svg path' => 'fill: {{VALUE}} !important;',
        		        ],
        		    ]
        		);
        		$this->add_group_control(
        		    Group_Control_Background::get_type(),
        			[
        				'name' => 'background',
        				'label' => esc_html__( 'Background', 'rtelements' ),
        				'types' => [ 'classic', 'gradient' ],
        				'selector' => '{{WRAPPER}} .dynamic .porfolio_icon a:hover,{{WRAPPER}}  .dynamic .rts-btn.btn-primary-4:hover,{{WRAPPER}} .rt-portfolio-style2 .grid .col-md-6:nth-child(even) .single-portfolio-box-style.style-five .inner-content .left-content .rts-btn:hover,{{WRAPPER}} .dynamic .thumbnail .icon-top-right:hover',
        			]
        		);
        		$this->end_controls_tab();
        		$this->end_controls_tabs();	
        	$this->end_controls_section();
	}

	/**
	 * Render rsgallery widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
	$settings = $this->get_settings_for_display();
	$popup_port_title_color = !empty( $settings['popup_port_title_color']) ? 'style="color: '.$settings['popup_port_title_color'].'"' : '';
	$popup_port_content_color = !empty( $settings['popup_port_content_color']) ? 'style="color: '.$settings['popup_port_content_color'].'"' : '';
	$popup_port_info_color = !empty( $settings['popup_port_info_color']) ? 'style="color: '.$settings['popup_port_info_color'].'"' : '';
	$popup_port_background = !empty( $settings['popup_port_background']) ? 'style="background: '.$settings['popup_port_background'].'"' : '';
	
	$stylee = 'style'.$settings['portfolio_grid_style'];
?>

	<div class="rt-portfolio-style<?php echo esc_attr($settings['portfolio_grid_style']); ?> grid-portfolio">
		<div class="grid">
			<div class="row">
				<?php 
					if($stylee){
						include plugin_dir_path(__FILE__)."/$stylee.php";
					}else{
						include plugin_dir_path(__FILE__)."/style1.php";
					}
					
				?>
			</div>
		</div>
	</div>

	<?php	

	}
public function getCategories(){
    $cat_list = [];
     	if ( post_type_exists( 'rt-portfolios' ) ) { 
      	$terms = get_terms( array(
         	'taxonomy'    => 'rt-portfolio-category',
         	'hide_empty'  => true            
     	) );
        
        foreach($terms as $post) {
        	$cat_list[$post->slug]  = [$post->name];
        }
	}  
    return $cat_list;
}
}?>