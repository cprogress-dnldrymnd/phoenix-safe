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
class Timeline extends Widget_Controller {

	protected $widget_slug = 'timeline';

	protected $widget_icon = 'eicon-time-line';

	protected $keywords = array( 'timeline' );

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
		return esc_html__( 'Timeline', 'pgs-core' );
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
			array(
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'style of timeline item display.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/timeline/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/timeline/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/timeline/style-3.png',
					),
				),
			)
		);
		
		$this->add_control(
			'box_shape',
			[
				'label'       => esc_html__( 'List Box Shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select list box shape.', 'pgs-core' ),
				'default'     => 'square',
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				],
				'condition'   => array(
					'style!' => 'style-2',
				),
			]
		);

		$this->add_control(
			'list_bg_color',
			[
				'label'       => esc_html__( 'List Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f5f5f5',
				'description' => esc_html__( 'Select background color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .timeline-panel' => 'color: {{VALUE}};',
					'{{WRAPPER}} .timeline-panel' => 'background: {{VALUE}};',
					'{{WRAPPER}} .pgscore_timeline_wrapper .timeline-panel:before' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
				],
				'condition'   => array(
					'style' => 'style-3',
				),
			]
		);
		
		$this->add_control(
			'list_title_color',
			[
				'label'       => esc_html__( 'List Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .timeline-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'list_description_color',
			[
				'label'       => esc_html__( 'List Description Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select description color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .timeline-body' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_list',
			array(
				'label' => esc_html__( 'Timeline List', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'timeline_title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter button title.', 'pgs-core' ),
			]
		);
		
		$repeater->add_control(
			'timeline_description',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter button description.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'list',
			array(
				'label'       => esc_html__( 'Timeline Items', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ timeline_title }}}',
			)
		);

		$this->end_controls_section();
	}
}
