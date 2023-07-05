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
  <div class="resources-holder">

    <ul class="row" id="resources">

      <?php if ($resources_array) { ?>

        <?php foreach ($resources_array as $resource_val) { ?>

          <?php

          $resource_product = $resource_val['resource_product'];
          $resource_type = $resource_val['resource_type'];
          $resource_title = $resource_val['resource_title'];
          $resource_thumbnail = $resource_val['resource_thumbnail'];
          $resource_file = $resource_val['resource_file'];

          ?>

          <li
            class="col-md-4">

            <a href="<?= wp_get_attachment_url( $resource_file ) ?>" target="_blank"
              class="woocommerce-LoopProduct-link woocommerce-loop-product__link">

              <div class="product-thumb-wrapper">

                <?= get_resource_image($resource_type, $resource_thumbnail) ?>

              </div>

              <h2 class="woocommerce-loop-product__title">

                <?= $resource_product ?>

                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px" y="0px" viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;"
                  xml:space="preserve">
                  <g>
                    <g>
                      <path
                        d="M409.6,153.6h-85.333c-9.426,0-17.067,7.641-17.067,17.067s7.641,17.067,17.067,17.067H409.6c9.426,0,17.067,7.641,17.067,17.067v221.867c0,9.426-7.641,17.067-17.067,17.067H68.267c-9.426,0-17.067-7.641-17.067-17.067V204.8c0-9.426,7.641-17.067,17.067-17.067H153.6c9.426,0,17.067-7.641,17.067-17.067S163.026,153.6,153.6,153.6H68.267c-28.277,0-51.2,22.923-51.2,51.2v221.867c0,28.277,22.923,51.2,51.2,51.2H409.6c28.277,0,51.2-22.923,51.2-51.2V204.8C460.8,176.523,437.877,153.6,409.6,153.6z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path
                        d="M335.947,243.934c-6.614-6.387-17.099-6.387-23.712,0L256,300.134V17.067C256,7.641,248.359,0,238.933,0s-17.067,7.641-17.067,17.067v283.068l-56.201-56.201c-6.78-6.548-17.584-6.361-24.132,0.419c-6.388,6.614-6.388,17.1,0,23.713l85.333,85.333c6.657,6.673,17.463,6.687,24.136,0.03c0.01-0.01,0.02-0.02,0.031-0.03l85.333-85.333C342.915,261.286,342.727,250.482,335.947,243.934z" />
                    </g>
                  </g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                  <g></g>
                </svg>

              </h2>
              <p>

                <?= $resource_title ?>

              </p>

            </a>

            <a class="trydus-btn  d-inline-flex align-items-center elementor-animation- disable-default-hover-no"
              href="<?= wp_get_attachment_url($resource_file) ?>" target="_blank">

              <?php
              if ($resource_type == 'Brochure') {

                echo 'READ THE BROCHURE';

              }
              else if ($resource_type == 'Technical Data') {

                echo 'READ THE SPEC';

              }
              else {
                echo 'WATCH THE VIDEO';
              }
              ?>
              <span class="icon-after btn-icon"><i aria-hidden="true" class="fas fa-arrow-right"></i></span>
            </a>

          </li>

        <?php } ?>

      <?php }
      else { ?>

        <li class="no-resource col-md-4">

          <h2>No resources found</h2>

        </li>

      <?php } ?>



    </ul>

  </div>
  <?php

}