<?php

/*
Template name: Page Template : Resources
*/

?>

<?php get_header() ?>

<?php
while (have_posts()) {
	the_post();

?>

	<?php



	$args = array(

		'post_type'      => 'product',

		'posts_per_page' => -1,

		'orderby'        => 'modified',

		'order'          => 'DESC',

	);

	$the_query = new WP_Query($args);

	$resources_array = array();
	if ($the_query->have_posts()) {
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$resources = carbon_get_the_post_meta('resources');
			if ($resources) {
				foreach ($resources as $resource) {
					if (isset($_GET['resource_type'])) {
						if ($resource['resource_type'] == $_GET['resource_type']) {
							$resources_array[] = array(
								'resource_product'   => get_the_title(),
								'resource_type'      => $resource['resource_type'],
								'resource_title'     => $resource['resource_title'],
								'resource_thumbnail' => $resource['resource_thumbnail'],
								'resource_file'      => $resource['resource_file'],
								'embed_video_url'      => $resource['embed_video_url'],
							);
						}
					} else {
						$resources_array[] = array(
							'resource_product'   => get_the_title(),
							'resource_type'      => $resource['resource_type'],
							'resource_title'     => $resource['resource_title'],
							'resource_thumbnail' => $resource['resource_thumbnail'],
							'resource_file'      => $resource['resource_file'],
							'embed_video_url'      => $resource['embed_video_url'],
						);
					}
				}
			}
			wp_reset_postdata();
		}
	}
	?>

	<div class="trydus-woocommerce-page woocommerce">

		<div class="container">

			<div class="row justify-content-center">

				<div class="col-lg-3 col-md-4">

					<form role="search" method="get" class="woocommerce-product-search" id="resources_form">

						<div class="trydus-wc-widget  widget woocommerce widget_product_search">
							<h4 class="widget-title">Search</h4>



							<label class="screen-reader-text" for="woocommerce-product-search-field-0">Search for:</label>

							<input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="Search resources.." value="" name="search">

						</div>

						<div class="custom-checkbox-list custom-checkbox-list-v2 resource-type with-border">

							<h4 class="widget-title">
								Resources
							</h4>

							<ul class="list-unstyled resource-type">

								<li class="<?= !(isset($_GET['resource_type'])) ? 'active' : '' ?>">
									<a href="./">
										All
									</a>

								</li>


								<li class="<?= (isset($_GET['resource_type']) && $_GET['resource_type'] == 'Brochure') ? 'active' : '' ?>">
									<a href="?resource_type=Brochure">
										Brochures
									</a>

								</li>


								<li class="<?= (isset($_GET['resource_type']) && $_GET['resource_type'] == 'Technical Data') ? 'active' : '' ?>">
									<a href="?resource_type=Technical Data">
										Technical Data
									</a>
								</li>

								<li class="<?= (isset($_GET['resource_type']) && $_GET['resource_type'] == 'Videos') ? 'active' : '' ?>">
									<a href="?resource_type=Videos">
										Videos
									</a>
								</li>



							</ul>

						</div>



					</form>

				</div>

				<div class="col-lg-9 col-md-8 woo-has-sidebar trydus-shop-items-wrap">

					<main id="primary" class="site-main">

						<div id="results">

							<div class="results-holder">

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
											} else {
												$link = $embed_video_url;
											}
											?>

											<li class="col-md-4">
												<div class="inner">
													<a href="<?= $link ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-fancybox>

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

								<div class="pagination">

								</div>

							</div>

						</div>

					</main><!-- #main -->

				</div>

			</div>

		</div>



	</div>
<?php } ?>

<?php get_footer() ?>




<script>
	jQuery(document).ready(function() {

		jQuery("#resources_form").change(function(e) {

			e.preventDefault();

			ajax();

		});

		jQuery('input[name="search"').keyup(function(event) {

			ajax();

		});
		s


	});

	function ajax() {

		var file_type = jQuery("input[name='file_type[]']:checked");

		var resource_type = jQuery("input[name='resource_type[]']:checked");

		var search = jQuery("input[name='search']").val();

		var resource_type_array = [];

		var file_type_array = [];

		resource_type.each(function(index, el) {

			resource_type_array.push(jQuery(this).val());

		});

		file_type.each(function(index, el) {

			file_type_array.push(jQuery(this).val());

		});





		$loading = jQuery('<div class="loading"> <i class="fas fa-spinner rotating"> </div>');

		jQuery('#resources_form').addClass('searching');



		jQuery('#results  .results-holder').html($loading);

		jQuery.ajax({

			type: "POST",

			url: "/wp-admin/admin-ajax.php",

			data: {

				action: 'resources',

				file_type: file_type_array,

				resource_type: resource_type_array,

				search: search,


			},

			success: function(response) {

				jQuery('#results .results-holder').html(response);

				jQuery('#resources_form').removeClass('searching');

			}

		});

	}



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