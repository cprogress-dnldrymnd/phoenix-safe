<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$intro_description = isset( $settings['intro_description'] ) ? $settings['intro_description'] : '';
if ( $intro_description ) {
	?>
	<div class="products-listing-description" ><?php echo esc_html( $intro_description ); ?></div>
	<?php
}
