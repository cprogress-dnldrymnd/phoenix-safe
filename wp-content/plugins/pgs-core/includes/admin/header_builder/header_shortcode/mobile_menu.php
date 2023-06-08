<?php
/**
 *  Do not allow directly accessing this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['mobile_menu'] = header_builder_element_mobile_menu();

function header_builder_element_mobile_menu() {
	$shortcode_fields = array(
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Menu Type', 'pgs-core' ),
			'param_name'  => 'menu_type',
			'options'     => array(
				'side_menu' => __( 'Side Menu', 'pgs-core' ),
				'slick_nav' => __( 'Slick Nav', 'pgs-core' ),
			),
			'default'     => 'slick_nav',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose mobile menu type.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Side Menu Position', 'pgs-core' ),
			'param_name'  => 'menu_position',
			'options'     => array(
				'left_side'  => __( 'Left Side', 'pgs-core' ),
				'right_side' => __( 'Right Side', 'pgs-core' ),
			),
			'default'     => 'right_side',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose mobile menu position.', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'side_menu'),
			),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Side Menu Color', 'pgs-core' ),
			'param_name'  => 'menu_color',
			'options'     => array(
				'light' => __( 'Light', 'pgs-core' ),
				'dark'  => __( 'Dark', 'pgs-core' ),
			),
			'default'     => 'light',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose mobile menu color scheme.', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'side_menu'),
			),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Search For Side Menu', 'pgs-core' ),
			'param_name'  => 'sidemnu_search',
			'options'     => esc_html__( 'Enable search', 'pgs-core' ),
			'default'     => false,
			'description' => esc_html__( 'Add search in side menu.', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'side_menu'),
			),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories For Side Menu', 'pgs-core' ),
			'param_name'  => 'sidemnu_category',
			'options'     => esc_html__( 'Enable category', 'pgs-core' ),
			'default'     => false,
			'description' => esc_html__( 'Add category in side menu.', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'side_menu'),
			),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'color_settings',
			'heading'    => esc_html__( 'Color Settings', 'pgs-core' ),
			'param_name' => 'menu_colors',
			'text_color' => false,
			'group'      => esc_html__( 'General', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'slick_nav'),
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'pgs-core' ),
			'param_name' => 'menu_bg_color',
			'group'      => esc_html__( 'General', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'slick_nav'),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'ID', 'pgs-core' ),
			'param_name'  => 'element_id',
			'description' => sprintf(
				wp_kses(
					__( 'Enter ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>)', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'http://www.w3schools.com/tags/att_global_id.asp'
			)
							. '<br><span class="pgs-core-red">' .
							sprintf(
								wp_kses(
									__( 'Important : ID will be starts prefixed with "%s".', 'pgs-core' ),
									array(
										'atrong' => true,
									)
								),
								'<strong>mobile_menu_' . '</strong>'
							)
							. '</span>',
			'settings'    => array(),
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'pgs-core' ),
			'param_name'  => 'element_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pgs-core' ),
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
	);

	// Params
	$params = array(
		'id'           => 'mobile_menu',
		'name'         => esc_html__( 'Mobile Menu', 'pgs-core' ),
		'description'  => esc_html__( 'Display mobile menu', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'device'       => 'mobile',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/menu-icon.png',
		'element_icon' => 'ti-menu',
		'params'       => $shortcode_fields,
	);

	return $params;

}
