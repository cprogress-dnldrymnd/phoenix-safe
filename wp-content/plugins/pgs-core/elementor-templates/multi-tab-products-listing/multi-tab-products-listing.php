<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$intro_title                     = isset( $settings['intro_title'] ) ? $settings['intro_title'] : '';
$tabs_source                     = isset( $settings['tabs_source'] ) ? $settings['tabs_source'] : '';
$tabs_position                   = isset( $settings['tabs_position'] ) ? $settings['tabs_position'] : '';
$tabs_alignment                  = isset( $settings['tabs_alignment'] ) ? $settings['tabs_alignment'] : '';
$intro_description               = isset( $settings['intro_description'] ) ? $settings['intro_description'] : '';
$enable_intro                    = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$listing_type                    = isset( $settings['listing_type'] ) ? $settings['listing_type'] : '';
$tabs_source_categories_ids      = isset( $settings['tabs_source_categories_ids'] ) ? $settings['tabs_source_categories_ids'] : '';
$tabs_source_product_types       = isset( $settings['tabs_source_product_types'] ) ? $settings['tabs_source_product_types'] : '';
$intro_content_alignment         = isset( $settings['intro_content_alignment'] ) ? $settings['intro_content_alignment'] : '';
$number_of_item                  = isset( $settings['number_of_item'] ) ? $settings['number_of_item'] : '';
$intro_bg_type                   = isset( $settings['intro_bg_type'] ) ? $settings['intro_bg_type'] : '';
$tabs_source_categories          = isset( $settings['tabs_source_categories'] ) ? $settings['tabs_source_categories'] : '';
$tabs_source_cat_term_field_type = isset( $settings['tabs_source_cat_term_field_type'] ) ? $settings['tabs_source_cat_term_field_type'] : '';
$intro_bg_image_ol_color         = isset( $settings['intro_bg_image_ol_color'] ) ? $settings['intro_bg_image_ol_color'] : '';

// If Intro is not enabled and tab position is set to "intro", then set it back to "top".
if ( 'true' !== $enable_intro && 'intro' === $tabs_position ) {
	$tabs_position = 'top';
}

// Return if tabs source items are empty.
if ( 'categories' === $tabs_source && ( ( 'slug' === $tabs_source_cat_term_field_type && ! $tabs_source_categories ) || ( 'term_id' === $tabs_source_cat_term_field_type && ! $tabs_source_categories_ids ) ) ) {
	$multi_tab_args       = array(
		'taxonomy'     => 'product_cat',
		'orderby'      => 'name',
		'show_count'   => 0,
		'pad_counts'   => 0,
		'hierarchical' => 0,
		'title_li'     => '',
		'hide_empty'   => 0,
	);
	$multi_tab_categories = get_terms( $multi_tab_args );
	$all_cat              = array();
	foreach ( $multi_tab_categories as $category ) {
		$all_cat[ $category->term_id ] = $category->slug;
	}
	$tabs_source_categories     = implode( ',', $all_cat );
	$tabs_source_categories_ids = implode( ',', array_keys( $all_cat ) );
} elseif ( 'product_types' === $tabs_source && ! $tabs_source_product_types ) {
	return;
}

// Tabs.
$product_types   = pgscore_product_types();
$tabs_data       = array();
$tabs_data_count = 0;

$args = array(
	'post_type'      => 'product',
	'posts_status'   => 'publish',
	'posts_per_page' => $number_of_item,
);

