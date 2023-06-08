<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$product_source              = isset( $settings['product_source'] ) ? $settings['product_source'] : '';
$product_source_category     = isset( $settings['product_source_category'] ) ? $settings['product_source_category'] : '';
$product_source_product_type = isset( $settings['product_source_product_type'] ) ? $settings['product_source_product_type'] : '';
$product_ids                 = isset( $settings['product_ids'] ) ? $settings['product_ids'] : '';
$number_of_item              = isset( $settings['number_of_item'] ) ? $settings['number_of_item'] : '';
$listing_type                = isset( $settings['listing_type'] ) ? $settings['listing_type'] : '';
$enable_intro_link           = isset( $settings['enable_intro_link'] ) ? $settings['enable_intro_link'] : '';
$enable_intro                = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$intro_position              = isset( $settings['intro_position'] ) ? $settings['intro_position'] : '';
$intro_content_alignment     = isset( $settings['intro_content_alignment'] ) ? $settings['intro_content_alignment'] : '';
$intro_link_position         = isset( $settings['intro_link_position'] ) ? $settings['intro_link_position'] : '';
$link_title                  = isset( $settings['link_title'] ) ? $settings['link_title'] : '';
$intro_link_alignment        = isset( $settings['intro_link_alignment'] ) ? $settings['intro_link_alignment'] : '';

// Return if product source items are empty.
if ( 'category' === $product_source && ! $product_source_category ) {
	return;
} elseif ( 'product_type' === $product_source && ! $product_source_product_type ) {
	return;
} elseif ( 'selected_products' === $product_source && ! $product_ids ) {
	return;
}

// Query args.
$args = array(
	'post_type'           => 'product',
	'posts_status'        => 'publish',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => $number_of_item,
);

if ( 'selected_products' === $product_source ) {
	$args['post__in'] = $product_ids;
	$args['orderby']  = 'post__in';
} elseif ( 'category' === $product_source ) {

	$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $product_source_category,
		),
	);

	if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => array( 'outofstock' ),
			'operator' => 'NOT IN',
		);
	}
} elseif ( 'product_type' === $product_source ) {

	// New Arrival products.
	if ( 'new_arrivals' === $product_source_product_type ) {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';

		// Featured product.
	} elseif ( 'featured' === $product_source_product_type ) {
		$meta_query         = WC()->query->get_meta_query();
		$tax_query          = WC()->query->get_tax_query();
		$tax_query[]        = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		);
		$args['meta_query'] = $meta_query; // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['tax_query']  = $tax_query;  // phpcs:ignore WordPress.DB.SlowDBQuery

		// On Sale product.
	} elseif ( 'on_sale' === $product_source_product_type ) {
		$args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['tax_query']  = WC()->query->get_tax_query();  // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['post__in']   = array_merge( array( 0 ), wc_get_product_ids_on_sale() );

		// Best Sellers Product.
	} elseif ( 'best_sellers' === $product_source_product_type ) {
		$args['meta_key']   = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['orderby']    = 'meta_value_num';
		$args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['tax_query']  = WC()->query->get_tax_query();  // phpcs:ignore WordPress.DB.SlowDBQuery

		// Cheapest Product.
	} elseif ( 'cheapest' === $product_source_product_type ) {
		$args['meta_key'] = '_price'; // phpcs:ignore WordPress.DB.SlowDBQuery
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'ASC';
	}

	if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => array( 'outofstock' ),
			'operator' => 'NOT IN',
		);
	}
}

$loop = new WP_Query( $args );
if ( ! $loop->have_posts() ) {
	return;
}

$link_attr = false;

// Link Attributes.
if ( 'yes' === $enable_intro_link ) {
	$target   = ( isset( $settings['intro_link']['is_external'] ) && $settings['intro_link']['is_external'] ) ? ' target="_blank"' : '';
	$nofollow = ( isset( $settings['intro_link']['nofollow'] ) && $settings['intro_link']['nofollow'] ) ? ' rel="nofollow"' : '';
	if ( $settings['intro_link']['url'] ) {
		$link_attr = 'href="' . $settings['intro_link']['url'] . '"' . $target . $nofollow;
	}
}

