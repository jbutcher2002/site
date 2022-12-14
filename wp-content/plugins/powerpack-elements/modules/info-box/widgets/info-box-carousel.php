<?php
namespace PowerpackElements\Modules\InfoBox\Widgets;

use PowerpackElements\Base\Powerpack_Widget;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Info Box Carousel Widget
 */
class Info_Box_Carousel extends Powerpack_Widget {
    
    /**
	 * Retrieve info box carousel widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'pp-info-box-carousel';
    }

    /**
	 * Retrieve info box carousel widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Info Box Carousel', 'powerpack' );
    }

    /**
	 * Retrieve the list of categories the info box carousel widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'power-pack' ];
    }

    /**
	 * Retrieve info box carousel widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'ppicon-info-box-carousel power-pack-admin-icon';
    }
    
    /**
	 * Retrieve the list of scripts the info box carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
    public function get_script_depends() {
        return [
            'jquery-swiper',
            'powerpack-frontend'
        ];
    }

    /**
	 * Register info box carousel widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Info Boxes
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_boxes',
            [
                'label'                     => __( 'Info Boxes', 'powerpack' ),
            ]
        );
        
        $repeater = new Repeater();
        
        $repeater->start_controls_tabs( 'items_repeater' );

        $repeater->start_controls_tab( 'tab_content', [ 'label' => __( 'Content', 'powerpack' ) ] );

            $repeater->add_control(
                'title',
                [
                    'label'                 => __( 'Title', 'powerpack' ),
                    'type'                  => Controls_Manager::TEXT,
                    'dynamic'               => [
                        'active'   => true,
                    ],
                    'default'               => __( 'Title', 'powerpack' ),
                ]
            );

            $repeater->add_control(
                'subtitle',
                [
                    'label'                 => __( 'Subtitle', 'powerpack' ),
                    'type'                  => Controls_Manager::TEXT,
                    'dynamic'               => [
                        'active'   => true,
                    ],
                    'default'               => __( 'Subtitle', 'powerpack' ),
                ]
            );

            $repeater->add_control(
                'description',
                [
                    'label'                 => __( 'Description', 'powerpack' ),
                    'type'                  => Controls_Manager::TEXTAREA,
                    'dynamic'               => [
                        'active'   => true,
                    ],
                    'default'               => __( 'Enter info box description', 'powerpack' ),
                ]
            );
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab( 'tab_icon', [ 'label' => __( 'Icon', 'powerpack' ) ] );
        
            $repeater->add_control(
                'icon_type',
                [
                    'label'                 => esc_html__( 'Type', 'powerpack' ),
                    'type'                  => Controls_Manager::CHOOSE,
                    'label_block'           => false,
                    'options'               => [
                        'none' => [
                            'title' => esc_html__( 'None', 'powerpack' ),
                            'icon' => 'fa fa-ban',
                        ],
                        'icon' => [
                            'title' => esc_html__( 'Icon', 'powerpack' ),
                            'icon' => 'fa fa-gear',
                        ],
                        'image' => [
                            'title' => esc_html__( 'Image', 'powerpack' ),
                            'icon' => 'fa fa-picture-o',
                        ],
                        'text' => [
                            'title' => esc_html__( 'Text', 'powerpack' ),
                            'icon' => 'fa fa-font',
                        ],
                    ],
                    'default'               => 'icon',
                ]
            );

			$repeater->add_control(
				'selected_icon',
				[
					'label'					=> __( 'Icon', 'powerpack' ),
					'type'					=> Controls_Manager::ICONS,
					'label_block'			=> true,
					'default'				=> [
						'value'		=> 'fas fa-check',
						'library'	=> 'fa-solid',
					],
					'fa4compatibility'		=> 'icon',
                    'condition'             => [
                        'icon_type'     => 'icon',
                    ],
				]
			);

            $repeater->add_control(
                'icon_text',
                [
                    'label'                 => __( 'Text', 'powerpack' ),
                    'type'                  => Controls_Manager::TEXT,
                    'dynamic'               => [
                        'active'   => true,
                    ],
                    'default'               => '1',
                    'condition'             => [
                        'icon_type'     => 'text',
                    ],
                ]
            );

            $repeater->add_control(
                'image',
                [
                    'label'                 => __( 'Image', 'powerpack' ),
                    'type'                  => Controls_Manager::MEDIA,
                    'dynamic'               => [
                        'active'   => true,
                    ],
                    'default'               => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition'             => [
                        'icon_type' => 'image',
                    ],
                ]
            );
        
        $repeater->end_controls_tab();
        
        $repeater->start_controls_tab( 'tab_link', [ 'label' => __( 'Link', 'powerpack' ) ] );
        
        $repeater->add_control(
            'link_type',
            [
                'label'                 => __( 'Link Type', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'none',
                'options'               => [
                    'none'      => __( 'None', 'powerpack' ),
                    'box'       => __( 'Box', 'powerpack' ),
                    'icon'      => __( 'Image/Icon', 'powerpack' ),
                    'title'     => __( 'Title', 'powerpack' ),
                    'button'    => __( 'Button', 'powerpack' ),
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'                 => __( 'Link', 'powerpack' ),
                'type'                  => Controls_Manager::URL,
                'dynamic'               => [
                    'active'   => true,
                ],
                'placeholder'           => 'https://www.your-link.com',
                'default'               => [
                    'url' => '#',
                ],
                'condition'             => [
                    'link_type!'   => 'none',
                ],
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label'                 => __( 'Button Text', 'powerpack' ),
                'type'                  => Controls_Manager::TEXT,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => __( 'Get Started', 'powerpack' ),
                'condition'             => [
                    'link_type'   => 'button',
                ],
            ]
        );

		$repeater->add_control(
			'select_button_icon',
			[
				'label'					=> __( 'Button Icon', 'powerpack' ),
				'type'					=> Controls_Manager::ICONS,
				'label_block'			=> true,
				'fa4compatibility'		=> 'button_icon',
				'condition'             => [
					'link_type'   => 'button',
				],
			]
		);
        
        $repeater->add_control(
            'button_icon_position',
            [
                'label'                 => __( 'Icon Position', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'after',
                'options'               => [
                    'before'    => __( 'Before', 'powerpack' ),
                    'after'     => __( 'After', 'powerpack' ),
                ],
                'condition'             => [
                    'link_type'     => 'button',
                ],
            ]
        );
        
        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'pp_info_boxes',
            [
                'label' 	=> '',
                'type' 		=> Controls_Manager::REPEATER,
                'default' 	=> [
                    [
                        'title' => __( 'Info Box 1', 'powerpack' ),
                    ],
                    [
                        'title' => __( 'Info Box 2', 'powerpack' ),
                    ],
                    [
                        'title' => __( 'Info Box 3', 'powerpack' ),
                    ],
                ],
                'fields' 		=> array_values( $repeater->get_controls() ),
                'title_field' 	=> '{{{ title }}}'
            ]
        );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.,
                'label'                 => __( 'Image Size', 'powerpack' ),
                'default'               => 'full',
				'separator'             => 'before',
			]
		);
        
        $this->add_control(
            'divider_title_switch',
            [
                'label'                 => __( 'Title Separator', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'On', 'powerpack' ),
                'label_off'             => __( 'Off', 'powerpack' ),
                'return_value'          => 'yes',
            ]
        );
        
        $this->add_control(
            'title_html_tag',
            [
                'label'                 => __( 'Title HTML Tag', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'h4',
                'options'               => [
                    'h1'     => __( 'H1', 'powerpack' ),
                    'h2'     => __( 'H2', 'powerpack' ),
                    'h3'     => __( 'H3', 'powerpack' ),
                    'h4'     => __( 'H4', 'powerpack' ),
                    'h5'     => __( 'H5', 'powerpack' ),
                    'h6'     => __( 'H6', 'powerpack' ),
                    'div'    => __( 'div', 'powerpack' ),
                    'span'   => __( 'span', 'powerpack' ),
                    'p'      => __( 'p', 'powerpack' ),
                ],
            ]
        );
        
        $this->add_control(
            'sub_title_html_tag',
            [
                'label'                 => __( 'Subtitle HTML Tag', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'h5',
                'options'               => [
                    'h1'     => __( 'H1', 'powerpack' ),
                    'h2'     => __( 'H2', 'powerpack' ),
                    'h3'     => __( 'H3', 'powerpack' ),
                    'h4'     => __( 'H4', 'powerpack' ),
                    'h5'     => __( 'H5', 'powerpack' ),
                    'h6'     => __( 'H6', 'powerpack' ),
                    'div'    => __( 'div', 'powerpack' ),
                    'span'   => __( 'span', 'powerpack' ),
                    'p'      => __( 'p', 'powerpack' ),
                ],
            ]
        );
        
        $this->add_control(
            'equal_height_boxes',
            [
                'label'                 => __( 'Equal Height Boxes', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'On', 'powerpack' ),
                'label_off'             => __( 'Off', 'powerpack' ),
                'return_value'          => 'yes',
                'frontend_available'    => true,
            ]
        );
        
        $this->end_controls_section();

        /**
         * Content Tab: Carousel Settings
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label'                 => __( 'Carousel Settings', 'powerpack' ),
            ]
        );
        
        $this->add_control(
            'carousel_effect',
            [
                'label'                 => __( 'Effect', 'powerpack' ),
                'description'           => __( 'Sets transition effect', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'slide',
                'options'               => [
                    'slide'     => __( 'Slide', 'powerpack' ),
                    'fade'      => __( 'Fade', 'powerpack' ),
                    'cube'      => __( 'Cube', 'powerpack' ),
                    'coverflow' => __( 'Coverflow', 'powerpack' ),
                    'flip'      => __( 'Flip', 'powerpack' ),
                ],
            ]
        );
        
        $this->add_responsive_control(
            'items',
            [
                'label'                 => __( 'Visible Items', 'powerpack' ),
                'description'           => __( 'Number of slides visible at the same time on slider\'s container).', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 3 ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition'             => [
                    'carousel_effect'   => 'slide',
                ],
                'separator'             => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'margin',
            [
                'label'                 => __( 'Items Gap', 'powerpack' ),
                'description'           => __( 'Distance between slides (in px)', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 10 ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition'             => [
                    'carousel_effect'   => 'slide',
                ],
            ]
        );
        
        $this->add_control(
            'slider_speed',
            [
                'label'                 => __( 'Slider Speed', 'powerpack' ),
                'description'           => __( 'Duration of transition between slides (in ms)', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 600 ],
                'range'                 => [
                    'px' => [
                        'min'   => 100,
                        'max'   => 3000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'autoplay',
            [
                'label'                 => __( 'Autoplay', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'          => __( 'Yes', 'powerpack' ),
                'label_off'         => __( 'No', 'powerpack' ),
                'return_value'      => 'yes',
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'autoplay_speed',
            [
                'label'                 => __( 'Autoplay Speed', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 2400 ],
                'range'                 => [
                    'px' => [
                        'min'   => 500,
                        'max'   => 5000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition'             => [
                    'autoplay'      => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'infinite_loop',
            [
                'label'                 => __( 'Infinite Loop', 'powerpack' ),
                'description'           => __( 'Enables continuous loop mode', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'          => __( 'Yes', 'powerpack' ),
                'label_off'         => __( 'No', 'powerpack' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'grab_cursor',
            [
                'label'                 => __( 'Grab Cursor', 'powerpack' ),
                'description'           => __( 'Shows grab cursor when you hover over the slider', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'              => __( 'Show', 'powerpack' ),
                'label_off'             => __( 'Hide', 'powerpack' ),
                'return_value'          => 'yes',
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'navigation_heading',
            [
                'label'                 => __( 'Navigation', 'powerpack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'arrows',
            [
                'label'                 => __( 'Arrows', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'          => __( 'Yes', 'powerpack' ),
                'label_off'         => __( 'No', 'powerpack' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'dots',
            [
                'label'                 => __( 'Pagination', 'powerpack' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'          => __( 'Yes', 'powerpack' ),
                'label_off'         => __( 'No', 'powerpack' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'pagination_type',
            [
                'label'                 => __( 'Pagination Type', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'bullets',
                'options'               => [
                    'bullets'       => __( 'Dots', 'powerpack' ),
                    'fraction'      => __( 'Fraction', 'powerpack' ),
                ],
                'condition'             => [
                    'dots'          => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'direction',
            [
                'label'                 => __( 'Direction', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'left',
                'options'               => [
                    'auto'       => __( 'Auto', 'powerpack' ),
                    'left'       => __( 'Left', 'powerpack' ),
                    'right'      => __( 'Right', 'powerpack' ),
                ],
				'separator'             => 'before',
            ]
        );

        $this->end_controls_section();

		/**
		 * Content Tab: Docs Links
		 *
		 * @since 1.4.8
		 * @access protected
		 */
		$this->start_controls_section(
			'section_help_docs',
			[
				'label' => __( 'Help Docs', 'powerpack' ),
			]
		);
		
