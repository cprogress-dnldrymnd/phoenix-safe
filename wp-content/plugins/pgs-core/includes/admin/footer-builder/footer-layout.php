<?php
/**
 * Footer Builder layout.
 *
 * @package ciyashop Core
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;

$register_sidebars  = $GLOBALS['wp_registered_sidebars'];
$layout_data        = array();
$footer_layout_data = $layout_data;
$page_title_escaped = esc_html__( 'Add New Footer Layout', 'pgs-core' );
$footer_id          = 0;

if ( isset( $_GET['footer_id'] ) ) {
	$page_title_escaped = esc_html__( 'Edit Footer Layout', 'pgs-core' );
	$footer_id          = (int) $_GET['footer_id'];
	$table_name         = $wpdb->prefix . 'cs_footer_builder';

	if ( $wpdb->get_var( 'SHOW TABLES LIKE "' . $wpdb->prefix . 'cs_footer_builder"' ) === $table_name ) {
		$footer_layout_data = $wpdb->get_results(
			$wpdb->prepare(
				'
				SELECT * FROM ' . $wpdb->prefix . 'cs_footer_builder
				WHERE id = %d
				',
				$footer_id
			)
		);

		if ( ! empty( $footer_layout_data ) ) {
			$footer_layout_data = $footer_layout_data[0];
			$layout_data        = unserialize( $footer_layout_data->value );
		}
	}
}

$footer_columns_max = isset( $layout_data['footer_columns_max'] ) ? $layout_data['footer_columns_max'] : '';
?>
<div class="wrap">
	<?php
	// This variable has been safely escaped in the following file: ciyashop-core/includes/admin/footer-builder/footer-layout.php Line: 16 and 20
	?>
	<h1><?php echo $page_title_escaped; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
	<hr class="wp-footer-end"/>
	<div class="poststuff">
		<form method="post" action="#" class="pgsfb-footer-settings" id="pgsfb-footer-settings">
			<div class="footer-layout-cover">
				<div class="item-cover">
					<span class="dashicons dashicons-edit"></span>
					<input class="layout-title" type="text" name="footer_settings[layout_name]" placeholder="<?php esc_attr_e( 'Enter layout name*', 'pgs-core' ); ?>" value="<?php echo isset( $footer_layout_data->name ) ? esc_attr( $footer_layout_data->name ) : ''; ?>"/>
				</div>
				<hr/>
				<div class="pgsfb-footer-builder-container">
					<div class="pgsfb-elements-container">
						<div class="pgsfb-device-elements">
							<span class="pgsfb-devices-toolbar-title"><?php esc_html_e( 'Element Sidebars', 'pgs-core' ); ?></i>
								<div class="whb-info-container">
									<i class="dashicons dashicons-info"></i>
									<div class="pgsfb-info">
										<?php esc_html_e( 'Drag below elements in your desired section', 'pgs-core' ); ?>
									</div>
								</div>
							</span>
							<div class="pgsfb-elements-list">
								<?php
								foreach ( $register_sidebars as $register_sidebar ) {
									$element_class = '';
									$element_id    = isset( $register_sidebar['id'] ) ? $register_sidebar['id'] : '';
									$element_title = isset( $register_sidebar['name'] ) ? $register_sidebar['name'] : '';

									$element_class = 'pgsfb-element-content pgsfb-element-drag';
									if ( $element_id ) {
										?>
										<div class="pgsfb-draggable-item">
											<div class="<?php echo esc_attr( $element_class ); ?>" data-element_id="<?php echo esc_attr( $element_id ); ?>" data-element_title="<?php echo esc_attr( $element_title ); ?>">
												<div class="pgsfb-element-content-inner">
													<span class="pgsfb-element-title"><?php echo esc_html( $element_title ); ?></span>
												</div>
												<div class="pgsfb-element-content-action">
													<button class="pgsfb-icon-button pgsfb-remove-btn"><span class="ti-trash"></span></button>
												</div>
											</div>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="pgsfb-structure">
						<div class="pgsfb-action-cover">
							<span class="pgsfb-element-title pgsfb-footer-configure"><?php esc_html_e( 'Footer Settings', 'pgs-core' ); ?>
								<div class="pgsfb-element-action">
									<div class="pgsfb-icon-button pgsfb-add-button">
										<span class="dashicons dashicons-edit"></span>
									</div>
								</div>
							</span>
							<button class="button button-primary button-large pgsfb-save" data-footer_id="<?php echo esc_attr( $footer_id ); ?>"><span class="ti-save"></span><?php esc_html_e( 'Save Changes', 'pgs-core' ); ?></button>
						</div>
						<div class="pgsfb-settings">
							<div class="pgsfb-row pgsfb-elements-cover">
								<div class="pgsfb-footer-columns-slider-container">
									<label class="pgsfb-label" for="pgsfb-footer-columns">
										<span class="pgsfb-label-title"><?php esc_html_e( 'Column', 'pgs-core' ); ?></span>
									</label>
									<div id="pgsfb-footer-columns-slider">
										<div id="footer-columns-slider-handle" class="ui-slider-handle"></div>
										<input type="hidden" id="pgsfb-footer-columns" name="footer_settings[footer_columns_max]" value="<?php echo esc_attr( $footer_columns_max ); ?>">
									</div>
								</div>
								<div class="pgsfb-footer-column-settings">
								<?php

								if ( isset( $layout_data['columns_settings'] ) && $layout_data['columns_settings'] ) {
									foreach ( $layout_data['columns_settings'] as $field_key => $field_value ) {

										$hide_for_mobile                 = isset( $field_value['hide_for_mobile'] ) ? $field_value['hide_for_mobile'] : '';
										$hide_for_desktop                = isset( $field_value['hide_for_desktop'] ) ? $field_value['hide_for_desktop'] : '';
										$hide_for_tablet                 = isset( $field_value['hide_for_tablet'] ) ? $field_value['hide_for_tablet'] : '';
										$footer_sidebar                  = isset( $field_value['footer_sidebar'] ) ? $field_value['footer_sidebar'] : '';
										$footer_columns                  = isset( $field_value['footer_columns'] ) ? $field_value['footer_columns'] : '';
										$footer_columns_tablet           = isset( $field_value['footer_columns_tablet'] ) ? $field_value['footer_columns_tablet'] : '';
										$footer_columns_tablet_landscape = isset( $field_value['footer_columns_tablet_landscape'] ) ? $field_value['footer_columns_tablet_landscape'] : '';
										$columns_alignment               = isset( $field_value['columns_alignment'] ) ? $field_value['columns_alignment'] : '';
										?>
										<div class="pgsfb-footer-column-setting">
											<div class="pgsfb-footer-column-setting-inner">
												<div class="pgsfb-footer-input-field">
													<label class="pgsfb-label"><span class="pgsfb-label-title"><?php esc_html_e( 'Footer Column', 'pgs-core' ); ?></span></label>
													<div class="pgsfb-column-desktop">
														<i class="dashicons dashicons-desktop"></i>
														<select name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][footer_columns]">
															<?php
															$column_class = '';
															$column_name  = '';
															for ( $column = 1; $column <= 12; $column++ ) {
																$column_class = $column . esc_html__( '-column', 'pgs-core' );
																$column_name  = $column . esc_html__( ' column', 'pgs-core' );
																?>
																<option class="<?php echo esc_attr( $column_class ); ?>" value="<?php echo esc_attr( $column ); ?>" <?php selected( $footer_columns, $column ); ?> ><?php echo esc_html( $column_name ); ?></option>
																<?php
															}
															?>
														</select>
													</div>
													<div class="pgsfb-column-tablet-landscape">
														<i class="dashicons dashicons-tablet"></i>
														<select name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][footer_columns_tablet_landscape]">
															<?php
															$column_class = '';
															$column_name  = '';
															for ( $column = 1; $column <= 12; $column++ ) {
																$column_class = $column . esc_html__( '-column', 'pgs-core' );
																$column_name  = $column . esc_html__( ' column', 'pgs-core' );
																?>
																<option class="<?php echo esc_attr( $column_class ); ?>" value="<?php echo esc_attr( $column ); ?>" <?php selected( $footer_columns_tablet_landscape, $column ); ?> ><?php echo esc_html( $column_name ); ?></option>
																<?php
															}
															?>
														</select>
													</div>
													<div class="pgsfb-column-tablet">
														<i class="dashicons dashicons-tablet"></i>
														<select name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][footer_columns_tablet]">
															<?php
															$column_class = '';
															$column_name  = '';
															for ( $column = 1; $column <= 12; $column++ ) {
																$column_class = $column . esc_html__( '-column', 'pgs-core' );
																$column_name  = $column . esc_html__( ' column', 'pgs-core' );
																?>
																<option class="<?php echo esc_attr( $column_class ); ?>" value="<?php echo esc_attr( $column ); ?>" <?php selected( $footer_columns_tablet, $column ); ?> ><?php echo esc_html( $column_name ); ?></option>
																<?php
															}
															?>
														</select>
													</div>
													<span class="pgsfb-description"><?php esc_html_e( 'Select the footer column', 'pgs-core' ); ?></span>
												</div>
												<div class="pgsfb-footer-input-field">
													<label class="pgsfb-label">
														<span class="pgsfb-label-title"><?php esc_html_e( 'Column Alignment', 'pgs-core' ); ?></span>
													</label>
													<div class="ciyashop-buttonset">
														<div class="buttonset-field-container">
															<input id="footer_columns_settings_left[<?php echo esc_attr( $field_key ); ?>]" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][columns_alignment]" class="hidden" type="radio" value="left" <?php checked( $columns_alignment, 'left' ); ?> />
															<label for="footer_columns_settings_left[<?php echo esc_attr( $field_key ); ?>]">
																<i class="dashicons dashicons-editor-alignleft"></i>
															</label>
														</div>

														<div class="buttonset-field-container">
															<input id="footer_columns_settings_center[<?php echo esc_attr( $field_key ); ?>]" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][columns_alignment]" class="hidden" type="radio" value="center" <?php checked( $columns_alignment, 'center' ); ?> />
															<label for="footer_columns_settings_center[<?php echo esc_attr( $field_key ); ?>]">
																<i class="dashicons dashicons-editor-aligncenter"></i>
															</label>
														</div>

														<div class="buttonset-field-container">
															<input id="footer_columns_settings_right[<?php echo esc_attr( $field_key ); ?>]" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][columns_alignment]" class="hidden" type="radio" value="right" <?php checked( $columns_alignment, 'right' ); ?> />
															<label for="footer_columns_settings_right[<?php echo esc_attr( $field_key ); ?>]">
																<i class="dashicons dashicons-editor-alignright"></i>
															</label>
														</div>
													</div>
													<span class="pgsfb-description"><?php esc_html_e( 'Select column alignment', 'pgs-core' ); ?></span>
												</div>
												<div class="pgsfb-footer-input-field">
													<label class="pgsfb-label" for="sidebar">
														<span class="pgsfb-label-title"><?php esc_html_e( 'Footer Sidebar', 'pgs-core' ); ?></span>
													</label>
													<?php
													$dropable_classs = 'pgsfb-element-column pgsfb-element-contents pgsfb-element-droppable';
													if ( ! $footer_sidebar ) {
														$dropable_classs .= ' pgsfb-droppable-active';
													}
													?>
													<div class="<?php echo esc_attr( $dropable_classs ); ?>" data-placeholder="<?php esc_attr_e( 'Drop element here', 'pgs-core' ); ?>">
														<?php
														if ( isset( $register_sidebars[ $footer_sidebar ] ) && $register_sidebars[ $footer_sidebar ] ) {
															?>
															<div class="pgsfb-draggable-item">
																<div class="pgsfb-element-content" data-element_id="<?php echo esc_attr( $footer_sidebar ); ?>">
																	<div class="pgsfb-element-content-inner">
																		<span class="pgsfb-element-title"><?php echo esc_html( $register_sidebars[ $footer_sidebar ]['name'] ); ?></span>
																	</div>
																	<div class="pgsfb-element-content-action">
																		<button class="pgsfb-icon-button pgsfb-remove-btn" data-tip="Remove"><span class="ti-trash"></span></button>
																	</div>
																</div>
															</div>
															<?php
														}
														?>
														<input class="pgsfb-element-column-input" type="hidden" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][footer_sidebar]" value="<?php echo esc_attr( $footer_sidebar ); ?>">
													</div>
													<span class="pgsfb-description"><?php esc_html_e( 'Drag the sidebar here', 'pgs-core' ); ?></span>
												</div>
												<div class="pgsfb-footer-input-field input-type-checkbox">
													<i class="dashicons dashicons-desktop"></i>
													<label class="pgsfb-label">
														<?php esc_html_e( 'Hide For Desktop', 'pgs-core' ); ?>
														<input type="checkbox" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][hide_for_desktop]" value="1" <?php checked( $hide_for_desktop, 1 ); ?>>
													</label>
												</div>
												<div class="pgsfb-footer-input-field input-type-checkbox">
													<i class="dashicons dashicons-tablet"></i>
													<label class="pgsfb-label">
														<?php esc_html_e( 'Hide For Tablet', 'pgs-core' ); ?>
														<input type="checkbox" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][hide_for_tablet]" value="1" <?php checked( $hide_for_tablet, 1 ); ?>>
													</label>
												</div>
												<div class="pgsfb-footer-input-field input-type-checkbox">
													<i class="dashicons dashicons-smartphone"></i>
													<label class="pgsfb-label">
														<?php esc_html_e( 'Hide For Mobile', 'pgs-core' ); ?>
														<input type="checkbox" name="footer_settings[columns_settings][<?php echo esc_attr( $field_key ); ?>][hide_for_mobile]" value="1" <?php checked( $hide_for_mobile, 1 ); ?>>
													</label>
												</div>
											</div>
										</div>
										<?php
									}
								}
								?>
								</div>
							</div>
						</div>
					</div>
					<div class="pgsfb-elements-settings">
						<?php
						require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/footer-builder/footer-layout-helper.php';
						?>
					</div>
					<hr/>
				</div>
			</div>
		</form>
	</div>
</div>
<script id="pgsfb-column-settings-template" type="text/html">
	<div class="pgsfb-footer-column-setting">
		<div class="pgsfb-footer-column-setting-inner">
			<div class="pgsfb-footer-input-field">
				<label class="pgsfb-label"><span class="pgsfb-label-title"><?php esc_html_e( 'Footer Column', 'pgs-core' ); ?></span></label>
				<div class="pgsfb-column-desktop">
					<i class="dashicons dashicons-desktop"></i>
					<select name="footer_settings[columns_settings][{{column_index}}][footer_columns]">
						<?php
						$column_class = '';
						$column_name  = '';

						for ( $column = 1; $column <= 12; $column++ ) {
							$column_class = $column . esc_html__( '-column', 'pgs-core' );
							$column_name  = $column . esc_html__( ' column', 'pgs-core' );
							?>
							<option class="<?php echo esc_attr( $column_class ); ?>" value="<?php echo esc_attr( $column ); ?>" ><?php echo esc_html( $column_name ); ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="pgsfb-column-tablet-landscape">
					<i class="dashicons dashicons-tablet"></i>
					<select name="footer_settings[columns_settings][{{column_index}}][footer_columns_tablet_landscape]">
						<?php
						$column_class = '';
						$column_name  = '';

						for ( $column = 1; $column <= 12; $column++ ) {
							$column_class = $column . esc_html__( '-column', 'pgs-core' );
							$column_name  = $column . esc_html__( ' column', 'pgs-core' );
							?>
							<option class="<?php echo esc_attr( $column_class ); ?>" value="<?php echo esc_attr( $column ); ?>" ><?php echo esc_html( $column_name ); ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<div class="pgsfb-column-tablet">
					<i class="dashicons dashicons-tablet"></i>
					<select name="footer_settings[columns_settings][{{column_index}}][footer_columns_tablet]">
						<?php
						$column_class = '';
						$column_name  = '';

						for ( $column = 1; $column <= 12; $column++ ) {
							$column_class = $column . esc_html__( '-column', 'pgs-core' );
							$column_name  = $column . esc_html__( ' column', 'pgs-core' );
							?>
							<option class="<?php echo esc_attr( $column_class ); ?>" value="<?php echo esc_attr( $column ); ?>" ><?php echo esc_html( $column_name ); ?></option>
							<?php
						}
						?>
					</select>
				</div>
				<span class="pgsfb-description"><?php esc_html_e( 'Select the footer column', 'pgs-core' ); ?></span>
			</div>
			<div class="pgsfb-footer-input-field ">
				<label class="pgsfb-label">
					<span class="pgsfb-label-title"><?php esc_html_e( 'Column Alignment', 'pgs-core' ); ?></span>
				</label>
				<div class="ciyashop-buttonset">
					<div class="buttonset-field-container">
						<input id="footer_columns_settings_left[{{column_index}}]" name="footer_settings[columns_settings][{{column_index}}][columns_alignment]" class="hidden" type="radio" value="left" checked />
						<label for="footer_columns_settings_left[{{column_index}}]">
							<i class="dashicons dashicons-editor-alignleft"></i>
						</label>
					</div>

					<div class="buttonset-field-container">
						<input id="footer_columns_settings_center[{{column_index}}]" name="footer_settings[columns_settings][{{column_index}}][columns_alignment]" class="hidden" type="radio" value="center"/>
						<label for="footer_columns_settings_center[{{column_index}}]">
							<i class="dashicons dashicons-editor-aligncenter"></i>
						</label>
					</div>

					<div class="buttonset-field-container">
						<input id="footer_columns_settings_right[{{column_index}}]" name="footer_settings[columns_settings][{{column_index}}][columns_alignment]" class="hidden" type="radio" value="right"/>
						<label for="footer_columns_settings_right[{{column_index}}]">
							<i class="dashicons dashicons-editor-alignright"></i>
						</label>
					</div>
				</div>
				<span class="pgsfb-description"><?php esc_html_e( 'Select column alignment', 'pgs-core' ); ?></span>
			</div>
			<div class="pgsfb-footer-input-field">
				<label class="pgsfb-label" for="sidebar">
					<span class="pgsfb-label-title"><?php esc_html_e( 'Footer Sidebar', 'pgs-core' ); ?></span>
				</label>
				<div class="pgsfb-element-column pgsfb-element-contents pgsfb-element-droppable pgsfb-droppable-active" data-placeholder="<?php esc_attr_e( 'Drop element here', 'pgs-core' ); ?>">
					<input class="pgsfb-element-column-input" type="hidden" name="footer_settings[columns_settings][{{column_index}}][footer_sidebar]" value="">
				</div>
				<span class="pgsfb-description"><?php esc_html_e( 'Drag the sidebar here', 'pgs-core' ); ?></span>
			</div>
			<div class="pgsfb-footer-input-field input-type-checkbox">
				<i class="dashicons dashicons-desktop"></i>
				<label class="pgsfb-label">
					<?php esc_html_e( 'Hide For Desktop', 'pgs-core' ); ?>
					<input type="checkbox" name="footer_settings[columns_settings][{{column_index}}][hide_for_desktop]" value="1">
				</label>
			</div>
			<div class="pgsfb-footer-input-field input-type-checkbox">
				<i class="dashicons dashicons-tablet"></i>
				<label class="pgsfb-label">
					<?php esc_html_e( 'Hide For Tablet', 'pgs-core' ); ?>
					<input type="checkbox" name="footer_settings[columns_settings][{{column_index}}][hide_for_tablet]" value="1">
				</label>
			</div>
			<div class="pgsfb-footer-input-field input-type-checkbox">
				<i class="dashicons dashicons-smartphone"></i>
				<label class="pgsfb-label">
					<?php esc_html_e( 'Hide For Mobile', 'pgs-core' ); ?>
					<input type="checkbox" name="footer_settings[columns_settings][{{column_index}}][hide_for_mobile]" value="1">
				</label>
			</div>
		</div>
	</div>
</script>
