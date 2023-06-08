<?php
/**
 * PGSCore Elementor class.
 *
 * @package pgs-core/elementor
 * @since   5.0.0
 */

namespace PGSCore_Elementor;

use Elementor;
use Elementor\Plugin;
use PGSCore_Elementor\Widget_Controller;
use PGSCore_Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class PGSCore_Elementor.
 *
 * @since   5.0.0
 */
class PGSCore_Elementor {

	/**
	 * Instance
	 *
	 * @since 5.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 5.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Register plugin action hooks and filters.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function __construct() {
		// Register category.
		add_action( 'elementor/init', array( $this, 'register_category' ) );

		// Register controls.
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_group_controls' ) );

		// Register editor scripts/styles.
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_scripts' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_styles' ) );

		// Register widgets.
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		// Register additional icons.
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'register_additional_icons' ) );
	}

	/**
	 * Register potenza category for elementor if not exists
	 *
	 * @return void
	 */
	public function register_category() {

		$elements_manager = Elementor\Plugin::instance()->elements_manager;

		$elements_manager->add_category(
			PGSCORE_ELEMENTOR_CAT,
			array(
				'title' => esc_html__( 'Potenza', 'pgs-core' ),
				'icon'  => 'font',
			)
		);
	}

	public function register_controls( $controls_manager ) {
		$controls = $this->get_controls_list();

		// Its is now safe to include Control files.
		$available_controls = $this->include_controls_files( $controls );

		foreach ( $available_controls as $control_id => $control_data ) {
			$control_class = false;

			if ( is_array( $control_data ) && isset( $control_data['class'] ) && empty( $control_data['class'] ) ) {
				$control_class = $control_data['class'];
			} else {
				$control_class = '\PGSCore_Elementor\Controls\\' . $control_data;
			}

			if ( $control_class ) {
				$controls_manager->register( new $control_class() );
			}
		}

	}

	private function get_controls_list() {
		// Elementor Controls List.
		$controls = array(
			'pgs_select_image' => 'PGS_Select_Image',
			'pgs_typography'   => 'PGS_Typography',
			'pgs_ajax_select'  => 'PGS_Ajax_Select',
		);

		$controls = apply_filters( 'pgscore_elementor_controls', $controls );

		return $controls;
	}

	/**
	 * Include Controls files
	 *
	 * Load controls files
	 *
	 * @since 5.0.0
	 * @access private
	 */
	private function include_controls_files( $controls = array() ) {
		$available_controls = $controls;

		foreach ( $controls as $control_id => $control_data ) {
			$control_path = '';
			if ( is_array( $control_data ) && isset( $control_data['path'] ) && empty( $control_data['path'] ) ) {
				$control_path = $control_data['path'];
			} else {
				$control_filename = str_replace( '_', '-', "controls/{$control_id}/class-{$control_id}.php" );
				$control_path     = trailingslashit( PGSCORE_ELEMENTOR_PATH ) . $control_filename;
			}

			if ( $control_path && file_exists( $control_path ) ) {
				require_once $control_path;
			} else {
				unset( $available_controls[ $control_id ] );
			}
		}

		return $available_controls;
	}


	public function register_group_controls( $controls_manager ) {
		$controls = $this->get_group_controls_list();

		// Its is now safe to include Control files.
		$available_controls = $this->include_group_controls_files( $controls );

		foreach ( $available_controls as $control_id => $control_data ) {
			$control_class = false;

			if ( is_array( $control_data ) && isset( $control_data['class'] ) && empty( $control_data['class'] ) ) {
				$control_class = $control_data['class'];
			} else {
				$control_class = '\PGSCore_Elementor\Group_Controls\\' . $control_data;
			}

			if ( $control_class ) {
				$controls_manager->add_group_control( $control_id, new $control_class() );
			}
		}

	}

	private function get_group_controls_list() {
		// Elementor Group Controls List.
		$controls = array(
			'pgs_typography' => 'PGS_Typography',
		);

		$controls = apply_filters( 'pgscore_elementor_group_controls', $controls );

		return $controls;
	}

