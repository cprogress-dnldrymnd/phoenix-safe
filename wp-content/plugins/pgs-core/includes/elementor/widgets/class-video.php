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
class Video extends Widget_Controller {

	protected $widget_slug = 'video';

	protected $widget_icon = 'eicon-youtube';

	protected $keywords = array( 'video' );

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
		return esc_html__( 'Video', 'pgs-core' );
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
			'video_link',
			[
				'label'         => esc_html__( 'Video URL', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'description'   => sprintf(
					/* translators: %s: URL */
					wp_kses(
						__( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank"> codex page</a>)', 'pgs-core' ),
						array(
							'a' => array(
								'href'   => true,
								'target' => true,
							),
						)
					),
					'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'
				),
			]
		);
		
		$this->add_control(
			'image_source',
			[
				'label'       => esc_html__( 'Image Source', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'description' => esc_html__( 'Select Border Shape.', 'pgs-core' ),
				'options'     => [
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'video_img',
			[
				'label'       => esc_html__( 'Video Image', 'pgs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Kindly upload your required size image, as the same image will display which you upload here.', 'pgs-core' ),
				'condition'   => [
					'image_source' => 'image',
				],
			]
		);
		
		
		$this->add_control(
			'video_img_link',
			[
				'label'         => esc_html__( 'Image Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'description'   => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'condition'     => [
					'image_source' => 'link',
				],
			]
		);
		
		$this->add_control(
			'enable_opacity',
			[
				'label'        => esc_html__( 'Opacity Enable ?', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);
		
		$this->add_control(
			'opacity_color',
			[
				'label'       => esc_html__( 'Opacity Color', 'pgs-core' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Add opacity color.', 'pgs-core' ),
				'default'     => 'rgba(0, 0, 0, 0.7)',
				'selectors'   => [
					'{{WRAPPER}} .pgs-video-opacity' => 'background: {{VALUE}};',
				],
				'condition'   => [
					'enable_opacity' => 'true',
				],
			]
		);
		
		$this->add_control(
			'button_style',
			[
				'label'       => esc_html__( 'Button / Icon Type ', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'icon',
				'description' => esc_html__( 'Select any one Button / Icon Type from given dropdown.', 'pgs-core' ),
				'options'     => [
					'btn'  => esc_html__( 'Button', 'pgs-core' ),
					'icon' => esc_html__( 'Icon', 'pgs-core' ),
				],
			]
		);
		
		$this->add_control(
			'button_style_type',
			[
				'label'       => esc_html__( 'Button Styles', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select any one Button Style from given dropdown.', 'pgs-core' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'border'  => esc_html__( 'Border', 'pgs-core' ),
				],
				'condition'   => [
					'button_style' => 'btn',
				],
			]
		);
		
		$this->add_control(
			'btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add Button Text.', 'pgs-core' ),
				'condition'   => [
					'button_style' => 'btn',
				],
			]
		);
		
		$this->add_control(
			'icon_style',
			array(
				'label'       => esc_html__( 'Icon Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'default'     => 'icon-1',
				'description' => esc_html__( 'Select icon style.', 'pgs-core' ),
				'options'     => array(
					'icon-1' => array(
						'label' => esc_html__( 'Icon 1', 'pgs-core' ),
						'image' => PGSCORE_URL . 'images/shortcodes/video/video-popup-black-icon1.jpg',
					),
					'icon-2' => array(
						'label' => esc_html__( 'Icon 2', 'pgs-core' ),
						'image' => PGSCORE_URL . 'images/shortcodes/video/video-popup-black-icon2.jpg',
					),
					'icon-3' => array(
						'label' => esc_html__( 'Icon 3', 'pgs-core' ),
						'image' => PGSCORE_URL . 'images/shortcodes/video/video-popup-black-icon3.jpg',
					),
				),
				'condition'   => [
					'button_style' => 'icon',
				],
			)
		);
		
		$this->add_control(
			'button_position',
			[
				'label'       => esc_html__( 'Button / Icon Position ', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'center',
				'description' => esc_html__( 'Select any one Button / Icon position from given dropdown.', 'pgs-core' ),
				'options'     => [
					'center'      => esc_html__( 'Center', 'pgs-core' ),
					'left_bottom' => esc_html__( 'Left Bottom', 'pgs-core' ),
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_detail',
			array(
				'label' => esc_html__( 'Content', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		
		$this->add_control(
			'show_content',
			[
				'label'        => esc_html__( 'Show Content ?', 'pgs-core' ),
				'description'  => esc_html__( 'Check this checkbox to Show Content.', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);
		
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title.', 'pgs-core' ),
				'condition'   => [
					'show_content' => 'true',
				],
			]
		);
		
		$this->add_control(
			'title_element',
			[
				'label'       => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h2',
				'description' => esc_html__( 'Select title element tag.', 'pgs-core' ),
				'options'     => [
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				],
				'condition'   => [
					'show_content' => 'true',
				],
			]
		);
		
		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Description', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter description.', 'pgs-core' ),
				'condition'   => [
					'show_content' => 'true',
				],
			]
		);

		$this->end_controls_section();
	}
}
