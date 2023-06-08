<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) && ! class_exists( 'YITH_WOOCOMPARE' ) ) {	
	return array(
		'id'               => 'woocommerce_compare',
		'title'            => esc_html__( 'Compare', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'       => 'show_compare',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show Compare', 'pgs-core' ),
				'subtitle' => esc_html__( 'Show Compare', 'pgs-core' ),
				'on'       => esc_html__( 'Yes', 'pgs-core' ),
				'off'      => esc_html__( 'No', 'pgs-core' ),
				'default'  => true,
			),
			array(
				'id'       => 'compare_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Compare Title', 'pgs-core' ),
				'desc'     => esc_html__( 'Add title for compare.', 'pgs-core' ),
				'default'  => esc_html__( 'Compare', 'pgs-core' ),
				'required' => array( 'show_compare', '=', true ),
			),
			array(
				'id'       => 'compare_empty_text',
				'type'     => 'textarea',
				'title'    => esc_html__( 'compare empty text', 'pgs-core' ),
				'desc'     => esc_html__( 'Enter text message for when compare is empty.', 'pgs-core' ),
				'default'  => esc_html__( 'No products added for the compare', 'pgs-core' ),
				'required' => array( 'show_compare', '=', true ),
			),
			array(
				'id'       => 'compare_fields_to_show',
				'type'     => 'select',
				'title'    => esc_html__( 'Fields to show', 'pgs-core' ),
				'desc'     => esc_html__( 'Select the fields to show in the comparison table and order them ( are also the WooCommerce attributes ). If no field is selected, then all the fields will be shown.', 'pgs-core' ),
				'options'  => ( function_exists( 'ciyashop_get_product_compare_fields' ) ? ciyashop_get_product_compare_fields() : array() ),
				'multi'    => true,
				'sortable' => true,
				'required' => array( 'show_compare', '=', true ),
			),
		),
	);
}
