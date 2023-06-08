<?php
$section_title_style = isset( $settings['section_title_style'] ) ? $settings['section_title_style'] : '';
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
<?php $this->get_templates( "{$this->widget_slug}/style/{$section_title_style}", null, array( 'settings' => $settings ) ); ?>
</div>


