<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$col_sm_perview            = isset( $settings['grid_elements_sm'] ) ? $settings['grid_elements_sm'] : 1;
$col_md_perview            = isset( $settings['grid_elements_md'] ) ? $settings['grid_elements_md'] : 2;
$col_lg_perview            = isset( $settings['grid_elements_lg'] ) ? $settings['grid_elements_lg'] : 3;
$col_xl_perview            = isset( $settings['grid_elements_xl'] ) ? $settings['grid_elements_xl'] : 4;
$style                     = isset( $settings['style'] ) ? $settings['style'] : '';
$title_counter_display     = isset( $settings['title_counter_display'] ) ? $settings['title_counter_display'] : '';
$product_cat_list          = isset( $settings['product_cat_list'] ) ? $settings['product_cat_list'] : '';
$category_title            = isset( $settings['category_title'] ) ? $settings['category_title'] : '';
$hide_categories_count     = isset( $settings['hide_categories_count'] ) ? $settings['hide_categories_count'] : '';
$category_title_tag        = isset( $settings['category_title_tag'] ) ? $settings['category_title_tag'] : 'div';
$background_overlay        = isset( $settings['background_overlay'] ) ? $settings['background_overlay'] : '';
$category_background_color = isset( $settings['category_background_color'] ) ? $settings['category_background_color'] : '';

$this->add_render_attribute(
	array(
		'pgscore_product_category_items_grid' => array(
			'class' => array(
				'col-xs-12',
				'col-sm-' . ( 12 / $col_sm_perview ),
				'col-md-' . ( 12 / $col_md_perview ),
				'col-lg-' . ( 12 / $col_lg_perview ),
				'col-xl-' . ( 12 / $col_xl_perview ),
			),
		),
	)
);

if ( 'custom' === $background_overlay && 'style-1' === $style && $category_background_color ) {
	?>
	<div class="category-overlay"></div>
	<?php
}
?>
<div class="row">
	<?php
	$thumb_size = 'ciyashop-latest-post-thumbnail';
	$width      = 500;
	$height     = 375;
	foreach ( $product_cat_list as $category ) {
		$link_attr     = get_term_link( $category );
		$thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
		$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		if ( ! $thumbnail_url ) {
			$thumbnail_url = apply_filters(
				'default_category_shortcode_img',
				array(
					get_template_directory_uri() . '/images/product-placeholder.jpg',
					'',
					'',
					'',
				)
			);
		}

		if ( $thumbnail_url && isset( $thumbnail_url[0] ) ) {
			$category_title = ( isset( $category->name ) ) ? $category->name : '';
			?>
			<div <?php $this->print_render_attribute_string( 'pgscore_product_category_items_grid' ); ?>>
				<div class="pgs-core-category-container">
					<div class="category-img-container">
						<?php
						if ( 'style-1' === $style ) {
							?>
							<div class="category-overlay"></div>
							<?php
						}
						?>
						<a href="<?php echo esc_url( $link_attr ); ?>" title="<?php echo esc_attr( $category_title ); ?>">
							<?php
							echo '<img class="img-fluid center-block" src="' . esc_url( $thumbnail_url[0] ) . '" width="' . esc_attr( $thumbnail_url[1] ) . '" height="' . esc_attr( $thumbnail_url[2] ) . '" alt="' . esc_attr( $category_title ) . '">';
							?>
						</a>
					</div>
					<?php
					if ( 'style-3' === $style ) {
						?>
						<div class="category-content-info">
						<?php
					}
					?>
					<div class="category-content">
						<?php
						if ( 'counter-up-title-bottom' === $title_counter_display ) {
							if ( ! $hide_categories_count ) {
								?>
								<span class="product-count" >
									<?php echo esc_html( $category->count ); ?> <?php esc_html_e( 'Products', 'pgs-core' ); ?>
								</span>
								<?php
							}

							if ( $category_title ) {
								?>
								<<?php echo esc_html( $category_title_tag ); ?> class="category-title">
									<a class="inline_hover category-item-title" href="<?php echo esc_url( $link_attr ); ?>">
										<?php echo esc_html( $category_title ); ?>
									</a>
								</<?php echo esc_html( $category_title_tag ); ?>>
								<?php
							}
						} else {

							if ( $category_title ) {
								?>
								<<?php echo esc_html( $category_title_tag ); ?> class="category-title">
									<a class="inline_hover category-item-title" href="<?php echo esc_url( $link_attr ); ?>">
										<?php echo esc_html( $category_title ); ?>
									</a>
								</<?php echo esc_html( $category_title_tag ); ?>>
								<?php
							}

							if ( ! $hide_categories_count ) {
								?>
								<span class="product-count" >
									<?php echo esc_html( $category->count ); ?> <?php esc_html_e( 'Products', 'pgs-core' ); ?>
								</span>
								<?php
							}
						}
						?>
					</div>
					<?php
					if ( 'style-3' === $style ) {
						?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
	}
	?>
</div>
