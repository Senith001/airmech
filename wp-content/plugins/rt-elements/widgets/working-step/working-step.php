<?php
/**
 * Icon List
 *
 */
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class RTS_Working_Step_Widget extends \Elementor\Widget_Base {

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
        return 'rtfeatureslist';
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
        return esc_html__( 'RT Working Step', 'rtelements' );
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
        return [ 'list', 'title', 'features', 'heading', 'plan' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'_section_header',
			[
				'label' => esc_html__( 'Content', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);      

        $repeater = new Repeater();     

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Step', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Step 1', 'rtelements'),
                'label_block' => true,
                
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Process Title', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Consultation', 'rtelements'),
                'label_block' => true,                
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
            'connector',
            [
                'label' => esc_html__('Process Connector', 'rtelements'),
                'type' => Controls_Manager::ICONS,                       
                'separator'   => 'before',
            ]
        );

        $repeater->add_control(
			'bg_style',
			[
				'label'   => esc_html__('Select Step Background', 'rtelements'),
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

		$repeater->add_control(
			'step_bg_color',
			[
				'label' => esc_html__('number  Background', 'rtelements'),				
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .de-step' => 'background: {{VALUE}};',
				],
				'condition' => [
					'bg_style' => 'custom',
				],	
			]
		);

        $repeater->add_control(
			'enable_animation',
			[
				'label' => esc_html__('Enable Animation', 'rtelements'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'rtelements'),
				'label_off' => esc_html__('No', 'rtelements'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater->add_control(
			'animation_style',
			[
				'label'   => esc_html__('Select Animation Style', 'rtelements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'defult' => esc_html__('default', 'rtelements'),
					'wow fadeInUp' => esc_html__('FadeIn UP', 'rtelements'),
					'wow fadeInDown' => esc_html__('FadeIn Down', 'rtelements'),
					'wow fadeInLeft' => esc_html__('FadeIn Left', 'rtelements'),
					'wow fadeInRight' => esc_html__('FadeIn Right', 'rtelements'),
					
				],
				'separator' => 'before',
				'condition' => [
					'enable_animation' => 'yes',
				],		
			]
		);

        $repeater->add_control(
			'delay',
			[
				'label' => esc_html__( 'Animation Delay', 'textdomain' ),
                'description' =>esc_html__( 'Animation Delay example (.4s)', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
					'enable_animation' => 'yes',
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
                
            ]
        );
        $this->end_controls_section();   
        
        // STYLE 

        //  Item 
        $this->start_controls_section(
            'slider_styles',
            [
                'label' => esc_html__('Item Wrapper', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background',
				'label' => esc_html__( 'Background', 'rtelements' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .de-step',
			]
		);
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-step' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                   ],
            ]
        );
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-step' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                   ],
            ]
        );
        
        $this->end_controls_section(); 
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
                    '{{WRAPPER}} .de-step h4' => 'color: {{VALUE}}',
                    
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .de-step h4',
            ]
        );
        
        $this->end_controls_section(); 
            
        // Step Style 
        $this->start_controls_section(
            'step_styles',
            [
                'label' => esc_html__('Step Style', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'step_color',
            [
                'label' => esc_html__('Color', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .de-step .d-number' => 'color: {{VALUE}}',                    
                ],
            ]
        );

        $this->add_control(
            'step_bg',
            [
                'label' => esc_html__('Background', 'rtelements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .de-step .d-number' => 'color: {{VALUE}}',                    
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'step_typography',
                'selector' => '{{WRAPPER}} .de-step .d-number',
            ]
        );

        $this->add_responsive_control(
            'step__padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-step .d-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                   ],
            ]
        );
        $this->add_responsive_control(
            'step__margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-step .d-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
            ]
        );
        $this->add_responsive_control(
            'stepr_border_radius',
            [
                'label' => esc_html__('Border Radius', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-step .d-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
            ]
        );
        $this->end_controls_section(); 

        // Icon Style 
        $this->start_controls_section(
            'icon_styles',
            [
                'label' => esc_html__('Icon Style', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .working-area .de-step i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .working-area .de-step svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .working-area .de-step svg path' => 'fill: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .de-step i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .de-step svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'icon__margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .de-step i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .de-step svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
            ]
        );
        $this->end_controls_section(); 
    } 

	protected function render() {
        $settings = $this->get_settings_for_display();
    ?>
    <div class="row working-area">
        <?php
            foreach ( $settings['logo_list'] as $index => $item ) :            
            $title = !empty($item['title']) ? $item['title'] : '';                         
            $name = !empty($item['name']) ? $item['name'] : '';
            $bg_box = !empty($item['bg_style']) ? $item['bg_style'] : '';

            $animation = $item['animation_style'] ? $item['animation_style'] : '';
             $delay = $item['delay'] ? 'data-wow-delay="'.$item['delay'].'"' : ''; 
        ?>
        <div class="col-lg-3 col-6 <?php echo $animation;?>" <?php echo $delay;?>>
            <div class="de-step text-light <?php echo esc_attr($bg_box);?>">
                <?php if($name) :?>
                    <div class="d-number"><?php echo esc_html($name);?></div>
                <?php endif; ?>
                <?php if($title) :?>
                    <h4><?php echo esc_html($title);?></h4>
                <?php endif; ?>   
                <?php if(!empty($item['connector'])) : ?>
						<?php \Elementor\Icons_Manager::render_icon( $item['connector'], [ 'aria-hidden' => 'true' ] ); ?>				
				<?php endif; ?>	            
            </div>     
        </div>    
        <?php endforeach; ?>
    </div>
    <?php
    }
}
