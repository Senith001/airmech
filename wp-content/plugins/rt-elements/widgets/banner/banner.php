<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Utils;


defined('ABSPATH') || die();

class ReacTheme_Elementor_Banner_Widget extends \Elementor\Widget_Base
{
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
    public function get_name()
    {
        return 'rt-banner';
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
    public function get_title()
    {
        return __('RT Banner', 'rtelements');
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
    public function get_icon()
    {
        return 'glyph-icon flaticon-slider-3';
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
    public function get_categories()
    {
        return ['pielements_category'];
    }

    public function get_style_depends()
    {

        wp_register_style('rtelements-style-portfolio-slider', plugins_url('portfolio-slider-css/portfolio-slider.css', __FILE__));

        return [
            'rtelements-style-portfolio-slider'
        ];
    }

    /**
     * Register rsgallery widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'banner_two_section',
            [
                'label' => esc_html__('Content', 'plugin-name')
            ]
        );


        $this->add_control(
            'video_link',
            [
                'label' => esc_html__('Video Link', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'plugin-name'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'video_text',
            [
                'label' => esc_html__('Video Title', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Intro Video', 'plugin-name'),
                'placeholder' => esc_html__('Type your video title here', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'banner_subtitle',
            [
                'label' => esc_html__('Sub Title', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default subtitle', 'plugin-name'),
                'placeholder' => esc_html__('Type your title here', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'banner_title',
            [
                'label' => esc_html__('Title', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default subtitle', 'plugin-name'),
                'placeholder' => esc_html__('Type your title here', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_text_one',
            [
                'label' => esc_html__('Button One Text', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'plugin-name'),
                'placeholder' => esc_html__('Type your title here', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_one_link',
            [
                'label' => esc_html__('Button One Link', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'plugin-name'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_text_two',
            [
                'label' => esc_html__('Button Two Text', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Default title', 'plugin-name'),
                'placeholder' => esc_html__('Type your title here', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_two_link',
            [
                'label' => esc_html__('Button Two Link', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'plugin-name'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'label_block' => true,
            ]
        );


        $this->end_controls_section();

        // ====================Style==========================//

        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon', 'plugin-name'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'icon_color_bac',
            [
                'label' => esc_html__('Icon Background', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .vedio-icone .video-play-button::after' => 'background:{{VALUE}}',
                ],
            ]
        );



        $this->end_controls_section();


        $this->start_controls_section(
            'icon_style_text',
            [
                'label' => esc_html__('Video Text', 'plugin-name'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__('Typography', 'plugin-name'),
                'name'     => 'icon_style_text_typ',
                'selector' => '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .vedio-icone .text',

            ]
        );

        $this->add_control(
            'icon_style_text_color',
            [
                'label'     => esc_html__('Color', 'plugin-name'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .vedio-icone .text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_style_text_margin',
            [
                'label' => esc_html__('Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .vedio-icone .text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_style_text_padding',
            [
                'label'      => __('Padding', 'plugin-name'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .vedio-icone .text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_text_subtitle',
            [
                'label' => esc_html__('Subtitle', 'plugin-name'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__('Typography', 'plugin-name'),
                'name'     => 'icon_style_text_subtitle_typ',
                'selector' => '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .title',

            ]
        );

        $this->add_control(
            'icon_style_text_subtitle_color',
            [
                'label'     => esc_html__('Color', 'plugin-name'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_style_text_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_style_text_subtitle_padding',
            [
                'label'      => __('Padding', 'plugin-name'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_text_title',
            [
                'label' => esc_html__('Title', 'plugin-name'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'    => esc_html__('Typography', 'plugin-name'),
                'name'     => 'icon_style_text_title_typ',
                'selector' => '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner p.disc',

            ]
        );

        $this->add_control(
            'icon_style_text_title_color',
            [
                'label'     => esc_html__('Color', 'plugin-name'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner p.disc' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_style_text_title_margin',
            [
                'label' => esc_html__('Margin', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner p.disc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_style_text_title_padding',
            [
                'label'      => __('Padding', 'plugin-name'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner p.disc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_text_btn_one',
            [
                'label' => esc_html__('Button One', 'plugin-name'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_one_typography',
                'selector' => '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn-one.btn-primary',
            ]
        );

        $this->add_responsive_control(
            'btn_one_border_radius',
            [
                'label'      => __('Border Radius', 'plugin-name'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn-one.btn-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn-one.btn-primary::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'btn_one_color',
            [
                'label' => esc_html__('Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rts-btn-one.btn-primary' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_one_colorb',
            [
                'label' => esc_html__('Background Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rts-btn-one.btn-primary::before' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_one_colorh',
            [
                'label' => esc_html__('Hover Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rts-btn-one.btn-primary:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_one_colorhb',
            [
                'label' => esc_html__('Hover Background', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rts-btn-one.btn-primary' => 'background: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_text_btn_two',
            [
                'label' => esc_html__('Button Two', 'plugin-name'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'btn_two_typography',
                'selector' => '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn-two.btn-primary',
            ]
        );

        $this->add_responsive_control(
            'btn_two_border_radius',
            [
                'label'      => __('Border Radius', 'plugin-name'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn-two.btn-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn-two.btn-primary::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'btntwoe_color',
            [
                'label' => esc_html__('Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn.btn-primary.bg-w' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_two_colorb',
            [
                'label' => esc_html__('Background Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn.btn-primary.bg-w::before' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'btn_two_colorh',
            [
                'label' => esc_html__('Hover Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner-solar-energy-bg .banner-solar-energy-inner .button-area .rts-btn.btn-primary.bg-w:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'btn_two_colorhb',
            [
                'label' => esc_html__('Hover Background', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rts-btn-two.btn-primary' => 'background: {{VALUE}}',
                ],
            ]
        );





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
    protected function render()
    {

        $settings    = $this->get_settings_for_display();
        ?>

        <script>
            jQuery(document).ready(function($) {
                function vedioActivation(e) {
                    $('#play-video, .play-video').on('click', function(e) {
                        e.preventDefault();
                        $('.video-overlay').addClass('open');
                        $(".video-overlay").append('<iframe width="560" height="315" src="https://www.youtube.com/watch?v=G4t6TqG5LM8&ab_channel=JavierNathaniel" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>');
                    });

                    $('.video-overlay, .video-overlay-close').on('click', function(e) {
                        e.preventDefault();
                        close_video();
                    });

                    $(document).keyup(function(e) {
                        if (e.keyCode === 27) {
                            close_video();
                        }
                    });

                    function close_video() {
                        $('.video-overlay.open').removeClass('open').find('iframe').remove();
                    }
                }

                vedioActivation();
            });

            
        </script>


        <div class="banner-area-start banner-solar-energy-bg bg_image">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 align-items-center">
                        <div class="banner-solar-energy-inner">
                            <div class="wrapper">
                                <div class="vedio-icone">
                                    <a class="video-play-button play-video" href="<?php echo esc_url($settings['video_link']['url']) ?>">
                                        <span></span>
                                        <p class="text ">
                                            <?php if (!empty($settings['video_text'])) :   ?>
                                                <?php echo esc_html($settings['video_text']) ?>
                                            <?php endif ?>
                                        </p>
                                    </a>
                                    <div class="video-overlay">
                                        <a class="video-overlay-close">×</a>
                                    </div>
                                </div>
                                <h1 class="title ">
                                    <?php if (!empty($settings['banner_subtitle'])) :   ?>
                                        <?php echo wp_kses($settings['banner_subtitle'], wp_kses_allowed_html('post'))  ?>
                                    <?php endif ?>
                                </h1>
                                <p class="disc ">
                                    <?php if (!empty($settings['banner_title'])) :   ?>
                                        <?php echo wp_kses($settings['banner_title'], wp_kses_allowed_html('post'))  ?>
                                    <?php endif ?>
                                </p>
                                <div class="button-area ">
                                    <?php if (!empty($settings['btn_text_one'])) :   ?>
                                        <a href="<?php echo esc_url($settings['btn_one_link']['url']) ?>" class="rts-btn rts-btn-one btn-primary"><?php echo esc_html($settings['btn_text_one']) ?></a>
                                    <?php endif ?>
                                    <?php if (!empty($settings['btn_text_two'])) :   ?>
                                        <a href="<?php echo esc_url($settings['btn_two_link']['url']) ?>" class="rts-btn rts-btn-two btn-primary bg-w"><?php echo esc_html($settings['btn_text_two']) ?></a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




<?php
    }
} ?>