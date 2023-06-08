<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$link_attr                 = '';
$icon                      = isset( $settings['icon'] ) ? $settings['icon'] : '';
$icon_image                = isset( $settings['icon_image'] ) ? $settings['icon_image'] : '';
$callout_title             = isset( $settings['callout_title'] ) ? $settings['callout_title'] : '';
$callout_button_title      = isset( $settings['callout_button_title'] ) ? $settings['callout_button_title'] : '';
$callout_icon_source       = isset( $settings['callout_icon_source'] ) ? $settings['callout_icon_source'] : '';
$callout_description       = isset( $settings['callout_description'] ) ? $settings['callout_description'] : '';
$callout_icon_size         = isset( $settings['callout_icon_size'] ) ? $settings['callout_icon_size'] : '';
$callout_icon              = isset( $settings['callout_icon'] ) ? $settings['callout_icon'] : '';
$callout_button_type       = isset( $settings['callout_button_type'] ) ? $settings['callout_button_type'] : '';
$callout_title_element_tag = isset( $settings['callout_title_element_tag'] ) ? $settings['callout_title_element_tag'] : '';

if ( ! $callout_title && ! $callout_description ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
			<p><?php esc_html_e( 'If field data is not set, the widget content will not be rendered. Please enter field data to display widget content.', 'pgs-core' ); ?></p>
		</div>
		<?php
	}
	return;
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div class="callout">
		<?php
		if ( $callout_icon ) {
			$this->add_render_attribute(
				array(
					'pgscore_callout_icon_class' => array(
						'class' => array(
							'callout-icon',
							'callout-icon-size-' . $callout_icon_size,
						),
					),
				)
			);
			?>
			<div <?php $this->print_render_attribute_string( 'pgscore_callout_icon_class' ); ?>>
				<?php
				if ( 'font' === $callout_icon_source ) {
					\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
				} elseif ( 'image' === $callout_icon_source && $icon_image ) {
					if ( isset( $icon_image['id'] ) && $icon_image['id'] ) {
						$icon_image_data = wp_get_attachment_image_src( $icon_image['id'], 'pgscore-thumbnail-80' );
						echo '<img src="' . esc_url( $icon_image_data[0] ) . '">';
					}
				}
				?>
			</div>
			<?php
		}
		?>
		<div class="callout-info">
			<div class="callout-content">
				<<?php echo esc_html( $callout_title_element_tag ); ?> class="callout-title">
					<?php echo esc_html( $callout_title ); ?>
				</<?php echo esc_html( $callout_title_element_tag ); ?>>
				<p><?php echo esc_html( $callout_description ); ?></p>
			</div>
			<?php
			if ( $callout_button_title ) {
				$this->add_render_attribute( 'pgscore_callout_button_class', 'class', 'callout-btn' );
				if ( 'border' === $callout_button_type ) {
					$this->add_render_attribute( 'pgscore_callout_button_class', 'class', 'pgscore_button_border' );
				} elseif ( 'simple' === $callout_button_type ) {
					$this->add_render_attribute( 'pgscore_callout_button_class', 'class', 'pgscore_button_simple' );
				} else {
					$this->add_render_attribute( 'pgscore_callout_button_class', 'class', 'pgscore_button_default' );
				}

				$this->add_link_attributes( 'pgs_callout_link', $settings['callout_button_link'] );
				if ( filter_var( $settings['callout_button_link']['is_external'], FILTER_VALIDATE_BOOLEAN ) ) {
					$this->add_render_attribute( 'pgs_callout_link', 'rel', 'noreferrer' );
					$this->add_render_attribute( 'pgs_callout_link', 'rel', 'noopener' );
				}
				if ( ! isset( $settings['callout_button_link']['url'] ) || empty( $settings['callout_button_link']['url'] ) ) {
					$this->add_render_attribute( 'pgs_callout_link', 'href', '#' );
				}
				$this->add_render_attribute( 'pgs_callout_link', 'class', 'inline_hover' );
				?>
				<div <?php $this->print_render_attribute_string( 'pgscore_callout_button_class' ); ?>>
					<a <?php $this->print_render_attribute_string( 'pgs_callout_link' ); ?>>
						<?php echo esc_html( $callout_button_title ); ?>
					</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
