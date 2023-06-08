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
class Single_Product_Slider extends Widget_Controller {

	protected $widget_slug = 'single-product-slider';

	protected $widget_icon = 'eicon-single-product';

	protected $keywords = array( 'single', 'product', 'slider' );

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
		return esc_html__( 'Single Product Slider', 'pgs-core' );
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

		$categories_hierarchy = function_exists( 'pgscore_get_terms_hierarchy' ) ? pgscore_get_terms_hierarchy( 'product_cat' ) : array();
		$categories_flat      = function_exists( 'pgscore_get_terms_hierarchical_list' ) ? pgscore_get_terms_hierarchical_list( $categories_hierarchy ) : array();
		$categories_list      = array();
		foreach ( $categories_flat as $term_id => $term ) {
			$categories_list[ $term_id ] = $term->name . ' (' . $term->count . ')';
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
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select style.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/single_product_slider/style1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/single_product_slider/style2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/single_product_slider/style3.png',
					),
				),
			)
		);

		$this->add_control(
			'custom_title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title.', 'pgs-core' ),
				'condition' => array(
					'style' => array( 'style-1', 'style-3' )
				),
			]
		);

		$this->add_control(
			'custom_content',
			[
				'label'       => esc_html__( 'Content', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Content.', 'pgs-core' ),
				'condition' => array(
					'style' => array( 'style-1', 'style-3' )
				),
			]
		);

		$this->add_control(
			'pro_cat_slug',
			[
				'label'       => esc_html__( 'Select category', 'pgs-core' ),
				'multiple'    => true,
				'type'        => Controls_Manager::SELECT,
				'options'     =>  $categories_list,
			]
		);

		$this->add_control(
			'product_type',
			[
				'label'       => esc_html__( 'Product Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'newest',
				'description' => esc_html__( 'Select product type. which type of product want to display on front page', 'pgs-core' ),
				'options'     => [
					'newest'       => esc_html__( 'Newest', 'pgs-core' ),
					'featured'     => esc_html__( 'Featured', 'pgs-core' ),
					'best_sellers' => esc_html__( 'Best Sellers', 'pgs-core' ),
					'on_sale'      => esc_html__( 'On sale', 'pgs-core' ),
					'cheapest'     => esc_html__( 'Cheapest', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'number_of_item',
			[
				'label'       => esc_html__( 'Number of Item', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 10,
				'default'     => 1,
				'description' => esc_html__( 'Enter number of items to display on front.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();
	}
}
