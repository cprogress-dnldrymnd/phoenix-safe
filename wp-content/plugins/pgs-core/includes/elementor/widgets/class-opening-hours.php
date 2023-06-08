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
class Opening_Hours extends Widget_Controller {

	protected $widget_slug = 'opening-hours';

	protected $widget_icon = 'eicon-toggle';

	protected $keywords = array( 'opening hours' );

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
		return esc_html__( 'Opening Hours', 'pgs-core' );
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Opening Hours', 'pgs-core' ),
				'description' => esc_html__( 'To display the timing you have to add the time in theme options at "Appearance > Theme Options > Site Info > Opening Hours".', 'pgs-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'opening-hours_title_typography',
				'label'    => esc_html__( 'Title Typography', 'pgs-core' ),
				'global'   => [
					'default' => '',
				],
				'selector' => '{{WRAPPER}} .pgs-opening-hours-title',
			]
		);

		$this->add_control(
			'opening-hours_icon-color',
			[
				'label'     => esc_html__( 'Icon Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pgs-opening-hours ul li i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'opening-hours_text-color',
			[
				'label'     => esc_html__( 'Content Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pgs-opening-hours ul li span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pgs-opening-hours ul li label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
}
