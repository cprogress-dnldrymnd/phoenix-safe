<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'App Style 1', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'App', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'app', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
