<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$kitebox_images  = isset( $settings['kitebox_images'] ) ? $settings['kitebox_images'] : '';
$kitebox_content = isset( $settings['kitebox_content'] ) ? $settings['kitebox_content'] : '';

$position_1 = false;
$position_2 = false;
$position_3 = false;
$position_4 = false;

// get image url and the button attribute for each images.
if ( $kitebox_images ) {

	$kitebox_images_sr = 0;

	foreach ( $kitebox_images as $kitebox_images_k => $kitebox_image_data ) {

		// Check if image or title is set.
		if ( ! isset( $kitebox_image_data['content_image'] ) && ! isset( $kitebox_image_data['image_title'] ) ) {
			unset( $kitebox_images[ $kitebox_images_k ] );
		} else {

			$kitebox_images_sr++;

			$img_data = array();

			if ( isset( $kitebox_image_data['content_image']['id'] ) && $kitebox_image_data['content_image']['id'] ) {
				$image_data = wp_get_attachment_image_src( $kitebox_image_data['content_image']['id'], 'large' );

				if ( isset( $image_data[0] ) && $image_data[0] ) {
					$img_data = $image_data;
				}
			}

			if ( $img_data ) {
				$kitebox_images[ $kitebox_images_k ]['content_image_url'] = $img_data[0];
				$kitebox_images[ $kitebox_images_k ]['content_image_w']   = $img_data[1];
				$kitebox_images[ $kitebox_images_k ]['content_image_h']   = $img_data[2];
			} else {
				$kitebox_images[ $kitebox_images_k ]['content_image_url'] = get_parent_theme_file_uri( '/images/placeholder/kite_box/900x900.jpg' );
				$kitebox_images[ $kitebox_images_k ]['content_image_w']   = 900;
				$kitebox_images[ $kitebox_images_k ]['content_image_h']   = 900;
			}

			if ( ( isset( $kitebox_image_data['kitebox_image_enable_link'] ) && 'true' === $kitebox_image_data['kitebox_image_enable_link'] ) && ( isset( $kitebox_image_data['kite_box_content_button_link'] ) && $kitebox_image_data['kite_box_content_button_link'] ) ) {
				$kite_but_attr = '';
				if ( isset( $kitebox_image_data['kite_box_content_button_link']['url'] ) && $kitebox_image_data['kite_box_content_button_link']['url'] ) {
					$target        = ( isset( $kitebox_image_data['kite_box_content_button_link']['is_external'] ) && $kitebox_image_data['kite_box_content_button_link']['is_external'] ) ? ' target="_blank"' : '';
					$nofollow      = ( isset( $kitebox_image_data['kite_box_content_button_link']['nofollow'] ) && $kitebox_image_data['kite_box_content_button_link']['nofollow'] ) ? ' rel="nofollow"' : '';
					$kite_but_attr = 'class="kite-btn" href="' . esc_url( $kitebox_image_data['kite_box_content_button_link']['url'] ) . '"' . $target . $nofollow;
				}
				if ( $kite_but_attr ) {
					$kitebox_images[ $kitebox_images_k ]['button_attr'] = $kite_but_attr;
				}
			}
		}
	}
}

$image_count = '';

if ( $kitebox_images ) {
	$kitebox_images = array_values( $kitebox_images );
	$image_count    = count( $kitebox_images );
}
$images_outer_class = 'col-xl kite-images-wrapper';

// Add classs for images based on count.
if ( $kitebox_images ) {

	if ( 1 === $image_count ) {

		$position_1 = $kitebox_images[0];

		$images_outer_class        = 'col-xl kite-images-wrapper kite-image-single';
		$image_class['position_1'] = 'col-xl-8 col-lg-8 col-md-6 col-sm-6 kite-big';

	} elseif ( 2 === $image_count ) {

		$position_1 = $kitebox_images[0];
		$position_3 = $kitebox_images[1];

		$image_class['position_1'] = 'col-lg-8 col-md-6 col-sm-6 kite-big';
		$image_class['position_3'] = 'col-lg-4 col-md-6 col-sm-6 offset-lg-8';

	} elseif ( 3 === $image_count ) {

		$position_1 = $kitebox_images[0];
		$position_2 = $kitebox_images[1];
		$position_4 = $kitebox_images[2];

		$image_class['position_1'] = 'col-lg-8 col-md-6 col-sm-6 kite-big';
		$image_class['position_2'] = 'col-lg-4 col-md-6 col-sm-6 offset-lg-4';
		$image_class['position_4'] = 'col-lg-4 col-md-6 col-sm-6';

	} else {

		$position_1 = $kitebox_images[0];
		$position_2 = $kitebox_images[1];
		$position_3 = $kitebox_images[2];
		$position_4 = $kitebox_images[3];

		$image_class['position_1'] = 'col-lg-8 col-md-6 col-sm-6 kite-big';
		$image_class['position_2'] = 'col-lg-4 col-md-6 col-sm-6 offset-lg-4';
		$image_class['position_3'] = 'col-lg-4 col-md-6 col-sm-6';
		$image_class['position_4'] = 'col-lg-4 col-md-6 col-sm-6';
	}
}

