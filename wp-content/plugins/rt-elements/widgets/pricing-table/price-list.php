<?php
/**
 * Pricing table widget class
 *
 */
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class ReacTheme_Elementor_Pricing_List_Widget extends \Elementor\Widget_Base {

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
        return 'rt-price-list';
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
        return esc_html__( 'Pricing List', 'rtelements' );
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
        return [ 'pricing', 'table', 'package', 'product', 'plan' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'section_price__style',
			[
				'label' => esc_html__( 'Style', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pricing__style',
			[
				'label'   => esc_html__( 'Select Style', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
					'style1' => esc_html__( 'Style 1', 'rtelements')
				],
			]
		);
        $this->end_controls_section();	
        $this->start_controls_section(
            '_section_features',
            [
                'label' => esc_html__( 'Features', 'rtelements' ),
            ]
        );     

        $repeater = new Repeater();
        $repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Exciting Feature', 'rtelements' ),
            ]
        );

        $repeater->add_control(
            'starting_text',
            [
                'label' => esc_html__( 'Starting Text', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
               
            ]
        );  
        $repeater->add_control(
            'price',
            [
                'label' => esc_html__( 'Price', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
               
            ]
        );  

        $this->add_control(
            'features_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => false,
                'default' => [
                    [
                        'text' => esc_html__( 'Social media advertising', 'rtelements' ),
                        
                    ],
                    [
                        'text' => esc_html__( 'Report analytics', 'rtelements' ),
                        
                    ],
                    [
                        'text' => esc_html__( 'Keyword research', 'rtelements' ),
                        
                    ],
                    [
                        'text' => esc_html__( 'Content strategy', 'rtelements' ),
                        
                    ],
                    [
                        'text' => esc_html__( 'Premium consulting', 'rtelements' ),
                       
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );
        $this->end_controls_section();   

        // STYLE 
        $this->start_controls_section(
			'price_list_style',
			[
				'label' => esc_html__( 'Style Section', 'rtelements' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		 );
        // Item options
        $this->add_control(
			'item_options',
			[
				'label' => esc_html__( 'Item Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
         $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .dlm:after',
			]
		);
         $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Item Margin', 'rtelements'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .dlm' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				 ],
            ]
        );

        // Title options
        $this->add_control(
			'title_options',
			[
				'label' => esc_html__( 'Title Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dlm-name' => 'color: {{VALUE}};',    
                ],                
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .dlm-name',                    
			]
		);
        // price options
        $this->add_control(
			'price_options',
			[
				'label' => esc_html__( 'Price Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__( 'Price Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dlm-value' => 'color: {{VALUE}};',    
                ],                
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Price Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .dlm-value',                    
			]
		);
        
        // starting options
        $this->add_control(
			'starting_options',
			[
				'label' => esc_html__( 'Starting Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'starting_color',
            [
                'label' => esc_html__( 'Starting Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dlm-value span ' => 'color: {{VALUE}};',    
                ],                
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'starting_typography',
				'label' => esc_html__( 'Starting Typography', 'rtelements' ),
				'selector' => '{{WRAPPER}} .dlm-value span',                    
			]
		);
        $this->end_controls_section(); 

    }
    // Currency Function 
    private static function get_currency_symbol( $symbol_name ) {
        $symbols = [
            'baht' => '&#3647;',
            'bdt' => '&#2547;',
            'dollar' => '&#36;',
            'euro' => '&#128;',
            'franc' => '&#8355;',
            'guilder' => '&fnof;',
            'indian_rupee' => '&#8377;',
            'pound' => '&#163;',
            'peso' => '&#8369;',
            'peseta' => '&#8359',
            'lira' => '&#8356;',
            'ruble' => '&#8381;',
            'shekel' => '&#8362;',
            'rupee' => '&#8360;',
            'real' => 'R$',
            'krona' => 'kr',
            'won' => '&#8361;',
            'yen' => '&#165;',
        ];

        return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'badge_text', 'class',
            [
                'rt-pricing-table-badge',                
            ]
        );

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'rt-pricing-table-title' );

        $this->add_inline_editing_attributes( 'price', 'none' );
        $this->add_render_attribute( 'price', 'class', 'rt-pricing-table-price-text' );

        $this->add_inline_editing_attributes( 'period', 'none' );
        $this->add_render_attribute( 'period', 'class', 'rt-pricing-table-period' );

        $this->add_inline_editing_attributes( 'features_title', 'basic' );
       

        $this->add_inline_editing_attributes( 'button_text', 'none' );
        $this->add_render_attribute( 'button_text', 'class', 'rt-pricing-table-btn' );

        

        if ( $settings['pricing__style'] === 'style2' ) {
            $styleClass = ' rt-pricingt-'.$settings['pricing__style'];
        } else {
            $styleClass = '';
        }
        ?>
        
        <?php 
        if($settings['pricing__style'] == 'style1'){ ?>

        <div class="rt-price-table<?php echo esc_attr( $styleClass);?>"> 
       
          <div class="rt-pricing-table-body">        

              <?php if ( is_array( $settings['features_list'] ) ) : ?>
                  <ul class="rt-pricing-table-features-list d-list-menu">
                      <?php foreach ( $settings['features_list'] as $index => $feature ) :
                          $name_key = $this->get_repeater_setting_key( 'text', 'features_list', $index );
                          $this->add_inline_editing_attributes( $name_key, 'basic' );
                          $this->add_render_attribute( $name_key, 'class', 'rt-pricing-table-feature-text' );
                          ?>
                          </li>
                        
                              <li class="dlm">
                                <div class="dlm-table">
                                  <div class="dlm-description">
                                    <h3 class="dlm-name">
                                    <?php echo wp_kses_post( $feature['text'] ); ?>
                                    </h3>
                                  </div>
                                  <div class="dlm-price">
                                    <span class="dlm-value">
                                         <?php if($feature['starting_text']): ?>
                                            <span class="id-color-2 me-3 fs-14"><?php echo $feature['starting_text']; ?></span>  
                                        <?php endif; ?>
                                         <?php echo wp_kses_post( $feature['price'] ); ?></span>
                                  </div>
                                </div>
                              </li>                     
                           

                       
                      <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
             
              
          </div>           
      </div>
    <?php

        } 
    }
}