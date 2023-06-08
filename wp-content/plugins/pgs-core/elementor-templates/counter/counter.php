<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$counter_style = isset( $settings['counter_style'] ) ? $settings['counter_style'] : '';
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php $this->get_templates( "{$this->widget_slug}/style/{$counter_style}", null, array( 'settings' => $settings ) ); ?>
</div>
