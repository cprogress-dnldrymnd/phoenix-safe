<?php
/**
 * PGS Ajax Select control.
 *
 * @package Pgs Core
 */

namespace PGSCore_Elementor\Controls;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor select2 control.
 *
 * @since 1.0.0
 */
class PGS_Ajax_Select extends Base_Data_Control {

	/**
	 * The type of control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'pgs_ajax_select';

	/**
	 * Get select control type.
	 *
	 * Retrieve the control type, in this case `select`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Enqueue emoji one area control scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the emoji one
	 * area control.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue() {
		// Scripts.
		wp_register_script( 'pgs_ajax_select', trailingslashit( PGSCORE_ELEMENTOR_URL ) . 'controls/pgs-ajax-select/pgs-ajax-select.js', array( 'jquery-elementor-select2' ), PGSCORE_VERSION, true );
		wp_localize_script(
			'pgs_ajax_select',
			'pgs_ajax_select_localize',
			array(
				'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
				'nonce'       => wp_create_nonce( 'ajax-nonce' ),
				'search_text' => esc_html__( 'Search', 'pgs-core' ),
			)
		);
		wp_enqueue_script( 'pgs_ajax_select' );
	}

	/**
	 * Get select control default settings.
	 *
	 * Retrieve the default settings of the select control. Used to return the
	 * default settings while initializing the select control.
	 *
	 * @since 2.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return array(
			'multiple'    => false,
			'source_name' => 'post_type',
			'source_type' => 'post',
		);
	}

	/**
	 * Render select control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<# var control_uid = '<?php echo esc_html( $control_uid ); ?>'; #>
		<div class="elementor-control-field elementor-control-field-{{ data.type }}">
			<# if ( data.label ) { #>
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title elementor-control-title-{{ data.type }}">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo esc_attr( $control_uid ); ?>" {{ multiple }} class="pgs-ajax-select-el" data-setting="{{ data.name }}"></select>
			</div>
		</div>
		<?php
	}
}
