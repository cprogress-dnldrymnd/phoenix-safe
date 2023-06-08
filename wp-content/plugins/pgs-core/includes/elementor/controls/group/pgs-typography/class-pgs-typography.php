<?php
namespace PGSCore_Elementor\Group_Controls;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use Elementor\Core\Settings\Page\Manager as PageManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor typography control.
 *
 * A base control for creating typography control. Displays input fields to define
 * the content typography including font size, font family, font weight, text
 * transform, font style, line height and letter spacing.
 *
 * @since 1.0.0
 */
class PGS_Typography extends Group_Control_Base {

	/**
	 * Fields.
	 *
	 * Holds all the typography control fields.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @static
	 *
	 * @var array Typography control fields.
	 */
	protected static $fields;

	/**
	 * Scheme fields keys.
	 *
	 * Holds all the typography control scheme fields keys.
	 * Default is an array containing `font_family` and `font_weight`.
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var array Typography control scheme fields keys.
	 */
	private static $_scheme_fields_keys = array( 'font_family', 'font_weight' );

	/**
	 * Get scheme fields keys.
	 *
	 * Retrieve all the available typography control scheme fields keys.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array Scheme fields keys.
	 */
	public static function get_scheme_fields_keys() {
		return self::$_scheme_fields_keys;
	}

	/**
	 * Get typography control type.
	 *
	 * Retrieve the control type, in this case `typography`.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return string Control type.
	 */
	public static function get_type() {
		return 'pgs_typography';
	}

