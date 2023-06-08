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
class Product_Deal extends Widget_Controller {

	protected $widget_slug = 'product-deal';

	protected $widget_icon = 'eicon-posts-group';

	protected $keywords = array( 'product', 'deal' );

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
		return esc_html__( 'Product Deal', 'pgs-core' );
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
			'product_id',
			[
				'label'       => esc_html__( 'Product', 'pgs-core' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Please enter product id. If the Start Date is greater than the Current Date, or the End Date is less than the current date, items will not be shown on the front. Also, if the Sale Price is not entered, it will not be shown.', 'pgs-core' ),
			]
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
		
		$this->add_control(
			'counter_size',
			[
				'label'       => esc_html__( 'Counter Size', 'pgs-core' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'sm',
				'description' => esc_html__( 'Select deal counter size.', 'pgs-core' ),
				'options'     => [
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
				],
			]
		);

		$this->end_controls_section();
	}
}
