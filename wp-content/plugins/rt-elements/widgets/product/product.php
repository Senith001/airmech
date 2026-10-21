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

class ReacTheme_Elementor_Product_Grid_Widget extends \Elementor\Widget_Base {

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
		return 'rt-product-grid';
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
		return __( 'RT Product Grid', 'rtelements' );
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
			'product_grid_style',
			[
				'label'   => esc_html__( 'Select Style', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Style 1',
				],											
			]
		);
		$this->add_control(
			'product_category',
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
            'product_word_show',
            [
                'label' => esc_html__( 'Show Content Limit', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '20', 'rtelements' ),
                'separator' => 'before',
				'default' => '20',
            ]
        );
		$this->add_control(
			'product_columns',
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
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,				
				'options' => [				
					'date' => esc_html__( 'Date', 'rtelements' ),	
					'menu_order'    => esc_html__( 'Menu Order', 'rtelements' ),			
				],
				'separator' => 'before',
				'default' => 'menu_order',							
			]
		);
		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,				
				'options' => [
					'ASC' => esc_html__( 'ASC', 'rtelements' ),				
					'DESC' => esc_html__( 'DESC', 'rtelements' ),						
				],
				'separator' => 'before',	
				'default' => 'DESC',						
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
			'show_btn',
			[
				'label' => esc_html__( 'Show Button', 'rtelements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rtelements' ),
				'label_off' => esc_html__( 'Hide', 'rtelements' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button Text', 'rtelements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'rtelements' ),
				'condition' => [
                    'show_btn' => 'yes',
                ],
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
                    '{{WRAPPER}} .grid-product .grid .row' => '--bs-gutter-y: {{SIZE}}{{UNIT}} !important;',
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
                    '{{WRAPPER}} .grid-product .grid .row' => '--bs-gutter-x: {{SIZE}}{{UNIT}} !important;',
                ],
			]
		);
		$this->add_control(
			'product_badge_show',
			[
				'label'   => esc_html__( 'Product Badge Show / Hide', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hide',				
				'options' => [
					'hide' => 'Hide',
					'show' => 'Show',
				],											
			]
		);
				
		$this->end_controls_section();

		$this->start_controls_section(
			'product_wrap_styles',
			[
				'label' => esc_html__( 'Item', 'rtelements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'wrapper_background',
				'label' => esc_html__( 'Background', 'rtelements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .grid-product .productItem',
			]
		);	
		
		$this->add_control(
            'wrapper_hover_background',
            [
                'label' => esc_html__( 'Hover Background', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-product .productItem .bg-light ' => 'background: {{VALUE}} !important;',    
                ],                
            ]
        );
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wrapper_border',
				'selector' => '{{WRAPPER}} .grid-product .productItem',
			]
		);
		$this->add_control(
			'wrapper_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .grid-product .productItem' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
					'{{WRAPPER}} .grid-product .productItem' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
					'{{WRAPPER}} .grid-product .productItem' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
                    '{{WRAPPER}} .grid-product .productItem .p-title ' => 'color: {{VALUE}};',    
                ],                
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                                    
                    '{{WRAPPER}} .grid-product .productItem .p-title:hover' => 'color: {{VALUE}};',                                     
                ],                
            ]
            
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .grid-product .productItem .p-title',                    
			]
		);
		$this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-product .productItem .p-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				 ],
            ]
        );
		$this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
				'separator' => 'before',          
                'selectors' => [
                    '{{WRAPPER}} .grid-product .productItem .p-desc' => 'color: {{VALUE}};',      
                ],                
            ]
        );	
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'des_typography',
				'label' => esc_html__( 'Description Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .grid-product .productItem .p-desc',            
			]
		);
		$this->add_responsive_control(
            'desc-margin',
            [
                'label' => esc_html__('Description Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-product .productItem .p-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				 ],
            ]
        );

        $this->end_controls_section();
		// Badge 
		$this->start_controls_section(
			'section_slider_badge_style',
			[
				'label' => esc_html__( 'Badge', 'rtelements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'badge_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .grid-product .productItem .p-badge ' => 'color: {{VALUE}};',    
                ],                
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .grid-product .productItem .p-badge',                    
			]
		);
		$this->add_responsive_control(
            'badge_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-product .productItem .p-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				 ],
            ]
        );

        $this->end_controls_section();
		// Button 
        $this->start_controls_section(
				'_section_style_button',
				[
					'label' => esc_html__( 'Button', 'rtelements' ),
					'tab' => Controls_Manager::TAB_STYLE,
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
							'label' => esc_html__( 'Text Color', 'rtelements' ),
							'type' => Controls_Manager::COLOR,		      
							'selectors' => [
								'{{WRAPPER}} .grid-product .productItem a.btn-main' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'content_typography',
							'selector' => '{{WRAPPER}} .grid-product .productItem a.btn-main',
						]
					);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name' => 'background_normal',
							'label' => esc_html__( 'Background', 'rtelements' ),
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .grid-product .productItem a.btn-main',
						]
					);	
					$this->add_responsive_control(
						'button_padding',
						[
							'label' => esc_html__('Padding', 'rtelements'),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => ['px', '%', 'em'],
							'selectors' => [
								'{{WRAPPER}} .grid-product .productItem a.btn-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
							'label' => esc_html__( 'Text Color', 'rtelements' ),
							'type' => Controls_Manager::COLOR,		      
							'selectors' => [
								'{{WRAPPER}} .grid-product .productItem a.btn-main:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name' => 'background',
							'label' => esc_html__( 'Background', 'rtelements' ),
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .grid-product .productItem a.btn-main:hover',
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
	
?>

	<div class="rt-product-style<?php echo esc_attr($settings['product_grid_style']); ?> grid-product">
		<div class="grid">
			<div class="row">
				<?php
					$cat = $settings['product_category'];
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

					if(empty($cat)){
						$best_wp = new wp_Query(array(
								'post_type'      => 'rt-products',
								'posts_per_page' => $settings['per_page'],	
								'order'        	 => $settings['order'],							
								'orderby'        => $settings['orderby'],							
						));	  
					}   
					else{
						$best_wp = new wp_Query(array(
								'post_type'      => 'rt-products',
								'posts_per_page' => $settings['per_page'],	
								'order'        	 => $settings['order'],							
								'orderby'        => $settings['orderby'],			
								'tax_query'      => array(
									array(
										'taxonomy' => 'rt-product-category',
										'field'    => 'slug', //can be set to ID
										'terms'    => $cat //if field is ID you can reference by cat/term number
									),
								)
						));	  
					}
					$x=1;
				    while($best_wp->have_posts()): $best_wp->the_post();
					$product_sell_badge      = get_post_meta( get_the_ID(), 'product_sell_badge', true );
					$limit = $settings['product_word_show'];

					if('1' == $settings['product_grid_style']){
						include plugin_dir_path(__FILE__)."/style1.php";
					}

                    $x++;
					endwhile;
                    
					wp_reset_query();  ?> 
			</div>
		</div>
	</div>

	<?php	
	}
	public function getCategories(){
		$cat_list = [];
			if ( post_type_exists('rt-products') ) { 
			$terms = get_terms( array(
				'taxonomy'    => 'rt-product-category',
				'hide_empty'  => true            
			));
		}
		foreach($terms as $post) {
			$cat_list[$post->slug]  = [$post->name];
		}
	 return $cat_list;
}
}?>