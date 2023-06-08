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
class Progress_Bar extends Widget_Controller {

	protected $widget_slug = 'progress-bar';

	protected $widget_icon = 'eicon-skill-bar';

	protected $keywords = array( 'progress' );

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
		return esc_html__( 'Progress Bar', 'pgs-core' );
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
			'progress_bar_title_position',
			[
				'label'       => esc_html__( 'Title Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'up',
				'description' => esc_html__( 'Select Title position.', 'pgs-core' ),
				'options'     => [
					'up'   => esc_html__( 'Up', 'pgs-core' ),
					'down' => esc_html__( 'Down', 'pgs-core' ),
				],
			]
		);
		
		$this->add_responsive_control(
			'progress_bar_height',
			[
				'label'       => esc_html__( 'Height', 'pgs-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Please select Height Between 1 to 20.', 'pgs-core' ),
				'range'       => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default'     => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'   => [
					'{{WRAPPER}} .pgscore_progress_bar_wrapper_inner'    => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .progress-bar.pgscore_progress_bar_box' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_control(
			'progress_bar_border',
			[
				'label'       => esc_html__( 'Border Styles', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'square',
				'description' => esc_html__( 'Select Border Style.', 'pgs-core' ),
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'progress_bar_layout',
			[
				'label'   => esc_html__( 'Progress Bar Layout', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => [
					'light' => esc_html__( 'Light', 'pgs-core' ),
					'dark'  => esc_html__( 'Dark', 'pgs-core' ),
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
			'progress_bar_title',
			array(
				'label' => esc_html__( 'Title', 'pgs-core' ),
				'type'  => Controls_Manager::TEXT,
			)
		);
		
		$repeater->add_control(
			'progress_bar_value',
			[
				'label'       => esc_html__( 'Value', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter value between 1 to 100.', 'pgs-core' ),
				'min'         => 1,
				'max'         => 100,
				'step'        => 5,
				'default'     => 10,
			]
		);

		$repeater->add_control(
			'progress_bar_color',
			[
				'label'       => esc_html__( 'Progress Bar Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select Progress Bar Color.', 'pgs-core' ),
				'default'     => '#04d39f',
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'progress_bar_list',
			array(
				'label'       => esc_html__( 'Progress Bars', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ progress_bar_title }}}',
			)
		);

		$this->end_controls_section();
	}
}
