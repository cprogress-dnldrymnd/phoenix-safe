<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$image_gallery               = isset( $settings['image_gallery'] ) ? $settings['image_gallery'] : '';
$image_gallery_style_disable = isset( $settings['image_gallery_style_disable'] ) ? $settings['image_gallery_style_disable'] : '';
?>
<div class="isotope image_popup-gallery">
	<?php
	foreach ( $image_gallery as $image ) {
		$image_url  = '';
		$image_full = '';
		if ( isset( $image['id'] ) && $image['id'] ) {
			$image_url = wp_get_attachment_image_src( $image['id'], 'full' );
		}
		?>
		<div class="image-gallery_isotope_item grid-item">
			<div class="image-gallery-info">
				<div class="image-gallery_item">
					<div class="pgscore_image-gallery_img">
						<?php
						if ( 'true' === $image_gallery_style_disable ) {
							?>
							<a href="<?php echo esc_url( $image_url[0] ); ?>" data-elementor-open-lightbox="no" class="image_popup-img pgscore_image-gallery_hover icon-disable">
								<img src="<?php echo esc_url( $image_url[0] ); ?>">
							</a>
							<?php
						} else {
							?>
							<img src="<?php echo esc_url( $image_url[0] ); ?>">
							<?php
						}
						?>
					</div>
					<?php
					if ( 'true' !== $image_gallery_style_disable ) {
						?>
						<a href="<?php echo esc_url( $image_url[0] ); ?>" data-elementor-open-lightbox="no" class="pgscore_image-gallery_hover image_popup-img">
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
