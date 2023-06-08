<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Banner With Text', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Banner', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'banner', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