$settings['link_attr'] = $link_attr;

if ( isset( $loop ) ) {
	$settings['loop'] = $loop;
}

$this->add_render_attribute( 'pgscore_product_listing', 'data-intro', ( 'yes' === $enable_intro ? 'yes' : 'no' ) );
$this->add_render_attribute(
	array(
		'pgscore_product_listing' => array(
			'class' => array(
				'products-listing-wrapper',
				'products-listing-type-' . $listing_type,
				'products-listing-' . ( 'yes' === $enable_intro ? 'with-intro' : 'without-intro' ),
			),
		),
	)
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_product_listing' ); ?>>
		<div class="products-listing-inner">
			<div class="row">
				<?php
				if ( 'yes' === $enable_intro ) {

					// Check intro position.
					if ( 'right' === $intro_position ) {
						$this->add_render_attribute( 'pgscore_product_listing_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3 order-md-2 order-lg-2' );
						$this->add_render_attribute( 'pgscore_product_listing_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9 order-md-1 order-lg-1' );

					} else {
						$this->add_render_attribute( 'pgscore_product_listing_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3' );
						$this->add_render_attribute( 'pgscore_product_listing_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9' );
					}

					$this->add_render_attribute( 'pgscore_product_listing_classes', 'class', 'products-listing-intro-wrapper products-listing-intro-content-alignment-' . $intro_content_alignment );
					?>
					<div <?php $this->print_render_attribute_string( 'pgscore_product_listing_intro_column_classes' ); ?>>
						<div <?php $this->print_render_attribute_string( 'pgscore_product_listing_classes' ); ?>>
							<?php
							if ( isset( $settings['intro_background_color'] ) && ! $settings['intro_background_color'] ) {
								?>
								<div class="products-listing-intro-wrapper-overlay"></div>
								<?php
							}

							$this->get_templates( "{$this->widget_slug}/content-parts/title", null, array( 'settings' => $settings ) );
							$this->get_templates( "{$this->widget_slug}/content-parts/description", null, array( 'settings' => $settings ) );

							if ( 'yes' === $enable_intro_link && ( 'grid' === $listing_type || ( 'carousel' === $listing_type && 'with_controls' !== $intro_link_position ) ) && ( $link_title && $link_attr ) ) {
								$this->get_templates( "{$this->widget_slug}/content-parts/link", null, array( 'settings' => $settings ) );
							}

							if ( 'carousel' === $listing_type ) {
								// Classes.
								$this->add_render_attribute( 'pgscore_product_listing_carousel_control', 'class', 'products-listing-control products-listing-control-' . $this->get_id() );
								if ( 'yes' === $enable_intro_link && 'with_controls' === $intro_link_position ) {
									$this->add_render_attribute( 'pgscore_product_listing_carousel_control', 'class', 'products-listing-control-link-alignment-' . $intro_link_alignment );
								}
								?>
								<div <?php $this->print_render_attribute_string( 'pgscore_product_listing_carousel_control' ); ?>>
									<?php
									if ( 'yes' === $enable_intro_link && 'with_controls' === $intro_link_position && ( $link_title && $link_attr ) ) {
										$this->get_templates( "{$this->widget_slug}/content-parts/link", null, array( 'settings' => $settings ) );
									}
									?>
									<div class="products-listing-nav"></div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				} else {
					$this->add_render_attribute( 'pgscore_product_listing_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-12' );
				}
				?>
				<div <?php $this->print_render_attribute_string( 'pgscore_product_listing_item_column_classes' ); ?>>
					<div class="products-listing-main">
						<div class="products-listing-main-inner">
							<?php
							if ( 'yes' !== $enable_intro ) {
								$this->get_templates( "{$this->widget_slug}/content-parts/header", null, array( 'settings' => $settings ) );
							}
							?>
							<div class="products-listing-content">
								<div class="products-listing-content-inner">
									<?php
									$this->get_templates( "{$this->widget_slug}/content-parts/products", null, array( 'settings' => $settings ) );
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
