<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Category List', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Category', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'category', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
