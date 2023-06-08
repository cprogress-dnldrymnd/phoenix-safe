<?php
/**
 * Add "Add to Cart" to "ciyashop_product_actions"
 *
 * @package CiyaShop
 */

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'ciyashop_before_page_wrapper', 'ciyashop_wc_set_add_to_cart_element', 20 );
/**
 * Wc set add to cart element
 */
function ciyashop_wc_set_add_to_cart_element() {
	global $ciyashop_options, $cs_product_list_styles;

	if ( ! isset( $ciyashop_options['hide_price_for_guest_user'] ) || ( isset( $ciyashop_options['hide_price_for_guest_user'] ) && ! $ciyashop_options['hide_price_for_guest_user'] ) || is_user_logged_in() ) {

		$product_hover_style = ciyashop_product_hover_style();

		switch ( $product_hover_style ) {
			case $cs_product_list_styles['minimal']:
			case $cs_product_list_styles['standard-quick-shop']:
					add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 25 );
				break;
			case $cs_product_list_styles['icons-left']:
			case $cs_product_list_styles['icons-rounded']:
			case $cs_product_list_styles['minimal-hover-cart']:
					add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
				break;
			case $cs_product_list_styles['info-transparent-center']:
			case $cs_product_list_styles['standard-icons-left']:
			case $cs_product_list_styles['button-standard']:
			case $cs_product_list_styles['button-standard']:
					add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 35 );
				break;
			case $cs_product_list_styles['grocery-1']:
			case $cs_product_list_styles['grocery-2']:
					add_action( 'ciyashop_product_info_right_open', 'woocommerce_template_loop_add_to_cart', 35 );
				break;
			case $cs_product_list_styles['icons-transparent-center']:
					add_action( 'ciyashop_product_actions', 'woocommerce_template_loop_add_to_cart', 20 );
				break;
			default:
					add_action( 'ciyashop_product_actions', 'woocommerce_template_loop_add_to_cart', 7 );
				break;

		}
	}
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'ciyashop_woocommerce_loop_add_to_cart_link', 10, 3 );
/**
 * Wc set add to cart element
 *
 * @param string $link .
 * @param string $product .
 */
function ciyashop_woocommerce_loop_add_to_cart_link( $link, $product, $args ) {
	if ( $product->is_in_stock() ) {
		$position      = ciyashop_get_tooltip_position();
		$cart_position = isset( $position['cart_icon'] ) ? $position['cart_icon'] : '';
		if ( $cart_position ) {
			return '<div class="product-action product-action-add-to-cart" data-toggle="tooltip" data-original-title="' . esc_attr__( 'Add To Cart', 'ciyashop' ) . '" data-placement="' . esc_attr( $cart_position ) . '">' . $link . '</div>';
		} else {
			$product_hover_style = ciyashop_product_hover_style();
			if ( in_array( $product_hover_style, array( 'grocery-1', 'grocery-2' ), true ) && $product->is_purchasable() && 'variable' !== $product->get_type() ) {
				ob_start();
				?>
				<div class="product-action product-action-add-to-cart">
					<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>">
						<?php
						woocommerce_quantity_input(
							array(
								'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
								'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
								'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
							)
						);
						?>
						<button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
						<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
						<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
					</form>
				</div>
				<?php
				return ob_get_clean();
			} else {
				return '<div class="product-action product-action-add-to-cart">' . $link . '</div>';
			}
		}
	}
	return '';
}
