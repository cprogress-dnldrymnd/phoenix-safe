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
class Image_Gallery extends Widget_Controller {

	protected $widget_slug = 'image-gallery';

	protected $widget_icon = 'eicon-gallery-grid';

	protected $keywords = array( 'image', 'gallery' );

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
		return esc_html__( 'Image Gallery', 'pgs-core' );
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
			'image_gallery_style_disable',
			[
				'label'        => esc_html__( 'Hide Icon Style?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);
		
		$this->add_control(
			'image_gallery_style',
			array(
				'label'       => esc_html__( 'Icon Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select icon style.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/image-gallery/style1.jpg',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/image-gallery/style2.jpg',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/image-gallery/style3.jpg',
					),
				),
				'condition'   => array(
					'image_gallery_style_disable!' => 'true',
				),
			)
		);
		
		$this->add_control(
			'image_gallery_type',
			[
				'label'   => esc_html__( 'Image Gallery Type', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'square',
				'default' => 'isotope',
				'options' => [
					'isotope'  => esc_html__( 'Masonry', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'image_gallery_space',
			[
				'label'   => esc_html__( 'Space between Image', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '10',
				'options' => [
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
			'image_gallery_column',
			[
				'label'       => esc_html__( 'Image Gallery Column Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'6' => '6',
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'condition'   => array(
					'image_gallery_type!' => 'carousel',
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
					'image_gallery_type' => 'carousel',
				),
			)
		);

		$this->add_control(
			'carousel_elements_xl',
			[
				'label'       => esc_html__( 'Columns - Extra large &ge;1200px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'6' => esc_html__( '6 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'image_gallery_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_elements_lg',
			[
				'label'       => esc_html__( 'Columns - Large &ge;992px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'image_gallery_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_elements_md',
			[
				'label'       => esc_html__( 'Columns - Medium &ge;768px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
				'default'     => '3',
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
				],
				'condition'   => array(
					'image_gallery_type' => 'carousel',
				),
			]
		);
		
		$this->add_control(
			'carousel_elements_sm',
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
					'image_gallery_type' => 'carousel',
				),
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_images',
			array(
				'label' => esc_html__( 'Images', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'image_overlay_color',
			[
				'label'       => esc_html__( 'Image Overlay Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(0,0,0,0.3)',
				'description' => esc_html__( 'Select overlay color.', 'pgs-core' ),
				'selectors'   => [
					'{{WRAPPER}} .pgscore_image-gallery_hover' => 'background: {{VALUE}};',
				],
				'condition'   => array(
					'image_gallery_style_disable!' => 'true',
				),
			]
		);
		
		$this->add_control(
			'image_gallery',
			[
				'label'   => esc_html__( 'Slider Image Gallery', 'pgs-core' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->end_controls_section();
	}
}
