<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Weapon Hotspots', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Hotspots', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'hotspots', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
