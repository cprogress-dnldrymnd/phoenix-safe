<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Counter Top Icon', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Counter', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'counter', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
