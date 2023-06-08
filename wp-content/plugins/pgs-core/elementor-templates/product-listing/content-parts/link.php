<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$link_title = isset( $settings['link_title'] ) ? $settings['link_title'] : '';
$link_attr  = isset( $settings['link_attr'] ) ? $settings['link_attr'] : '';
?>
<div class="products-listing-link">
	<?php
	if ( $link_title && $link_attr ) {
		echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $link_title ) . '</a>', ciyashop_allowed_html( 'a' ) );
	}
	?>
</div>
