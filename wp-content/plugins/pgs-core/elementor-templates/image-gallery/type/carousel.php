<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$carousel_elements_sm        = isset( $settings['carousel_elements_sm'] ) ? $settings['carousel_elements_sm'] : 2;
$carousel_elements_md        = isset( $settings['carousel_elements_md'] ) ? $settings['carousel_elements_md'] : 2;
$carousel_elements_lg        = isset( $settings['carousel_elements_lg'] ) ? $settings['carousel_elements_lg'] : 3;
$carousel_elements_xl        = isset( $settings['carousel_elements_xl'] ) ? $settings['carousel_elements_xl'] : 3;
$image_gallery_space         = isset( $settings['image_gallery_space'] ) ? (int) $settings['image_gallery_space'] : 0;
$image_gallery               = isset( $settings['image_gallery'] ) ? $settings['image_gallery'] : '';
$image_gallery_style_disable = isset( $settings['image_gallery_style_disable'] ) ? $settings['image_gallery_style_disable'] : '';

$owl_options_args = array(
	'items'              => $carousel_elements_xl,
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		576  => array(
			'items' => $carousel_elements_sm,
		),
		768  => array(
			'items' => $carousel_elements_md,
		),
		992  => array(
			'items' => $carousel_elements_lg,
		),
		1200 => array(
			'items' => $carousel_elements_xl,
		),
	),
	'margin'             => $image_gallery_space,
	'dots'               => false,
	'nav'                => true,
	'loop'               => true,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'autoplayTimeout'    => 3100,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'lazyLoad'           => true,
);

$owl_options = wp_json_encode( $owl_options_args );
?>
<div class="carousel-wrapper ">
	<div class="image_popup-gallery owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $image_gallery as $image ) {
		$image_url = isset( $image['url'] ) ? $image['url'] : '';
		?>
		<div class="image-gallery_carousel_item">
			<div class="image-gallery-info">
				<div class="image-gallery_item">
					<div class="pgscore_image-gallery_img">
						<?php
						if ( 'true' === $image_gallery_style_disable ) {
							?>
							<a href="<?php echo esc_url( $image_url ); ?>" data-elementor-open-lightbox="no" class="pgscore_image-gallery_hover image_popup-img icon-disable">
								<img src="<?php echo esc_url( $image_url ); ?>">
							</a>
							<?php
						} else {
							?>
							<img src="<?php echo esc_url( $image_url ); ?>">
							<?php
						}
						?>
					</div>
					<?php
					if ( 'true' !== $image_gallery_style_disable ) {
						?>
						<a href="<?php echo esc_url( $image_url ); ?>" data-elementor-open-lightbox="no" class="pgscore_image-gallery_hover image_popup-img">
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
</div>
