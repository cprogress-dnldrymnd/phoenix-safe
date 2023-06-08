<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$enable_intro            = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$tabs_data               = isset( $settings['tabs_data'] ) ? $settings['tabs_data'] : '';
$listing_type            = isset( $settings['listing_type'] ) ? $settings['listing_type'] : '';
$list_grid_columns       = isset( $settings['list_grid_columns'] ) ? $settings['list_grid_columns'] : 3;
$list_grid_columns_small = isset( $settings['list_grid_columns_small'] ) ? $settings['list_grid_columns_small'] : 1;
$list_carousel_items_xs  = isset( $settings['list_carousel_items_xs'] ) ? $settings['list_carousel_items_xs'] : 1;
$list_carousel_items_sm  = isset( $settings['list_carousel_items_sm'] ) ? $settings['list_carousel_items_sm'] : 2;
$list_carousel_items_md  = isset( $settings['list_carousel_items_md'] ) ? $settings['list_carousel_items_md'] : 3;
$list_carousel_items_lg  = isset( $settings['list_carousel_items_lg'] ) ? $settings['list_carousel_items_lg'] : 4;
$list_carousel_items_xl  = isset( $settings['list_carousel_items_xl'] ) ? $settings['list_carousel_items_xl'] : 5;

$this->add_render_attribute( 'pgscore_mtpl_listing_wrapper', 'class', 'mtpl-listing-wrapper woocommerce mtpl-listing-type-' . $listing_type );
?>
<div class="tab-content">
	<?php
	$tab_content_sr = 1;

	foreach ( $tabs_data as $tab_item ) {
		$tab_id   = 'mtpl-' . $this->get_id() . '-tab-' . $tab_item['tab_slug'];
		$arrow_id = 'mtpl-' . $this->get_id() . '-arrow-' . $tab_item['tab_slug'];
		$loop     = $tab_item['tab_query'];

		$tab_content_active = '';
		if ( 1 === $tab_content_sr ) {
			$tab_content_active = ' show active';
		}
		?>
		<div class="tab-pane fade<?php echo esc_attr( $tab_content_active ); ?>" id="<?php echo esc_attr( $tab_id ); ?>" role="tabpanel">
			<div <?php $this->print_render_attribute_string( 'pgscore_mtpl_listing_wrapper' ); ?>>
				<div class="mtpl-listing-inner">

					<?php if ( $loop->have_posts() ) : ?>

						<?php
						/**
						 * Hook woocommerce_before_shop_loop..
						 *
						 * @hooked wc_print_notices - 10
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
						?>

						<?php
						// Setting ported from woocommerce_product_loop_start().
						$GLOBALS['woocommerce_loop']['loop'] = 0;

						$listing_classes = array(
							'products',
							'products-loop',
							'row',
							'grid',
						);

						$carousel_option = '';

						if ( 'grid' === $listing_type ) {
							$listing_classes[] = "products-loop-column-{$list_grid_columns}";
							$listing_classes[] = "mobile-portrait-{$list_grid_columns_small}";
						} elseif ( 'carousel' === $listing_type ) {
							$listing_classes[] = 'owl-carousel owl-theme owl-carousel-options';
							$listing_classes[] = "mobile-portrait-{$list_carousel_items_xs}";

							$owl_options_args = array(
								'items'              => 3,
								'responsive'         => array(
									0    => array(
										'items' => $list_carousel_items_xs,
									),
									480  => array(
										'items' => $list_carousel_items_sm,
									),
									768  => array(
										'items' => $list_carousel_items_md,
									),
									992  => array(
										'items' => $list_carousel_items_lg,
									),
									1200 => array(
										'items' => $list_carousel_items_xl,
									),
								),
								'margin'             => 20,
								'dots'               => false,
								'nav'                => true,
								'loop'               => true,
								'autoplay'           => false,
								'autoplayHoverPause' => true,
								'autoplayTimeout'    => 3100,
								'smartSpeed'         => 1000,
								'navText'            => array(
									'<i class="fas fa-angle-left fa-2x"></i>',
									'<i class="fas fa-angle-right fa-2x"></i>',
								),
							);

							if ( 'true' === $enable_intro ) {
								$owl_options_args['navContainer'] = "#{$arrow_id}";
							}

							$carousel_option = wp_json_encode( $owl_options_args );
						}

						$listing_classes = implode( ' ', $listing_classes );
						?>
						<ul class="<?php echo esc_attr( $listing_classes ); ?>" data-owl_options="<?php echo esc_attr( ( 'carousel' === $listing_type ) ? $carousel_option : '' ); ?>">

							<?php
							while ( $loop->have_posts() ) :
								$loop->the_post();

								if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {

									if ( ! class_exists( 'YITH_Woocompare' ) && function_exists( 'ciyashop_wc_compare' ) ) {
										ciyashop_wc_compare();
									}

									if ( function_exists( 'ciyashop_set_product_list_elements' ) ) {
										ciyashop_set_product_list_elements();
									}
									if ( function_exists( 'ciyashop_before_page_wrapper_check' ) ) {
										ciyashop_before_page_wrapper_check();
									}
									if ( function_exists( 'ciyashop_wc_wishlist' ) ) {
										ciyashop_wc_wishlist();
									}
									if ( function_exists( 'ciyashop_wc_set_add_to_cart_element' ) ) {
										ciyashop_wc_set_add_to_cart_element();
									}

									add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
									add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
									if ( function_exists( 'ciyashop_shop_loop_item_hover_style_init' ) ) {
										add_action( 'woocommerce_before_shop_loop', 'ciyashop_shop_loop_item_hover_style_init' );
									}
									add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
									add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
									add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
								}
								?>

								<?php
								/**
								 * Hook woocommerce_shop_loop.
								 *
								 * @hooked WC_Structured_Data::generate_product_data() - 10
								 */
								do_action( 'woocommerce_shop_loop' );
								?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>

							<?php wp_reset_postdata(); ?>

						<?php woocommerce_product_loop_end(); ?>

						<?php
						/**
						 * Hook woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
						?>

					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		$tab_content_sr++;
	}
	?>
</div>
