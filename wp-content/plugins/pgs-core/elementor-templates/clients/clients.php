<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$style         = isset( $settings['style'] ) ? $settings['style'] : '';
$grid_elements = isset( $settings['grid_elements'] ) ? $settings['grid_elements'] : '';
$img_size      = isset( $settings['img_size'] ) ? $settings['img_size'] : '';

// Check for thumbnail size.
if ( ! $img_size ) {
	$img_size = 'full';
}

global $_wp_additional_image_sizes;

$thumb_size = '';
if ( is_string( $img_size ) && ( ( isset( $_wp_additional_image_sizes[ $img_size ] ) && $_wp_additional_image_sizes[ $img_size ] && is_array( $_wp_additional_image_sizes[ $img_size ] ) ) || in_array( $img_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) ) ) {
	$thumb_size = $img_size;
} elseif ( strpos( $img_size, 'x' ) !== false ) {
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
	return;
}

$this->add_render_attribute(
	array(
		'pgscore_clients' => array(
			'class' => array(
				'pgscore_clients',
				'pgscore_clients-list-type-' . $style,
			),
		),
	)
);

if ( 'grid' === $style ) {
	$this->add_render_attribute( 'pgscore_clients', 'class', 'pgscore_clients-grid-column-' . $grid_elements );
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_clients' ); ?>>
		<?php $this->get_templates( "{$this->widget_slug}/style/{$style}", null, array( 'settings' => $settings ) ); ?>
	</div>
</div>
