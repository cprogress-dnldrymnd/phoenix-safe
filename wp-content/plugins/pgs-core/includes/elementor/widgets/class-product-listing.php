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
class Product_Listing extends Widget_Controller {

	protected $widget_slug = 'product-listing';

	protected $widget_icon = 'eicon-products-archive';

	protected $keywords = array( 'product-listing' );

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
		return esc_html__( 'Product Listing', 'pgs-core' );
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
			$categories_list[ $term->name . ' (' . $term->count . ')' ] = $term->slug;
		}

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'listing_type',
			[
				'label'       => esc_html__( 'Listing Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'grid',
				'description' => esc_html__( 'Select listing type.', 'pgs-core' ),
				'options'     => [
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'enable_intro',
			[
				'label'        => esc_html__( 'Enable Intro', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable intro to display title and description (and tabs) on left side of listing.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		// Content
		$this->start_controls_section(
			'section_content_tab',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'intro_title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add intro title.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'intro_title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'default'     => '#323232',
				'selectors'   => [
					'{{WRAPPER}} .products-listing-title h2' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro' => 'yes',
				),
			]
		);

		$this->add_control(
			'intro_description',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add intro description.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'intro_description_color',
			[
				'label'       => esc_html__( 'Description Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select description color.', 'pgs-core' ),
				'default'     => '#969696',
				'selectors'   => [
					'{{WRAPPER}} .products-listing-description' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro' => 'yes',
				),
			]
		);

		$this->add_control(
			'enable_intro_link',
			[
				'label'        => esc_html__( 'Enable Intro Link', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable this to display link in  Intro Content.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'enable_intro' => 'yes',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro_link',
			array(
				'label'     => esc_html__( 'Intro Link', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'enable_intro_link' => 'yes',
					'enable_intro'      => 'yes',
				),
			)
		);

		$this->add_control(
			'link_title',
			[
				'label'     => esc_html__( 'Link Title', 'pgs-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'View All', 'pgs-core' ),
				'condition' => array(
					'enable_intro_link' => 'yes',
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
					'enable_intro_link' => 'yes',
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
					'{{WRAPPER}} .products-listing-link a' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro_link' => 'yes',
				),
			]
		);

		$this->add_control(
			'intro_link_position',
			[
				'label'       => esc_html__( 'Link Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'below_desc',
				'description' => esc_html__( 'Select link position. Note: This is applicable only when "Listing Type" is set to "Carousel". If "Listing Type" is set to grid, this will be set as "Below Description" by default.', 'pgs-core' ),
				'options'     => [
					'below_desc'    => esc_html__( 'Below Description', 'pgs-core' ),
					'with_controls' => esc_html__( 'With Carousel Controls', 'pgs-core' ),
				],
				'condition'   => array(
					'enable_intro_link' => 'yes',
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

		// Intro
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro_design',
			array(
				'label'     => esc_html__( 'Intro Design', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'enable_intro' => 'yes',
				),
			)
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
					'enable_intro' => 'yes',
				),
			]
		);

		$this->add_control(
			'intro_content_alignment',
			[
				'label'       => esc_html__( 'Intro Content Alignment', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'left',
				'description' => esc_html__( 'Select content alignment in Intro', 'pgs-core' ),
				'options'     => [
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				],
				'condition'   => array(
					'enable_intro' => 'yes',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'intro_background',
				'label'    => esc_html__( 'Background', 'pgs-core' ),
				'types'    => [ 'classic' ],
				'selector' => '{{WRAPPER}} .products-listing-intro-wrapper',
			]
		);

		$this->add_control(
			'intro_bg_image_ol_color',
			[
				'label'       => esc_html__( 'Overlay Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select overlay color for background image.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .products-listing-intro-wrapper-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Products Filter
		$this->start_controls_section(
			'section_content_products',
			array(
				'label' => esc_html__( 'Products', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'product_source',
			[
				'label'       => esc_html__( 'Product Source', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'product_type',
				'description' => esc_html__( 'Select product source.', 'pgs-core' ),
				'options'     => [
					'category'          => esc_html__( 'Category', 'pgs-core' ),
					'product_type'      => esc_html__( 'Product Type', 'pgs-core' ),
					'selected_products' => esc_html__( 'Selected Products', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
		    'product_ids',
		    [
			    'label'       => esc_html__( 'Select Products', 'pgs-core' ),
			    'type'        => 'pgs_ajax_select',
				'source_name' => 'post_type',
				'source_type' => 'product',
				'multiple'    => true,
				'ajax_params' => array(),
			    'label_block' => true,
			    'condition'   => [
					'product_source' => 'selected_products',
			    ],
		    ]
	    );

		$this->add_control(
			'product_source_category',
			[
				'label'       => esc_html__( 'Product Source (Category)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select category to display products from.', 'pgs-core' ),
				'options'     => array_flip( $categories_list ),
				'condition'   => array(
					'product_source' => 'category',
				),
			]
		);

		$this->add_control(
			'product_source_product_type',
			[
				'label'       => esc_html__( 'Product Source (Product Type)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'product_type',
				'description' => esc_html__( 'Select product type to display products from.', 'pgs-core' ),
				'options'     => pgscore_product_types(),
				'condition'   => array(
					'product_source' => 'product_type',
				),
			]
		);

		$this->add_control(
			'number_of_item',
			[
				'label' => esc_html__( 'Number of item', 'pgs-core' ),
				'type'  => Controls_Manager::NUMBER,
			]
		);

		$this->end_controls_section();

		// Grid Settings
		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'listing_type' => 'grid',
				),
			)
		);

		$this->add_control(
			'list_grid_columns',
			[
				'label'       => esc_html__( 'Grid Columns', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Select listing grid columns.', 'pgs-core' ),
				'options'     => [
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'5' => esc_html__( '5 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'grid',
				),
			]
		);

		$this->add_control(
			'list_grid_columns_small',
			[
				'label'       => esc_html__( 'Grid Columns for small devices', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Select listing grid columns.', 'pgs-core' ),
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'grid',
				),
			]
		);

		$this->end_controls_section();

		// Carousel Settings
		$this->start_controls_section(
			'section_content_carousel',
			array(
				'label'     => esc_html__( 'Carousel Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'list_carousel_items_xs',
			[
				'label'       => esc_html__( 'Small Devices (&lt;480px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'pgs-core' ),
				'options'     => [
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'list_carousel_items_sm',
			[
				'label'       => esc_html__( 'Small Devices (&ge;480px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'pgs-core' ),
				'options'     => [
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'list_carousel_items_md',
			[
				'label'       => esc_html__( 'Medium Devices ( &ge;768px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select number of items to display at a time in medium devices.', 'pgs-core' ),
				'options'     => [
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'list_carousel_items_lg',
			[
				'label'       => esc_html__( 'Large Devices ( &ge;992px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Select number of items to display at a time in large devices.', 'pgs-core' ),
				'options'     => [
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'list_carousel_items_xl',
			[
				'label'       => esc_html__( 'Extra Large Devices ( &ge;1200px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '5',
				'description' => esc_html__( 'Select number of items to display at a time in  extra large devices.', 'pgs-core' ),
				'options'     => [
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->end_controls_section();
	}
}
