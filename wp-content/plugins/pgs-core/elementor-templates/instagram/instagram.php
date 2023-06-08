<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$item_count = isset( $settings['item_count']['size'] ) ? (int) $settings['item_count']['size'] : '';
$list_type  = isset( $settings['list_type'] ) ? $settings['list_type'] : '';

$images = array();
if ( function_exists( 'pgscore_get_instagram_image' ) && $item_count ) {
	$images = pgscore_get_instagram_image( $item_count );
}

if ( ! $images ) {
	return;
}

$settings['images'] = $images;
$this->add_render_attribute( 'pgscore_instagram', 'class', 'insta_v3_wrapper insta_v3_list_type--' . $list_type );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_instagram' ); ?>>
		<div class="insta_v3_content">
			<?php $this->get_templates( "{$this->widget_slug}/list-type/" . $list_type, null, array( 'settings' => $settings ) ); ?>
		</div>
	</div>
</div>
