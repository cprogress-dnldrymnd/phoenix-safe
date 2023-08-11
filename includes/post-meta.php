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


  
Container::make('post_meta', 'Resources')
->where('post_type', '=', 'stockists')
->add_fields(
  array(
    Field::make('complex', 'products')
      ->add_fields(
        array(
          Field::make('select', 'product', __('Resource Type'))
          ->set_options(get_posts_details('page'))
            )->set_width(25),
        )
      )
      ->set_header_template('<%- resource_title %>')
      ->set_layout('tabbed-vertical')
  )
);