		$this->add_control(
			'help_doc_1',
			[
				'type'            => Controls_Manager::RAW_HTML,
				/* translators: %1$s doc link */
				'raw'             => sprintf( __( '%1$s Widget Overview %2$s', 'powerpack' ), '<a href="https://powerpackelements.com/docs/powerpack/widgets/info-box-carousel/info-box-carousel-widget-overview/?utm_source=widget&utm_medium=panel&utm_campaign=userkb" target="_blank" rel="noopener">', '</a>' ),
				'content_classes' => 'pp-editor-doc-links',
			]
		);

		$this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Info Boxes
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_box_style',
            [
                'label'                 => __( 'Info Boxes', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'align',
			[
				'label'                 => __( 'Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'powerpack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'powerpack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'powerpack' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify'   => [
						'title' => __( 'Justified', 'powerpack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box .swiper-slide'   => 'text-align: {{VALUE}};',
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'info_box_background',
				'types'             => [ 'classic', 'gradient' ],
                'separator'             => 'before',
				'selector'          => '{{WRAPPER}} .pp-info-box-content-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'info_box_border',
				'label'                 => __( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
                'separator'             => 'before',
				'selector'              => '{{WRAPPER}} .pp-info-box-content-wrap',
			]
		);

		$this->add_responsive_control(
			'info_box_padding',
			[
				'label'                 => __( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
                'separator'             => 'before',
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Icon Style
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_box_icon_style',
            [
                'label'                 => __( 'Icon Style', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'icon_size',
            [
                'label'                 => __( 'Icon Size', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 5,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_style' );

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label'                 => __( 'Normal', 'powerpack' ),
            ]
        );

        $this->add_control(
            'icon_color_normal',
            [
                'label'                 => __( 'Icon Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .pp-info-box-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'icon_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'icon_border',
				'label'                 => __( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-info-box-icon',
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label'                 => __( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-icon, {{WRAPPER}} .pp-info-box-icon img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
            'icon_rotation',
            [
                'label'                 => __( 'Icon Rotation', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 360,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon' => 'transform: rotate( {{SIZE}}deg );',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'icon_padding',
            [
                'label'                 => __( 'Padding', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 120,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'                 => __( 'Margin', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'           => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label'                 => __( 'Hover', 'powerpack' ),
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'                 => __( 'Icon Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .pp-info-box-icon:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'icon_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'icon_rotation_hover',
            [
                'label'                 => __( 'Icon Rotation', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 360,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box .pp-info-box-icon-wrap:hover' => 'transform: rotate( {{SIZE}}deg );',
                ],
            ]
        );

		$this->add_control(
			'icon_animation',
			[
				'label'                 => __( 'Icon Animation', 'powerpack' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_control(
            'icon_image_heading',
            [
                'label'                 => __( 'Icon Image', 'powerpack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_responsive_control(
            'icon_img_width',
            [
                'label'                 => __( 'Width', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    '%' => [
                        'min'   => 25,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-icon img' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_control(
            'icon_text_heading',
            [
                'label'                 => __( 'Icon Text', 'powerpack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'icon_typography',
                'label'                 => __( 'Typography', 'powerpack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .pp-info-box-icon',
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Title
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_box_title_style',
            [
                'label'                 => __( 'Title', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', 'powerpack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .pp-info-box-title',
            ]
        );
        
        $this->add_responsive_control(
            'title_margin',
            [
                'label'                 => __( 'Margin Bottom', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 20,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->add_control(
            'subtitle_heading',
            [
                'label'                 => __( 'Sub Title', 'powerpack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'subtitle_typography',
                'label'                 => __( 'Typography', 'powerpack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .pp-info-box-subtitle',
            ]
        );
        
        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label'                 => __( 'Margin Bottom', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 20,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Title Separator
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_title_divider_style',
            [
                'label'                 => __( 'Title Separator', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'divider_title_border_type',
            [
                'label'                 => __( 'Border Type', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'solid',
                'options'               => [
                    'none'      => __( 'None', 'powerpack' ),
                    'solid'     => __( 'Solid', 'powerpack' ),
                    'double'    => __( 'Double', 'powerpack' ),
                    'dotted'    => __( 'Dotted', 'powerpack' ),
                    'dashed'    => __( 'Dashed', 'powerpack' ),
                ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-divider' => 'border-bottom-style: {{VALUE}}',
                ],
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'divider_title_width',
            [
                'label'                 => __( 'Border Width', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 30,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 1000,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 1,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-divider' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'divider_title_border_height',
            [
                'label'                 => __( 'Border Height', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 2,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 20,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'divider_title_border_color',
            [
                'label'                 => __( 'Border Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-divider' => 'border-bottom-color: {{VALUE}}',
                ],
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
			'divider_title_align',
			[
				'label'                 => __( 'Alignment', 'powerpack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'powerpack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'powerpack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'powerpack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-divider-wrap'   => 'text-align: {{VALUE}};',
				],
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
			]
		);
        
        $this->add_responsive_control(
            'divider_title_margin',
            [
                'label'                 => __( 'Margin Bottom', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 20,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'divider_title_switch' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Description
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_description_style',
            [
                'label'                 => __( 'Description', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-description' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'description_typography',
                'label'                 => __( 'Typography', 'powerpack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .pp-info-box-description',
            ]
        );

		$this->add_responsive_control(
			'description_padding',
			[
				'label'                 => __( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
            'description_margin',
            [
                'label'                 => __( 'Margin Bottom', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 20,
                ],
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                    '%' => [
                        'min'   => 0,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_info_box_button_style',
            [
                'label'                 => __( 'Button', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'button_size',
			[
				'label'                 => __( 'Size', 'powerpack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'md',
				'options'               => [
					'xs' => __( 'Extra Small', 'powerpack' ),
					'sm' => __( 'Small', 'powerpack' ),
					'md' => __( 'Medium', 'powerpack' ),
					'lg' => __( 'Large', 'powerpack' ),
					'xl' => __( 'Extra Large', 'powerpack' ),
				],
			]
		);

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'                 => __( 'Normal', 'powerpack' ),
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => __( 'Text Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .pp-info-box-button .pp-icon' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => __( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-info-box-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => __( 'Typography', 'powerpack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .pp-info-box-button',
            ]
        );

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => __( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .pp-info-box-button',
			]
		);
        
        $this->add_control(
            'info_box_button_icon_heading',
            [
                'label'                 => __( 'Button Icon', 'powerpack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
                'condition'             => [
                    'button_icon!'  => '',
                ],
            ]
        );

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'                 => __( 'Margin', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'           => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
                'condition'             => [
                    'button_icon!'  => '',
                ],
				'selectors'             => [
					'{{WRAPPER}} .pp-info-box .pp-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'                 => __( 'Hover', 'powerpack' ),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => __( 'Text Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .pp-info-box-button:hover .pp-icon' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-info-box-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'button_hover_animation',
			[
				'label'                 => __( 'Animation', 'powerpack' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .pp-info-box-button:hover',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label'                 => __( 'Arrows', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'arrow',
            [
                'label'                 => __( 'Choose Arrow', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'label_block'           => true,
                'default'               => 'fa fa-angle-right',
                'options'               => [
                    'fa fa-angle-right'             => __( 'Angle', 'powerpack' ),
                    'fa fa-angle-double-right'      => __( 'Double Angle', 'powerpack' ),
                    'fa fa-chevron-right'           => __( 'Chevron', 'powerpack' ),
                    'fa fa-chevron-circle-right'    => __( 'Chevron Circle', 'powerpack' ),
                    'fa fa-arrow-right'             => __( 'Arrow', 'powerpack' ),
                    'fa fa-long-arrow-right'        => __( 'Long Arrow', 'powerpack' ),
                    'fa fa-caret-right'             => __( 'Caret', 'powerpack' ),
                    'fa fa-caret-square-o-right'    => __( 'Caret Square', 'powerpack' ),
                    'fa fa-arrow-circle-right'      => __( 'Arrow Circle', 'powerpack' ),
                    'fa fa-arrow-circle-o-right'    => __( 'Arrow Circle O', 'powerpack' ),
                    'fa fa-toggle-right'            => __( 'Toggle', 'powerpack' ),
                    'fa fa-hand-o-right'            => __( 'Hand', 'powerpack' ),
                ],
            ]
        );
        
        $this->add_responsive_control(
            'arrows_size',
            [
                'label'                 => __( 'Arrows Size', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '22' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'left_arrow_position',
            [
                'label'                 => __( 'Align Left Arrow', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'right_arrow_position',
            [
                'label'                 => __( 'Align Right Arrow', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label'                 => __( 'Normal', 'powerpack' ),
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => __( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev'
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label'                 => __( 'Hover', 'powerpack' ),
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'                 => __( 'Padding', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'             => 'before',
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Pagination: Dots
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label'                 => __( 'Pagination: Dots', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label'                 => __( 'Position', 'powerpack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'inside'     => __( 'Inside', 'powerpack' ),
                   'outside'    => __( 'Outside', 'powerpack' ),
                ],
                'default'               => 'outside',
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_size',
            [
                'label'                 => __( 'Size', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 2,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_spacing',
            [
                'label'                 => __( 'Spacing', 'powerpack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label'                 => __( 'Normal', 'powerpack' ),
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label'                 => __( 'Active Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dots_border_normal',
				'label'                 => __( 'Border', 'powerpack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet',
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
			]
		);

		$this->add_control(
			'dots_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
			]
		);

		$this->add_responsive_control(
			'dots_margin',
			[
				'label'                 => __( 'Margin', 'powerpack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
                'allowed_dimensions'    => 'vertical',
				'placeholder'           => [
					'top'      => '',
					'right'    => 'auto',
					'bottom'   => '',
					'left'     => 'auto',
				],
				'selectors'             => [
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label'                 => __( 'Hover', 'powerpack' ),
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label'                 => __( 'Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        /**
         * Style Tab: Pagination: Dots
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_fraction_style',
            [
                'label'                 => __( 'Pagination: Fraction', 'powerpack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'fraction',
                ],
            ]
        );

        $this->add_control(
            'fraction_text_color',
            [
                'label'                 => __( 'Text Color', 'powerpack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'fraction',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'fraction_typography',
                'label'                 => __( 'Typography', 'powerpack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .swiper-pagination-fraction',
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'fraction',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

	/**
	 * Slider Settings.
	 *
	 * @access public
	 */
	public function slider_settings() {
        $settings = $this->get_settings();
        
        $slider_options = [
			'direction'              => 'horizontal',
			'speed'                  => ( $settings['slider_speed']['size'] !== '' ) ? $settings['slider_speed']['size'] : 400,
			'effect'                 => ( $settings['carousel_effect'] ) ? $settings['carousel_effect'] : 'slide',
			'slidesPerView'          => ( $settings['items']['size'] !== '' ) ? absint( $settings['items']['size'] ) : 3,
			'spaceBetween'           => ( $settings['margin']['size'] !== '' ) ? $settings['margin']['size'] : 10,
			'grabCursor'             => ( $settings['grab_cursor'] === 'yes' ),
			'autoHeight'             => true,
			'loop'                   => ( $settings['infinite_loop'] === 'yes' ),
		];
        
        if ( $settings['autoplay'] == 'yes' && ! empty( $settings['autoplay_speed']['size'] ) ) {
            $autoplay_speed = $settings['autoplay_speed']['size'];
        } else {
            $autoplay_speed = 999999;
        }
        
        $slider_options['autoplay'] = [
            'delay'                  => $autoplay_speed
        ];
        
        if ( $settings['dots'] == 'yes' ) {
            $slider_options['pagination'] = [
                'el'                 => '.swiper-pagination-'.esc_attr( $this->get_id() ),
                'type'               => $settings['pagination_type'],
                'clickable'          => true,
            ];
        }
        
        if ( $settings['arrows'] == 'yes' ) {
            $slider_options['navigation'] = [
                'nextEl'             => '.swiper-button-next-'.esc_attr( $this->get_id() ),
                'prevEl'             => '.swiper-button-prev-'.esc_attr( $this->get_id() ),
            ];
        }
        
        $slider_options['breakpoints'] = [
            '768'   => [
                'slidesPerView'      => ( $settings['items_tablet']['size'] !== '' ) ? absint( $settings['items_tablet']['size'] ) : 2,
                'spaceBetween'       => ( $settings['margin_tablet']['size'] !== '' ) ? $settings['margin_tablet']['size'] : 10,
            ],
            '480'   => [
                'slidesPerView'      => ( $settings['items_mobile']['size'] !== '' ) ? absint( $settings['items_mobile']['size'] ) : 1,
                'spaceBetween'       => ( $settings['margin_mobile']['size'] !== '' ) ? $settings['margin_mobile']['size'] : 10,
            ],
        ];
        
        $this->add_render_attribute(
			'info-box-carousel-wrap',
			[
				'data-slider-settings' => wp_json_encode( $slider_options ),
			]
		);
    }

    /**
	 * Render info box carousel widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'info-box-carousel-wrap', 'class', 'swiper-container-wrap pp-info-box-carousel-wrap' );

        if ( $settings['dots_position'] ) {
            $this->add_render_attribute( 'info-box-carousel-wrap', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position'] );
        } elseif ( $settings['pagination_type'] == 'fraction' ) {
            $this->add_render_attribute( 'info-box-carousel-wrap', 'class', 'swiper-container-wrap-dots-outside' );
        }
        
        $this->slider_settings();
        
        if ( $settings['direction'] == 'right' || is_rtl() ) {
            $this->add_render_attribute( 'info-box-carousel', 'dir', 'rtl' );
        }
        
        $this->add_render_attribute(
            'info-box-carousel',
            [
                'class'             => [ 'swiper-container', 'pp-info-box', 'pp-info-box-carousel', 'swiper-container-'.esc_attr( $this->get_id() ) ],
                'data-pagination'   => '.swiper-pagination-'.esc_attr( $this->get_id() ),
                'data-arrow-next'   => '.swiper-button-next-'.esc_attr( $this->get_id() ),
                'data-arrow-prev'   => '.swiper-button-prev-'.esc_attr( $this->get_id() ),
            ]
        );
        
        $this->add_render_attribute( 'info-box-container', 'class', 'pp-info-box-container' );
            
        $this->add_render_attribute( 'title-container', 'class', 'pp-info-box-title-container' );
        
        $pp_if_html_tag = 'div';
        $pp_title_html_tag = 'div';
        $pp_button_html_tag = 'div';
        
        $this->add_render_attribute( 'info-box-button', 'class', [
				'pp-info-box-button',
				'elementor-button',
				'elementor-size-' . $settings['button_size'],
			]
		);

		if ( $settings['button_hover_animation'] ) {
			$this->add_render_attribute( 'info-box-button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}
        
        $this->add_render_attribute( 'icon', 'class', ['pp-info-box-icon', 'pp-icon'] );

		if ( $settings['icon_animation'] ) {
			$this->add_render_attribute( 'icon', 'class', 'elementor-animation-' . $settings['icon_animation'] );
		}
        ?>
        <div <?php echo $this->get_render_attribute_string( 'info-box-carousel-wrap' ); ?>>
            <div <?php echo $this->get_render_attribute_string( 'info-box-carousel' ); ?>>
                <div class="swiper-wrapper">
                <?php
                $i = 1;

                foreach ( $settings['pp_info_boxes'] as $item ) :

                    if ( $item['link_type'] != 'none' ) {
                        if ( ! empty( $item['link']['url'] ) ) {
                            
                            $this->add_render_attribute( 'link' . $i, 'href', $item['link']['url'] );

                            if ( $item['link']['is_external'] ) {
                                $this->add_render_attribute( 'link' . $i, 'target', '_blank' );
                            }

                            if ( $item['link']['nofollow'] ) {
                                $this->add_render_attribute( 'link' . $i, 'rel', 'nofollow' );
                            }
                            
                            if ( $item['link_type'] == 'title' ) {
                                $pp_title_html_tag = 'a';
                            }
                            elseif ( $item['link_type'] == 'button' ) {
                                $pp_button_html_tag = 'a';
                            }
                        }
                    }
                    ?>
                    <div class="swiper-slide">
						<div class="pp-info-box-content-wrap">
							<?php if ( $item['link_type'] == 'box' ) { ?>
								<a <?php echo $this->get_render_attribute_string( 'link' . $i ); ?>>
							<?php } ?>
							<?php if ( $item['icon_type'] != 'none' ) { ?>
								<div class="pp-info-box-icon-wrap">
									<?php if ( $item['link_type'] == 'icon' ) { ?>
										<a <?php echo $this->get_render_attribute_string( 'link' . $i ); ?>>
									<?php } ?>
									<?php $this->render_infobox_icon( $item ); ?>
									<?php if ( $item['link_type'] == 'icon' ) { ?>
										</a>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="pp-info-box-content">
								<div class="pp-info-box-title-wrap">
									<?php
										if ( ! empty( $item['title'] ) ) {
											printf( '<%1$s %2$s %3$s>', $pp_title_html_tag, $this->get_render_attribute_string( 'title-container' . $i ), $this->get_render_attribute_string( 'link' . $i ) );
											printf( '<%1$s class="pp-info-box-title">', $settings['title_html_tag'] );
											echo $item['title'];
											printf( '</%1$s>', $settings['title_html_tag'] );
											printf( '</%1$s>', $pp_title_html_tag );
										}

										if ( ! empty( $item['subtitle'] ) ) {
											printf( '<%1$s class="pp-info-box-subtitle">', $settings['sub_title_html_tag'] );
											echo $item['subtitle'];
											printf( '</%1$s>', $settings['sub_title_html_tag'] );
										}
									?>
								</div>

								<?php if ( $settings['divider_title_switch'] == 'yes' ) { ?>
									<div class="pp-info-box-divider-wrap">
										<div class="pp-info-box-divider"></div>
									</div>
								<?php } ?>

								<?php if ( ! empty( $item['description'] ) ) { ?>
									<div class="pp-info-box-description">
										<?php echo $this->parse_text_editor( nl2br( $item['description'] ) ); ?>
									</div>
								<?php } ?>
								<?php if ( $item['link_type'] == 'button' ) { ?>
									<div class="pp-info-box-footer">
										<<?php echo $pp_button_html_tag. ' ' . $this->get_render_attribute_string( 'info-box-button' . $i ) . $this->get_render_attribute_string( 'link' . $i ); ?>>
											<div <?php echo $this->get_render_attribute_string( 'info-box-button' ); ?>>
												<?php
													if ( $item['button_icon_position'] == 'before' ) { 
														$this->render_infobox_button_icon($item);
													}
												?>
												<?php if ( ! empty( $item['button_text'] ) ) { ?>
													<span class="pp-button-text">
														<?php echo esc_attr( $item['button_text'] ); ?>
													</span>
												<?php } ?>
												<?php
													if ( $item['button_icon_position'] == 'after' ) { 
														$this->render_infobox_button_icon($item);
													}
												?>
											</div>
										</<?php echo $pp_button_html_tag; ?>>
									</div>
								<?php } ?>
								<?php if ( $item['link_type'] == 'box' ) { ?>
									</a>
								<?php } ?>
							</div><!-- .pp-info-box-content -->
						</div>
                    </div>
                <?php $i++; endforeach; ?>
                </div>
            </div>
            <?php
                $this->render_dots();

                $this->render_arrows();
            ?>
        </div>
        <?php
    }

    /**
	 * Render info-box carousel icon output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_infobox_icon( $item ) {
        $settings = $this->get_settings_for_display();

		$fallback_defaults = [
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		];
		
		$migration_allowed = Icons_Manager::is_migration_allowed();
		
		// add old default
		if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
			$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
		}

		$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
		$is_new = ! isset( $item['icon'] ) && $migration_allowed;
		
		if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) {
			?>
			<span <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
				<?php if ( $item['icon_type'] == 'icon' ) { ?>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
					} else { ?>
							<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
					<?php } ?>
				<?php } elseif ( $item['icon_type'] == 'image' ) { ?>
					<?php
						if ( ! empty( $item['image']['url'] ) ) {
							$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail', $settings );

							if ( $image_url ) {
								echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( Control_Media::get_image_alt( $item['image'] ) ) . '">';
							} else {
								echo '<img src="' . esc_url( $item['image']['url'] ) . '">';
							}
						}
					?>
				<?php } elseif ( $item['icon_type'] == 'text' ) {
					echo $item['icon_text'];
				} ?>
			</span>
			<?php
		}
    }

    /**
	 * Render info-box carousel icon output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_infobox_button_icon( $item ) {
        $settings = $this->get_settings_for_display();
		
		$migration_allowed = Icons_Manager::is_migration_allowed();
		
		// add old default
		if ( ! isset( $item['button_icon'] ) && ! $migration_allowed ) {
			$item['button_icon'] = '';
		}

		$migrated = isset( $item['__fa4_migrated']['select_button_icon'] );
		$is_new = ! isset( $item['button_icon'] ) && $migration_allowed;
		
		if ( ! empty( $item['button_icon'] ) || ( ! empty( $item['select_button_icon']['value'] ) && $is_new ) ) {
			?>
			<span class="pp-button-icon pp-icon">
				<?php
				if ( $is_new || $migrated ) {
					Icons_Manager::render_icon( $item['select_button_icon'], [ 'aria-hidden' => 'true' ] );
				} else { ?>
						<i class="<?php echo esc_attr( $item['button_icon'] ); ?>" aria-hidden="true"></i>
				<?php } ?>
			</span>
			<?php
		}
    }

    /**
	 * Render info-box carousel dots output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_dots() {
        $settings = $this->get_settings_for_display();

        if ( $settings['dots'] == 'yes' ) { ?>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ); ?>"></div>
        <?php }
    }

    /**
	 * Render info-box carousel arrows output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_arrows() {
        $settings = $this->get_settings_for_display();

        if ( $settings['arrows'] == 'yes' ) { ?>
            <?php
                if ( $settings['arrow'] ) {
                    $pa_next_arrow = $settings['arrow'];
                    $pa_prev_arrow = str_replace("right","left",$settings['arrow']);
                }
                else {
                    $pa_next_arrow = 'fa fa-angle-right';
                    $pa_prev_arrow = 'fa fa-angle-left';
                }
            ?>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $pa_next_arrow ); ?>"></i>
            </div>
            <div class="swiper-button-prev swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $pa_prev_arrow ); ?>"></i>
            </div>
        <?php }
    }

    protected function _content_template() {
        ?>
        <#
           function dots_template() {
                if ( settings.dots == 'yes' ) {
                    #>
                    <div class="swiper-pagination"></div>
                    <#
                }
           }

           function arrows_template() {
                if ( settings.arrows == 'yes' ) {
                    if ( settings.arrow != '' ) {
                        var pp_next_arrow = settings.arrow;
                        var pp_prev_arrow = pp_next_arrow.replace('right', "left");
                    }
                    else {
                        var pp_next_arrow = 'fa fa-angle-right';
                        var pp_prev_arrow = 'fa fa-angle-left';
                    }
                    #>
                    <div class="swiper-button-next">
                        <i class="{{ pp_next_arrow }}"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="{{ pp_prev_arrow }}"></i>
                    </div>
                    <#
                }
           }
					   
           function button_icon_template( item, index ) {
				var buttonIconHTML = {},
					buttonMigrated = {};

				if ( item.button_icon || item.select_button_icon.value ) { #>
					<span class="pp-button-icon pp-icon">
						<#
						buttonIconHTML[ index ] = elementor.helpers.renderIcon( view, item.select_button_icon, { 'aria-hidden': true }, 'i', 'object' );
						buttonMigrated[ index ] = elementor.helpers.isIconMigrated( item, 'select_button_icon' );
						if ( buttonIconHTML[ index ] && buttonIconHTML[ index ].rendered && ( ! item.button_icon || buttonMigrated[ index ] ) ) { #>
							{{{ buttonIconHTML[ index ].value }}}
						<# } else { #>
							<i class="{{ item.button_icon }}" aria-hidden="true"></i>
						<# } #>
					</span>
					<#
				}
           }

           function get_slider_settings( settings ) {

                var $items          = ( settings.items.size !== '' || settings.items.size !== undefined ) ? settings.items.size : 3,
                    $items_tablet   = ( settings.items_tablet.size !== '' || settings.items_tablet.size !== undefined ) ? settings.items_tablet.size : 2,
                    $items_mobile   = ( settings.items_mobile.size !== '' || settings.items_mobile.size !== undefined ) ? settings.items_mobile.size : 1,
                    $speed          = ( settings.slider_speed.size !== '' || settings.slider_speed.size !== undefined ) ? settings.slider_speed.size : 400,
                    $margin         = ( settings.margin.size !== '' || settings.margin.size !== undefined ) ? settings.margin.size : 10,
                    $margin_tablet  = ( settings.margin_tablet.size !== '' || settings.margin_tablet.size !== undefined ) ? settings.margin_tablet.size : 10,
                    $margin_mobile  = ( settings.margin_mobile.size !== '' || settings.margin_mobile.size !== undefined ) ? settings.margin_mobile.size : 10,
                    $autoplay       = ( settings.autoplay == 'yes' && settings.autoplay_speed.size != '' ) ? settings.autoplay_speed.size : 999999;

                return {
                    direction:              "horizontal",
                    speed:                  $speed,
                    effect:                 settings.carousel_effect,
                    slidesPerView:          $items,
                    spaceBetween:           $margin,
                    grabCursor:             ( settings.grab_cursor === 'yes' ) ? true : false,
                    autoHeight:             true,
                    loop:                   ( settings.infinite_loop === 'yes' ),
                    autoplay: {
                        delay: $autoplay,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        type: settings.pagination_type,
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView:  $items_tablet,
                            spaceBetween:   $margin_tablet
                        },
                        480: {
                            slidesPerView:  $items_mobile,
                            spaceBetween:   $margin_mobile
                        }
                    }
                };
           };

           view.addRenderAttribute(
                'info-box-carousel-wrap',
                {
                    'class': [ 'swiper-container-wrap', 'pp-info-box-carousel-wrap', 'swiper-container-wrap-dots-' + settings.dots_position ],
                }
           );

           var slider_options = get_slider_settings( settings );

           view.addRenderAttribute( 'info-box-carousel-wrap', 'data-slider-settings', JSON.stringify( slider_options ) );
                  
		   if ( settings.direction == 'auto' ) {
			   #>
			   <?php if ( is_rtl() ) { ?>
					<# view.addRenderAttribute( 'info-box-carousel', 'dir', 'rtl' ); #>
			   <?php } ?>
			   <#
		   } else {
			   if ( settings.direction == 'right' ) {
					view.addRenderAttribute( 'info-box-carousel', 'dir', 'rtl' );
			   }
		   }
			  
           view.addRenderAttribute(
                'info-box-carousel',
                {
                    'class': [ 'swiper-container', 'pp-info-box', 'pp-info-box-carousel' ],
                    'data-pagination': 'swiper-pagination',
                    'data-arrow-next': 'swiper-button-next',
                    'data-arrow-prev': 'swiper-button-prev',
                }
           );

           view.addRenderAttribute( 'info-box-container', 'class', 'pp-info-box-container' );
                       
           view.addRenderAttribute( 'title-container', 'class', 'pp-info-box-title-container' );
        
           var $pp_if_html_tag = 'div',
                $pp_title_html_tag = 'div',
                $pp_button_html_tag = 'div';

           view.addRenderAttribute( 'info-box-button', 'class', [
                    'pp-info-box-button',
				    'elementor-button',
				    'elementor-size-' + settings.button_size,
                ],
           );

           if ( settings.button_hover_animation ) {
                view.addRenderAttribute( 'info-box-button', 'class', 'elementor-animation-' + settings.button_hover_animation );
           }

           view.addRenderAttribute( 'icon', 'class', ['pp-info-box-icon', 'pp-icon'] );

           if ( settings.icon_animation ) {
                view.addRenderAttribute( 'icon', 'class', 'elementor-animation-' + settings.icon_animation );
           }
			  
			var iconsHTML = {},
				migrated = {};
        #>
        <div {{{ view.getRenderAttributeString( 'info-box-carousel-wrap' ) }}}>
            <div {{{ view.getRenderAttributeString( 'info-box-carousel' ) }}}>
                <div class="swiper-wrapper">
                <#
                   var i = 1;

                   _.each( settings.pp_info_boxes, function( item, index ) {

                        if ( item.link_type != 'none' ) {
                            if ( item.link.url ) {
                   
                                view.addRenderAttribute( 'link' + i, 'href', item.link.url );

                                if ( item.link.is_external ) {
                                    view.addRenderAttribute( 'link' + i, 'target', '_blank' );
                                }

                                if ( item.link.nofollow ) {
                                    view.addRenderAttribute( 'link' + i, 'rel', 'nofollow' );
                                }
                            
                                if ( item.link_type == 'title' ) {
                                    $pp_title_html_tag = 'a';
                                }
                                else if ( item.link_type == 'button' ) {
                                    $pp_button_html_tag = 'a';
                                }
                            }
                        }
                    #>
                    <div class="swiper-slide">
						<div class="pp-info-box-content-wrap">
							<# if ( item.link_type == 'box' ) { #>
								<a {{{ view.getRenderAttributeString( 'link' + i ) }}}>
							<# } #>
							<# if ( item.icon_type != 'none' ) { #>
								<div class="pp-info-box-icon-wrap">
									<# if ( item.link_type == 'icon' ) { #>
										<a {{{ view.getRenderAttributeString( 'link' + i ) }}}>
									<# } #>
									<span {{{ view.getRenderAttributeString( 'icon' ) }}}>
										<# if ( item.icon_type == 'icon' ) { #>
											<# if ( item.icon || item.selected_icon.value ) { #>
												<#
													iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
													migrated[ index ] = elementor.helpers.isIconMigrated( item, 'selected_icon' );
													if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.icon || migrated[ index ] ) ) { #>
														{{{ iconsHTML[ index ].value }}}
													<# } else { #>
														<i class="{{ item.icon }}" aria-hidden="true"></i>
													<# }
												#>
											<# } #>
										<# } else if ( item.icon_type == 'image' ) { #>
											<#
											var image = {
												id: item.image.id,
												url: item.image.url,
												size: settings.thumbnail_size,
												dimension: settings.thumbnail_custom_dimension,
												model: view.getEditModel()
											};
											var image_url = elementor.imagesManager.getImageUrl( image );
											#>
											<img src="{{{ image_url }}}" />
										<# } else if ( item.icon_type == 'text' ) {
											{{{ item.icon_text }}}
										} #>
									</span>
									<# if ( item.link_type == 'icon' ) { #>
										</a>
									<# } #>
								</div>
							<# } #>
							<div class="pp-info-box-content">
								<div class="pp-info-box-title-wrap">
									<#
										if ( item.title ) {
											#>
											<{{{ $pp_title_html_tag }}} {{{ view.getRenderAttributeString( 'title-container' + i ) }}} {{{ view.getRenderAttributeString( 'link' + i ) }}}>

											<{{{ settings.title_html_tag }}} class="pp-info-box-title">
											{{ item.title }}
											</{{{ settings.title_html_tag }}}>
											</{{{ $pp_title_html_tag }}}>
											<#
										}

										if ( item.subtitle ) {
											#>
											<{{{ settings.sub_title_html_tag }}} class="pp-info-box-subtitle">
											{{ item.subtitle }}
											</{{{ settings.sub_title_html_tag }}}>
											<#
										}
									#>
								</div>

								<# if ( settings.divider_title_switch == 'yes' ) { #>
									<div class="pp-info-box-divider-wrap">
										<div class="pp-info-box-divider"></div>
									</div>
								<# } #>

								<# if ( item.description ) { #>
									<div class="pp-info-box-description">
										{{ item.description }}
									</div>
								<# } #>
								<# if ( item.link_type == 'button' ) { #>
									<div class="pp-info-box-footer">
										<{{{ $pp_button_html_tag }}} {{{ view.getRenderAttributeString( 'info-box-button' + i ) }}} {{{ view.getRenderAttributeString( 'link' + i ) }}}>
											<div {{{ view.getRenderAttributeString( 'info-box-button' ) }}}>
												<# if ( item.button_icon && item.button_icon_position == 'before' ) { #>
													<# button_icon_template( item, index ); #>
												<# } #>
												<# if ( item.button_text ) { #>
													<span class="pp-button-text">
														{{ item.button_text }}
													</span>
												<# } #>
												<# if ( item.button_icon_position == 'after' ) { #>
													<# button_icon_template( item, index ); #>
												<# } #>
											</div>
										</{{{ $pp_button_html_tag }}}>
									</div>
								<# } #>
								<# if ( item.link_type == 'box' ) { #>
									</a>
								<# } #>
							</div><!-- .pp-info-box-content -->
						</div>
                    </div>
                <# i++ } ); #>
                </div>
            </div>
            <# dots_template(); #>
            <# arrows_template(); #>
        </div>
        <?php
        }

}