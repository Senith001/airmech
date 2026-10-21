<?php

use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class ReacTheme_Elementor_Blog_Grid_Widget extends \Elementor\Widget_Base {

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
		return 'react-blog';
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
	public function get_title() {
		return esc_html__( 'RT Blog Grid', 'rtelements' );
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
	public function get_icon() {
		return 'glyph-icon flaticon-blogging';
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
	public function get_categories() {
        return [ 'pielements_category' ];
    }


	/**
	 * Register rsgallery widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {		

		$post_categories = get_terms( 'category' );

        $post_options = [];
        foreach ( $post_categories as $category ) {
            $post_options[ $category->slug ] = $category->name;
        }


		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content Settings', 'rtelements' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'blog_grid_style',
			[
				'label'   => esc_html__( 'Select Style', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [					
                    'style1' => esc_html__( 'Style 1', 'rtelements'),
                    'style2' => esc_html__( 'Style 2', 'rtelements'),                  
				],
			]
		);
      

		$this->add_control(
			'category',
			[
				'label'   => esc_html__( 'Category', 'rtelements' ),				
				'type'        => Controls_Manager::SELECT2,
                'options'     => $post_options,
                'default'     => [],
				'multiple' => true,	
				'separator' => 'before',		
			]

		);
	
		$this->add_control(
			'blog_columns',
			[
				'label'   => esc_html__( 'Desktops > 1199px', 'rtelements' ),
				'type'    => Controls_Manager::SELECT,
                'default' => 3,			
				'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),				
				],
				'separator' => 'before',							
			]
		);
        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__('Laptop > 991px', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 2,
                'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__('Tablets > 767px', 'rtelements'),
                'type'    => Controls_Manager::SELECT,
                'default' => 1,
                'options' => [
                    '1' => esc_html__('1 Column', 'rtelements'),
                    '2' => esc_html__('2 Column', 'rtelements'),
                    '3' => esc_html__('3 Column', 'rtelements'),
                    '4' => esc_html__('4 Column', 'rtelements'),
                    '5' => esc_html__('5 Column', 'rtelements'),
                    '6' => esc_html__('6 Column', 'rtelements'),
                ],
                'separator' => 'before',

            ]

        );

        $this->add_responsive_control(
            'item_middle_gap',
            [
                'label' => esc_html__( 'Item Middle Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .row.blog-gird-item' => '--bs-gutter-x: {{SIZE}}{{UNIT}}; --bs-gutter-y: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_bottom_gap',
            [
                'label' => esc_html__( 'Item Bottom Spacing', 'rtelements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Blog Show Per Page', 'rtelements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '6', 'rtelements' ),
				'separator' => 'before',
                'placeholder' => esc_html__( '5', 'rtelements' ),
			]
		);

        $this->add_control(
            'title_word_count',
            [
                'label' => esc_html__( 'Title Word Count', 'rtelements' ),
                'type' => Controls_Manager::NUMBER,   
                'placeholder' => esc_html__( '5', 'rtelements' ),
            ]
        );

        $this->add_control(
            'post_offset',
            [
                'label' => esc_html__( 'Offset', 'rtelements' ),
                'type' => Controls_Manager::TEXT,                
                'separator' => 'before',
                'placeholder' => esc_html__( '5', 'rtelements' ),
            ]
        );       

        $this->add_control(
            'blog_word_show',
            [
                'label' => esc_html__( 'Show Content Limit', 'rtelements' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '20', 'rtelements' ),
                'separator' => 'before',
                'condition' => [
                    'blog_content_show_hide' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ],
                'separator' => 'before',
            ]
        ); 

        $this->end_controls_section();

        $this->start_controls_section(
            'meta_section',
            [
                'label' => esc_html__( 'Meta Settings', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
            'blog_avatar_show_hide',
            [
                'label' => esc_html__( 'Author Show / Hide', 'rtelements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rtelements' ),
                    'no' => esc_html__( 'No', 'rtelements' ),
                ],                
                'separator' => 'before',
            ]
        );
        $this->add_control(
        'blog_cat_show_hide',
        [
            'label' => esc_html__( 'Cateogry Enable', 'rtelements' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'Yes',
            'options' => [
                'yes' => esc_html__( 'Yes', 'rtelements' ),
                'no' => esc_html__( 'No', 'rtelements' ),
            ],                
            'separator' => 'before',
        ]
    );

		$this->add_control(
            'blog_date_show_hide',
            [
                'label' => esc_html__( 'Date Show / Hide', 'rtelements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rtelements' ),
                    'no' => esc_html__( 'No', 'rtelements' ),
                ],                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'blog_readmore_show_hide',
            [
                'label' => esc_html__( 'Read More Show / Hide', 'rtelements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rtelements' ),
                    'no' => esc_html__( 'No', 'rtelements' ),
                ],                
                'separator' => 'before',
            ]
        );
		$this->add_control(
            'blog_pagination_show_hide',
            [
                'label' => esc_html__( 'Pagination Show / Hide', 'rtelements' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rtelements' ),
                    'no' => esc_html__( 'No', 'rtelements' ),
                ],                
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__( 'Button Settings', 'rtelements' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                
                
            ]
        );

		$this->add_control(
			'blog_btn_text',
			[
                'label'       => esc_html__( 'Blog Button Text', 'rtelements' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Read More',
                'placeholder' => esc_html__( 'Blog Button Text', 'rtelements' ),
                'separator'   => 'before',
               
			]
		);
				
		$this->end_controls_section();

        $this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__( 'Item', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'=> esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ], 
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_grid_style',
            [
                'label' => esc_html__( 'Blog Meta', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'blog_grid_style' => 'style1',
                ],
            ]
        );
        $this->add_control(
			'blog_auth_style',
			[
				'label' => esc_html__( 'Author Options', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                    'blog_avatar_show_hide' => 'yes',
                ]  
			]
		);
        $this->add_control(
            'blog_author_color',
            [
                'label' => esc_html__( 'Admin Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .inner-content-wrapper .bottom-area .admin' => 'color: {{VALUE}};',
                ],          
                'condition' => [
                    'blog_avatar_show_hide' => 'yes',
                ]      
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_author_typo',
				'selector' => '{{WRAPPER}} .single-blog-area-style-one .inner-content-wrapper .bottom-area .admin',
                'condition' => [
                    'blog_avatar_show_hide' => 'yes',
                ]  
			]
		);
        $this->add_responsive_control(            
            'blog_author_pdding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],               
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .inner-content-wrapper .bottom-area .admin' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'blog_avatar_show_hide' => 'yes',
                ]  
            ]
        );
        $this->add_control(
			'blog_date_style',
			[
				'label' => esc_html__( 'Date Option', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                    'blog_date_show_hide' => 'yes',
                ],
			]
		);
        $this->add_control(
            'blog_date_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .inner-content-wrapper .bottom-area .date' => 'color: {{VALUE}};',
                ], 
                'condition' => [
                    'blog_date_show_hide' => 'yes',
                ],               
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_date_typo',
				'selector' => '{{WRAPPER}} .single-blog-area-style-one .inner-content-wrapper .bottom-area .date',
                'condition' => [
                    'blog_date_show_hide' => 'yes',
                ],
			]
		);
        $this->add_responsive_control(            
            'blog_date_pdding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],               
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .inner-content-wrapper .bottom-area .date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'blog_date_show_hide' => 'yes',
                ],
            ]
        );
        $this->add_control(
			'blog_cat_style',
			[
				'label' => esc_html__( 'Category', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],
			]
		);
        $this->add_control(
            'blog_cat_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat_list li a' => 'color: {{VALUE}};',
                ],     
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],           
            ]
        );
        $this->add_control(
            'blog_cat_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cat_list li a' => 'background: {{VALUE}};',
                ],     
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],           
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'blog_cat_typo',
				'selector' => '{{WRAPPER}} .cat_list li a',
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],
			]
		);
        $this->add_responsive_control(            
            'blog_cat_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],          
                'selectors' => [
                    '{{WRAPPER}} .cat_list li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(            
            'blog_cat_pdding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],               
                'selectors' => [
                    '{{WRAPPER}} .cat_list li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(            
            'blog_cat_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,        
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],  
                'selectors' => [
                    '{{WRAPPER}} .cat_list li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style 
        $this->start_controls_section(
            'section_slider_title',
            [
                'label' => esc_html__( 'Title', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper a .title' => 'color: {{VALUE}};',
                ],                
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper a .title:hover' => 'color: {{VALUE}};',
                ],                
            ]
            
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'rtelements' ),
				
				'selector' => 
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper a .title',
			]
		);
        $this->add_responsive_control(
            'title_content_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],  
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper a .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper a .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();

        // Description Style 
        $this->start_controls_section(
            'blog_section_desc',
            [
                'label' => esc_html__( 'Description', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Color', 'rtelements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .desc' => 'color: {{VALUE}};',
                ],                
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Typography', 'rtelements' ),
				
				'selector' => 
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .desc',
			]
		);
        $this->add_responsive_control(
            'desc_content_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'desc_padding',
            [
                'label' => esc_html__( 'Padding', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->end_controls_section();

        // Image Style 
        $this->start_controls_section(
            'section_img_sec',
            [
                'label' => esc_html__( 'Image Style', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
			'blog_img_size',
			[
				'label' => esc_html__( 'Size', 'rtelements' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .single-blog-area-style-one .thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
            'blog_img_padding',
            [
                'label'=> esc_html__( 'Padding', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'blog_img_margin',
            [
                'label'=> esc_html__( 'Marign', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .thumbnail img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
                
        $this->add_responsive_control(
            'blog_img_border_radius',
            [
                'label'=> esc_html__( 'Border Radius', 'rtelements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ], 
                'selectors' => [
                    '{{WRAPPER}} .single-blog-area-style-one .thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Read More Button Style
		$this->start_controls_section(
            'blog_button_style',
            [
                'label' => esc_html__( 'Button', 'rtelements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
            );
            
            $this->start_controls_tabs( '_tabs_button' );	

                $this->start_controls_tab(
                    'tab_button_normal',
                    [
                        'label' => esc_html__( 'Normal', 'rtelements' ),
                    ]
                 );
                    $this->add_control(
                        'button_text_color',
                        [
                            'label' => esc_html__( 'Color', 'rtelements' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [                  
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main' => 'color: {{VALUE}};',                   
                            ],                
                        ]
                    );
                    $this->add_control(
                        'button_normal_bg',
                        [
                            'label' => esc_html__( 'Background', 'rtelements' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main' => 'background: {{VALUE}}',							
                            ],
                        ]
                    );

                    $this->add_group_control(
                        \Elementor\Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_normal_typo',
                            'selector' => '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main',
                        ]
                    );
                    $this->add_responsive_control(
                        'button_normal_margin',
                        [
                            'label' => esc_html__( 'Margin', 'rtelements' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'button_normal_padding',
                        [
                            'label' => esc_html__( 'Padding', 'rtelements' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'button_normal_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'rtelements' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				            
                            ],
                        ]
                    );
                    $this->add_group_control(
                        \Elementor\Group_Control_Border::get_type(),
                        [
                            'name' => 'button_normal_border',
                            'selector' => '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main',
                        ]
                    );
                    $this->add_group_control(
                        \Elementor\Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'button_normal_box_shadow',
                            'label' => esc_html__( 'Box Shadow', 'rtelements' ),
                            'selector' => '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main',
                        ]
                    );
                    $this->add_responsive_control(
                        'button_normal_width',
                        [
                            'label' => esc_html__( 'Button Width', 'rtelements' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main' => 'width: {{SIZE}}{{UNIT}};',
                                
                            ],
                        ]
                    );
                $this->end_controls_tab();

                $this->start_controls_tab(
                    'tab_button_hover',
                    [
                        'label' => esc_html__( 'Hover', 'rtelements' ),
                    ]
                 );
                    $this->add_control(
                        'button_hover_bg',
                        [
                            'label' => esc_html__( 'Hover Background', 'rtelements' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main:hover' => 'background: {{VALUE}}',							
                            ],
                        ]
                    );
                    $this->add_control(
                        'button_text_color_hover',
                        [
                            'label' => esc_html__( 'Hover Color', 'rtelements' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main:hover' => 'color: {{VALUE}};',                  
                            ],                
                        ]
                    );
                    $this->add_group_control(
                        \Elementor\Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'button_hover_box_shadow',
                            'label' => esc_html__( 'Hover Box Shadow', 'rtelements' ),
                            'selector' => '{{WRAPPER}} .rt_blog_item_style .inner-content-wrapper .btn-main:hover',
                        ]
                    );
            
                $this->end_controls_tab();

		    $this->end_controls_tabs();
        
        $this->end_controls_section();

		// Start Blog Pagination Style
		$this->start_controls_section(
		    '_blog_pagination_style',
		    [
		        'label' => esc_html__( 'Pagination Style', 'rtelements' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagi_color',
		    [
		        'label' => esc_html__( 'Text Color', 'rtelements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links a' => 'color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagi_hover_color',
		    [
		        'label' => esc_html__( 'Text Hover Color', 'rtelements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links a:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links span.current' => 'color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagi_divider_color',
		    [
		        'label' => esc_html__( 'Divider Color', 'rtelements' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links a' => 'border-color: {{VALUE}};',
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links span.current' => 'border-color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagiesc_html__bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rtelements' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links' => 'background-color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

        $this->add_responsive_control(            
            'blog_pagiesc_html_margin',
            [
                'label' => esc_html__( 'Margin', 'rtelements' ),
                'type'  => Controls_Manager::DIMENSIONS, 
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],             
                'selectors' => [
		            '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_pagi_shadow',
				'label' => esc_html__( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .reactheme-blog-grid .reactheme-pagination-area .nav-links',
				'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
			]
		);

		$this->end_controls_section();

		// End Blog Pagination Style


		

	}

	/**
	 * Render rsgallery widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
        $bstyle = $settings['blog_grid_style'];
        if( $bstyle ){
            $styleClass = ' blog--'.$bstyle;
        }
        $col_lg          = 12 / $settings['blog_columns'] ;
        $col_md          = 12 / $settings['col_md'];
        $col_sm          = 12 / $settings['col_sm'];

        $col = 'col-lg-'.$col_lg.' col-md-'.$col_md.' col-sm-'.$col_sm.' col-12';    
        ?>

		<div class="reactheme-blog-grid2x reactheme-blog-grid<?php echo esc_attr( $styleClass);?>">          

            <div class="row blog-gird-item">
			 	<?php
			        $cat = $settings['category'];     
			        if(($settings['blog_pagination_show_hide'] == 'yes')){
						global  $paged;
				        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						if(empty($cat)){
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' => $settings['per_page'],										
                                'offset'		 => $settings['post_offset'],
                                'paged'          => $paged		
							));	  
				        }   
				        else{
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' =>  $settings['per_page'],										
                                'offset'         => $settings['post_offset'],
                                'paged'          => $paged,
								'tax_query'      => array(
							        array(
										'taxonomy' => 'category',
										'field'    => 'slug', 
										'terms'    => $cat 
							        ),
							    )
							));	  
				        }
				    }

				    else{
					    if(empty($cat)){
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' => $settings['per_page'],	
                                'offset'        => $settings['post_offset']	,		
							));	  
				        }   
				        else{
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' => $settings['per_page'],
                                'offset'         => $settings['post_offset'],
								'tax_query'      => array(
							        array(
										'taxonomy' => 'category',
										'field'    => 'slug', 
										'terms'    => $cat 
							        ),
							    )
							));	  
				        }
				    }
			        $x=1;
					while($best_wp->have_posts()): $best_wp->the_post(); 
                     $termsArray = get_the_terms( $best_wp->ID, "category" );  //Get the terms for this particular item
                     $termsString = ""; //initialize the string that will contain the terms
                     foreach ( $termsArray as $term ) { // for each term 
                        $termsString .= 'filter_'.$term->slug.' '; //create a string that has all the slugs 
                     }

					$full_date      = get_the_date();
					$blog_date      = get_the_date();	
					$post_admin     = get_the_author();

					if(!empty($settings['blog_word_show'])){
						$limit = $settings['blog_word_show'];
					}
					else{
						$limit = 20;
					}

                    if($settings['blog_grid_style'] == 'style1') {
                        include plugin_dir_path(__FILE__)."/style1.php";
                    }
                    if($settings['blog_grid_style'] == 'style2') {
                        include plugin_dir_path(__FILE__)."/style2.php";
                    } 
                        
                        
                ?>                            
                  
					<?php
                    $x++;
					endwhile;
                    
					wp_reset_query();  ?>                 
                         
                </div>   
                               
            	    
                <?php 

                    $blog_item_data = array(
                    'per_page'  => $settings['per_page']
                );
            wp_localize_script( 'vloglab-main', 'blog_load_data', $blog_item_data );

			$paginate = paginate_links( array(
			    'total' => $best_wp->max_num_pages
			));

			if(!empty($paginate ) && ($settings['blog_pagination_show_hide'] == 'yes')){ ?>
				<div class="reactheme-pagination-area"><div class="nav-links"><?php echo wp_kses_post($paginate); ?></div></div>
			<?php } ?>              
		</div>
	   <?php

	}
}?>