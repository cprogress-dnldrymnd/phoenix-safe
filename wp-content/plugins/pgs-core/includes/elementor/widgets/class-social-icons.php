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
class Social_Icons extends Widget_Controller {

	protected $widget_slug = 'social-icons';

	protected $widget_icon = 'eicon-social-icons';

	protected $keywords = array( 'social', 'icons' );

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
		return esc_html__( 'Social Icons', 'pgs-core' );
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
			[
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select style. ', 'pgs-core' ),
				'options'     => [
					'default'    => esc_html__( 'Default', 'pgs-core' ),
					'border'     => esc_html__( 'Border', 'pgs-core' ),
					'flat-color' => esc_html__( 'Flat Color', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'shape',
			[
				'label'       => esc_html__( 'Shape', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'square',
				'description' => esc_html__( 'Select shape.', 'pgs-core' ),
				'options'     => [
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'Round'   => esc_html__( 'Round', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label'       => esc_html__( 'Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'medium',
				'description' => esc_html__( 'Select icon display size.', 'pgs-core' ),
				'options'     => [
					'small'       => esc_html__( 'Small', 'pgs-core' ),
					'medium'      => esc_html__( 'Medium', 'pgs-core' ),
					'large'       => esc_html__( 'Large', 'pgs-core' ),
					'extra-large' => esc_html__( 'Extra Large', 'pgs-core' ),
				],
			]
		);

		$this->add_control(
			'hover_style',
			[
				'label'       => esc_html__( 'Hover Style', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select hover style.', 'pgs-core' ),
				'options'     => [
					'default'     => esc_html__( 'Default', 'pgs-core' ),
					'color-hover' => esc_html__( 'Color Hover', 'pgs-core' )
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_icon',
			array(
				'label' => esc_html__( 'Icon', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'link',
			[
				'label'         => esc_html__( 'Profile Link', 'pgs-core' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$repeater->add_control(
			'social_icon',
			[
				'label'       => esc_html__( 'Icon', 'pgs-core' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'elementor',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
				],
			]
		);

		$this->add_control(
			'list_items',
			array(
				'label'  => esc_html__( 'List Items', 'pgs-core' ),
				'type'   => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			)
		);

		$this->end_controls_section();
	}
}