	/**
	 * Init fields.
	 *
	 * Initialize typography control fields.
	 *
	 * @since 1.2.2
	 * @access protected
	 *
	 * @return array Control fields.
	 */
	protected function init_fields() {
		$fields = array();

		$kit = Plugin::$instance->kits_manager->get_active_kit_for_frontend();

		/**
		 * Retrieve the settings directly from DB, because of an open issue when a controls group is being initialized
		 * from within another group
		 */
		$kit_settings = $kit->get_meta( PageManager::META_KEY );

		$default_fonts = isset( $kit_settings['default_generic_fonts'] ) ? $kit_settings['default_generic_fonts'] : 'Sans-serif';

		if ( $default_fonts ) {
			$default_fonts = ', ' . $default_fonts;
		}

		$fields['font_family'] = array(
			'label'          => _x( 'Family', 'Typography Control', 'pgs-core' ),
			'type'           => Controls_Manager::FONT,
			'default'        => '',
			'selector_value' => 'font-family: "{{VALUE}}"' . $default_fonts . ';',
		);

		$fields['font_size'] = array(
			'label'          => _x( 'Size', 'Typography Control', 'pgs-core' ),
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => array( '%', 'px', 'em', 'rem', 'vw' ),
			'range'          => array(
				'%'  => array(
					'min' => 1,
					'max' => 200,
				),
				'px' => array(
					'min' => 1,
					'max' => 200,
				),
				'vw' => array(
					'min'  => 0.1,
					'max'  => 10,
					'step' => 0.1,
				),
			),
			'responsive'     => true,
			'selector_value' => 'font-size: {{SIZE}}{{UNIT}}',
		);

		$typo_weight_options = array(
			'' => __( 'Default', 'pgs-core' ),
		);

		foreach ( array_merge( array( 'normal', 'bold' ), range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}

		$fields['font_weight'] = array(
			'label'   => _x( 'Weight', 'Typography Control', 'pgs-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => $typo_weight_options,
		);

		$fields['text_transform'] = array(
			'label'   => _x( 'Transform', 'Typography Control', 'pgs-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''           => __( 'Default', 'pgs-core' ),
				'uppercase'  => _x( 'Uppercase', 'Typography Control', 'pgs-core' ),
				'lowercase'  => _x( 'Lowercase', 'Typography Control', 'pgs-core' ),
				'capitalize' => _x( 'Capitalize', 'Typography Control', 'pgs-core' ),
				'none'       => _x( 'Normal', 'Typography Control', 'pgs-core' ),
			),
		);

		$fields['font_style'] = array(
			'label'   => _x( 'Style', 'Typography Control', 'pgs-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''        => __( 'Default', 'pgs-core' ),
				'normal'  => _x( 'Normal', 'Typography Control', 'pgs-core' ),
				'italic'  => _x( 'Italic', 'Typography Control', 'pgs-core' ),
				'oblique' => _x( 'Oblique', 'Typography Control', 'pgs-core' ),
			),
		);

		$fields['text_decoration'] = array(
			'label'   => _x( 'Decoration', 'Typography Control', 'pgs-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => array(
				''             => __( 'Default', 'pgs-core' ),
				'underline'    => _x( 'Underline', 'Typography Control', 'pgs-core' ),
				'overline'     => _x( 'Overline', 'Typography Control', 'pgs-core' ),
				'line-through' => _x( 'Line Through', 'Typography Control', 'pgs-core' ),
				'none'         => _x( 'None', 'Typography Control', 'pgs-core' ),
			),
		);

		$fields['line_height'] = array(
			'label'           => _x( 'Line-Height', 'Typography Control', 'pgs-core' ),
			'type'            => Controls_Manager::SLIDER,
			'desktop_default' => array(
				'unit' => 'em',
			),
			'tablet_default'  => array(
				'unit' => 'em',
			),
			'mobile_default'  => array(
				'unit' => 'em',
			),
			'range'           => array(
				'px' => array(
					'min' => 1,
				),
			),
			'responsive'      => true,
			'size_units'      => array( 'px', 'em' ),
			'selector_value'  => 'line-height: {{SIZE}}{{UNIT}}',
		);

		$fields['letter_spacing'] = array(
			'label'          => _x( 'Letter Spacing', 'Typography Control', 'pgs-core' ),
			'type'           => Controls_Manager::SLIDER,
			'range'          => array(
				'px' => array(
					'min'  => -5,
					'max'  => 10,
					'step' => 0.1,
				),
			),
			'responsive'     => true,
			'selector_value' => 'letter-spacing: {{SIZE}}{{UNIT}}',
		);

		return $fields;
	}

	/**
	 * Prepare fields.
	 *
	 * Process typography control fields before adding them to `add_control()`.
	 *
	 * @since 1.2.3
	 * @access protected
	 *
	 * @param array $fields Typography control fields.
	 *
	 * @return array Processed fields.
	 */
	protected function prepare_fields( $fields ) {
		array_walk(
			$fields, function( &$field, $field_name ) {

				if ( in_array( $field_name, array( 'typography', 'popover_toggle' ), true ) ) {
					return;
				}

				$selector_value = ! empty( $field['selector_value'] ) ? $field['selector_value'] : str_replace( '_', '-', $field_name ) . ': {{VALUE}};';

				$field['selectors'] = array(
					'{{SELECTOR}}' => $selector_value,
				);
			}
		);

		return parent::prepare_fields( $fields );
	}

	/**
	 * Add group arguments to field.
	 *
	 * Register field arguments to typography control.
	 *
	 * @since 1.2.2
	 * @access protected
	 *
	 * @param string $control_id Typography control id.
	 * @param array  $field_args Typography control field arguments.
	 *
	 * @return array Field arguments.
	 */
	protected function add_group_args_to_field( $control_id, $field_args ) {
		$field_args = parent::add_group_args_to_field( $control_id, $field_args );

		$field_args['groupPrefix'] = $this->get_controls_prefix();
		$field_args['groupType']   = 'typography';

		$args = $this->get_args();

		if ( in_array( $control_id, self::get_scheme_fields_keys() ) && ! empty( $args['scheme'] ) ) {
			$field_args['scheme'] = array(
				'type'  => self::get_type(),
				'value' => $args['scheme'],
				'key'   => $control_id,
			);
		}

		return $field_args;
	}

	/**
	 * Get default options.
	 *
	 * Retrieve the default options of the typography control. Used to return the
	 * default options while initializing the typography control.
	 *
	 * @since 1.9.0
	 * @access protected
	 *
	 * @return array Default typography control options.
	 */
	protected function get_default_options() {
		return array(
			'popover' => array(
				'starter_name'  => 'typography',
				'starter_title' => _x( 'Typography', 'Typography Control', 'pgs-core' ),
				'settings'      => array(
					'render_type' => 'ui',
					'groupType'   => 'typography',
					'global'      => array(
						'active' => true,
					),
				),
			),
		);
	}
}
