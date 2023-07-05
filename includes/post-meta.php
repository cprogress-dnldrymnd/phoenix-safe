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
              ),
            Field::make('text', 'resource_title', __('Resource Title')),
            Field::make('image', 'resource_thumbnail', __('Resource Thumbnail')),
            Field::make('file', 'resource_file', __('Resource File')),


          )
        )
        ->set_header_template('<%- resource_title %>')
    )
  );