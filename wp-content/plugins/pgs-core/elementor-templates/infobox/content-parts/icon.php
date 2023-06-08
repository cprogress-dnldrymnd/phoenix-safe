<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$icon         = isset( $settings['icon'] ) ? $settings['icon'] : '';
$icon_disable = isset( $settings['icon_disable'] ) ? $settings['icon_disable'] : '';
$layout       = isset( $settings['layout'] ) ? $settings['layout'] : '';
$icon_image   = isset( $settings['icon_image'] ) ? $settings['icon_image'] : '';
$image_link   = isset( $settings['image_link'] ) ? $settings['image_link'] : '';
$icon_source  = isset( $settings['icon_source'] ) ? $settings['icon_source'] : '';

if ( 'yes' === $icon_disable ) {
	return;
}
?>
<div class="pgscore_info_box-icon-outer">
	<div class="pgscore_info_box-icon-inner">
		<?php
		if ( 'font' === $icon_source ) {
			\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
		} elseif ( 'image' === $icon_source && $icon_image ) {
			if ( isset( $icon_image['id'] ) && $icon_image['id'] ) {
				$icon_image_data = wp_get_attachment_image_src( $icon_image['id'], 'pgscore-thumbnail-80' );
				echo '<img src="' . esc_url( $icon_image_data[0] ) . '">';
			}
		} elseif ( 'link' === $icon_source && $image_link ) {
			if ( isset( $image_link['url'] ) && $image_link['url'] ) {
				echo '<img src="' . esc_url( $image_link['url'] ) . '">';
			}
		}
		?>
	</div>
</div>
