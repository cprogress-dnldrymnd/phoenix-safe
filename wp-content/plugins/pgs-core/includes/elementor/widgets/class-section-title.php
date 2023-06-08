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
class Section_Title extends Widget_Controller {

	protected $widget_slug = 'section-title';

	protected $widget_icon = 'eicon-typography-1';

	protected $keywords = array( 'section', 'title' );

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
		return esc_html__( 'Section Title', 'pgs-core' );
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
			'section_title_style',
			array(
				'label'       => esc_html__( 'Title Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'default'     => 'style-1',
				'description' => esc_html__( 'Select  Title Style.', 'pgs-core' ),
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/section_title/style1.jpg',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/section_title/style2.jpg',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/section_title/style3.jpg',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/section_title/style4.jpg',
					),
				),
			)
		);

		$this->add_control(
			'section_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'section_title_style' => [ 'style-2', 'style-3' ]
				),
				'selectors' => [
					'{{WRAPPER}} .pgscore_divider_style2 .divider-title:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .pgscore_divider_style3 .pgscore-left-line' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .pgscore_divider_style3 .pgscore-right-line' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_source',
			[
				'label'     => esc_html__( 'Image Source', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'image',
				'options'   => [
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				],
				'condition' => [
					'section_title_style' => 'style-4',
				],
			]
		);
		
		$this->add_control(
			'divider_bg_img',
			[
				'label'       => esc_html__( 'Divider Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select/upload divider image.', 'pgs-core' ),
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'section_title_style',
							'value' => 'style-4',
						],
						[
							'name'  => 'image_source',
							'value' => 'image',
						],
					],
				],
			]
		);

		$this->add_control(
			'divider_bg_img_link',
			[
				'label'       => esc_html__( 'Image Link', 'pgs-core' ),
				'type'        => Controls_Manager::URL,
				'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'is_external' => false,
				'nofollow'    => false,
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'section_title_style',
							'value' => 'style-4',
						],
						[
							'name'  => 'image_source',
							'value' => 'link',
						],
					],
				],
			]
		);

		$this->add_control(
			'section_alighnment',
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
				'description' => esc_html__( 'Select section alignment.', 'pgs-core' ),
				'default'     => 'center',
				'toggle'      => true,
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section__title_content',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);


		$this->add_control(
			'main_title',
			[
				'label' => esc_html__( 'Main Title', 'pgs-core' ),
				'type'  => Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'main_title_el',
			[
				'label'   => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'section_title_typography',
				'label'    => esc_html__( 'Title Typography', 'pgs-core' ),
				'selector' => '{{WRAPPER}} .pgscore_divider_wrapper .divider-title',
			]
		);

		$this->add_control(
			'main_title_el_color',
			[
				'label'     => esc_html__( 'Title Element Tag Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#323232',
				'selectors' => [
					'{{WRAPPER}} .divider-title' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'pgs-core' ),
				'type'  => Controls_Manager::TEXT,
			]
		);
		
		
		$this->add_control(
			'sub_title_color',
			[
				'label'     => esc_html__( 'Sub Title Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#bbbbbb',
				'selectors' => [
					'{{WRAPPER}} .divider-sub-title' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		
		
		$this->add_control(
			'section_description',
			[
				'label' => esc_html__( 'Description', 'pgs-core' ),
				'type'  => Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'section_description_color',
			[
				'label'     => esc_html__( 'Description Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pgscore_divider_wrapper p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
}
