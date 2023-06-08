<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$style          = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$title          = isset( $settings['title'] ) ? $settings['title'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$title_el       = isset( $settings['title_el'] ) ? $settings['title_el'] : '';
$product_type   = isset( $settings['product_type'] ) ? $settings['product_type'] : '';
$number_of_item = isset( $settings['number_of_item'] ) ? (int) $settings['number_of_item'] : '';

$query_args = array(
	'posts_per_page' => $number_of_item,
	'no_found_rows'  => 1,
	'post_status'    => 'publish',
	'post_type'      => 'product',
);

if ( 'recently-viewed' === $product_type ) {
	$woocommerce_recently_viewed = ( isset( $_COOKIE['woocommerce_recently_viewed'] ) ) ? wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$viewed_products             = ( $woocommerce_recently_viewed ) ? (array) explode( '|', $woocommerce_recently_viewed ) : array();
	$viewed_products             = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
	if ( empty( $viewed_products ) ) {
		$viewed_products[] = 0;
	}

	$query_args['post__in'] = $viewed_products;
	$query_args['orderby']  = 'post__in';

	if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$query_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'outofstock',
				'operator' => 'NOT IN',
			),
		);
	}
} elseif ( 'featured-products' === $product_type ) {
	$query_args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery
	$query_args['tax_query']  = WC()->query->get_tax_query();  // phpcs:ignore WordPress.DB.SlowDBQuery
	$tax_query[]              = array(
		'taxonomy' => 'product_visibility',
		'field'    => 'name',
		'terms'    => 'featured',
		'operator' => 'IN',
	);
	$query_args['tax_query']  = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery
} elseif ( 'products-in-sale' === $product_type ) {
	$query_args['meta_key']     = '_sale_price'; // phpcs:ignore WordPress.DB.SlowDBQuery
	$query_args['meta_value']   = '0';           // phpcs:ignore WordPress.DB.SlowDBQuery
	$query_args['meta_compare'] = '>=';
} elseif ( 'top-rated-products' === $product_type ) {
	$query_args['meta_key']   = '_wc_average_rating'; // phpcs:ignore WordPress.DB.SlowDBQuery
	$query_args['orderby']    = 'meta_value_num';
	$query_args['order']      = 'DESC';
	$query_args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery
	$query_args['tax_query']  = WC()->query->get_tax_query();  // phpcs:ignore WordPress.DB.SlowDBQuery
}

$loop = new WP_Query( $query_args );

$allowed_tags = wp_kses_allowed_html( 'post' );

$owl_options_args = array(
	'items'      => 1,
	'loop'       => true,
	'autoplay'   => false,
	'dots'       => false,
	'nav'        => true,
	'smartSpeed' => 1000,
	'navText'    => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'responsive' => array(
		0    => array(
			'items' => 1,
		),
		600  => array(
			'items' => 1,
		),
		1000 => array(
			'items' => 1,
		),
	),
);

$owl_options = wp_json_encode( $owl_options_args );

$this->add_render_attribute( 'widget_wrapper', 'class', 'pgscore_product_showcase_wrapper' );
$this->add_render_attribute( 'pgscore_product_showcase', 'class', 'pgscore_product_showcase_inner product-showcase-' . $style );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_product_showcase' ); ?>>
		<?php
		if ( $title ) {
			?>
			<<?php echo esc_attr( $title_el ); ?> class="pgscore_product_showcase-title">
				<?php echo esc_html( $title ); ?>
			</<?php echo esc_attr( $title_el ); ?>>
			<?php
		}
		if ( $loop->have_posts() ) {
			$this->add_render_attribute( 'pgscore_product_showcase_carousel', 'class', 'pgscore_product_showcase-carousel owl-carousel owl-theme owl-carousel-options feature-6' );
			$this->add_render_attribute( 'pgscore_product_showcase_carousel', 'data-owl_options', $owl_options );
			?>
			<div <?php $this->print_render_attribute_string( 'pgscore_product_showcase_carousel' ); ?>>
				<div class="item">
					<?php
					$product_sr = 1;
					while ( $loop->have_posts() ) {
						$loop->the_post();
						global $product;
						?>
						<div class="content-row product-sr-<?php echo esc_attr( $product_sr ); ?>">
							<div class="left-image">
								<?php echo wp_kses( $product->get_image( 'shop_thumbnail', array( 'class' => 'img-fluid' ) ), array( 'img' => $allowed_tags['img'] ) ); ?>
							</div>
							<div class="right-info">
								<span class="product_type-title">
									<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html( $product->get_title() ); ?></a>
								</span>
								<span class="price">
									<?php
									echo wp_kses(
										$product->get_price_html(),
										array(
											'span' => array_merge( $allowed_tags['span'], array( 'data-product-id' => true ) ),
											'del'  => $allowed_tags['del'],
											'ins'  => $allowed_tags['ins'],
										)
									);
									?>
								</span>
							</div>
						</div>
						<?php
						if ( 0 === ( $product_sr % 4 ) && $product_sr !== (int) $loop->post_count ) {
							?>
							</div><div class="item">
							<?php
						}
						$product_sr++;
					}
					/* Restore original Post Data */
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
