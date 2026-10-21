<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Reactheme_Button_Widget extends \Elementor\Widget_Base {

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
	public function get_name() {
		return 'react-button';
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
	public function get_title() {
		return esc_html__( 'RT Button', 'rtelements' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve counter widget icon.
	 *
	 * @since 1.0.
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-menu';
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
	public function get_categories() {
        return [ 'rtelements_category' ];
    }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'button' ];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => esc_html__( 'Content', 'rtelements' ),
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'   => esc_html__( 'Select Style', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'primary_btn',
				'separator' => 'before',
				'options' => [					
					'primary_btn' => esc_html__( 'Primary Button', 'rtelements'),
					
				],
			]
		);
		
		$this->add_control(
			'btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'rtelements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Sample',
				'placeholder' => esc_html__( 'Button Text', 'rtelements' ),
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'btn_link',
			[
				'label'       => esc_html__( ' Button Link', 'rtelements' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,						
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
                    '{{WRAPPER}} .react-button' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .rt_btn_render' => 'text-align: {{VALUE}}',
                ]
            ]
        );

	
		
		
		
		$this->end_controls_section();	

		//********** STYLE **********//
		$this->start_controls_section(
		    '_section_style_button',
		    [
		        'label' => esc_html__( 'Button', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->start_controls_tabs('_tabs_button');

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
		            '{{WRAPPER}} .react-button a' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rt_btn_render a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .react-button a, {{WRAPPER}} .rt_btn_render a',
		      
		    ]
		);
		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'background_normal',
				'label' => esc_html__( 'Background', 'rtelements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' =>'{{WRAPPER}} .react-button a, {{WRAPPER}} .rt_btn_render a::after, {{WRAPPER}} .rts-btn.btn-primary-4-border',
				'condition' => [
					'button_style' => [ 'primary_btn', 'secondary_btn', 'secondary_btn_2', 'btn_style_4','btn_style_6'],
				],
			]
		);
		// Button Style 5 Border After Before Color 
		$this->add_control(
		    'btn_style5_after_color',
		    [
		        'label' => esc_html__( 'Border After Color', 'rtelements' ),
		        'type' => Controls_Manager::COLOR,		      
				'selectors' => [ 
					'{{WRAPPER}} .rt_btn_render a.under-line-btn::after' => 'background: {{VALUE}};',
		         ],
				'condition' => [
					'button_style' => ['btn_style_5'],
				],
		    ]
		);
		$this->add_control(
		    'btn_style5_before_color',
		    [
		        'label' => esc_html__( 'Border Before Color', 'rtelements' ),
		        'type' => Controls_Manager::COLOR,		      
				'selectors' => [ 
					'{{WRAPPER}} .rt_btn_render a.under-line-btn::before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .rts-btn.btn-primary-gradient-border::before' => 'background: {{VALUE}};',					
		         ],
				'condition' => [
					'button_style' => ['btn_style_5','btn_style_6'],
				],
		    ]
		);
		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_border',
		        'selector' => '{{WRAPPER}} .react-button a, {{WRAPPER}} .rt_btn_render a',
		    ]
		);

		$this->add_control(
		    'button_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rtelements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .react-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',        
		            '{{WRAPPER}} .rt_btn_render a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',        
		            '{{WRAPPER}} .rts-btn.btn-primary-gradient-border::after,{{WRAPPER}} .rts-btn.btn-primary-gradient-border::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',        
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_box_shadow',
		        'selector' => '{{WRAPPER}} .react-button a, {{WRAPPER}} .rt_btn_render a',
		    ]
		);
		
		$this->add_responsive_control(
		    'link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rtelements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .react-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .rt_btn_render a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		            '{{WRAPPER}} .react-button a:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rt_btn_render a:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'link_hover_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rtelements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rt_btn_render a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_hover_typography',
		        'selector' => '{{WRAPPER}} .react-button a:hover, {{WRAPPPER}} .rt_btn_render a:hover',
		        
		    ]
		);

		$this->add_group_control(
		    Group_Control_Background::get_type(),
			[
				'name' => 'hover_background',
				'label' => esc_html__( 'Background', 'rtelements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .react-button a:hover, {{WRAPPER}} .rt_btn_render a::before, {{WRAPPER}} .rts-btn.btn-primary-4-border:hover,{{WRAPPER}} .rts-btn.btn-primary-gradient-border:hover::after',
				'condition' => [
					'button_style' => [ 'primary_btn', 'secondary_btn', 'secondary_btn_2', 'btn_style_4','btn_style_6'],
				],
			]
		);	

		$this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
		        'name' => 'button_hover_border',
		        'selector' => '{{WRAPPER}} .react-button a:hover, {{WRAPPER}} .rt_btn_render a:hover',
		    ]
		);

		$this->add_control(
		    'button_hover_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rtelements' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .react-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .rt_btn_render a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .rts-btn.btn-primary-gradient-border:hover::after,{{WRAPPER}} .rts-btn.btn-primary-gradient-border:hover::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',   
		        ],
		    ]
		);
		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .react-button a:hover, {{WRAPPER}} .rt_btn_render a:hover',
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
		$this->add_inline_editing_attributes( 'btn_text', 'basic' );
        $this->add_render_attribute( 'btn_text', 'class', 'btn_text' );
		
	?>	
		
		
		
		
			<div class="react-button  <?php echo esc_attr($settings['button_style']);?>">
				<?php $target = $settings['btn_link']['is_external'] ? 'target=_blank' : '';?>
				<a class="react_button " href="<?php echo esc_url($settings['btn_link']['url']);?>" <?php echo esc_attr($target);?>>				
					<span <?php echo $this->print_render_attribute_string('btn_text');?>> <?php echo esc_html($settings['btn_text']);?></span>
				</a>
			</div>
	

	<?php 
	}
}