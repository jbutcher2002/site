<?php
namespace PowerpackElements\Modules\ProtectedContent\Widgets;

use PowerpackElements\Base\Powerpack_Widget;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Protected Content Widget
 */
class Protected_Content extends Powerpack_Widget {
    
    /**
	 * Retrieve protected content widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'pp-protected-content';
    }

    /**
	 * Retrieve protected content widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Protected Content', 'power-pack' );
    }

    /**
	 * Retrieve the list of categories the protected content widget belongs to.
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
	 * Retrieve protected content widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'ppicon-promo-box power-pack-admin-icon';
    }

    /**
	 * Register protected content widget controls.
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
         * Content Tab: Content
         */
        $this->start_controls_section(
			'section_protected_content',
			[
				'label'                 => esc_html__( 'Protected Content', 'power-pack' ),
			]
		);
        
        $this->add_control(
			'protected_content_type',
			[
				'label'                 => esc_html__( 'Content Type', 'power-pack' ),
				'type'                  => Controls_Manager::SELECT,
				'label_block'           => false,
                'options'               => [
                    'content'   => __( 'Content', 'power-pack' ),
                    'image'     => __( 'Image', 'power-pack' ),
                    'video' 	=> __( 'Video', 'power-pack' ),
                    'section'   => __( 'Saved Section', 'power-pack' ),
                    'widget'    => __( 'Saved Widget', 'power-pack' ),
                    'template'  => __( 'Saved Page Template', 'power-pack' ),
                ],
				'default'               => 'content',
			]
		);
		
		$this->add_control(
			'protected_content_text',
			[
				'label'                 => esc_html__( 'Content', 'power-pack' ),
				'type'                  => Controls_Manager::WYSIWYG,
				'label_block'           => true,
				'dynamic'               => [
					'active' => true
				],
				'default'               => esc_html__( 'This is the content that you want to be protected by either role or password.', 'power-pack' ),
				'condition'             => [
					'protected_content_type'      => 'content',
				],
			]
		);
        
