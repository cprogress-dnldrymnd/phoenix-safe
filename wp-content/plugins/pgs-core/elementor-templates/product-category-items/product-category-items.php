<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$style                 = isset( $settings['style'] ) ? $settings['style'] : '';
$order_by              = isset( $settings['order_by'] ) ? $settings['order_by'] : '';
$list_order            = isset( $settings['list_order'] ) ? $settings['list_order'] : '';
$empty_categories      = isset( $settings['empty_categories'] ) ? $settings['empty_categories'] : '';
$product_categories    = isset( $settings['product_categories'] ) ? $settings['product_categories'] : '';
$list_style            = isset( $settings['list_style'] ) ? $settings['list_style'] : '';
$horizontal_align      = isset( $settings['horizontal_align'] ) ? $settings['horizontal_align'] : 'hleft';
$vertical_align        = isset( $settings['vertical_align'] ) ? $settings['vertical_align'] : '';
$background_overlay    = isset( $settings['background_overlay'] ) ? $settings['background_overlay'] : '';
$hover_effect          = isset( $settings['hover_effect'] ) ? $settings['hover_effect'] : '';
$cat_img_style         = isset( $settings['cat_img_style'] ) ? $settings['cat_img_style'] : '';
$title_counter_display = isset( $settings['title_counter_display'] ) ? $settings['title_counter_display'] : '';

$product_cat_carousel_args = array(
	'taxonomy'     => 'product_cat',
	'show_count'   => 0,
	'pad_counts'   => 0,
	'hierarchical' => 0,
	'title_li'     => '',
	'hide_empty'   => ( 'yes' !== $empty_categories ) ? 1 : 0,
	'include'      => $product_categories,
	'exclude'      => get_option( 'default_product_cat' ), // Exclude uncategorised(default) category.
);

if ( $order_by ) {
	$product_cat_carousel_args['orderby'] = $order_by;
}

if ( $list_order ) {
	$product_cat_carousel_args['order'] = $list_order;
}

$product_cat_list = get_terms( $product_cat_carousel_args );
if ( ! $product_cat_list || is_wp_error( $product_cat_list ) ) {
	return;
}

$this->add_render_attribute(
	array(
		'pgscore_product_category_items' => array(
			'class' => array(
				'product-category-items',
				'product-category-' . $style,
				'product-category-' . $list_style,
				'product-category-' . $horizontal_align,
			),
		),
	)
);

if ( 'style-1' === $style || 'style-3' === $style ) {
	$this->add_render_attribute( 'pgscore_product_category_items', 'class', 'product-category-' . $vertical_align );
}

// background overlay settings.
if ( 'custom' !== $background_overlay ) {
	$this->add_render_attribute( 'pgscore_product_category_items', 'class', 'category-style-' . $background_overlay );
}

// category title hover setting.
if ( $hover_effect ) {
	$this->add_render_attribute( 'pgscore_product_category_items', 'class', 'category-hover-' . $hover_effect );
}

// Style 2 options.
if ( $cat_img_style ) {
	$this->add_render_attribute( 'pgscore_product_category_items', 'class', 'category-img-' . $cat_img_style );
}
$this->add_render_attribute( 'pgscore_product_category_items', 'class', $title_counter_display );

$settings['product_cat_list'] = $product_cat_list;
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_product_category_items' ); ?>>
		<?php $this->get_templates( "{$this->widget_slug}/style/" . $list_style, null, array( 'settings' => $settings ) ); ?>
	</div>
</div>
