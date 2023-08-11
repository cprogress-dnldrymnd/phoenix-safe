<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;




Container::make('post_meta', 'Resources')
  ->where('post_type', '=', 'product')
  ->add_fields(
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
$stockist_fields = array();


$args = array(
  'post_type' => 'stockists',
  'posts_per_page' => -1
);
$posts = get_posts($args);
foreach ($posts as $p) {
  $stockist_fields[] =  Field::make('text', 'stockist_' . $p->post_name, __($p->post_title));
}

Container::make('post_meta', 'Stockist')
  ->where('post_type', '=', 'product')
  ->add_fields($stockist_fields);