if ( 'product_types' === $tabs_source ) {
	foreach ( $tabs_source_product_types as $tab_item ) {
		$typeargs = array();

		// New Arrival products.
		if ( 'new_arrivals' === $tab_item ) {
			$typeargs['orderby'] = 'date';
			$typeargs['order']   = 'DESC';

			// Featured product.
		} elseif ( 'featured' === $tab_item ) {
			$meta_query             = WC()->query->get_meta_query();
			$tax_query              = WC()->query->get_tax_query();
			$tax_query[]            = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
			$typeargs['meta_query'] = $meta_query; // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['tax_query']  = $tax_query;  // phpcs:ignore WordPress.DB.SlowDBQuery

			// On Sale product.
		} elseif ( 'on_sale' === $tab_item ) {
			$typeargs['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['tax_query']  = WC()->query->get_tax_query();  // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['post__in']   = array_merge( array( 0 ), wc_get_product_ids_on_sale() );

			// Best Sellers Product.
		} elseif ( 'best_sellers' === $tab_item ) {

			$typeargs['meta_key']   = 'total_sales';                 // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['orderby']    = 'meta_value_num';              // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['tax_query']  = WC()->query->get_tax_query();  // phpcs:ignore WordPress.DB.SlowDBQuery

			// Cheapest Product.
		} elseif ( 'cheapest' === $tab_item ) {

			$typeargs['meta_key'] = '_price';         // phpcs:ignore WordPress.DB.SlowDBQuery
			$typeargs['orderby']  = 'meta_value_num';
			$typeargs['order']    = 'ASC';
		}

		$loop = new WP_Query( array_merge( $args, $typeargs ) );

		if ( $loop->have_posts() ) {
			$tabs_data_count++;

			$tabs_data[ $tab_item ]['tab_slug']   = $tab_item;
			$tabs_data[ $tab_item ]['tab_name']   = $product_types[ $tab_item ];
			$tabs_data[ $tab_item ]['tab_query']  = $loop;
			$tabs_data[ $tab_item ]['tab_status'] = true;
		}
	}
} elseif ( 'categories' === $tabs_source ) {

	$tab_items = array();
	if ( 'slug' === $tabs_source_cat_term_field_type ) {
		$tab_items = $tabs_source_categories;
	} elseif ( 'term_id' === $tabs_source_cat_term_field_type ) {
		$tab_items = $tabs_source_categories_ids;
	}

	if ( $tab_items && is_array( $tab_items ) ) {
		foreach ( $tab_items as $tab_item ) {
			if ( is_numeric( $tab_item ) && is_string( $tab_item ) && 'term_id' === $tabs_source_cat_term_field_type ) {
				$tab_item = (int) $tab_item;
			}

			if ( term_exists( $tab_item, 'product_cat' ) ) {
				$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
					array(
						'taxonomy' => 'product_cat',
						'field'    => $tabs_source_cat_term_field_type,
						'terms'    => $tab_item,
					),
				);

				$loop = new WP_Query( $args );

				if ( $loop->have_posts() ) {
					$tabs_data_count++;

					$tab_item_term = get_term_by( $tabs_source_cat_term_field_type, $tab_item, 'product_cat' );

					$tabs_data[ $tab_item ]['tab_slug']   = $tab_item;
					$tabs_data[ $tab_item ]['tab_name']   = $tab_item_term->name;
					$tabs_data[ $tab_item ]['tab_query']  = $loop;
					$tabs_data[ $tab_item ]['tab_status'] = true;
				}
				wp_reset_postdata();
			}
		}
	}
}

if ( 0 === $tabs_data_count ) {
	return;
}

$this->add_render_attribute(
	array(
		'pgscore_multi_tab_product_listing' => array(
			'class' => array(
				'pgs-mtpl-wrapper',
				'pgs-mtpl-' . ( ( 'true' === $enable_intro ) ? 'with-intro' : 'without-intro' ),
				( ( 'carousel' === $listing_type ) ? 'multi_tab-products-listing-type-carousel' : '' ),
			),
		),
	)
);

