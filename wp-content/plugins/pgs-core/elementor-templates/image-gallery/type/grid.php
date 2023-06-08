<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$image_gallery_column        = isset( $settings['image_gallery_column'] ) ? (int) $settings['image_gallery_column'] : '';
$image_gallery               = isset( $settings['image_gallery'] ) ? $settings['image_gallery'] : '';
$image_gallery_style_disable = isset( $settings['image_gallery_style_disable'] ) ? $settings['image_gallery_style_disable'] : '';

$this->add_render_attribute( 'pgscore_image_gallery_grid', 'class', 'image-gallery_grid_item' );
if ( 2 === $image_gallery_column ) {
	$this->add_render_attribute( 'pgscore_image_gallery_grid', 'class', 'col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6' );
} elseif ( 3 === $image_gallery_column ) {
	$this->add_render_attribute( 'pgscore_image_gallery_grid', 'class', 'col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4' );
} elseif ( 4 === $image_gallery_column ) {
	$this->add_render_attribute( 'pgscore_image_gallery_grid', 'class', 'col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3' );
} elseif ( 6 === $image_gallery_column ) {
	$this->add_render_attribute( 'pgscore_image_gallery_grid', 'class', 'col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-2' );
}
?>
<div class="row image_popup-gallery">
	<?php
	foreach ( $image_gallery as $image ) {
		$image_url  = '';
		$image_full = '';
		if ( isset( $image['id'] ) && $image['id'] ) {
			$image_url  = wp_get_attachment_image_src( $image['id'], 'ciyashop-latest-post-thumbnail' );
			$image_full = wp_get_attachment_image_src( $image['id'], 'full' );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'pgscore_image_gallery_grid' ); ?>>
			<div class="image-gallery-info">
				<div class="image-gallery_item">
					<div class="pgscore_image-gallery_img">
						<?php
						if ( 'true' === $image_gallery_style_disable ) {
							?>
							<a href="<?php echo esc_url( $image_full[0] ); ?>" data-elementor-open-lightbox="no" class="pgscore_image-gallery_hover image_popup-img icon-disable">
								<img  src="<?php echo esc_url( $image_url[0] ); ?>">
							</a>
							<?php
						} else {
							?>
							<img  src="<?php echo esc_url( $image_url[0] ); ?>">
							<?php
						}
						?>
					</div>
					<?php
					if ( 'true' !== $image_gallery_style_disable ) {
						?>
						<a href="<?php echo esc_url( $image_full[0] ); ?>" data-elementor-open-lightbox="no" class="pgscore_image-gallery_hover image_popup-img">
							<span class="gallery-icon"><i class="icon"></i></span>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>
