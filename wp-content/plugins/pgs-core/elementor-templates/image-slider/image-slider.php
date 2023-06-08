<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
global $_wp_additional_image_sizes;

$image_slider_class = array();
$style              = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$custom_img_size    = isset( $settings['custom_img_size'] ) ? $settings['custom_img_size'] : '';
$img_size           = isset( $settings['img_size'] ) ? $settings['img_size'] : '';
$slides_data        = isset( $settings['slides'] ) ? $settings['slides'] : '';
$thumbnail_size     = isset( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : '';
$list_style         = isset( $settings['list_style'] ) ? $settings['list_style'] : 'slider';

if ( ! is_array( $slides_data ) || ! $slides_data || ( ( 1 === count( $slides_data ) ) && ! $slides_data[0] ) ) {
	return;
}

if ( 'custom' === $thumbnail_size ) {
	$img_size = $custom_img_size;
}

if ( ! $img_size ) {
	$img_size = 'ciyashop-latest-post-thumbnail';
}

$thumb_size = '';
if (
	is_string( $img_size ) && (
		( isset( $_wp_additional_image_sizes[ $img_size ] ) && $_wp_additional_image_sizes[ $img_size ] && is_array( $_wp_additional_image_sizes[ $img_size ] ) )
		|| in_array( $img_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true )
	)
) {
	$thumb_size = $img_size;
} elseif ( false !== strpos( $img_size, 'x' ) ) {
	$img_size = explode( 'x', $img_size );
	$img_size = array_filter(
		$img_size,
		function( $value ) {
			return '' !== $value;
		}
	);

	if ( 2 === count( $img_size ) && is_numeric( $img_size[0] ) && is_numeric( $img_size[1] ) ) {
		$thumb_size = $img_size;
	}
}

if ( ! $thumb_size ) {
	$thumb_size = 'ciyashop-latest-post-thumbnail';
}

foreach ( $slides_data as $slide_tk => $slide_td ) {
	if ( ! isset( $slide_td['image']['id'] ) || ( isset( $slide_td['image']['id'] ) && ! $slide_td['image']['id'] ) ) {
		unset( $slides_data[ $slide_tk ] );
	} else {
		$image_thumb = wp_get_attachment_image_src( $slide_td['image']['id'], $thumb_size, false );
		$image_full  = wp_get_attachment_image_src( $slide_td['image']['id'], 'full', false );

		if ( $image_thumb && ! empty( $image_thumb[0] ) ) {
			$slides_data[ $slide_tk ]['image_thumbnail']        = $image_thumb[0];
			$slides_data[ $slide_tk ]['image_thumbnail_width']  = $image_thumb[1];
			$slides_data[ $slide_tk ]['image_thumbnail_height'] = $image_thumb[2];
			$slides_data[ $slide_tk ]['image_url']              = $image_full[0];
			$slides_data[ $slide_tk ]['image_url_width']        = $image_full[1];
			$slides_data[ $slide_tk ]['image_url_height']       = $image_full[2];
		} else {
			unset( $slides_data[ $slide_tk ] );
		}
	}
}

$settings['slides_data'] = $slides_data;
$this->add_render_attribute(
	array(
		'pgscore_image_slider' => array(
			'class' => array(
				'image-slider-items',
				'image-slider-' . $style,
				'image-slider-' . $list_style,
			),
		),
	)
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_image_slider' ); ?>>
		<?php $this->get_templates( "{$this->widget_slug}/style/{$list_style}", null, array( 'settings' => $settings ) ); ?>
	</div>
</div>
