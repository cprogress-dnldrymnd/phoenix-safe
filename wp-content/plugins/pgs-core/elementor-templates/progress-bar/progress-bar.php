<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$progress_bar_list           = isset( $settings['progress_bar_list'] ) ? $settings['progress_bar_list'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$progress_bar_border         = isset( $settings['progress_bar_border'] ) ? $settings['progress_bar_border'] : '';
$progress_bar_layout         = isset( $settings['progress_bar_layout'] ) ? $settings['progress_bar_layout'] : '';
$progress_bar_title_position = isset( $settings['progress_bar_title_position'] ) ? $settings['progress_bar_title_position'] : '';

// Return if no list items found.
if ( ! is_array( $progress_bar_list ) || ! $progress_bar_list || ( ( 1 === count( $progress_bar_list ) ) && empty( $progress_bar_list[0] ) ) ) {
	return;
}

$this->add_render_attribute( 'widget_wrapper', 'class', 'pgscore_progress_bar_wrapper' );
if ( $progress_bar_layout ) {
	$this->add_render_attribute( 'widget_wrapper', 'class', 'progress_bar_' . $progress_bar_layout );
}

$this->add_render_attribute( 'pgscore_progress_bar', 'class', 'pgscore_progress_bar_wrapper_inner' );
if ( $progress_bar_border ) {
	$this->add_render_attribute( 'pgscore_progress_bar', 'class', 'progress_bar_' . $progress_bar_border );
}

if ( $progress_bar_title_position ) {
	$this->add_render_attribute( 'pgscore_progress_bar', 'class', 'progress_bar_title_position_' . $progress_bar_title_position );
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php
	foreach ( $progress_bar_list as $list ) {

		if ( isset( $list['progress_bar_value'] ) && $list['progress_bar_value'] > 100 ) {
			$list['progress_bar_value'] = 100;
		}

		if ( isset( $list['progress_bar_value'] ) && $list['progress_bar_value'] <= 0 ) {
			$list['progress_bar_value'] = 1;
		}

		if ( isset( $list['progress_bar_title'] ) && isset( $list['progress_bar_value'] ) ) {
			?>
			<div <?php $this->print_render_attribute_string( 'pgscore_progress_bar' ); ?>>
				<div  class="progress-bar pgscore_progress_bar_box <?php echo esc_attr( 'elementor-repeater-item-' . $list['_id'] ); ?>" data-percent="<?php echo esc_attr( $list['progress_bar_value'] ); ?>" data-delay="0" data-type="%">
					<div class="progress-title"><?php echo esc_html( $list['progress_bar_title'] ); ?></div>
					<div class="progress_bar_type_value">
						<span class="pgscore_progress_bar_value"><?php echo esc_attr( $list['progress_bar_value'] ); ?></span>
						<span class="progress-type">%</span>
					</div>
				</div>
			</div>
			<?php
		}
	}
	?>
</div>

