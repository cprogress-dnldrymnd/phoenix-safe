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
class Callout extends Widget_Controller {

	protected $widget_slug = 'callout';

	protected $widget_icon = 'eicon-call-to-action';

	protected $keywords = array( 'callout' );

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
		return esc_html__( 'Callout', 'pgs-core' );
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
			'callout_title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Callout Title.', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'callout_title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .callout-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'callout_title_element_tag',
			[
				'label'       => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'description' => esc_html__( 'Select Title Element Tag.', 'pgs-core' ),
				'options'     => [
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'callout_description',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter Description.', 'pgs-core' ),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_button',
			array(
				'label' => esc_html__( 'Button', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'callout_button_title',
			[
				'label'       => esc_html__( 'Button Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Button Title.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'callout_button_link',
			[
				'label'         => esc_html__( 'Button Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enter the link.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'callout_button_type',
			[
				'label'       => esc_html__( 'Button Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select Button Type.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'border'  => esc_html__( 'Border', 'pgs-core' ),
					'simple'  => esc_html__( 'Simple Link', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'callout_button_background_color',
			[
				'label'       => esc_html__( 'Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Background Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover' => 'background: {{VALUE}};',
				],
				'condition'     => [
					'callout_button_type' => 'default',
				],
			]
		);
		
		$this->add_control(
			'callout_button_background_hover_color',
			[
				'label'       => esc_html__( 'Background Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Background Hover Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover:hover' => 'background: {{VALUE}};',
				],
				'condition'     => [
					'callout_button_type' => 'default',
				],
			]
		);
		
		$this->add_control(
			'callout_button_border_color',
			[
				'label'       => esc_html__( 'Border Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Border Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover' => 'border-color: {{VALUE}};',
				],
				'condition'     => [
					'callout_button_type' => 'border',
				],
			]
		);
		
		$this->add_control(
			'callout_button_border_hover_color',
			[
				'label'       => esc_html__( 'Border Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Border Hover Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover:hover' => 'border-color: {{VALUE}};',
				],
				'condition'     => [
					'callout_button_type' => 'border',
				],
			]
		);
		
		$this->add_control(
			'callout_button_text_color',
			[
				'label'       => esc_html__( 'Text Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Text color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'callout_button_text_hover_color',
			[
				'label'       => esc_html__( 'Text Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Text Hover color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover:hover' => 'color: {{VALUE}};',
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
			'callout_icon',
			[
				'label'        => esc_html__( 'Icon', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to Enable icon.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Enable', 'pgs-core' ),
				'label_off'    => esc_html__( 'Disable', 'pgs-core' ),
				'return_value' => 'true',
			]
		);
		
		$this->add_control(
			'callout_icon_source',
			array(
				'label'     => esc_html__( 'Icon Source', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'font'  => esc_html__( 'Font', 'pgs-core' ),
					'image' => esc_html__( 'Image', 'pgs-core' ),
				),
				'default'   => 'font',
				'condition' => [
					'callout_icon' => 'true',
				],
			)
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
					'callout_icon_source' => 'font',
					'callout_icon'        => 'true',
				],
			]
		);
		
		$this->add_control(
			'callout_icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select icon color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .callout-icon i' => 'color: {{VALUE}};',
				],
				'condition'     => [
					'callout_icon_source' => 'font',
					'callout_icon'        => 'true',
				],
			]
		);
		
		$this->add_control(
			'callout_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
				),
				'description' => esc_html__( 'Select icon size.', 'pgs-core' ),
				'default'   => 'md',
				'condition' => [
					'callout_icon_source' => 'font',
					'callout_icon'        => 'true',
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
					'callout_icon_source' => 'image',
					'callout_icon'        => 'true',
				],
			]
		);

		$this->end_controls_section();
	}
}
