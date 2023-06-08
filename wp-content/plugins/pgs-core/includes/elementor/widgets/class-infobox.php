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
class Infobox extends Widget_Controller {

	protected $widget_slug = 'infobox';

	protected $widget_icon = 'eicon-icon-box';

	protected $keywords = array( 'infobox' );

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
		return esc_html__( 'Info Box', 'pgs-core' );
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
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'pgs-core' ),
				'type'    => 'pgs_select_image',
				'default' => 'style-1',
				'options' => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/info_box/style_1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/info_box/style_2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/info_box/style_3.png',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/info_box/style_4.png',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/info_box/style_5.png',
					),
				),
			)
		);

		$this->add_control(
			'content_alignment',
			[
				'label'     => esc_html__( 'Content Alignment', 'pgs-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'pgs-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'pgs-core' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'pgs-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'center',
				'toggle'    => true,
				'condition' => [
					'layout' => 'style-1',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'pgs-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'pgs-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'pgs-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'left',
				'toggle'    => true,
				'condition' => [
					'layout' => 'style-2',
				],
			]
		);

		$this->add_control(
			'icon_disable',
			[
				'label'        => esc_html__( 'Disable Icon?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to disable icon.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Disable', 'pgs-core' ),
				'label_off'    => esc_html__( 'Enable', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'layout' => [ 'style-1', 'style-2', 'style-3' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_details',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'add_anchor',
			[
				'label'        => esc_html__( 'Add link to title?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to disable icon.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'anchor_link',
			[
				'label'         => esc_html__( 'Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enter title link.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'add_anchor' => 'true',
				],
			]
		);

		$this->add_control(
			'title_el',
			array(
				'label'       => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select title element tag.', 'pgs-core' ),
				'default'     => 'h3',
				'options'     => array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				),
			)
		);

		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#323232',
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-title, {{WRAPPER}} .pgscore_info_box-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter description. Please ensure to add short content.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'       => esc_html__( 'Description Color', 'pgs-core' ),
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'selectors'   => [
					'{{WRAPPER}} .pgscore_infobox_wrapper .pgscore_info_box-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_step',
			array(
				'label'     => esc_html__( 'Step', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout!' => 'style-1',
				],
			)
		);

		$this->add_control(
			'enable_step',
			[
				'label'        => esc_html__( 'Enable Step?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'select this checkbox to enable step.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'layout' => [ 'style-2', 'style-3' ],
				],
			]
		);

		$this->add_control(
			'step',
			array(
				'label'       => esc_html__( 'Step', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select step number.', 'pgs-core' ),
				'options'     => pgscore_info_box_steps_number(true),
				'condition'   => [
					'layout'      => [ 'style-2', 'style-3' ],
					'enable_step' => 'true',
				],
			)
		);

		$this->add_control(
			'step_4_5',
			array(
				'label'       => esc_html__( 'Step', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select step number.', 'pgs-core' ),
				'options'     => pgscore_info_box_steps_number(true),
				'condition'   => [
					'layout' => [ 'style-4', 'style-5' ],
				],
			)
		);

		$this->add_control(
			'step_tag',
			array(
				'label'       => esc_html__( 'Step Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select step element tag.', 'pgs-core' ),
				'options'     => array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				),
				'default'     => 'h2',
				'condition'   => [
					'layout' => [ 'style-4', 'style-5' ],
				],
			)
		);

		$this->add_control(
			'style_2_step_position',
			array(
				'label'      => esc_html__( 'Step Position', 'pgs-core' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => array(
					'above_title'   => esc_html__( 'Above Title', 'pgs-core' ),
					'under_icon'    => esc_html__( 'Under Icon', 'pgs-core' ),
					'opposite_icon' => esc_html__( 'Oposite Icon', 'pgs-core' ),
				),
				'default'    => 'above_title',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'layout',
							'value' => 'style-2',
						],
						[
							'name'  => 'enable_step',
							'value' => 'true',
						],
					],
				],
			)
		);

		$this->add_control(
			'style_23_color',
			[
				'label'       => esc_html__( 'Step Color', 'pgs-core' ),
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'condition'   => [
					'layout' => [ 'style-2', 'style-3' ],
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_infobox_wrapper .pgscore_info_box-layout-style-2 .pgscore_info_box-step' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pgscore_infobox_wrapper .pgscore_info_box-layout-style-3 .pgscore_info_box-step' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_4_step_color',
			[
				'label'       => esc_html__( 'Step Color', 'pgs-core' ),
				'description' => esc_html__( 'Select step color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#323232',
				'condition'   => [
					'layout' => 'style-4',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-step' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style_5_step_color',
			[
				'label'       => esc_html__( 'Step Color', 'pgs-core' ),
				'description' => esc_html__( 'Select step color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#323232',
				'condition'   => [
					'layout' => 'style-5',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-step' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_icon',
			array(
				'label'      => esc_html__( 'Icon', 'pgs-core' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'icon_disable',
							'operator' => '!==',
							'value'    => 'yes',
						],
						[
							'name'     => 'layout',
							'operator' => '!in',
							'value'    => [
								'style-4',
								'style-5',
							],
						],
					],
				],
			)
		);

		$this->add_control(
			'icon_style',
			array(
				'label'     => esc_html__( 'Icon Style', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'flat'    => esc_html__( 'Flat', 'pgs-core' ),
					'border'  => esc_html__( 'Border', 'pgs-core' ),
				),
				'default'   => 'default',
				'condition' => [
					'icon_disable!' => 'yes',
				],
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select icon size.', 'pgs-core' ),
				'options'     => array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
					'custom' => esc_html__( 'Custom', 'pgs-core' ),
				),
				'default'     => 'md',
				'condition'   => [
					'icon_disable!' => 'yes',
				],
			)
		);

		$this->add_responsive_control(
			'icon_custom_size',[
				'label' => __( 'Custom Size', 'pgs-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'condition'   => [
					'icon_size' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .pgscore_infobox_wrapper .pgscore_info_box-icon-size-custom .pgscore_info_box-icon-inner i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pgscore_infobox_wrapper .pgscore_info_box-icon-size-custom .pgscore_info_box-icon-inner img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_shape',
			array(
				'label'       => esc_html__( 'Icon Shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select icon shape.', 'pgs-core' ),
				'options'     => array(
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
				),
				'default'     => 'square',
				'condition'   => [
					'icon_style' => [ 'flat', 'border' ],
				],
			)
		);

		$this->add_control(
			'icon_background_color',
			[
				'label'       => esc_html__( 'Background Color', 'pgs-core' ),
				'description' => esc_html__( 'Select icon background color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#ccc',
				'condition'   => [
					'icon_style' => 'flat',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label'       => esc_html__( 'Border Color', 'pgs-core' ),
				'description' => esc_html__( 'Select border color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#ccc',
				'condition'   => [
					'icon_style' => 'border',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_width',
			[
				'label'       => esc_html__( 'Border Width', 'pgs-core' ),
				'description' => esc_html__( 'Enter/select border width.', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 10,
				'step'        => 1,
				'default'     => 5,
				'condition'   => [
					'icon_style' => 'border',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-inner' => 'border-width: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'icon_border_style',
			array(
				'label'       => esc_html__( 'Border Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select border style.', 'pgs-core' ),
				'options'     => array(
					''       => esc_html__( 'Theme defaults', 'pgs-core' ),
					'solid'  => esc_html__( 'Solid', 'pgs-core' ),
					'dotted' => esc_html__( 'Dotted', 'pgs-core' ),
					'dashed' => esc_html__( 'Dashed', 'pgs-core' ),
					'double' => esc_html__( 'Double', 'pgs-core' ),
					'groove' => esc_html__( 'Groove', 'pgs-core' ),
					'ridge'  => esc_html__( 'Ridge', 'pgs-core' ),
				),
				'default'     => '',
				'condition'   => [
					'icon_style' => 'border',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-inner' => 'border-style: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'icon_enable_outer_border',
			[
				'label'        => esc_html__( 'Enable Outer Border', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to enable outer border.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'icon_style' => [ 'flat', 'border' ],
				],
			]
		);

		$this->add_control(
			'icon_outer_border_color',
			[
				'label'       => esc_html__( 'Outer Border Color', 'pgs-core' ),
				'description' => esc_html__( 'Select border color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#ccc',
				'condition'   => [
					'icon_enable_outer_border' => 'true',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-outer' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_outer_border_width',
			[
				'label'       => esc_html__( 'Outer Border Width', 'pgs-core' ),
				'description' => esc_html__( 'Enter/select border width.', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 10,
				'step'        => 1,
				'default'     => 5,
				'condition'   => [
					'icon_enable_outer_border' => 'true',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-outer' => 'border-width: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'icon_outer_border_style',
			array(
				'label'       => esc_html__( 'Outer Border Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select border style.', 'pgs-core' ),
				'options'     => array(
					''       => esc_html__( 'Theme defaults', 'pgs-core' ),
					'solid'  => esc_html__( 'Solid', 'pgs-core' ),
					'dotted' => esc_html__( 'Dotted', 'pgs-core' ),
					'dashed' => esc_html__( 'Dashed', 'pgs-core' ),
					'double' => esc_html__( 'Double', 'pgs-core' ),
					'groove' => esc_html__( 'Groove', 'pgs-core' ),
					'ridge'  => esc_html__( 'Ridge', 'pgs-core' ),
				),
				'default'     => '',
				'condition'   => [
					'icon_enable_outer_border' => 'true',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-outer' => 'border-style: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'icon_source',
			array(
				'label'     => esc_html__( 'Icon Source', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'font'  => esc_html__( 'Font', 'pgs-core' ),
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				),
				'default'   => 'font',
				'condition' => [
					'icon_disable!' => 'true',
				],
			)
		);

		$this->add_control(
			'icon_image',
			[
				'label'       => esc_html__( 'Icon Image', 'pgs-core' ),
				'description' => esc_html__( 'Upload/select icon image.', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'condition'   => [
					'icon_source' => 'image',
				],
			]
		);

		$this->add_control(
			'image_link',
			[
				'label'         => esc_html__( 'Image Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'icon_source' => 'link',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'pgs-core' ),
				'description' => esc_html__( 'Select icon color.', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#323232',
				'condition'   => [
					'icon_source' => 'font',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_info_box-icon-inner i' => 'color: {{VALUE}};',
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
					'icon_source' => 'font',
				],
			]
		);

		$this->end_controls_section();
	}
}
