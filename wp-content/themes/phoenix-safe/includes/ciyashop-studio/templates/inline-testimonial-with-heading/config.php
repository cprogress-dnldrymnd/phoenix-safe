<?php
defined( 'ABSPATH' ) || exit('restricted access');

return array(
    'title'            => esc_html__( 'Inline Testimonial With Heading', 'ciyashop' ), // Required
    'demo_url'         => '',
    'type'             => 'block',                                 // Required
    'category'         => array(                                   // Required
        esc_html__( 'Testimonials', 'ciyashop' ),
    ),
    'tags'             => array(
        esc_html__( 'testimonials', 'ciyashop' ),
        esc_html__( 'feature', 'ciyashop' ),
    ),
);