        $this->add_control(
			'protected_image',
            [
                'name'                  => __( 'Image', 'power-pack' ),
                'type'                  => Controls_Manager::MEDIA,
                'default'               => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition'             => [
                    'protected_content_type' => 'image',
                ],
            ]
		);
        
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'                  => 'protected_image',
                'label'                 => __( 'Image Size', 'power-pack' ),
                'default'               => 'full',
                'exclude'               => [ 'custom' ],
                'condition'             => [
                    'protected_content_type' => 'image',
                ],
            ]
        );
        
        $this->add_control(
			'protected_saved_widget',
            [
                'label'                 => __( 'Choose Widget', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'widget' ),
                'default'               => '-1',
                'condition'             => [
                    'protected_content_type' => 'widget',
                ],
            ]
		);
        
        $this->add_control(
			'protected_saved_section',
            [
                'label'                 => __( 'Choose Section', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'section' ),
                'default'               => '-1',
                'condition'             => [
                    'protected_content_type' => 'section',
                ],
            ]
		);
        
        $this->add_control(
			'protected_templates',
            [
                'label'                 => __( 'Choose Template', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'page' ),
                'default'               => '-1',
                'condition'             => [
                    'protected_content_type' => 'template',
                ],
            ]
		);
		
		$this->end_controls_section();

		/**
		 * Content Tab: Protection Rule
		 */
		$this->start_controls_section(
			'section_protection_rule',
			[
				'label'                 => esc_html__( 'Protection Rule', 'power-pack' )
			]
		);
		
		$this->add_control(
			'protection_by',
			[
				'label'                 => esc_html__('Protection By', 'power-pack'),
				'label_block'			=> false,
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'role'         => esc_html__('User Role', 'power-pack'),
					'password'     => esc_html__('Password', 'power-pack')
				],
				'default'               => 'role'
			]
		);

		$this->add_control(
            'user_roles',
            [
                'label'                 => __( 'Select Roles', 'power-pack' ),
				'type'                  => Controls_Manager::SELECT2,
				'label_block'			=> true,
				'multiple' 				=> true,
				'options'				=> pp_user_roles(),
				'condition'             => [
					'protection_by'	=> 'role'
				]
            ]
		);

		$this->add_control(
			'content_password',
			[
				'label'                 => esc_html__( 'Set Password', 'power-pack' ),
				'type'                  => Controls_Manager::TEXT,
				'input_type'            => 'password',
				'condition'             => [
					'protection_by'	=> 'password'
				]
			]
		);
        
        $this->add_responsive_control(
			'password_form_alignment',
			[
				'label'                 => esc_html__( 'Password Form Alignment', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => true,
				'toggle'                => false,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'power-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'           => [
						'title' => __( 'Center', 'power-pack' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'            => [
						'title' => __( 'Right', 'power-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => 'left',
                'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'center'   => 'center',
					'right'    => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-password-protected-content-form > form' => 'justify-content: {{VALUE}};',
				],
                'condition'             => [
                    'protection_by'	=> 'password'
                ],
			]
		);
		
		$this->add_control(
			'preview_content',
			[
				'label'                 => __( 'Preview Content', 'power-pack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'no',
				'label_on'              => __( 'Show', 'power-pack' ),
				'label_off'             => __( 'Hide', 'power-pack' ),
				'return_value'          => 'yes',
				'description'           => 'You can preview the content in editor to style it properly.',
				'condition'             => [
					'protection_by'	=> 'password'
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Content Tab: Info Message
		 */
		$this->start_controls_section(
			'section_info_message',
			[
				'label'                 => esc_html__( 'Info Message' , 'power-pack' ),
			]
		);

		$this->add_control(
			'info_message_type',
			[
				'label'                 => esc_html__('Message Type', 'power-pack'),
				'label_block'			=> false,
				'type'                  => Controls_Manager::SELECT,
                'description'           => esc_html__('Set a message or a saved template when the content is protected.', 'power-pack'),
				'options'               => [
					'none'         => esc_html__( 'None', 'power-pack' ),
					'text'         => esc_html__( 'Message', 'power-pack' ),
					'section'      => esc_html__( 'Saved Section', 'power-pack' ),
				],
				'default'               => 'text'
			]
		);

		$this->add_control(
			'info_message_text',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::WYSIWYG,
				'default'               => esc_html__('You do not have permission to see this content.','power-pack'),
				'dynamic'               => [
					'active' => true
				],
				'condition'             => [
					'info_message_type' => 'text'
				]
			]
		);
        
        $this->add_control(
			'info_message_saved_section',
            [
                'label'                 => __( 'Choose Section', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'section' ),
                'default'               => '-1',
                'condition'             => [
                    'info_message_type' => 'section',
                ],
            ]
		);

		$this->add_control(
			'preview_info_message', 
			[
				'label'                 => __( 'Preview Info Message', 'power-pack' ),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'no',
				'label_on'              => __( 'Show', 'power-pack' ),
				'label_off'             => __( 'Hide', 'power-pack' ),
				'return_value'          => 'yes',
				'description'           => __( 'You can preview info message in editor to style it properly.', 'power-pack' ),
                'condition'             => [
                    'protection_by' => 'role',
                ],
			]
		);

		$this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Style Tab: Protected Content
         */
		$this->start_controls_section(
			'protected_content_style',
			[
				'label'                 => esc_html__( 'Protected Content', 'power-pack' ),
				'tab'                   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'protected_content_color',
			[
				'label'                 => esc_html__( 'Text Color', 'power-pack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-protected-content-wrap .pp-protected-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'                  => 'protected_content_typography',
				'selector'              => '{{WRAPPER}} .pp-protected-content-wrap .pp-protected-content',
			]
		);

		$this->add_responsive_control(
			'protected_content_alignment',
			[
				'label'                 => esc_html__( 'Text Alignment', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => true,
				'options'               => [
					'left' => [
						'title' => esc_html__( 'Left', 'power-pack' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'power-pack' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'power-pack' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'               => 'left',
				'selectors'             => [
					'{{WRAPPER}} .pp-protected-content-wrap .pp-protected-content' => 'text-align: {{VALUE}};',
				], 
			]
		);

		$this->add_responsive_control(
			'protected_content_padding',
			[
				'label'                 => esc_html__( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-protected-content-wrap .pp-protected-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        /**
         * Style Tab: Info Message
         */
		$this->start_controls_section(
			'section_info_message_style',
			[
				'label'                 => esc_html__( 'Info Message', 'power-pack' ),
				'tab'                   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'info_message_text_color',
			[
				'label'                 => esc_html__( 'Text Color', 'power-pack' ),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .pp-protected-content-info-message' => 'color: {{VALUE}};',
				], 
				'condition'             => [
					'info_message_type' => 'text',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
                'name'                  => 'info_message_text_typography',
				'selector'              => '{{WRAPPER}} .pp-protected-content-info-message, {{WRAPPER}} .pp-protected-content-error-message',
				'condition'             => [
					'info_message_type' => 'text',
				],
			]
		);

		$this->add_responsive_control(
			'info_message_text_alignment',
			[
				'label'                 => esc_html__( 'Text Alignment', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => true,
				'options'               => [
					'left' => [
						'title' => esc_html__( 'Left', 'power-pack' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'power-pack' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'power-pack' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'               => 'left',
				'selectors'             => [
					'{{WRAPPER}} .pp-protected-content-info-message, {{WRAPPER}} .pp-protected-content-error-message' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_message_text_padding',
			[
				'label'                 => esc_html__( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%', 'em' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-protected-content-info-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'info_message_type' => 'text',
				],
			]
		);

		$this->end_controls_section();
		
		/**
         * Style Tab: Password Form: Input Field
         */
		$this->start_controls_section(
			'section_password_field_style',
			[
				'label'                 => esc_html__( 'Password Form: Input Field', 'power-pack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'protection_by'	=> 'password'
				]
				
			]
		);

		$this->add_control(
			'password_form_input_width',
			[
				'label'                 => esc_html__( 'Input Width', 'power-pack' ),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'max' => 1000,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password' => 'width: {{SIZE}}px;'
				],
				'condition'             => [
					'protection_by'	=> 'password'
				]
			]
		);

		$this->add_responsive_control(
			'password_form_input_margin',
			[
				'label'                 => esc_html__( 'Margin', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'protection_by'	=> 'password'
				]
			]
		);

		$this->add_responsive_control(
			'password_form_input_padding',
			[
				'label'                 => esc_html__( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'protection_by'	=> 'password'
				]
			]
		);

		$this->start_controls_tabs('password_form_input_style_tabs');

        $this->start_controls_tab(
            'password_form_input_normal_style',
            [
                'label'                 => esc_html__( 'Normal', 'power-pack' ),
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );	

        $this->add_control(
            'password_form_input_color',
            [
                'label'                 => esc_html__( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#333333',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_form_input_bg_color',
            [
                'label'                 => esc_html__( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password' => 'background-color: {{VALUE}};',
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'password_form_input_typography',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'password_form_input_border',
                'label'                 => esc_html__( 'Border', 'power-pack' ),
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

		$this->add_control(
			'password_form_input_border_radius',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'protection_by'	=> 'password'
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'password_form_input_box_shadow',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'password_form_input_hover_style',
            [
                'label'                 => esc_html__( 'Hover', 'power-pack' ),
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_form_input_color_hover',
            [
                'label'                 => esc_html__( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#333333',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password:hover' => 'color: {{VALUE}};',
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_form_input_bg_color_hover',
            [
                'label'                 => esc_html__( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password:hover' => 'background-color: {{VALUE}};',
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_form_input_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password:hover' => 'border-color: {{VALUE}};',
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'password_form_input_box_shadow_hover',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-password:hover',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
		
        /**
         * Content Tab: Password Form: Button
         */
		$this->start_controls_section(
			'section_password_button_style',
			[
				'label'                 => esc_html__( 'Password Form: Button', 'power-pack' ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'protection_by'	=> 'password'
				]
			]
		);

        $this->add_responsive_control(
            'password_button_margin',
            [
                'label'                 => esc_html__( 'Margin', 'power-pack' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_responsive_control(
            'password_button_padding',
            [
                'label'                 => esc_html__( 'Padding', 'power-pack' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ], 
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->start_controls_tabs('password_button_style_tabs');

        $this->start_controls_tab(
            'password_button_normal_tab',
            [
                'label'                 => esc_html__( 'Normal', 'power-pack' ),
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_button_color',
            [
                'label'                 => esc_html__( 'Text Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit' => 'color: {{VALUE}};'
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_button_bg_color',
            [
                'label'                 => esc_html__( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#333333',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit' => 'background: {{VALUE}};'
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'password_button_typography',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                  => 'password_button_border',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

		$this->add_control(
			'password_button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'protection_by'	=> 'password'
                ],
			]
		);

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'password_button_box_shadow',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'protected_content_submit_button_hover',
            [
                'label'                 => esc_html__( 'Hover', 'power-pack' ),
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_button_text_color_hover',
            [
                'label'                 => esc_html__( 'Text Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit:hover' => 'color: {{VALUE}};'
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_button_bg_color_hover',
            [
                'label'                 => esc_html__( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#333333',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit:hover' => 'background: {{VALUE}};'
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_control(
            'password_button_border_color_hover',
            [
                'label'                 => esc_html__( 'Border Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit:hover' => 'border-color: {{VALUE}};'
                ],
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                  => 'password_button_box_shadow_hover',
                'selector'              => '{{WRAPPER}} .pp-password-protected-content-form .pp-password-form-submit:hover',
				'condition'             => [
					'protection_by'	=> 'password'
				]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();		

		$this->end_controls_section();
	}

	/** Check current user role exists inside of the roles array. **/
	protected function current_user_privileges() {
		$settings = $this->get_settings_for_display();
        
		if ( ! is_user_logged_in() ) return;

		$user_role = reset( wp_get_current_user()->roles );
        
        if ( !empty( $settings['user_roles'] ) ) {
            return in_array( $user_role, $settings['user_roles'] );
        } else {
            return false;
        }
	}

	protected function render_info_message() {
		$settings = $this->get_settings_for_display();
		ob_start();?>
		<div class="pp-protected-content-info-message">
			<?php 
				if ( 'none' == $settings['info_message_type'] ) {
					//nothing happen
				}
				elseif ( 'text' == $settings['info_message_type'] && $settings['info_message_text'] ) { ?>
                    <div class="pp-protected-content-info-message-text">
                        <?php echo $settings['info_message_text']; ?>
                    </div>
                    <?php
                }
                elseif ( $settings['info_message_type'] == 'section' && !empty( $settings['info_message_saved_section'] ) ) {

                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['info_message_saved_section'] );

                }
			?>
		</div>  
		<?php echo ob_get_clean();
	}

	protected function render_protected_content() {
		$settings = $this->get_settings_for_display();
		ob_start(); ?>
        <div class="pp-protected-content">
            <?php
                if ( 'content' === $settings['protected_content_type'] ) {
                    if ( ! empty( $settings['protected_content_text'] ) ) {
                        echo $settings['protected_content_text'];
                    }
                } elseif ( 'protected_image' == $settings['protected_content_type'] && $settings['protected_image']['url'] != '' ) {

                    echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'protected_image', 'protected_image' );

                } elseif ( 'protected_video' == $settings['protected_content_type'] ) {

                    echo $this->parse_text_editor( $settings['link_video'] );

                } elseif ( $settings['protected_content_type'] == 'section' && !empty( $settings['protected_saved_section'] ) ) {

                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['protected_saved_section'] );

                } elseif ( $settings['protected_content_type'] == 'template' && !empty( $settings['protected_templates'] ) ) {

                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['protected_templates'] );

                } elseif ( $settings['protected_content_type'] == 'widget' && !empty( $settings['protected_saved_widget'] ) ) {

                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['protected_saved_widget'] );

                }
             ?>
        </div>
		<?php echo ob_get_clean();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        ?>
		<?php if ( $settings['protection_by'] == 'role' ) { ?>
			<div class="pp-protected-content-wrap">     
				<?php
                    if ( true === $this->current_user_privileges() ) {
					   $this->render_protected_content();
                    } else {
                        $this->render_info_message();
                    }

                    if ( 'yes' == $settings['preview_info_message'] ) {
                        $this->render_info_message();
                    }
                ?>
			</div>
		<?php } else { ?>
            <?php
                if ( !empty( $settings['content_password'] ) ) {
					if ( ! session_status() ) { session_start(); }

                    if ( isset($_POST['protected_content_password'] ) && ( $settings['content_password'] === $_POST['protected_content_password'] ) ) {
                        $_SESSION['protected_content_password'] = true;
                    }
                    
                    if ( ! isset($_SESSION['protected_content_password'] ) ) {
						if ( 'yes' !== $settings['preview_content'] ) {
							$this->render_info_message(); 
							$this->get_password_form();
                        	return;
						}                    
                    }                    
                }
            ?>
			<div class="pp-protected-content-wrap">
				<?php $this->render_protected_content(); ?>
			</div>
            <?php
        }
	}
    
    protected function get_password_form() {
		$settings = $this->get_settings_for_display();
        ?>
        <div class="pp-password-protected-content-form">
            <form method="post">
                <input type="password" name="protected_content_password" class="pp-password-form-password" placeholder="<?php echo __( 'Enter Password', 'power-pack' ); ?>">
                <input type="submit" value="<?php echo __( 'Submit', 'power-pack' ); ?>" class="pp-password-form-submit">
            </form>
            <?php
                if ( isset( $_POST['protected_content_password'] ) && ( $settings['content_password'] !== $_POST['protected_content_password'] ) ) {
                    echo '<p class="pp-protected-content-error-message">' . __( 'Password does not match.', 'power-pack' ) . '</p>';
                }
            ?>
        </div>
        <?php
    }

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  
	 *  @return string
	 */
	public function get_page_template_options( $type = '' ) {

		$page_templates = pp_get_page_templates( $type );

		$options[-1]   = __( 'Select', 'power-pack' );

		if ( count( $page_templates ) ) {
			foreach ( $page_templates as $id => $name ) {
				$options[ $id ] = $name;
			}
		} else {
			$options['no_template'] = __( 'No saved templates found!', 'power-pack' );
		}

		return $options;
	}
}