<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$slides_data   = isset( $settings['slides'] ) ? $settings['slides'] : '';
$grid_elements = isset( $settings['grid_elements'] ) ? $settings['grid_elements'] : '';
$img_size      = isset( $settings['img_size'] ) ? $settings['img_size'] : '';

$this->add_render_attribute(
	array(
		'pgscore_clients_grid' => array(
			'class' => array(
				'our-clients',
				'boxed-list',
				'box-' . $grid_elements,
			),
		),
	)
);
?>
<div <?php $this->print_render_attribute_string( 'pgscore_clients_grid' ); ?>>
	<ul class="list-inline clearfix">
		<?php
		foreach ( $slides_data as $slide ) {
			$link_attr = '';

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
				<li>
					<?php
					if ( $link_attr ) {
						echo wp_kses( '<a ' . $link_attr . '>', pgscore_allowed_html( array( 'a' ) ) );
					}

					$slide_title = ( $slide['title'] ) ? esc_attr( $slide['title'] ) : '';
					echo '<img class="img-fluid center-block" src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" alt="' . esc_attr( $slide_title ) . '">';

					if ( $link_attr ) {
						?>
						</a>
						<?php
					}
					?>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