// Get image url and the button attribute for each images.
if ( $kitebox_content ) {

	$kitebox_images_sr = 0;

	foreach ( $kitebox_content as $kitebox_content_k => $kitebox_content_data ) {
		if ( empty( $kitebox_content_data ) || ( ! isset( $kitebox_content_data['content_title'] ) && ! isset( $kitebox_content_data['content_description'] ) ) ) {
			unset( $kitebox_content[ $kitebox_content_k ] );
		}
	}
}

$content_count = '';
if ( $kitebox_content ) {
	$kitebox_content = array_values( $kitebox_content );
	$content_count   = count( $kitebox_content );
}

// Add classs for content base on count.
if ( $content_count && 1 === $content_count ) {
	$content_class[] = 'middle-step';
} elseif ( $content_count && 2 === $content_count ) {
	$content_class[] = 'top-step';
	$content_class[] = 'bottom-step';
} else {
	$content_class[] = 'top-step';
	$content_class[] = 'middle-step';
	$content_class[] = 'bottom-step';
}

$kite_box_classes = array(
	'kite-box',
	'container-fluid',
);

if ( ! $kitebox_images ) {
	$kite_box_classes[] = 'no-images';
	$kite_box_classes[] = 'kite-box-without-images';
}

if ( ! $kitebox_content ) {
	$kite_box_classes[] = 'kite-box-without-content';
}

// bail if images and contents, both is empty.
if ( ! $kitebox_images && ! $kitebox_content ) {
	return;
}

