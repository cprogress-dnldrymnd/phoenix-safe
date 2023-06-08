<?php
// Reference: https://github.com/woocommerce/woocommerce/blob/8f5378a8166e2d242cfeb601bb9580195d41ab88/plugins/woocommerce/includes/wc-conditional-functions.php#L527
if ( ! function_exists( 'wc_wp_theme_get_element_class_name' ) ) {
	/**
	 * Given an element name, returns a class name.
	 *
	 * If the WP-related function is not defined, return empty string.
	 *
	 * @param string $element The name of the element.
	 *
	 * @since 7.1.0
	 * @return string
	 */
	function wc_wp_theme_get_element_class_name( $element ) {
		if ( function_exists( 'wp_theme_get_element_class_name' ) ) {
			return wp_theme_get_element_class_name( $element );
		}

		return '';
	}
}
