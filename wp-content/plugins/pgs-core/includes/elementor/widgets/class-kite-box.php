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
class Kite_Box extends Widget_Controller {

	protected $widget_slug = 'kite-box';

	protected $widget_icon = 'eicon-thumbnails-half';

	protected $keywords = array( 'kite' );

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
		return esc_html__( 'Kite Box', 'pgs-core' );
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
		global $ciyashop_options;
		
		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$kitebox_images = new \Elementor\Repeater();
		
		$kitebox_images->add_control(
			'content_image',
			[
				'label'       => esc_html__( 'Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Upload image.', 'pgs-core' ),
				'dynamic'     => [
					'active' => false,
				],
			]
		);
		
		$kitebox_images->add_control(
			'image_title',
			array(
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
			)
		);
		
		$kitebox_images->add_control(
			'kitebox_image_enable_link',
			[
				'label'        => esc_html__( 'Enable Button', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to add link on banner.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		
		$kitebox_images->add_control(
			'kite_box_image_button_text',
			array(
				'label'       => esc_html__( 'Button Text', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => array(
					'kitebox_image_enable_link' => 'true',
				),
			)
		);
		
		$kitebox_images->add_control(
			'kite_box_content_button_link',
			[
				'label'         => esc_html__( 'Button Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Select/enter url.', 'pgs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => array(
					'kitebox_image_enable_link' => 'true',
				),
			]
		);
		
		$this->add_control(
			'kitebox_images',
			array(
				'label'       => esc_html__( 'Add maximum four images.', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $kitebox_images->get_controls(),
				'title_field' => '{{{ image_title }}}',
			)
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_content',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$kitebox_content = new \Elementor\Repeater();
		
		$kitebox_content->add_control(
			'content_title',
			array(
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
			)
		);
		
		$kitebox_content->add_control(
			'content_description',
			array(
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
			)
		);
		
		$this->add_control(
			'kitebox_content',
			array(
				'label'       => esc_html__( 'Add maximum three elements.', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $kitebox_content->get_controls(),
				'title_field' => '{{{ content_title }}}',
			)
		);

		$this->end_controls_section();
	}
}
