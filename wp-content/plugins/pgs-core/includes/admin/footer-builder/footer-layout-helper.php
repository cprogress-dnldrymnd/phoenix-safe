<?php
/**
 * Megamenu helper functions.
 *
 * @author      Potenza Team
 * @package     ciyashop
 * @version     1.0.0
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pgscore_footer_layout_fields = array();
if ( function_exists( 'pgscore_footer_layout_fields' ) ) {
	$pgscore_footer_layout_fields = pgscore_footer_layout_fields();
}

/**
 * Get Footer fields html.
 */
?>

<div class="pgsfb-element-settings">
	<div class="pgsfb-element-settings-inner">
		<div class="pgsfb-element-settings-footer">
			<div class="pgsfb-element-settings-close"><span class="dashicons dashicons-no"></span></div>
			<div class="pgsfb-element-settings-title"><?php esc_html_e( 'Footer Settings', 'pgs-core' ); ?></div>
			<?php
			$footer_tabs = array();
			if ( $pgscore_footer_layout_fields ) {
				foreach ( $pgscore_footer_layout_fields as $field_key => $field_value ) {

					if ( isset( $field_value['group'] ) && $field_value['group'] ) {
						if ( ! in_array( $field_value['group'], $footer_tabs, true ) ) {
							array_push( $footer_tabs, $field_value['group'] );
						}
					}
				}
			}

			if ( $footer_tabs ) {
				?>
				<div class="pgsfb-edit-tabs">
				<?php
				foreach ( $footer_tabs as $tab_key => $tab_name ) {
					$tab_class = ( ! $tab_key ) ? 'pgsfb-tab-active pgsfb-tabs-title' : 'pgsfb-tabs-title';
					?>
					<div class="<?php echo esc_attr( $tab_class ); ?>" data-tab="<?php echo esc_attr( $tab_name ); ?>"><?php echo esc_html( $tab_name ); ?></div>
					<?php
				}
				?>
				</div>
				<?php
			}
			?>
		</div>
		<div class="pgsfb-element-settings-content pgsfb-element-settings-edit-content">
			<div class="pgsfb-element-edit">
				<div class="pgsfb-editor-fields">
					<?php
					$layout_settings = '';
					if ( isset( $layout_data['common_settings'] ) && $layout_data['common_settings'] ) {
						$layout_settings = $layout_data['common_settings'];
					}

					foreach ( $pgscore_footer_layout_fields as $field_key => $field_value ) {
						echo ciyashopcore_get_footer_fields_html( $field_value, $layout_settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
				<div class="pgsfb-edit-action-tabs">
					<a class="button button-primary button-large pgsfb-save-configuration"><?php esc_html_e( 'Save', 'pgs-core' ); ?></a>
					<a class="button button-secondary button-large pgsfb-close-element"><?php esc_html_e( 'Cancel', 'pgs-core' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
/**
 * Function to get the fields HTML
 */
function ciyashopcore_get_footer_fields_html( $field_args, $saved_data ) {

	$data_attr   = '';
	$saved_value = '';
	$output      = '';

	if ( isset( $field_args['classes'] ) && $field_args['classes'] ) {
		$classes = $field_args['classes'];
	}

	if ( isset( $saved_data[ $field_args['param_name'] ] ) && $saved_data[ $field_args['param_name'] ] ) {
		if ( ! is_array( $saved_data[ $field_args['param_name'] ] ) ) {
			$saved_value = $saved_data[ $field_args['param_name'] ];
		}
	}

	if ( isset( $field_args['dependency'] ) ) {
		foreach ( $field_args['dependency'] as $key => $value ) {
			if ( 'element' === $key ) {
				$element_name = 'footer_settings[common_settings][' . $value . ']';
			} elseif ( 'value' === $key ) {
				$element_value = json_encode( $value );
			}
		}
		$data_attr = "data-dependency-element='" . esc_attr( $element_name ) . "' data-dependency-value='" . esc_attr( $element_value ) . "'";
	}

	if ( ! $saved_value ) {
		if ( isset( $field_args['default'] ) ) {
			$saved_value = $field_args['default'];
		}
	}

	ob_start();
	?>
	<div class="pgsfb-field-option" data-content="<?php echo esc_attr( $field_args['group'] ); ?>" <?php echo $data_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<div class="pgsfb-field-label"><?php echo esc_html( $field_args['heading'] ); ?></div>
		<div class="pgsfb-field-input-cover <?php echo esc_attr( $field_args['type'] ); ?>">
			<?php
			switch ( $field_args['type'] ) {
				case 'radio_buttonset':
					foreach ( $field_args['options'] as $field_key => $field_value ) {
						?>
						<label class="pgsfb-label pgsfb-radio-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][' . $field_key . ']' ); ?>">
							<input type="radio" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][' . $field_key . ']' ); ?>" value="<?php echo esc_attr( $field_key ); ?>" class="pgsfb-field-input pgsfb-radio <?php echo esc_attr( $classes ); ?>" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . ']' ); ?>"<?php checked( $saved_value, $field_key ); ?>>
							<span class="pgsfb-radio-title"><?php echo esc_html( $field_value ); ?></span>
						</label>
						<?php
					}
					break;

				case 'background_settings':
					$select_options      = array();
					$background_settings = isset( $saved_data[ $field_args['param_name'] ] ) ? $saved_data[ $field_args['param_name'] ] : '';
					$hidden_class        = ( ! isset( $background_settings['bg_src'] ) || empty( $background_settings['bg_src'] ) ) ? 'hidden' : '';
					$bg_image            = ( isset( $background_settings['bg_image'] ) ) ? $background_settings['bg_image'] : '';
					$bg_src              = ( isset( $background_settings['bg_src'] ) ) ? $background_settings['bg_src'] : '';
					$bg_color            = ( isset( $background_settings['bg_color'] ) ) ? $background_settings['bg_color'] : '';
					$bg_repeat           = ( isset( $background_settings['bg_repeat'] ) ) ? $background_settings['bg_repeat'] : 'inherit';
					$bg_size             = ( isset( $background_settings['bg_size'] ) ) ? $background_settings['bg_size'] : 'inherit';
					$bg_attachment       = ( isset( $background_settings['bg_attachment'] ) ) ? $background_settings['bg_attachment'] : 'inherit';
					$bg_position         = ( isset( $background_settings['bg_position'] ) ) ? $background_settings['bg_position'] : 'inherit';
					?>

					<div class="pgsfb-background-setting-field">
						<label class="pgsfb-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_image]' ); ?>">
							<span class="pgsfb-label-title"><?php esc_html_e( 'Upload Image', 'pgs-core' ); ?></span>
						</label>
						<div class="pgsfb-field-media-cover <?php echo esc_attr( $hidden_class ); ?>">
							<img src="<?php echo esc_url( $bg_src ); ?>" alt="<?php esc_attr_e( 'Background Image', 'pgs-core' ); ?>" />
						</div>
						<input class="pgsfb-field-input button pgsfb-button button-large pgsfb-field-media media-upload" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_image]' ); ?>" type="button" value="<?php esc_html_e( 'Upload', 'pgs-core' ); ?>"/>
						<input class="pgsfb-field-input button pgsfb-button button-large pgsfb-remove-media-button <?php echo esc_attr( $hidden_class ); ?>" type="button" value="Remove"/>
						<input class="pgsfb-field-input pgsfb-field-media-id hidden" type="text" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_image]' ); ?>" value="<?php echo esc_attr( $bg_image ); ?>"/>
						<input class="pgsfb-field-input pgsfb-field-media-src hidden" type="text" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_src]' ); ?>" value="<?php echo esc_attr( $bg_src ); ?>"/>
					</div>

					<div class="pgsfb-background-setting-field">
						<label class="pgsfb-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_color]' ); ?>">
							<span class="pgsfb-label-title"><?php esc_html_e( 'Background Color', 'pgs-core' ); ?></span>
						</label>
						<input class="pgsfb-field-input pgsfb-field-colorpicker colorpicker color-picker" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_color]' ); ?>" type="text" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_color]' ); ?>" value="<?php echo esc_attr( $bg_color ); ?>"/>
					</div>

					<div class="pgsfb-background-setting-field">
						<label class="pgsfb-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_repeat]' ); ?>">
							<span class="pgsfb-label-title"><?php esc_html_e( 'Image Repeat', 'pgs-core' ); ?></span>
						</label>
						<select class="pgsfb-field-input pgsfb-field-dropdown dropdown" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_repeat]' ); ?>" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_repeat]' ); ?>">
						<?php
						$select_options = array(
							'inherit'   => esc_html__( 'Inherit', 'pgs-core' ),
							'no-repeat' => esc_html__( 'No repeat', 'pgs-core' ),
							'repeat'    => esc_html__( 'Repeat All', 'pgs-core' ),
							'repeat-x'  => esc_html__( 'Repeat Horizontally', 'pgs-core' ),
							'repeat-y'  => esc_html__( 'Repeat Vertically', 'pgs-core' ),
						);

						foreach ( $select_options as $option_key => $option_value ) {
							?>
							<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $bg_repeat, $option_key ); ?>><?php echo esc_html( $option_value ); ?></option>
							<?php
						}
						?>
						</select>
					</div>

					<div class="pgsfb-background-setting-field">
						<label class="pgsfb-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_size]' ); ?>">
							<span class="pgsfb-label-title"><?php esc_html_e( 'Image Size', 'pgs-core' ); ?></span>
						</label>
						<select class="pgsfb-field-input pgsfb-field-dropdown dropdown" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_size]' ); ?>" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_size]' ); ?>">
							<?php
							$select_options = array(
								'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
								'cover'   => esc_html__( 'Cover', 'pgs-core' ),
								'contain' => esc_html__( 'Contain', 'pgs-core' ),
							);

							foreach ( $select_options as $option_key => $option_value ) {
								?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $bg_size, $option_key ); ?>><?php echo esc_html( $option_value ); ?></option>
								<?php
							}
							?>
						</select>
					</div>

					<div class="pgsfb-background-setting-field">
						<label class="pgsfb-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_attachment]' ); ?>">
							<span class="pgsfb-label-title"><?php esc_html_e( 'Image Attachment', 'pgs-core' ); ?></span>
						</label>
						<select class="pgsfb-field-input pgsfb-field-dropdown dropdown" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_attachment]' ); ?>" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_attachment]' ); ?>">
							<?php
							$select_options = array(
								'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
								'fixed'   => esc_html__( 'Fixed', 'pgs-core' ),
								'scroll'  => esc_html__( 'Scroll', 'pgs-core' ),
							);

							foreach ( $select_options as $option_key => $option_value ) {
								?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $bg_attachment, $option_key ); ?>><?php echo esc_html( $option_value ); ?></option>
								<?php
							}
							?>
						</select>
					</div>

					<div class="pgsfb-background-setting-field">
						<label class="pgsfb-label" for="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_position]' ); ?>">
							<span class="pgsfb-label-title"><?php esc_html_e( 'Image Position', 'pgs-core' ); ?></span>
						</label>
						<select class="pgsfb-field-input pgsfb-field-dropdown dropdown" id="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_position]' ); ?>" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . '][bg_position]' ); ?>">
							<?php
							$select_options = array(
								'inherit'       => esc_html__( 'Inherit', 'pgs-core' ),
								'left top'      => esc_html__( 'Left Top', 'pgs-core' ),
								'left center'   => esc_html__( 'Left Center', 'pgs-core' ),
								'left bottom'   => esc_html__( 'Left Bottom', 'pgs-core' ),
								'center top'    => esc_html__( 'Center Top', 'pgs-core' ),
								'center center' => esc_html__( 'Center Center', 'pgs-core' ),
								'center bottom' => esc_html__( 'Center Bottom', 'pgs-core' ),
								'right top'     => esc_html__( 'Right Top', 'pgs-core' ),
								'right center'  => esc_html__( 'Right Center', 'pgs-core' ),
								'right bottom'  => esc_html__( 'Right Bottom', 'pgs-core' ),
							);

							foreach ( $select_options as $option_key => $option_value ) {
								?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $bg_position, $option_key ); ?>><?php echo esc_html( $option_value ); ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<?php
					break;

				case 'colorpicker':
					$alpha = 'false';
					if ( isset( $field_args['alpha'] ) && $field_args['alpha'] ) {
						$alpha = 'true';
					}
					?>
					<input class="pgsfb-field-input pgsfb-field-colorpicker colorpicker color-picker" data-alpha="<?php echo esc_attr( $alpha ); ?>" type="text" name="<?php echo esc_attr( 'footer_settings[common_settings][' . $field_args['param_name'] . ']' ); ?>" value="<?php echo esc_attr( $saved_value ); ?>"/>
					<?php
					break;

				case 'textarea_html':
					$settings = array(
						'textarea_rows' => 10,
						'textarea_name' => 'footer_settings[common_settings][' . $field_args['param_name'] . ']'
					);
					wp_editor( $saved_value, $field_args['param_name'], $settings );
					break;
			}
			if ( isset( $field_args['description'] ) && $field_args['description'] ) {
				?>
				<span class="pgsfb-description"><?php echo wp_kses( $field_args['description'], pgscore_allowed_html( array( 'a', 'b', 'span' ) ) ); ?></span>
				<?php
			}
			?>
		</div>
	</div>
	<?php
	$output .= ob_get_clean();

	return $output;
}
