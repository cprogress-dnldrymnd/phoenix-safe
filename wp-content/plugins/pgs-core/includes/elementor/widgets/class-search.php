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
class Search extends Widget_Controller {

	protected $widget_slug = 'search';

	protected $widget_icon = 'eicon-site-search';

	protected $keywords = array( 'search' );

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
		return esc_html__( 'Search', 'pgs-core' );
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
			'search_placeholder_text',
			[
				'label'       => esc_html__( 'Search Input Placeholder', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
				'description' => esc_html__( 'Enter the Placeholder', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'search_box_shape',
			[
				'label'       => esc_html__( 'Search Box Shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'square',
				'description' => esc_html__( 'Choose search box shape.', 'pgs-core' ),
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'search_box_background',
			[
				'label'       => esc_html__( 'Search Box Background', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Choose search box background.', 'pgs-core' ),
				'options'     => [
					'default'     => esc_html__( 'Default', 'pgs-core' ),
					'transparent' => esc_html__( 'Transparent', 'pgs-core' ),
					'white'       => esc_html__( 'White', 'pgs-core' ),
					'dark'        => esc_html__( 'Dark', 'pgs-core' ),
					'theme'       => esc_html__( 'Theme', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'search_content_type',
			[
				'label'       => esc_html__( 'Search Content Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'all',
				'description' => esc_html__( 'Choose search content type.', 'pgs-core' ),
				'options'     => [
					'all'     => esc_html__( 'All', 'pgs-core' ),
					'product' => esc_html__( 'Product', 'pgs-core' ),
					'post'    => esc_html__( 'Post', 'pgs-core' ),
					'page'    => esc_html__( 'Page', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'show_categories',
			[
				'label'        => esc_html__( 'Show Categories ?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'condition' => array(
					'search_content_type' => array( 'product', 'post' ),
				),
			]
		);

		$this->end_controls_section();
	}
}
