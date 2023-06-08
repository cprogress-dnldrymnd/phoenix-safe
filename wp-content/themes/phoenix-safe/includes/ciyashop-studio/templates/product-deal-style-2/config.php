<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Product Deal Style 2', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Deal', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'deal', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
