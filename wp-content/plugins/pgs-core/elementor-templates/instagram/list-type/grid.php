<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$image_size  = isset( $settings['image_size'] ) ? $settings['image_size'] : '';
$grid_col_xl = isset( $settings['grid_col_xl'] ) ? (int) $settings['grid_col_xl'] : 6;
$grid_col_lg = isset( $settings['grid_col_lg'] ) ? (int) $settings['grid_col_lg'] : 4;
$grid_col_md = isset( $settings['grid_col_md'] ) ? (int) $settings['grid_col_md'] : 3;
$grid_col_sm = isset( $settings['grid_col_sm'] ) ? (int) $settings['grid_col_sm'] : 2;
$grid_col_xs = isset( $settings['grid_col_xs'] ) ? (int) $settings['grid_col_xs'] : 2;

$this->add_render_attribute( 'pgscore_instagram_grid', 'data-owl_options', 'insta_v3_items insta_v3_style--without_meta' );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_instagram_grid' ); ?>>
	<div class="row">
		<?php
		$this->add_render_attribute(
			array(
				'pgscore_instagram_grid_class' => array(
					'class' => array(
						'col-xl-' . 12 / $grid_col_xl,
						'col-lg-' . 12 / $grid_col_lg,
						'col-md-' . 12 / $grid_col_md,
						'col-sm-' . 12 / $grid_col_sm,
						'col-' . 12 / $grid_col_xs,
					),
				),
			)
		);
		if ( isset( $settings['images'] ) && $settings['images'] ) {
			foreach ( $settings['images'] as $image ) {
				if ( 'small' === $image_size ) {
					$image_url = $image->images->low_resolution->url;
				} elseif ( 'large' === $image_size ) {
					$image_url = $image->images->standard_resolution->url;
				} else {
					$image_url = $image->images->thumbnail->url;
				}
				?>
				<div <?php $this->print_render_attribute_string( 'pgscore_instagram_grid_class' ); ?>>
					<div class="insta_v3_item">
						<a href="<?php echo esc_url( $image->link ); ?>" class="insta_v3_item--link" target="_blank">
							<div class="insta_v3_item--content">
								<?php
								echo '<img class="insta_v3_item--img img-responsive" src="' . esc_url( $image_url ) . '" alt="' . esc_attr__( 'Instagram Image', 'pgs-core' ) . '">';
								?>
							</div>
						</a>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>
