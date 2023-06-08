<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$slides_data     = isset( $settings['slides'] ) ? $settings['slides'] : '';
$slider_elements = isset( $settings['slider_elements'] ) ? $settings['slider_elements'] : '';
$img_size        = isset( $settings['img_size'] ) ? $settings['img_size'] : '';

$owl_options_args = array(
	'items'              => 5,
	'loop'               => true,
	'dots'               => 'none' !== $slider_elements && ( 'both' === $slider_elements || 'pagination' === $slider_elements ),
	'nav'                => 'none' !== $slider_elements && ( 'both' === $slider_elements || 'prevnext' === $slider_elements ),
	'margin'             => 30,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'smartSpeed'         => 1000,
	'responsive'         => array(
		'0'    => array(
			'items' => 1,
		),
		'480'  => array(
			'items' => 2,
		),
		'768'  => array(
			'items' => 3,
		),
		'980'  => array(
			'items' => 4,
		),
		'1200' => array(
			'items' => 5,
		),
	),
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
);

$owl_options = wp_json_encode( $owl_options_args );
$this->add_render_attribute( 'pgscore_clients_carousal', 'class', 'our-clients owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_clients_carousal', 'data-owl_options', $owl_options );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_clients_carousal' ); ?>>
	<?php
	foreach ( $slides_data as $slide ) {
		$link_attr = '';
		$img_src   = '';

		if ( isset( $slide['image_link']['url'] ) && $slide['image_link']['url'] ) {
			$target    = ( isset( $slide['image_link']['is_external'] ) && $slide['image_link']['is_external'] ) ? ' target="_blank"' : '';
			$nofollow  = ( isset( $slide['image_link']['nofollow'] ) && $slide['image_link']['nofollow'] ) ? ' rel="nofollow"' : '';
			$link_attr = 'href="' . $slide['image_link']['url'] . '"' . $target . $nofollow;
		}

		$image_source = isset( $slide['image_source'] ) ? $slide['image_source'] : 'image';
		if ( 'image' === $image_source ) {
			$img_src = ( isset( $slide['slide_image']['id'] ) && $slide['slide_image']['id'] ) ? wp_get_attachment_image_src( $slide['slide_image']['id'], $img_size ) : apply_filters(
				'default_brand_logo',
				array(
					get_template_directory_uri() . '/images/brand-logo.png',
					112,
					65,
					'',
				)
			);
		} elseif ( 'link' === $image_source ) {
			$img_src = ( isset( $slide['slide_img_link']['url'] ) && $slide['slide_img_link']['url'] ) ? array( esc_url( $slide['slide_img_link']['url'] ), 112, 65 ) : apply_filters(
				'default_brand_logo',
				array(
					get_template_directory_uri() . '/images/brand-logo.png',
					112,
					65,
					'',
				)
			);
		}

		if ( $img_src && isset( $img_src[0] ) ) {
			?>
			<div class="item">
				<?php
				if ( $link_attr ) {
					echo wp_kses( '<a ' . $link_attr . '>', pgscore_allowed_html( 'a' ) );
				}

				echo '<img class="img-fluid center-block" src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" alt="' . esc_attr( isset( $slide['title'] ) ? $slide['title'] : '' ) . '">';

				if ( $link_attr ) {
					?>
					</a>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
	?>
</div>
