<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Blog Style 1', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Blog', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'blog', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