$settings['tabs_data'] = $tabs_data;
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_multi_tab_product_listing' ); ?>>
		<div class="pgs-mtpl-inner">
			<div class="row">
				<?php
				if ( 'true' === $enable_intro ) {

					$this->add_render_attribute( 'pgscore_mtpl_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3' );
					$this->add_render_attribute( 'pgscore_mtpl_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9' );
					$this->add_render_attribute(
						array(
							'pgscore_mtpl_intro_classes' => array(
								'class' => array(
									'pgs-mtpl-intro-wrapper',
									'pgs-mtpl-intro-content-alignment-' . $intro_content_alignment,
									'pgs-mtpl-intro-bg_type-' . $intro_bg_type,
								),
							),
						)
					);
					?>
					<div <?php $this->print_render_attribute_string( 'pgscore_mtpl_intro_column_classes' ); ?>>
						<div <?php $this->print_render_attribute_string( 'pgscore_mtpl_intro_classes' ); ?>>
							<?php
							// Overlay.
							if ( $intro_bg_image_ol_color ) {
								?>
								<div class="pgs-mtpl-wrapper-overlay"></div>
								<?php
							}

							// Title.
							if ( $intro_title ) {
								?>
								<div class="mtpl-title"><h2><?php echo esc_html( $intro_title ); ?></h2></div>
								<?php
							}

							// Description.
							if ( $intro_description ) {
								?>
								<div class="mtpl-description"><?php echo esc_html( $intro_description ); ?></div>
								<?php
							}

							// Tabs.
							if ( 'intro' === $tabs_position ) {
								$this->get_templates( "{$this->widget_slug}/tabs", null, array( 'settings' => $settings ) );
							}

							// Controls.
							$this->add_render_attribute( 'pgscore_mtpl_controls', 'class', 'pgs-mtpl-control pgs-mtpl-control-' . $this->get_id() );
							?>
							<div <?php $this->print_render_attribute_string( 'pgscore_mtpl_controls' ); ?>>
								<div class="mtpl-arrows">
									<?php
									$arrow_sr = 1;
									foreach ( $tabs_data as $tab_item ) {

										$arrow_id = 'mtpl-' . $this->get_id() . '-arrow-' . $tab_item['tab_slug'];

										$arrow_active = '';
										if ( 1 === $arrow_sr ) {
											$arrow_active = ' active';
										}
										?>
										<div id="<?php echo esc_attr( $arrow_id ); ?>" class="mtpl-arrow<?php echo esc_attr( $arrow_active ); ?>"></div>
										<?php
										$arrow_sr++;
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
				} else {
					$this->add_render_attribute( 'pgscore_mtpl_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-12' );
				}
				?>
				<div <?php $this->print_render_attribute_string( 'pgscore_mtpl_item_column_classes' ); ?>>
					<div class="pgs-mtpl-main-wrapper">
						<?php
						if ( 'true' !== $enable_intro || 'top' === $tabs_position ) {

							$this->add_render_attribute( 'pgscore_mtpl_header_wrapper', 'class', 'pgs-mtpl-header-wrapper' );
							if ( 'top' === $tabs_position ) {
								$this->add_render_attribute( 'pgscore_mtpl_header_wrapper', 'class', 'pgs-mtpl-header-tabs_alignment-' . $tabs_alignment );
							}
							?>
							<div <?php $this->print_render_attribute_string( 'pgscore_mtpl_header_wrapper' ); ?>>
								<div class="pgs-mtpl-header-inner">
									<div class="row">
										<?php
										if ( 'true' !== $enable_intro ) {
											?>
											<div class="col">
												<?php
												// Title.
												if ( $intro_title ) {
													?>
													<div class="mtpl-title"><h2><?php echo esc_html( $intro_title ); ?></h2></div>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>
									</div>
									<?php
									if ( 'true' !== $enable_intro ) {
										?>
										<div class="row">
											<div class="col">
												<?php
												// Description.
												if ( $intro_description ) {
													?>
													<div class="mtpl-description"><?php echo esc_html( $intro_description ); ?></div>
													<?php
												}
												?>
											</div>
										</div>
										<?php
									}
									if ( 'top' === $tabs_position ) {
										?>
										<div class="row">
											<div class="col">
												<?php
												if ( 'top' === $tabs_position ) {
													$this->get_templates( "{$this->widget_slug}/tabs", null, array( 'settings' => $settings ) );
												}
												?>
											</div>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						<?php } ?>
						<div class="pgs-mtpl-products-wrapper">
							<?php $this->get_templates( "{$this->widget_slug}/tab-contents", null, array( 'settings' => $settings ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
