<?php
/**
 * Add a custom product data tab
 */
add_filter('woocommerce_product_tabs', 'woo_resources_tab');
function woo_resources_tab($tabs)
{

  // Adds the new tab

  $tabs['resources'] = array(
    'title'    => __('Resources', 'woocommerce'),
    'priority' => 50,
    'callback' => 'woo_resources_tab_content'
  );

  return $tabs;

}
function woo_resources_tab_content()
{
  $resources = carbon_get_the_post_meta('resources');
  if ($resources) {
    foreach ($resources as $resource) {
      $resources_array[] = array(
        'resource_product'   => get_the_title(),
        'resource_type'      => $resource['resource_type'],
        'resource_title'     => $resource['resource_title'],
        'resource_thumbnail' => $resource['resource_thumbnail'],
        'resource_file'      => $resource['resource_file'],
      );
    }
  }
  ?>
  
  <?php

}