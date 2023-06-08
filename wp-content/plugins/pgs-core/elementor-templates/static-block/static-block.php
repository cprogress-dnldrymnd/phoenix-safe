<?php
$html_block_id = isset( $settings['html_block_id'] ) ? $settings['html_block_id'] : '';
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php
	if ( did_action( 'elementor/loaded' ) ) {
		$template = new \Elementor\Frontend;
		if ( \Elementor\Plugin::$instance->documents->get( $html_block_id )->is_built_with_elementor() ) {
			echo $template->get_builder_content_for_display( $html_block_id );
		}
	}
	?>
</div>
