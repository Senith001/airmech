<?php
/**
 * Image widget class
 *
 */
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class Reactheme_Image_Showcase_Widget extends \Elementor\Widget_Base {
    /**    
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'rt-react-image';
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
        return esc_html__( 'RT Image Showcase', 'rtelements' );
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
        return 'glyph-icon flaticon-image';
    }


    public function get_categories() {
        return [ 'pielements_category' ];
    }

    public function get_keywords() {
        return [ 'logo', 'clients', 'brand', 'parnter', 'image' ];
    }

    

	protected function register_controls() {
		$this->start_controls_section(
            '_section_logo',
            [
                'label' => esc_html__( 'Image Settings', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        ); 

        $this->add_control(
            'first_image',
            [
                'label' => esc_html__( 'Choose Image', 'rtelements' ),
                'type' => \Elementor\Controls_Manager::MEDIA,     
                'separator' => 'before',
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
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .react-image' => 'text-align: {{VALUE}}'
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'react_image_size',
            [

                'label' => esc_html__( 'Image Size', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'selectors' => [
					'{{WRAPPER}} img.react-multi-image' => 'width: {{SIZE}}{{UNIT}};',
				],
                
            ]
        );      
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],                
                'selectors' => [
                    '{{WRAPPER}} .react-image .react-multi-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
                    'wow scaleIn' => esc_html__('Scale In', 'rtelements'),  
                    'wow scaleOut' => esc_html__('scale Out', 'rtelements'),  
                    'wow zoomIn' => esc_html__('Zoom In', 'rtelements'),  
                    'wow zoomOut' => esc_html__('Zoom Out', 'rtelements'), 
                               
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

    protected function render() {
        $settings = $this->get_settings_for_display();         
        $animation = $settings['rt_image_animation'] ? $settings['rt_image_animation'] : '';
        $delay = $settings['delay'] ? 'data-wow-delay="'.$settings['delay'].'"' : '';        
        ?>        
        <div class="react-image">
            <?php if(!empty($settings['first_image']['url'])) : ?>
                <img class="react-multi-image <?php echo $animation;?>" src="<?php echo esc_url($settings['first_image']['url']);?>" <?php echo $delay; ?> alt=""/>
            <?php endif; ?>
        </div>       
    <?php
    }
}