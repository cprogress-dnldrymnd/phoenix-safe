<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$image_gallery_style         = isset( $settings['image_gallery_style'] ) ? $settings['image_gallery_style'] : 'style-1';
$image_gallery_column        = isset( $settings['image_gallery_column'] ) ? $settings['image_gallery_column'] : '';
$image_gallery_space         = isset( $settings['image_gallery_space'] ) ? $settings['image_gallery_space'] : '';
$image_gallery_type          = isset( $settings['image_gallery_type'] ) ? $settings['image_gallery_type'] : '';
$image_gallery               = isset( $settings['image_gallery'] ) ? $settings['image_gallery'] : '';
$image_gallery_style_disable = isset( $settings['image_gallery_style_disable'] ) ? $settings['image_gallery_style_disable'] : '';

if ( ! $image_gallery ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
			<p><?php esc_html_e( 'If image is not set, the widget content will not be rendered. Please select an images to display widget content.', 'pgs-core' ); ?></p>
		</div>
		<?php
	}
	return;
}

$this->add_render_attribute( 'pgscore_image_gallery', 'class', 'pgscore_image-gallery_wrapper' );
if ( ! $image_gallery_style_disable ) {
	$this->add_render_attribute( 'pgscore_image_gallery', 'class', 'pgscore_image-gallery_' . $image_gallery_style );
}

if ( 'isotope' === $image_gallery_type ) {
	$this->add_render_attribute( 'pgscore_image_gallery', 'class', 'isotope-wrapper' );
}

if ( $image_gallery_column && 'carousel' !== $image_gallery_type ) {
	$this->add_render_attribute( 'pgscore_image_gallery', 'class', 'column-' . $image_gallery_column );
}

if ( $image_gallery_space ) {
	$this->add_render_attribute( 'pgscore_image_gallery', 'class', 'image-gallery-space-' . $image_gallery_space );
} else {
	$this->add_render_attribute( 'pgscore_image_gallery', 'class', 'image-gallery-space-0' );
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_image_gallery' ); ?>>
		<?php $this->get_templates( "{$this->widget_slug}/type/{$image_gallery_type}", null, array( 'settings' => $settings ) ); ?>
	</div>
</div>







