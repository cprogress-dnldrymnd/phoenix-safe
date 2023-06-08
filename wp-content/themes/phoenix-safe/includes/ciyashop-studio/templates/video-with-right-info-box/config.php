<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Video with Right Info Box', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Video', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'video', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
