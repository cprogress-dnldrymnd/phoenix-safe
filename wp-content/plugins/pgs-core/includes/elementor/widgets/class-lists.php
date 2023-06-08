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
class Lists extends Widget_Controller {

	protected $widget_slug = 'lists';

	protected $widget_icon = 'eicon-editor-list-ul';

	protected $keywords = array( 'list' );

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
		return esc_html__( 'Lists', 'pgs-core' );
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
		global $ciyashop_options;
		
		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'list_element_tag',
			[
				'label'       => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'p',
				'description' => esc_html__( 'Select Title Element Tag.', 'pgs-core' ),
				'options'     => [
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
					'p'  => esc_html__( 'P', 'pgs-core' ),
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'list_content_typography',
				'label'    => esc_html__( 'Typography', 'pgs-core' ),
				'selector' => '{{WRAPPER}} .pgscore_list li .pgscore-list-info',
			]
		);
		
		$this->add_control(
			'list_title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select Title color.', 'pgs-core' ),
				'default'     => '#969696',
				'selectors'   => [
					'{{WRAPPER}} ul.pgscore_list li .pgscore-list-info' => 'color:{{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'list_title_hover_color',
			[
				'label'       => esc_html__( 'Title Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select Title Hover Color, Working, if you have add list item content link.', 'pgs-core' ),
				'default'     => isset( $ciyashop_options['primary_color'] ) ? $ciyashop_options['primary_color'] : '#04d39f',
				'selectors'   => [
					'{{WRAPPER}} ul.pgscore_list li .pgscore-list-info:hover' => 'color:{{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_icon',
			array(
				'label' => esc_html__( 'Icon', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'add_icon',
			[
				'label'        => esc_html__( 'Add Icon?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'icon',
			[
				'label'     => __( 'Icon', 'pgs-core' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'add_icon' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'list_style_type',
			[
				'label'       => esc_html__( 'Icon list type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'description' => esc_html__( 'Select Icon List Type.', 'pgs-core' ),
				'options'     => [
					'none'        => esc_html__( 'None', 'pgs-core' ),
					'circle'      => esc_html__( 'Circle', 'pgs-core' ),
					'decimal'     => esc_html__( 'Decimal', 'pgs-core' ),
					'disc'        => esc_html__( 'Disc', 'pgs-core' ),
					'square'      => esc_html__( 'Square', 'pgs-core' ),
					'lower-alpha' => esc_html__( 'Lower Alpha', 'pgs-core' ),
					'lower-roman' => esc_html__( 'Lower Roman', 'pgs-core' ),
				],
				'condition'   => [
					'add_icon!' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'icon_style_type',
			[
				'label'       => esc_html__( 'Icon style type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select Icon style Type.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'border'  => esc_html__( 'Border', 'pgs-core' ),
					'flat'    => esc_html__( 'Flat', 'pgs-core' ),
				],
				'condition'   => [
					'add_icon' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'icon_shape',
			[
				'label'       => esc_html__( 'Icon shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'square',
				'description' => esc_html__( 'Select Icon Shape.', 'pgs-core' ),
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'icon_style_type',
							'operator' => '!=',
							'value'    => 'default',
						],
						[
							'name'  => 'add_icon',
							'value' => 'yes',
						],
					],
				],
			]
		);
		
		$this->add_control(
			'list_icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => isset( $ciyashop_options['primary_color'] ) ? $ciyashop_options['primary_color'] : '#04d39f',
				'description' => esc_html__( 'Select Icon Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgscore_list li > i' => 'color:{{VALUE}};',
				],
				'condition'   => [
					'add_icon' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'list_icon_background_color',
			[
				'label'       => esc_html__( 'Icon Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Icon Background Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgscore_list li > i' => 'background:{{VALUE}};',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'icon_style_type',
							'value' => 'flat',
						],
						[
							'name'  => 'add_icon',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_list',
			array(
				'label' => esc_html__( 'List Items', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'content',
			array(
				'label'       => esc_html__( 'Content', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add item content.', 'pgs-core' ),
			)
		);

		$repeater->add_control(
			'content_link',
			[
				'label'         => esc_html__( 'Content Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		
		$this->add_control(
			'list_items',
			array(
				'label'       => esc_html__( 'List Items', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ content }}}',
			)
		);

		$this->end_controls_section();
	}
}
