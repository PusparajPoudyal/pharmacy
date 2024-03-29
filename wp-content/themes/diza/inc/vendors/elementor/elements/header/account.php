<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Account') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Border;
use Elementor\Controls_Manager;

class Diza_Elementor_Account extends Diza_Elementor_Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'tbay-account';
    }

    public function get_title() {
        return esc_html__('Diza Account', 'diza');
    }

    public function get_icon() {
        return 'eicon-user-circle-o';
    }

    protected function get_html_wrapper_class() {
		return 'w-auto elementor-widget-' . $this->get_name();
    }
    
    public function get_keywords() {
        return ['account', 'login'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Account', 'diza'),
            ]
        );

        $this->add_control(
            'icon_account',
            [
                'label'              => esc_html__('Icon', 'diza'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-account',
					'library' => 'tbay-custom',
                ],                
            ]
        );
        
        $this->add_control(
            'show_text_account',
            [
                'label'              => esc_html__('Display Text Account', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'        
            ]
        );
        $this->add_control(
            'show_sub_account',
            [
                'label'              => esc_html__('Display Sub Menu', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'sub_menu_account',
                [
                    'label'        => esc_html__('Choose Menu', 'diza'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'condition'    => [
                        'show_sub_account'  => 'yes'
                    ],
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'diza'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $this->add_control(
                'sub_menu_account',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'diza'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->add_control(
            'show_popup_login',
            [
                'label'              => esc_html__('Display Popup Login', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
        $this->register_section_style_popup();
    }
    protected function register_section_style_icon() {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_account_size',
            [
                'label' => esc_html__('Font Size', 'diza'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tbay-login a i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'padding_icon_account',
            [
                'label'     => esc_html__('Padding Icon Account', 'diza'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-login a i, {{WRAPPER}} .tbay-login a svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );   
        $this->start_controls_tabs('tabs_style_icon');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'diza'),
            ]
        );
        $this->add_control(
            'color_icon',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-login a i'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tbay-login a svg'     => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-login a i, {{WRAPPER}} .tbay-login a svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'diza'),
            ]
        );
        $this->add_control(
            'hover_color_icon',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-login a i:hover'         => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tbay-login a svg:hover'       => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-login a i:hover, {{WRAPPER}} .tbay-login a svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_section_style_text() {

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Text', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_text_account' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'text_account_size',
            [
                'label' => esc_html__('Font Size', 'diza'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tbay-login > a span' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'text_account_line_height',
            [
                'label' => esc_html__('Line Height', 'diza'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tbay-login > a span' => 'line-height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_style_text');

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => esc_html__('Normal', 'diza'),
            ]
        );
        $this->add_control(
            'color_text',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-account'    => 'color: {{VALUE}}',
                ],
            ]
        );   

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => esc_html__('Hover', 'diza'),
            ]
        );
        $this->add_control(
            'hover_color_text',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-account:hover' => 'color: {{VALUE}}',
                ],
            ]
        );   
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_section_style_popup() {

        $this->start_controls_section(
            'section_style_popup',
            [
                'label' => esc_html__('Style Popup', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_popup_login' => 'yes',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_popup',
				'selector' => '{{WRAPPER}} .tbay-login .account-menu',
			]
        );
        $this->add_control(
            'border_radius_popup',
            [
                'label'     => esc_html__('Border Radius', 'diza'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                
                    '{{WRAPPER}} .tbay-login .account-menu ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'position_popup',
            [
                'label' => esc_html__('Position Popup', 'diza'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 62,
                ],
                'size_units' => [ 'px' ,'%'],
                'selectors' => [
                    '{{WRAPPER}} .tbay-login .account-menu'=> 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        
        $this->end_controls_section();
    }

    protected function is_user_logged_in() {
		$user = wp_get_current_user();

		return $user->exists();
    }
    
    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    public function check_login($show_text_account) {
        if(is_user_logged_in()) {
            $current_user 	= wp_get_current_user(); 
            $name = $current_user->display_name;
            $name = esc_html__('Hi,','diza').' '.$name;
        }
        else {
            $name = esc_html__('Login Or Register','diza');
        }

        if ($show_text_account === 'yes') {
            ?><span class="text-account"> <?php echo trim($name); ?> </span><?php
        }
    }
    public function render_item_account() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        // $name = '';
        $this->render_item_icon($icon_account);
        $this->check_login($show_text_account);
    }
    
    public function render_sub_menu() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $args = [
            'menu'        => $sub_menu_account,
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id()
        ];
        $menu_html = wp_nav_menu($args);
        echo trim($menu_html);
    }
}
$widgets_manager->register_widget_type(new Diza_Elementor_Account());

