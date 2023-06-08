<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$listing_type            = isset( $settings['listing_type'] ) ? $settings['listing_type'] : '';
$list_grid_columns       = isset( $settings['list_grid_columns'] ) ? $settings['list_grid_columns'] : 2;
$list_grid_columns_small = isset( $settings['list_grid_columns_small'] ) ? $settings['list_grid_columns_small'] : 1;
$list_carousel_items_xs  = isset( $settings['list_carousel_items_xs'] ) ? $settings['list_carousel_items_xs'] : 1;
$list_carousel_items_sm  = isset( $settings['list_carousel_items_sm'] ) ? $settings['list_carousel_items_sm'] : 2;
$list_carousel_items_md  = isset( $settings['list_carousel_items_md'] ) ? $settings['list_carousel_items_md'] : 3;
$list_carousel_items_lg  = isset( $settings['list_carousel_items_lg'] ) ? $settings['list_carousel_items_lg'] : 4;
$list_carousel_items_xl  = isset( $settings['list_carousel_items_xl'] ) ? $settings['list_carousel_items_xl'] : 5;
$enable_intro            = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$intro_title             = isset( $settings['intro_title'] ) ? $settings['intro_title'] : '';
$loop                    = isset( $settings['loop'] ) ? $settings['loop'] : '';

$this->add_render_attribute( 'pgscore_product_listing_wrapper_classes', 'class', 'products-listing-items-wrapper woocommerce products-listing-' . $listing_type );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_product_listing_wrapper_classes' ); ?>>
	<?php if ( $loop->have_posts() ) : ?>

		<?php
			/**
			 * Hook woocommerce_before_shop_loop.
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

		$this->add_render_attribute( 'pgscore_product_listing_loop_class', 'class', 'products products-loop row grid' );
		if ( 'grid' === $listing_type ) {
			$this->add_render_attribute( 'pgscore_product_listing_loop_class', 'class', 'products-loop-column-' . $list_grid_columns );
			$this->add_render_attribute( 'pgscore_product_listing_loop_class', 'class', 'mobile-portrait-' . $list_grid_columns_small );
		} elseif ( 'carousel' === $listing_type ) {
			$this->add_render_attribute( 'pgscore_product_listing_loop_class', 'class', 'mobile-portrait-' . $list_carousel_items_xs );
			$this->add_render_attribute( 'pgscore_product_listing_loop_class', 'class', 'owl-carousel owl-theme owl-carousel-options' );
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
				'lazyLoad'           => true,
			);
			if ( 'yes' === $enable_intro ) {
				$owl_options_args['navContainer'] = ".products-listing-control.products-listing-control-{$this->get_id()} .products-listing-nav";
			} elseif ( 'yes' !== $enable_intro && $intro_title ) {
				$owl_options_args['navContainer'] = ".products-listing-header-control.products-listing-header-control-{$this->get_id()} .products-listing-nav";
			}

			$owl_options_args = apply_filters( 'pgscore_products_listing_widget_owl_options_args', $owl_options_args );
			$owl_options      = wp_json_encode( $owl_options_args );

			$this->add_render_attribute( 'pgscore_product_listing_loop_class', 'data-owl_options', $owl_options );
		}
		?>
		<ul <?php $this->print_render_attribute_string( 'pgscore_product_listing_loop_class' ); ?>>
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

				<?php
			endwhile; // end of the loop.
			?>

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
