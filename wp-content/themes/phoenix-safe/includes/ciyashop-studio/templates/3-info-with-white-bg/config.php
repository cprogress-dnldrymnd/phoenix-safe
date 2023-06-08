<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( '3 Info with White BG', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Info Box', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'info-box', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
