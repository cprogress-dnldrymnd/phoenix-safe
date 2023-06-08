<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$style            = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$slides_data      = isset( $settings['slides_data'] ) ? $settings['slides_data'] : '';
$enable_caption   = isset( $settings['enable_caption'] ) ? $settings['enable_caption'] : '';
$grid_elements_sm = isset( $settings['grid_elements_sm'] ) ? $settings['grid_elements_sm'] : 1;
$grid_elements_md = isset( $settings['grid_elements_md'] ) ? $settings['grid_elements_md'] : 2;
$grid_elements_lg = isset( $settings['grid_elements_lg'] ) ? $settings['grid_elements_lg'] : 3;
$grid_elements_xl = isset( $settings['grid_elements_xl'] ) ? $settings['grid_elements_xl'] : 3;

$col_xs = 12 / $grid_elements_sm;
$col_sm = 12 / $grid_elements_sm;
$col_md = 12 / $grid_elements_md;
$col_lg = 12 / $grid_elements_lg;
$col_xl = 12 / $grid_elements_xl;

$this->add_render_attribute(
	array(
		'pgscore_image_slider_grid' => array(
			'class' => array(
				'col-xs-' . $col_xs,
				'col-sm-' . $col_sm,
				'col-md-' . $col_md,
				'col-lg-' . $col_lg,
				'col-xl-' . $col_xl,
			),
		),
	)
);
?>
<div class="row">
	<?php
	foreach ( $slides_data as $slide ) {
		?>
		<div <?php $this->print_render_attribute_string( 'pgscore_image_slider_grid' ); ?>>
			<div class="about pro-deta image-grid-<?php echo esc_attr( $style ); ?>">
				<div class="about-image clearfix">
					<?php
					$link_stat = false;
					if ( isset( $slide['onclick'] ) && 'link_no' !== $slide['onclick'] ) {
						$image_url = '';
						if ( 'link_image' === $slide['onclick'] ) {
							$image_url = $slide['image_url'];
							$link_stat = true;
							?>
							<a href="<?php echo esc_url( $image_url ); ?>" data-elementor-open-lightbox="no" class="slider-popup">
							<?php
						} elseif ( 'custom_link' === $slide['onclick'] ) {

							$link_attr = '';
							if ( isset( $slide['custom_link']['url'] ) && $slide['custom_link']['url'] ) {
								$target    = ( isset( $slide['custom_link']['is_external'] ) && $slide['custom_link']['is_external'] ) ? ' target="_blank"' : '';
								$nofollow  = ( isset( $slide['custom_link']['nofollow'] ) && $slide['custom_link']['nofollow'] ) ? ' rel="nofollow"' : '';
								$link_attr = 'href="' . $slide['custom_link']['url'] . '"' . $target . $nofollow;
							}

							if ( $link_attr ) {
								$link_stat = true;
								echo wp_kses( '<a ' . $link_attr . '>', pgscore_allowed_html( array( 'a' ) ) );
							}
						}
					}

					$alt_attr = ( isset( $slide['title'] ) && $slide['title'] ) ? $slide['title'] : '';
					echo '<img class="img-fluid" src="' . esc_url( $slide['image_thumbnail'] ) . '" width="' . esc_attr( $slide['image_thumbnail_width'] ) . '" height="' . esc_attr( $slide['image_thumbnail_height'] ) . '" alt="' . esc_attr( $alt_attr ) . '">';

					if ( 'link_no' !== $slide['onclick'] && $link_stat ) {
						?>
						</a>
						<?php
					}
					?>
				</div>
				<?php
				if ( 'true' === $enable_caption ) {
					?>
					<div class="about-details">
						<?php
						if ( isset( $slide['subtitle'] ) && $slide['subtitle'] ) {
							?>
							<div class="about-des"><?php echo esc_html( $slide['subtitle'] ); ?></div>
							<?php
						}

						if ( isset( $slide['title'] ) && $slide['title'] ) {

							$title_link_enable = isset( $slide['title_link_enable'] ) ? $slide['title_link_enable'] : '';
							$title_link_attr   = '';

							if ( 'true' === $title_link_enable && isset( $slide['title_link_url']['url'] ) ) {

								if ( $slide['title_link_url']['url'] ) {
									$target          = ( isset( $slide['title_link_url']['is_external'] ) && $slide['title_link_url']['is_external'] ) ? ' target="_blank"' : '';
									$nofollow        = ( isset( $slide['title_link_url']['nofollow'] ) && $slide['title_link_url']['nofollow'] ) ? ' rel="nofollow"' : '';
									$title_link_attr = 'href="' . $slide['title_link_url']['url'] . '"' . $target . $nofollow;
								}

								if ( $title_link_attr ) {
									echo wp_kses( '<a ' . $title_link_attr . '>', pgscore_allowed_html( array( 'a' ) ) );
								}
							}
							?>
							<h5 class="title"><?php echo esc_html( $slide['title'] ); ?></h5>
							<?php
							if ( 'true' === $title_link_enable && $title_link_attr ) {
								?>
								</a>
								<?php
							}
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
</div>
