<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$hotspot_image        = '';
$list_items           = isset( $settings['list_items'] ) ? $settings['list_items'] : '';
$hotspot_trigger      = isset( $settings['hotspot_trigger'] ) ? $settings['hotspot_trigger'] : '';
$pointer_style        = isset( $settings['pointer_style'] ) ? $settings['pointer_style'] : '';
$image_source         = isset( $settings['image_source'] ) ? $settings['image_source'] : '';
$hotspot_color_scheme = isset( $settings['hotspot_color_scheme'] ) ? $settings['hotspot_color_scheme'] : '';
$hotspot_box_img_link = isset( $settings['hotspot_box_img_link'] ) ? $settings['hotspot_box_img_link'] : '';
$hotspot_box_img      = isset( $settings['hotspot_box_img']['id'] ) ? $settings['hotspot_box_img']['id'] : '';

if ( ! is_array( $list_items ) || ! $list_items || ( ( count( $list_items ) === 1 ) && ! $list_items[0] ) ) {
	return;
}

$pointer_class = 'hotspot-dot dot-' . str_replace( '-', '', $pointer_style );
if ( 'link' === $image_source && $hotspot_box_img_link ) {
	$hotspot_image = $hotspot_box_img_link;
} elseif ( $hotspot_box_img ) {
	$hotspot_image_data = wp_get_attachment_image_src( $hotspot_box_img, 'full' );
	$hotspot_image      = $hotspot_image_data[0];
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php
	if ( $hotspot_image ) {
		?>
		<div class="pgscore-image-hotspot-wrapper">
			<div class="pgscore-image-hotspot">
				<img src="<?php echo esc_url( $hotspot_image ); ?>"/>
				<?php
				if ( $list_items ) {
					?>
					<div class="pgscore-hotspot-contents-wrapper">
						<?php
						foreach ( $list_items as $list_item ) {

							$list_classes   = array();
							$list_classes[] = 'image-hotspot';
							$list_classes[] = 'pgscore-hotspot-' . $hotspot_color_scheme;
							$list_classes[] = 'elementor-repeater-item-' . $list_item['_id'];

							if ( isset( $list_item['hotspot_desktop'] ) && 'true' === $list_item['hotspot_desktop'] ) {
								$list_classes[] = 'hide-desktop';
							}
							if ( isset( $list_item['hotspot_mobile'] ) && 'true' === $list_item['hotspot_mobile'] ) {
								$list_classes[] = 'hide-mobile';
							}
							if ( 'click' === $hotspot_trigger ) {
								$list_classes[] = 'trigger-click';
							} else {
								$list_classes[] = 'trigger-hover';
							}
							$list_classes = implode( ' ', $list_classes );

							if ( array_key_exists( 'hotspot_list_image', $list_item ) || array_key_exists( 'hotspot_list_title', $list_item ) || array_key_exists( 'hotspot_list_content', $list_item ) ) {
								?>
								<div class="<?php echo esc_attr( $list_classes ); ?>">
									<div class="<?php echo esc_attr( $pointer_class ); ?>">
										<span></span>
									</div>
									<div class="hotspot-content hotspot-dropdown-<?php echo esc_attr( $list_item['hotspot_list_direction'] ); ?>">
										<?php
										if ( array_key_exists( 'hotspot_list_image', $list_item ) && isset( $list_item['hotspot_list_image']['id'] ) && $list_item['hotspot_list_image']['id'] ) {
											$list_img = wp_get_attachment_image_src( $list_item['hotspot_list_image']['id'], 'medium' );
											?>
											<div class="hotspot-content-image">
												<img src="<?php echo esc_attr( $list_img[0] ); ?>"/>
											</div>
											<?php
										}

										if ( array_key_exists( 'hotspot_list_title', $list_item ) && isset( $list_item['hotspot_list_title'] ) && $list_item['hotspot_list_title'] ) {
											?>
											<h6 class="hotspot-title"><?php echo esc_html( $list_item['hotspot_list_title'] ); ?></h6>
											<?php
										}

										if ( array_key_exists( 'hotspot_list_content', $list_item ) && isset( $list_item['hotspot_list_content'] ) && $list_item['hotspot_list_content'] ) {
											?>
											<div class="hotspot-content-text">
												<p><?php echo esc_html( $list_item['hotspot_list_content'] ); ?></p>
											</div>
											<?php
										}

										if ( isset( $list_item['hotspot_list_link'] ) && isset( $list_item['hotspot_list_link_title'] ) ) {
											$link_attr = '';
											if ( isset( $list_item['hotspot_list_link']['url'] ) && $list_item['hotspot_list_link']['url'] ) {

												$target    = ( isset( $list_item['hotspot_list_link']['is_external'] ) && $list_item['hotspot_list_link']['is_external'] ) ? ' target="_blank"' : '';
												$nofollow  = ( isset( $list_item['hotspot_list_link']['nofollow'] ) && $list_item['hotspot_list_link']['nofollow'] ) ? ' rel="nofollow"' : '';
												$link_attr = 'href="' . $list_item['hotspot_list_link']['url'] . '"' . $target . $nofollow;
											}

											if ( $link_attr && $list_item['hotspot_list_link_title'] ) {
												?>
												<div class="hotspot-btn">
													<a <?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
														<?php echo esc_html( $list_item['hotspot_list_link_title'] ); ?>
													</a>
												</div>
												<?php
											}
										}
										?>
									</div>
								</div>
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
