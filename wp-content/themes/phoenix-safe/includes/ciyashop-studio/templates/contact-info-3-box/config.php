<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Contact Info 3 Box', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Contact Info', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'contact-info', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
