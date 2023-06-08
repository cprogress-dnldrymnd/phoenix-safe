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
class Team_Members extends Widget_Controller {

	protected $widget_slug = 'team-members';

	protected $widget_icon = 'eicon-info-box';

	protected $keywords = array( 'team', 'members' );

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
		return esc_html__( 'Team Members', 'pgs-core' );
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

		$testimonial_categories = array();
		if ( function_exists( 'pgscore_get_terms' ) ) {
			$testimonial_categories = pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'team-category',
					'pad_counts' => true,
				)
			);
		}

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
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/team_members/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'pgs-core' ),
						'image' => trailingslashit( PGSCORE_URL ) . 'images/shortcodes/team_members/style-3.png',
					),
				),
			)
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'Count', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 10,
				'step'        => 1,
				'description' => esc_html__( 'Enter number of members to display.', 'pgs-core' ),
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories', 'pgs-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => array_flip( $testimonial_categories ),
				'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider',
			array(
				'label' => esc_html__( 'Slider Settings', 'pgs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_pagination_control',
			[
				'label'        => esc_html__( 'Show Pagination Control', 'pgs-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to display pagination controls.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_prev_next_buttons',
			[
				'label'        => esc_html__( 'Show Prev/Next Buttons', 'pgs-core' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Select this checkbox to display prev/next buttons.', 'pgs-core' ),
				'label_on'     => esc_html__( 'Yes', 'pgs-core' ),
				'label_off'    => esc_html__( 'No', 'pgs-core' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}
}
