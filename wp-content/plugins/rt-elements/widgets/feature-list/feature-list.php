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

class RTS_Features_List_Widget extends \Elementor\Widget_Base {

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
				'label' => esc_html__('Subtitle  Background', 'rtelements'),				
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
    } 

	protected function render() {
        $settings = $this->get_settings_for_display();
    ?>
    <div class="row">
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
