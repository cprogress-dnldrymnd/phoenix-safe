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
class Clients extends Widget_Controller {

	protected $widget_slug = 'clients';

	protected $widget_icon = 'eicon-carousel';

	protected $keywords = array( 'clients' );

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
		return esc_html__( 'Clients Logo', 'pgs-core' );
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
				'label'   => esc_html__( 'List Style', 'pgs-core' ),
				'type'    => 'pgs_select_image',
				'default' => 'slider',
				'options' => array(
					'slider' => array(
						'label' => esc_html__( 'Slider', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/clients/style-1.png',
					),
					'grid'   => array(
						'label' => esc_html__( 'Grid', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/clients/style-2.png',
					),
				),
			)
		);
		
		$this->add_control(
			'img_size',
			[
				'label'       => esc_html__( 'Image Size', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'pgs-core' ),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Slider Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'style' => 'slider',
				],
			)
		);
		
		$this->add_control(
			'slider_elements',
			[
				'label'       => esc_html__( 'Slider Navigations', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'description' => esc_html__( 'Select slider navigations controls type.', 'pgs-core' ),
				'options'     => [
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'pagination' => esc_html__( 'Pagination Control', 'pgs-core' ),
					'prevnext'   => esc_html__( 'Prev/Next Buttons', 'pgs-core' ),
					'both'       => esc_html__( 'Both', 'pgs-core' ),
				],
				'condition'   => [
					'style' => 'slider',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'style' => 'grid',
				],
			)
		);
		
		$this->add_control(
			'grid_elements',
			[
				'label'       => esc_html__( 'Grid Columns', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select number of columns in Grid view.', 'pgs-core' ),
				'options'     => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				],
				'condition'   => [
					'style' => 'grid',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_logo_image',
			array(
				'label' => esc_html__( 'Logo Images', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image_source',
			array(
				'label'   => esc_html__( 'Image Source', 'pgs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				],
			)
		);
		
		$repeater->add_control(
			'slide_image',
			[
				'label'     => esc_html__( 'Slide Image', 'pgs-core' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'image_source' => 'image',
				],
			]
		);
		
		$repeater->add_control(
			'slide_img_link',
			[
				'label'         => esc_html__( 'Image URL', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'image_source' => 'link',
				],
			]
		);
		
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title.', 'pgs-core' ),
			]
		);
		
		$repeater->add_control(
			'image_link',
			[
				'label'         => esc_html__( 'Image Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'heading'       => esc_html__( 'Image Link', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		
		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Logo Images', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			)
		);
		
		$this->end_controls_section();
	}
}
