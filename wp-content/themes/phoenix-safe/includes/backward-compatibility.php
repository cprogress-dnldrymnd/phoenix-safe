<?php
// Reference: https://github.com/WordPress/WordPress/blob/6.1/wp-includes/theme.php#L4220
if ( ! function_exists( 'wp_theme_get_element_class_name' ) ) {
	/**
	 * Given an element name, returns a class name.
	 *
	 * Alias of WP_Theme_JSON::get_element_class_name.
	 *
	 * @since 6.1.0
	 *
	 * @param string $element The name of the element.
	 *
	 * @return string The name of the class.
	 */
	function wp_theme_get_element_class_name( $element ) {
		return WP_Theme_JSON::get_element_class_name( $element );
	}
}
