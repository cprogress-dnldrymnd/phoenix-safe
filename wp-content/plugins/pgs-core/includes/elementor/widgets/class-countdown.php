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
class Countdown extends Widget_Controller {

	protected $widget_slug = 'countdown';
	
	protected $widget_icon = 'eicon-countdown';

	protected $keywords = array( 'countdown' );

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
		return esc_html__( 'Countdown', 'pgs-core' );
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
			'counter_style',
			array(
				'label'       => esc_html__( 'Countdown Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select countdown style.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_1.jpg',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_2.jpg',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_3.jpg',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_4.jpg',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_5.jpg',
					),
					'style-6' => array(
						'label' => esc_html__( 'Style 6', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_6.jpg',
					),
					'style-7' => array(
						'label' => esc_html__( 'Style 7', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_7.jpg',
					),
					'style-8' => array(
						'label' => esc_html__( 'Style 8', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_8.jpg',
					),
					'style-9' => array(
						'label' => esc_html__( 'Style 9', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_9.jpg',
					),
					'style-10' => array(
						'label' => esc_html__( 'Style 10', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/banner/deal/style_10.jpg',
					),
				),
			)
		);
		
		$this->add_control(
			'countdown_date',
			[
				'label'         => esc_html__( 'Countdown Date', 'pgs-core' ),
				'type'           => Controls_Manager::DATE_TIME,
				'description'    => esc_html__( 'Enter coundown date.', 'pgs-core' ),
				'picker_options' => array(					
					'enableTime' => false,
				),
			]
		);
		
		$this->add_control(
			'countdown_color_scheme',
			array(
				'label'       => esc_html__( 'Countdown Color Scheme', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Slect countdown color scheme.', 'pgs-core' ),
				'default'     => 'dark',
				'options'     => array(
					'dark'  => esc_html__( 'Dark', 'pgs-core' ),
					'light' => esc_html__( 'Light', 'pgs-core' ),
				),
			)
		);

		$this->add_control(
			'expire_message',
			[
				'label'       => esc_html__( 'Expire Message', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This offer has expired!', 'pgs-core' ),
				'description' => esc_html__( 'Enter message to display, instead of date counter, when deal is expired.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();
	}
}
