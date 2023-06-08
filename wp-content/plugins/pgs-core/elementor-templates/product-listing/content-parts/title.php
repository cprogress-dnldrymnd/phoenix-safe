<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$intro_title = isset( $settings['intro_title'] ) ? $settings['intro_title'] : '';
if ( $intro_title ) {
	?>
	<div class="products-listing-title"><h2><?php echo esc_html( $intro_title ); ?></h2></div>
	<?php
}
