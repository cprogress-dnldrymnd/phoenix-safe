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
class Pricing_Box extends Widget_Controller {

	protected $widget_slug = 'pricing-box';

	protected $widget_icon = 'eicon-price-table';

	protected $keywords = array( 'pricing' );

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
		return esc_html__( 'Pricing Box', 'pgs-core' );
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
				'label'       => esc_html__( 'Style', 'pgs-core' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'style of timeline item display.', 'pgs-core' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/pricing/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/pricing/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/pricing/style-3.png',
					),
				),
			)
		);
		
		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => wp_kses( __( 'Enter plan title.<br><strong><span class="ciyashop-red">Note</span> : Plan title must be required to display pricing plan.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			]
		);
		
		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Sub Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter pricing sub title.', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'price',
			[
				'label'       => esc_html__( 'Price', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter price. e.g. $10.00', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'frequency',
			[
				'label'       => esc_html__( 'Frequency', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter price. e.g.Per Month', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'features',
			[
				'label'       => esc_html__( 'Features', 'pgs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => wp_kses( __( 'Enter features included in the plan.<br><strong><span class="ciyashop-red">Note</span> : Features must be required to display pricing plan. Press enter to each new feature.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			]
		);
		
		$this->add_control(
			'btntext',
			[
				'label'       => esc_html__( 'Button Title', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter button title.', 'pgs-core' ),
			]
		);
		
		$this->add_control(
			'btnlink',
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
			]
		);
		
		$this->add_control(
			'bestseller',
			[
				'label'        => esc_html__( 'Best Seller', 'pgs-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to display the table as best-seller/featured.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'true',
			]
		);
		
		$this->add_control(
			'bestseller_label',
			[
				'label'       => esc_html__( 'Best Seller Label', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Best seller label text like "Best Seller, Trending, Best Plan".', 'pgs-core' ),
				'condition' => array(
					'bestseller' => 'true',
				),
			]
		);

		$this->end_controls_section();
	}
}
