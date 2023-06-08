<?php
$style          = isset( $settings['style'] ) ? $settings['style'] : '';
$number_of_item = isset( $settings['number_of_item'] ) ? (int) $settings['number_of_item'] : 3;
$pro_cat_slug   = isset( $settings['pro_cat_slug'] ) ? $settings['pro_cat_slug'] : '';
$product_type   = isset( $settings['product_type'] ) ? $settings['product_type'] : '';
$custom_title   = isset( $settings['custom_title'] ) ? $settings['custom_title'] : '';
$custom_content = isset( $settings['custom_content'] ) ? $settings['custom_content'] : '';

$tax_query = array();
$args      = array(
	'post_type'      => 'product',
	'posts_status'   => 'publish',
	'posts_per_page' => $number_of_item,
);

if ( $pro_cat_slug ) {
	$tax_query[] = array(
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => explode( ',', $pro_cat_slug ),
		),
	);
}

/* Featured product */
if ( 'featured' === $product_type ) {
	$tax_query[] = array(
		array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		),
	);

	/* On Sale product */
} elseif ( 'on_sale' === $product_type ) {
	$args['meta_query'] = array(
		array(
			'key'     => '_sale_price',
			'value'   => '',
			'compare' => '!=',
		),
	);

	/* Best Sellers Product */
} elseif ( 'best_sellers' === $product_type ) {
	unset( $args['meta_query'] );
	$args['meta_key']       = 'total_sales';
	$args['meta_value_num'] = 'total_sales';
	$args['orderby']        = 'meta_value_num';
	$args['order']          = 'DESC';

	/* Cheapest Product */
} elseif ( 'cheapest' === $product_type ) {
	unset( $args['meta_query'] );
	$args['meta_key']       = '_price';
	$args['meta_value_num'] = '_price';
	$args['orderby']        = 'meta_value_num';
	$args['order']          = 'ASC';
}

if ( $tax_query ) {
	$args['tax_query'] = $tax_query;
}

$loop = new WP_Query( $args );

$owl_options_args = array(
	'items'              => 1,
	'loop'               => true,
	'autoplay'           => true,
	'autoplayTimeout'    => 3000,
	'autoplayHoverPause' => true,
	'dots'               => false,
	'nav'                => true,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left"></i>',
		'<i class="fas fa-angle-right"></i>',
	),
	'responsive'         => array(
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

$owl_options = json_encode( $owl_options_args );

$this->add_render_attribute(
	[
		'pgscore_single_product_slider' => [
			'class' => [
				'single-product-carousel woocommerce feature-5',
				'single-product-carousel-' . $style,
				'single-product-carousel-' . str_replace( '-', '_', $style ),
			],
		],
	]
);

$this->add_render_attribute( 'pgscore_single_product_slider_carousel', 'class', 'owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_single_product_slider_carousel', 'data-owl_options', $owl_options );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_single_product_slider' ); ?>>
		<?php
		if ( ( 'style-1' === $style || 'style-3' === $style ) && ( $custom_title || $custom_content ) ) {
			?>
			<div class="single-product-carousel-top-info top-info">
				<?php
				if ( $custom_title ) {
					?>
					<h3><?php echo esc_html( $custom_title ); ?></h3>
					<?php
				}
				if ( $custom_content ) {
					?>
					<p><?php echo esc_html( $custom_content ); ?></p>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
		<div <?php $this->print_render_attribute_string( 'pgscore_single_product_slider_carousel' ); ?>>
			<?php
			while ( $loop->have_posts() ) {
				$loop->the_post();
				global $post;
				?>
				<div class="item">
					<div class="product-img product">
						<div class="product-inner">
							<div class="product-thumbnail">
								<div class="product-thumbnail-inner">
									<?php woocommerce_template_loop_product_thumbnail(); ?>
								</div><!-- .product-thumbnail-inner -->
							</div><!-- .product-thumbnail -->
						</div><!-- .product-thumbnail-inner -->
						<div class="product-info">
							<div class="star-rating-wrapper">
								<?php woocommerce_template_loop_rating(); ?>
							</div><!-- .star-rating-wrapper -->
							<h3 class="product-name">
								<?php woocommerce_template_loop_product_link_open(); ?>
									<?php echo esc_html( get_the_title() ); ?>
								<?php woocommerce_template_loop_product_link_close(); ?>
							</h3><!-- .product-name-->
							<?php woocommerce_template_loop_price(); ?>
							<?php
							if ( $post->post_excerpt ) {
								$product_excerpt = $post->post_excerpt;
								$product_excerpt = pgscore_shorten_string( $product_excerpt, 115, true, true );
								if ( $product_excerpt ) {
									?>
									<div class="woocommerce-product-details__short-description">
										<p><?php echo esc_html( $product_excerpt ); ?></p>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>
