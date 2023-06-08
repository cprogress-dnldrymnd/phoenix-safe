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
class Product_Category_Items extends Widget_Controller {

	protected $widget_slug = 'product-category-items';

	protected $widget_icon = 'eicon-product-images';

	protected $keywords = array( 'product', 'category' );

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
		return esc_html__( 'Product Category Items', 'pgs-core' );
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
				'description' => esc_html__( 'style of products categories item display.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1 ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2 ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3 ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/style-3.png',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4 ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/style-4.png',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5 ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/style-5.png',
					),
					'style-6' => array(
						'label' => esc_html__( 'Style 6 ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/style-6.png',
					),
				),
			)
		);

		$this->add_control(
			'list_style',
			array(
				'label'       => esc_html__( 'List Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Layout style of displaying products categories.', 'pgs-core' ),
				'default'     => 'slider',
				'options'     => array(
					'slider' => array(
						'label' => esc_html__( 'Slider ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/layout-style-1.png',
					),
					'grid'   => array(
						'label' => esc_html__( 'Grid ', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/product_cat_carousel/layout-style-2.png',
					),
				),
			)
		);

		$this->add_control(
			'vertical_align',
			[
				'label'       => esc_html__( 'Text Vertical Align', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'vtop',
				'description' => esc_html__( 'Set text vertical position.', 'pgs-core' ),
				'options'     => [
					'vtop'    => esc_html__( 'Top', 'pgs-core' ),
					'vmiddle' => esc_html__( 'Middle', 'pgs-core' ),
					'vbottom' => esc_html__( 'Bottom', 'pgs-core' ),
				],
				'condition'   => array(
					'style' => [ 'style-1', 'style-3' ],
				),
			]
		);

		$this->add_control(
			'horizontal_align',
			[
				'label'       => esc_html__( 'Text Horizontal Align', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'hleft',
				'description' => esc_html__( 'Set text horizontal position', 'pgs-core' ),
				'options'     => [
					'hleft'   => esc_html__( 'Left', 'pgs-core' ),
					'hcenter' => esc_html__( 'Center', 'pgs-core' ),
					'hright'  => esc_html__( 'Right', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'category_title_tag',
			[
				'label'       => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h3',
				'description' => esc_html__( 'Select category title element tag.', 'pgs-core' ),
				'options'     => [
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
				'name'     => 'category_title_typography',
				'label'    => esc_html__( 'Title Typography', 'pgs-core' ),
				'selector' => '{{WRAPPER}} .inline_hover.category-item-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'count_typography',
				'label'    => esc_html__( 'Count Typography', 'pgs-core' ),
				'selector' => '{{WRAPPER}} .product-count',
			]
		);

		$this->add_control(
			'background_overlay',
			[
				'label'       => esc_html__( 'Text And Overlay Color', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'description' => esc_html__( 'Set text and overlay color.', 'pgs-core' ),
				'options'     => [
					'none'   => esc_html__( 'None', 'pgs-core' ),
					'theme'  => esc_html__( 'Theme', 'pgs-core' ),
					'dark'   => esc_html__( 'Dark', 'pgs-core' ),
					'light'  => esc_html__( 'Light', 'pgs-core' ),
					'custom' => esc_html__( 'Custom', 'pgs-core' ),
				],
				'condition'   => array(
					'style!' => 'style-2',
				),
			]
		);

		$this->add_control(
			'category_title_color',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Category Title Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .inline_hover.category-item-title' => 'color: {{VALUE}};',
				],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'  => 'background_overlay',
							'value' => 'custom',
						],
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-2',
						],
					],
				],
			]
		);

		$this->add_control(
			'category_title_hover_color',
			[
				'label'       => esc_html__( 'Title Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Category Title Hover Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover'       => 'color: {{VALUE}};',
					'{{WRAPPER}} a.inline_hover:hover' => 'color: {{VALUE}};',
				],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'  => 'background_overlay',
							'value' => 'custom',
						],
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-2',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label'       => esc_html__( 'Count Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#969696',
				'description' => esc_html__( 'Select Category Count Title Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} span.product-count' => 'color: {{VALUE}};',
				],
				'conditions'  => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'  => 'background_overlay',
							'value' => 'custom',
						],
						[
							'name'     => 'hide_categories_count',
							'operator' => '!=',
							'value'    => 'true',
						],
						[
							'name'     => 'style',
							'operator' => '!=',
							'value'    => 'style-2',
						],
					],
				],
			]
		);

		$this->add_control(
			'category_background_color',
			[
				'label'       => esc_html__( 'Background Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#969696',
				'description' => esc_html__( 'Select category background color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .category-overlay' => 'background: {{VALUE}};',
					'{{WRAPPER}} .product-category-style-3 .pgs-core-category-container .category-content' => 'background: {{VALUE}};',
					'{{WRAPPER}} .product-category-style-4 .pgs-core-category-container .category-content' => 'background: {{VALUE}};',
					'{{WRAPPER}} .product-category-style-5 .pgs-core-category-container .category-content' => 'background: {{VALUE}};',
					'{{WRAPPER}} .product-category-style-6 .pgs-core-category-container .category-content' => 'background: {{VALUE}};',
				],
				'condition'   => array(
					'background_overlay' => 'custom',
					'style!'             => 'style-2',
				),
			]
		);

		/* Style 2 Uniq Options */
		$this->add_control(
			'category_title_color_style_2',
			[
				'label'       => esc_html__( 'Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => esc_html__( 'Select Category Title Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .inline_hover.category-item-title' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'category_title_hover_color_style_2',
			[
				'label'       => esc_html__( 'Title Hover Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => esc_html__( 'Select Category Title Hover Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} a.inline_hover'       => 'color: {{VALUE}};',
					'{{WRAPPER}} a.inline_hover:hover' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'cat_count_color_style_2',
			[
				'label'       => esc_html__( 'Count Title Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#969696',
				'description' => esc_html__( 'Select Category Count Title Color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} span.product-count' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'cat_img_style',
			[
				'label'       => esc_html__( 'Image Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Set category image style.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				],
				'condition'   => array(
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'show_border_style_2',
			[
				'label'        => esc_html__( 'Show Border?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable to show border to the category item.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'condition'    => array(
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'border_color_style_2',
			[
				'label'       => esc_html__( 'Border Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#969696',
				'description' => esc_html__( 'Select category item border color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .category-img-container' => 'border-color: {{VALUE}};',
				],
				'condition'   => array(
					'show_border_style_2' => 'yes',
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'border_width_style_2',
			[
				'label'       => esc_html__( 'Border Width', 'pgs-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Please select Height Between 1 to 20.', 'pgs-core' ),
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'default'     => [
					'size' => 1,
					'unit' => 'px',
				],
				'condition'   => array(
					'show_border_style_2' => 'yes',
					'style' => 'style-2',
				),
				'selectors'   => [
					'{{WRAPPER}} .category-img-container' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'border_style_style_2',
			[
				'label'       => esc_html__( 'Border Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'description' => esc_html__( 'Select category border style.', 'pgs-core' ),
				'options'     => [
					'none'    => esc_html__( 'None', 'pgs-core' ),
					'solid'   => esc_html__( 'Solid', 'pgs-core' ),
					'dotted'  => esc_html__( 'Dotted', 'pgs-core' ),
					'dashed'  => esc_html__( 'Dashed', 'pgs-core' ),
					'double'  => esc_html__( 'Double', 'pgs-core' ),
					'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
				],
				'selectors'   => [
					'{{WRAPPER}} .category-img-container' => 'border-style: {{VALUE}};',
				],
				'condition'   => array(
					'show_border_style_2' => 'yes',
					'style' => 'style-2',
				),
			]
		);

		$this->add_control(
			'title_counter_display',
			[
				'label'       => esc_html__( 'Title Counter Display', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'title-up-counter-bottom',
				'description' => esc_html__( 'Select option to show title and product counter of product category.', 'pgs-core' ),
				'options'     => [
					'title-up-counter-bottom' => esc_html__( 'Title Up Counter Bottom', 'pgs-core' ),
					'counter-up-title-bottom' => esc_html__( 'Counter Up Title Bottom', 'pgs-core' ),
				],
				'condition'   => array(
					'hide_categories_count!' => 'true',
				),
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label'       => esc_html__( 'Hover Effect', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'description' => esc_html__( 'Set category title hover effect.', 'pgs-core' ),
				'options'     => [
					'none' => esc_html__( 'None', 'pgs-core' ),
					'zoom' => esc_html__( 'Zoom', 'pgs-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_category',
			array(
				'label' => esc_html__( 'Category', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$product_categories_options = array();
		if ( function_exists( 'pgscore_get_terms' ) ) {
			$product_categories_options = pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'product_cat',
					'pad_counts' => true,
					'hide_empty' => false,
					'exclude'    => get_option( 'default_product_cat' ),
				)
			);
		}

		/*  Category Settings */
		$this->add_control(
			'product_categories',
			[
				'label'       => esc_html__( 'Categories', 'pgs-core' ),
				'multiple'    => true,
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select categories to display on front. If no categories selected, it will show all the categories on front.', 'pgs-core' ),
				'options'     => array_flip( $product_categories_options ),
			]
		);

		$this->add_control(
			'empty_categories',
			[
				'label'        => esc_html__( 'Show Empty Categories?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => wp_kses( __( 'Check this checkbox to show categories which are not assigned to any products. <br> <strong><span class="ciyashop-red">Note</span> : Here "Uncategorised" category will not be shown.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_categories_count',
			[
				'label'        => esc_html__( 'Hide Product Categories Count?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => wp_kses( __( 'Check this checkbox to hide categories products counts.', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'order_by',
			[
				'label'       => esc_html__( 'Order By', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'description' => esc_html__( 'Select order by field for order to display product category.', 'pgs-core' ),
				'options'     => [
					''       => esc_html__( 'Default', 'pgs-core' ),
					'name'   => esc_html__( 'Category Name', 'pgs-core' ),
					'date'   => esc_html__( 'Date', 'pgs-core' ),
					'id'     => esc_html__( 'ID', 'pgs-core' ),
					'author' => esc_html__( 'Author', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'list_order',
			[
				'label'       => esc_html__( 'Display Order', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'description' => esc_html__( 'Select order to display product category.', 'pgs-core' ),
				'options'     => [
					''     => esc_html__( 'Default', 'pgs-core' ),
					'ASC'  => esc_html__( 'Ascending', 'pgs-core' ),
					'DESC' => esc_html__( 'Descending', 'pgs-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'list_style' => 'grid',
				),
			)
		);

		// Grid Settings
		$this->add_control(
			'grid_elements_xl',
			[
				'label'       => esc_html__( 'Columns - Extra large &ge;1200px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '4',
				'options'     => [
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'list_style' => 'grid',
				),
			]
		);

		$this->add_control(
			'grid_elements_lg',
			[
				'label'       => esc_html__( 'Columns - Large &ge;992px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'list_style' => 'grid',
				),
			]
		);

		$this->add_control(
			'grid_elements_md',
			[
				'label'       => esc_html__( 'Columns - Medium &ge;768px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'list_style' => 'grid',
				),
			]
		);

		$this->add_control(
			'grid_elements_sm',
			[
				'label'       => esc_html__( 'Columns - Small &ge;576px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '1',
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'list_style' => 'grid',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Slider Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'list_style' => 'slider',
				),
			)
		);

		// Slider Settings
		$this->add_control(
			'slider_elements',
			[
				'label'       => esc_html__( 'Slider Settings', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select slider navigations controls type.', 'pgs-core' ),
				'default'     => 'none',
				'options'     => [
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'pagination' => esc_html__( 'Pagination Control', 'pgs-core' ),
					'prevnext'   => esc_html__( 'Prev/Next Buttons', 'pgs-core' ),
					'both'       => esc_html__( 'Both', 'pgs-core' ),
				],
				'condition'   => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'carousel_items_xl',
			[
				'label'       => esc_html__( 'Extra large &ge;1200px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '4',
				'options'     => [
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				],
				'condition'   => array(
					'list_style' => 'slider',
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
					'4' => '4',
					'3' => '3',
					'2' => '2',
				],
				'condition'   => array(
					'list_style' => 'slider',
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
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'condition'   => array(
					'list_style' => 'slider',
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
					'2' => '2',
					'1' => '1',
				],
				'condition'   => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'carousel_margin',
			[
				'label'       => esc_html__( 'Margin', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter value between 1 to 100.', 'pgs-core' ),
				'min'         => 0,
				'max'         => 50,
				'default'     => 15,
				'description' => wp_kses( __( 'Enter margin, in pixels (px), between each item. <br> <strong><span class="ciyashop-red">Note</span> : If you add "less than 0" value in input, then it will take "0" margin and if you select "greater than 50" value, then it will set 50 as margin.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
				'condition'   => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->end_controls_section();
	}
}
