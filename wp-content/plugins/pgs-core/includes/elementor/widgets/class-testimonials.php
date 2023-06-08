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
class Testimonials extends Widget_Controller {

	protected $widget_slug = 'testimonials';

	protected $widget_icon = 'eicon-testimonial-carousel';

	protected $keywords = array( 'testimonials' );

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
		return esc_html__( 'Testimonials', 'pgs-core' );
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

		$testimonial_categories = array();
		if ( function_exists( 'pgscore_get_terms' ) ) {
			$testimonial_categories = pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'testimonial-category',
					'pad_counts' => true,
				)
			);
		}

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'pgs-core' ),
				'type'    => 'pgs_select_image',
				'default' => 'style-1',
				'options' => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-3.png',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-4.png',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-5.png',
					),
					'style-6' => array(
						'label' => esc_html__( 'Style 6', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-6.png',
					),
					'style-7' => array(
						'label' => esc_html__( 'Style 7', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/testimonials/style-7.png',
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_carousel_settings',
			array(
				'label'      => esc_html__( 'Carousel Settings', 'pgs-core' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			)
		);

		$this->add_control(
			'carousel_speed',
			[
				'label'       => esc_html__( 'Carousel Speed', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1000,
				'max'         => 10000,
				'step'        => 2500,
				'default'     => 1000,
				'description' => esc_html__( 'Enter carousel speed in milliseconds.', 'pgs-core' ),
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_prev_next_buttons',
			[
				'label'        => esc_html__( 'Show Prev/Next Buttons', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to display prev/next buttons.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'enable_infinity_loop',
			[
				'label'        => esc_html__( 'Infinity Loop', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to enable infinity loop and display carousel in circular loop.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'slides_per_view',
			[
				'label'       => esc_html__( 'Slides per view', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'slides_per_view_md',
			[
				'label'       => esc_html__( 'Slides per view ( < 1200px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'slides_per_view_sm',
			[
				'label'       => esc_html__( 'Slides per view ( < 992px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'slides_per_view_xs',
			[
				'label'       => esc_html__( 'Slides per view ( < 768px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'2' => '2',
					'1' => '1',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->add_control(
			'slide_margin',
			[
				'label'       => esc_html__( 'Margin', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '30',
				'description' => esc_html__( 'Enter margin, in pixels (px), between each item.', 'pgs-core' ),
				'options'     => [
					'5'  => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-1',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_post_settings',
			array(
				'label' => esc_html__( 'Post Settings', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'Count', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 4,
				'min'         => 1,
				'max'         => 50,
				'description' => wp_kses( __( 'Enter number of testimonial items to display. <br> <strong><span class="ciyashop-red">Note</span> : If you add "less than 0" value in input, then it will take "0" items and if you select "greater than 50" value, then it will set 50 items.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => array_flip( $testimonial_categories ),
				'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();
	}
}
