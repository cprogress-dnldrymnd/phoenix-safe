<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$is_icon                  = false;
$icon                     = isset( $settings['icon'] ) ? $settings['icon'] : '';
$title                    = isset( $settings['title'] ) ? $settings['title'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$content_alignment        = isset( $settings['content_alignment'] ) ? $settings['content_alignment'] : '';
$description              = isset( $settings['description'] ) ? $settings['description'] : '';
$layout                   = isset( $settings['layout'] ) ? $settings['layout'] : '';
$icon_source              = isset( $settings['icon_source'] ) ? $settings['icon_source'] : '';
$icon_style               = isset( $settings['icon_style'] ) ? $settings['icon_style'] : '';
$icon_size                = isset( $settings['icon_size'] ) ? $settings['icon_size'] : '';
$icon_shape               = isset( $settings['icon_shape'] ) ? $settings['icon_shape'] : '';
$icon_enable_outer_border = isset( $settings['icon_enable_outer_border'] ) ? $settings['icon_enable_outer_border'] : '';
$icon_position            = isset( $settings['icon_position'] ) ? $settings['icon_position'] : '';
$icon_image               = isset( $settings['icon_image'] ) ? $settings['icon_image'] : '';
$image_link               = isset( $settings['image_link'] ) ? $settings['image_link'] : '';
$style_2_step_position    = isset( $settings['style_2_step_position'] ) ? $settings['style_2_step_position'] : '';

// Return shortcode if no required content found to display the shortcode perfectly.
if ( ! $title && ! $description ) {
	return;
}

if ( 'font' === $icon_source && $icon ) {
	$is_icon = true;
} elseif ( 'image' === $icon_source && isset( $icon_image['id'] ) && $icon_image['id'] ) {
	$is_icon = true;
} elseif ( 'link' === $icon_source && isset( $image_link['url'] ) && $image_link['url'] ) {
	$is_icon = true;
}

$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box pgscore_info_box-layout-' . $layout );
if ( in_array( $layout, array( 'style-4', 'style-5' ), true ) ) {
	$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-content_alignment-left' );
} else {
	$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-content_alignment-' . $content_alignment );
}

if ( in_array( $layout, array( 'style-1', 'style-2', 'style-3' ), true ) ) {
	if ( $is_icon ) {
		$this->add_render_attribute(
			array(
				'pgscore_info_box' => array(
					'class' => array(
						'pgscore_info_box-with-icon',
						'pgscore_info_box-icon-source-' . $icon_source,
						'pgscore_info_box-icon-style-' . $icon_style,
						'pgscore_info_box-icon-size-' . $icon_size,
					),
				),
			)
		);
		if ( 'default' !== $icon_style ) {
			$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-icon-shape-' . $icon_shape );
			if ( 'true' === $icon_enable_outer_border ) {
				$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-outer-border' );
			}
		}
	} else {
		$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-without-icon' );
	}
}

if ( 'style-2' === $layout ) {
	if ( $icon_position ) {
		$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-icon_position-' . $icon_position );
	}
	if ( $style_2_step_position ) {
		$this->add_render_attribute( 'pgscore_info_box', 'class', 'info_box-step_position-' . $style_2_step_position );
	}
}

if ( 'link' === $icon_source ) {
	$this->add_render_attribute( 'pgscore_info_box', 'class', 'pgscore_info_box-icon-source-image' );
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_info_box' ); ?>>
		<?php $this->get_templates( "{$this->widget_slug}/layout/" . $layout, null, array( 'settings' => $settings ) ); ?>
	</div>
</div>
