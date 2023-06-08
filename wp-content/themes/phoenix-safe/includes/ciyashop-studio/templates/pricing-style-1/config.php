<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Pricing Style 1', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Pricing', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'pricing', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
