<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;

defined('ABSPATH') || die();

class Wrapper_Link {

    public static function init() {
        add_action( 'elementor/element/container/section_layout/after_section_end', [ __CLASS__, 'rt_add_controls_section' ], 1 );
        add_action( 'elementor/element/column/section_advanced/after_section_end', [ __CLASS__, 'rt_add_controls_section' ], 1 );
        add_action( 'elementor/element/section/section_advanced/after_section_end', [ __CLASS__, 'rt_add_controls_section' ], 1 );
        add_action( 'elementor/element/common/_section_style/after_section_end', [ __CLASS__, 'rt_add_controls_section' ], 1 );

        add_action( 'elementor/frontend/before_render', [ __CLASS__, 'before_section_render' ], 1 );
    }

    public static function rt_add_controls_section( Element_Base $element) {
        $tabs = Controls_Manager::TAB_CONTENT;

        if ( 'section' === $element->get_name() || 'column' === $element->get_name()  || 'container' === $element->get_name() ) {
            $tabs = Controls_Manager::TAB_LAYOUT;
        }

        $element->start_controls_section(
            '_section_cls_',
            [
                'label' => __( 'Select Primary Color', 'rt-addon' ),
                'tab'   => $tabs,
            ]
        );

        $element->add_control(
            '_section_cls_select',
            [
                'label' => esc_html__( 'Select Color', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'rt-default-class',
                'options' => [                      
                    'rt-default-class' => esc_html__( 'Default Color', 'rt-addon'),           
                    'rt-primary-bg' => esc_html__( 'Primary Bg Color', 'rt-addon'),
                    'bg-color-2' => esc_html__( 'Secondary Bg Color', 'rt-addon'),     
                    'bg-color-3' => esc_html__( 'Tertiary Bg Color', 'rt-addon'),                           
                    'rt-primary-color' => esc_html__( 'Primary Color', 'rt-addon'),                      
                ],
                'ai' => [
                    'active' => false,
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'prefix_class' => '',
                'title' => esc_html__( 'Select Your Class', 'elementor' ),
                'classes' => 'elementor-control-direction-ltr',
            ]
        );
        $element->end_controls_section();
    }

    public static function before_section_render( Element_Base $element ) {
        $rt_cls_settings = $element->get_settings_for_display( '_section_cls_select' );

        if ( $rt_cls_settings && is_array( $rt_cls_settings ) ) {
            $rt__select_class = $rt_cls_settings['_section_cls_select'];

            if ( $rt__select_class ) {
                $element->add_render_attribute(
                    '_wrapper',
                    [
                        'class' => esc_attr( $rt__select_class ),
                    ]
                );
            }
        }
    }
}

Wrapper_Link::init();


function rselemetns_woocommerce_product_categories(){
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ));

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $options[$term->slug] = $term->name;
        }
        return $options;
    }
}