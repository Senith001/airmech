<?php

use Elementor\Repeater;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();
class ReacTheme_Widget_Accordion extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'rt-custom-accordions';
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
        return esc_html__('RT Accordion', 'rtelements');
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
        return 'eicon-accordion';
    }


    public function get_categories()
    {
        return ['pielements_category'];
    }

    public function get_keywords()
    {
        return ['Accordion'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__('Item', 'rtelements'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'accordion_style',
            [
                'label'   => esc_html__('Select Style', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => 'Style 1',
                    'style2' => 'Style 2',
                    'style3' => 'Style 3',
                ],
            ]
        );

        $repeater = new Repeater();        
        $repeater->add_control(
            'name',
            [
                'label' => esc_html__('Item Title', 'rtelements'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__('Title', 'rtelements'),
            ]
        );
        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Item Description', 'rtelements'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('', 'rtelements'),
                'label_block' => true,
                'placeholder' => esc_html__('Description', 'rtelements'),
                'separator'   => 'before',
            ]
        );
        $repeater->add_control(
			'title_logo_show',
			[
				'label' => esc_html__( 'Title Icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'rtelements' ),
				'label_off' => esc_html__( 'Hide', 'rtelements' ),
                'separator'   => 'before',
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $repeater->add_control(
			'title_icon',
			[
				'label' => esc_html__( 'choose icon', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::ICONS,
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
                    'title_logo_show' => 'yes',
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

        $this->add_control(
			'accordion_icons_options',
			[
				'label' => esc_html__( 'Accordion Icon Select', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'      => esc_html__( 'Icon', 'rtelements' ),
					'number'    => esc_html__( 'Number', 'rtelements' ),
				],
			]
		);

        $this->add_control(
            'accordion_icon',
            [
                'label' => esc_html__('Accordion Regular Icon', 'rtelements'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
                'separator' => 'before',
                'condition' => [
                    'accordion_icons_options' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'accordion_active_icon',
            [
                'label' => esc_html__('Accordion Active Icon', 'rtelements'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-up',
                    'library' => 'solid',
                ],
                'separator' => 'before',
                'condition' => [
                    'accordion_icons_options' => 'icon'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            '_accordion_wrap_style',
            [
                'label' => esc_html__('Wraper', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'accordion_wrap_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .rts-accordion .accordion-item.bg_color',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'accordion_wrap_border',
				'selector' => '{{WRAPPER}} .rts-accordion .accordion-item',
			]
		);
        $this->add_responsive_control(
            'accordion_wrap_radius',
            [
                'label' => esc_html__('Border Radius', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion .accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'accordion_wrap_padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion .accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'accordion_wrap_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion .accordion-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'accordion_head_style',
            [
                'label' => esc_html__('Header', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'accordion_head_color',
			[
				'label' => esc_html__( 'Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_control(
			'accordion_head_active_color',
			[
				'label' => esc_html__( 'Active Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header button[aria-expanded=true]' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header button[aria-expanded=true]' => 'color: {{VALUE}} !important',                    
					'{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header button[aria-expanded=true]' => 'color: {{VALUE}} !important',                    
				],
			]
		);
        $this->add_control(
			'accordion_head_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button span i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button span i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button span i' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_control(
			'accordion_head_active_icon_color',
			[
				'label' => esc_html__( 'Icon Active Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header button[aria-expanded=true] span i' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header button[aria-expanded=true] span i' => 'color: {{VALUE}} !important',                    
					'{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header button[aria-expanded=true] span i' => 'color: {{VALUE}} !important',                    
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'head_typo',
				'selector' => '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button,{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button,{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'accordion_head_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button,{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button,{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'accordion_head_border',
				'selector' => '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button,{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button,{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button',
			]
		);
        $this->add_control(
            'accordion_head_radius',
            [
                'label' => esc_html__('Border Radius', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'accordion_head_padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'accordion_head_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-header .accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-header .accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-header .accordion-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        
        $this->start_controls_section(
            'accordion_des_style',
            [
                'label' => esc_html__('Description', 'rtelements'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'des_color',
			[
				'label' => esc_html__( 'Color', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-body' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-body' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-body' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'des_typo',
				'selector' => '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-body,{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-body,{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-body',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'des_bg',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-body,{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-body,{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-body'
			]
		);
        $this->add_responsive_control(
            'des_padding',
            [
                'label' => esc_html__('Padding', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'des_margin',
            [
                'label' => esc_html__('Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'des_border_radius',
            [
                'label' => esc_html__('Border Radius', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .rts-accordion.style1 .accordion-item .accordion-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style2 .accordion-item .accordion-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rts-accordion.style3 .accordion-item .accordion-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $unique = rand(2012, 35120);
        $blank = '';
        ?>
        <div class="rts-accordion <?php echo $settings['accordion_style']; ?>" id="accordionExample<?php echo $unique; ?>">
                <?php $x = 0;
                    foreach ($settings['logo_list'] as $index => $item) :
                        $title = !empty($item['name']) ? $item['name'] : '';
                        $description = !empty($item['description']) ? $item['description'] : '';
                        $x++;

                        if ($x == 1) {
                            $collapse  = '';
                            $show = '';
                            $true = 'false';
                            $bg_color = 'bg_color';
                        } else {
                            $collapse  = 'collapsed';
                            $show = '';
                            $true = 'false';
                        }

                        $dataUnique = $unique . $x;

                    if ($settings['accordion_style'] == 'style1') : ?>

                    <div class="accordion-item <?php echo esc_attr($bg_color); ?>">
                        <div class="accordion-header" id="heading-<?php echo $dataUnique; ?>">                           
                            <button class="accordion-button <?php echo $collapse; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $dataUnique; ?>" aria-expanded="<?php echo $true; ?>" aria-controls="collapse<?php echo $dataUnique; ?>">

                            <?php if(!empty($item['title_icon'])) : ?>
                                <span class="title_icon">
                                    <?php \Elementor\Icons_Manager::render_icon( $item['title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </span>
                                <?php
                            else : echo $blank;
                            endif; ?>


                            <?php echo wp_kses_post($title); ?>

                            <?php 
                            if($settings['accordion_icons_options'] == 'icon') : ?>
                                <span class="accordion-icon"><?php \Elementor\Icons_Manager::render_icon($settings['accordion_icon'], ['aria-hidden' => 'true']); ?></span> <span class="accordion-icon-active"> <?php \Elementor\Icons_Manager::render_icon($settings['accordion_active_icon'], ['aria-hidden' => 'true']); ?></span>
                                    <?php 
                                elseif($settings['accordion_icons_options'] == 'number') : ?>
                                   <span class="number"><?php echo str_pad($x, 2, '0', STR_PAD_LEFT); ?></span>
                                    <?php
                                else:  
                                    echo $blank;
                            endif;
                            ?>
                                
                            </button>
                        </div>
                        <div id="collapse<?php echo $dataUnique; ?>" class="accordion-collapse collapse <?php echo $show; ?>" aria-labelledby="heading<?php echo $dataUnique; ?>" data-bs-parent="#accordionExample<?php echo $unique; ?>">
                            <div class="accordion-body">
                                 <?php echo nl2br(htmlspecialchars_decode($description)); ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="accordion-item">
                        <div class="accordion-header" id="heading-<?php echo $dataUnique; ?>">
                            <button class="accordion-button <?php echo $collapse; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $dataUnique; ?>" aria-expanded="<?php echo $true; ?>" aria-controls="collapse<?php echo $dataUnique; ?>">

                            <?php if(!empty($item['title_icon'])) : ?>
                                <span class="title_icon">
                                    <?php \Elementor\Icons_Manager::render_icon( $item['title_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </span>
                                <?php
                            else : echo $blank;
                            endif; ?>
                          
                            <?php echo wp_kses_post($title); ?>

                            <?php 
                            if($settings['accordion_icons_options'] == 'icon') : ?>
                                <span class="accordion-icon"><?php \Elementor\Icons_Manager::render_icon($settings['accordion_icon'], ['aria-hidden' => 'true']); ?></span> <span class="accordion-icon-active"> <?php \Elementor\Icons_Manager::render_icon($settings['accordion_active_icon'], ['aria-hidden' => 'true']); ?></span>
                                    <?php 
                                elseif($settings['accordion_icons_options'] == 'number') : ?>
                                    <span class="accordion-icon number"><?php echo str_pad($x, 2, '0', STR_PAD_LEFT); ?></span>
                                    <?php
                                else:  
                                    echo $blank;
                            endif;
                            ?>

                            </button>
                        </div>
                        <div id="collapse<?php echo $dataUnique; ?>" class="accordion-collapse collapse <?php echo $show; ?>" aria-labelledby="heading<?php echo $dataUnique; ?>" data-bs-parent="#accordionExample<?php echo $unique; ?>">
                            <div class="accordion-body">
                                <div class="inner">
                                    <?php if (!empty($item['col_image']['url'])) :   ?>
                                        <div class="thumb-area">
                                            <img src="<?php echo esc_url($item['col_image']['url']) ?>" alt="<?php echo esc_attr('image') ?>">
                                        </div>
                                    <?php endif ?>
                                    <div class="content">
                                        <?php if (!empty($item['col_namee'])) :   ?>
                                            <h6 class="title"><?php echo esc_html($item['col_namee']) ?></h6>
                                        <?php endif ?>
                                        <p class="disc">
                                           <?php echo nl2br(htmlspecialchars_decode($description)); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                endif;

                endforeach; ?>
        </div>

        <script>
            jQuery(document).ready(function () {
                jQuery('.rts-accordion .accordion-button').click(function () {                  
                    jQuery('.rts-accordion .accordion-item').removeClass("bg_color");                                       
                    jQuery(this).closest('.accordion-item').addClass("bg_color");
                });
            });
        </script>
<?php
    }
} ?>