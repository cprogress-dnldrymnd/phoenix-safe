<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Icon with Video Style 1', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Feature Box', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'feature-box', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
