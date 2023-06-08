<?php
$image_gallery                    = isset( $settings['image_gallery'] ) ? $settings['image_gallery'] : '';
$show_auto_play_smart_image_view  = isset( $settings['show_auto_play_smart_image_view'] ) ? $settings['show_auto_play_smart_image_view'] : '';
$show_prev_next_buttons           = isset( $settings['show_prev_next_buttons'] ) ? $settings['show_prev_next_buttons'] : '';

if ( ! $image_gallery ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
			<p><?php esc_html_e( 'If image is not set, the widget content will not be rendered. Please select an images to display widget content.', 'pgs-core' ); ?></p>
		</div>
		<?php
	}
	return;
}

$this->add_render_attribute( 'widget_wrapper', 'class', 'pgscore_smart_image_view_wrapper' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div class="cloudimage-360" 
		data-image-list='[
			<?php 
			$i = 0; 
			foreach ( $image_gallery as $image_gallery_url ) {
				if ( isset( $image_gallery_url['url'] ) && $image_gallery_url['url'] ) {
					if( $i > 0 ) { echo ','; }
					?> "<?php echo esc_url( $image_gallery_url['url'] ); ?>"
					<?php
					$i++;
				}
			}
			?>
			]' data-bottom-circle-offset="5" data-keys <?php if ( 'true' === $show_auto_play_smart_image_view ) { echo "data-autoplay"; } ?> data-ratio="0.365"> 
			<?php
			if ( 'true' === $show_prev_next_buttons ) {
				?>
				<button class="cloudimage-360-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
				<button class="cloudimage-360-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
				<?php 
			}
			?>
	</div>
</div>