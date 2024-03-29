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
        'embed_video_url'    => $resource['embed_video_url'],
      );
    }
  }
  ?>
  <div class="resource-holder">

    <ul class="row" id="resources">

      <?php if ($resources_array) { ?>

        <?php foreach ($resources_array as $resource_val) { ?>

          <?php
          $resource_product = $resource_val['resource_product'];
          $resource_type = $resource_val['resource_type'];
          $resource_title = $resource_val['resource_title'];
          $resource_thumbnail = $resource_val['resource_thumbnail'];
          $resource_file = $resource_val['resource_file'];
          $embed_video_url = $resource_val['embed_video_url'];

          if ($resource_type != 'Videos Embed') {
            $link = wp_get_attachment_url($resource_file);
          }
          else {
            $link = $embed_video_url;
          }
          ?>

          <li class="col-md-3">
            <div class="inner">
              <a href="<?= wp_get_attachment_url($resource_file) ?>" target="_blank"
                class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-fancybox>

                <div class="image-box">

                  <?= get_resource_image($resource_type, $resource_thumbnail) ?>

                </div>

                <div class="bottom-box">
                  <div class="heading-box">
                    <h3><?= $resource_product ?></h3>
                  </div>
                  <div class="title-box">
                    <h2>
                      <?= $resource_title ?>
                    </h2>
                  </div>

                  <span
                    class="resource-btn d-inline-flex align-items-center disable-default-hover-no w-100 justify-content-between">
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
                  </span>
                </div>
              </a>
            </div>

          </li>

        <?php } ?>

      <?php }
      else { ?>

        <li class="no-resource col-md-12">

          <h2>No resources found</h2>

        </li>

      <?php } ?>

    </ul>

  </div>
  <script>
    function forceDownload(link) {

      var url = link.getAttribute("data-href");

      var fileName = link.getAttribute("download");

      var xhr = new XMLHttpRequest();

      xhr.open("GET", url, true);

      xhr.responseType = "blob";

      xhr.onload = function () {

        var urlCreator = window.URL || window.webkitURL;

        var imageUrl = urlCreator.createObjectURL(this.response);

        var tag = document.createElement('a');

        tag.href = imageUrl;

        tag.download = fileName;

        document.body.appendChild(tag);

        tag.click();

        document.body.removeChild(tag);

      }

      xhr.send();

    }
  </script>
  <?php

}


function woo_stockists_tab_content()
{
  ob_start();
  ?>
  <div class="product-stockist-holder mt-4">

    <h3>Buy Online</h3>

    <?php
    $args = array(
      'post_type'      => 'stockists',
      'posts_per_page' => -1,
      'orderby' => 'rand'
    );
    $product_id = get_the_ID();
    $stockist_arr = array();
    $posts = get_posts($args);
    foreach ($posts as $p) {
      $post_name = get_post_meta($p->ID, '_stockist_code', true);

      $url = carbon_get_post_meta($product_id, 'stockist_' . $post_name);
      if ($url) {
        $stockist_arr[] = array(
          'stockist_id' => $p->ID,
          'product_url' => $url
        );
      }
    }


    ?>
    <div class="product-stockist">
      <div class="row">
        <?php foreach ($stockist_arr as $stockist) { ?>
          <div class="col-lg-2">
            <a href="<?= $stockist['product_url'] ?>">
              <div class="image-box">
                <img src="<?= get_the_post_thumbnail_url($stockist['stockist_id'], 'medium') ?>" alt="">
              </div>
            </a>
          </div>
        <?php } ?>
      </div>

    </div>
  </div>

  <?php
  return ob_get_clean();
}


add_filter('woocommerce_short_description', 'add_text_after_excerpt_single_product', 20, 1);
function add_text_after_excerpt_single_product($post_excerpt)
{
  ob_start();
  echo $post_excerpt;
  echo woo_stockists_tab_content();
  $SVG = new SVG;
  $specs = array(
    'fire_protection',
    'drop_test',
    'ventilation',
    'temperature',
    'doors',
    'locking',
    'construction',
    'power',
    'shelving',
    'multipoint_lock',
    'keypad',
    'alarm',
    'water_resist',
    'combination',
    'laptop',
    'keyhole',
    'fingerprint',
    'insurance'
  );
  ?>
  <div class="specs-box mt-4">
    <ul>
      <?php foreach ($specs as $spec) { ?>
        <?php
        $spec_val = carbon_get_the_post_meta($spec);
        ?>
        <?php if ($spec_val) { ?>

          <li class="d-flex">
            <div class="icon"><?= $SVG->$spec ?></div>
            <div class="text">
              <p class="title">
                <strong> <?= str_replace('_', " ", $spec); ?> </strong>
              </p>
              <div>
                <?= wpautop($spec_val) ?>
              </div>
            </div>
          </li>

        <?php } ?>
      <?php } ?>

    </ul>
  </div>
  <?php
  return ob_get_clean();
}


/**
 * Remove related products output
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 99);