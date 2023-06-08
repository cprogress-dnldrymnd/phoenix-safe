<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$carousel_items_sm         = isset( $settings['carousel_items_sm'] ) ? $settings['carousel_items_sm'] : 1;
$carousel_items_md         = isset( $settings['carousel_items_md'] ) ? $settings['carousel_items_md'] : 2;
$carousel_items_lg         = isset( $settings['carousel_items_lg'] ) ? $settings['carousel_items_lg'] : 3;
$carousel_items_xl         = isset( $settings['carousel_items_xl'] ) ? $settings['carousel_items_xl'] : 3;
$slider_elements           = isset( $settings['slider_elements'] ) ? $settings['slider_elements'] : '';
$carousel_margin           = isset( $settings['carousel_margin'] ) ? $settings['carousel_margin'] : 50;
$style                     = isset( $settings['style'] ) ? $settings['style'] : '';
$title_counter_display     = isset( $settings['title_counter_display'] ) ? $settings['title_counter_display'] : '';
$product_cat_list          = isset( $settings['product_cat_list'] ) ? $settings['product_cat_list'] : '';
$category_title            = isset( $settings['category_title'] ) ? $settings['category_title'] : '';
$hide_categories_count     = isset( $settings['hide_categories_count'] ) ? $settings['hide_categories_count'] : '';
$category_title_tag        = isset( $settings['category_title_tag'] ) ? $settings['category_title_tag'] : 'div';
$background_overlay        = isset( $settings['background_overlay'] ) ? $settings['background_overlay'] : '';
$category_background_color = isset( $settings['category_background_color'] ) ? $settings['category_background_color'] : '';

$owl_options_args = array(
	'items'              => $carousel_items_xl,
	'loop'               => false,
	'dots'               => 'none' !== $slider_elements && ( 'both' === $slider_elements || 'pagination' === $slider_elements ),
	'nav'                => 'none' !== $slider_elements && ( 'both' === $slider_elements || 'prevnext' === $slider_elements ),
	'margin'             => (int) $carousel_margin,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'smartSpeed'         => 1000,
	'responsive'         => array(
		'0'    => array(
			'items' => 1,
		),
		'576'  => array(
			'items' => $carousel_items_sm,
		),
		'768'  => array(
			'items' => $carousel_items_md,
		),
		'992'  => array(
			'items' => $carousel_items_lg,
		),
		'1200' => array(
			'items' => $carousel_items_xl,
		),
	),
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
);

$owl_options = wp_json_encode( $owl_options_args );

if ( 'custom' === $background_overlay && 'style-1' === $style && $category_background_color ) {
	?>
	<div class="category-overlay"></div>
	<?php
}

$this->add_render_attribute( 'pgscore_product_category_items_slider', 'class', 'pgs-core-category owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_product_category_items_slider', 'data-owl_options', $owl_options );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_product_category_items_slider' ); ?>>
	<?php
	foreach ( $product_cat_list as $category ) {
		$link_attr     = get_term_link( $category );
		$thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
		$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		if ( empty( $thumbnail_url ) ) {
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
			$category_title = ( isset( $category->name ) ) ? esc_attr( $category->name ) : '';
			?>
			<div class="item">
				<div class="pgs-core-category-container">
					<div class="category-img-container">
						<?php
						if ( 'style-1' === $style ) {
							?>
							<div class="category-overlay"></div>
							<?php
						}
						?>
						<a href="<?php echo esc_url( $link_attr ); ?>" title="<?php echo esc_attr( $category_title ); ?>" >
							<?php echo '<img class="img-fluid center-block" src="' . esc_url( $thumbnail_url[0] ) . '" width="' . esc_attr( $thumbnail_url[1] ) . '" height="' . esc_attr( $thumbnail_url[2] ) . '" alt="' . esc_attr( $category_title ) . '">'; ?>
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
