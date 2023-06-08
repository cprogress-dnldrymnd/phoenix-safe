<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Product With Banner 3', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Product', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'newsletter', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
