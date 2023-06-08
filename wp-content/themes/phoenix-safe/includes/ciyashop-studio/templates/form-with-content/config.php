<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Form With Content', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Form', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'form', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
