<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$sale_ids             = array();
$intro_content_status = true;
$intro_status         = true;
$link_attr            = false;
$el_id                = $this->get_id();
$intro_title          = isset( $settings['intro_title'] ) ? $settings['intro_title'] : '';
$link_title           = isset( $settings['link_title'] ) ? $settings['link_title'] : '';
$product_per_page     = isset( $settings['product_per_page'] ) ? (int) $settings['product_per_page'] : '';
$enable_intro_content = isset( $settings['enable_intro_content'] ) ? $settings['enable_intro_content'] : '';
$product_categories   = isset( $settings['product_categories'] ) ? $settings['product_categories'] : '';
$intro_position       = isset( $settings['intro_position'] ) ? $settings['intro_position'] : '';
$intro_description    = isset( $settings['intro_description'] ) ? $settings['intro_description'] : '';
$enable_intro_link    = isset( $settings['enable_intro_link'] ) ? $settings['enable_intro_link'] : '';
$intro_link_position  = isset( $settings['intro_link_position'] ) ? $settings['intro_link_position'] : '';
$intro_link_alignment = isset( $settings['intro_link_alignment'] ) ? $settings['intro_link_alignment'] : '';

$args = array(
	'post_type'      => 'product',
	'posts_status'   => 'publish',
	'posts_per_page' => $product_per_page,
	'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
);

if ( is_array( $product_categories ) && $product_categories ) {
	$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $product_categories,
		),
	);
}

$loop = new WP_Query( $args );
if ( $loop->have_posts() ) {
	while ( $loop->have_posts() ) :
		$loop->the_post();
		$sale_ids[] = get_the_ID();
	endwhile;
}

wp_reset_postdata();

if ( ! is_array( $sale_ids ) || ( is_array( $sale_ids ) && ! $sale_ids ) ) {
	return;
}

if ( ! $intro_title && ! $intro_description ) {
	$intro_content_status = false;
}

if ( 'true' !== $enable_intro_content || ! $intro_content_status ) {
	$intro_status = false;
}
$control_index_class = 'product-deals-control-' . $el_id;

if ( 'true' === $enable_intro_link ) {
	$target   = ( isset( $settings['intro_link']['is_external'] ) && $settings['intro_link']['is_external'] ) ? ' target="_blank"' : '';
	$nofollow = ( isset( $settings['intro_link']['nofollow'] ) && $settings['intro_link']['nofollow'] ) ? ' rel="nofollow"' : '';
	if ( $settings['intro_link']['url'] ) {
		$link_attr = 'href="' . $settings['intro_link']['url'] . '"' . $target . $nofollow;
	}
}

