<?php
require_once get_parent_theme_file_path( '/includes/ciyashop-studio/elementor/pgs-library/class-pgs-library.php' );

/**
 * Initializes the PGS_Library.
 */
$pgs_library = pgs_library(
	array(
		'pgs_library_title'         => esc_html__( 'Ciyashop Studio', 'ciyashop' ),
		'pgs_library_templates_dir' => get_parent_theme_file_path( '/includes/ciyashop-studio/templates' ),
		'pgs_library_templates_url' => get_parent_theme_file_uri( '/includes/ciyashop-studio/templates' )
	)
);
