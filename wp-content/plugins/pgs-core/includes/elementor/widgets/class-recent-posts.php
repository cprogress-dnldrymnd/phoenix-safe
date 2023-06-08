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
class Recent_Posts extends Widget_Controller {

	protected $widget_slug = 'recent-posts';

	protected $widget_icon = 'eicon-post-slider';

	protected $keywords = array( 'posts' );

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
		return esc_html__( 'Recent Posts', 'pgs-core' );
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

		$recent_post_categories_data = get_terms(
			array(
				'taxonomy'   => 'category',
				'hide_empty' => true,
			)
		);

		$recent_post_categories = array();

		if ( ! is_wp_error( $recent_post_categories_data ) ) {
			if ( is_array( $recent_post_categories_data ) || ! empty( $recent_post_categories_data ) ) {
				foreach ( $recent_post_categories_data as $term_data ) {
					if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
						$recent_post_categories[ "{$term_data->name} ({$term_data->count})" ] = $term_data->slug;
					}
				}
			}
		}

		$categories_hierarchy = function_exists( 'pgscore_get_terms_hierarchy' ) ? pgscore_get_terms_hierarchy( 'category' ) : array();
		$categories_flat      = function_exists( 'pgscore_get_terms_hierarchical_list' ) ? pgscore_get_terms_hierarchical_list( $categories_hierarchy ) : array();
		$categories_list      = array();
		foreach ( $categories_flat as $term_id => $term ) {
			$categories_list[ str_repeat( '&mdash; ', $term->depth ) . $term->name . ' (' . $term->count . ')' ] = $term_id;
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
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-3.png',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-4.jpg',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-5.jpg',
					),
					'style-6' => array(
						'label' => esc_html__( 'Style 6', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-6.jpg',
					),
					'style-7' => array(
						'label' => esc_html__( 'Style 7', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/recent_posts/style-7.jpg',
					),
				),
			)
		);

		$this->add_control(
			'listing_type',
			[
				'label'       => esc_html__( 'List Type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'grid',
				'description' => esc_html__( 'Select list type.', 'pgs-core' ),
				'options'     => [
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'post_title_tag',
			[
				'label'   => esc_html__( 'Post Title Tag', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
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
				'condition'    => [
					'style' => 'style-1',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_details',
			array(
				'label'      => esc_html__( 'Intro Content', 'pgs-core' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'style',
							'value' => 'style-1',
						],
						[
							'name'  => 'enable_intro',
							'value' => 'yes',
						],
					],
				],
			)
		);

		$this->add_control(
			'intro_title',
			[
				'label'       => __( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add intro title.', 'pgs-core' ),
				'condition'   => [
					'enable_intro' => 'yes',
				],
			]
		);

		$this->add_control(
			'intro_title_tag',
			[
				'label'   => esc_html__( 'Title Element', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h2',
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
					'{{WRAPPER}} .latest-post-title h2' => 'color: {{VALUE}};',
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
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Add intro description.', 'pgs-core' ),
				'condition'   => array(
					'enable_intro' => 'yes',
				),
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
					'{{WRAPPER}} .latest-post-description' => 'color: {{VALUE}};',
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
				'condition'    => [
					'enable_intro' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro_link',
			array(
				'label'      => esc_html__( 'Intro Link', 'pgs-core' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'style',
							'value' => 'style-1',
						],
						[
							'name'  => 'enable_intro',
							'value' => 'yes',
						],
						[
							'name'  => 'enable_intro_link',
							'value' => 'yes',
						],
					],
				],
			)
		);

		$this->add_control(
			'link_title',
			[
				'label'       => __( 'Link Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add intro title.', 'pgs-core' ),
				'default'     => esc_html__( 'View All', 'pgs-core' ),
				'condition'   => [
					'enable_intro_link' => 'yes',
				],
			]
		);

		$this->add_control(
			'intro_link',
			[
				'label'         => esc_html__( 'Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Add link. For email use mailto:your.email@example.com.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
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
				'default'     => '#323232',
				'description' => esc_html__( 'Select link color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .latest-post-link a' => 'color: {{VALUE}};',
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
				'options'     => array(
					'below_desc'    => esc_html__( 'Below Description', 'pgs-core' ),
					'with_controls' => esc_html__( 'With Carousel Controls', 'pgs-core' ),
				),
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
				'options'     => array(
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				),
				'condition'   => array(
					'intro_link_position' => 'with_controls',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_intro_design',
			array(
				'label'      => esc_html__( 'Intro Design', 'pgs-core' ),
				'tab'        => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'terms' => [
						[
							'name'  => 'style',
							'value' => 'style-1',
						],
						[
							'name'  => 'enable_intro',
							'value' => 'yes',
						],
					],
				],
			)
		);

		$this->add_control(
			'intro_position',
			[
				'label'       => esc_html__( 'Intro Position', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'left',
				'description' => esc_html__( 'Select intro position.', 'pgs-core' ),
				'options'     => array(
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				),
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
				'options'     => array(
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				),
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
				'selector' => '{{WRAPPER}} .latest-post-intro-wrapper',
			]
		);

		$this->add_control(
			'intro_bg_image_ol_color',
			[
				'label'       => esc_html__( 'Overlay Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select overlay color for background image.', 'pgs-core' ),
				'selectors'   => [ '{{WRAPPER}} .latest-post-intro-wrapper-overlay' => 'background-color: {{VALUE}};' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid_settings',
			array(
				'label'     => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'listing_type' => 'grid',
				),
			)
		);

		$this->add_control(
			'grid_column_xl',
			[
				'label'       => esc_html__( 'Grid Columns - Extra large Devices (&ge;1200px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
				'options'     => array(
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				),
				'condition'   => array(
					'listing_type' => 'grid',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_carousel_settings',
			array(
				'label'     => esc_html__( 'Carousel Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'listing_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'carousel_items_xl',
			[
				'label'       => esc_html__( 'Extra large &ge;1200px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				),
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_items_lg',
			[
				'label'       => esc_html__( 'Large &ge;992px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				),
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_items_md',
			[
				'label'       => esc_html__( 'Medium &ge;768px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				),
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_items_sm',
			[
				'label'       => esc_html__( 'Small &ge;576px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => array(
					'3' => '3',
					'2' => '2',
					'1' => '1',
				),
				'condition'   => array(
					'listing_type' => 'carousel',
				),
			]
		);

		$this->add_control(
			'carousel_margin',
			[
				'label'       => esc_html__( 'Margin', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 100,
				'step'        => 15,
				'description' => esc_html__( 'Enter margin, in pixels (px), between each item.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_posts',
			array(
				'label' => esc_html__( 'Posts', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'Count', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 2,
				'max'         => 10,
				'description' => esc_html__( 'Enter number of posts to display.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => array_flip( $recent_post_categories ),
				'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'show_category_boxes',
			[
				'label'        => esc_html__( 'Show Category Boxes', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to show categories on top within boxes. Note that by choosing this, only single category will be shown for respected blog.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'conditions'   => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'style',
							'value' => 'style-6',
						],
						[
							'name'  => 'style',
							'value' => 'style-7',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}
}
