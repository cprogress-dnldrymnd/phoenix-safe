<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Brand Newsletter & Instagram', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Brand', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'brand', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
