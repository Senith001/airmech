<?php
/**
 * Elementor Buisness Hour Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class ReacThemes_Elementor_Business_Hour_Widget extends \Elementor\Widget_Base {

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
		return 'rts-business-hour';
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
		return esc_html__( 'RTS Business Hour', 'rtelements' );
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
	public function get_icon() {
		return 'glyph-icon flaticon-24-hours';
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
        return [ 'rsaddon_category' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'rts_section_title',
			[
				'label' => esc_html__( 'Content', 'rtelements' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'business_day',
			[
				'label' => esc_html__( 'Day', 'rtelements' ),
				'type' => Controls_Manager::TEXT,							
			]
		);

		$repeater->add_control(
			'business_time',
			[
				'label' => esc_html__( 'Time', 'rtelements' ),
				'type' => Controls_Manager::TEXT,	
				'separator'    => 'before',		
			]
		);

		$repeater->add_control(
			'rts_close_this_day',
			[
				'label'        => esc_html__( 'Highlight this day', 'rtelements' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);
		
		$repeater->add_responsive_control(
			'rts_single_business_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'rtelements' ),
				'type'      => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .yes .rs-business-day' => 'color: {{VALUE}}',
				],
				'condition' => [
					'rts_close_this_day' => 'yes',
				],
				'default' => '#ff0000',
				'separator' => 'before',
			]
		);

		$repeater->add_responsive_control(
			'single_business_time_color',
			[
				'label'     => esc_html__( 'Time Color', 'rtelements' ),
				'type'      => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .yes .rs-business-time' => 'color: {{VALUE}}',
				],
				'condition' => [
					'rts_close_this_day' => 'yes',
				],
				'default' => '#ff0000',
				'separator' => 'before',
			]
		);


		$this->add_control(
			'rts_business_hour_list',
			[
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => [					

					[
						'business_day'  => esc_html__( 'Saturday', 'rtelements' ),
						'business_time' => esc_html__( '10:00 AM to 3:00 PM','rtelements' ),						
					],

					[
						'business_day'  => esc_html__( 'Monday', 'rtelements' ),
						'business_time' => esc_html__( '10:00 AM to 5:00 PM','rtelements' ),
					],

					[
						'business_day'  => esc_html__( 'Tues Day', 'rtelements' ),
						'business_time' => esc_html__( '10:00 AM to 5:00 PM','rtelements' ),
					],

					[
						'business_day'  => esc_html__( 'Wednesday', 'rtelements' ),
						'business_time' => esc_html__( '10:00 AM to 5:00 PM','rtelements' ),
					],

					[
						'business_day'  => esc_html__( 'Thursday', 'rtelements' ),
						'business_time' => esc_html__( '10:00 AM to 5:00 PM','rtelements' ),
					],

					[
						'business_day'  => esc_html__( 'Friday', 'rtelements' ),
						'business_time' => esc_html__( '10:00 AM to 5:00 PM','rtelements' ),
					],

					[
						'business_day'      => esc_html__( 'Sunday', 'rtelements' ),
						'business_time'     => esc_html__( 'Close','rtelements' ),
						'rts_close_this_day' => esc_html__( 'yes','rtelements' ),
					],
				],
				'title_field' => '{{{ business_day }}}',
			]
		);
		

       $this->end_controls_section();


		$this->start_controls_section(
			'section_faq_style_title',
			[
				'label' => esc_html__( 'Day/Time', 'rtelements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_color',
			[
				'label' => esc_html__( 'Item Color', 'rtelements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rs-business-hour .rs-business-schedule' => 'color: {{VALUE}};',
				],
				'separator' => 'before',				
			]
		);

		$this->add_control(
			'item_background',
			[
				'label' => esc_html__( 'Item Background', 'rtelements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rs-business-hour .rs-business-schedule' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_typography',
				'selector' => '{{WRAPPER}} .rs-business-hour .rs-business-schedule span',
			
			]
		);

		
		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'rtelements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .rs-business-hour .rs-business-schedule' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		
		$this->add_responsive_control(
			'item_margin',
			[
				'label' => esc_html__( 'Margin', 'rtelements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .rs-business-hour .rs-business-schedule' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'item_border',
    	        'selector' => '{{WRAPPER}} .rs-business-hour .rs-business-schedule',
    	    ]
		);

		
		$this->end_controls_section();
	}

	/**
	 * Render accordion widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<div class="rs-business-hour">';			
			foreach ( $settings['rts_business_hour_list'] as $index => $item ) :
			?>
				<div class="rs-business-schedule <?php echo esc_attr($item['rts_close_this_day']); ?>">
					<span class="rs-business-day"><?php echo esc_html($item['business_day']); ?></span>
					<span class="rs-business-time"><?php echo esc_html($item['business_time']); ?></span>
				</div>
			<?php					
			endforeach;
		echo '</div>';
	}
}