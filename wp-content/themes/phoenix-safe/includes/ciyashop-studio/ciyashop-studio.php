<?php
if ( ! apply_filters( 'ciyashop_studio_enabled', true ) ) {
	return;
}

// Elementor.
if ( did_action( 'elementor/loaded' ) ) {
	require_once get_parent_theme_file_path( '/includes/ciyashop-studio/elementor/elementor.php' );
}