$kite_box_classes = implode( ' ', $kite_box_classes );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div class="<?php echo esc_attr( $kite_box_classes ); ?>">
		<div class="row align-items-center">
			<?php
			// Images.
			if ( $kitebox_images ) {
				?>
				<div class="<?php echo esc_attr( $images_outer_class ); ?>">
					<div class="row no-gutters">
						<?php
						if ( $position_2 ) {
							?>
							<div class="<?php echo esc_attr( $image_class['position_2'] ); ?>">
								<div class="image-inner">
									<div class="kite-image">
										<?php
										echo '<img class="img-fluid" src="' . esc_url( $position_2['content_image_url'] ) . '" width="' . esc_attr( $position_2['content_image_w'] ) . '" height="' . esc_attr( $position_2['content_image_h'] ) . '" alt="' . esc_attr( $position_2['image_title'] ) . '">';
										?>
									</div>
									<div class="kite-images-actions">
										<div class="kite-actions-wrapper">
											<?php
											if ( isset( $position_2['image_title'] ) && $position_2['image_title'] ) {
												?>
												<div class="title"><?php echo esc_html( $position_2['image_title'] ); ?></div>
												<?php
											}
											if ( isset( $position_2['button_attr'] ) && $position_2['button_attr'] && $position_2['kite_box_image_button_text'] ) {
												echo wp_kses( '<a ' . $position_2['button_attr'] . '>' . esc_html( $position_2['kite_box_image_button_text'] ) . '</a>', pgscore_allowed_html( 'a' ) );
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						if ( $position_3 ) {
							?>
							<div class="<?php echo esc_attr( $image_class['position_3'] ); ?>">
								<div class="image-inner">
									<div class="kite-image">
										<?php
										echo '<img class="img-fluid" src="' . esc_url( $position_3['content_image_url'] ) . '" width="' . esc_attr( $position_3['content_image_w'] ) . '" height="' . esc_attr( $position_3['content_image_h'] ) . '" alt="' . esc_attr( $position_3['image_title'] ) . '">';
										?>
									</div>
									<div class="kite-images-actions">
										<div class="kite-actions-wrapper">
											<?php
											if ( isset( $position_3['image_title'] ) && $position_3['image_title'] ) {
												?>
												<div class="title"><?php echo esc_html( $position_3['image_title'] ); ?></div>
												<?php
											}
											if ( isset( $position_3['button_attr'] ) && $position_3['button_attr'] && $position_3['kite_box_image_button_text'] ) {
												echo wp_kses( '<a ' . $position_3['button_attr'] . '>' . esc_html( $position_3['kite_box_image_button_text'] ) . '</a>', pgscore_allowed_html( 'a' ) );
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<div class="row align-items-start no-gutters">
						<?php
						if ( $position_1 ) {
							?>
							<div class="<?php echo esc_attr( $image_class['position_1'] ); ?>">
								<div class="image-inner">
									<div class="kite-image">
										<?php
										echo '<img class="img-fluid" src="' . esc_url( $position_1['content_image_url'] ) . '" width="' . esc_attr( $position_1['content_image_w'] ) . '" height="' . esc_attr( $position_1['content_image_h'] ) . '" alt="' . esc_attr( $position_1['image_title'] ) . '">';
										?>
									</div>
									<div class="kite-images-actions">
										<div class="kite-actions-wrapper">
											<?php
											if ( isset( $position_1['image_title'] ) && $position_1['image_title'] ) {
												?>
												<div class="title"><?php echo esc_html( $position_1['image_title'] ); ?></div>
												<?php
											}
											if ( isset( $position_1['button_attr'] ) && $position_1['button_attr'] && $position_1['kite_box_image_button_text'] ) {
												echo wp_kses( '<a ' . $position_1['button_attr'] . '>' . esc_html( $position_1['kite_box_image_button_text'] ) . '</a>', pgscore_allowed_html( 'a' ) );
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						if ( $position_4 ) {
							?>
							<div class="<?php echo esc_attr( $image_class['position_4'] ); ?>">
								<div class="image-inner">
									<div class="kite-image">
										<?php
										echo '<img class="img-fluid" src="' . esc_url( $position_4['content_image_url'] ) . '" width="' . esc_attr( $position_4['content_image_w'] ) . '" height="' . esc_attr( $position_4['content_image_h'] ) . '" alt="' . esc_attr( $position_4['image_title'] ) . '">';
										?>
									</div>
									<div class="kite-images-actions">
										<div class="kite-actions-wrapper">
											<?php
											if ( isset( $position_4['image_title'] ) && $position_4['image_title'] ) {
												?>
												<div class="title"><?php echo esc_html( $position_4['image_title'] ); ?></div>
												<?php
											}
											if ( isset( $position_4['button_attr'] ) && $position_4['button_attr'] && $position_4['kite_box_image_button_text'] ) {
												echo wp_kses( '<a ' . $position_4['button_attr'] . '>' . esc_html( $position_4['kite_box_image_button_text'] ) . '</a>', pgscore_allowed_html( 'a' ) );
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}

			// Contents.
			if ( $kitebox_content ) {
				if ( $kitebox_content[0] || isset( $kitebox_content[1] ) ) {
					?>
					<div class="col-xl kite-steps-wrapper">
						<?php
						$class = 0;
						$i     = 0;

						foreach ( $kitebox_content as $kitebox_content_v ) {
							$content_title       = isset( $kitebox_content_v['content_title'] ) ? $kitebox_content_v['content_title'] : '';
							$content_description = isset( $kitebox_content_v['content_description'] ) ? $kitebox_content_v['content_description'] : '';
							$i++;

							if ( $i > 3 ) {
								break;
							}
							?>
							<div class="kite-step-inner <?php echo esc_attr( $content_class[ $class ] ); ?>">
								<?php
								if ( $content_title || $content_description ) {
									?>
									<div class="step-number"><?php echo esc_html( '0' . $i ); ?></div>
									<div class="step-content">
										<div class="step-title"><?php echo esc_html( $content_title ); ?></div>
										<div class="step-description"><?php echo esc_html( $content_description ); ?></div>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							$class++;
						}
						?>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
