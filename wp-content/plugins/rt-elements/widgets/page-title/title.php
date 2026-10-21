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

class Reactheme_Page_Title_Showcase_Widget extends \Elementor\Widget_Base {
    /**    
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'react-page-title';
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
        return esc_html__( 'RT Page Title', 'rsaddon' );
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
				'label' => esc_html__( 'Title', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'title_tag',
			[
				'label'   => esc_html__('Select Heading Tag', 'rtelements'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => [
					'h1' => esc_html__('H1', 'rtelements'),
					'h2' => esc_html__('H2', 'rtelements'),
					'h3' => esc_html__('H3', 'rtelements'),
					'h4' => esc_html__('H4', 'rtelements'),
					'h5' => esc_html__('H5', 'rtelements'),
					'h6' => esc_html__('H6', 'rtelements'),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'label' => esc_html__('Typography', 'rtelements'),
				'selector' => '{{WRAPPER}} .page-title',
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => esc_html__('Color', 'rtelements'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_margin',
			[
				'label' => esc_html__('Margin', 'rtelements'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],

				'selectors' => [
					'{{WRAPPER}} .page-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);       
		$this->end_controls_section();       
    }

    protected function render() {
        $settings = $this->get_settings_for_display();  

        ?>
        
        <<?php echo $settings['title_tag']; ?> class="page-title">
		<?php 
                if (class_exists('WooCommerce')) {
                    if (is_shop()) {
                        echo get_the_title(wc_get_page_id('shop'));
                    } elseif (is_product_category() || is_product_tag() || is_tax('product_brand')) {
                        $p_title = get_queried_object();
                        echo $p_title->name;
                    } else {
                        the_title(); 
                    }
                } else {
                    the_title();
                }
            ?>
        </<?php echo $settings['title_tag']; ?>>
        <?php
    }
}
