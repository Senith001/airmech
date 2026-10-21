<?php

use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Global_Colors;


defined('ABSPATH') || die();

class ReacTheme_Elementor_Counter_Widget extends \Elementor\Widget_Base
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
		return 'rt-counter';
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
		return esc_html__('RT Counter', 'rtelements');
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
		return 'glyph-icon flaticon-count';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['counter'];
	}

	/**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__('Counter', 'rtelements'),
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__('Select Counter Style', 'rtelements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => esc_html__('Style 1', 'rtelements'),
					'style2' => esc_html__('Style 2', 'rtelements'),
				],
			]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__('Counter Number', 'rtelements'),
				'type' => Controls_Manager::NUMBER,
				'default' => 100,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'suffix',
			[
				'label' => esc_html__('Number Prefix', 'rtelements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('Prefix', 'rtelements'),
				'separator' => 'before',
			]

		);

		$this->add_control(
			'prefix',
			[
				'label' => esc_html__('Number Suffix', 'rtelements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => 'Suffix',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Counter Title', 'rtelements'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Happy Clients', 'rtelements'),
				'placeholder' => esc_html__('Clients', 'rtelements'),
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'title_position',
			[
				'label' => esc_html__('Title Position', 'rtelements'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'rtelements'),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'rtelements'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => true,
				'default' => 'bottom'
			]
		);		
		$this->add_responsive_control(
			'title_alignment',
			[
				'label' => esc_html__('Text Alignment', 'rtelements'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'rtelements'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'rtelements'),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'rtelements'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'default' => 'start',
				'selectors' => [
					'{{WRAPPER}} .count-text.top' => 'align-items: {{VALUE}}',                
				],
				'condition' => [
					'title_position' => 'top'
				]
			]
		);
		
		$this->add_control(
			'text',
			[
				'label' => esc_html__('Counter Text', 'rtelements'),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => esc_html__('On the other hand we denounce', 'rtelements'),
				'separator' => 'before',
				'condition' => ['style' => ['style2']],
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__('Alignment', 'rtelements'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'rtelements'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'rtelements'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'rtelements'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__('Justify', 'rtelements'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .counter-top-area' => 'text-align: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);
		

		$this->add_control(
			'show_icon',
			[
				'label' => esc_html__( 'Show Icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'true' => esc_html__( 'Show', 'rtelements' ),
				'false' => esc_html__( 'Hide', 'rtelements' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'condition' => ['show_icon' => 'true'],
				'label_block' => true
			]
		);
		$this->add_responsive_control(
			'icon_position',
			[
				'label' => esc_html__('Icon Position', 'rtelements'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex' => [
						'title' => esc_html__('Left', 'rtelements'),
						'icon' => 'eicon-h-align-left',
					],
					'block' => [
						'title' => esc_html__('Top', 'rtelements'),
						'icon' => 'eicon-v-align-top',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .rts-counter-list-inner' => 'display: {{VALUE}} !important'
				],
				'condition' => [
					'show_icon' => 'true',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

		/******* STYLE ********/
		$this->start_controls_section(
			'section_number',
			[
				'label' => esc_html__('Number', 'rtelements'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => esc_html__('Color', 'rtelements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .count-number span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_hover_color',
			[
				'label' => esc_html__('Hover Color', 'rtelements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-top-area:hover .count-number span' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Typography', 'rtelements'),
				'name' => 'typography_number',
				
				'selector' => '{{WRAPPER}} .count-number span',
			]
		);

		$this->add_responsive_control(
			'number_top_spacing',
			[
				'label' => esc_html__('Padding', 'rtelements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .count-number span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_top_margin',
			[
				'label' => esc_html__('Margin', 'rtelements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .count-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Sufix Typography', 'rtelements'),
				'name' => 'typography_suffix',
			
				'selector' => '{{WRAPPER}} .count-number span.suffix',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Prefix Typography', 'rtelements'),
				'name' => 'typography_prefix',
				
				'selector' => '{{WRAPPER}} .count-number span.prefix',
			]
		);
		$this->add_control(
			'gradient_color',
			[
				'label' => esc_html__( 'Gradient Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'yes' => esc_html__( 'Yes', 'rtelements' ),
				'no' => esc_html__( 'No', 'rtelements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'gradient_color',
				'label' => esc_html__('Gradient Color', 'rtelements'),
				'types' => ['gradient'],
				'exclude' => ['classic', 'image'],
				'selector' => '{{WRAPPER}} .count-number span',
				'condition' => [
					'gradient_color' => 'yes',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
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
					'{{WRAPPER}} .count-text .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Hover Color', 'rtelements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-top-area:hover .count-text .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'selector' => '{{WRAPPER}} .count-text .title',
			]
		);

		$this->add_responsive_control(
			'counter_title',
			[
				'label' => esc_html__('Padding', 'rtelements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .counter-top-area .rts-counter-list .count-text .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_content',
			[
				'label' => esc_html__('Content', 'rtelements'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'style' => 'style2' ]
			]
		);
		$this->add_control(
			'section_title_content_color',
			[
				'label' => esc_html__('Hover Color', 'rtelements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-top-area.style2 .rts-counter-list .count-text .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_title_content_typography',
				'selector' => '{{WRAPPER}} .counter-top-area.style2 .rts-counter-list .count-text .text',
			]
		);
		$this->add_responsive_control(
			'counter_title_content',
			[
				'label' => esc_html__('Padding', 'rtelements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .counter-top-area.style2 .rts-counter-list .count-text .text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'counter_title_content_margin',
			[
				'label' => esc_html__('Margin', 'rtelements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .counter-top-area.style2 .rts-counter-list .count-text .text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$this->add_inline_editing_attributes('suffix', 'basic');
		$this->add_render_attribute('suffix', 'class', 'suffix');

		$this->add_inline_editing_attributes('number', 'basic');
		$this->add_render_attribute('number', 'class', 'rs-counter');

		$this->add_inline_editing_attributes('prefix', 'basic');
		$this->add_render_attribute('prefix', 'class', 'prefix');

		$this->add_inline_editing_attributes('title', 'basic');
		$this->add_render_attribute('title', 'class', 'title');

		$blank = '';
		$icon = !empty( $settings['show_icon'] == 'true' ) ? 'true' : 'false';	
		$icon_flex = !empty( $settings['show_icon'] == 'true' ) ? 'd-flex' : '';
		$title_position = !empty($settings['title_position']) && $settings['title_position'] == 'top' ? 'top' : 'bottom';
		$animation = $settings['rt_image_animation'] ? $settings['rt_image_animation'] : '';
        $delay = $settings['delay'] ? 'data-wow-delay="'.$settings['delay'].'"' : '';  
		?>
		<?php if ($settings['style'] == 'style1' or $settings['style'] == 'style2') : ?>
			<div class="counter-top-area <?php echo esc_attr($settings['style']); ?> <?php echo esc_attr($animation); ?>" <?php echo $delay; ?>>
				<div class="rts-counter-list">
					<div class="rts-counter-list-inner <?php echo esc_attr($icon_flex); ?>">					

						<div class="count-text <?php echo esc_attr($title_position); ?>">
							<div class="count-number">
								<?php if ($settings['suffix']) : ?><span <?php echo $this->print_render_attribute_string('suffix'); ?>><?php echo esc_html($settings['suffix']); ?></span><?php endif; ?>
								<span data-letters="500" <?php echo $this->print_render_attribute_string('number'); ?>> <?php echo esc_html($settings['number']); ?></span>
								<?php if ($settings['prefix']) : ?><span <?php echo $this->print_render_attribute_string('prefix'); ?>><?php echo esc_html($settings['prefix']); ?></span><?php endif; ?>
							</div>

							<?php if (!empty($settings['title'])) : ?>
								<span <?php echo$this->print_render_attribute_string('title'); ?>> <?php echo esc_html($settings['title']); ?></span>
							<?php endif; ?>

							<?php if (!empty($settings['text']) && $settings['style'] == 'style2') : ?>
								<div class="text"> <?php echo esc_html($settings['text']); ?></div>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>
		

	<?php
	}
}
