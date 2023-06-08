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
class Image_Slider extends Widget_Controller {

	protected $widget_slug = 'image-slider';

	protected $widget_icon = 'eicon-slider-video';

	protected $keywords = array( 'image', 'slider' );

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
		return esc_html__( 'Image Slider', 'pgs-core' );
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
				'label'   => esc_html__( 'Style', 'pgs-core' ),
				'type'    => 'pgs_select_image',
				'default' => 'style-1',
				'options' => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/image_slider/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/image_slider/style-2.png',
					),
				),
			)
		);
		
		$this->add_control(
			'list_style',
			array(
				'label'       => esc_html__( 'List Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'default'     => 'slider',
				'description' => esc_html__( 'Layout style of displaying image slider.', 'pgs-core' ),
				'options'     => array(
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
			'thumbnail_size',
			[
				'label'       => esc_html__( 'Thumbnail type', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select thumbnail size you want to use.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'custom'  => esc_html__( 'Custom', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'img_size',
			[
				'label'       => esc_html__( 'Thumbnail Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'full',
				'description' => esc_html__( 'Choose image size. If corresponding size is not available with the theme, then "ciyashop-latest-post-thumbnail" size will apply.', 'pgs-core' ),
				'options'     => [
					'thumbnail' => esc_html__( 'Thumbnail', 'pgs-core' ),
					'medium'    => esc_html__( 'Medium', 'pgs-core' ),
					'large'     => esc_html__( 'Large', 'pgs-core' ),
					'full'      => esc_html__( 'Full', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'custom_img_size',
			[
				'label'       => esc_html__( 'Custom', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter image size. If corresponding size is not available with the theme, then "ciyashop-latest-post-thumbnail" size will apply.', 'pgs-core' ),
			]
		);
		
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_slides',
			array(
				'label' => esc_html__( 'Slides', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'enable_caption',
			[
				'label'        => esc_html__( 'Enable Caption', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this to enable caption on slides.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'       => esc_html__( 'Slide Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Upload only image types like JPG, JPEG, PNG No other types are supported.Please Upload maximum size of image.', 'pgs-core' ),
			)
		);
		
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'This will be displayed only if Enable Caption is selected.', 'pgs-core' ),
			]
		);
		
		$repeater->add_control(
			'title_link_enable',
			[
				'label'        => esc_html__( 'Title Link ?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add link on title.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		
		$repeater->add_control(
			'title_link_url',
			[
				'label'         => esc_html__( 'Title URL (Link)', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Add custom link on title.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'title_link_enable' => 'true',
				],
			]
		);
		
		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'This will be displayed only if Enable Caption is selected.', 'pgs-core' ),
			]
		);
		
		$repeater->add_control(
			'onclick',
			[
				'label'       => esc_html__( 'On Click Action', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'link_no',
				'description' => esc_html__( 'Select action for click event.', 'pgs-core' ),
				'options'     => [
					'link_no'     => esc_html__( 'None', 'pgs-core' ),
					'link_image'  => esc_html__( 'Image Popup', 'pgs-core' ),
					'custom_link' => esc_html__( 'Open Link', 'pgs-core' ),
				],
			]
		);
		
		$repeater->add_control(
			'custom_link',
			[
				'label'         => esc_html__( 'Custom Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Add custom link.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'     => [
					'onclick' => 'custom_link',
				],
			]
		);
		
		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			)
		);
		
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_style' => 'grid',
				],
			)
		);

		// Grid Settings

		$this->add_control(
			'grid_elements_xl',
			[
				'label'       => esc_html__( 'Columns - Extra large &ge;1200px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => [
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				],
				'condition'   => [
					'list_style' => 'grid',
				],
			]
		);
		
		$this->add_control(
			'grid_elements_lg',
			[
				'label'       => esc_html__( 'Columns - Large &ge;992px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => [
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
				],
				'condition'   => [
					'list_style' => 'grid',
				],
			]
		);
		
		$this->add_control(
			'grid_elements_md',
			[
				'label'       => esc_html__( 'Columns - Medium &ge;768px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
				],
				'condition'   => [
					'list_style' => 'grid',
				],
			]
		);
		
		$this->add_control(
			'grid_elements_sm',
			[
				'label'       => esc_html__( 'Columns - Small &ge;576px', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
				'options'     => [
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
				],
				'condition'   => [
					'list_style' => 'grid',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Slider Settings', 'pgs-core' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_style' => 'slider',
				],
			)
		);

		// Slider Settings
		
		$this->add_control(
			'show_pagination_control',
			[
				'label'        => esc_html__( 'Show Pagination Control', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to display pagination controls.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'show_prev_next_buttons',
			[
				'label'        => esc_html__( 'Show Prev/Next Buttons', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to display prev/next buttons.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'enable_infinity_loop',
			[
				'label'        => esc_html__( 'Infinity Loop', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this checkbox to enable infinity loop and display carousel in circular loop.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'slides_per_view',
			[
				'label'       => esc_html__( 'Slides per view', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '4',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'condition'   => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'slides_per_view_md',
			[
				'label'       => esc_html__( 'Slides per view ( < 1200px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				],
				'condition'   => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'slides_per_view_sm',
			[
				'label'       => esc_html__( 'Slides per view ( < 992px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'condition'   => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'slides_per_view_xs',
			[
				'label'       => esc_html__( 'Slides per view ( < 768px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'condition'   => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'slides_per_view_xx',
			[
				'label'       => esc_html__( 'Slides per view ( < 480px)', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
				'options'     => [
					'1' => '1',
					'2' => '2',
				],
				'condition'   => [
					'list_style' => 'slider',
				],
			]
		);
		
		$this->add_responsive_control(
			'slide_margin',
			[
				'label'       => esc_html__( 'Margin', 'pgs-core' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Enter margin, in pixels (px), between each item.', 'pgs-core' ),
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'     => [
					'size' => 0,
					'unit' => 'px',
				],
				'condition'   => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->end_controls_section();
	}
}
