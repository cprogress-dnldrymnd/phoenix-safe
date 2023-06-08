<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Services Left Right Box 2', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Service', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'service', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
