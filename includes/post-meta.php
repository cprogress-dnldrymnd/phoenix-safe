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
      Field::make('textarea', 'fire_protection', __('Fire Protection'))->set_width(33),
      Field::make('textarea', 'drop_test', __('Drop Test'))->set_width(33),
      Field::make('textarea', 'ventilation', __('Ventilation'))->set_width(33),
      Field::make('textarea', 'temperature', __('Temperature'))->set_width(33),
      Field::make('textarea', 'doors', __('Doors'))->set_width(33),
      Field::make('textarea', 'locking', __('Locking'))->set_width(33),
      Field::make('textarea', 'construction', __('Construction'))->set_width(33),
      Field::make('textarea', 'power', __('Power'))->set_width(33),
      Field::make('textarea', 'shelving', __('Shelving'))->set_width(33),
      Field::make('textarea', 'multipoint_lock', __('Multipoint Lock'))->set_width(33),
      Field::make('textarea', 'keypad', __('Keypad'))->set_width(33),
      Field::make('textarea', 'alarm', __('Alarm'))->set_width(33),
      Field::make('textarea', 'water_resist', __('Water Resist'))->set_width(33),
      Field::make('textarea', 'combination', __('Combination'))->set_width(33),
      Field::make('textarea', 'laptop', __('Laptop'))->set_width(33),
      Field::make('textarea', 'keyhole', __('Keyhole'))->set_width(33),
      Field::make('textarea', 'fingerprint', __('Fingerprint'))->set_width(33),
      Field::make('textarea', 'insurance', __('Insurance'))->set_width(33),
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
Container::make('post_meta', 'Stockist Code')
  ->where('post_type', '=', 'stockists')
  ->add_fields(
    array(
      Field::make('text', 'stockist_code', '')
      ->set_help_text('Please make it unique for each')
    )
  );