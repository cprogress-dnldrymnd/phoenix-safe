<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$enable_step = isset( $settings['enable_step'] ) ? $settings['enable_step'] : '';
$step        = isset( $settings['step'] ) ? $settings['step'] : '';
$layout      = isset( $settings['layout'] ) ? $settings['layout'] : '';
$step_4_5    = isset( $settings['step_4_5'] ) ? $settings['step_4_5'] : '';
$step_tag    = isset( $settings['step_tag'] ) ? $settings['step_tag'] : '';
$step        = strlen( (string) $step ) < 2 ? "0{$step}" : $step;
$step_4_5    = strlen( (string) $step_4_5 ) < 2 ? "0{$step_4_5}" : $step_4_5;

if ( 'true' === $enable_step || 'style-4' === $layout || 'style-5' === $layout ) {
	if ( ( 'style-4' === $layout || 'style-5' === $layout ) && $step_4_5 ) {
		$step = $step_4_5;
	}
	?>
	<div class="pgscore_info_box-step-wrapper">
		<?php
		if ( ( 'style-4' === $layout || 'style-5' === $layout ) && $step_tag ) {
			?>
			<<?php echo esc_html( $step_tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="pgscore_info_box-step">
				<?php echo esc_html( $step ); ?>
			</<?php echo esc_html( $step_tag ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
		} else {
			?>
			<span class="pgscore_info_box-step">
				<?php echo esc_html( $step ); ?>
			</span>
			<?php
		}
		?>
	</div>
	<?php
}
