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
			if (have_rows('resources')) {
				while (have_rows('resources')) {
					the_row();
					if (isset($_GET['resource_type'])) {
						if (get_sub_field('resource_type') == $_GET['resource_type']) {
							$resources_array[] = array(
								'resource_product'   => get_the_title(),
								'resource_type'      => get_sub_field('resource_type'),
								'resource_title'     => get_sub_field('resource_title'),
								'resource_thumbnail' => get_sub_field('resource_thumbnail'),
								'resource_file'      => get_sub_field('resource_file'),
							);
						}
					}
					else {
						$resources_array[] = array(
							'resource_product'   => get_the_title(),
							'resource_type'      => get_sub_field('resource_type'),
							'resource_title'     => get_sub_field('resource_title'),
							'resource_thumbnail' => get_sub_field('resource_thumbnail'),
							'resource_file'      => get_sub_field('resource_file'),
						);
					}
				}
			}
			wp_reset_postdata();
		}
	}
	//echo '<pre>';
	//var_dump($resources_array);
	//echo '</pre>';

	?>

	<div class="trydus-woocommerce-page woocommerce">

		<div class="container">

			<div class="row justify-content-center">

				<div class="col-lg-3 col-md-4">

					<form role="search" method="get" class="woocommerce-product-search" id="resources_form">

						<div id="woocommerce_product_search-4" class="trydus-wc-widget col widget woocommerce widget_product_search">
							<h4 class="widget-title">Search</h4>



							<label class="screen-reader-text" for="woocommerce-product-search-field-0">Search for:</label>

							<input type="search" id="woocommerce-product-search-field-0" class="search-field"
								placeholder="Search resources.." value="" name="search">

						</div>

						<div class="custom-checkbox-list custom-checkbox-list-v2 resource-type with-border">

							<h4 class="widget-title">

								Resources

							</h4>

							<ul class="list-unstyled">

								<li class="<?= !(isset($_GET['resource_type'])) ? 'active' : '' ?>">
									<a href="">
										All
									</a>

								</li>


								<li
									class="<?= (isset($_GET['resource_type']) && $_GET['resource_type'] == 'Brochure') ? 'active' : '' ?>">
									<a href="?resource_type=Brochure">
										Brochures
									</a>

								</li>


								<li
									class="<?= (isset($_GET['resource_type']) && $_GET['resource_type'] == 'Technical Data') ? 'active' : '' ?>">
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

								<ul class="products columns-3 resources" id="resources">

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
												class="product type-product post-15169 status-publish first instock product_cat-rubber has-post-thumbnail shipping-taxable purchasable product-type-simple">

												<a href="<?= $resource_file['url'] ?>" target="_blank"
													class="woocommerce-LoopProduct-link woocommerce-loop-product__link">

													<div class="product-thumb-wrapper">

														<?= get_resource_image($resource_type, $resource_thumbnail) ?>

													</div>

													<h2 class="woocommerce-loop-product__title">

														<?= $resource_product ?>

														<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
															xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 477.867 477.867"
															style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve">
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
													href="<?= $resource_file['url'] ?>" target="_blank">

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

										<li class="no-resource">

											<h2>No resources found</h2>

										</li>

									<?php } ?>



								</ul>

								<div class="pagination">

									<?php pf_pagination($the_query); ?>

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

	jQuery(document).ready(function () {

		jQuery("#resources_form").change(function (e) {

			e.preventDefault();

			ajax();

		});

		jQuery('input[name="search"').keyup(function (event) {

			ajax();

		});



	});

	function ajax() {

		var file_type = jQuery("input[name='file_type[]']:checked");

		var resource_type = jQuery("input[name='resource_type[]']:checked");

		var search = jQuery("input[name='search']").val();

		var resource_type_array = [];

		var file_type_array = [];

		resource_type.each(function (index, el) {

			resource_type_array.push(jQuery(this).val());

		});

		file_type.each(function (index, el) {

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

				application: '<?= $application ?>',

			},

			success: function (response) {

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