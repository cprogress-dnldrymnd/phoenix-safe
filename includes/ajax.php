<?php
add_action('wp_ajax_nopriv_resources', 'resources'); // for not logged in users
add_action('wp_ajax_resources', 'resources');
function resources()
{
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
						if ($_GET['resource_type'] == 'Videos') {
							if ($resource['resource_type'] == 'Videos' || $resource['resource_type'] == 'Videos Embed') {
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
						else {
							if ($resource['resource_type'] == $_GET['resource_type']) {
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
					}
					else {
						$resources_array[] = array(
							'resource_product'   => get_the_title(),
							'resource_type'      => $resource['resource_type'],
							'resource_title'     => $resource['resource_title'],
							'resource_thumbnail' => $resource['resource_thumbnail'],
							'resource_file'      => $resource['resource_file'],
						);
					}
				}
			}
			wp_reset_postdata();
		}
	}
	?>
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

				<li class="col-md-4">
					<div class="inner">
						<a href="<?= $link ?>" target="_blank"
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

	<?php

	die();
}