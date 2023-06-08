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
class Menu_List extends Widget_Controller {

	protected $widget_slug = 'menu-list';

	protected $widget_icon = 'eicon-bullet-list';

	protected $keywords = array( 'list', 'menu' );

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
		return esc_html__( 'Menu List', 'pgs-core' );
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
			'menu_list_title',
			array(
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add menu list title.', 'pgs-core' ),
			)
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
			'menu_title',
			array(
				'label'       => esc_html__( 'Menu Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add item content.', 'pgs-core' ),
			)
		);
		
		$repeater->add_control(
			'menu_item_link',
			[
				'label'         => esc_html__( 'Menu Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		
		$repeater->add_control(
			'menu_item_label',
			array(
				'label'       => esc_html__( 'Menu Label', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add item label.', 'pgs-core' ),
			)
		);
		
		$repeater->add_control(
			'menu_item_label_color',
			[
				'label'       => esc_html__( 'Menu Label Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select label Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .menu_item_label' => 'background: {{VALUE}};',
				],
			]
		);
		
		$repeater->add_control(
			'add_icon',
			[
				'label'        => esc_html__( 'Add Icon?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
			]
		);
		
		$repeater->add_control(
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
			'list_items',
			array(
				'label'       => esc_html__( 'List Items', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ menu_title }}}',
			)
		);

		$this->end_controls_section();
	}
}
