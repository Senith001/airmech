<?php
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class ReacTheme_Portfolio_Features_List_Widget extends \Elementor\Widget_Base {


    public function get_name() {
        return 'rt-portfolio-featureslist';
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
        return esc_html__( 'RT Portfolio Features', 'rtelements' );
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

        $this->add_control(
        'heading_title',
        [
            'label' => esc_html__( 'Project Information Heading', 'rtelements' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            
        ]
    );
    $repeater = new Repeater();

    $repeater->add_control(
        'icon',
        [
            'label'     => esc_html__( 'Icon', 'pielements' ),
            'type'      => Controls_Manager::ICONS,           
            'separator' => 'before',            		
        ]
    );

    $repeater->add_control(
        'information_title',
        [
            'label' => esc_html__('Information Title', 'rtelements'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Project Information', 'rtelements'),
            'label_block' => true,
            'placeholder' => esc_html__( 'Title', 'rtelements' ),
            'separator'   => 'before',
        ]
    );

    $repeater->add_control(
        'information_value',
        [
            'label' => esc_html__('Information Value', 'rtelements'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => esc_html__('', 'rtelements'),
            'label_block' => true,
            'placeholder' => esc_html__( 'Description', 'rtelements' ),
            'separator'   => 'before',
        ]
    );

    $this->add_control(
        'info_list',
        [
            'show_label' => false,
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ information_title }}}',
            
        ]
    );
       

    $this->end_controls_section();
    }
  
	protected function render() {
        $settings = $this->get_settings_for_display();?>
        <div class="rt-features-list-portfolio-content">
            <?php if($settings['heading_title']) : ?>
            <h5 class="pinfo--sidebar-title"><?php echo esc_html($settings['heading_title']);?></h5>    
            <?php endif; ?>   
            <div class="info-body"> 
                <?php foreach ( $settings['info_list'] as $index => $item ) :  ?>   
                    <div class="single-info">
                        <div class="info-ico">
                        <?php 
                        if(!empty($item['icon'])) :
                            \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); 
                        endif; ?>
                        </div>
                        <div class="info-details">
                            <span><?php echo $item['information_title']?></span>
                            <h6 class="name"><?php echo $item['information_value']?></h6>
                        </div>
                    </div>  
                <?php endforeach; ?>   
            </div>                
        </div>
        <?php
    }
}
