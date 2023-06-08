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
class Address_Block extends Widget_Controller {

	protected $widget_slug = 'address-block';

	protected $widget_icon = 'eicon-alert';

	protected $keywords = array( 'address', 'block' );

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
		return esc_html__( 'Address Block', 'pgs-core' );
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
			'style',
			[
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select style.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'border'  => esc_html__( 'Border', 'pgs-core' ),
					'flat'    => esc_html__( 'Flat', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'icon-position',
			[
				'label'       => esc_html__( 'Icon Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'icon-left',
				'description' => esc_html__( 'Select icon Position.', 'pgs-core' ),
				'options'     => [
					'icon-top'   => esc_html__( 'Top', 'pgs-core' ),
					'icon-left'  => esc_html__( 'Left', 'pgs-core' ),
					'icon-right' => esc_html__( 'Right', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'shape',
			[
				'label'       => esc_html__( 'Shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'square',
				'description' => esc_html__( 'Select icon shape.', 'pgs-core' ),
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
				],
				'condition'   => array(
					'style' => [ 'border', 'flat' ],
				),
			]
		);

		$this->add_control(
			'alighnment',
			[
				'label'       => esc_html__( 'Alignment', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
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
				'condition'   => array(
					'icon-position' => 'icon-top',
				),
				'description' => esc_html__( 'Select section alignment.', 'pgs-core' ),
				'default'     => 'left',
				'toggle'      => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_icon',
			array(
				'label' => esc_html__( 'Icon', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'icon',
			[
				'label'   => __( 'Icon', 'pgs-core' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .address-block .address-block-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .address-block.border .address-block-icon i' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg-color',
			[
				'label'     => esc_html__( 'Icon Background Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'style' => [ 'flat' ],
				),
				'selectors' => [
					'{{WRAPPER}} .address-block.flat .address-block-icon i' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'pgs-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .address-block i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_content',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'pgs-core' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .address-block .title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_responsive_control(
			'subcontent_title',
			array(
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add content here.', 'pgs-core' ),
			)
		);
		
		$repeater->add_control(
			'enable_link',
			[
				'label'        => esc_html__( 'Enable Link', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable link for the content.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);
		
		$repeater->add_control(
			'custom_link',
			[
				'label'         => esc_html__( 'Content Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enable link for the content.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => array(
					'enable_link' => 'true',
				),
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Sub Content Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .address-block .address-block-data span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .address-block .address-block-data span a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'sub_contents',
			array(
				'label'       => esc_html__( 'Sub Contents', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ subcontent_title }}}',
			)
		);

		$this->end_controls_section();
	}
}
