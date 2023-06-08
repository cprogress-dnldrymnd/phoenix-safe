<?php
/**
 * Banner class.
 *
 * @package pgs-core/elementor
 * @since   5.0.0
 */

namespace PGSCore_Elementor\Widgets;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

use PGSCore_Elementor\Widget_Controller\Widget_Controller;
use PGSCore_Elementor\Group_Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor banner widget.
 *
 * Elementor widget that displays an banner.
 *
 * @since 5.0.0
 */
class Button extends Widget_Controller {

	protected $widget_slug = 'button';

	protected $widget_icon = 'eicon-button';

	protected $keywords = array( 'button' );

	/**
	 * Retrieve the widget title.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Button', 'pgs-core' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'button_type',
			array(
				'label'       => esc_html__( 'Button Type', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select Button Type.', 'pgs-core' ),
				'default'     => 'default',
				'options'     => array(
					'default' => array(
						'label' => esc_html__( 'Default', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/button/default-btn.jpg',
					),
					'border'  => array(
						'label' => esc_html__( 'Border', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/button/border-btn.jpg',
					),
					'link'    => array(
						'label' => esc_html__( 'Link', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/button/link.jpg',
					),
				),
			)
		);
		
		$this->add_control(
			'button_title',
			[
				'label'       => esc_html__( 'Button Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter button title.', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'button_link',
			[
				'label'         => esc_html__( 'Button Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enter button link.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		
		$this->add_control(
			'use_typography',
			[
				'label'        => esc_html__( 'Use typography ?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to use google fonts.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'content_typography',
				'label'     => esc_html__( 'Typography', 'pgs-core' ),
				'selector'  => '{{WRAPPER}} a.inline_hover',
				'condition' => array(
					'use_typography' => 'yes',
				),
			]
		);
		
		$this->add_control(
			'button_underline',
			[
				'label'        => esc_html__( 'Button Underline', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add link on banner.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => array(
					'button_type' => 'link',
				),
			]
		);
		
		$this->add_control(
			'button_border',
			[
				'label'       => esc_html__( 'Border Shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'square',
				'description' => esc_html__( 'Select Border Shape.', 'pgs-core' ),
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				],
				'condition'   => array(
					'button_type' => [ 'default', 'border' ],
				),
			]
		);
		
		$this->add_control(
			'button_width',
			[
				'label'       => esc_html__( 'Button Width', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select Button Width.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'full'    => esc_html__( 'Full', 'pgs-core' ),
				],
				'condition'   => array(
					'button_type' => [ 'default', 'border' ],
				),
			]
		);
		
		$this->add_control(
			'button_size',
			[
				'label'       => esc_html__( 'Button Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'medium',
				'description' => esc_html__( 'Select Button Size.', 'pgs-core' ),
				'options'     => [
					'small'  => esc_html__( 'Small', 'pgs-core' ),
					'medium' => esc_html__( 'Medium', 'pgs-core' ),
					'large'  => esc_html__( 'Large', 'pgs-core' ),
					'extra'  => esc_html__( 'Extra Large', 'pgs-core' ),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_colors',
			array(
				'label' => esc_html__( 'Custom Color', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->start_controls_tabs( 'tabs_button_colors' );
		
		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'button_background_color',
			[
				'label'       => esc_html__( 'Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Background Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover' => 'background: {{VALUE}} none repeat scroll 0% 0%;',
				],
				'condition'   => array(
					'button_type' => 'default',
				),
			]
		);
		
		$this->add_control(
			'button_text_color',
			[
				'label'       => esc_html__( 'Text Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#ffffff',
				'description' => esc_html__( 'Select Button Text color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'       => esc_html__( 'Border Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Border Color.', 'pgs-core' ),
				'condition'   => array(
					'button_type' => 'border',
				),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'button_background_hover_color',
			[
				'label'       => esc_html__( 'Background Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Background Hover Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover:hover' => 'background: {{VALUE}} none repeat scroll 0% 0%;',
				],
				'condition'   => array(
					'button_type' => 'default',
				),
			]
		);
		
		$this->add_control(
			'button_text_hover_color',
			[
				'label'       => esc_html__( 'Text Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#ffffff',
				'description' => esc_html__( 'Select Button Hover Text color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'button_border_hover_color',
			[
				'label'       => esc_html__( 'Border Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Border Hover Color.', 'pgs-core' ),
				'condition'   => array(
					'button_type' => 'border',
				),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'button_border_background_color',
			[
				'label'       => esc_html__( 'Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select background Color.', 'pgs-core' ),
				'condition'   => array(
					'button_type' => 'border',
				),
				'selectors'   => [
					'{{WRAPPER}} .pgscore_banner-btn' => 'background: {{VALUE}} none repeat scroll 0% 0%;',
					'{{WRAPPER}} .pgscore_button_border .inline_hover:hover' => 'background: {{VALUE}} none repeat scroll 0% 0%;',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_icon',
			array(
				'label' => esc_html__( 'Icon', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'button_icon',
			[
				'label'        => esc_html__( 'Icon', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'button_icon_position',
			[
				'label'       => esc_html__( 'Icon Position', 'pgs-core' ),
				'description' => esc_html__( 'Select Icon Position.', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'  => [
						'title' => esc_html__( 'Left', 'pgs-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pgs-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'     => 'left',
				'toggle'      => true,
				'condition'   => [
					'button_icon' => 'true',
				],
			]
		);
		
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'pgs-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'button_icon' => 'true',
				],
			]
		);

		$this->end_controls_section();
	}
}
