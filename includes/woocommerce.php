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


  $tabs['stockists'] = array(
    'title'    => __('Stockists', 'woocommerce'),
    'priority' => 50,
    'callback' => 'woo_stockists_tab_content'
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
          ?>

          <li class="col-md-3">
            <div class="inner">
              <a href="<?= wp_get_attachment_url($resource_file) ?>" target="_blank" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">

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

                  <span class="resource-btn d-inline-flex align-items-center disable-default-hover-no w-100 justify-content-between">
                    <?php
                    if ($resource_type == 'Brochure') {

                      echo 'READ THE BROCHURE';
                    } else if ($resource_type == 'Technical Data') {

                      echo 'READ THE SPEC';
                    } else {
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

      <?php } else { ?>

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

      xhr.onload = function() {

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
  <div class="resource-holder">

    <ul class="row" id="resources">


        <?php foreach ($resources_array as $resource_val) { ?>

          <?php
          $resource_product = $resource_val['resource_product'];
          $resource_type = $resource_val['resource_type'];
          $resource_title = $resource_val['resource_title'];
          $resource_thumbnail = $resource_val['resource_thumbnail'];
          $resource_file = $resource_val['resource_file'];
          ?>

          <li class="col-md-3">
            <div class="inner">
              <a href="<?= wp_get_attachment_url($resource_file) ?>" target="_blank" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">

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

                  <span class="resource-btn d-inline-flex align-items-center disable-default-hover-no w-100 justify-content-between">
                    <?php
                    if ($resource_type == 'Brochure') {

                      echo 'READ THE BROCHURE';
                    } else if ($resource_type == 'Technical Data') {

                      echo 'READ THE SPEC';
                    } else {
                      echo 'WATCH THE VIDEO';
                    }
                    ?>
                    <span class="icon-after btn-icon"><i aria-hidden="true" class="fas fa-arrow-right"></i></span>
                  </span>
                </div>
              </a>
            </div>

          </li>

    </ul>

  </div>

<?php
}
