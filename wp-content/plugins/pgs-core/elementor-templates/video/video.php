<?php
$icon_url          = '';
$button_style      = isset( $settings['button_style'] ) ? $settings['button_style'] : '';
$image_source      = isset( $settings['image_source'] ) ? $settings['image_source'] : '';
$video_img_link    = isset( $settings['video_img_link'] ) ? $settings['video_img_link'] : '';
$video_img         = isset( $settings['video_img'] ) ? $settings['video_img'] : '';
$icon_style        = isset( $settings['icon_style'] ) ? $settings['icon_style'] : '';
$btn_text          = isset( $settings['btn_text'] ) ? $settings['btn_text'] : '';
$button_position   = isset( $settings['button_position'] ) ? $settings['button_position'] : '';
$video_link        = isset( $settings['video_link'] ) ? $settings['video_link'] : '';
$enable_opacity    = isset( $settings['enable_opacity'] ) ? $settings['enable_opacity'] : '';
$button_style_type = isset( $settings['button_style_type'] ) ? $settings['button_style_type'] : '';
$title_element     = isset( $settings['title_element'] ) ? $settings['title_element'] : '';
$title             = isset( $settings['title'] ) ? $settings['title'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$show_content      = isset( $settings['show_content'] ) ? $settings['show_content'] : '';
$content           = isset( $settings['content'] ) ? $settings['content'] : '';

if ( ! $video_img_link && ( ! isset( $video_img['url'] ) || ( isset( $video_img['url'] ) && ! $video_img['url'] ) ) ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
			<p><?php esc_html_e( 'If "Video Image" is not set, the widget content will not be rendered. Please select an image to display widget content.', 'pgs-core' ); ?></p>
		</div>
		<?php
	}
	return;
}


if ( $icon_style ) {
	$icon_url = PGSCORE_URL . 'images/shortcodes/video/video-popup-' . str_replace( '-', '', $icon_style ) . '.png';
}

$this->add_render_attribute( 'pgscore_video', 'class', 'pgs-video-info' );
if ( 'icon' === $button_style ) {
	$this->add_render_attribute( 'pgscore_video', 'class', 'pgs-video-icon' );
} else {
	$this->add_render_attribute( 'pgscore_video', 'class', 'pgs-video-btn' );
}

if ( 'center' === $button_position ) {
	$this->add_render_attribute( 'pgscore_video', 'class', 'pgs-video-icon-position-center' );
} else {
	$this->add_render_attribute( 'pgscore_video', 'class', 'pgs-video-icon-position-left_bottom' );
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_video' ); ?>>
		<div class="pgs-video">
			<?php
			if ( 'true' === $enable_opacity ) {
				?>
				<div class="pgs-video-opacity"></div>
				<?php
			}
			if ( 'link' === $image_source ) {
				if ( isset( $video_img_link['url'] ) && $video_img_link['url'] ) {
					?>
					<img class="img-responsive" src="<?php echo esc_url( $video_img_link['url'] ); ?>" />
					<?php
				}
			} else {
				if ( isset( $video_img['id'] ) && $video_img['id'] ) {
					echo wp_get_attachment_image( $video_img['id'], 'full', '', array( 'class' => 'img-responsive' ) );
				}
			}

			?>
			<div class="pgs-video-content video_popup-gallery">
				<?php
				if ( isset( $video_link['url'] ) && $video_link['url'] ) {
					if ( $icon_url ) {
						?>
						<a class="popup-youtube" href="<?php echo esc_url( $video_link['url'] ); ?>" >
							<img class="img-responsive" src="<?php echo esc_url( $icon_url ); ?>" alt="Video Img">
						</a>
						<?php
					}

					if ( $btn_text ) {
						?>
						<a class="popup-youtube btn-style-type-<?php echo esc_attr( $button_style_type ); ?> video-popup-btn" href="<?php echo esc_url( $video_link['url'] ); ?>" >
							<?php echo $btn_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
						<?php
					}
				}

				if ( $title ) {
					?>
					<div class="pgs-title-des">
						<?php
						if ( 'true' === $show_content ) {
							?>
							<<?php echo esc_html( $title_element ); ?> class="pgs-video-title">
								<?php echo esc_html( $title ); ?>
							</<?php echo esc_html( $title_element ); ?>>
							<?php
						}

						if ( $content ) {
							?>
							<p><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
