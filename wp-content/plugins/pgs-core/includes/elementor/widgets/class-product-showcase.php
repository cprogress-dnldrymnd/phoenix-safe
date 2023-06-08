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
class Product_Showcase extends Widget_Controller {

	protected $widget_slug = 'product-showcase';

	protected $widget_icon = 'eicon-post-list';

	protected $keywords = array( 'product', 'showcase' );

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
		return esc_html__( 'Product Showcase', 'pgs-core' );
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
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_showcase/style-1.png',
					),
					'style-2'  => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_showcase/style-2.png',
					),
				),
			)
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title.', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'title_el',
			[
				'label'       => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'description' => esc_html__( 'Select title element tag.', 'pgs-core' ),
				'options'     => [
					'h1' => esc_html__( 'H1', 'pgs-core' ),
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'product_type',
			[
				'label'       => esc_html__( 'Product Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'recently-viewed',
				'description' => esc_html__( 'Select type of product to display in slider.', 'pgs-core' ),
				'options'     => [
					'recently-viewed'    => esc_html__( 'Recently Viewed', 'pgs-core' ),
					'featured-products'  => esc_html__( 'Featured Products', 'pgs-core' ),
					'products-in-sale'   => esc_html__( 'Products in Sale', 'pgs-core' ),
					'top-rated-products' => esc_html__( 'Top Rated Products', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'number_of_item',
			[
				'label'       => esc_html__( 'Number of item', 'pgs-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter number of products to display in slider.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();
	}
}
