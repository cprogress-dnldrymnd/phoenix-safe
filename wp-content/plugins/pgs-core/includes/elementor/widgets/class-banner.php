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
use Elementor\Group_Control_Typography;

// use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

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
class Banner extends Widget_Controller {

	protected $widget_slug = 'banner';

	protected $widget_icon = 'eicon-single-post';

	protected $keywords = array( 'banner', 'info' );

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
		return esc_html__( 'Banner', 'pgs-core' );
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

		// Content Tab.
		$this->register_controls_content__layout();
		$this->register_controls_content__list_items();
		$this->register_controls_content__button();
		$this->register_controls_content__badge();
		$this->register_controls_content__deal();

		// Style Tab.
		$this->register_controls_style__banner();
	}

	protected function register_controls_content__layout() {

		$this->start_controls_section(
			'section_content_layout',
			array(
				'label' => esc_html__( 'Layout', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => '',
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/style-1.png',
					),
					'deal-1'  => array(
						'label' => esc_html__( 'Deal 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal-1.png',
					),
					'deal-2'  => array(
						'label' => esc_html__( 'Deal 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal-2.png',
					),
				),
			)
		);

		$this->add_control(
			'bg_img_source',
			[
				'label'       => esc_html__( 'Image source', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Select image source.', 'pgs-core' ),
				'default'     => 'media_library',
				'options'     => [
					'media_library' => [
						'title' => esc_html__( 'Media library', 'pgs-core' ),
						'icon'  => 'eicon-image',
					],
					'external_link' => [
						'title' => esc_html__( 'External link', 'pgs-core' ),
						'icon'  => 'eicon-link',
					],
				],
			]
		);

		$this->add_control(
			'bg_img',
			[
				'label'      => __( 'Banner Image', 'pgs-core' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => [
					'active' => false,
				],
				'default'    => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'bg_img_source',
							'value' => 'media_library',
						],
						[
							'name'     => 'bg_img_source',
							'operator' => '==',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'bg_img_link',
			[
				'label'         => esc_html__( 'Banner Image', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://banner-image-link.com', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'bg_img_source' => 'external_link',
				],
			]
		);

		$this->add_control(
			'vertical_align',
			array(
				'label'       => esc_html__( 'Vertical Align', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Set banner text vertical position.', 'pgs-core' ),
				'default'     => 'vtop',
				'options'     => array(
					'vtop'    => array(
						'title' => esc_html__( 'Top', 'pgs-core' ),
						'icon'  => 'eicon-v-align-top',
					),
					'vmiddle' => array(
						'title' => esc_html__( 'Middle', 'pgs-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'vbottom' => array(
						'title' => esc_html__( 'Middle', 'pgs-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'condition'   => array(
					'style' => array( 'style-1', 'deal-1' ),
				),
			)
		);

		$this->add_control(
			'horizontal_align',
			array(
				'label'       => esc_html__( 'Horizontal Align', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Set banner text horizontal position', 'pgs-core' ),
				'default'     => 'hleft',
				'options'     => array(
					'hleft'   => array(
						'title' => esc_html__( 'Left', 'pgs-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'hcenter' => array(
						'title' => esc_html__( 'Center', 'pgs-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					'hright'  => array(
						'title' => esc_html__( 'Right', 'pgs-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'condition'   => array(
					'style' => array( 'style-1', 'deal-1' ),
				),
			)
		);

		$this->add_control(
			'banner_effect',
			array(
				'label'       => esc_html__( 'Effect', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select banner effect type.', 'pgs-core' ),
				'default'     => 'none',
				'options'     => array(
					'none'   => esc_html__( 'None', 'pgs-core' ),
					'border' => esc_html__( 'Border', 'pgs-core' ),
					'flash'  => esc_html__( 'Flash', 'pgs-core' ),
					'zoom'   => esc_html__( 'Zoom', 'pgs-core' ),
				),
			)
		);

		$this->add_responsive_control(
			'banner_css',
			array(
				'label'      => esc_html__( 'Padding', 'pgs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pgscore_banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'banner_link_enable',
			[
				'label'        => esc_html__( 'Enable Banner Link?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add link on banner.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'banner_enable_button',
			[
				'label'        => esc_html__( 'Enable Button?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'banner_link_enable!' => 'yes',
				],
			]
		);

		$this->add_control(
			'banner_link_url',
			[
				'label'         => esc_html__( 'Banner Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'pgs-core' ),
				'description'   => esc_html__( 'Add custom link on banner.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [
					'banner_link_enable' => 'yes',
				],
				'separator'     => 'after',
			]
		);

		$this->add_control(
			'banner_enable_badge',
			[
				'label'        => esc_html__( 'Enable Badge?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add badge on banner.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'style' => 'style-1',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function register_controls_content__button() {

		// TODO: Add icon.

		$this->start_controls_section(
			'section_content_button',
			array(
				'label'     => esc_html__( 'Button', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'banner_link_enable!'  => 'yes',
					'banner_enable_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Click here', 'pgs-core' ),
				'placeholder' => __( 'Click here', 'pgs-core' ),
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'   => __( 'Style', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'link',
				'options' => [
					'link'   => esc_html__( 'Link', 'pgs-core' ),
					'flat'   => esc_html__( 'Flat', 'pgs-core' ),
					'border' => esc_html__( 'Border', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'link_url',
			[
				'label'       => __( 'Link', 'pgs-core' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'pgs-core' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'   => __( 'Size', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
				),
			]
		);

		/* Button Style */
		$this->add_control(
			'button_formatting_heading',
			[
				'label'     => __( 'Button Formatting', 'pgs-core' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'global'   => [
					'default' => '',
				],
				'selector' => '{{WRAPPER}} .pgscore_banner .pgscore_banner-content .pgscore_banner-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'button_text_shadow',
				'selector' => '{{WRAPPER}} .pgscore_banner-btn',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

			$this->start_controls_tab(
				'tab_button_normal',
				[
					'label' => __( 'Normal', 'pgs-core' ),
				]
			);

				$this->add_control(
					'button_text_color',
					[
						'label'     => __( 'Text Color', 'pgs-core' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .pgscore_banner-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'button_background_color',
					[
						'label'     => __( 'Background Color', 'pgs-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pgscore_banner-btn' => 'background-color: {{VALUE}};',
						],
						'condition' => array(
							'button_style' => 'flat',
						),
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
					'button_text_hover_color',
					[
						'label'     => __( 'Text Color', 'pgs-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pgscore_banner-btn:hover, {{WRAPPER}} .pgscore_banner-btn:focus' => 'color: {{VALUE}};',
							'{{WRAPPER}} .pgscore_banner-btn:hover svg, {{WRAPPER}} .pgscore_banner-btn:focus svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'button_background_hover_color',
					[
						'label'     => __( 'Background Color', 'pgs-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pgscore_banner-btn:hover, {{WRAPPER}} .pgscore_banner-btn:focus' => 'background-color: {{VALUE}};',
						],
						'condition' => array(
							'button_style' => 'flat',
						),
					]
				);

				$this->add_control(
					'button_hover_border_color',
					[
						'label'     => __( 'Border Color', 'pgs-core' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => [
							'button_border_border!' => '',
							'button_style!'         => 'link',
						],
						'selectors' => [
							'{{WRAPPER}} .pgscore_banner-btn:hover, {{WRAPPER}} .pgscore_banner-btn:focus' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'hover_animation',
					[
						'label' => __( 'Hover Animation', 'pgs-core' ),
						'type'  => Controls_Manager::HOVER_ANIMATION,
					]
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .pgscore_banner-btn',
				'separator' => 'before',
				'condition' => [
					'button_style!' => 'link',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'pgs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pgscore_banner-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_style!' => 'link',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .pgscore_banner-btn',
				'condition' => array(
					'button_style!' => 'link',
				),
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[
				'label'      => __( 'Padding', 'pgs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pgscore_banner .pgscore_banner-content .pgscore_banner-btn-wrap.pgscore_banner-btn-size-lg .pgscore_banner-btn, {{WRAPPER}} .pgscore_banner .pgscore_banner-content .pgscore_banner-btn-wrap.pgscore_banner-btn-size-md .pgscore_banner-btn, {{WRAPPER}} .pgscore_banner .pgscore_banner-content .pgscore_banner-btn-wrap.pgscore_banner-btn-size-sm .pgscore_banner-btn, {{WRAPPER}} .pgscore_banner .pgscore_banner-content .pgscore_banner-btn-wrap.pgscore_banner-btn-size-xs .pgscore_banner-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => array(
					'button_style!' => 'link',
				),
			]
		);

		$this->end_controls_section();
	}


	protected function register_controls_content__badge() {

		$this->start_controls_section(
			'section_content_badge',
			array(
				'label'     => esc_html__( 'Badge', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'banner_enable_badge' => 'yes',
					'style'               => 'style-1',
				),
			)
		);

		$this->add_control(
			'badge_style',
			[
				'label'   => __( 'Badge Style', 'pgs-core' ),
				'type'    => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'style-1',
			]
		);

		$this->add_control(
			'badge_title',
			[
				'label'   => esc_html__( 'Title', 'pgs-core' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Lorem Ipsum', 'pgs-core' ),
			]
		);

		$this->add_control(
			'badge_type',
			[
				'label'   => esc_html__( 'Style', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'border',
				'options' => [
					'border' => esc_html__( 'Border', 'pgs-core' ),
					'flat'   => esc_html__( 'Flat', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'badge_vertical_align',
			array(
				'label'       => esc_html__( 'Vertical Align', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Set badge vertical position.', 'pgs-core' ),
				'default'     => 'vbottom',
				'options'     => array(
					'vtop'    => array(
						'title' => esc_html__( 'Top', 'pgs-core' ),
						'icon'  => 'eicon-v-align-top',
					),
					'vmiddle' => array(
						'title' => esc_html__( 'Middle', 'pgs-core' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'vbottom' => array(
						'title' => esc_html__( 'Middle', 'pgs-core' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
			)
		);

		$this->add_control(
			'badge_horizontal_align',
			array(
				'label'       => esc_html__( 'Horizontal Align', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Set badge horizontal position', 'pgs-core' ),
				'default'     => 'hright',
				'options'     => array(
					'hleft'   => array(
						'title' => esc_html__( 'Left', 'pgs-core' ),
						'icon'  => 'eicon-h-align-left',
					),
					'hcenter' => array(
						'title' => esc_html__( 'Center', 'pgs-core' ),
						'icon'  => 'eicon-h-align-center',
					),
					'hright'  => array(
						'title' => esc_html__( 'Right', 'pgs-core' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
			)
		);

		$this->add_control(
			'badge_width',
			[
				'label'      => __( 'Width', 'pgs-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 70,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_height',
			[
				'label'      => __( 'Height', 'pgs-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 70,
					'unit' => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		/* Badge Style */
		$this->add_control(
			'badge_formatting_heading',
			[
				'label'     => __( 'Badge Formatting', 'pgs-core' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => __( 'Text Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#323232',
				'selectors' => [
					'{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background_color',
			[
				'label'     => __( 'Background Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge' => 'background-color: {{VALUE}};',
				],
				'condition' => array(
					'badge_type' => 'flat',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_text_typography',
				'label'    => __( 'Text Typography', 'pgs-core' ),
				'global'   => [
					'default' => '',
				],
				'selector' => '{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge .pgscore_banner-badge-text',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'badge_text_shadow',
				'selector' => '{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'badge_border',
				'selector'  => '{{WRAPPER}} .pgscore_banner-badge-wrap .pgscore_banner-badge',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls_content__deal() {

		$this->start_controls_section(
			'section_content_deal',
			array(
				'label'     => esc_html__( 'Deal', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'style' => array( 'deal-1', 'deal-2' ),
				),
			)
		);

		$this->add_control(
			'deal_counter_style',
			array(
				'label'       => esc_html__( 'Counter Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => '',
				'default'     => 'style-1',
				'options'     => array(
					'style-1'  => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_1.jpg',
					),
					'style-2'  => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_2.jpg',
					),
					'style-3'  => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_3.jpg',
					),
					'style-4'  => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_4.jpg',
					),
					'style-5'  => array(
						'label' => esc_html__( 'Style 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_5.jpg',
					),
					'style-6'  => array(
						'label' => esc_html__( 'Style 6', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_6.jpg',
					),
					'style-7'  => array(
						'label' => esc_html__( 'Style 7', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_7.jpg',
					),
					'style-8'  => array(
						'label' => esc_html__( 'Style 8', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_8.jpg',
					),
					'style-9'  => array(
						'label' => esc_html__( 'Style 9', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_9.jpg',
					),
					'style-10' => array(
						'label' => esc_html__( 'Style 10', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_10.jpg',
					),
				),
				'condition'   => array(
					'style' => 'deal-1',
				),
			)
		);

		$this->add_control(
			'deal_date',
			[
				'label' => esc_html__( 'Deal Date', 'pgs-core' ),
				'type'  => \Elementor\Controls_Manager::DATE_TIME,
			]
		);

		$this->add_control(
			'deal_color_scheme',
			array(
				'label'       => esc_html__( 'Countdown Color Scheme', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Slect countdown color scheme.', 'pgs-core' ),
				'default'     => 'dark',
				'options'     => array(
					'dark'  => esc_html__( 'Dark', 'pgs-core' ),
					'light' => esc_html__( 'Light', 'pgs-core' ),
				),
			)
		);

		$this->add_control(
			'deal_expire_message',
			[
				'label'       => esc_html__( 'Expire Message', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This offer has expired.', 'pgs-core' ),
				'description' => esc_html__( 'Enter message to display, instead of date counter, when deal is expired.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'deal_counter_size',
			[
				'label'     => esc_html__( 'Counter Size', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'sm',
				'options'   => array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
				),
				'condition' => array(
					'style' => array( 'deal-2' ),
				),
			]
		);

		$this->add_responsive_control(
			'deal_padding',
			array(
				'label'      => esc_html__( 'Deal Padding', 'pgs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .deal-counter-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'deal_on_expire_btn',
			[
				'label'       => esc_html__( 'On Expire Button?', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select status of button on deal expire.', 'pgs-core' ),
				'default'     => 'disable',
				'options'     => array(
					'disable' => esc_html__( 'Disable', 'pgs-core' ),
					'remove'  => esc_html__( 'Remove', 'pgs-core' ),
				),
			]
		);


		$this->end_controls_section();
	}

	protected function register_controls_content__list_items() {
		$this->start_controls_section(
			'section_content_list_items',
			array(
				'label' => esc_html__( 'List Items', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lorem Ipsum', 'pgs-core' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'color',
			[
				'label'     => esc_html__( 'Text Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .pgscore_banner-text' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'bg_color',
			[
				'label'     => __( 'Text Background Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .pgscore_banner-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_group_control(
			Group_Controls\PGS_Typography::get_type(),
			array(
				'name'     => 'item_typography',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .pgscore_banner-text',
				'default'  => array(
					'font_size' => array(
						'desktop_default' => [
							'size' => '81',
						],
						'tablet_default'  => [
							'size' => '61',
						],
						'mobile_default'  => [
							'size' => '51',
						],
					),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .pgscore_banner-text',
			]
		);

		$repeater->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'pgs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .pgscore_banner-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$repeater->add_responsive_control(
			'item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'pgs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .pgscore_banner-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'list_items',
			array(
				'label'       => esc_html__( 'List Items', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title' => esc_html__( 'Lorem Ipsum', 'pgs-core' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}

	protected function register_controls_style__banner() {
		$this->start_controls_section(
			'section_style_banner',
			array(
				'label' => esc_html__( 'Banner', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->end_controls_section();
	}

	protected function register_controls_style__button() {

		$this->start_controls_section(
			'section_style_button',
			array(
				'label'     => esc_html__( 'Button (Style)', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'banner_link_enable!' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	public function is_banner_link_enabled() {
		$settings = $this->get_settings_for_display();

		$banner_link_enabled = ( ( isset( $settings['banner_link_enable'] ) && 'yes' === $settings['banner_link_enable'] ) && ( isset( $settings['banner_link_url'] ) && is_array( $settings['banner_link_url'] ) && isset( $settings['banner_link_url']['url'] ) && $settings['banner_link_url']['url'] ) );

		return $banner_link_enabled;
	}

	public function is_button_enabled() {
		$settings = $this->get_settings_for_display();

		$banner_link_enabled = (
			( isset( $settings['banner_link_enable'] ) && 'yes' !== $settings['banner_link_enable'] )
			&& ( isset( $settings['banner_enable_button'] ) && 'yes' === $settings['banner_enable_button'] )
			&& ( isset( $settings['link_url'] ) && is_array( $settings['link_url'] ) && isset( $settings['link_url']['url'] ) && $settings['link_url']['url'] )
		);

		return $banner_link_enabled;
	}
}
