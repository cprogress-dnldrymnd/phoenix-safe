<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$link_attr           = '';
$bg_image_url        = '';
$bg_image            = array();
$cbtitle             = isset( $settings['title'] ) ? $settings['title'] : '';
$subtitle            = isset( $settings['subtitle'] ) ? $settings['subtitle'] : '';
$image_source        = isset( $settings['image_source'] ) ? $settings['image_source'] : '';
$categories          = isset( $settings['categories'] ) ? $settings['categories'] : '';
$category_box_bg     = isset( $settings['category_box_bg'] ) ? $settings['category_box_bg'] : '';
$category_img_link   = isset( $settings['category_img_link'] ) ? $settings['category_img_link'] : '';
$enable_archive_link = isset( $settings['enable_archive_link'] ) ? $settings['enable_archive_link'] : '';
$archive_link        = isset( $settings['archive_link'] ) ? $settings['archive_link'] : '';

$categorybox_args = array(
	'taxonomy'     => 'product_cat',
	'orderby'      => 'name',
	'show_count'   => 0,
	'pad_counts'   => 0,
	'hierarchical' => 0,
	'title_li'     => '',
	'hide_empty'   => 0,
	'include'      => $categories,
);

$categorybox_categories = get_terms( $categorybox_args );

if ( empty( $categorybox_categories ) || is_wp_error( $categorybox_categories ) ) {
	return;
}

// Background Image.
if ( 'image' === $image_source && isset( $settings['category_box_bg']['id'] ) && $settings['category_box_bg']['id'] ) {
	$bg_image = wp_get_attachment_image_src( $settings['category_box_bg']['id'], 'full' );
} elseif ( 'link' === $image_source ) {
	$bg_image = array( $category_img_link );
}

if ( isset( $bg_image[0] ) && $bg_image[0] ) {
	$bg_image_url = $bg_image[0];
	$this->add_render_attribute( 'pgscore_category_box_styles', 'style', 'background-image:url(' . $bg_image_url . ');' );
}

// All Link.
if ( $enable_archive_link && isset( $settings['archive_link']['url'] ) && $settings['archive_link']['url'] ) {
	$target    = ( isset( $settings['archive_link']['is_external'] ) && $settings['archive_link']['is_external'] ) ? ' target="_blank"' : '';
	$nofollow  = ( isset( $settings['archive_link']['nofollow'] ) && $settings['archive_link']['nofollow'] ) ? ' rel="nofollow"' : '';
	$link_attr = 'href="' . $settings['archive_link']['url'] . '"' . $target . $nofollow;
}
$this->add_render_attribute( 'pgscore_category_box_styles', 'class', 'category-box' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_category_box_styles' ); ?>>
		<?php
		if ( $cbtitle ) {
			?>
			<h2><?php echo esc_html( $cbtitle ); ?></h2>
			<?php
		}
		if ( $subtitle ) {
			?>
			<span class="subhead"><?php echo esc_html( $subtitle ); ?></span>
			<?php
		}
		?>
		<div class="category-box-link">
			<ul>
				<?php
				foreach ( $categorybox_categories as $cbox_category ) {
					?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $cbox_category ) ); ?>">
							<i class="fa fa-angle-right" aria-hidden="true"></i><?php echo esc_html( $cbox_category->name ); ?>
						</a>
					</li>
					<?php
				}
				if ( $link_attr ) {
					?>
					<li class="view-all">
						<?php echo wp_kses( '<a ' . $link_attr . '>' . esc_html__( 'View All', 'pgs-core' ) . '</a>', pgscore_allowed_html( 'a' ) ); ?>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>
