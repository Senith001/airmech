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

class Reactheme_Page_Breadcrumb_Showcase_Widget extends \Elementor\Widget_Base {
    /**    
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'react-page-heading';
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
        return esc_html__( 'RT Breadcrumb', 'rsaddon' );
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
        return [ 'title', 'page heading', 'page title' ];
    }
    protected function register_controls() {   

        $this->start_controls_section(
			'content_caption_style_section',
			[
				'label' => esc_html__( 'Breadcrumb', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		 
		$this->end_controls_section();       
    }

    protected function render() {
        $settings = $this->get_settings_for_display();  

    ?>
        <div class="breadcrumbs-single"> 
            <?php      
                if(function_exists('bcn_display')){?>
                    <div class="breadcrumbs-title"> <?php  bcn_display();?></div>
                <?php  } ?>           
        
            </div>
    <?php
    }
}
