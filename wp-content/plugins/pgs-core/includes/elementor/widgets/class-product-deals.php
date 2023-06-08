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
use Elementor\Group_Control_Background;

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
class Product_Deals extends Widget_Controller {

	protected $widget_slug = 'product-deals';

	protected $widget_icon = 'eicon-posts-group';

	protected $keywords = array( 'product', 'deals' );

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
		return esc_html__( 'Product Deals', 'pgs-core' );
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

		// Get Product Categories
		$product_categories_data = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
			)
		);

		$product_categories = array();

		if ( ! is_wp_error( $product_categories_data ) ) {
			if ( is_array( $product_categories_data ) || ! empty( $product_categories_data ) ) {
				foreach ( $product_categories_data as $term_data ) {
					if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
						$product_categories[ "{$term_data->name}" ] = $term_data->slug;
					}
				}
			}
		}

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'enable_intro_content',
			[
				'label'        => esc_html__( 'Enable Intro Content', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable intro content to display title and description.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'product_per_page',
			[
				'label'       => esc_html__( 'Product Count', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 2,
				'max'         => 20,
				'description' => esc_html__( 'Enter number product to display.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'product_categories',
			array(
				'label'       => esc_html__( 'Product Categories', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
				'multiple'    => true,
				'options'     => $product_categories,
			)
		);

		$this->add_control(
			'enable_intro_link',
			[
				'label'        => esc_html__( 'Enable Link', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable this to display link in  Intro Content.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			]
		);

		$this->add_control(
			'expire_message',
			[
				'label'       => esc_html__( 'Expire Message', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This offer has expired!', 'pgs-core' ),
				'description' => esc_html__( 'Enter message to display, instead of date counter, when deal is expired.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro_design',
			array(
				'label' => esc_html__( 'Intro Design', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			)
		);

		$this->add_control(
			'intro_title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description'      => esc_html__( 'Add intro title.', 'pgs-core' ),
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'alpha'       => false,
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .product-deals-title h2' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_description',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Add intro description.', 'pgs-core' ),
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_description_color',
			[
				'label'       => esc_html__( 'Description Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'alpha'       => false,
				'default'     => '#969696',
				'description' => esc_html__( 'Select description color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .product-deals-description' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_position',
			[
				'label'       => esc_html__( 'Intro Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'left',
				'description' => esc_html__( 'Select intro position.', 'pgs-core' ),
				'options'     => [
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				],
				'condition'   => array(
					'enable_intro_content' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_bg_type',
			[
				'label' => __( 'Background Type', 'pgs-core' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'color' => [
						'title' => __( 'Color', 'pgs-core' ),
						'icon' => 'fa fa-palette',
					],
					'image' => [
						'title' => __( 'Image', 'pgs-core' ),
						'icon' => 'fa fa-image',
					],
					'none' => [
						'title' => __( 'None', 'pgs-core' ),
						'icon' => 'fa fa-times',
					],
				],
				'default' => 'color',
			]
		);

		$this->add_control(
			'intro_bg_color',
			[
				'label'     => __( 'Background Color', 'pgs-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#f5f5f5',
				'selectors' => [
					'{{WRAPPER}} .product-deals-content-wrapper' => 'background-color: {{VALUE}};',
				],
				'condition'   => array(
					'intro_bg_type' => 'color',
				),
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'intro_background',
				'label'    => esc_html__( 'Background', 'pgs-core' ),
				'types'    => [ 'classic' ],
				'selector' => '{{WRAPPER}} .product-deals-content-wrapper',
				'fields_options' => [
					'background' => [
						'label'   => esc_html__( 'Background', 'pgs-core' ),
						'default' => 'classic',
					],
					'image' => [
						'dynamic' => [
							'active' => false,
						],
					],
					'color' => [
						'condition' => [
							'background' => [ 'gradient' ],
						],
					],
				],
				'condition'   => array(
					'intro_bg_type' => 'image',
				),
			]
		);

		$this->add_control(
			'intro_bg_image_ol_color',
			[
				'label'       => esc_html__( 'Overlay Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select overlay color for background image.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .product-deals-content-wrapper-overlay' => 'background-color: {{VALUE}};',
				],
				'dynamic' => [
					'active' => false,
				],
				'default' => 'rgba(0,0,0,.6)',
				'condition'   => array(
					'intro_bg_type'                => 'image',
					'intro_background_background'  => 'classic',
					'intro_background_image[url]!' => '',
				),
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro_link',
			array(
				'label' => esc_html__( 'Intro Link', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition'   => array(
					'enable_intro_content' => 'true',
					'enable_intro_link'    => 'true',
				),
			)
		);

		$this->add_control(
			'link_title',
			[
				'label'       => esc_html__( 'Link Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'View All', 'pgs-core' ),
				'condition'   => array(
					'enable_intro_link' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_link',
			[
				'label'         => esc_html__( 'Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Add link. For email use mailto:your.email@example.com.', 'pgs-core' ),
				'show_external' => true,
				'condition'     => [
					'enable_intro_link' => 'true',
				],
			]
		);

		$this->add_control(
			'intro_link_color',
			[
				'label'       => esc_html__( 'Link Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select link color.', 'pgs-core' ),
				'default'     => '#323232',
				'selectors'   => [
					'{{WRAPPER}} .product-deals-link a' => 'color: {{VALUE}};',
				],
				'condition'     => [
					'enable_intro_link' => 'true',
				],
			]
		);

		$this->add_control(
			'intro_link_position',
			[
				'label'       => esc_html__( 'Link Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'below_desc',
				'description'      => esc_html__( 'Select link position.', 'pgs-core' ),
				'options'     => [
					'below_desc'    => esc_html__( 'Below Description', 'pgs-core' ),
					'with_controls' => esc_html__( 'With Carousel Controls', 'pgs-core' ),
				],
				'condition'   => array(
					'enable_intro_link' => 'true',
				),
			]
		);

		$this->add_control(
			'intro_link_alignment',
			[
				'label'       => esc_html__( 'Link Alignment', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'left',
				'description' => esc_html__( 'Select link alignment with carousel controls.', 'pgs-core' ),
				'options'     => [
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				],
				'condition'   => array(
					'intro_link_position' => 'with_controls',
				),
			]
		);

		$this->end_controls_section();
	}
}
