<?php 
add_action('wp_ajax_nopriv_resources', 'resources'); // for not logged in users
add_action('wp_ajax_resources', 'resources');
function resources() {
	$file_type = $_POST['file_type'];
	$resource_type = $_POST['resource_type'];
	$application = $_POST['application'];
	$search = $_POST['search'];
	
	if($file_type) {
		$file_type_arr = array();
		foreach($file_type as $filetype) {
			$file_type_arr[] = $filetype;
		}
		$meta_query = array(
			'relation'		=> 'AND',
			array(
				'key'	 	=> 'file_type',
				'value'	  	=> $file_type_arr,
				'compare' 	=> 'IN',
			),
		);
	}
	

	$tax_query = array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'application_category',
			'field'    => 'slug',
			'terms'    => $application,
		),
	);
	if($resource_type) {
		$resource_arr = array();
		foreach($resource_type as $resource) {
			$resource_arr[] = $resource;
		}
		$tax_query[] = array(
			'taxonomy' => 'resource_type',
			'field'    => 'slug',
			'terms'    => $resource_arr,
			'operator' => 'IN'
		);
	}

	$args = array(
		'post_type' => 'resources',
		'posts_per_page' => -1,
		's'=> $search,
		'tax_query' => $tax_query,
		'meta_query' => $meta_query,
	);
	$the_query = new WP_Query( $args );
	?>
	<ul class="products columns-3 resources" id="resources">
		<?php if ( $the_query->have_posts() ) { ?>
			<?php while ( $the_query->have_posts() ) { ?>
				<?php 
				$the_query->the_post();
				$file_type = get_field('file_type');
				$resource_file_val = get_field('resource_'.$file_type);
				$resource_file = wp_get_attachment_url($resource_file_val);
				$download = basename($resource_file);
				?>
				<li class="product type-product post-15169 status-publish first instock product_cat-rubber has-post-thumbnail shipping-taxable purchasable product-type-simple">
					<a data-href="<?= $resource_file ?>" download="<?= $download ?>" onclick="forceDownload(this)" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
						<div class="product-thumb-wrapper">
							<?= get_resource_image($file_type, get_the_ID()) ?>
						</div>	
						<h2 class="woocommerce-loop-product__title">
							<?php the_title() ?>		
							<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve"><g><g><path d="M409.6,153.6h-85.333c-9.426,0-17.067,7.641-17.067,17.067s7.641,17.067,17.067,17.067H409.6c9.426,0,17.067,7.641,17.067,17.067v221.867c0,9.426-7.641,17.067-17.067,17.067H68.267c-9.426,0-17.067-7.641-17.067-17.067V204.8c0-9.426,7.641-17.067,17.067-17.067H153.6c9.426,0,17.067-7.641,17.067-17.067S163.026,153.6,153.6,153.6H68.267c-28.277,0-51.2,22.923-51.2,51.2v221.867c0,28.277,22.923,51.2,51.2,51.2H409.6c28.277,0,51.2-22.923,51.2-51.2V204.8C460.8,176.523,437.877,153.6,409.6,153.6z"/></g></g><g><g><path d="M335.947,243.934c-6.614-6.387-17.099-6.387-23.712,0L256,300.134V17.067C256,7.641,248.359,0,238.933,0s-17.067,7.641-17.067,17.067v283.068l-56.201-56.201c-6.78-6.548-17.584-6.361-24.132,0.419c-6.388,6.614-6.388,17.1,0,23.713l85.333,85.333c6.657,6.673,17.463,6.687,24.136,0.03c0.01-0.01,0.02-0.02,0.031-0.03l85.333-85.333C342.915,261.286,342.727,250.482,335.947,243.934z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
							<span class="download">
								DOWNLOAD
								<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 477.867 477.867" style="enable-background:new 0 0 477.867 477.867;" xml:space="preserve"><g><g><path d="M409.6,153.6h-85.333c-9.426,0-17.067,7.641-17.067,17.067s7.641,17.067,17.067,17.067H409.6c9.426,0,17.067,7.641,17.067,17.067v221.867c0,9.426-7.641,17.067-17.067,17.067H68.267c-9.426,0-17.067-7.641-17.067-17.067V204.8c0-9.426,7.641-17.067,17.067-17.067H153.6c9.426,0,17.067-7.641,17.067-17.067S163.026,153.6,153.6,153.6H68.267c-28.277,0-51.2,22.923-51.2,51.2v221.867c0,28.277,22.923,51.2,51.2,51.2H409.6c28.277,0,51.2-22.923,51.2-51.2V204.8C460.8,176.523,437.877,153.6,409.6,153.6z"/></g></g><g><g><path d="M335.947,243.934c-6.614-6.387-17.099-6.387-23.712,0L256,300.134V17.067C256,7.641,248.359,0,238.933,0s-17.067,7.641-17.067,17.067v283.068l-56.201-56.201c-6.78-6.548-17.584-6.361-24.132,0.419c-6.388,6.614-6.388,17.1,0,23.713l85.333,85.333c6.657,6.673,17.463,6.687,24.136,0.03c0.01-0.01,0.02-0.02,0.031-0.03l85.333-85.333C342.915,261.286,342.727,250.482,335.947,243.934z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
							</span>
						</h2>
					</a>
					<p>
						<?php the_content() ?>

					</p>
				</li>
			<?php } ?>
		<?php } else { ?>
			<li class="no-resource">
				<h2>No resources found</h2>
			</li>
		<?php } ?>

	</ul>

	<?php

	die();
}
