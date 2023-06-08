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
class Instagram extends Widget_Controller {

	protected $widget_slug = 'instagram';

	protected $widget_icon = 'eicon-instagram-gallery';

	protected $keywords = array( 'instagram' );

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
		return esc_html__( 'Instagram', 'pgs-core' );
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
			'list_type',
			array(
				'label'       => esc_html__( 'List Type', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select list type.', 'pgs-core' ),
				'default'     => 'grid',
				'options'     => array(
					'grid' => array(
						'label' => esc_html__( 'Grid', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/instagram_v3/list_type/grid.png',
					),
					'carousel'  => array(
						'label' => esc_html__( 'Carousel', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/instagram_v3/list_type/carousel.png',
					),
				),
			)
		);

		$this->add_responsive_control(
			'item_count',
			[
				'label'       => esc_html__( 'Item Count', 'pgs-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Please select Height Between 1 to 20.', 'pgs-core' ),
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					],
				],
				'default'     => [
					'size' => 12,
				],
			]
		);
		
		$this->add_control(
			'image_size',
			[
				'label'       => esc_html__( 'Image Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'thumbnail',
				'description' => esc_html__( 'Select image size.', 'pgs-core' ),
				'options'     => [
					'thumbnail' => esc_html__( 'Thumbnail', 'pgs-core' ),
					'small'     => esc_html__( 'Small', 'pgs-core' ),
					'large'     => esc_html__( 'Large', 'pgs-core' ),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_grid',
			array(
				'label' => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition'    => array(
					'list_type' => 'grid',
				),
			)
		);
		
		$this->add_control(
			'grid_col_xl',
			[
				'label'       => esc_html__( 'Grid Column (Extra large &ge;1200px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '6',
				'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
				'options'     => [
					'6' => esc_html__( '6 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'grid',
				),
			]
		);
		
		$this->add_control(
			'grid_col_lg',
			[
				'label'       => esc_html__( 'Grid Column (Large &ge;992px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
				'options'     => [
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'grid',
				),
			]
		);
		
		$this->add_control(
			'grid_col_md',
			[
				'label'       => esc_html__( 'Grid Column (Medium &ge;768px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
				'options'     => [
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'grid',
				),
			]
		);
		
		$this->add_control(
			'grid_col_sm',
			[
				'label'       => esc_html__( 'Grid Column (Small &ge;576px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
				'options'     => [
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'grid',
				),
			]
		);
		
		$this->add_control(
			'grid_col_xs',
			[
				'label'       => esc_html__( 'Grid Column (Extra small <576px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
				'options'     => [
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'grid',
				),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_carousel',
			array(
				'label'     => esc_html__( 'Carousel Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'list_type' => 'carousel',
				),
			)
		);
		
		$this->add_control(
			'carousel_pagination',
			[
				'label'        => esc_html__( 'Show Pagination', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to show carousel pagination navigation.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'condition'    => array(
					'list_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_arrow',
			[
				'label'        => esc_html__( 'Show Left/Right Navigation', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to show carousel left/right navigation.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'condition'    => array(
					'list_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_gapping',
			[
				'label'       => esc_html__( 'Item Gapping', 'pgs-core' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select gapping between carousel items', 'pgs-core' ),
				'min'         => 0,
				'max'         => 20,
				'step'        => 1,
				'default'     => 0,
				'condition'   => array(
					'list_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_items_xl',
			[
				'label'       => esc_html__( 'Carousel Items(Extra large &ge;1200px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '5',
				'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
				'options'     => [
					'10' => esc_html__( '10 Items', 'pgs-core' ),
					'9'  => esc_html__( '9 Items', 'pgs-core' ),
					'8'  => esc_html__( '8 Items', 'pgs-core' ),
					'7'  => esc_html__( '7 Items', 'pgs-core' ),
					'6'  => esc_html__( '6 Items', 'pgs-core' ),
					'5'  => esc_html__( '5 Items', 'pgs-core' ),
					'4'  => esc_html__( '4 Items', 'pgs-core' ),
					'3'  => esc_html__( '3 Items', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_items_lg',
			[
				'label'       => esc_html__( 'Carousel Items(Large &ge;992px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
				'options'     => [
					'8' => esc_html__( '8 Items', 'pgs-core' ),
					'7' => esc_html__( '7 Items', 'pgs-core' ),
					'6' => esc_html__( '6 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_items_md',
			[
				'label'       => esc_html__( 'Carousel Items(Medium &ge;768px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
				'options'     => [
					'6' => esc_html__( '6 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'1' => esc_html__( '1 Item', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_items_sm',
			[
				'label'       => esc_html__( 'Carousel Items(Small &ge;576px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
				'options'     => [
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'1' => esc_html__( '1 Item', 'pgs-core' ),
				],
				'condition'    => array(
					'list_type' => 'carousel',
				),
			]
		);

		$this->end_controls_section();
	}
}
