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
class Counter extends Widget_Controller {

	protected $widget_slug = 'counter';

	protected $widget_icon = 'eicon-counter';

	protected $keywords = array( 'counter' );

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
		return esc_html__( 'Counter', 'pgs-core' );
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
			'counter_style',
			array(
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select Counter Style.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/counter/style1.jpg',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/counter/style2.jpg',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/counter/style3.jpg',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/counter/style4.jpg',
					),
				),
			)
		);

		$this->add_control(
			'counter_alighnment',
			[
				'label'       => esc_html__( 'Counter Alignment', 'pgs-core' ),
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
				'description' => esc_html__( 'Select counter alignment.', 'pgs-core' ),
				'default'     => 'center',
				'toggle'      => true,
				'condition'   => array(
					'counter_style' => array( 'style-1', 'style-2', 'style-3' ),
				),
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


		$this->start_controls_tabs( 'tabs_counter_style' );

			$this->start_controls_tab(
				'tab_counter_title',
				[
					'label' => __( 'Counter Title', 'pgs-core' ),
				]
			);

			$this->add_control(
				'counter_title',
				[
					'label'       => esc_html__( 'Counter Title', 'pgs-core' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Enter Counter title.', 'pgs-core' ),
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'      => 'counter_title_typography',
					'label'     => esc_html__( 'Counter Title Typography', 'pgs-core' ),
					'selector'  => '{{WRAPPER}} .pgscore-counter-title',
				]
			);

			$this->add_control(
				'counter_title_color',
				[
					'label'       => esc_html__( 'Title Color', 'pgs-core' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => '#969696',
					'description' => esc_html__( 'Select Title color.', 'pgs-core' ),
					'selectors'   => [
						'{{WRAPPER}} .pgscore-counter-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_counter_number',
				[
					'label' => __( 'Counter Number', 'pgs-core' ),
				]
			);

			$this->add_control(
				'counter_number',
				[
					'label'       => esc_html__( 'Counter Number', 'pgs-core' ),
					'type'        => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Enter the counter number.', 'pgs-core' ),
					'min'         => 1,
					'max'         => 1000000,
					'step'        => 5,
					'default'     => 70,
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'      => 'counter_number_typography',
					'label'     => esc_html__( 'Counter Number Typography', 'pgs-core' ),
					'selector'  => '{{WRAPPER}} .pgscore-counter-number',
				]
			);

			$this->add_control(
				'counter_number_color',
				[
					'label'       => esc_html__( 'Number Color', 'pgs-core' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => '#323232',
					'description' => esc_html__( 'Select Number color.', 'pgs-core' ),
					'selectors'   => [
						'{{WRAPPER}} .pgscore-counter-number' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'counter_icon_background',
			array(
				'label'       => esc_html__( 'Counter Icon Background', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select Icon Background/Border.', 'pgs-core' ),
				'default'     => 'background',
				'options'     => array(
					'background' => esc_html__( 'Background', 'pgs-core' ),
					'border'     => esc_html__( 'Border', 'pgs-core' ),
				),
				'condition'     => [
					'counter_style' => 'style-2',
				],
			)
		);

		$this->add_control(
			'counter_background_color',
			[
				'label'       => esc_html__( 'Counter Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Counter Background Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgscore-counter-icon.pgscore-icon-font' => 'background-color: {{VALUE}};',
				],
				'condition' => array(
					'counter_icon_background' => 'background',
					'counter_style'           => 'style-2',
				),
			]
		);

		$this->add_control(
			'counter_border_color',
			[
				'label'       => esc_html__( 'Counter Border Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Counter Border Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgscore-counter-icon.pgscore-icon-font' => 'border-color: {{VALUE}};',
				],
				'condition'     => [
					'counter_icon_background' => 'border',
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
			'counter_icon_disable',
			[
				'label'        => esc_html__( 'Disable Icon', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'counter_icon_position',
			[
				'label'       => esc_html__( 'Icon Position', 'pgs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Select Icon Position.', 'pgs-core' ),
				'default'     => 'left',
				'options'     => [
					'left' => [
						'title' => esc_html__( 'left', 'pgs-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'right'    => [
						'title' => esc_html__( 'Right', 'pgs-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'condition' => array(
					'counter_style' => 'style-4',
					'counter_icon_disable!' => 'true',
				),
			]
		);

		$this->add_control(
			'counter_icon_source',
			array(
				'label'     => esc_html__( 'Icon Source', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'font'  => esc_html__( 'Font', 'pgs-core' ),
					'image' => esc_html__( 'Image', 'pgs-core' ),
				),
				'default'   => 'font',
				'condition' => [
					'counter_icon_disable!' => 'true',
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
					'counter_icon_source' => 'image',
					'counter_icon_disable!' => 'true',
				],
			]
		);

		$this->add_control(
			'image_link',
			[
				'label'         => esc_html__( 'Image Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'counter_icon_source' => 'link',
					'counter_icon_disable!' => 'true',
				],
			]
		);

		$this->add_control(
			'counter_icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select icon color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgscore-counter-icon i' => 'color: {{VALUE}};',
				],
				'condition'     => [
					'counter_icon_source' => 'font',
					'counter_icon_disable!' => 'true',
				],
			]
		);

		$this->add_control(
			'counter_icon_size',
			array(
				'label'     => esc_html__( 'Icon Size', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'description'      => esc_html__( 'Select icon size.', 'pgs-core' ),
				'options'   => array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
					'xl' => esc_html__( 'Extra Large', 'pgs-core' ),
				),
				'default'   => 'md',
				'condition' => [
					'counter_icon_source' => 'font',
					'counter_icon_disable!' => 'true',
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
					'counter_icon_source' => 'font',
					'counter_icon_disable!' => 'true',
				],
			]
		);

		$this->end_controls_section();
	}
}
