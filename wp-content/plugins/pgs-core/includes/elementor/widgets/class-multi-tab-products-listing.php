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
class Multi_Tab_Products_Listing extends Widget_Controller {

	protected $widget_slug = 'multi-tab-products-listing';

	protected $widget_icon = 'eicon-product-tabs';

	protected $keywords = array( 'multi', 'tab', 'products', 'listing' );

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
		return esc_html__( 'Multi Tab Products Listing', 'pgs-core' );
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

		$categories_list    = array();
		$categories_list_id = array();

		foreach ( $categories_flat as $term_id => $term ) {
			$categories_list[ $term->slug ]       = $term->name . ' (' . $term->count . ')';
			$categories_list_id[ $term->term_id ] = $term->name . ' (' . $term->count . ')';
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
				'return_value' => 'true',
				'default'      => 'no',
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

		$this->start_controls_section(
			'section_content_content',
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
				'default'     => '#323232',
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .mtpl-title h2' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro' => 'true',
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
				'default'     => '#969696',
				'description' => esc_html__( 'Select description color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .mtpl-description' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro' => 'true',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro',
			array(
				'label'     => esc_html__( 'Intro Design', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'enable_intro' => 'true',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'intro_background',
				'label'    => esc_html__( 'Background', 'pgs-core' ),
				'types'    => [ 'classic' ],
				'selector' => '{{WRAPPER}} .pgs-mtpl-intro-wrapper',
			]
		);

		$this->add_control(
			'intro_bg_image_ol_color',
			[
				'label'       => esc_html__( 'Overlay Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(0,0,0,0.6)',
				'description' => esc_html__( 'Select overlay color for background image.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgs-mtpl-wrapper-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'intro_content_alignment',
			array(
				'label'       => esc_html__( 'Intro Content Alignment', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select content alignment in Intro', 'pgs-core' ),
				'default'     => 'left',
				'options'     => [
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				],
				'condition'   => array(
					'enable_intro' => 'true',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_tab_details',
			array(
				'label' => esc_html__( 'Tabs', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'tabs_position',
			array(
				'label'       => esc_html__( 'Tabs Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => wp_kses(
					__( "Select tabs position. <strong><span class='ciyashop-red'>Note</span>: If 'Intro' is not enabled, Tab Position will be set as 'Top' by default.</strong>", 'pgs-core' ),
					pgscore_allowed_html( array( 'span', 'strong' ) )
				),
				'default'     => 'top',
				'options'     => [
					'top'   => esc_html__( 'Top', 'pgs-core' ),
					'intro' => esc_html__( 'Intro', 'pgs-core' ),
				],
			)
		);

		$this->add_control(
			'top_tabs_style',
			array(
				'label'       => esc_html__( 'Top Tabs Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select tabs style, when Tabs are positioned at top.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/multi_tab_products_listing/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/multi_tab_products_listing/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/multi_tab_products_listing/style-3.png',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/multi_tab_products_listing/style-4.png',
					),
				),
				'condition'   => array(
					'tabs_position' => 'top',
				),
			)
		);

		$this->add_control(
			'tabs_alignment',
			array(
				'label'       => esc_html__( 'Top Tabs Alignment', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select tabs alignment, when Tabs are positioned at top.', 'pgs-core' ),
				'default'     => 'right',
				'options'     => [
					'left'   => esc_html__( 'Left', 'pgs-core' ),
					'center' => esc_html__( 'Center', 'pgs-core' ),
					'right'  => esc_html__( 'Right', 'pgs-core' ),
				],
				'condition'   => array(
					'tabs_position' => 'top',
				),
			)
		);

		$this->add_control(
			'tabs_source',
			array(
				'label'       => esc_html__( 'Tabs Source', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select tabs source.', 'pgs-core' ),
				'default'     => 'product_types',
				'options'     => [
					'categories'    => esc_html__( 'Categories', 'pgs-core' ),
					'product_types' => esc_html__( 'Product Types', 'pgs-core' ),
				],
			)
		);

		$this->add_control(
			'tabs_source_cat_term_field_type',
			array(
				'label'       => esc_html__( 'Tabs Categories Field Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'multiple'    => true,
				'description' => esc_html__( 'Select category field type. If you are facing issue with tab navigation and click on the tab is not working correctly on the front, in another language, then select Category ID.', 'pgs-core' ),
				'default'     => 'slug',
				'options'     => [
					'slug'    => esc_html__( 'Slug', 'pgs-core' ),
					'term_id' => esc_html__( 'Category ID', 'pgs-core' ),
				],
				'condition'   => array(
					'tabs_source' => 'categories',
				),
			)
		);

		$this->add_control(
			'tabs_source_categories',
			array(
				'label'       => esc_html__( 'Tabs Categories (Slug)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select categories to display as tab.', 'pgs-core' ),
				'multiple'    => true,
				'options'     => $categories_list,
				'condition'   => array(
					'tabs_source'                     => 'categories',
					'tabs_source_cat_term_field_type' => 'slug',
				),
			)
		);

		$this->add_control(
			'tabs_source_categories_ids',
			array(
				'label'       => esc_html__( 'Tabs Categories (IDs)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select categories to display as tab.', 'pgs-core' ),
				'options'     => $categories_list_id,
				'multiple'    => true,
				'condition'   => array(
					'tabs_source'                     => 'categories',
					'tabs_source_cat_term_field_type' => 'term_id',
				),
			)
		);

		$this->add_control(
			'tabs_source_product_types',
			array(
				'label'       => esc_html__( 'Tabs Source (Product Types)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select product types to display as tabs.', 'pgs-core' ),
				'options'     => pgscore_product_types(),
				'multiple'    => true,
				'condition'   => array(
					'tabs_source' => 'product_types',
				),
			)
		);

		$this->add_control(
			'tab_link_color',
			[
				'label'       => esc_html__( 'Tab Link Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#323232',
				'description' => wp_kses( __( "<strong><span class='ciyashop-red'>Note</span> : Tab Link color will applied, If 'Tab Position' set as intro.</strong>", 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong' ) ) ),
				'selectors'   => [
					'{{WRAPPER}} .mtpl-tab-link' => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro' => 'true',
				),
			]
		);

		$this->add_control(
			'tab_link_active_color',
			[
				'label'       => esc_html__( 'Tab Link Active Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#04d39f',
				'description' => wp_kses( __( "<strong><span class='ciyashop-red'>Note</span> : Tab link active color will applied, If 'Tab Position' set as intro.</strong>", 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong' ) ) ),
				'selectors'   => [
					'{{WRAPPER}} .mtpl-tab-link.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mtpl-tab-link:hover'  => 'color: {{VALUE}};',
				],
				'condition'   => array(
					'enable_intro' => 'true',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'listing_type' => 'grid',
				],
			)
		);

		$this->add_control(
			'list_grid_columns',
			array(
				'label'       => esc_html__( 'Grid Columns', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
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
			)
		);

		$this->add_control(
			'list_grid_columns_small',
			array(
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
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Carousel Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'listing_type' => 'carousel',
				],
			)
		);

		$this->add_control(
			'list_carousel_items_xs',
			array(
				'label'       => esc_html__( 'Small Devices ( &lt;480px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'pgs-core' ),
				'default'     => '1',
				'options'     => [
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'list_carousel_items_sm',
			array(
				'label'       => esc_html__( 'Small Devices ( &ge;480px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'pgs-core' ),
				'default'     => '2',
				'options'     => [
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'list_carousel_items_md',
			array(
				'label'       => esc_html__( 'Medium Devices ( &ge;768px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select number of items to display at a time in medium devices.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'list_carousel_items_lg',
			array(
				'label'       => esc_html__( 'Large Devices ( &ge;992px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select number of items to display at a time in large devices.', 'pgs-core' ),
				'default'     => '4',
				'options'     => [
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'list_carousel_items_xl',
			array(
				'label'       => esc_html__( 'Extra Large Devices ( &ge;1200px )', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select number of items to display at a time in  extra large devices.', 'pgs-core' ),
				'default'     => '5',
				'options'     => [
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
				],
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->end_controls_section();
	}
}