	/**
	 * Include Controls files
	 *
	 * Load controls files
	 *
	 * @since 5.0.0
	 * @access private
	 */
	private function include_group_controls_files( $controls = array() ) {
		$available_controls = $controls;

		foreach ( $controls as $control_id => $control_data ) {
			$control_path = '';
			if ( is_array( $control_data ) && isset( $control_data['path'] ) && empty( $control_data['path'] ) ) {
				$control_path = $control_data['path'];
			} else {
				$control_filename = str_replace( '_', '-', "controls/group/{$control_id}/class-{$control_id}.php" );
				$control_path     = trailingslashit( PGSCORE_ELEMENTOR_PATH ) . $control_filename;
			}

			if ( $control_path && file_exists( $control_path ) ) {
				require_once $control_path;
			} else {
				unset( $available_controls[ $control_id ] );
			}
		}

		return $available_controls;
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function editor_scripts() {
		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		add_filter( 'script_loader_tag', array( $this, 'editor_scripts_as_a_module' ), 10, 2 );

		wp_enqueue_script( 'pgscore-elementor-editor', trailingslashit( PGSCORE_ELEMENTOR_URL ) . '/assets/js/editor/pgscore-elementor-editor.js', array( 'elementor-editor' ), '1.2.1', true );
	}

	/**
	 * Editor styles.
	 *
	 * Enqueue plugin styles integrations for Elementor editor.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function editor_styles() {
		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_register_style( 'pgscore-elementor-editor', trailingslashit( PGSCORE_ELEMENTOR_URL ) . 'assets/css/editor/pgscore-elementor-editor' . $direction_suffix . $suffix . '.css', array(), false );
		wp_enqueue_style( 'pgscore-elementor-themefy', get_parent_theme_file_uri( '/includes/icons/themefy/themefy.css' ), array(), false );
		wp_enqueue_style( 'pgscore-elementor-flaticon', get_parent_theme_file_uri( '/includes/icons/flaticon/flaticon.css' ), array(), false );
		wp_enqueue_style( 'pgscore-elementor-editor' );
	}

	/**
	 * Preview styles.
	 *
	 * Enqueue plugin styles for Elementor preview.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function preview_styles() {
		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_register_style( 'pgscore-elementor-preview', trailingslashit( PGSCORE_ELEMENTOR_URL ) . 'assets/css/preview/pgscore-elementor-preview' . $direction_suffix . $suffix . '.css', array(), false );
		wp_enqueue_style( 'pgscore-elementor-themefy', get_parent_theme_file_uri( '/includes/icons/themefy/themefy.css' ), array(), false );
		wp_enqueue_style( 'pgscore-elementor-flaticon', get_parent_theme_file_uri( '/includes/icons/flaticon/flaticon.css' ), array(), false );
		wp_enqueue_style( 'pgscore-elementor-preview' );
	}

	/**
	 * Force load editor script as a module.
	 *
	 * @since 5.0.0
	 *
	 * @param string $tag      Enqueue tag.
	 * @param string $handle   Enqueue handle.
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'pgscore-elementor-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	/**
	 * Include Widgets files.
	 *
	 * Load widgets files.
	 *
	 * @since 5.0.0
	 * @access private
	 *
	 * @param array $widgets  Array of widgets.
	 */
	private function include_widgets_files( $widgets = array() ) {
		$available_widgets = $widgets;

		foreach ( $widgets as $widget_id => $widget_data ) {
			$widget_path = '';
			if ( is_array( $widget_data ) && isset( $widget_data['path'] ) && empty( $widget_data['path'] ) ) {
				$widget_path = $widget_data['path'];
			} else {
				$widget_path = trailingslashit( PGSCORE_ELEMENTOR_PATH ) . "widgets/class-{$widget_id}.php";
			}

			if ( $widget_path && file_exists( $widget_path ) ) {
				require_once $widget_path;
			} else {
				unset( $available_widgets[ $widget_id ] );
			}
		}

		return $available_widgets;
	}

	private function get_widgets_list() {

		// Elementor Widgets List.
		$widgets = array(
			'address-block'    => 'Address_Block',
			'banner'           => 'Banner',
			'clients'          => 'Clients',
			'countdown'        => 'Countdown',
			'image-slider'     => 'Image_Slider',
			'infobox'          => 'Infobox',
			'instagram'        => 'Instagram',
			'kite-box'         => 'Kite_Box',
			'lists'            => 'Lists',
			'newsletter'       => 'Newsletter',
			'opening-hours'    => 'Opening_Hours',
			'portfolio'        => 'Portfolio',
			'recent-posts'     => 'Recent_Posts',
			'social-icons'     => 'Social_Icons',
			'team-members'     => 'Team_Members',
			'testimonials'     => 'Testimonials',
			'vertical-menu'    => 'Vertical_Menu',
			'progress-bar'     => 'Progress_Bar',
			'search'           => 'Search',
			'section-title'    => 'Section_Title',
			'button'           => 'Button',
			'timeline'         => 'Timeline',
			'image-gallery'    => 'Image_Gallery',
			'video'            => 'Video',
			'callout'          => 'Callout',
			'hotspot'          => 'Hotspot',
			'counter'          => 'Counter',
			'static-block'     => 'Static_Block',
			'menu-list'        => 'Menu_List',
			'smart-image-view' => 'Smart_Image_View',
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$widgets = array_merge(
				$widgets,
				array(
					'categorybox'                => 'Categorybox',
					'product-category-items'     => 'Product_Category_Items',
					'multi-tab-products-listing' => 'Multi_Tab_Products_Listing',
					'product-deal'               => 'Product_Deal',
					'product-deals'              => 'Product_Deals',
					'product-showcase'           => 'Product_Showcase',
					'product-listing'            => 'Product_Listing',
					'single-product-slider'      => 'Single_Product_Slider',
					'pricing-box'                => 'Pricing_Box',
				)
			);
		}

		$widgets = apply_filters( 'pgscore_elementor_widgets', $widgets );

		return $widgets;

	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function register_widgets() {

		$widgets = $this->get_widgets_list();

		require_once trailingslashit( PGSCORE_ELEMENTOR_PATH ) . 'class-widget-controller.php';

		// Its is now safe to include Widgets files.
		$available_widgets = $this->include_widgets_files( $widgets );

		foreach ( $available_widgets as $widget_id => $widget_data ) {
			$widget_class = false;

			if ( is_array( $widget_data ) && isset( $widget_data['class'] ) && empty( $widget_data['class'] ) ) {
				$widget_class = $widget_data['class'];
			} else {
				$widget_class = '\PGSCore_Elementor\Widgets\\' . $widget_data;
			}

			if ( $widget_class ) {
				\Elementor\Plugin::instance()->widgets_manager->register( new $widget_class() );
			}
		}

	}

	/**
	 * Register Additional Icons
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function register_additional_icons( $settings ) {

		// Open Iconic
		$settings['flaticon'] = [
			'name'          => 'flaticon',
			'label'         => esc_html__( 'Flaticon', 'pgs-core' ),
			'url'           => '',
			'enqueue'       => '',
			'prefix'        => '',
			'displayPrefix' => '',
			'labelIcon'     => 'glyph-icon pgsicon-ecommerce-locked',
			'ver'           => '1.0',
			'fetchJson'     => PGSCORE_URL . 'includes/elementor/assets/js/icons/flaticon.js',
		];

		// Themefy Icons
		$settings['themefy'] = [
			'name'          => 'themefy',
			'label'         => esc_html__( 'Themefy Icons', 'pgs-core' ),
			'url'           => '',
			'enqueue'       => '',
			'prefix'        => '',
			'displayPrefix' => '',
			'labelIcon'     => 'ti-arrow-up',
			'ver'           => '1.0',
			'fetchJson'     => PGSCORE_URL . 'includes/elementor/assets/js/icons/themefy.js',
		];

		// Linecons
		$settings['linecons'] = [
			'name'          => 'linecons',
			'label'         => esc_html__( 'Linecons', 'pgs-core' ),
			'url'           => get_parent_theme_file_uri( '/includes/icons/linecons/linecons.css' ),
			'enqueue'       => [ get_parent_theme_file_uri( '/includes/icons/linecons/linecons.css' ) ],
			'prefix'        => '',
			'displayPrefix' => '',
			'labelIcon'     => 'vc_li vc_li-heart',
			'ver'           => '1.0',
			'fetchJson'     => PGSCORE_URL . 'includes/elementor/assets/js/icons/linecons.js',
		];

		return $settings;
	}

}

// Instantiate PGSCore_Elementor Class.
PGSCore_Elementor::instance();
