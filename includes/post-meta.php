<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;


$stockist_fields = array();

$args = array(
  'post_type' => 'stockists',
  'posts_per_page' => -1
);
$posts = get_posts($args);
foreach ($posts as $p) {
  $stockist_fields[] =  Field::make('text', 'stockist_' . $p->post_name, __($p->post_title));
}


Container::make('post_meta', 'Product Data')
  ->where('post_type', '=', 'product')
  ->add_tab(
    'Resources',
    array(
      Field::make('complex', 'resources')
        ->add_fields(
          array(
            Field::make('radio', 'resource_type', __('Resource Type'))
              ->set_options(
                array(
                  'Brochure' => 'Brochure',
                  'Technical Data' => 'Technical Data',
                  'Videos' => 'Videos',
                )
              )->set_width(25),
            Field::make('text', 'resource_title', __('Resource Title'))->set_width(25),
            Field::make('image', 'resource_thumbnail', __('Resource Thumbnail'))->set_width(25),
            Field::make('file', 'resource_file', __('Resource File'))->set_width(25),


          )
        )
        ->set_header_template('<%- resource_title %>')
        ->set_layout('tabbed-vertical')
    )
  )
  ->add_tab('Stockists', $stockist_fields)
  ->add_tab(
    'Specifications',
    array(
      Field::make('text', 'fire_protection', __('Fire Protection')),
      Field::make('text', 'drop_test', __('Drop Test')),
      Field::make('text', 'ventilation', __('Ventilation')),
      Field::make('text', 'temperature', __('Temperature')),
      Field::make('text', 'doors', __('Doors')),
      Field::make('text', 'locking', __('Locking')),
      Field::make('text', 'construction', __('Construction')),
      Field::make('text', 'power', __('Power')),
      Field::make('text', 'shelving', __('shelving')),
      Field::make('text', 'multipoint_lock', __('Multipoint Lock')),
      Field::make('text', 'keypad', __('Keypad')),
      Field::make('text', 'alarm', __('Alarm')),
      Field::make('text', 'water_resist', __('Water Resist')),
      Field::make('text', 'combination', __('Combination')),
      Field::make('text', 'laptop', __('Laptop')),
      Field::make('text', 'keyhole', __('Keyhole')),
      Field::make('text', 'fingerprint', __('Fingerprint')),
      Field::make('text', 'insurance', __('Insurance')),
    )
    );


/*
Container::make('post_meta', 'Product Lists')
  ->where('post_type', '=', 'stockists')
  ->add_fields(
    array(
      Field::make('complex', 'products')
        ->add_fields(
          array(
            Field::make('select', 'product', __('Product'))
              ->set_options(get_posts_details('product')),
            Field::make('text', 'product_url', __('Product URL'))

          )
        )
        ->set_header_template('<%- product %>')
        ->set_layout('tabbed-vertical')
    )
  );

*/
