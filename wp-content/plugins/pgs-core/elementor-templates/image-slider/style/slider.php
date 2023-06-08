<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$style                   = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$slides_data             = isset( $settings['slides_data'] ) ? $settings['slides_data'] : '';
$enable_caption          = isset( $settings['enable_caption'] ) ? $settings['enable_caption'] : '';
$slide_margin            = isset( $settings['slide_margin']['size'] ) ? (int) $settings['slide_margin']['size'] : 0;
$show_prev_next_buttons  = isset( $settings['show_prev_next_buttons'] ) ? $settings['show_prev_next_buttons'] : '';
$show_pagination_control = isset( $settings['show_pagination_control'] ) ? $settings['show_pagination_control'] : '';
$enable_infinity_loop    = isset( $settings['enable_infinity_loop'] ) ? $settings['enable_infinity_loop'] : '';
$slides_per_view         = isset( $settings['slides_per_view'] ) ? (int) $settings['slides_per_view'] : 3;
$slides_per_view_md      = isset( $settings['slides_per_view_md'] ) ? (int) $settings['slides_per_view_md'] : 3;
$slides_per_view_sm      = isset( $settings['slides_per_view_sm'] ) ? (int) $settings['slides_per_view_sm'] : 2;
$slides_per_view_xs      = isset( $settings['slides_per_view_xs'] ) ? (int) $settings['slides_per_view_xs'] : 1;
$slides_per_view_xx      = isset( $settings['slides_per_view_xx'] ) ? (int) $settings['slides_per_view_xx'] : 1;

$owl_options_args = array(
	'nav'        => ( 'true' === $show_prev_next_buttons ) ? true : false,  // Arrow.
	'dots'       => ( 'true' === $show_pagination_control ) ? true : false, // Pagination.
	'loop'       => ( 'true' === $enable_infinity_loop ) ? true : false,    // Loop.
	'items'      => $slides_per_view,                                       // Data Items.
	'smartSpeed' => 1000,
	'responsive' => array(
		1200 => array(
			'items' => $slides_per_view,
		),
		992  => array(
			'items' => $slides_per_view_md,
		),
		768  => array(
			'items' => $slides_per_view_sm,
		),
		480  => array(
			'items' => $slides_per_view_xs,
		),
		0    => array(
			'items' => $slides_per_view_xx,
		),
	),
	'navText'    => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'margin'     => $slide_margin,
);

$owl_options = wp_json_encode( $owl_options_args );
?>
<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $slides_data as $slide ) {
		?>
		<div class="item">
			<div class="about pro-deta image-slider-<?php echo esc_attr( $style ); ?>">
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

					$alt_attr = ( isset( $slide['title'] ) && ! empty( $slide['title'] ) ) ? $slide['title'] : '';
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
							$title_link_url    = '';

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