$this->add_render_attribute( 'pgscore_product_deals', 'class', 'product-deals-wrapper woocommerce product-deals-style-default' );
if ( $intro_status ) {
	$this->add_render_attribute( 'pgscore_product_deals', 'data-intro', $intro_status ? 'yes' : 'no' );
}
?>
<div <?php $this->print_render_attribute_string( 'pgscore_product_deals' ); ?>>
	<div class="product-deals-inner">
		<div class="row">
			<?php
			if ( 'true' === $enable_intro_content && $intro_content_status ) {
				if ( 'right' === $intro_position ) {
					$this->add_render_attribute( 'pgscore_product_deals_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3 order-md-2 order-lg-2' );
					$this->add_render_attribute( 'pgscore_product_deals_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9 order-md-1 order-lg-1' );
				} else {
					$this->add_render_attribute( 'pgscore_product_deals_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3' );
					$this->add_render_attribute( 'pgscore_product_deals_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9' );
				}
				?>
				<div <?php $this->print_render_attribute_string( 'pgscore_product_deals_intro_column_classes' ); ?>>
					<div class="product-deals-content-wrapper">
						<div class="product-deals-content-wrapper-overlay"></div>
						<?php
						if ( $intro_title ) {
							?>
							<div class="product-deals-title"><h2><?php echo esc_html( $intro_title ); ?></h2></div>
							<?php
						}
						if ( $intro_description ) {
							?>
							<div class="product-deals-description"><?php echo esc_html( $intro_description ); ?></div>
							<?php
						}
						if ( 'true' === $enable_intro_link && 'with_controls' !== $intro_link_position && $link_title && $link_attr ) {
							?>
							<div class="product-deals-link">
								<?php
								if ( $link_title && $link_attr ) {
									echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $link_title ) . '</a>', pgscore_allowed_html( 'a' ) );
								}
								?>
							</div>
							<?php
						}

						$this->add_render_attribute( 'pgscore_product_deals_controls_classes', 'class', 'product-deals-control ' . $control_index_class );
						if ( 'true' === $enable_intro_link && 'with_controls' === $intro_link_position ) {
							$this->add_render_attribute( 'pgscore_product_deals_controls_classes', 'class', 'intro-link-alignment-' . $intro_link_alignment );
						}
						?>
						<div <?php $this->print_render_attribute_string( 'pgscore_product_deals_controls_classes' ); ?>>
							<?php
							if ( 'true' === $enable_intro_link && 'with_controls' === $intro_link_position && $link_title && $link_attr ) {
								?>
								<div class="product-deals-link">
									<?php
									if ( $link_title && $link_attr ) {
										echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $link_title ) . '</a>', pgscore_allowed_html( 'a' ) );
									}
									?>
								</div>
								<?php
							}
							?>
							<div class="product-deals-nav"></div>
						</div>
					</div>
				</div>
				<?php
			} else {
				$this->add_render_attribute( 'pgscore_product_deals_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-12' );
			}
			?>
			<div <?php $this->print_render_attribute_string( 'pgscore_product_deals_item_column_classes' ); ?>>
				<div class="product-deals-items-wrapper">
					<?php
					$owl_options_args = array(
						'items'              => 3,
						'responsive'         => array(
							0    => array(
								'items' => 1,
							),
							480  => array(
								'items' => 1,
							),
							768  => array(
								'items' => 1,
							),
							980  => array(
								'items' => 2,
							),
							1600 => array(
								'items' => 2,
							),
						),
						'margin'             => 20,
						'dots'               => false,
						'nav'                => true,
						'loop'               => false,
						'autoplay'           => false,
						'autoplayHoverPause' => true,
						'autoplayTimeout'    => 3100,
						'smartSpeed'         => 1000,
						'navText'            => array(
							'<i class="fas fa-angle-left fa-2x"></i>',
							'<i class="fas fa-angle-right fa-2x"></i>',
						),
					);
					if ( $intro_status ) {
						$owl_options_args['navContainer'] = ".product-deals-control.{$control_index_class} .product-deals-nav";
					}

					$owl_options = wp_json_encode( $owl_options_args );

					$this->add_render_attribute( 'pgscore_product_deals_item_carousel', 'class', 'product-deals-items owl-carousel owl-theme owl-carousel-options' );
					$this->add_render_attribute( 'pgscore_product_deals_item_carousel', 'data-owl_options', $owl_options );
					?>
					<div <?php $this->print_render_attribute_string( 'pgscore_product_deals_item_carousel' ); ?>>
						<?php
						$items_in_column = 2;
						$sale_ids_chunks = array_chunk( $sale_ids, $items_in_column );

						foreach ( $sale_ids_chunks as $sale_ids_chunk ) {
							?>
							<div class="product-deals-items-column">
								<?php
								foreach ( $sale_ids_chunk as $sale_id ) {

									global $product;

									$product = wc_get_product( (int) $sale_id );
									if ( is_object( $product ) ) {
										$product_deals_item_classes = array( 'product-deals-item' );

										if ( ! $product->get_date_on_sale_to() ) {
											$product_deals_item_classes[] = 'product-deals-item-withou-counter';
										}

										if ( has_post_thumbnail( $product->get_id() ) ) {
											$product_deals_item_classes[] = 'product-deals-item-with-image';
										} else {
											$product_deals_item_classes[] = 'product-deals-item-without-image';
										}

										$product_deals_item_classes[] = 'clearfix';
										$product_deals_item_classes[] = 'match-height';

										$product_deals_item_classes = implode( ' ', $product_deals_item_classes );
										?>
										<div class="<?php echo esc_attr( $product_deals_item_classes ); ?>">
											<?php $this->get_templates( "{$this->widget_slug}/product/content", null, array( 'settings' => $settings ) ); ?>
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
			</div>
		</div>
	</div>
</div>
