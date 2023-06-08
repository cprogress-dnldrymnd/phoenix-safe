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
class Categorybox extends Widget_Controller {

	protected $widget_slug = 'categorybox';

	protected $widget_icon = 'eicon-thumbnails-down';

	protected $keywords = array( 'categorybox' );

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
		return esc_html__( 'Category Box', 'pgs-core' );
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter the title.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'title-color',
			[
				'label'     => esc_html__( 'Title Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .category-box h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter the Subtitle.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'subtitle-color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .category-box span.subhead' => 'color: {{VALUE}};',
				],
			]
		);

		$categories_terms = array();
		if ( function_exists( 'pgscore_get_terms' ) ) {
			$categories_terms = pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'product_cat',
					'pad_counts' => true,
				)
			);
		}

		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Categories', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select categories to display on front. If no categories selected, it will not display the complete box on front.', 'pgs-core' ),
				'options'     => array_flip( $categories_terms ),
				'multiple'    => true,
			)
		);

		$this->add_control(
			'categories-color',
			[
				'label'     => esc_html__( 'Categories Color', 'pgs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .category-box-link ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'enable_archive_link',
			[
				'label'        => esc_html__( 'Display View All Link?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'archive_link',
			[
				'label'         => esc_html__( 'Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Select/enter url.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition' => array(
					'enable_archive_link' => 'true',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_background',
			array(
				'label' => esc_html__( 'Background', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'image_source',
			[
				'label'       => esc_html__( 'Image Source', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'options'     => [
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'category_box_bg',
			[
				'label'       => esc_html__( 'Background Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select background image from media library.', 'pgs-core' ),
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
			'category_img_link',
			[
				'label'       => esc_html__( 'Image URL', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'condition'   => [
					'image_source' => 'link',
				],
			]
		);

		$this->end_controls_section();
	}
}
