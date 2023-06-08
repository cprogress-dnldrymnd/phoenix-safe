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
class Static_Block extends Widget_Controller {

	protected $widget_slug = 'static-block';

	protected $widget_icon = 'eicon-custom-css';

	protected $keywords = array( 'static', 'block' );

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
		return esc_html__( 'Static Block', 'pgs-core' );
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
			'html_block_id',
			[
				'label'       => esc_html__( 'Static Block', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select Static Block to display.', 'pgs-core' ),
				'options'     => pgscore_get_static_blocks(),
			]
		);

		$this->add_control(
			'important_note',
			[
				'label'           => '',
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => __( 'The selected block must be built with Elementor; otherwise, it will not display.', 'pgs-core' ),
				'label_block'     => true,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
			]
		);

		$this->end_controls_section();
	}
}
