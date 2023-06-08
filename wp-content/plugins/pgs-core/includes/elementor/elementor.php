<?php
// Define PGSCORE_INC_PATH and PGSCORE_INC_URL.
define( 'PGSCORE_ELEMENTOR_PATH', trailingslashit( PGSCORE_PATH ) . 'includes//elementor' );
define( 'PGSCORE_ELEMENTOR_URL', trailingslashit( PGSCORE_URL ) . 'includes//elementor' );
define( 'PGSCORE_ELEMENTOR_CAT', 'aqb-potenza' );

add_action( 'plugins_loaded', 'pgscore_elementor_init' );
function pgscore_elementor_init() {
	require_once trailingslashit( PGSCORE_ELEMENTOR_PATH ) . 'class-pgscore-elementor.php';
}

/**
 * Reorder Widget Categories.
 * Ref: https://github.com/elementor/elementor/issues/7445#issuecomment-472822406
 */
function add_elementor_widget_categories( \Elementor\Elements_Manager $elements_manager ) {

	$category_prefix = 'aqb-';

	$elements_manager->add_category(
		PGSCORE_ELEMENTOR_CAT,
		array(
			'title' => esc_html__( 'Potenza Elements', 'pgs-core' ),
			'icon'  => 'font',
		)
	);

	// Hack into the private $categories member, and reorder it so our stuff is at the top.
	$reorder_cats = function() use( $category_prefix ) {
		uksort( $this->categories, function( $keyOne, $keyTwo ) use( $category_prefix ) {
			if ( substr( $keyOne, 0, 4 ) == $category_prefix ) {
				return -1;
			}
			if ( substr( $keyTwo, 0, 4 ) == $category_prefix ) {
				return 1;
			}
			return 0;
		});
	};

	$reorder_cats->call( $elements_manager );
}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
