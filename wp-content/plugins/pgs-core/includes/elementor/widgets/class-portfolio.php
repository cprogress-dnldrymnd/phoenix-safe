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
class Portfolio extends Widget_Controller {

	protected $widget_slug = 'portfolio';

	protected $widget_icon = 'eicon-gallery-justified';

	protected $keywords = array( 'portfolio' );

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
		return esc_html__( 'Portfolio', 'pgs-core' );
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
			array(
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select style.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/portfolio/style1.jpg',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/portfolio/style2.jpg',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/portfolio/style3.jpg',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/portfolio/style4.jpg',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/portfolio/style5.jpg',
					),
				),
			)
		);

		$this->add_control(
			'portfolio_type',
			[
				'label'       => esc_html__( 'Portfolio Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'isotope',
				'description' => esc_html__( 'Select Border Shape.', 'pgs-core' ),
				'options'     => [
					'isotope'  => esc_html__( 'Isotope', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'portfolio_space',
			[
				'label'       => esc_html__( 'Space between Portfolio', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '10',
				'options'     => [
					'0'  => '0',
					'5'  => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
				],
			]
		);

		$this->add_control(
			'portfolio_column',
			[
				'label'       => esc_html__( 'Portfolio Column Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'6' => '6',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				],
				'condition'   => array(
					'portfolio_type' => [ 'isotope', 'grid' ],
				),
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
			'portfolio_per_page',
			[
				'label'       => esc_html__( 'Number Of Portfolio', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 10,
				'max'         => 100,
				'step'        => 1,
				'default'     => 20,
				'description' => esc_html__( 'Add number of portfolio to display', 'pgs-core' ),
			]
		);

		$categories_terms = array();
		if ( function_exists( 'pgscore_get_terms' ) ) {
			$categories_terms = pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'portfolio-category',
					'pad_counts' => true,
				)
			);
		}

		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Categories', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
				'options'     => array_flip( $categories_terms ),
				'condition'   => array(
					'portfolio_type' => 'isotope',
				),
				'multiple'    => true,
			)
		);

		$this->add_control(
			'oredr_by',
			[
				'label'       => esc_html__( 'Order By', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'publish_date',
				'options'     => [
					'title'        => esc_html__( 'Title', 'pgs-core' ),
					'publish_date' => esc_html__( 'Date', 'pgs-core' ),
					'modified'     => esc_html__( 'Modified', 'pgs-core' ),
					'ID'           => esc_html__( 'ID', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'sort_by',
			[
				'label'       => esc_html__( 'Sort By', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'ASC',
				'options'     => [
					'ASC'  => esc_html__( 'ASC', 'pgs-core' ),
					'DESC' => esc_html__( 'DESC', 'pgs-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Slider Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'portfolio_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'carousel_items_xl',
			[
				'label'       => esc_html__( 'Extra large &ge;1200px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				],
				'condition'   => array(
					'portfolio_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_items_lg',
			[
				'label'       => esc_html__( 'Large &ge;992px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				],
				'condition'   => array(
					'portfolio_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_items_md',
			[
				'label'       => esc_html__( 'Medium &ge;768px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '2',
				'options'     => [
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'condition'   => array(
					'portfolio_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_items_sm',
			[
				'label'       => esc_html__( 'Small &ge;576px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '1',
				'options'     => [
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'condition'   => array(
					'portfolio_type' => 'carousel',
				),
			]
		);

		$this->end_controls_section();
	}
}
