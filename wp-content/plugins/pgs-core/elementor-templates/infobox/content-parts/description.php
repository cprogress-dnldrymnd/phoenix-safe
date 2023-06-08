<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$description = isset( $settings['description'] ) ? $settings['description'] : '';
if ( $description ) {
	?>
	<div class="pgscore_info_box-description">
		<p><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}
