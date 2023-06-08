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
class Newsletter extends Widget_Controller {

	protected $widget_slug = 'newsletter';

	protected $widget_icon = 'eicon-mail';

	protected $keywords = array( 'newsletter' );

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
		return esc_html__( 'Newsletter', 'pgs-core' );
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
			[
				'label'   => esc_html__( 'Style', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => esc_html__( 'Style 1', 'pgs-core' ),
					'style-2' => esc_html__( 'Style 2', 'pgs-core' ),
					'style-3' => esc_html__( 'Style 3', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'newsletter_design',
			array(
				'label'       => esc_html__( 'Newsletter Designs', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select the newsletter design', 'pgs-core' ),
				'default'     => 'design-1',
				'options'     => array(
					'design-1' => array(
						'label' => esc_html__( 'Design 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/newsletter/style_1.jpg',
					),
					'design-2' => array(
						'label' => esc_html__( 'Design 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/newsletter/style_2.jpg',
					),
					'design-3' => array(
						'label' => esc_html__( 'Design 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/newsletter/style_3.jpg',
					),
					'design-4' => array(
						'label' => esc_html__( 'Design 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/newsletter/style_4.jpg',
					),
					'design-5' => array(
						'label' => esc_html__( 'Design 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/newsletter/style_5.jpg',
					),
					'design-6' => array(
						'label' => esc_html__( 'Design 6', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/newsletter/style_6.jpg',
					),
				),
				'condition'   => [
					'style' => 'style-1',
				],
			)
		);

		$this->add_control(
			'button_type',
			[
				'label'   => esc_html__( 'Button Type', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => [
					'dark'  => esc_html__( 'Dark', 'pgs-core' ),
					'theme' => esc_html__( 'Theme', 'pgs-core' ),
				],
				'condition'   => [
					'style' => 'style-3',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_details',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title here', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .newsletter-wrapper .newsletter-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter description. Please ensure to add short content.', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'description_color',
			[
				'label'       => esc_html__( 'Description Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select Description color.', 'pgs-core' ),
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .newsletter-wrapper .newsletter > p, {{WRAPPER}} .newsletter-wrapper .newslatter-text > p' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'content_alignment',
			[
				'label'     => esc_html__( 'Content Alignment', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'right'  => esc_html__( 'Right', 'pgs-core' ),
					'center' => esc_html__( 'Center', 'pgs-core' ),
					'left'   => esc_html__( 'Left', 'pgs-core' ),
				],
				'condition' => [
					'style' => array ('style-1','style-2'),
				],
			]
		);
		
		$this->add_control(
			'bg_type',
			[
				'label'     => esc_html__( 'Content Background', 'pgs-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'light',
				'options'   => [
					'light' => esc_html__( 'Light', 'pgs-core' ),
					'dark'  => esc_html__( 'Dark', 'pgs-core' ),
				],
				'condition' => [
					'style' => 'style-2',
				],
			]
		);
		
		$this->end_controls_section();
	}
}
