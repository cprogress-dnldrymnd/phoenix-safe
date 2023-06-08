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
class Hotspot extends Widget_Controller {

	protected $widget_slug = 'hotspot';

	protected $widget_icon = 'eicon-integration';

	protected $keywords = array( 'hotspot' );

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
		return esc_html__( 'Hotspot', 'pgs-core' );
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
			'image_source',
			[
				'label'       => esc_html__( 'Image Source', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'description' => esc_html__( 'Select Border Shape.', 'pgs-core' ),
				'options'     => [
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'hotspot_box_img',
			[
				'label'       => esc_html__( 'Hotspot Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Upload image.', 'pgs-core' ),
				'dynamic'     => [
					'active' => false,
				],
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'image_source' => 'image',
				],
			]
		);
		
		$this->add_control(
			'hotspot_box_img_link',
			[
				'label'       => esc_html__( 'Hotspot Image Link', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'condition'   => [
					'image_source' => 'link',
				],
			]
		);
		
		$this->add_control(
			'pointer_style',
			array(
				'label'       => esc_html__( 'Pointer Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select Pointer Style.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/hotspot/style1.jpg',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/hotspot/style2.jpg',
					),
				),
			)
		);
		
		$this->add_control(
			'hotspot_trigger',
			[
				'label'       => esc_html__( 'Trigger', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'hover',
				'description' => esc_html__( 'Select trigger.', 'pgs-core' ),
				'options'     => [
					'hover' => esc_html__( 'Hover', 'pgs-core' ),
					'click' => esc_html__( 'Click', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'hotspot_color_scheme',
			[
				'label'       => esc_html__( 'Color Scheme', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'light-bg',
				'description' => esc_html__( 'Select Color Scheme.', 'pgs-core' ),
				'options'     => [
					'light-bg' => esc_html__( 'Light', 'pgs-core' ),
					'dark-bg'  => esc_html__( 'Dark', 'pgs-core' ),
					'theme-bg' => esc_html__( 'Theme', 'pgs-core' ),
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_list_items',
			array(
				'label' => esc_html__( 'List Items', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_responsive_control(
			'position-horizontal',
			[
				'label'       => esc_html__( 'Position Horizontal', 'pgs-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Please select Height Between 1 to 20.', 'pgs-core' ),
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 0.1,
					],
				],
				'default'     => [
					'size' => 50,
				],
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'left:calc( {{SIZE}}% - 28px);',
				],
				'description' => esc_html__( 'Define hotspot position on background image for horizontal view. By clicking on Set Position  button you can drag the hotspot point to the desired position.', 'pgs-core' ),
			]
		);
		
		$repeater->add_responsive_control(
			'position-vertical',
			[
				'label'       => esc_html__( 'Position Vertical', 'pgs-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Please select Height Between 1 to 20.', 'pgs-core' ),
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 0.1,
					],
				],
				'default'     => [
					'size' => 50,
				],
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top:calc({{SIZE}}% - 28px);',
				],
				'description' => esc_html__( 'Define hotspot position on background image for Vertical view. By clicking on Set Position  button you can drag the hotspot point to the desired position.', 'pgs-core' ),
			]
		);
		
		$repeater->add_control(
			'hotspot_list_image',
			[
				'label'       => esc_html__( 'Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Upload image.', 'pgs-core' ),
				'dynamic'     => [
					'active' => false,
				],
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_list_title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add item title.', 'pgs-core' ),
			]
		);
		
		$repeater->add_control(
			'hotspot_list_content',
			[
				'label'       => esc_html__( 'Content', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add item content.', 'pgs-core' ),
			]
		);

		$repeater->add_control(
			'hotspot_list_link_title',
			[
				'label'       => esc_html__( 'Button Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add Button title.', 'pgs-core' ),
			]
		);

		$repeater->add_control(
			'hotspot_list_link',
			[
				'label'         => esc_html__( 'Button Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enter link.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_list_direction',
			[
				'label'       => esc_html__( 'Direction', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'right',
				'description' => esc_html__( 'Select Direction position.', 'pgs-core' ),
				'options'     => [
					'up'    => esc_html__( 'Up', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'down'  => esc_html__( 'Down', 'pgs-core' ),
				],
			]
		);
		
		$repeater->add_control(
			'hotspot_desktop',
			[
				'label'        => esc_html__( 'Hide Desktop?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add link on banner.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		
		$repeater->add_control(
			'hotspot_mobile',
			[
				'label'        => esc_html__( 'Hide Mobile?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add link on banner.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		
		$this->add_control(
			'list_items',
			array(
				'label'       => esc_html__( 'List Items', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ hotspot_list_title }}}',
			)
		);

		$this->end_controls_section();
	}
}
