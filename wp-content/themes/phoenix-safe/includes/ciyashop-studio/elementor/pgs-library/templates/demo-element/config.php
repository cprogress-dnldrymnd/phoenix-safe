<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
	'title'            => esc_html__( 'Demo Element', 'ciyashop' ), // Required
	'demo_url'         => '',
	'type'             => 'block',                                 // Required
	'category'         => array(                                   // Required
		esc_html__( 'Demo', 'ciyashop' ),
	),
	'tags'             => array(
		esc_html__( 'Test', 'ciyashop' ),
		esc_html__( 'Demo', 'ciyashop' ),
	),
);
